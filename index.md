---
layout: default
title: Emil Constantinescu
tagline: Homepage
description: Homepage of Emil Constantinescu
---

<nav class="home-jumpnav" aria-label="Homepage sections">
  <a href="#research">Research</a>
  <a href="#software">Software</a>
  <a href="#recent-papers">Recent papers</a>
  <a href="{{ '/pages/group' | relative_url }}">Group</a>
</nav>

<div class="home-hero">
  <div class="home-hero__photo">
    <img src="{{ '/assets/images/emil-constantinescu-pic.jpg' | relative_url }}" alt="Emil Constantinescu" />
  </div>
  <div class="home-hero__meta">
    <h1 class="home-hero__name">Emil Constantinescu</h1>
    <p class="home-hero__value">Scalable scientific machine learning and scientific computing for simulation, inference, and uncertainty-aware decision support.</p>
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

<div class="home-overview">
  <a class="pill" href="#research">4 research areas</a>
  <a class="pill" href="#software">4 software packages</a>
  <a class="pill" href="#recent-papers">12 featured papers</a>
  <a class="pill" href="{{ '/pages/group' | relative_url }}">Group members</a>
</div>

## Research {#research}

<p class="home-section-intro">Core research themes and representative directions.</p>

My research focuses on scientific machine learning (SciML) for modeling and inference in complex dynamical systems. I develop scalable methods for uncertainty quantification and data assimilation, robust time integration schemes for stiff and multiscale dynamics, and adaptive mesh refinement techniques for PDE simulation.

<div class="cards cards--research">
  <a class="card" href="{{ '/pages/sciml' | relative_url }}">
    <h3 class="card__title">Scientific machine learning</h3>
    <p class="card__tag">Focus: SciML</p>
    <p class="card__desc">Hybrid physics/ML methods for modeling, inference, and uncertainty quantification.</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
  <a class="card" href="{{ '/pages/data-assimilation' | relative_url }}">
    <h3 class="card__title">Uncertainty quantification &amp; data assimilation</h3>
    <p class="card__tag">Focus: UQ/DA</p>
    <p class="card__desc">Inverse problems, sensitivity analysis, and data assimilation for large-scale models.</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
  <a class="card" href="{{ '/pages/time-stepping' | relative_url }}">
    <h3 class="card__title">Time integration</h3>
    <p class="card__tag">Focus: Time stepping</p>
    <p class="card__desc">Robust time-stepping for stiff and multiscale dynamical systems (IMEX, multirate, adjoints), including methods implemented in PETSc and DESolve.</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
  <a class="card" href="{{ '/pages/amr' | relative_url }}">
    <h3 class="card__title">PDE &amp; AMR</h3>
    <p class="card__tag">Focus: PDE/AMR</p>
    <p class="card__desc">High-fidelity PDE simulation with adaptive mesh refinement and scalable solvers.</p>
    <p class="card__meta">Selected papers and background →</p>
  </a>
</div>

## Software {#software}

<p class="home-section-intro">Open-source software contributions for scientific computing and machine learning workflows.</p>

<div class="cards cards--software">
  <article class="card software-card">
    <h3 class="card__title">DESolve</h3>
    <p class="software-card__role">Lead package</p>
    <p class="card__desc">Time integration for stiff and multiscale systems.</p>
    <p class="software-card__links"><a class="pub-chip" href="https://emconsta.github.io/desolve">Website</a> <a class="pub-chip" href="https://github.com/emconsta/desolve">GitHub</a></p>
  </article>
  <article class="card software-card">
    <h3 class="card__title">PETSc TS</h3>
    <p class="software-card__role">Core contributor</p>
    <p class="card__desc">Scalable ODE/DAE and time stepping in HPC.</p>
    <p class="software-card__links"><a class="pub-chip" href="https://petsc.org/release/">Project page</a></p>
  </article>
  <article class="card software-card">
    <h3 class="card__title">DAPack</h3>
    <p class="software-card__role">Lead package</p>
    <p class="card__desc">Data assimilation for uncertainty quantification and inference.</p>
    <p class="software-card__links"><a class="pub-chip" href="https://bitbucket.org/emconsta/dapack">Repository</a></p>
  </article>
  <article class="card software-card">
    <h3 class="card__title">UQGrid</h3>
    <p class="software-card__role">Contributor</p>
    <p class="card__desc">Power grid dynamics and UQ workflows.</p>
    <p class="software-card__links"><a class="pub-chip" href="https://github.com/dmaldona/uqgrid">GitHub</a></p>
  </article>
</div>

## Recent papers {#recent-papers}

<p class="home-section-intro">Selected recent and featured publications.</p>

{% include publications.html featured="true" limit="12" %}

<p class="home-section-actions">
  <a class="pill pill--primary" href="{{ '/pages/publications' | relative_url }}">View all publications</a>
</p>
