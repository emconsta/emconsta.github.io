---
layout: default
title: "Project: Time integration"
description: "Time integration project overview"
---

# Time Integration Project: Robust time stepping for stiff and multiscale PDEs

<script>
  window.MathJax = {
    tex: {
      inlineMath: [['$', '$'], ['\\(', '\\)']],
      displayMath: [['$$', '$$'], ['\\[', '\\]']]
    },
    options: {
      skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code']
    }
  };
</script>
<script defer src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>

<div class="project-overview">
  <p class="project-overview__lead">
    This project develops time integration algorithms for stiff and multiscale dynamical systems arising
    from PDE discretizations. The focus is on methods that remain accurate in long simulations while
    scaling to large problems: strong-stability-preserving (SSP) schemes, general linear methods (GLMs),
    implicit-explicit (IMEX) integration, multirate time stepping, and global error estimation.
  </p>
  <div class="project-overview__meta">
    <span class="pill">Thrust: Time integration</span>
    <span class="pill">Scope: SSP, GLM, IMEX, multirate, global error estimation</span>
    <span class="pill">Implementation: PETSc TS and DESolve</span>
  </div>
</div>

## Motivation

Many scientific applications evolve PDEs in time. After spatial discretization, these problems typically
take the form of large ODE systems:

<p class="mathjax-display">\[ \frac{d u_h(t)}{dt} = F_h(u_h(t), t), \qquad u_h(0) = u_{h,0}. \]</p>

Two challenges tend to dominate:

1. **Stiffness**: fast physics or fine spatial scales can force prohibitively small explicit time steps.
2. **Multiple time scales**: different components (or spatial regions) evolve at very different rates.

This project explores integrators that exploit structure (splittings, partitions, and error estimators) to
improve efficiency while maintaining stability and reliable accuracy.

## Topic 1: New methodologies for numerical integrators

At the core are **one-step** (Runge-Kutta) and **multistep** (linear multistep) methods. For hyperbolic
PDEs and nonlinear conservation laws, robustness often means preserving stability properties that are
known to hold under forward Euler, such as monotonicity or total-variation-diminishing (TVD) behavior.

### Strong stability preserving (SSP) time stepping

An SSP method is designed so that, under an appropriate step-size restriction, it can be expressed as a
convex combination of forward Euler updates. This provides a principled way to build higher-order
methods that inherit nonlinear stability properties important in PDE simulations.

### General linear methods (GLMs)

GLMs unify Runge-Kutta and linear multistep methods within a single framework. A compact representation is:

<p class="mathjax-display">\[
Y = h A F(Y) + U\,y^{[n-1]}, \qquad
y^{[n]} = h B F(Y) + V\,y^{[n-1]},
\]</p>

where $Y$ collects stage values, $y^{[n]}$ stores the propagated solution history, and $(A,B,U,V)$ define
the method. This view is useful for designing schemes with properties that matter in PDE settings, such
as **high stage order** (to mitigate order reduction in stiff problems) and SSP behavior. GLMs also
provide a natural bridge to linearly implicit (Rosenbrock-type) constructions and to methods with
embedded error estimation.

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>Advantages:</strong> principled stability design (SSP) and a unified design space (GLMs) that can improve long-time robustness for PDE discretizations.</p>
  <p><strong>Limitations:</strong> higher-order SSP/GLM designs can increase stage count or coupling complexity, and practical performance depends on implementation details (e.g., Jacobian reuse, preconditioning, and adaptivity).</p>
</div>

<h3>Selected references</h3>
<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "sandu-2010-optimal-strong-stability-preserving-general-linear-methods" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "constantinescu-2009-on-the-order-of-general-linear" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

## Topic 2: Implicit-explicit (IMEX) and splitting methods

In many PDE models, different terms have very different stiffness and solver cost. IMEX methods start
from an additive split

<p class="mathjax-display">\[ F_h(u,t) = F_E(u,t) + F_I(u,t), \]</p>

where $F_E$ is treated explicitly (cheap, nonstiff) and $F_I$ is treated implicitly (stiff, but often
structured so that robust solvers and preconditioners apply). IMEX is particularly attractive for
multiphysics coupling and for systems where a fully implicit method would be too expensive.

<div class="project-callout">
  <h3>When IMEX works best</h3>
  <p><strong>Best use cases:</strong> a clean split with a stiff component that is well-handled by scalable implicit solvers, and a nonstiff component that would otherwise enforce small explicit steps.</p>
  <p><strong>Typical limitations:</strong> splitting error and nonlinear coupling can reduce effective order (order reduction), and stability constraints may still depend on the explicit component or on how the split is defined.</p>
</div>

<div class="project-media-card">
  <h3>Accuracy and cost tradeoffs in IMEX designs</h3>
  <p class="project-media-card__lead">
    IMEX design is ultimately about balancing stability and accuracy against solver cost. This figure shows
    a representative cost-versus-error comparison across different IMEX-type strategies.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/time-stepping/imex-error-vs-cpu.jpg' | relative_url }}" alt="Error versus CPU time comparison across IMEX and related methods" />
      <figcaption>Error versus CPU time illustrates efficiency tradeoffs among IMEX variants.</figcaption>
    </figure>
  </div>
</div>

<h3>Selected references</h3>
<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "sandu-2010-extrapolated-implicit-explicit-time-stepping" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "abdi-2019-acceleration-of-an-implicit-explicit-non-hydrostatic" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

## Topic 3: Multirate methods for multiple time scales

Multirate methods target problems where some components evolve fast and others evolve slowly. One way to
express this is a partition:

<p class="mathjax-display">\[ \frac{d u}{dt} = f_{\mathrm{slow}}(u,t) + f_{\mathrm{fast}}(u,t). \]</p>

The goal is to take a large **macro step** for the slow dynamics while resolving the fast dynamics with
cheaper **micro steps**, often only where needed (e.g., localized fast regions in space).

This project studies multirate methods built from several design patterns:

1. **Multirate Runge-Kutta (MRK)**: RK stages are coupled across fast/slow components with controlled
   information exchange.
2. **Multirate linear multistep (MR-LMM)**: multistep history is advanced with different step sizes for
   different components.
3. **Multirate extrapolation**: a hierarchy of solves at different resolutions is combined by
   extrapolation to improve accuracy without fully resolving all components at the smallest step size.

<div class="project-media-card">
  <h3>Fast and slow regions, coupling, and stability</h3>
  <p class="project-media-card__lead">
    The central multirate question is how to couple fast and slow updates so that the combined method is
    stable and accurate. The figures below illustrate fast/slow structure, error behavior, and the impact
    of coupling choices on stability.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/time-stepping/mr-fast-slow-wavespeed.png' | relative_url }}" alt="Example of a spatially varying wavespeed with fast and slow regions" />
      <figcaption>Spatially varying fast/slow structure motivates multirate stepping.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/time-stepping/mr-system-fast-slow-error.png' | relative_url }}" alt="Error behavior for system, fast, and slow components as a function of time step" />
      <figcaption>Different components can exhibit different error sensitivity to the step size.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/time-stepping/mr-unstable.png' | relative_url }}" alt="An unstable multirate integration example with blow-up behavior" />
      <figcaption>Naive coupling can produce severe instabilities in multirate settings.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/time-stepping/mr-stable.png' | relative_url }}" alt="A stable multirate integration example" />
      <figcaption>Structured coupling stabilizes multirate integration in the same setting.</figcaption>
    </figure>
  </div>
</div>

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>Advantages:</strong> reduces cost by resolving fast dynamics only as needed while taking large steps for slow dynamics.</p>
  <p><strong>Limitations:</strong> stability and accuracy depend on coupling design; fast/slow partitions that change in time or space require careful treatment to avoid drift or instability.</p>
</div>

<h3>Selected references</h3>
<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "sandu-2007-multirate-timestepping-methods-for-hyperbolic-conservation" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "constantinescu-2009-multirate-explicit-adams-methods-for-time" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "sandu-2010-on-multirate-numerical-integration-methods" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

## Topic 4: Global error estimation and control

Most adaptive time integrators choose the time step by controlling a **local error estimate** (LEE), for example from an embedded method pair.
This is effective for short integrations, but it does not directly control the **global error** $e^{[n]} = y^{[n]} - y(t_n)$, which can drift above
tolerance over long horizons or in problems with unstable components.

Global error estimation methods augment the integrator so that an estimate of the accumulated error is propagated alongside the solution.
In the approach developed in this project, a general linear method evolves both the numerical solution $y^{[n]}$ and an error estimate
$\varepsilon^{[n]}$:

<p class="mathjax-display">\[
\{y^{[n]},\varepsilon^{[n]}\} = \mathcal{G}_h(\{y^{[n-1]},\varepsilon^{[n-1]}\}), \qquad
\widehat{y}^{[n]} = y^{[n]} + \varepsilon^{[n]}, \qquad
\varepsilon_{\mathrm{loc}}^{[n]} = \varepsilon^{[n]} - \varepsilon^{[n-1]}.
\]</p>

**Advantage.** The estimator targets the quantity of interest (global error) rather than an indirect proxy, which is better suited for long-time
integration and for detecting when local-error-controlled simulations silently accumulate unacceptable error.

**Limitation.** As with any estimator, accuracy depends on the problem class and method design; global-error-aware adaptivity introduces additional
parameters and requires careful stability analysis.

<div class="project-media-card">
  <h3>Local versus global error behavior</h3>
  <p class="project-media-card__lead">
    Local error control can appear successful on short windows while the accumulated global error grows over long horizons.
    Global error estimation explicitly tracks the accumulated error and can remain informative in long-time simulations.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/time-stepping/local-error-short-time.png' | relative_url }}" alt="Global error over a short time interval under local error control" />
      <figcaption>Short time: local error control can keep the global error below tolerance.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/time-stepping/local-error-long-time.png' | relative_url }}" alt="Global error growth over a long time interval under local error control" />
      <figcaption>Long time: global error can grow beyond tolerance even when local error is controlled.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/time-stepping/global-error-estimate.png' | relative_url }}" alt="Estimated global error compared with exact global error" />
      <figcaption>Estimated versus exact global error illustrates estimator fidelity.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/time-stepping/global-error-stability.png' | relative_url }}" alt="Stability diagnostics for global error estimation methods" />
      <figcaption>Stability diagnostics complement accuracy when designing global-error-aware schemes.</figcaption>
    </figure>
  </div>
</div>

<h3>Selected references</h3>
<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "constantinescu-2018-generalizing-global-error-estimation-for-ordinary" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

## Software

<p class="home-section-intro">
  Many of the methods above are available in open-source libraries used in production simulations.
</p>

<div class="cards cards--software">
  <article class="card software-card">
    <h3 class="card__title">PETSc TS</h3>
    <p class="software-card__role">HPC time stepping</p>
    <p class="card__desc">Includes ARKIMEX, global error estimation methods (GLEE), and multirate time stepping for large-scale ODE/DAE systems.</p>
    <p class="software-card__links"><a class="pub-chip" href="https://petsc.org/release/">Project page</a></p>
  </article>
  <article class="card software-card">
    <h3 class="card__title">DESolve</h3>
    <p class="software-card__role">Time integration package</p>
    <p class="card__desc">Research implementation of MREXIM, along with prototyping of stiff and multirate integrators.</p>
    <p class="software-card__links"><a class="pub-chip" href="https://emconsta.github.io/desolve">Website</a> <a class="pub-chip" href="https://github.com/emconsta/desolve">GitHub</a></p>
  </article>
</div>

## Related pages

- [Projects index]({{ '/pages/projects' | relative_url }})
- [Time integration research area]({{ '/pages/time-stepping' | relative_url }})
- [PDE & AMR]({{ '/pages/amr' | relative_url }})

## Funding

- U.S. Department of Energy, Office of Science, Office of Advanced Scientific Computing Research (ASCR), the Applied Mathematics Program.
- U.S. National Science Foundation (on earlier work, prior to 2008)

## References for deeper dive

<p class="home-section-intro">
  The lists below are filtered from the site’s publication database.
</p>

<h3>Journal articles</h3>
{% include publications.html type="journal" tag="time-stepping" entry_layout="rows" %}

<h3>Proceedings / presentations</h3>
{% include publications.html type="proceedings" tag="time-stepping" entry_layout="rows" %}

<h3>Technical reports</h3>
{% include publications.html type="report" tag="time-stepping" entry_layout="rows" %}
