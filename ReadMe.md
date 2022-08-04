## Simple site: Easy websites with GitHub pages

To build the site locally, run `bundle exec jekyll serve`
Use `pandoc` to convert old html pages to markdown
```
pandoc  --from html --to markdown_strict -s page.html -o page.md
``` 