---
layout: default
title: PDE & AMR
description: PDE simulation with adaptive mesh refinement (AMR)
---

# PDE & AMR

Many real-world applications require large-scale numerical solutions of PDEs. I work on scalable simulation algorithms and adaptive mesh refinement (AMR), which dynamically refines space/time resolution in regions where solution features require it.

<img src="{{ '/assets/images/research/grid_refined.jpg' | relative_url }}" alt="Adaptive mesh refinement example" width="420" />

## Related project

<div class="project-callout">
  <h3>Hybrid ML-PDE for accelerated simulation</h3>
  <p>Includes learned corrections embedded in PDE discretizations, with direct relevance to stable, scalable simulation pipelines.</p>
  <p><a href="{{ '/pages/project-hybrid-ml-pde' | relative_url }}">View project details</a></p>
</div>

## Selected journal publications

{% include publications.html type="journal" tag="amr" %}

## Proceedings / presentations

{% include publications.html type="proceedings" tag="amr" %}

## Technical reports

{% include publications.html type="report" tag="amr" %}
