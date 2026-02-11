---
layout: default
title: "Project: Hybrid ML-PDE for SciML"
description: "Hybrid ML-PDE project overview"
---

# SciML Project: Hybrid ML-PDE Models

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
    This project develops hybrid machine learning and PDE methods that augment coarse-grid finite element or DG solvers with learnable correction operators.
    The objective is to preserve the numerical structure of scientific simulations while improving long-horizon accuracy and computational efficiency.
  </p>
  <div class="project-overview__meta">
    <span class="pill">Thrust: Scientific machine learning</span>
    <span class="pill">Scope: Hybrid ML + PDE solvers</span>
    <span class="pill">Participants: Junoh Jung, Shinhoo Kang, Emil M Constantinescu</span>
  </div>
</div>

## Motivation

High-fidelity PDE simulations are accurate but expensive. Low-order models are efficient but often miss unresolved dynamics and accumulate rollout error.  
This project studies learned correction operators that are trained end-to-end through differentiable simulators, with the goal of improving long-horizon fidelity while preserving key numerical structure.

## Source term and weak-form correction strategies

The project explores two ways to inject learnable corrections into PDE solvers. They differ in *where the correction enters* and therefore in the tradeoff between expressivity and numerical consistency.

### Source-term correction: expressive forcing for compressible Navier-Stokes (DG)

In the discontinuous Galerkin (DG) setting for the **compressible Navier-Stokes equations**, we augment the semi-discrete evolution with a learnable source term:

<p class="mathjax-display">\[ \frac{d\mathbf{u}}{dt} = \mathcal{R}(\mathbf{u}) + \mathcal{S}_{\theta}(\mathbf{u}) \]</p>

Here $\mathbf{u}$ is a state vector of conservative variables (e.g., density, momentum, total energy), $\mathcal{R}(\mathbf{u})$ is the DG discretization of the PDE operator, and $\mathcal{S}_{\theta}(\mathbf{u})$ is a neural source term trained from data (typically from filtered/projected high-fidelity trajectories).

**Advantage (expressivity).** A source term can represent a wide class of unresolved effects because it is not restricted to a specific discretization component. This is useful when the missing physics acts like an effective closure/parameterization.

**Limitation (consistency).** A naive additive source can violate discrete invariants. In particular, if the density source has nonzero mean on elements, it can act as an artificial sink/source of mass, and long-horizon rollouts may destabilize.
To improve stability, we also study **mass-conserving source constructions** that enforce an elementwise zero-mean constraint (e.g., zeroing the constant modal coefficient of the density source so that the density source integrates to zero on each element).

### Weak-form correction: discretization-consistent operator modifications for incompressible Navier-Stokes (finite elements)

For the **incompressible Navier-Stokes equations** in a finite element framework, we use a different mechanism: rather than adding a pointwise forcing term, we modify the *variational form* (i.e., the discrete operator itself). A representative baseline weak form is:

<p class="mathjax-display">\[ \left(\partial_t \mathbf{u}_h, \mathbf{v}_h\right) + \nu \left(\nabla \mathbf{u}_h, \nabla \mathbf{v}_h\right) + c_{\mathrm{skew}}\left(\mathbf{u}_{\mathrm{adv}};\mathbf{u}_h,\mathbf{v}_h\right) - \left(p_h,\nabla\cdot \mathbf{v}_h\right) + \left(q_h,\nabla\cdot \mathbf{u}_h\right) = 0 \]</p>

and a weak-form-corrected variant augments existing terms through learned coefficient fields, e.g.:

<p class="mathjax-display">\[ \left(\partial_t \mathbf{u}_h, \mathbf{v}_h\right) + \left((\nu + \nu_t)\nabla \mathbf{u}_h, \nabla \mathbf{v}_h\right) + \left(1 + c_{\mathrm{adv}}\right)c_{\mathrm{skew}}\left(\mathbf{u}_{\mathrm{adv}};\mathbf{u}_h,\mathbf{v}_h\right) + \left(\gamma\,\nabla\cdot \mathbf{u}_h, \nabla\cdot \mathbf{v}_h\right) - \left(p_h,\nabla\cdot \mathbf{v}_h\right) + \left(q_h,\nabla\cdot \mathbf{u}_h\right) = 0 \]</p>

The fields $c_{\mathrm{adv}}(u_h)$, $\nu_t(u_h)$, and $\gamma(u_h)$ are predicted from the coarse solution (often elementwise with neighborhood context) and are bounded to maintain stability/interpretability (e.g., $\nu_t \ge 0$, $\gamma \ge 0$, and moderate advection scaling).

**Advantage (consistency).** Because the correction is applied through the same assembled bilinear forms, this approach preserves sparsity/locality, tends to remain compatible with existing linear/nonlinear solvers and preconditioners, and supports adjoint-consistent differentiation.

**Limitation (expressivity).** Weak-form corrections are intentionally structured: you choose which terms to correct and how. This can reduce the hypothesis space, but can also improve conditioning and long-horizon robustness by preventing the correction from "fighting" the discretization.

In benchmark studies, this structure can translate into better optimization behavior (lower training loss) and improved long-horizon accuracy compared with unconstrained strong-form corrections.

<div class="project-media-standalone">
  <figure class="project-media">
    <img src="{{ '/assets/images/projects/sciml-hybrid/weakform-schematic.png' | relative_url }}" alt="Element-based neighborhood model schematic for weak-form corrections" />
    <figcaption>Weak-form corrections can be parameterized elementwise with neighborhood context (schematic from project materials).</figcaption>
  </figure>
</div>

## Training 

Across both correction mechanisms, training typically minimizes rollout mismatch to projected/filter-aligned high-fidelity trajectories:

<p class="mathjax-display">\[ J(\theta) = \sum_{j=0}^{m-1} \left\lVert \tilde{\mathbf{u}}^{j+1}(\theta) - \mathcal{P}\mathbf{u}_H^{j+1} \right\rVert_2^2 \]</p>

with gradients computed by differentiating through the time integrator (e.g., neural ODE / adjoint methods for DG+source models, and discrete adjoints plus backpropagation for weak-form finite element models).

## What this project contributes 

1. Continuous-in-time neural correction operators compatible with variable-step integration.
2. Strong-form (source-term) corrections for DG discretizations of compressible flows, including conservation-aware designs.
3. Weak-form corrections that modify discrete operators in a finite element setting for incompressible flows.
4. Differentiable training pipelines that couple PDE solvers with ML frameworks for long-horizon optimization.

## Advantages and limitations

Source-term corrections (DG, compressible flows):
1. Pros: high expressivity; direct representation of missing physics; natural fit for continuous-in-time training and variable time stepping.
2. Cons: must explicitly control conservation/stability (e.g., mass); naive choices can drift and destabilize; architecture locality matters for scalability.

Weak-form corrections (finite elements, incompressible flows):
1. Pros: discretization-consistent; preserves sparsity/locality and solver structure; often better conditioned for long-horizon training.
2. Cons: reduced hypothesis space; requires choosing a structured correction parameterization and appropriate bounds/regularization.

## Gallery

<div class="project-media-card">
  <h3>Compressible Navier-Stokes (DG): Q-criterion and conservation</h3>
  <p class="project-media-card__lead">
    Q-criterion is a standard diagnostic for coherent vortical structures. The examples below illustrate how (i) hybrid corrections can improve coarse-resolution vortical structure and (ii) conservation awareness can matter for long-horizon stability.
  </p>
  <div class="project-media-grid project-media-grid--tight">
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/sciml-hybrid/re400-qv-ul.png' | relative_url }}" alt="Q-criterion visualization: low-order DG at Re=400" />
      <figcaption>3D Taylor-Green vortex: Q-criterion, low-order DG (Re=400).</figcaption>
    </figure>
    <figure class="project-media">
      <img src="{{ '/assets/images/projects/sciml-hybrid/re400-qv-uh.png' | relative_url }}" alt="Q-criterion visualization: augmented or higher-fidelity field at Re=400" />
      <figcaption>3D Taylor-Green vortex: Q-criterion, augmented / higher-fidelity field (Re=400).</figcaption>
    </figure>
    <figure class="project-media">
      <video controls muted preload="metadata">
        <source src="{{ '/assets/videos/projects/sciml-hybrid/blowup.mp4' | relative_url }}" type="video/mp4" />
      </video>
      <figcaption>Naive (nonconservative) augmentation can destabilize rollouts.</figcaption>
    </figure>
    <figure class="project-media">
      <video controls muted preload="metadata">
        <source src="{{ '/assets/videos/projects/sciml-hybrid/stable.mp4' | relative_url }}" type="video/mp4" />
      </video>
      <figcaption>Conservation-aware (mass-conserving) augmentation improves stability.</figcaption>
    </figure>
  </div>
</div>

## Related pages

- [Projects index]({{ '/pages/projects' | relative_url }})
- [Scientific machine learning]({{ '/pages/sciml' | relative_url }})
- [PDE & AMR]({{ '/pages/amr' | relative_url }})

## Funding

- U.S. Department of Energy, Office of Science, Office of Advanced Scientific Computing Research (ASCR) and the Scientific Discovery through Advanced Computing (SciDAC) FASTMath Institute program ([FASTMath](https://sites.google.com/lbl.gov/scidacfastmathinstitute/home))
- U.S. Department of Energy, Office of Science, Office of Advanced Scientific Computing Research (ASCR), the Applied Mathematics Program through the Competitive Portfolios Project on Energy Efficient Computing: A Holistic Methodology
- U.S. Department of Energy, Office of Science, Office of Advanced Scientific Computing Research (ASCR) and the Scientific Discovery through Advanced Computing (SciDAC) ASCR-BER partnership program
- Argonne Leadership Computing Facility (ALCF) Postdoctoral Fellowship

## References for deeper dive

1. Junoh Jung and Emil M Constantinescu. *Learning differentiable weak-form corrections to accelerate finite element simulations* (proceedings, 2026). [arXiv](https://arxiv.org/abs/2601.20019)
2. Shinhoo Kang and Emil M Constantinescu. *Differentiable DG with neural operator source term correction* (2025). [arXiv](https://arxiv.org/abs/2310.18897)
3. Shinhoo Kang and Emil M Constantinescu. *Enhancing low-order discontinuous Galerkin methods with neural ordinary differential equations for compressible Navier-Stokes equations* (2023). [arXiv](https://arxiv.org/abs/2310.18897v2)
4. Shinhoo Kang and Emil M Constantinescu. *Learning subgrid-scale models with neural ordinary differential equations*. Computers and Fluids, 2023. [DOI](https://doi.org/10.1016/j.compfluid.2023.105919) [arXiv](https://arxiv.org/abs/2212.09967)
