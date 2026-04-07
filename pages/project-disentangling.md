---
layout: default
title: "Project: Disentangled latent spaces"
description: "Disentangled latent spaces project overview"
---

# SciML Project: Disentangled latent spaces

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
    This project develops interpretable generative models whose latent coordinates align with known physical drivers while preserving residual variability needed for realistic scientific data.
    The same latent-space design appears in three successive developments: Aux-VAE for representation learning, DL-CFM for higher-fidelity scientific generation, and disentangled deep priors for Bayesian inverse problems.
  </p>
  <div class="project-overview__meta">
    <span class="pill">Thrust: Scientific machine learning</span>
    <span class="pill">Core idea: Guided and residual latent blocks</span>
    <span class="pill">Applications: Scientific generative modeling, cosmology, inverse problems</span>
  </div>
</div>

<nav class="project-nav" aria-label="Disentangled latent spaces sections">
  <a href="#motivation">Motivation</a>
  <a href="#idea">Basic idea</a>
  <a href="#auxvae">Aux-VAE</a>
  <a href="#dlcfm">DL-CFM</a>
  <a href="#deep-priors">Deep priors</a>
  <a href="#related-pages">Related pages</a>
  <a href="#references">References</a>
</nav>

<div class="cards project-key-grid">
  <article class="card project-key-card">
    <p class="card__tag">Scientific question</p>
    <h3 class="card__title">Can latent spaces reflect named physical factors?</h3>
    <p class="card__desc">Scientific datasets often come with some meaningful covariates, but not a complete factorization of all variability. The challenge is to align what is known without destroying generative flexibility.</p>
  </article>
  <article class="card project-key-card">
    <p class="card__tag">Core idea</p>
    <h3 class="card__title">Split the latent space into guided and residual coordinates</h3>
    <p class="card__desc">A small latent block is softly tethered to auxiliary variables, while the remaining coordinates capture unresolved or unknown structure. This gives controllability without requiring full supervision.</p>
  </article>
  <article class="card project-key-card">
    <p class="card__tag">Chronological thread</p>
    <h3 class="card__title">One design pattern, three increasingly ambitious uses</h3>
    <p class="card__desc">The project begins with disentangled representation learning, extends the same structure to higher-fidelity flow-based generation, and finally turns it into a prior for inverse problems.</p>
  </article>
</div>

## Motivation {#motivation}

Many scientific datasets contain a mix of known and unknown sources of variation.
Some physical quantities are measured or inferred and should have an interpretable role in the representation, while other mechanisms remain unmodeled or only partially understood.
Standard deep generative models often compress these effects into entangled latent coordinates, which makes sensitivity analysis, controlled generation, and posterior interpretation harder than necessary.

This project studies a simple but powerful alternative: guide part of the latent space with auxiliary variables and reserve the rest for residual variability.
That structure is useful not only for better representation learning, but also for anomaly discovery, interpretable scientific generation, and uncertainty-aware inverse problems.

## Basic idea: disentangled latent spaces {#idea}

Across the three developments, the common latent parameterization is

<p class="mathjax-display">\[
z = \bigl(z_{\mathrm{aux}}, z_{\mathrm{rec}}\bigr),
\qquad
z_{\mathrm{aux}} \mid u \sim \mathcal{N}(u, \tau^2 I),
\qquad
z_{\mathrm{rec}} \sim \mathcal{N}(0, I),
\qquad
x = G_{\theta}(z_{\mathrm{aux}}, z_{\mathrm{rec}}).
\]</p>

Here $u$ denotes auxiliary variables with direct scientific meaning.
The guided block $z_{\mathrm{aux}}$ is encouraged to align with those variables, while the residual block $z_{\mathrm{rec}}$ captures remaining variation that should not be forced into a named coordinate.
In practical terms, this makes the latent space more useful for controlled traversals, response studies, outlier detection, and Bayesian posterior summaries.

<div class="project-callout">
  <h3>What disentanglement means in this project</h3>
  <p><strong>Interpretability:</strong> changing one guided coordinate should correspond to one physical effect rather than a mixture of unrelated changes.</p>
  <p><strong>Flexibility:</strong> the residual block should still absorb unresolved structure, so the model does not become brittle or over-constrained.</p>
  <p><strong>Transferability:</strong> the same split should remain useful when moving from representation learning to flow-based generation and then to inverse problems.</p>
</div>

## Development 1: Aux-VAE {#auxvae}

The first step is <strong>Aux-VAE</strong>, which introduces the guided/residual split inside a variational autoencoder.
The model uses a conditional prior together with lightweight alignment and decorrelation penalties so that the first latent coordinates track the chosen auxiliary variables, while the remaining coordinates preserve reconstruction quality by representing unmodeled variability.

This matters because it keeps the architecture close to a standard VAE while making the latent space scientifically actionable.
Instead of only asking whether the model reconstructs well, Aux-VAE asks whether the representation can be traversed and interpreted in terms of known generative factors.
In the scientific-image experiments, this leads to clearer correspondence between selected latent coordinates and physically meaningful inputs.

<div class="project-media-card">
  <h3>Aux-VAE: interpretable traversal and factor alignment</h3>
  <p class="project-media-card__lead">
    The first figure shows that changing selected latent coordinates produces structured changes in the generated images. The second shows the intended one-to-one relationship between auxiliary variables and the first latent coordinates.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/disentangling/auxvae-latent-traversal.png' | relative_url }}" alt="Latent traversal for Aux-VAE on the scientific image dataset" />
      <figcaption>Aux-VAE latent traversals across several experimental cases. The guided block adapts to the auxiliary variables, while the residual block preserves the remaining reconstruction degrees of freedom.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/disentangling/auxvae-z-vs-u.png' | relative_url }}" alt="Scatter plots between auxiliary variables and learned Aux-VAE latent coordinates" />
      <figcaption>Scatter plots between auxiliary variables and learned latent coordinates. The goal is not full factorization of all variability, but a clean alignment of the selected coordinates with the known generating factors.</figcaption>
    </figure>
  </div>
</div>

## Development 2: DL-CFM {#dlcfm}

The second step, <strong>Disentangled Latent Conditional Flow Matching (DL-CFM)</strong>, keeps the same latent-space idea but replaces the VAE-style generator with a more expressive flow-matching model.
This addresses an important limitation of plain VAEs in scientific imaging: they can learn interpretable embeddings, but often smooth out fine structure and under-represent realistic sample variability.

In the dark-matter halo application, the guided variables are halo mass and concentration derived from thermal Sunyaev-Zel'dovich maps.
The first two latent coordinates are softly aligned with those quantities, while the residual coordinates capture remaining morphology.
That makes the latent space useful for both controlled generation and diagnostics: one can move along physically meaningful axes while also probing residual-latent tails to surface unusual halo structure and candidate outliers.

<div class="project-media-card">
  <h3>DL-CFM: physical control with higher-fidelity generation</h3>
  <p class="project-media-card__lead">
    These figures illustrate the two roles of the latent split in DL-CFM: the guided coordinates track halo mass and concentration, while the residual coordinates expose structural variability beyond those named factors.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/disentangling/dlcfm-latent-u-scatter.png' | relative_url }}" alt="Guided DL-CFM latent coordinates aligned with halo mass and concentration" />
      <figcaption>Alignment of guided latents with halo mass and concentration in DL-CFM. The goal is an interpretable low-dimensional control space, not just a compressed code.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/disentangling/dlcfm-outlier-tail.png' | relative_url }}" alt="Dark matter halo samples from residual-latent tails in DL-CFM" />
      <figcaption>Samples generated from the tail of the reconstruction-focused latent block with the guided coordinates held fixed. This helps isolate unusual morphology and supports anomaly-style diagnostics.</figcaption>
    </figure>
  </div>
</div>

## Development 3: Disentangled deep priors for inverse problems {#deep-priors}

The third development takes the same latent decomposition and uses it as a <strong>structured prior for Bayesian inverse problems</strong>.
Here the point is no longer only generation or traversal: the guided coordinates become named uncertain parameters, while the residual block carries unresolved field variability.
This turns disentanglement into a prior-design principle for inference.

In elliptic PDE inverse problems, the resulting prior supports latent-space MAP estimation and MCMC sampling while keeping posterior summaries interpretable.
Instead of a purely black-box generative prior, the posterior can be read in two layers: uncertainty in the physically meaningful auxiliary variables and uncertainty in the residual latent field.
That is useful when the goal is not merely to fit observations, but to recover a scientifically meaningful uncertainty decomposition.

<div class="project-media-card">
  <h3>Deep priors: interpretable posteriors for inverse problems</h3>
  <p class="project-media-card__lead">
    Representative source-identification results from an elliptic PDE inverse problem. The guided coordinates parameterize the dominant source characteristics, while the residual latent block captures remaining uncertainty in the reconstructed field.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/disentangling/deep-prior-source-true.png' | relative_url }}" alt="Ground-truth source field for the inverse-problem example" />
      <figcaption>Ground-truth source field used in the inverse-problem study.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/disentangling/deep-prior-source-post-mean.png' | relative_url }}" alt="Posterior mean field from the disentangled deep prior" />
      <figcaption>Posterior mean field recovered with the disentangled deep prior.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/disentangling/deep-prior-source-post-std.png' | relative_url }}" alt="Posterior standard deviation field from the disentangled deep prior" />
      <figcaption>Posterior standard deviation, showing where uncertainty remains concentrated after assimilation of the observations.</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/disentangling/deep-prior-source-data-fit.png' | relative_url }}" alt="Observed-versus-predicted data fit for the disentangled deep prior" />
      <figcaption>Observed-versus-predicted data fit. The latent prior is designed to preserve interpretability without sacrificing the ability to match measurements.</figcaption>
    </figure>
  </div>
</div>

## Related pages {#related-pages}

- [Projects index]({{ '/pages/projects' | relative_url }})
- [Scientific machine learning]({{ '/pages/sciml' | relative_url }})
- [Uncertainty quantification & data assimilation]({{ '/pages/data-assimilation' | relative_url }})

## References for deeper dive {#references}

<ul class="pub-list">
  {%- assign p = site.data.publications | where: "id", "ganguli-2025-enhancing-interpretability-in-generative-modeling-statistically" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "ganguli-2026-uncovering-physical-drivers-of-dark-matter" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
  {%- assign p = site.data.publications | where: "id", "ganguli-2026-disentangled-deep-priors-for-bayesian-inverse" | first -%}
  {%- if p -%}{%- include publication.html pub=p -%}{%- endif -%}
</ul>
