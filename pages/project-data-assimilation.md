---
layout: default
title: "Project: Data assimilation"
description: "Data assimilation and uncertainty-aware inference project overview"
---

# Data Assimilation Project: Uncertainty-aware inference for complex dynamical systems

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
    This project develops scalable methods for uncertainty quantification (UQ) and data assimilation (DA) in large dynamical systems.
    The emphasis is on combining ensemble-based and variational approaches with physics-informed statistical models (Gaussian processes) to enable robust state/parameter inference and uncertainty-aware prediction.
  </p>
  <div class="project-overview__meta">
    <span class="pill">Thrust: UQ &amp; data assimilation</span>
    <span class="pill">Methods: EnKF/EnKS, 4D-Var, inverse problems, Gaussian processes</span>
    <span class="pill">Applications: Atmospheric chemistry, wind and climate variability</span>
  </div>
</div>

<nav class="project-nav" aria-label="Data assimilation sections">
  <a href="#motivation">Motivation</a>
  <a href="#topic-chemistry-da">Chemistry DA</a>
  <a href="#topic-variational-da">Variational DA</a>
  <a href="#topic-gp-inference">Physics-informed GPs</a>
  <a href="#topic-mjo">MJO forecasting</a>
  <a href="#software">Software</a>
  <a href="#funding">Funding</a>
</nav>

<div class="cards project-key-grid">
  <article class="card project-key-card">
    <p class="card__tag">Scientific question</p>
    <h3 class="card__title">How do we infer hidden states and parameters from sparse noisy data?</h3>
    <p class="card__desc">Scientific DA problems combine partial observations, uncertain models, and large state spaces, so uncertainty has to be represented in a computationally realistic way.</p>
  </article>
  <article class="card project-key-card">
    <p class="card__tag">Core idea</p>
    <h3 class="card__title">Combine numerical structure with statistical models</h3>
    <p class="card__desc">This work spans ensemble and variational DA, inverse problems, and physics-informed Gaussian processes, with each tool addressing a different computational bottleneck.</p>
  </article>
  <article class="card project-key-card">
    <p class="card__tag">What visitors should learn</p>
    <h3 class="card__title">Different inference tasks need different approximations</h3>
    <p class="card__desc">The page is organized around four settings: chemistry DA, scalable 4D-Var, multi-output GP inference, and probabilistic climate forecasting.</p>
  </article>
</div>

## Motivation {#motivation}

Many inference problems in science can be framed as estimating an evolving state $x(t)$ from partial and noisy observations $y(t)$, given an imperfect dynamical model.
In discrete time, a common abstraction is

<p class="mathjax-display">\[
x_{k+1} = \mathcal{M}_k(x_k) + \eta_k,
\qquad
y_k = \mathcal{H}_k(x_k) + \epsilon_k,
\]</p>

where $\mathcal{M}_k$ is the model propagator, $\mathcal{H}_k$ maps a model state to observation space, and $(\eta_k,\epsilon_k)$ represent model and observation errors.
DA methods compute estimates of $x_k$ (and often uncertain parameters) while tracking uncertainty in a way that is accurate enough for decision support, but also computationally feasible at scale.

## Ensemble and variational data assimilation: complementary tools

Two widely used paradigms are **ensemble-based** and **variational** data assimilation. They have different computational tradeoffs and failure modes, and many practical workflows mix ideas from both.

### Variational DA (4D-Var)

4D-Var estimates an initial condition (and possibly parameters) by solving an optimization problem over an assimilation window:

<p class="mathjax-display">\[
J(x_0) =
\tfrac{1}{2}\lVert x_0 - x_b \rVert_{\mathbf{B}^{-1}}^2
\;+\;
\tfrac{1}{2}\sum_{k=0}^{N}
\lVert y_k - \mathcal{H}_k(\mathcal{M}_{0\to k}(x_0)) \rVert_{\mathbf{R}_k^{-1}}^2,
\]</p>

where $x_b$ is a background (prior) state, and $\mathbf{B},\mathbf{R}_k$ are background and observation error covariances.
Gradients (and often Hessian-vector products) are computed with tangent-linear/adjoint models.

### Ensemble Kalman methods (EnKF/EnKS)

Ensemble Kalman methods approximate uncertainty using an ensemble and apply Kalman-type updates at observation times. In a linearized form,

<p class="mathjax-display">\[
x_k^{a} = x_k^{f} + \mathbf{K}_k \bigl(y_k - \mathbf{H}_k x_k^{f}\bigr),
\qquad
\mathbf{K}_k = \mathbf{P}_k^{f}\mathbf{H}_k^{T}\bigl(\mathbf{H}_k\mathbf{P}_k^{f}\mathbf{H}_k^{T} + \mathbf{R}_k \bigr)^{-1},
\]</p>

with the forecast covariance $\mathbf{P}_k^{f}$ estimated from the ensemble.

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>Ensemble methods:</strong> naturally parallel, no adjoint required, and provide sample-based uncertainty; but they suffer from sampling error in high dimension (spurious long-range correlations), often requiring <em>localization</em> and <em>inflation</em>, and they are sensitive to model error specification.</p>
  <p><strong>Variational methods:</strong> scale well with state dimension (no explicit covariance matrices) and can enforce model and constraint structure; but they require tangent-linear/adjoint capabilities and robust optimization, and they can be sensitive to nonconvexity and poor preconditioning.</p>
</div>

## What this project contributes

1. Flow-dependent prior/error models for ensemble-based chemistry DA, including autoregressive (AR) background covariance construction and analysis of ensemble size/localization effects.
2. Scalable variational DA strategies (low-memory smoothing and space-time domain decomposition) for large inverse problems.
3. Physics-informed covariance modeling for multi-output Gaussian processes and hidden-process inference.
4. Probabilistic GP forecasting workflows with explicit uncertainty calibration for time-series prediction problems.

## Topic 1: Chemical data assimilation with EnKF and flow-dependent priors {#topic-chemistry-da}

Atmospheric chemistry DA is challenging because (i) the state is large and coupled across species, (ii) observations are sparse/heterogeneous, and (iii) background error structure is strongly flow-dependent.
In ensemble Kalman workflows, the **background covariance** plays a central role because it controls how observation increments propagate through the model state.

One approach developed in this work models the background covariance through an autoregressive (AR) structure that captures distance decay and flow dependence.
A representative construction is

<p class="mathjax-display">\[
\mathbf{B} = \mathbf{A}^{-1}\mathbf{S}^2\mathbf{A}^{-T},
\qquad
\delta c^{\mathrm{B}}(e) = \mathbf{A}^{-1}\mathbf{S}\,\xi(e),
\qquad
\xi(e)\sim \mathcal{N}(0,\mathbf{I}),
\]</p>

where $\mathbf{S}$ encodes spatially varying standard deviations and $\mathbf{A}$ encodes correlations (parameterized through an AR process).
This provides a computationally practical way to inject physically meaningful structure into ensemble initialization and into the implied background statistics.

In addition, the chemistry DA studies in this project analyze sensitivity to practical algorithmic choices (ensemble size, localization/inflation strength, and error sources such as emissions and boundary conditions) and explore the use of **model singular vectors** as physically motivated perturbation directions for ensemble generation.

<div class="project-media-card">
  <h3>Chemistry DA: domain, observations, and forecast impact</h3>
  <p class="project-media-card__lead">
    Examples from an idealized chemistry transport model study: the domain and observation network, and a representative forecast improvement signal after assimilation.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/data-assimilation/chem-domain-se-asia.png' | relative_url }}" alt="Chemistry assimilation domain example (SE Asia)" />
      <figcaption>Representative domain used in chemistry DA experiments.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/data-assimilation/chem-observations-network.png' | relative_url }}" alt="Observation network schematic for chemistry data assimilation" />
      <figcaption>Illustrative observation footprint/network.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/data-assimilation/chem-assimilation-impact-o3.png' | relative_url }}" alt="O3 forecast difference with assimilation compared to non-assimilated baseline" />
      <figcaption>Assimilation can reduce forecast error for observed quantities (example signal).</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/data-assimilation/chem-o3-field-example.png' | relative_url }}" alt="Field example from chemistry data assimilation study" />
      <figcaption>Field snapshot illustrating spatial structure relevant to DA.</figcaption>
    </figure>
  </div>
</div>

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>Advantages:</strong> AR-style priors provide a compact, flow-aware covariance structure that improves ensemble realism and can reduce spurious long-range correlations.</p>
  <p><strong>Limitations:</strong> covariance modeling is still approximate (especially under strong nonlinearity), and practical EnKF deployments still require careful tuning of localization, inflation, and model error representation.</p>
</div>

<h3>Selected references</h3>
<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "constantinescu-2007-assessment-of-ensemble-based-chemical-data-assimilation" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "constantinescu-2007-autoregressive-models-of-background-errors-for" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "sandu-2011-ensemble-methods-for-dynamic-data-assimilation" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

## Topic 2: Variational DA and scalable PDE-constrained inverse problems {#topic-variational-da}

In variational DA, the dominant cost often comes from repeatedly solving large linear/nonlinear systems inside an optimization method.
This motivates algorithms that reduce memory footprint and expose parallel structure in space and time.

Two representative directions in this project are:

1. **Low-memory best-state estimation** for hidden Markov models with model error, which targets large-scale inference where naive smoothing formulations become memory-prohibitive.
2. **Space-time domain decomposition for 4D-Var**, which decomposes the inference problem into coupled local subproblems, enabling scalable solvers for large regularized inverse problems.

<div class="project-media-card">
  <h3>Scalable variational DA: local solvers and domain decomposition</h3>
  <p class="project-media-card__lead">
    These two images summarize the algorithmic theme in this part of the project: break a large inverse problem into computational units that are easier to solve and coordinate.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/data-assimilation/4dvar-local-solver.jpg' | relative_url }}" alt="Nested local solver view for scalable variational data assimilation" />
      <figcaption>Nested local solvers illustrate how low-memory variational estimation can be organized around smaller optimization steps rather than one monolithic global solve.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/data-assimilation/4dvar-domain-decomposition.jpg' | relative_url }}" alt="Space-time domain decomposition for 4D-Var" />
      <figcaption>Space-time domain decomposition partitions the assimilation window into coupled local subdomains, exposing parallel structure while preserving consistency across interfaces.</figcaption>
    </figure>
  </div>
</div>

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>Advantages:</strong> variational formulations provide a principled way to incorporate dynamical constraints and correlated error models, while domain decomposition can expose parallelism and reduce memory pressure.</p>
  <p><strong>Limitations:</strong> performance hinges on high-quality linear/nonlinear solvers and preconditioners; strong nonlinearity can lead to nonconvex optimization, and adjoint/tangent-linear infrastructure remains a key requirement.</p>
</div>

<h3>Selected references</h3>
<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "d-amore-2022-a-scalable-space-time-domain-decomposition-approach" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "anitescu-2014-a-low-memory-approach-for-best-state-estimation" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "zhang-2008-an-adjoint-sensitivity-analysis-and-4d-var" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

## Topic 3: Physics-informed Gaussian processes for multi-output inference {#topic-gp-inference}

Gaussian processes (GPs) provide a flexible, nonparametric route to inference with uncertainty quantification. A key practical challenge is specifying covariance structure that is both expressive and physically meaningful, especially for **multiple outputs** (co-kriging) and for settings where some processes are hidden/unobserved.

A physics-informed approach is to define outputs through linear operators acting on a latent GP $f$.
If $y_i(x) = \mathcal{L}_i f(x)$ and $f \sim \mathcal{GP}(0,k)$, then the induced cross-covariance is

<p class="mathjax-display">\[
\mathrm{Cov}\bigl(y_i(x),y_j(x')\bigr)
= (\mathcal{L}_i)_x\,(\mathcal{L}_j)_{x'}\,k(x,x').
\]</p>

This construction preserves positive definiteness by design, while enabling covariance models that reflect physical constraints (for example, relationships between pressure and wind derived from geostrophic assumptions).

In space-time settings, GP models can also fuse deterministic numerical weather prediction (NWP) output with historical measurements to produce probabilistic forecasts and realistic scenario ensembles (with calibrated correlation structure).

<div class="project-media-card">
  <h3>Physics-informed covariance structure for multi-output GPs</h3>
  <p class="project-media-card__lead">
    The figures below move from model ingredient to model behavior: first a physics-induced cross-covariance surface, then a coupled multi-output regression example, and finally a wider space-time correlation comparison for wind scenario generation.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/data-assimilation/gp-k12-model.png' | relative_url }}" alt="Physics-informed cross-covariance surface used in a multi-output GP" />
      <figcaption>An off-diagonal cross-covariance surface $K_{12}$ induced by the governing relation between two outputs. This is often more informative than the base kernel itself because it shows how structure is transferred across variables in the coupled GP.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/data-assimilation/gp-physics-multioutput.png' | relative_url }}" alt="Multi-output GP regression example with uncertainty bands" />
      <figcaption>Multi-output GP inference with uncertainty bands. The top and bottom panels show two coupled outputs; the dashed curve is the truth, circles mark noisy observations, the dark curve with gray band is an independent fit, and the blue fit with colored band is the physics-coupled regression that transfers information across outputs.</figcaption>
    </figure>
    <figure class="project-media project-media--span-2">
      <img src="{{ '/assets/images/projects/data-assimilation/wind-covariance-comparison.png' | relative_url }}" alt="Covariance structure comparison for wind scenario modeling" />
      <figcaption>Space-time covariance comparison for wind scenario modeling. The upper-left triangular block shows empirical correlations from measurements; the fitted blocks compare the full space-time model against simplified alternatives. Diagonal blocks represent temporal correlations at each station, while off-diagonal blocks represent temporal cross-correlations between stations. The full model best preserves cross-station dependence needed for realistic scenarios.</figcaption>
    </figure>
  </div>
</div>

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>Advantages:</strong> operator-based covariance construction is interpretable and embeds physical structure directly into the statistical model.</p>
  <p><strong>Limitations:</strong> when relationships among outputs are strongly nonlinear, additional closure assumptions may be needed; and scalable GP inference may require approximations for large datasets.</p>
</div>

<h3>Selected references</h3>
<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "anitescu-2013-physics-based-covariance-models-for-gaussian-processes" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "bessac-2018-stochastic-simulation-of-predictive-space-time-scenarios" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

## Topic 4: Data-driven prediction with Gaussian processes (MJO forecasting) {#topic-mjo}

Recent work also explores GP models as a data-driven route to probabilistic forecasting of climate variability.
For the Madden--Julian Oscillation (MJO), GP models can be calibrated using empirical correlations and then corrected a posteriori to better match forecast uncertainty.
This yields both point forecasts and confidence intervals and enables diagnostic analysis of when uncertainty estimates are overconfident or miscalibrated.

In numerical experiments, this strategy improves deterministic prediction skill at short lead times and (through posterior covariance correction) substantially extends probabilistic coverage.

<div class="project-media-card">
  <h3>Gaussian process forecasting workflow (MJO)</h3>
  <p class="project-media-card__lead">
    These panels summarize three parts of the workflow: how the GP is calibrated and variance-corrected, how the RMM dataset is split into train/validation/test periods, and how deterministic and probabilistic forecast quality evolve with lead time.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media project-media--span-2">
      <img src="{{ '/assets/images/projects/data-assimilation/mjo-gp-algorithm.png' | relative_url }}" alt="Gaussian process workflow schematic for MJO prediction" />
      <figcaption>Workflow for GP-based MJO prediction. The training set is used to estimate empirical means and covariances, the validation set is used to correct posterior variance as lead time grows, and the test set is used for out-of-sample probabilistic forecasting.</figcaption>
    </figure>
    <figure class="project-media">
      <a class="project-lightbox-link" href="{{ '/assets/images/projects/data-assimilation/mjo-rmm-timeseries.png' | relative_url }}" data-lightbox-caption="RMM1 and RMM2 time series used in the study, with the long historical record partitioned into training, validation, and test windows. This split separates covariance calibration from uncertainty correction and final evaluation." target="_blank" rel="noopener">
        <img src="{{ '/assets/images/projects/data-assimilation/mjo-rmm-timeseries.png' | relative_url }}" alt="RMM1 and RMM2 time series dataset splits used for MJO forecasting" />
      </a>
      <figcaption>RMM1 and RMM2 time series used in the study, with the long historical record partitioned into training, validation, and test windows. This split separates covariance calibration from uncertainty correction and final evaluation. Click the plot to enlarge.</figcaption>
    </figure>
    <figure class="project-media">
      <a class="project-lightbox-link" href="{{ '/assets/images/projects/data-assimilation/mjo-forecast-errors.png' | relative_url }}" data-lightbox-caption="Forecast skill as a function of lead time. On the left, correlation and RMSE are shown for lag choices of 40 and 60 days against common skill thresholds; on the right, phase and amplitude errors diagnose how the GP forecast drifts and underestimates oscillation strength as lead time increases." target="_blank" rel="noopener">
        <img src="{{ '/assets/images/projects/data-assimilation/mjo-forecast-errors.png' | relative_url }}" alt="Forecast skill metrics for MJO Gaussian process model" />
      </a>
      <figcaption>Forecast skill as a function of lead time. On the left, correlation and RMSE are shown for lag choices of 40 and 60 days against common skill thresholds; on the right, phase and amplitude errors diagnose how the GP forecast drifts and underestimates oscillation strength as lead time increases. Click the plot to enlarge.</figcaption>
    </figure>
  </div>
</div>

<dialog id="project-lightbox" class="project-lightbox">
  <button type="button" class="project-lightbox__close" aria-label="Close enlarged image">Close</button>
  <img class="project-lightbox__image" alt="" />
  <p class="project-lightbox__caption"></p>
</dialog>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var dialog = document.getElementById('project-lightbox');
    if (!dialog || typeof dialog.showModal !== 'function') return;

    var image = dialog.querySelector('.project-lightbox__image');
    var caption = dialog.querySelector('.project-lightbox__caption');
    var closeButton = dialog.querySelector('.project-lightbox__close');
    var links = document.querySelectorAll('.project-lightbox-link');

    links.forEach(function (link) {
      link.addEventListener('click', function (event) {
        event.preventDefault();
        image.src = link.href;
        image.alt = link.querySelector('img') ? link.querySelector('img').alt : '';
        caption.textContent = link.getAttribute('data-lightbox-caption') || '';
        dialog.showModal();
      });
    });

    closeButton.addEventListener('click', function () {
      dialog.close();
    });

    dialog.addEventListener('click', function (event) {
      if (event.target === dialog) {
        dialog.close();
      }
    });
  });
</script>

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>Advantages:</strong> GP forecasts are probabilistic by construction and provide uncertainty estimates that can be analyzed and corrected, rather than being purely heuristic.</p>
  <p><strong>Limitations:</strong> model calibration is sensitive to covariance structure choices and stationarity assumptions; scaling to very large datasets may require sparse/approximate GP techniques.</p>
</div>

<h3>Selected references</h3>
<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "chen-2025-improving-the-predictability-of-the-madden-julian" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "chen-2023-uncertainty-quantification-of-the-madden-julian" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

## Software {#software}

<p class="home-section-intro">
  Several of the methods above are implemented and tested in production-grade scientific computing libraries.
</p>

<div class="cards cards--software">
  <article class="card software-card">
    <h3 class="card__title">DAPack</h3>
    <p class="software-card__role">Data assimilation toolkit</p>
    <p class="card__desc">Research code for UQ/DA workflows and inverse problems.</p>
    <p class="software-card__links"><a class="pub-chip" href="https://bitbucket.org/emconsta/dapack">Repository</a></p>
  </article>
  <article class="card software-card">
    <h3 class="card__title">PETSc TAO / TSAdjoint</h3>
    <p class="software-card__role">Scalable optimization + adjoints</p>
    <p class="card__desc">Nonlinear optimization and adjoint sensitivity analysis used in variational DA and PDE-constrained inversion.</p>
    <p class="software-card__links"><a class="pub-chip" href="https://petsc.org/release/">Project page</a></p>
  </article>
</div>

## Related pages

- [Projects index]({{ '/pages/projects' | relative_url }})
- [UQ &amp; data assimilation research area]({{ '/pages/data-assimilation' | relative_url }})

## Funding {#funding}

- U.S. Department of Energy, Office of Science, Office of Advanced Scientific Computing Research (ASCR) (including SciDAC programs on recent work).
- Argonne National Laboratory Directed Research and Development (LDRD) (on recent work).
- U.S. National Science Foundation, NOAA, and the Houston Advanced Research Center (on earlier chemistry DA work).
