#!/usr/bin/env python3
"""
Build Jekyll publication data from legacy PHP/HTML pages (deprecated).

This repository historically stored publications in `legacy/new-pages/*.php`
(moved from `new-pages/`). The Jekyll site renders publications from a single
YAML data source: `_data/publications.yml`, which should be edited directly.

This script is kept for reference and is intentionally gated behind `--force`
to avoid accidentally overwriting hand-edited publication data.

This script:
  1) Parses publication lists from the legacy pages using BeautifulSoup.
  2) Extracts structured metadata (authors/title/venue/year/DOI/arXiv/PDF).
  3) Deduplicates entries across pages and assigns stable IDs.
  4) Adds topical tags (time-stepping, data-assimilation, amr) based on
     dedicated legacy topic pages.
  5) Marks a small set of "featured" papers based on the legacy homepage.
  6) Writes the merged dataset to `_data/publications.yml`.

Run from the repo root:
  `python3 legacy/scripts/build_publications_data.py --force`

The output YAML is consumed by Jekyll includes in `_includes/`.
"""

from __future__ import annotations

import argparse
import re
import sys
from dataclasses import dataclass, field
from pathlib import Path
from typing import Any

import yaml
from bs4 import BeautifulSoup

# Match a 4-digit year anywhere in the text.
YEAR_RE = re.compile(r"\b(19|20)\d{2}\b")
# DOI patterns show up either as a DOI URL or as plain text (e.g. "DOI: 10....").
DOI_RE = re.compile(r"\b10\.\d{4,9}/[-._;()/:A-Z0-9]+\b", re.IGNORECASE)
# Match arXiv links that include an identifier with an optional version suffix.
ARXIV_RE = re.compile(r"arxiv\.org/(abs|pdf)/([0-9]{4}\.[0-9]{4,5}(?:v\d+)?)", re.IGNORECASE)
# Strip embedded PHP blocks so legacy pages become parseable HTML.
PHP_BLOCK_RE = re.compile(r"<\?php.*?\?>", re.DOTALL)

# Legacy pages use a mix of "Vol." and "Volume", and "Pages" / "pp".
VOLUME_RE = re.compile(r"\b(?:vol\.?|volume)\s*([0-9]+)\b", re.IGNORECASE)
ISSUE_RE = re.compile(r"\b(?:vol\.?|volume)\s*[0-9]+\s*\(\s*([0-9]+)\s*\)", re.IGNORECASE)
PAGES_RE = re.compile(r"\b(?:pages|pp\.?)\s*([^,;.]+)", re.IGNORECASE)


def _collapse_ws(text: str) -> str:
    """Normalize whitespace by collapsing runs to single spaces."""
    return " ".join(text.split())


def _slugify(text: str) -> str:
    """Create a stable, URL-safe-ish slug used as a publication record ID."""
    slug = text.lower()
    slug = slug.replace("’", "'")
    slug = re.sub(r"[^a-z0-9]+", "-", slug)
    slug = re.sub(r"-{2,}", "-", slug).strip("-")
    return slug or "untitled"


def _normalize_title_key(title: str) -> str:
    """Normalize titles for deduplication (case/punctuation/whitespace insensitive)."""
    key = title.lower()
    key = key.replace("’", "'")
    key = re.sub(r"[^a-z0-9]+", " ", key)
    return _collapse_ws(key)


def _extract_doi_from_url(url: str) -> str | None:
    """Extract the DOI from a DOI resolver URL (doi.org / dx.doi.org), if present."""
    lowered = url.lower()
    if "doi.org/" not in lowered and "dx.doi.org/" not in lowered:
        return None

    if "doi.org/" in lowered:
        doi = url.split("doi.org/", 1)[1]
    else:
        doi = url.split("dx.doi.org/", 1)[1]

    doi = doi.lstrip("/").split("?", 1)[0].split("#", 1)[0]
    doi = doi.strip().rstrip(").,;")
    return doi or None


def _extract_arxiv_id_from_url(url: str) -> str | None:
    """Extract an arXiv identifier (e.g. 2310.18897v2) from an arxiv.org URL."""
    match = ARXIV_RE.search(url)
    if not match:
        return None
    arxiv_id = match.group(2)
    return arxiv_id or None


def _read_html(path: Path) -> str:
    """Read a legacy HTML/PHP page and remove PHP include blocks."""
    text = path.read_text(encoding="utf-8", errors="replace")
    return PHP_BLOCK_RE.sub("", text)


@dataclass
class ParsedRef:
    """Structured metadata extracted from a single legacy `<li>` entry."""

    title: str | None
    authors: str | None
    venue: str | None
    volume: str | None
    number: str | None
    pages: str | None
    year: int | None
    doi: str | None
    arxiv: str | None
    pdf: str | None


def _parse_li(li) -> ParsedRef:
    """
    Parse a legacy publication `<li>` node into a `ParsedRef`.

    The legacy pages include icons (bib/doi/pdf) and inconsistent markup. This
    parser uses simple heuristics:
      - Title is usually in `<strong>` (fallback to `<b>`).
      - Venue is usually in `<em>` (first non-empty wins).
      - Year is the last 4-digit year in the text.
      - DOI/arXiv/PDF are extracted from links when possible, with DOI also
        falling back to a text regex match.
      - Authors are inferred by taking the text before the title substring.
    """
    # Remove icon images so they don't pollute extracted text.
    for img in li.find_all("img"):
        img.decompose()

    hrefs: list[str] = []
    # Collect all hrefs; we will later scan them for DOI/arXiv/PDF links.
    for a in li.find_all("a"):
        href = (a.get("href") or "").strip()
        if not href:
            continue
        hrefs.append(href)

    title: str | None = None
    strong = li.find("strong")
    if strong:
        title = _collapse_ws(strong.get_text(" ", strip=True))
    else:
        # Some legacy entries wrap the title in `<b>` instead of `<strong>`.
        b_tag = li.find("b")
        if b_tag:
            title = _collapse_ws(b_tag.get_text(" ", strip=True))

    if title:
        title = title.strip().strip("“”\"' ").rstrip(".")

    text = _collapse_ws(li.get_text(" ", strip=True))
    # If multiple years appear (e.g. citations, preprints), take the last one.
    years: list[int] = []
    for match in YEAR_RE.finditer(text):
        # Ignore year-like prefixes inside arXiv IDs (e.g. 2007.14476, 1912.07696)
        # and DOIs such as "...j.jcp.2007.02.024".
        end = match.end()
        if end + 1 < len(text) and text[end] == "." and text[end + 1].isdigit():
            continue
        years.append(int(match.group(0)))
    year = years[-1] if years else None

    doi = None
    # Prefer explicit DOI links over regex matching in free text.
    for href in hrefs:
        doi = _extract_doi_from_url(href)
        if doi:
            break
    if not doi:
        match = DOI_RE.search(text)
        doi = match.group(0).rstrip(").,;") if match else None

    arxiv = None
    for href in hrefs:
        arxiv = _extract_arxiv_id_from_url(href)
        if arxiv:
            break

    pdf = None
    for href in hrefs:
        # Only keep direct PDF links; other links are handled via DOI/arXiv.
        if href.startswith(("http://", "https://")) and href.lower().endswith(".pdf"):
            pdf = href
            break

    venue = None
    for em in li.find_all("em"):
        # Some entries contain multiple <em> tags; keep the first meaningful one.
        candidate = _collapse_ws(em.get_text(" ", strip=True))
        if candidate:
            venue = candidate
            break

    volume = None
    volume_match = VOLUME_RE.search(text)
    if volume_match:
        volume = volume_match.group(1)

    number = None
    number_match = ISSUE_RE.search(text)
    if number_match:
        number = number_match.group(1)

    pages = None
    pages_match = PAGES_RE.search(text)
    if pages_match:
        pages = pages_match.group(1).strip().rstrip(").,;")

    authors = None
    if title and title in text:
        # Assume "Authors ... Title ..." and keep the prefix as an author list.
        before = text.split(title, 1)[0]
        before = before.strip().rstrip("“”\"' ").rstrip(",").strip()
        if before:
            authors = before

    return ParsedRef(
        title=title or None,
        authors=authors or None,
        venue=venue or None,
        volume=volume or None,
        number=number or None,
        pages=pages or None,
        year=year,
        doi=doi,
        arxiv=arxiv,
        pdf=pdf,
    )


class PublicationIndex:
    """
    Merge publication records across multiple legacy sources.

    Multiple legacy pages can reference the same paper. We match existing records
    by, in order:
      1) DOI
      2) arXiv ID
      3) (normalized title, year)

    Records are assigned stable `id` strings used as YAML keys and can be tagged
    by research area.
    """

    def __init__(self) -> None:
        # Primary record store: record_id -> record dict written to YAML.
        self._records: dict[str, dict[str, Any]] = {}
        # Secondary indexes for deduplication across pages.
        self._doi_to_id: dict[str, str] = {}
        self._arxiv_to_id: dict[str, str] = {}
        self._title_year_to_id: dict[tuple[str, int], str] = {}
        # Prevent ID collisions when generating new record IDs.
        self._used_ids: set[str] = set()

    def _find_existing_id(self, parsed: ParsedRef) -> str | None:
        """Return an existing record ID if `parsed` matches an already-seen publication."""
        if parsed.doi:
            existing = self._doi_to_id.get(parsed.doi.lower())
            if existing:
                return existing
        if parsed.arxiv:
            existing = self._arxiv_to_id.get(parsed.arxiv.lower())
            if existing:
                return existing
        if parsed.title and parsed.year:
            key = (_normalize_title_key(parsed.title), parsed.year)
            existing = self._title_year_to_id.get(key)
            if existing:
                return existing
        return None

    def _allocate_id(self, parsed: ParsedRef) -> str:
        """Generate a stable-ish ID based on author/year/title, avoiding collisions."""
        year = parsed.year or 0
        first_author_last = "unknown"
        if parsed.authors:
            first_author = parsed.authors.split(",", 1)[0].strip()
            if first_author:
                parts = first_author.split()
                first_author_last = parts[-1] if parts else first_author

        title_words = (parsed.title or "publication").split()
        short_title = " ".join(title_words[:6])

        base = _slugify(f"{first_author_last}-{year}-{short_title}")
        candidate = base
        counter = 2
        while candidate in self._used_ids:
            candidate = f"{base}-{counter}"
            counter += 1
        self._used_ids.add(candidate)
        return candidate

    def upsert(self, parsed: ParsedRef, *, type_: str) -> str:
        """
        Insert or update a publication record from a `ParsedRef`.

        Existing records are updated conservatively via `setdefault` so that the
        first-seen value for a field is preserved unless it was missing.
        """
        existing_id = self._find_existing_id(parsed)
        if existing_id:
            record = self._records[existing_id]
        else:
            record_id = self._allocate_id(parsed)
            record = {"id": record_id}
            self._records[record_id] = record
            existing_id = record_id

        record["type"] = type_
        if parsed.title:
            record.setdefault("title", parsed.title)
        if parsed.authors:
            record.setdefault("authors", parsed.authors)
        if parsed.venue:
            record.setdefault("venue", parsed.venue)
        if parsed.volume:
            record.setdefault("volume", parsed.volume)
        if parsed.number:
            record.setdefault("number", parsed.number)
        if parsed.pages:
            record.setdefault("pages", parsed.pages)
        if parsed.year:
            record.setdefault("year", parsed.year)
        if parsed.doi:
            record.setdefault("doi", parsed.doi)
        if parsed.arxiv:
            record.setdefault("arxiv", parsed.arxiv)
        if parsed.pdf:
            record.setdefault("pdf", parsed.pdf)

        record.setdefault("tags", [])

        if parsed.doi:
            self._doi_to_id.setdefault(parsed.doi.lower(), existing_id)
        if parsed.arxiv:
            self._arxiv_to_id.setdefault(parsed.arxiv.lower(), existing_id)
        if parsed.title and parsed.year:
            self._title_year_to_id.setdefault(
                (_normalize_title_key(parsed.title), parsed.year), existing_id
            )

        return existing_id

    def merge_existing(self, existing_records: list[dict[str, Any]]) -> None:
        """
        Merge fields from an existing `_data/publications.yml` file.

        This lets the data file be edited by hand (e.g., extra tags) without
        losing those changes when regenerating from legacy sources.
        """
        by_id: dict[str, dict[str, Any]] = {}
        for item in existing_records:
            record_id = item.get("id")
            if isinstance(record_id, str) and record_id:
                by_id[record_id] = item

        for record_id, record in self._records.items():
            existing = by_id.get(record_id)
            if not existing:
                continue

            existing_tags = existing.get("tags")
            if isinstance(existing_tags, list):
                for tag in existing_tags:
                    if isinstance(tag, str) and tag:
                        self.add_tag(record_id, tag)

            if existing.get("featured") is True:
                self.set_flag(record_id, "featured", True)

            # Fill missing metadata from the existing file if we didn't extract it.
            for key in ("title", "authors", "venue", "volume", "number", "pages", "year", "doi", "arxiv", "pdf"):
                if key in record and record.get(key):
                    continue
                value = existing.get(key)
                if value is not None and value != [] and value != "":
                    record[key] = value

    def add_tag(self, record_id: str, tag: str) -> None:
        """Add a topic tag to a record (no-op if the record doesn't exist)."""
        record = self._records.get(record_id)
        if not record:
            return
        tags: list[str] = record.setdefault("tags", [])
        if tag not in tags:
            tags.append(tag)

    def set_flag(self, record_id: str, flag: str, value: Any = True) -> None:
        """Set an arbitrary boolean-ish flag on a record (e.g. featured=True)."""
        record = self._records.get(record_id)
        if not record:
            return
        record[flag] = value

    def to_sorted_list(self) -> list[dict[str, Any]]:
        """Return records as a list sorted for stable diffs and human readability."""
        type_order = {"journal": 0, "proceedings": 1, "report": 2}

        def sort_key(item: dict[str, Any]) -> tuple:
            year = item.get("year")
            year_sort = -(int(year) if isinstance(year, int) else 0)
            authors = item.get("authors") or ""
            title = item.get("title") or ""
            return (type_order.get(item.get("type"), 99), year_sort, authors.lower(), title.lower())

        def normalize(value: Any) -> Any:
            if value is None:
                return []
            if isinstance(value, str):
                return value.strip() or []
            return value

        normalized_records: list[dict[str, Any]] = []
        for record_id in sorted(self._records.keys(), key=lambda k: sort_key(self._records[k])):
            record = self._records[record_id]
            normalized_records.append(
                {
                    "id": record["id"],
                    "type": record.get("type", []),
                    "title": normalize(record.get("title")),
                    "authors": normalize(record.get("authors")),
                    "venue": normalize(record.get("venue")),
                    "volume": normalize(record.get("volume")),
                    "number": normalize(record.get("number")),
                    "pages": normalize(record.get("pages")),
                    "year": normalize(record.get("year")),
                    "doi": normalize(record.get("doi")),
                    "arxiv": normalize(record.get("arxiv")),
                    "pdf": normalize(record.get("pdf")),
                    "tags": record.get("tags", []),
                    "featured": record.get("featured", []),
                }
            )

        return normalized_records


def _find_ul_after_anchor(soup: BeautifulSoup, *, anchor_id: str | None = None, anchor_name: str | None = None):
    """
    Find the first `<ul>` that follows a named anchor.

    Legacy pages use a mix of `<hX id="...">` and `<a name="...">` anchors.
    """
    anchor = None
    if anchor_id:
        anchor = soup.find(id=anchor_id)
    if not anchor and anchor_name:
        anchor = soup.find("a", attrs={"name": anchor_name})
    if not anchor:
        return None
    return anchor.find_next("ul")


def _ingest_section(
    index: PublicationIndex,
    *,
    soup: BeautifulSoup,
    type_: str,
    anchor_id: str | None = None,
    anchor_name: str | None = None,
    tag: str | None = None,
):
    """Parse and ingest a publication `<ul>` section, optionally tagging entries."""
    ul = _find_ul_after_anchor(soup, anchor_id=anchor_id, anchor_name=anchor_name)
    if not ul:
        return

    for li in ul.find_all("li", recursive=False):
        parsed = _parse_li(li)
        # Skip empty list items that contain no useful metadata.
        if not parsed.title and not parsed.doi and not parsed.arxiv:
            continue
        record_id = index.upsert(parsed, type_=type_)
        if tag:
            index.add_tag(record_id, tag)


def _mark_featured_from_index_page(index: PublicationIndex, *, soup: BeautifulSoup) -> None:
    """Mark publications that appear in the legacy homepage "Recent papers" list."""
    header = soup.find(lambda t: t.name == "h4" and "Recent papers" in t.get_text(" ", strip=True))
    if not header:
        return
    ul = header.find_next("ul")
    if not ul:
        return
    for li in ul.find_all("li", recursive=False):
        parsed = _parse_li(li)
        record_id = index._find_existing_id(parsed)
        if record_id:
            index.set_flag(record_id, "featured", True)


def main() -> int:
    parser = argparse.ArgumentParser(
        description="(Legacy) Build _data/publications.yml from legacy/new-pages/*.php"
    )
    parser.add_argument("--repo-root", type=Path, default=Path(__file__).resolve().parents[2])
    parser.add_argument(
        "--force",
        action="store_true",
        help="Actually rewrite _data/publications.yml (deprecated; prefer editing YAML directly).",
    )
    args = parser.parse_args()

    if not args.force:
        print(
            "Refusing to run without --force: publications are maintained directly in _data/publications.yml.",
            file=sys.stderr,
        )
        return 2

    repo_root: Path = args.repo_root

    # Source-of-truth legacy page that contains the full publication lists.
    legacy_root = repo_root / "legacy" / "new-pages"
    research_path = legacy_root / "research.php"
    if not research_path.exists():
        raise SystemExit(f"Missing expected file: {research_path}")

    index = PublicationIndex()

    # Ingest the main legacy publication lists.
    research_soup = BeautifulSoup(_read_html(research_path), "html.parser")
    _ingest_section(index, soup=research_soup, type_="journal", anchor_id="Journals")
    _ingest_section(index, soup=research_soup, type_="proceedings", anchor_name="Proceedings")
    _ingest_section(index, soup=research_soup, type_="report", anchor_id="TechnicalReports")

    # Ingest topical pages to attach tags to records referenced there.
    topic_pages = [
        ("time-stepping", legacy_root / "TimeStepping.php"),
        ("data-assimilation", legacy_root / "DA.php"),
        ("amr", legacy_root / "AMR.php"),
    ]
    for tag, path in topic_pages:
        if not path.exists():
            continue
        soup = BeautifulSoup(_read_html(path), "html.parser")
        _ingest_section(index, soup=soup, type_="journal", anchor_id="Journals", tag=tag)
        _ingest_section(index, soup=soup, type_="journal", anchor_name="Journal", tag=tag)
        _ingest_section(index, soup=soup, type_="proceedings", anchor_name="Proceedings", tag=tag)
        _ingest_section(index, soup=soup, type_="report", anchor_id="TechnicalReports", tag=tag)

    # Mark featured publications based on the legacy homepage.
    index_php = legacy_root / "index.php"
    if index_php.exists():
        soup = BeautifulSoup(_read_html(index_php), "html.parser")
        _mark_featured_from_index_page(index, soup=soup)

    existing_path = repo_root / "_data" / "publications.yml"
    if existing_path.exists():
        existing_data = yaml.safe_load(existing_path.read_text(encoding="utf-8")) or []
        if isinstance(existing_data, list):
            index.merge_existing(existing_data)

    # Write the final YAML file used by the Jekyll site.
    output_path = repo_root / "_data" / "publications.yml"
    output_path.parent.mkdir(parents=True, exist_ok=True)

    with output_path.open("w", encoding="utf-8") as f:
        f.write("# Generated by legacy/scripts/build_publications_data.py (legacy)\n")
        f.write("# Source: legacy/new-pages/research.php (+ topic pages for tags)\n")
        yaml.safe_dump(index.to_sorted_list(), f, sort_keys=False, allow_unicode=True, width=100)

    print(f"Wrote {output_path.relative_to(repo_root)}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
