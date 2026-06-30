---
layout: default
title: Emil Constantinescu
tagline: Homepage
description: Homepage of Emil Constantinescu
---

<nav class="home-jumpnav" aria-label="Homepage sections">
  <a href="#research">Research</a>
  <a href="#projects">Projects</a>
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

<section id="research" class="home-section home-section--research">
  <div class="home-section-heading">
    <span class="home-section-heading__icon" aria-hidden="true">
      <svg viewBox="0 0 24 24" focusable="false">
        <circle cx="6" cy="7" r="2"></circle>
        <circle cx="18" cy="7" r="2"></circle>
        <circle cx="12" cy="17" r="2"></circle>
        <path d="M8 7h8M7.2 8.8l3.5 5.8M16.8 8.8l-3.5 5.8"></path>
      </svg>
    </span>
    <div>
      <h2>Research</h2>
    </div>
  </div>

  <p class="home-section-intro">Core research themes and representative directions.</p>

  <p>My research focuses on scientific machine learning (SciML) for modeling and inference in complex dynamical systems. I develop scalable methods for uncertainty quantification and data assimilation, robust time integration schemes for stiff and multiscale dynamics, and adaptive mesh refinement techniques for PDE simulation.</p>

  <div class="cards cards--research cards--compact">
    <a class="card" href="{{ '/pages/sciml' | relative_url }}">
      <h3 class="card__title">Scientific machine learning</h3>
      <p class="card__tag">Focus: SciML</p>
      <p class="card__desc">Hybrid physics/ML methods for modeling, inference, and uncertainty quantification.</p>
      <p class="card__meta">Selected papers and background →</p>
    </a>
    <a class="card" href="{{ '/pages/data-assimilation' | relative_url }}">
      <h3 class="card__title">Uncertainty quantification &amp; data assimilation</h3>
      <p class="card__tag">Focus: UQ/DA</p>
      <p class="card__desc">Inverse problems, sensitivity analysis, and scalable data assimilation.</p>
      <p class="card__meta">Selected papers and background →</p>
    </a>
    <a class="card" href="{{ '/pages/time-stepping' | relative_url }}">
      <h3 class="card__title">Time integration</h3>
      <p class="card__tag">Focus: Time stepping</p>
      <p class="card__desc">Robust time-stepping for stiff and multiscale dynamics (IMEX, multirate, adjoints), with PETSc and DESolve implementations.</p>
      <p class="card__meta">Selected papers and background →</p>
    </a>
    <a class="card" href="{{ '/pages/amr' | relative_url }}">
      <h3 class="card__title">PDE &amp; AMR</h3>
      <p class="card__tag">Focus: PDE/AMR</p>
      <p class="card__desc">High-fidelity PDE simulation with adaptive mesh refinement and scalable solvers.</p>
      <p class="card__meta">Selected papers and background →</p>
    </a>
  </div>
</section>

<section id="projects" class="home-section home-section--projects">
  <div class="home-section-heading">
    <span class="home-section-heading__icon" aria-hidden="true">
      <svg viewBox="0 0 24 24" focusable="false">
        <rect x="4" y="5" width="7" height="5" rx="1.5"></rect>
        <rect x="13" y="5" width="7" height="5" rx="1.5"></rect>
        <rect x="8.5" y="14" width="7" height="5" rx="1.5"></rect>
        <path d="M11 7.5h2M12 10v4"></path>
      </svg>
    </span>
    <div>
      <h2>Projects</h2>
    </div>
  </div>

  <p class="home-section-intro">Current project overviews and research-thrust pages.</p>

  <div class="cards cards--home-projects cards--compact">
    <a class="card project-card" href="{{ '/pages/project-power-grid' | relative_url }}">
      <p class="card__tag">Power grid</p>
      <h3 class="card__title">Power Grid and Uncertainty Quantification</h3>
      <p class="card__desc">Weather-aware operations, stochastic power-system dynamics, adjoint-based inference, and surrogate-assisted security margins for inverter-based grids.</p>
      <p class="card__meta">Open project page →</p>
    </a>
    <a class="card project-card" href="{{ '/pages/project-hybrid-ml-pde' | relative_url }}">
      <p class="card__tag">Scientific machine learning</p>
      <h3 class="card__title">Hybrid ML-PDE for accelerated simulation</h3>
      <p class="card__desc">Learned weak-form and source-term corrections for finite element and DG solvers, designed for long-horizon accuracy at reduced computational cost.</p>
      <p class="card__meta">Open project page →</p>
    </a>
    <a class="card project-card" href="{{ '/pages/project-disentangling' | relative_url }}">
      <p class="card__tag">Scientific machine learning</p>
      <h3 class="card__title">Disentangled latent spaces for scientific modeling</h3>
      <p class="card__desc">Auxiliary-guided latent representations for interpretable generative modeling, dark-matter structure analysis, and deep priors for inverse problems.</p>
      <p class="card__meta">Open project page →</p>
    </a>
    <a class="card project-card" href="{{ '/pages/project-data-assimilation' | relative_url }}">
      <p class="card__tag">UQ &amp; data assimilation</p>
      <h3 class="card__title">Data assimilation and uncertainty-aware inference</h3>
      <p class="card__desc">Ensemble and variational data assimilation, physics-informed Gaussian processes, and uncertainty-aware forecasting for atmospheric chemistry and climate variability.</p>
      <p class="card__meta">Open project page →</p>
    </a>
    <a class="card project-card" href="{{ '/pages/project-time-integration' | relative_url }}">
      <p class="card__tag">Time integration</p>
      <h3 class="card__title">Time integration for stiff and multiscale dynamics</h3>
      <p class="card__desc">SSP and general linear methods, IMEX and multirate schemes, and global error estimation for PDE discretizations.</p>
      <p class="card__meta">Open project page →</p>
    </a>
  </div>

  <p class="home-section-actions">
    <a class="pill" href="{{ '/pages/projects' | relative_url }}">View all project pages</a>
  </p>
</section>

<section id="software" class="home-section home-section--software">
  <div class="home-section-heading">
    <span class="home-section-heading__icon" aria-hidden="true">
      <svg viewBox="0 0 24 24" focusable="false">
        <rect x="3" y="5" width="18" height="14" rx="2.5"></rect>
        <path d="M7.5 9.2 10.5 12l-3 2.8M13.5 15h3.5"></path>
      </svg>
    </span>
    <div>
      <h2>Software</h2>
    </div>
  </div>

  <p class="home-section-intro">Open-source software contributions for scientific computing and machine learning workflows.</p>

  <div class="cards cards--software cards--compact">
    <article class="card software-card">
      <h3 class="card__title">DESolve</h3>
      <p class="software-card__role">Lead developer</p>
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
      <p class="software-card__role">Lead developer</p>
      <p class="card__desc">Data assimilation for UQ and inference.</p>
      <p class="software-card__links"><a class="pub-chip" href="https://bitbucket.org/emconsta/dapack">Repository</a></p>
    </article>
    <article class="card software-card">
      <h3 class="card__title">DeepGenPrior</h3>
      <p class="software-card__role">Lead developer</p>
      <p class="card__desc">Disentangled deep generative priors for Bayesian inverse problems.</p>
      <p class="software-card__links"><a class="pub-chip" href="https://github.com/emconsta/DeepGenPrior">GitHub</a></p>
    </article>
    <article class="card software-card">
      <h3 class="card__title">UQGrid</h3>
      <p class="software-card__role">Contributor</p>
      <p class="card__desc">Power grid dynamics and UQ workflows.</p>
      <p class="software-card__links"><a class="pub-chip" href="https://github.com/dmaldona/uqgrid">GitHub</a></p>
    </article>
  </div>
</section>

<section id="recent-papers" class="home-section home-section--publications">
  <div class="home-section-heading">
    <span class="home-section-heading__icon" aria-hidden="true">
      <svg viewBox="0 0 24 24" focusable="false">
        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"></path>
        <path d="M8 7h6M8 11h4"></path>
      </svg>
    </span>
    <div>
      <h2>Recent papers</h2>
    </div>
  </div>

  <p class="home-section-intro">Selected recent and featured publications.</p>

  {% include publications.html featured="true" limit="12" %}

  <p class="home-section-actions">
    <a class="pill pill--primary" href="{{ '/pages/publications' | relative_url }}">View all publications</a>
  </p>
</section>
