---
layout: default
title: Emil Constantinescu
tagline: Homepage
description: Homepage of Emil Constantinescu
---

<div class="home-hero">
  <div class="home-hero__photo">
    <img src="{{ '/assets/images/emil-constantinescu-pic.jpg' | relative_url }}" alt="Emil Constantinescu" />
  </div>
  <div class="home-hero__meta">
    <h1 class="home-hero__name">Emil Constantinescu</h1>
    <p class="home-hero__tagline">
      Senior Computational Mathematician, Argonne National Laboratory · Scientist at Large, CASE (University of Chicago)
    </p>
    <div class="home-hero__links">
      <a class="pill" href="https://scholar.google.com/citations?hl=en&user=aPLUgCMAAAAJ">Google Scholar</a>
      <a class="pill" href="https://github.com/emconsta">GitHub</a>
    </div>
  </div>
</div>

I am a Senior Computational Mathematician in the Mathematics and Computer Science Division and part of the Laboratory for Applied Mathematics, Numerical Software, and Statistics (LANS) at Argonne National Laboratory, and a Scientist at Large at the Consortium for Advanced Science and Engineering (CASE), The University of Chicago.

## Research

My research interests are in scientific computing and applied mathematics, with a focus on algorithms for modeling and simulation of multiscale, real-world processes.

<div class="cards">
  <a class="card" href="{{ '/pages/time-stepping' | relative_url }}">
    <h3 class="card__title">Time integration</h3>
    <p class="card__desc">Robust time-stepping for stiff and multiscale dynamical systems (IMEX, multirate, adjoints).</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
  <a class="card" href="{{ '/pages/data-assimilation' | relative_url }}">
    <h3 class="card__title">Uncertainty quantification &amp; data assimilation</h3>
    <p class="card__desc">Inverse problems, sensitivity analysis, and data assimilation for large-scale models.</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
  <a class="card" href="{{ '/pages/amr' | relative_url }}">
    <h3 class="card__title">Modeling &amp; simulation (AMR)</h3>
    <p class="card__desc">Adaptive resolution and scalable solvers for high-fidelity simulation.</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
  <a class="card" href="{{ '/pages/sciml' | relative_url }}">
    <h3 class="card__title">Scientific machine learning</h3>
    <p class="card__desc">Hybrid physics/ML methods for modeling, inference, and uncertainty quantification.</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
</div>

## Software

- DAPack (data assimilation package): <https://bitbucket.org/emconsta/dapack>
- PETSc time stepping: <https://petsc.org/release/>

## Recent papers

{% include publications.html type="journal" featured="true" limit="8" %}
