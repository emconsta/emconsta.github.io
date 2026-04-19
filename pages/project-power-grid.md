---
layout: default
title: "Project: Power Grid and Uncertainty Quantification"
description: "Power grid project overview"
---

# Power Grid and Uncertainty Quantification

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
    This project brings together work on power-grid operations under weather and hazard uncertainty, stochastic models for inverter-based dynamics,
    adjoint-based sensitivity and inverse methods, and recent surrogate-assisted approaches to security margins and reliability.
    The common thread is that the grid should be treated as an uncertain dynamical system rather than as a single deterministic operating point.
  </p>
  <div class="project-overview__meta">
    <span class="pill">Thrust: Power grid</span>
    <span class="pill">Scope: Operations, dynamics, inference, security</span>
    <span class="pill">Methods: Stochastic optimization, adjoints, inverse problems, surrogates</span>
  </div>
</div>

<nav class="project-nav" aria-label="Power grid sections">
  <a href="#motivation">Motivation</a>
  <a href="#topic-operations">Weather-aware operations</a>
  <a href="#topic-stochastic">Stochastic models</a>
  <a href="#topic-dynamics">Dynamics and calibration</a>
  <a href="#topic-security">Security margins</a>
  <a href="#lessons">Lessons learned</a>
  <a href="#funding">Funding</a>
  <a href="#references">References</a>
</nav>

<div class="cards project-key-grid">
  <article class="card project-key-card">
    <p class="card__tag">Scientific question</p>
    <h3 class="card__title">How should uncertainty enter grid computation?</h3>
    <p class="card__desc">The work spans scheduling, dynamic simulation, calibration, and security analysis, but the same issue appears in each setting: uncertain inputs must be propagated in a way that is useful for decisions.</p>
  </article>
  <article class="card project-key-card">
    <p class="card__tag">Core idea</p>
    <h3 class="card__title">Combine physics-based models with uncertainty-aware algorithms</h3>
    <p class="card__desc">The page traces a progression from probabilistic forecast inputs, to stochastic dynamical models, to adjoint-based inference, and finally to calibrated surrogate models for fast security assessment.</p>
  </article>
  <article class="card project-key-card">
    <p class="card__tag">What visitors should learn</p>
    <h3 class="card__title">The right approximation depends on the task</h3>
    <p class="card__desc">Operations, forecasting, inverse problems, and dynamic security need different tools; the page emphasizes what each tool buys, what it misses, and why later developments became necessary.</p>
  </article>
</div>

## Motivation {#motivation}

Modern power systems are shaped by weather, hazard exposure, inverter-based resources, incomplete knowledge of dynamic parameters, and rare but consequential security events.
That makes the computational problem broader than classical steady-state analysis.
At different stages, one may need to schedule generation under uncertain wind, infer hidden model parameters from transient measurements, propagate stochastic forcing through dynamic simulations, or estimate how close the system is to a critical security boundary.
This progression, from weather-aware operations to calibrated security surrogates, is reflected in work ranging from [Constantinescu et al. (2011)](https://doi.org/10.1109/TPWRS.2010.2048133) and [Bessa et al. (2012)](https://doi.org/10.1109/TSTE.2012.2200302) to [Maldonado et al. (2022)](https://doi.org/10.1109/TPWRS.2022.3141372), [Zhao et al. (2024)](https://arxiv.org/abs/2401.02555), and [Su et al. (2026)](https://doi.org/10.1109/TPWRS.2026.3685097).

One abstract view is

<p class="mathjax-display">\[
\min_{u} \ \mathbb{E}\bigl[C(u,\xi)\bigr]
\qquad \text{subject to} \qquad
g(u,\xi) \le 0,
\]</p>

where $u$ collects control decisions and $\xi$ represents uncertain weather, hazard-driven conditions, loads, inverter-based injections, or model parameters.
The technical question is not only how to solve such problems, but how to build uncertainty models that remain informative when embedded in large dynamical and optimization workflows.

## Weather-aware operations and inverter-based integration {#topic-operations}

The earliest phase of this line of work focused on bringing weather uncertainty into grid operations in a way that mattered for decisions, not only for forecast verification.
That began with reports and conference work in 2009--2010 on exploiting weather forecasts in integrated energy systems and on the economic implications of better forecast information, and it matured into journal work on stochastic unit commitment, probabilistic wind forecasting, and cooling-constrained plant operation.
Representative papers in this phase are [Constantinescu et al. (2011)](https://doi.org/10.1109/TPWRS.2010.2048133), [Bessa et al. (2012)](https://doi.org/10.1109/TSTE.2012.2200302), and [Salazar et al. (2013)](https://doi.org/10.1016/j.apenergy.2013.05.077).

In the unit-commitment setting, the key step was to connect ensemble numerical weather prediction to stochastic scheduling.
The point was not to generate a single "best" wind forecast, but to pass a scenario-based uncertainty description into commitment and dispatch.
That is what makes the 2011 framework important in hindsight: it treats meteorology, forecast uncertainty, and power-system optimization as one pipeline rather than as disconnected tasks ([Constantinescu et al., 2011](https://doi.org/10.1109/TPWRS.2010.2048133)).

The wind-power forecasting work pushed the same lesson further.
Conditional kernel density estimation produces full predictive distributions, and the time-adaptive version matters because wind uncertainty is not stationary over the day.
Once the output is a density rather than a point, one can ask calibration and sharpness questions that are directly relevant to bidding and reserve decisions ([Bessa et al., 2012](https://doi.org/10.1109/TSTE.2012.2200302)).

The water-management work adds a different operational constraint: thermal generation is not only limited by fuel and demand, but also by environmental and cooling conditions.
That paper shows how stochastic optimization changes the operating point when weather and intake constraints are uncertain, and it broadens the meaning of "energy uncertainty" beyond variable injections alone toward wider hazard-aware operating constraints ([Salazar et al., 2013](https://doi.org/10.1016/j.apenergy.2013.05.077)).

The solar-irradiation study is a short but useful bridge in this story.
Even though it is not a power-grid dynamics paper, it reinforces the same idea: spatial information and probabilistic prediction are valuable when the end use is operational risk, not just pointwise forecast error ([Bilionis et al., 2014](https://doi.org/10.1016/j.solener.2014.09.009)).

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>What improved:</strong> these methods moved the workflow from deterministic forecasts to distributions and scenarios that can drive scheduling and bidding decisions.</p>
  <p><strong>What remained hard:</strong> early operations models still depend heavily on forecast quality, scenario design, and simplified representations of downstream dynamics. They say little by themselves about transient security or parameter uncertainty.</p>
</div>

## Stochastic uncertainty models for power systems {#topic-stochastic}

Once uncertain inverter-based injections are treated as dynamic forcing rather than as exogenous scenarios, the problem becomes one of uncertainty propagation through power-system models, as developed in [Wang et al. (2015)](https://doi.org/10.1137/130940050) and carried into operational flexibility studies such as [Li et al. (2016)](https://doi.org/10.1109/TSTE.2015.2497470).
For a stochastic dynamical system,

<p class="mathjax-display">\[
d x(t) = f(x(t), z(t))\,dt,
\qquad
d z(t) = a(z(t))\,dt + B(z(t))\,dW_t,
\]</p>

the goal is no longer only to optimize an operating point; it is to understand the evolving distribution of quantities of interest under correlated random input.

The probabilistic density function work addresses exactly this issue ([Wang et al., 2015](https://doi.org/10.1137/130940050)).
Instead of relying purely on Monte Carlo sampling, it derives and solves deterministic equations for the probability density associated with stochastic power-system dynamics.
That is useful because tail behavior and rare events are often the quantities that matter operationally, and brute-force sampling becomes expensive precisely where the interesting events are rare.

This phase also clarifies a tradeoff that shows up repeatedly later in the project.
A reduced probabilistic model can be much more efficient than sampling, but only if the closure assumptions are good enough for the quantity being tracked.
Efficiency is not free; it is paid for by modeling assumptions.

The battery-scheduling work is a natural operational extension of this stochastic viewpoint ([Li et al., 2016](https://doi.org/10.1109/TSTE.2015.2497470)).
It shows that uncertainty should not only be forecast, but also converted into flexible operating ranges and recourse decisions.
That paper does not replace the PDF-based dynamical viewpoint, but it illustrates how uncertainty quantification becomes operational value only when the control model is allowed to respond to it.

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>What improved:</strong> this stage moved from probabilistic inputs to probabilistic system response, which is the right language for reliability and risk.</p>
  <p><strong>What remained hard:</strong> reduced stochastic models still need careful closure choices and are not a substitute for scalable inference when the main uncertainty lies in poorly known parameters rather than in exogenous forcing.</p>
</div>

## Dynamics, sensitivities, and calibration {#topic-dynamics}

The next step in the project treats the power grid as a hybrid dynamical system whose behavior depends on control settings, model parameters, switching events, and observation quality, which is the setting addressed by [Zhang et al. (2017)](https://doi.org/10.1109/TCSI.2017.2651683), [Petra et al. (2017)](https://doi.org/10.1109/TPWRS.2016.2625277), [Constantinescu et al. (2020)](https://doi.org/10.1137/18M122073X), and [Attia et al. (2023)](https://arxiv.org/abs/2311.07676).
Here the central computational question changes again: if a transient-performance metric depends on many parameters, how can one differentiate, calibrate, and optimize it without paying the cost of one forward simulation per parameter?

The discrete-adjoint sensitivity work answers that question for hybrid power-system dynamics with switching ([Zhang et al., 2017](https://doi.org/10.1109/TCSI.2017.2651683)).
Its main contribution is not only an adjoint formula, but a consistent treatment of events and jump conditions so that sensitivities remain accurate for the same discrete model that is actually simulated.
That consistency is essential once sensitivities are used for optimization rather than only for diagnostics.

This work also has a software and scalability dimension.
The adjoint machinery was implemented in PETSc with checkpointing, event handling, and reusable time-stepping infrastructure, and related work on Krylov--Schwarz solvers addressed the cost of large dynamic simulations themselves ([Abhyankar et al., 2017](https://doi.org/10.1109/TSG.2016.2610863)).
That combination matters because adjoint methods are only useful in practice if the forward and backward solves scale on realistic systems.

With those ingredients in place, the project moved into dynamic inverse problems.
The Bayesian parameter-estimation work targets quantities such as generator inertias that are not observable in steady state and therefore need transient information ([Petra et al., 2017](https://doi.org/10.1109/TPWRS.2016.2625277)).
The later statistical-treatment paper generalizes this idea by using proper scoring rules for inverse problems with stochastic forward models, which is a more honest formulation when the forward output is itself a distribution ([Constantinescu et al., 2020](https://doi.org/10.1137/18M122073X)).
The most recent calibration paper pushes further toward centralized variational data assimilation for dynamic models, connecting the inference problem directly to scalable optimization methods ([Attia et al., 2023](https://arxiv.org/abs/2311.07676)).

<div class="project-media-card">
  <h3>Dynamic sensitivities and score-based calibration</h3>
  <p class="project-media-card__lead">
    The figures below illustrate the transition from sensitivity analysis to scalable inference: a reusable adjoint workflow, a transient-security sensitivity example on the 9-bus system, and a score-based inverse-identification curve that shows how parameter estimation becomes an optimization problem over uncertainty-aware objectives.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media project-media--span-2">
      <a class="project-lightbox-link" href="{{ '/assets/images/projects/power-grid/petsc-adjoint-impl.png' | relative_url }}" data-lightbox-caption="PETSc-based workflow for discrete adjoint sensitivity analysis. The forward solve checkpoints the trajectory, and the backward solve propagates adjoint variables through the same event-aware time-stepping infrastructure. This is what makes the sensitivity machinery reusable inside larger optimization and inference workflows." target="_blank" rel="noopener">
        <img src="{{ '/assets/images/projects/power-grid/petsc-adjoint-impl.png' | relative_url }}" alt="PETSc workflow for adjoint sensitivity analysis in power-system dynamics" />
      </a>
      <figcaption>PETSc-based workflow for discrete adjoint sensitivity analysis. The forward solve checkpoints the trajectory, and the backward solve propagates adjoint variables through the same event-aware time-stepping infrastructure. Click to enlarge.</figcaption>
    </figure>
    <figure class="project-media">
      <a class="project-lightbox-link" href="{{ '/assets/images/projects/power-grid/freq-9bus.png' | relative_url }}" data-lightbox-caption="A 9-bus transient-security example. The top panel shows generator frequencies after a fault, the middle panel shows accumulated frequency-violation severity, and the bottom panel shows sensitivities of that severity metric with respect to initial generator dispatch. The point is not only to monitor the transient, but to learn which control directions most strongly affect it." target="_blank" rel="noopener">
        <img src="{{ '/assets/images/projects/power-grid/freq-9bus.png' | relative_url }}" alt="Frequency violations and sensitivities on a 9-bus power-system example" />
      </a>
      <figcaption>A transient-security example on the 9-bus system: frequencies, violation severity, and sensitivities to dispatch. Click to enlarge.</figcaption>
    </figure>
    <figure class="project-media">
      <a class="project-lightbox-link" href="{{ '/assets/images/projects/power-grid/inverse-variogram-score.png' | relative_url }}" data-lightbox-caption="A score-based inverse-identification curve from the stochastic inverse-problem work. The objective is deliberately distribution-aware rather than purely pointwise; the minimum indicates the parameter region that best matches the observed distribution under the chosen score. This is the conceptual bridge from trajectory sensitivities to uncertainty-aware calibration." target="_blank" rel="noopener">
        <img src="{{ '/assets/images/projects/power-grid/inverse-variogram-score.png' | relative_url }}" alt="Variogram-score objective curve for a power-system inverse problem" />
      </a>
      <figcaption>A distribution-aware inverse objective based on the variogram score. Click to enlarge.</figcaption>
    </figure>
  </div>
</div>

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>What improved:</strong> the work moved from uncertainty propagation alone to gradient-based inference, calibration, and control on realistic dynamic models.</p>
  <p><strong>What remained hard:</strong> adjoints and variational methods require event-consistent discretizations, scalable solvers, and objectives that remain meaningful when the forward model is stochastic rather than deterministic.</p>
</div>

## Security margins, extreme trajectories, and surrogate models {#topic-security}

Recent work in this area focuses on quantities that are closer to operational security margins: short-time transient amplification, worst-case trajectories over parameter sets, failure probabilities, and load-margin constraints under dynamic line ratings, as developed in [Maldonado et al. (2022)](https://doi.org/10.1109/TPWRS.2022.3141372), [Maldonado et al. (2023)](https://arxiv.org/abs/2302.10388), [Zhao et al. (2024)](https://arxiv.org/abs/2401.02555), and [Su et al. (2026)](https://doi.org/10.1109/TPWRS.2026.3685097).

The transient-growth work begins from the observation that eigenvalues alone do not fully characterize short-time dynamic risk ([Maldonado et al., 2023](https://arxiv.org/abs/2302.10388)).
If $\delta x(t)$ is a perturbation to an operating point, the relevant quantity can be written as

<p class="mathjax-display">\[
G(t) = \max_{\lVert \delta x_0 \rVert = 1} \lVert \delta x(t) \rVert,
\]</p>

which captures the largest pre-asymptotic amplification over all admissible initial perturbations.
That perspective is useful because inverter-based systems can exhibit significant short-term growth even when asymptotic modal analysis looks benign.

The trust-region trajectory work addresses a related, but nonlinear, question: how can one compute extreme trajectories over uncertain parameter sets without relying on prohibitively large Monte Carlo ensembles ([Maldonado et al., 2022](https://doi.org/10.1109/TPWRS.2022.3141372)).
The answer is to combine sensitivity information with a trust-region optimization procedure that keeps the local approximation under control when nonlinear effects become important.
This is exactly the kind of place where the page should teach a clear pro/con lesson: local surrogates are powerful, but only if the algorithm monitors when the local model stops being trustworthy.

The most recent reliability-oriented papers continue this progression.
One estimates failure probabilities in correlated structure-preserving stochastic models, pushing uncertainty quantification closer to tail events that matter operationally ([Zhao et al., 2024](https://arxiv.org/abs/2401.02555)).
The newest work then combines multi-fidelity dynamic line rating, conformal uncertainty calibration, and learned load-margin surrogates in a real-time control setting ([Su et al., 2026](https://doi.org/10.1109/TPWRS.2026.3685097)).
The underlying idea is attractive: use data-driven models for speed, but force them to remain tied to physically meaningful security quantities such as line ratings and load margin.

<div class="project-media-card">
  <h3>Transient growth and extreme trajectories</h3>
  <p class="project-media-card__lead">
    The first figure shows why modal stability alone is not enough: the 39-bus system can exhibit substantial short-time amplification as loading increases. The second figure shows the complementary nonlinear question, where a trust-region method approximates the extreme trajectory and is compared against Monte Carlo estimates.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <a class="project-lightbox-link" href="{{ '/assets/images/projects/power-grid/caseNE-growth.png' | relative_url }}" data-lightbox-caption="Optimal transient growth for the New England 39-bus system under increasing loading. The higher-loading case shows strong pre-asymptotic amplification even though the underlying question is still framed around perturbations near an operating point. This is the main reason the work moves beyond eigenvalue-based summaries." target="_blank" rel="noopener">
        <img src="{{ '/assets/images/projects/power-grid/caseNE-growth.png' | relative_url }}" alt="Optimal transient growth for the New England 39-bus power system" />
      </a>
      <figcaption>Optimal transient growth for the 39-bus system at several loading levels. Click to enlarge.</figcaption>
    </figure>
    <figure class="project-media">
      <a class="project-lightbox-link" href="{{ '/assets/images/projects/power-grid/neweng-gen30f.png' | relative_url }}" data-lightbox-caption="Extreme generator-frequency trajectories on the New England test system. The black curve is the trust-region estimate of the minimum trajectory, and the dashed curves are Monte Carlo approximations using increasing sample counts. The figure illustrates the practical value of sensitivity-guided optimization when brute-force sampling converges slowly." target="_blank" rel="noopener">
        <img src="{{ '/assets/images/projects/power-grid/neweng-gen30f.png' | relative_url }}" alt="Trust-region extreme trajectory comparison with Monte Carlo on the New England test system" />
      </a>
      <figcaption>Trust-region trajectory estimation compared with Monte Carlo on the New England system. Click to enlarge.</figcaption>
    </figure>
  </div>
</div>

<div class="project-media-card">
  <h3>Surrogate-assisted reliability and load-margin enhancement</h3>
  <p class="project-media-card__lead">
    The recent security work uses surrogate models because the underlying continuation-power-flow and stochastic-dynamics calculations are too expensive to repeat online. The diagrams below emphasize that the surrogate is useful only because it is calibrated against physically meaningful quantities and wrapped in uncertainty estimates.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media project-media--span-2">
      <a class="project-lightbox-link" href="{{ '/assets/images/projects/power-grid/dlr-framework.png' | relative_url }}" data-lightbox-caption="Workflow for the dynamic-line-rating and load-margin enhancement pipeline. Offline modules fuse multi-fidelity line-rating data and train a load-margin surrogate; the online module evaluates real-time measurements, embeds a chance constraint, and solves the operational optimization problem. The structure is important because it makes clear where the data-driven acceleration enters and where the physics-based constraints remain." target="_blank" rel="noopener">
        <img src="{{ '/assets/images/projects/power-grid/dlr-framework.png' | relative_url }}" alt="Workflow for multi-fidelity dynamic line rating and load-margin enhancement" />
      </a>
      <figcaption>Workflow for multi-fidelity dynamic line rating and load-margin enhancement. Click to enlarge.</figcaption>
    </figure>
    <figure class="project-media">
      <a class="project-lightbox-link" href="{{ '/assets/images/projects/power-grid/dlr-load-margin.png' | relative_url }}" data-lightbox-caption="Predicted load margins with calibrated uncertainty intervals. The key point is not the specific surrogate architecture, but the fact that the prediction is probabilistic and can be used inside a chance-constrained operational workflow rather than as an unqualified point estimate." target="_blank" rel="noopener">
        <img src="{{ '/assets/images/projects/power-grid/dlr-load-margin.png' | relative_url }}" alt="Predicted load margins with calibrated uncertainty intervals" />
      </a>
      <figcaption>Load-margin prediction with calibrated uncertainty intervals. Click to enlarge.</figcaption>
    </figure>
    <figure class="project-media">
      <p class="mathjax-display">\[
\mathbb{P}\!\left(\lambda \ge \lambda_{\min}\right) \ge 1-\alpha
\]</p>
      <figcaption>Representative chance-constraint form used to connect learned load-margin estimates back to an operational security threshold.</figcaption>
    </figure>
  </div>
</div>

<div class="project-callout">
  <h3>Advantages and limitations</h3>
  <p><strong>What improved:</strong> recent work turns security analysis into quantities that are both operationally meaningful and fast enough to be embedded in decision workflows.</p>
  <p><strong>What remains hard:</strong> surrogate models only help if their uncertainty is calibrated and their outputs stay tied to physical notions of margin, failure, and feasibility. A fast but uncalibrated surrogate can be more dangerous than an expensive solver.</p>
</div>

## Lessons learned {#lessons}

<div class="project-callout">
  <h3>Lessons learned</h3>
  <p><strong>Probabilistic forecasts are more useful than point forecasts for decisions.</strong> Once the task is commitment, bidding, or reserve management, distributions and scenarios matter more than a single best guess.</p>
  <p><strong>Dynamic security is not an eigenvalue-only problem.</strong> Short-time amplification, switching events, and nonlinear trajectory extremes can dominate the behavior that matters operationally.</p>
  <p><strong>Adjoints and scalable solvers become essential as soon as inference enters the loop.</strong> Calibration and dynamic optimization are not practical without reusable sensitivity infrastructure and parallel forward/backward solves.</p>
  <p><strong>Data-driven surrogates are valuable only when they remain tied to physics-based margins.</strong> The strongest recent results use learned models for speed, but keep security quantities such as line ratings, load margins, and calibrated uncertainty intervals at the center.</p>
</div>

## Funding {#funding}

- U.S. Department of Energy, Office of Science, Office of Advanced Scientific Computing Research (ASCR) and the Scientific Discovery through Advanced Computing (SciDAC) FASTMath Institute program (FASTMath), and the SciDAC ASCR-OE (Office of Electricity) partnership.
- U.S. Department of Energy, Office of Science, Office of Advanced Scientific Computing Research (ASCR), the Applied Mathematics Program through the Competitive Portfolios Project on Energy Efficient Computing: A Holistic Methodology.

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

## Related pages

- [Projects index]({{ '/pages/projects' | relative_url }})
- [Publications]({{ '/pages/publications' | relative_url }})
- [Data assimilation project]({{ '/pages/project-data-assimilation' | relative_url }})
- [Time integration project]({{ '/pages/project-time-integration' | relative_url }})

## References {#references}

### Weather-aware operations and inverter-based integration

<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "constantinescu-2011-a-computational-framework-for-uncertainty-quantification" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "bessa-2012-time-adaptive-conditional-kernel-density-estimation" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "salazar-2013-stochastic-optimization-approach-to-water-management" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

### Stochastic uncertainty models

<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "wang-2015-probabilistic-density-function-method-for-stochastic" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

### Dynamics, sensitivities, and calibration

<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "zhang-2017-discrete-adjoint-sensitivity-analysis-of-power" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "petra-2017-a-bayesian-approach-for-parameter-estimation" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "constantinescu-2020-statistical-treatment-of-inverse-problems-constrained" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "attia-2023-centralized-calibration-of-power-system-dynamic" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>

### Security margins, reliability, and surrogate models

<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "maldonado-2022-trust-region-approximation-of-extreme-trajectories-in" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "maldonado-2023-computationally-efficient-power-system-maximum-transient" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "zhao-2024-data-driven-estimation-of-failure-probabilities-in" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "su-2026-multi-fidelity-dynamic-line-rating-fusion-for" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>
