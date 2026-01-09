# Repository Guidelines

## Project Structure & Module Organization

- `_config.yml`: Jekyll/GitHub Pages configuration (navigation is `header_pages`).
- `index.md`: site landing page.
- `pages/`: primary content pages (`*.md` with YAML front matter).
- `_data/publications.yml`: publication metadata used across pages.
- `_includes/`: Liquid includes (publication rendering lives here).
- `assets/`: images and other static assets.
- `_sass/`: Sass overrides for the site theme.
- `scripts/`: maintenance scripts (not part of the built site).
- `new-pages/`: legacy PHP/HTML kept for reference (excluded from the built site).

## Build, Test, and Development Commands

Prereqs: Ruby + Bundler.

- `bundle install`: install gems pinned in `Gemfile.lock`.
- `bundle exec jekyll serve`: run locally with live rebuilds (default `http://localhost:4000`).
- `bundle exec jekyll build`: generate the static site into `_site/` (use as a pre-push sanity check).
- `bundle exec jekyll doctor`: diagnose common Jekyll configuration/content issues.

## Coding Style & Naming Conventions

- Markdown pages should include YAML front matter (`layout`, `title`, etc.) like `pages/group.md`.
- YAML: use 2-space indentation; keep keys consistent with existing config.
- Filenames: lowercase with hyphens (example: `pages/my-topic.md`).
- Prefer Markdown over raw HTML; if importing older HTML, keep the output readable.
  - Example: `pandoc --from html --to markdown_strict -s page.html -o page.md`

## Testing Guidelines

No automated test suite is configured. Treat `bundle exec jekyll build` plus a quick local preview (`bundle exec jekyll serve`) as the required verification for changes.

## Publications / References

- Source of truth: edit `_data/publications.yml` and reuse lists via `{% include publications.html ... %}`.
- Optional: regenerate `_data/publications.yml` from legacy sources with `python3 scripts/build_publications_data.py`.

## Commit & Pull Request Guidelines

- Commits: short, imperative summaries consistent with history (example: `Update _config.yml`); avoid vague messages like “modified stuff”.
- PRs: include a clear description, link relevant issues, and add a screenshot for visual/layout changes. Note what you ran locally (usually `bundle exec jekyll build`).
