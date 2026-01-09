#!/usr/bin/env python3
from __future__ import annotations

import argparse
import re
from dataclasses import dataclass, field
from pathlib import Path
from typing import Any

import yaml
from bs4 import BeautifulSoup

YEAR_RE = re.compile(r"\b(19|20)\d{2}\b")
DOI_RE = re.compile(r"\b10\.\d{4,9}/[-._;()/:A-Z0-9]+\b", re.IGNORECASE)
ARXIV_RE = re.compile(r"arxiv\.org/(abs|pdf)/([0-9]{4}\.[0-9]{4,5}(?:v\d+)?)", re.IGNORECASE)
PHP_BLOCK_RE = re.compile(r"<\?php.*?\?>", re.DOTALL)


def _collapse_ws(text: str) -> str:
    return " ".join(text.split())


def _slugify(text: str) -> str:
    slug = text.lower()
    slug = slug.replace("’", "'")
    slug = re.sub(r"[^a-z0-9]+", "-", slug)
    slug = re.sub(r"-{2,}", "-", slug).strip("-")
    return slug or "untitled"


def _normalize_title_key(title: str) -> str:
    key = title.lower()
    key = key.replace("’", "'")
    key = re.sub(r"[^a-z0-9]+", " ", key)
    return _collapse_ws(key)


def _extract_doi_from_url(url: str) -> str | None:
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
    match = ARXIV_RE.search(url)
    if not match:
        return None
    arxiv_id = match.group(2)
    return arxiv_id or None


def _read_html(path: Path) -> str:
    text = path.read_text(encoding="utf-8", errors="replace")
    return PHP_BLOCK_RE.sub("", text)


@dataclass
class ParsedRef:
    title: str | None
    authors: str | None
    venue: str | None
    year: int | None
    doi: str | None
    arxiv: str | None
    pdf: str | None


def _parse_li(li) -> ParsedRef:
    for img in li.find_all("img"):
        img.decompose()

    hrefs: list[str] = []
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
        b_tag = li.find("b")
        if b_tag:
            title = _collapse_ws(b_tag.get_text(" ", strip=True))

    if title:
        title = title.strip().strip("“”\"' ").rstrip(".")

    text = _collapse_ws(li.get_text(" ", strip=True))
    years = [int(m.group(0)) for m in YEAR_RE.finditer(text)]
    year = years[-1] if years else None

    doi = None
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
        if href.startswith(("http://", "https://")) and href.lower().endswith(".pdf"):
            pdf = href
            break

    venue = None
    for em in li.find_all("em"):
        candidate = _collapse_ws(em.get_text(" ", strip=True))
        if candidate:
            venue = candidate
            break

    authors = None
    if title and title in text:
        before = text.split(title, 1)[0]
        before = before.strip().rstrip("“”\"' ").rstrip(",").strip()
        if before:
            authors = before

    return ParsedRef(
        title=title or None,
        authors=authors or None,
        venue=venue or None,
        year=year,
        doi=doi,
        arxiv=arxiv,
        pdf=pdf,
    )


class PublicationIndex:
    def __init__(self) -> None:
        self._records: dict[str, dict[str, Any]] = {}
        self._doi_to_id: dict[str, str] = {}
        self._arxiv_to_id: dict[str, str] = {}
        self._title_year_to_id: dict[tuple[str, int], str] = {}
        self._used_ids: set[str] = set()

    def _find_existing_id(self, parsed: ParsedRef) -> str | None:
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

    def add_tag(self, record_id: str, tag: str) -> None:
        record = self._records.get(record_id)
        if not record:
            return
        tags: list[str] = record.setdefault("tags", [])
        if tag not in tags:
            tags.append(tag)

    def set_flag(self, record_id: str, flag: str, value: Any = True) -> None:
        record = self._records.get(record_id)
        if not record:
            return
        record[flag] = value

    def to_sorted_list(self) -> list[dict[str, Any]]:
        type_order = {"journal": 0, "proceedings": 1, "report": 2}

        def sort_key(item: dict[str, Any]) -> tuple:
            year = item.get("year")
            year_sort = -(int(year) if isinstance(year, int) else 0)
            authors = item.get("authors") or ""
            title = item.get("title") or ""
            return (type_order.get(item.get("type"), 99), year_sort, authors.lower(), title.lower())

        return [self._records[k] for k in sorted(self._records.keys(), key=lambda k: sort_key(self._records[k]))]


def _find_ul_after_anchor(soup: BeautifulSoup, *, anchor_id: str | None = None, anchor_name: str | None = None):
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
    ul = _find_ul_after_anchor(soup, anchor_id=anchor_id, anchor_name=anchor_name)
    if not ul:
        return

    for li in ul.find_all("li", recursive=False):
        parsed = _parse_li(li)
        if not parsed.title and not parsed.doi and not parsed.arxiv:
            continue
        record_id = index.upsert(parsed, type_=type_)
        if tag:
            index.add_tag(record_id, tag)


def _mark_featured_from_index_page(index: PublicationIndex, *, soup: BeautifulSoup) -> None:
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
    parser = argparse.ArgumentParser(description="Build _data/publications.yml from legacy new-pages/*.php")
    parser.add_argument("--repo-root", type=Path, default=Path(__file__).resolve().parents[1])
    args = parser.parse_args()

    repo_root: Path = args.repo_root

    legacy_root = repo_root / "new-pages"
    research_path = legacy_root / "research.php"
    if not research_path.exists():
        raise SystemExit(f"Missing expected file: {research_path}")

    index = PublicationIndex()

    research_soup = BeautifulSoup(_read_html(research_path), "html.parser")
    _ingest_section(index, soup=research_soup, type_="journal", anchor_id="Journals")
    _ingest_section(index, soup=research_soup, type_="proceedings", anchor_name="Proceedings")
    _ingest_section(index, soup=research_soup, type_="report", anchor_id="TechnicalReports")

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

    index_php = legacy_root / "index.php"
    if index_php.exists():
        soup = BeautifulSoup(_read_html(index_php), "html.parser")
        _mark_featured_from_index_page(index, soup=soup)

    output_path = repo_root / "_data" / "publications.yml"
    output_path.parent.mkdir(parents=True, exist_ok=True)

    with output_path.open("w", encoding="utf-8") as f:
        f.write("# Generated by scripts/build_publications_data.py\n")
        f.write("# Source: new-pages/research.php (+ topic pages for tags)\n")
        yaml.safe_dump(index.to_sorted_list(), f, sort_keys=False, allow_unicode=True, width=100)

    print(f"Wrote {output_path.relative_to(repo_root)}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
