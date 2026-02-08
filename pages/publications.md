---
layout: default
title: Publications
description: Publications
---

# Publications

{% assign pubs = site.data.publications %}
{% assign journal_pubs = pubs | where: "type", "journal" %}
{% assign proceedings_pubs = pubs | where: "type", "proceedings" %}
{% assign report_pubs = pubs | where: "type", "report" %}

<div class="publications-overview">
  <div class="publications-overview__stats">
    <span class="pill">{{ journal_pubs | size }} journal articles</span>
    <span class="pill">{{ proceedings_pubs | size }} conference / workshop papers</span>
    <span class="pill">{{ report_pubs | size }} technical reports</span>
  </div>

  <nav class="pub-nav" aria-label="Publications sections">
    <a href="#journals">Journal articles</a>
    <a href="#proceedings">Conference / workshops / presentations</a>
    <a href="#reports">Technical reports</a>
  </nav>
</div>

## Journal articles {#journals}

{% include publications.html type="journal" entry_layout="rows" %}

## Conference / workshops / presentations {#proceedings}

{% include publications.html type="proceedings" entry_layout="rows" %}

## Technical reports {#reports}

{% include publications.html type="report" entry_layout="rows" %}
