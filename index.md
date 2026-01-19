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
    <ul class="home-hero__affiliations">
      <li>
        Senior Computational Mathematician, <a href="https://www.anl.gov/mcs">Mathematics and Computer Science Division (MCS)</a>, Argonne National Laboratory
      </li>
      <li>
        <a href="https://www.anl.gov/mcs/lans">Laboratory for Applied Mathematics, Numerical Software, and Statistics (LANS)</a>, Argonne National Laboratory
      </li>
      <li>
        Scientist at Large, <a href="https://researchdevelopment.uchicago.edu/case/">Consortium for Advanced Science and Engineering (CASE)</a>, University of Chicago
      </li>
    </ul>
    <div class="home-hero__links">
      <a class="pill" href="https://scholar.google.com/citations?hl=en&user=aPLUgCMAAAAJ">Google Scholar</a>
      <a class="pill" href="https://orcid.org/0000-0002-7003-6899">ORCID</a>
      <a class="pill" href="https://github.com/emconsta">GitHub</a>
      <a class="pill" href="https://gitlab.com/emconsta">GitLab</a>
    </div>
  </div>
</div>

## Research

My research focuses on scientific machine learning (SciML) for modeling and inference in complex dynamical systems. I develop scalable methods for uncertainty quantification and data assimilation, robust time integration schemes for stiff and multiscale dynamics, and adaptive mesh refinement techniques for PDE simulation.

<div class="cards">
  <a class="card" href="{{ '/pages/sciml' | relative_url }}">
    <h3 class="card__title">Scientific machine learning</h3>
    <p class="card__desc">Hybrid physics/ML methods for modeling, inference, and uncertainty quantification.</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
  <a class="card" href="{{ '/pages/data-assimilation' | relative_url }}">
    <h3 class="card__title">Uncertainty quantification &amp; data assimilation</h3>
    <p class="card__desc">Inverse problems, sensitivity analysis, and data assimilation for large-scale models.</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
  <a class="card" href="{{ '/pages/time-stepping' | relative_url }}">
    <h3 class="card__title">Time integration</h3>
    <p class="card__desc">Robust time-stepping for stiff and multiscale dynamical systems (IMEX, multirate, adjoints).</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
  <a class="card" href="{{ '/pages/amr' | relative_url }}">
    <h3 class="card__title">PDE &amp; AMR</h3>
    <p class="card__desc">High-fidelity PDE simulation with adaptive mesh refinement and scalable solvers.</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
</div>

## Software

- DESolve (time integration package): <https://gitlab.com/emconsta/desolve>
- PETSc time stepping: <https://petsc.org/release/>
- DAPack (data assimilation package): <https://bitbucket.org/emconsta/dapack>
- UQGrid (power grid dynamics; contributor): <https://github.com/dmaldona/uqgrid>

## Recent papers

{% include publications.html featured="true" limit="12" %}
