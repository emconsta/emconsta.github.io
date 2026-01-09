<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Emil Constantinescu's research: time-stepping</title>
<!--<meta http-equiv="REFRESH" content="5;url=http://www.cs.vt.edu/~emconsta">-->
<style type="text/css">
</style>
</head>

<body>
<table width="870" height="233" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="142" valign="top">
	<?php include("contents.html"); ?></td>
	
    <td width="704" valign="top"> 
    <p><a name="Top"></a>
    <u><font size=+2><span style="font-style: normal; font-weight: 700">Time Integration</span></font></u>
    </p>
    <p>Time-stepping methods are algorithms used to compute the numerical solution of ordinary differential equations as well as to evolve the solution of partial differential equations in time. This page describes three advanced techniques: general linear methods, implicit-explicit schemes, and multirate time-stepping algorithms.&nbsp;Implementations of varios algorithm is available in <a href="http://www.mcs.anl.gov/petsc/">PETSc</a> library.</p>
    <p>&nbsp;</p>
   
   <p> <span style="font-style: normal; font-weight:700"> <font size="4"> Events, presentations, notes, ...  of interes</font> </span>  </p>
   
    <ul type="square">  
     <li>Extreme-scale solvers workshop 2012 (<a href="http://science.energy.gov/~/media/ascr/pdf/program-documents/docs/reportExtremeScaleSolvers2012.pdf">pdf</a>)</li>
     <li>SIAM Presents (<a href="http://www.siam.org/meetings/presents.php">video</a>)</li>
     <li>ITER (<a href="http://www.iter.org/">link</a>)</li>
     <li>1st International Workshop on High Order CFD Methods (<a href="http://www.cfdc.iastate.edu/hiocfd.html">link</a>)</li>
     <li>Test problems <a href="http://www.dm.uniba.it/~testset/testsetivpsolvers">(http://www.dm.uniba.it/~testset/testsetivpsolvers</a>)</li>
   
    </ul>
    <p>&nbsp;</p>
      <p align="center">
      <span style="font-style: normal"><a href="#GLMDescription">GLM</a> | <a href="#IMEXDescription">IMEX</a> | <a href="#MRDescription">Multirate</a> - [<a href="#MRExample">Example</a>] | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>        
      <p>&nbsp;  </p>
      <p>
      <span style="font-style: normal; font-weight: 700"><font size="4"> <a name="GLMDescription" id="GLMDescription">General linear methods (GLMs)</a></font></span>
      </p>
      
      <p> General linear (GL) methods, under various names (e.g., hybrid methods, pseudo Runge-Kutta) represent a natural generalization of both Runge-Kutta and linear multistep methods that are aimed at improving their stability and accuracy properties while taking advantage of past precomputed information. They use both internal stages like RK methods and information from previous solution steps like LM methods.</p>
      <p align="center">
      <span style="font-style: normal"><a href="#GLMDescription">GLM</a> | <a href="#IMEXDescription">IMEX</a> | <a href="#MRDescription">Multirate</a> - [<a href="#MRExample">Example</a>] | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>      
             <p>&nbsp;</p>

      <p>
      <span style="font-style: normal; font-weight: 700"><font size="4"> <a name="IMEXDescription" id="IMEXDescription">IMplicit-EXplicit (IMEX) time stepping methods</a></font></span>
      </p>
      
      <p>
      The dynamics of a process determines the best numerical solution strategy. Explicit
time discretizations are effective for slow processes as their computational cost per step is
relatively low. On the other hand implicit methods are more efficient for fast processes
as their step sizes are not limited by stability considerations. Time integration of
multiscale processes is challenging as neither purely explicit nor purely implicit methods are
adequate. Explicit methods require prohibitively small time steps (limited by the fastest
time scale in the system). Implicit methods require the solution of (non)linear systems of
equations that involve all the processes in the model; this is both computationally expensive
and difficult to implement. The implicit-explicit (IMEX) approach has been developed to alleviate these difficulties. The IMEX idea is to combine an implicit scheme for the stiff components with an explicit scheme for the non-stiff components such that the overall discretization method has the desired stability and accuracy properties.     
        <br>
        <br>
      Below is a performance analysis of several extrapolation IMEX methods introduced in [<a href="#Constantinescu_S2008_IMEX">Constantinescu and Sandu, 2008</a>] applied to a advection-reaction problem with stiff boundary conditions. The comparison is carried among different IMEX-BDF and ARK methods of various orders. As discussed in the reference mentioned above, the extrapolation IMEX methods are easily parallelizable; therefore, a naive parallelization with OpenMP (left figure) shows that these methods can outperform the state-of-the-art BDF or Runge-Kutta IMEX schemes on a 8-core machine. [mode details are forthcoming] </p>
      <table width="674" height="65" border="0">
        <tr>
          <td width="331"><img src="Pictures/Research/ErrorAll_5_000400_010000.png" width="329" height="258"></td>
          <td width="333"><img src="Pictures/Research/ErrorAll_1_000400_010000.png" width="329" height="256"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p>    
     
 
      <p align="center">
<span style="font-style: normal"><a href="#GLMDescription">GLM</a> | <a href="#IMEXDescription">IMEX</a> | <a href="#MRDescription">Multirate</a> - [<a href="#MRExample">Example</a>] | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>     
           <p>&nbsp;</p>
      <p>
      <span style="font-style: normal; font-weight: 700"><font size="4"> <a name="MRDescription" id="MRDescription">Multirate time stepping methods</a></font></span>
      </p>
      <address>
&nbsp;
      </address>
      Hyperbolic conservation laws are of great practical importance as they
model diverse physical phenomena that appear in mechanical and chemical
engineering, aeronautics, astrophysics, meteorology and oceanography,
financial modeling, environmental sciences, etc. Representative examples
are gas  dynamics, shallow water flow, groundwater flow,  non-Newtonian
flows, traffic flows, advection and dispersion of contaminants, etc.
Conservative high resolution methods with explicit time discretization
have gained widespread popularity to numerically solve these problems.
      <p>Stability requirements limit the temporal step size, with the upper bound being determined by the ratio of the temporal and spatial meshes and the magnitude of the wave speed. Local spatial mesh refinement reduces the allowable time step for the explicit time discretizations. The time step for the entire domain is restricted by the finest mesh patch or by the highest wave velocity, and is 
        typically (much) smaller than necessary for other variables in the computational domain. </p>
      <p><b>Multirate time integration schemes</b> allow the time step to vary across the spatial domain while satisfying the CFL condition only locally, resulting in substantially more efficient overall computations.</p>   
      
      <p align="center">
      <span style="font-style: normal"><a href="#GLMDescription">GLM</a> | <a href="#IMEXDescription">IMEX</a> | <a href="#MRDescription">Multirate</a> - [<a href="#MRExample">Example</a>] | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>      
      
       <p>&nbsp;</p>
      <p>
      <span style="font-style: normal; font-weight: 700"><font size="4"> <a name="MRExample" id="MRExample">Multirate Example (1)</a></font></span></p>
      <p>
      <span style="font-style: normal">An example is given below that illustrates the 
main idea of<b> multirate</b> and <a href="AMR.html">AMR</a>. The 2D simulation 
models the transport of a (power plant) plume in the atmosphere (1 km mixing 
layer) with an Eastern wind (5 m/s) and a turbulent diffusivity of 100 m<sup>2</sup>/s. 
The simulation is run for 6 hours. The power plant is turned off and the plume 
dynamics is simulated for another six hours. Note how the fine grid resolution 
follows the features of the solution. Such an algorithm that dynamically adapts 
the grid for large scale models is presented in [<a href="#Constantinescu_A2008a">Constantinescu 
et al. 2007; Comp. Geosci.</a>]. The fine resolution accurately resolves the 
fine features of the solution. In order to efficiently implement this <a href="AMR.html">AMR</a> approach, different time steps should be used for 
different resolutions: large time steps for coarse resolutions and small 
time steps for fine resolutions resulting in <b>multirate</b> algorithms. 
Examples of such algorithms are found in [<a href="#Constantinescu_A2007e">Constantinescu 
et al. 2007; Sci. Comp.</a>] or [<a href="#Sandu_A2007">Sandu 
et al. 2007; Sci. Comp.</a>]</span>
      </p>
      <p>
      <img border="0" src="Movies/Case_242.gif">
      </p>
       
      <p align="center">
      <span style="font-style: normal"><a href="#GLMDescription">GLM</a> | <a href="#IMEXDescription">IMEX</a> | <a href="#MRDescription">Multirate</a> - [<a href="#MRExample">Example</a>] | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>   
      
     <p>&nbsp;</p>
      <p>
      <span style="font-style: normal; font-weight:700"><font size="4"><a name="Publications" id="Publications">Selected journal publications, 
  proceedings, presentations</a></font></span>
      </p>
      <p>
      <span style="font-style: normal; font-weight:700"><font size="4"> &nbsp;&nbsp;&nbsp; <a name="Journals" id="Journals">Journal</a> publications:</font></span></p>

      <ul type="square"> 
      <li><a href="https://arxiv.org/pdf/2303.17019.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> 
<a href="https://doi.org/10.1016/j.jcp.2024.112954"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>
Johann Rudi, Max Heldman, Emil M. Constantinescu, Qi Tang, and Xian-Zhu Tang,
 <b>&quot;<strong>Scalable implicit solvers with dynamic mesh adaptation for a relativistic drift-kinetic Fokker-Planck-Boltzmann model</strong>.&quot;</b>  
  <em>Journal of Computational Physics</em>, Vol. 507, Pages 112954, DOI: 10.1016/j.jcp.2024.112954, 2024.
  [<a href="https://arxiv.org/abs/2303.17019">https://arxiv.org/abs/2303.17019</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>


      <li><a href="https://arxiv.org/abs/2310.18897v2"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a>
<!-- <a href="https://doi.org/10.1016/j.compfluid.2023.105964"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> -->
  Shinhoo Kang and Emil M. Constantinescu,
  <b>&quot;<strong>Enhancing Low-Order Discontinuous Galerkin Methods with Neural Ordinary Differential Equations for Compressible Navier--Stokes Equations</strong>.&quot;</b> 
    <!-- <em>Computers &amp; Fluids</em>,--> Submitted, <!-- DOI: https://doi.org/10.1016/j.compfluid.2023.105964, --> 2023.
    [<a href="https://arxiv.org/abs/2310.18897">https://arxiv.org/abs/2310.18897v2</a>]
    <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
  </li>

<li><a href="https://arxiv.org/abs/2202.11890"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a>
<a href="https://doi.org/10.1016/j.compfluid.2023.105964"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>  
  Shinhoo Kang, Alp Dener, Aidan Hamilton, Hong Zhang, Emil M. Constantinescu, and Robert Jacob,
  <b>&quot;<strong>Multirate Partitioned Runge-Kutta Methods for Coupled Navier-Stokes Equations</strong>.&quot;</b> 
    <em>Computers &amp; Fluids</em>, Volume 264 (15), DOI: https://doi.org/10.1016/j.compfluid.2023.105964, 2023.
    [<a href="https://arxiv.org/abs/2202.11890">https://arxiv.org/abs/2202.11890</a>]
    <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
  </li>

<li>
<a href="https://arxiv.org/abs/2212.09967"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> 
<a href="https://doi.org/10.1016/j.compfluid.2023.105919"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>
Shinhoo Kang and Emil M. Constantinescu,
 <b>&quot;<strong>Learning subgrid-scale models with neural ordinary differential equations</strong>.&quot;</b>  
  <em>Computers and Fluids, In Press</em>, Vol. 261, Pages 105919, DOI: 10.1016/j.compfluid.2023.105919.
  [<a href="https://arxiv.org/abs/2212.09967">https://arxiv.org/abs/2212.09967</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>



<li><a href="https://arxiv.org/pdf/2302.10388.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> 
<!--<a href="https://doi.org/10.1007/s10915-022-01982-w"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>-->
Daniel Adrian Maldonado, Emil M. Constantinescu, Junbo Zhao, and Mihai Anitescu,
 <b>&quot;<strong>Computationally efficient power system maximum transient linear growth estimation</strong>.&quot;</b>  
  <em>Submitted</em>, <!--Vol. 93(23), DOI: 10.1007/s10915-022-01982-w,--> 2023.
  [<a href="https://arxiv.org/abs/2302.10388">https://arxiv.org/abs/2302.10388</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>



<li>
<a https://arxiv.org/pdf/2211.16718.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> 
<a href="https://doi.org/10.1016/j.compfluid.2022.105744"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> 
Youngdae Kim, Debojyoti Ghosh, Emil Constantinescu, and Ramesh Balakrishnan,
 <b>&quot;<strong>GPU-Accelerated WENO schemes for the DNS of compressible turbulent flows</strong>.&quot;</b> 
  <em>Computers & Fluids</em>, Vol 251, Pages 105744, 2023.
  (DOI: 10.1016/j.compfluid.2022.105744). 
  [<a href="https://arxiv.org/abs/2211.16718">https://arxiv.org/abs/2211.16718</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>


<li>
<a href="https://arxiv.org/pdf/2106.13879"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a>
<a href="https://doi.org/10.1016/j.jocs.2022.101913"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> 
Hong Zhang and Emil M. Constantinescu,
 <b>&quot;<strong>Optimal checkpointing for adjoint multistage time-stepping schemes</strong>.&quot;</b> 
  <em>Journal of Computational Science</em>, Vol 366, 101913, (DOI: 10.1016/j.jocs.2022.101913).
  [<a href="https://arxiv.org/abs/2106.13879">https://arxiv.org/abs/2106.13879</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>


<li>
<a https://arxiv.org/pdf/2112.10568"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> 
<a href="https://doi.org/10.1016/j.aml.2021.107871"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> 
Emil Constantinescu,
 <b>&quot;<strong>Implicit extensions of an explicit multirate Runge–Kutta scheme</strong>.&quot;</b> 
  <em>Applied Mathematics Letters</em>, Vol 128, Pages 107871, 2022.
  (DOI: 10.1016/j.aml.2021.107871). 
  [<a href="https://arxiv.org/abs/2112.10568">https://arxiv.org/abs/2112.10568</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>

<li><a href="https://arxiv.org/pdf/2106.16132"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a>
<a href="https://doi.org/10.1109/TPWRS.2022.3141372"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> 
Adrian Maldonado, Emil M. Constantinescu, Hong Zhang, Vishwas Rao, and Mihai Anitescu,
 <b>&quot;<strong>Trust-region approximation of extreme trajectories in power system dynamics</strong>.&quot;</b> <em> IEEE Transactions on Power Systems </em>, Vol 37(5), Pages 3937-3946, 2022.
  [<a href="https://arxiv.org/abs/2106.16132">https://arxiv.org/abs/2106.16132</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>

<li><a href="https://arxiv.org/pdf/2108.08908"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> 
<a href="https://doi.org/10.1007/s10915-022-01982-w"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>
Shinhoo Kang and Emil M. Constantinescu,
 <b>&quot;<strong>Entropy-preserving and entropy-stable relaxation IMEX and multirate time-stepping methods</strong>.&quot;</b>  
  <em>Journal of Scientific Computing</em>, Vol. 93(23), DOI: 10.1007/s10915-022-01982-w, 2022.
  [<a href="https://arxiv.org/abs/2108.08908">https://arxiv.org/abs/2108.08908</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>

<li><!--<a href="https://arxiv.org/pdf/2112.07856.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> 
 <a href="https://doi.org/10.1016/j.cma.2021.113988"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> -->
Hong Zhang, Zhengyu Liu, Emil M. Constantinescu, and Robert Jacob
 <b>&quot;<strong>Stability Analysis of Coupled Advection-Diffusion Models with Bulk Interface Condition</strong>&quot;</b>
 <em> Journal of Scientific Computing </em>, Vol 93(33), DOI: 10.1007/s10915-022-01983-9, 2022.
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>

<li><a href="https://arxiv.org/pdf/2205.04386.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a>
<a href="https://doi.org/10.1557/s43579-022-00273-7"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> 
Alina Kononov, Cheng-Wei Lee, Tatiane Pereira dos Santos, Brian Robinson, Yifan Yao, Yi Yao, Xavier Andrade, Andrew David Baczewski, Emil Constantinescu, Alfredo Correa, Yosuke Kanai, Norman Modine, and Andre Schleife, 
 <b>&quot;<strong>Electron dynamics in extended systems within real-time time-dependent density functional theory, </strong>&quot;</b>  
 <em>MRS Communications</em>, Pages 1-13, DOI: 10.1557/s43579-022-00273-7, 2022.
 [<a href="https://arxiv.org/abs/2205.04386">https://arxiv.org/abs/2205.04386</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>

<li><!--<a href="https://arxiv.org/pdf/2112.07856.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> -->
 <a href="https://doi.org/10.1007/s10915-022-01826-7"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> 
 Luisa D'amore, Emil Constantinescu, and Luisa Carracciuolo,
 <b>&quot;<strong>A scalable space-time domain decomposition approach for solving large scale non linear regularized inverse ill posed problems in 4D Variational Data Assimilation, </strong>&quot;</b> 91(59), 
 <em>Springer Journal of Scientific Computing</em>, 2022.
  <!--[<a href="https://arxiv.org/abs/2101.09263">https://arxiv.org/abs/2101.09263</a>]-->
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>




<li><a href="https://arxiv.org/abs/2101.09263"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> 
<a href="https://doi.org/10.1016/j.cma.2021.113988"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> 
Shinhoo Kang, Emil M. Constantinescu, Hong Zhang, and Robert Jacob,
 <b>&quot;<strong>Mass-Conserving Implicit-Explicit Methods for Coupled Compressible Navier-Stokes Equations</strong>.&quot;</b> 
  <em>Computer Methods in Applied Mechanics and Engineering (CMAME)</em>, Vol 384, pp. 113988, 2021, (DOI: 10.1016/j.cma.2021.113988). 
  [<a href="https://arxiv.org/abs/2101.09263">https://arxiv.org/abs/2101.09263</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>


<li>
<a href="https://doi.org/10.1137/21M140078X"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>
  <a href="https://arxiv.org/abs/1912.07696.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a>
   Hong Zhang, Emil M. Constantinescu, and Barry F. Smith, <b>&quot;<strong>PETSc TSAdjoint: a discrete adjoint ODE solver for first-order and second-order sensitivity analysis</strong>.&quot;</b> 
   <em>SIAM Journal of Scientific Computing</em>, Vol 44, Pages C1-C24, 2022.
 [<a href="https://arxiv.org/abs/1912.07696">https://arxiv.org/abs/1912.07696</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>

<li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
<a href="https://doi.org/10.1007/s10915-020-01293-y"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>
<a href="https://arxiv.org/pdf/1909.00916.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a>
 Hong Zhang, Zhengyu Liu, Emil M. Constantinescu, and Robert Jacob, 
<b>&quot;<strong>Stability analysis of interface conditions for ocean-atmosphere coupling</strong>.&quot;</b> 
<em>Springer Journal of Scientific Computing</em>, Vol. 84 (44), 2020. 
[<a href="https://arxiv.org/abs/1909.00916">https://arxiv.org/abs/1909.00916</a>]</p>
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>
      
      <li>Valeria Mele, Emil M. Constantinescu, Luisa Carracciuolo, and Luisa D'Amore, <b>&quot;A PETSc parallel-in-time solver based on MGRIT algorithm.&quot;</b>  Submitted, Concurrency and Computation: Practice and Experience, 2018.
        <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
  
      <li><a href="https://arxiv.org/pdf/1806.01437"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Shrirang Abhyankar, Jed Brown, Emil M. Constantinescu, Debojyoti Ghosh*, Barry F. Smith and Hong Zhang*, <b>&quot;<strong>PETSc/TS: A modern scalable ODE/DAE solver library.&quot;</strong></b>  Submitted, 2018. [<a href="https://arxiv.org/abs/1806.01437">https://arxiv.org/abs/1806.01437</a>]
        <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>

 <li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="https://doi.org/10.1016/j.advwatres.2018.02.003"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a href="http://arxiv.org/abs/1607.04547"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Simone Marras, Michal A. Kopera, Emil M. Constantinescu, Jenny
  Suckale, and Francis X. Giraldo <b>&quot;<strong>A residual-based shock capturing scheme for the continuous/discontinuous spectral element solution of the 2D shallow water equations</strong>.&quot; </b>Vol. 114, Pages 45-63, 2018. [<a href="http://arxiv.org/abs/1607.04547">http://arxiv.org/abs/1607.04547</a>]</p>
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
 
<li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="http://dx.doi.org/10.1016/j.cam.2017.05.012"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a href="http://arxiv.org/abs/1503.05166"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Emil Constantinescu, <b>&quot;Generalizing global error estimation for ordinary differential equations by using coupled time-stepping methods.&quot;</b> Journal of Computational and Applied Mathematics, Vol 332(C), Pages 140-158, 2018.  (<a href="https://arxiv.org/abs/1503.05166">https://arxiv.org/abs/1503.05166</a>) </p>
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>
 
 
<li><!--<a href="bib.php#Abhyankar_P2013" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a href="http://dx.doi.org/10.1145/2536780.2536784"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a target="_blank" href="Repository/Papers/Abhyankar_P2013.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a>-->
  <span style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="http://dx.doi.org/10.1109/TSG.2016.2610863"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a href="http://ieeexplore.ieee.org/xpl/articleDetails.jsp?arnumber=7736993&source=authoralert"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a></span> Shrirang Abhyankar,  Emil M. Constantinescu, Barry Smith, Alexander J. Flueck, and Daniel A. Maldonado <b>&quot;<strong>Parallel dynamics simulation using a Krylov-Schwarz linear solution scheme</strong>.&quot; </b>IEEE Transactions on Smart Grid Special Issue on High Performance Computing (HPC) Applications for a More Resilient and Efficient Power Grid, Vol. 8(3), Pages 1378-1386, 2017.
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>

<li>
  <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="http://dx.doi.org/10.1109/TCSI.2017.2651683"> <img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a href="Repository/Papers/TCASI_DASA_sm.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> 	Hong Zhang*, Shrirang S. Abhyankar, Emil M. Constantinescu, and Mihai Anitescu, <b>&quot;<strong>Discrete adjoint sensitivity analysis of power system dynamics</strong>.&quot; </b>IEEE Transactions on Circuits and Systems--I: Regular Papers, Vol. 64(5), Pages 1247-1259, 2017.</p>
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>

<li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="http://dx.doi.org/10.1109/TPWRS.2016.2625277"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a target="_blank" href="http://arxiv.org/abs/1601.07448"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Noemi Petra, Cosmin G. Petra, Zheng Zhang*, Emil M. Constantinescu, and Mihai Anitescu, <b>&quot;<strong>A Bayesian approach for parameter estimation with uncertainty for dynamic power systems</strong>.&quot; </b>IEEE Transactions on Power Systems, Vol. 32(4), Pages 2735-2743, 2017.</p>
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
 

     
<li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="http://www.mcs.anl.gov/papers/ANL/MCS-TM-352.pdf"></a> <a href="bib.php#Ghosh_2015b" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a>
       <a href="http://dx.doi.org/10.1137/15M1044369"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>
<!-- <a href="http://dx.doi.org/"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a href=""><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> -->
      <!-- <a href="http://dx.doi.org/10.1137/130940050"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>--> 
      <a href=" http://arxiv.org/abs/1510.05751"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Debojyoti Ghosh* and Emil M. Constantinescu, <b>&quot;Semi-implicit time integration of atmospheric flows with characteristic-based flux partitioning.&quot;</b>  SIAM Journal on Scientific Computing (SISC), Vol. 38(3), Pages A1848-A1875, 2016. [Preprint # ANL/MCS-P5417-1015;<a href="http://arxiv.org/abs/1510.05751"> http://arxiv.org/abs/1510.05751</a>].</p>
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>

<li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="http://www.mcs.anl.gov/papers/ANL/MCS-TM-352.pdf"></a> <a href="bib.php#Ghosh_2015a" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a>
       <!-- <a href="http://dx.doi.org/"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a href=""><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> -->
      <!-- <a href="http://dx.doi.org/10.1137/130940050"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>--> <a href="Repository/Papers/Ghosh_2015a.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Debojyoti Ghosh* and Emil M. Constantinescu, <b>&quot;A well-balanced conservative finite-difference algorithm for atmospheric flows.&quot;</b> AAIA Journal, Accepted, 2015. [Preprint # ANL/MCS-P5371-0615].</p>
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>

<li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#Ghosh_S2014a" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a href="http://dx.doi.org/10.1137/140989261 "><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a target="_blank" href="Repository/Papers/Ghosh_S2014a-preprint.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Debojyoti Ghosh*, Emil M. Constantinescu, and Jed Brown, <b>&quot;Efficient implementation of non-linear compact schemes on massively-parallel platforms.&quot;</b> SIAM Journal on Scientific Computing (SISC), Vol. 37(3), Pages C354-C383, 2015. -&gt;<span style="margin-top: 4"> <a target="_self" href="bib.php#Ghosh_TR2014a"> <img border="0" src="Pictures/icons_bib.jpg" width="18" height="19"></a></span> <a target="_blank" href="Repository/Papers/Ghosh_TR2014a.pdf"><img border="0" src="Pictures/icons_pdf.jpg" width="18" height="19"></a> Technical report version.</p>
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
     

      
      <li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#Giraldo_S2012a" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a target="_blank" href="Repository/Papers/Giraldo_et_al_SISC_2013_Final.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Francis X Giraldo, James F. Kelly, and Emil Constantinescu, <b>&quot;<strong>Implicit-explicit formulations of a three-dimensional nonhydrostatic unified model of the atmosphere (NUMA)</strong>.&quot;</b> SIAM Journal on Scientific Computing (SISC), In press, Preprint #  ANL/MCS-P2083-0512, 2013.</p>
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
     
             <li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#Constantinescu_S2010" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a href="http://dx.doi.org/10.1007/s10915-012-9662-z"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a target="_blank" href="Repository/Papers/MRExtrap_Preprint.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Emil M. Constantinescu and Adrian Sandu, <b>&quot;Extrapolated multirate methods for differential equations with multiple time scales.&quot;</b> Journal of 
Scientific Computing, Vol. 56(1), pp 28-44, 2013. 
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;</p>
     	</li>
         <li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#KeyesMcInnesWoodwardEtAl13" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a href="http://dx.doi.org/10.1177/1094342012468181"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> David E. Keyes, Lois Curfman McInnes, Carol Woodward, William Gropp, Eric Myra, Michael Pernice,
John Bell, Jed Brown, Alain Clo, Jeffrey Connors, Emil Constantinescu, Don Estep, Kate Evans,
Charbel Farhat, Ammar Hakim, Glenn Hammond, Glen Hansen, Judith Hill, Tobin Isaac, Xiaomin Jiao, Kirk Jordan,
Dinesh Kaushik, Efthimios Kaxiras, Alice Koniges, Kihwan Lee, Aaron Lott, Qiming Lu, John Magerlein,
Reed Maxwell, Michael McCourt, Miriam Mehl, Roger Pawlowski, Amanda Peters Randles, Daniel Reynolds, 
Beatrice Rivi&#232;re, Ulrich R&#252;de, Tim Scheibe, John Shadid, Brendan Sheehan, Mark Shephard, Andrew Siegel, 
Barry Smith, Xianzhu Tang, Cian Wilson, and Barbara Wohlmuth <b>&quot;Multiphysics Simulations: Challenges and Opportunities.&quot;</b> International Journal of High Performance Computing Applications, 27(1): 4-83, 2013. 
     --&gt;&gt; Tech Report verion: <a target="_blank" href="Repository/Papers/72183.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;</p>
     	</li>
 
      <li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#Keyes_TR2011" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a target="_blank" href="Repository/Papers/72183.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> D.E. Keyes, L.C. McInnes, C. Woodward, W.D. Gropp, E. Myra, M. Pernice, J. Bell, J. Brown, A. Clo, J. Connors, E. Constantinescu, D. Estep, K. Evans, C. Farhat, A. Hakim, G. Hammond, G. Hansen, J. Hill, T. Isaac, X. Jiao, K. Jordan, D. Kaushik, E. Kaxiras, A. Koniges, K. Lee, A. Lott, Q. Lu, J. Magerlein, R. Maxwell, M. McCourt, M. Mehl, R. Pawlowski, A. Peters, D. Reynolds, B. Rivi&#232;re, U. R&#252;de, T. Scheibe, J. Shadid, B. Sheehan, M. Shephard, A. Siegel, B. Smith, X. Tang, C. Wilson, B. Wohlmuth, <b>&quot;Multiphysics Simulations: Challenges and Opportunities.&quot; </b> Tech. Rep. ANL/MCS-TM-321, Revision 1.1, October 2012, Argonne National Laboratory. <a href="https://sites.google.com/site/icismultiphysics2011">ICiS Multiphysics 2011 Workshop Report</a>, Park City, Utah, July 30 - August 6, 2012. To appear as a special issue of the International Journal of High Performance Computing Applications.</p>
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
     

<li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#Constantinescu_S2009a" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a target="_blank" href="http://dx.doi.org/10.1137/090766206"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a target="_blank" href="Repository/Papers/Constantinescu_A2010b.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Emil M. Constantinescu and Adrian Sandu, <b>&quot;Optimal strong-stability-preserving general linear methods.&quot;</b> SIAM  Journal of 
     Scientific Computing, Vol. 32(5), Pages 3130-3150, 2010. -&gt; <a target="_blank" href="Repository/Papers/GenLinReport.pdf"> <img border="0" src="Pictures/icons_pdf.jpg" width="18" height="19"></a> <span style="margin-top: 4"> <a target="_self" href="bib.php#Constantinescu_TR2009a"> <img border="0" src="Pictures/icons_bib.jpg" width="18" height="19"></a></span>  Technical report with complete results.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>


 <li><a name="Constantinescu_S2008_IMEX"></a> 
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#Constantinescu_S2008b" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a target="_blank" href="http://dx.doi.org/10.1137/080732833"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a target="_blank" href="Repository/Papers/Constantinescu_2010a.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Emil M. Constantinescu and Adrian Sandu, <b>&quot;Extrapolated  implicit-explicit time stepping.&quot;</b>  Vol. 31(6), Pages 4452-4477, SIAM Journal of 
     Scientific Computing, 2010. -&gt; <a target="_blank" href="Repository/Papers/TM-306.pdf"> <img border="0" src="Pictures/icons_pdf.jpg" width="18" height="19"></a> <span style="margin-top: 4"> <a target="_self" href="bib.php#Constantinescu_TR2009b"> <img border="0" src="Pictures/icons_bib.jpg" width="18" height="19"></a></span> Technical report version.</p>
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
     
 <li>
   <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#Constantinescu_A2009b" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a>    <a target="_blank" href="http://dx.doi.org/10.1016/j.aml.2008.12.005"><img border="0" src="Pictures/icons_doi.jpg" width="24" height="27"></a> Emil M. Constantinescu, <b>&quot;On the order of general linear methods.&quot;</b>     Vol. 22(9), Pages 1425-1428, Applied Mathematics Letters, 2009. -&gt; <a target="_blank" href="Repository/Papers/GLMOrder.pdf"> <img border="0" src="Pictures/icons_pdf.jpg" width="18" height="19"></a> <span style="margin-top: 4"> <a target="_self" href="bib.php#Constantinescu_TR2008c"> <img border="0" src="Pictures/icons_bib.jpg" width="18" height="19"></a></span> Technical report version  [ANL/MCS-P1555-1008, Oct 2008].</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
   
   
     
 <li><a name="Sandu_A2007"></a>
   <p style="line-height: 125%; margin-top: 4; margin-bottom:0">
     <a href="bib.php#Sandu_A2007" target="_self">
       <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a target="_blank" href="http://dx.doi.org/10.1007/s10915-008-9235-3">
<img border="0" src="Pictures/icons_doi.jpg" width="24" height="27"></a> Adrian Sandu and Emil M. Constantinescu, <b>&quot;Multirate explicit Adams methods for time integration of conservation laws.&quot;</b>    Vol. 38(2), Pages 229-249, Journal of 
     Scientific Computing, 2009. -&gt; <a target="_blank" href="http://eprints.cs.vt.edu/archive/00000989/01/mradams.pdf">
     <img border="0" src="Pictures/icons_pdf.jpg" width="18" height="19"></a> <a target="_self" href="bib.php#Constantinescu_TR2007b"> <img border="0" src="Pictures/icons_bib.jpg" width="18" height="19"></a> Technical report version.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
     
 <li><a name="Constantinescu_A2008a"></a>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
<a target="_self" href="bib.php#Constantinescu_A2008a">
<img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a target="_blank" href="Repository/Papers/amr_aqm.pdf"> 
<img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a>
<a target="_blank" href="http://dx.doi.org/10.1007/s10596-007-9065-7">
<img border="0" src="Pictures/icons_doi.jpg" width="24" height="27"></a> Emil M. Constantinescu, Adrian Sandu, and Gregory R. Carmichael, <b>&quot;Modeling atmospheric chemistry and transport with dynamic adaptive resolution.&quot;</b>   Vol. 12(2), Pages 133-151, 
Computational Geosciences, 2008.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>  	

 	<li><a name="Constantinescu_A2007e"></a>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
<a target="_self" href="bib.php#Constantinescu_A2007e">
<img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> 
<a target="_blank" href="http://dx.doi.org/10.1007/s10915-007-9151-y">
<img border="0" src="Pictures/icons_doi.jpg" width="24" height="27"></a> Emil M. Constantinescu and Adrian Sandu, <b>&quot;Multirate timestepping 
methods for hyperbolic conservation laws.&quot;</b> Vol. 33(3), Pages 239-278, Journal of 
Scientific Computing, 2007. -&gt;<a target="_blank" href="http://eprints.cs.vt.edu/archive/00000955/01/TR_07_12_MRK.pdf"> <img border="0" src="Pictures/icons_pdf.jpg" width="18" height="19"></a> <a target="_self" href="bib.php#Constantinescu_TR2006d"> <img border="0" src="Pictures/icons_bib.jpg" width="18" height="19"></a> Technical report version.</p> </li> 
</ul>

 
      <p align="center">
<span style="font-style: normal"><a href="#GLMDescription">GLM</a> | <a href="#IMEXDescription">IMEX</a> | <a href="#MRDescription">Multirate</a> - [<a href="#MRExample">Example</a>] | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>     
           <p>&nbsp;</p>
      <p>
      <a name="Proceedings"><span style="font-style: normal; font-weight:700"><font size="4"> &nbsp;&nbsp;&nbsp; </font></span><span style="font-style: normal; font-weight:700"><font size="4"> Proceedings/Presentations/</font></span><font size="4"><span style="font-style: normal; font-weight:700">Posters</span></font></a><font size="4"><span style="font-style: normal; font-weight:700">:</span></font>
      </p>
      <ul  type="square"> 

<li>
     <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#Ghosh_P2014a" target="_self">
     <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a href="http://dx.doi.org/10.1007/978-3-319-19800-2_20">
     <img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>
      <a target="_blank" href="Repository/Papers/Ghosh_P2014-preprint.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> Debojyoti Ghosh* and Emil M. Constantinescu, <b>&quot;Nonlinear compact finite-difference schemes with semi-implicit time stepping.&quot;</b>Springer's Lecture Notes in Computational Science and Engineering (LNCSE) Series, ICOSAHOM 2014, Vol. 106, Pages 237-245, 2015.</p>
     <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>



<li><a href="bib.php#Abhyankar_P2013" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a href="http://dx.doi.org/10.1145/2536780.2536784"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a target="_blank" href="Repository/Papers/Abhyankar_P2013.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a>  Shrirang Abhyankar*, Barry Smith, and Emil M. Constantinescu, <b>&quot;Evaluation of overlapping restricted additive Schwarz preconditioning for parallel solution of very large power flow problems.&quot;</b> Proceedings of the<a href="http://gridoptics.pnnl.gov/sc13"> 3rd International Workshop on High Performance Computing, Networking and Analytics for the Power Grid</a>, pp 5:1-5:8, 2013.
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
     
          <li>
  <p style="line-height: 125%; margin-top: 4; margin-bottom:0"> <em>Emil M. Constantinescu</em>, <b>&quot;High Order Partitioned Time Stepping Methods for Stiff Problems&quot; </b>at SIAM Computational Science and Engineering (CS&amp;E) (<a href="http://www.siam.org/meetings/cse13">SIAM CSE13</a>), Boston, MA, Feb 25 - Mar 1, 2013.</p> 
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li> 
      <li>
  <p style="line-height: 125%; margin-top: 4; margin-bottom:0"> <em>Emil M. Constantinescu</em>, <b>&quot;Consistency and stability considerations for implicit-explicit additive splittings&quot; </b>at SIAM Annual Meeting (<a href="http://www.siam.org/meetings/an12">SIAM AN12</a>), Minneapolis, MN, July 9-13, 2012.</p> 
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>
      <li>
   <p style="line-height: 125%; margin-top: 4; margin-bottom:0"> <a target="_blank" href="Repository/Papers/Smith_TR2012a.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> <a href="bib.php#Smith_TR2012a" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Barry Smith, Lois Curfman McInnes, Emil Constantinescu, Mark Adams, Satish Balay, Jed Brown, Matthew Knepley, and Hong Zhang, <b>&quot;PETSc's Software Strategy for the Design Space of Composable Extreme-Scale Solvers.&quot;</b> (Preprint # ANL/MCS-P2059-0312) DOE Exascale Research Conference, April 16-18, 2012, Portland, OR, 2012.</p>
   <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>

   
     <li>
  <p style="line-height: 125%; margin-top: 4; margin-bottom:0">Emil M. Constantinescu and Adrian Sandu, <b>&quot;Multirate explicit SSP methods for hyperbolic PDEs&quot; </b> in Time Discretizations for the Evolution of Time-dependent PDEs mini-symposium; SIAM Annual Meeting (AN10), Pittsburgh, PA, July 13, 2010.</p> 
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>
<li>
  <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a target="_blank" href="http://dx.doi.org/10.1063/1.3241354"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> <a target="_self" href="bib.php#Constantinescu_PA2009b"><img src="Pictures/icons_bib.jpg" alt="" width="24" height="27" border="0"></a> Adrian Sandu and Emil M. Constantinescu, <b>&quot;Multirate time discretizations for hyperbolic partial differential equations.&quot; </b>International Conference of Numerical Analysis and Applied Mathematics  (ICNAAM 2009), Crete, Greece, 18-22 September; Vol. 1168(1), pp. 1411-1414, 2009.</p> 
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>
<li>
  <p style="line-height: 125%; margin-top: 4; margin-bottom:0"> 
    <a target="_self" href="bib.php#Constantinescu_PA2009a">
      <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. Constantinescu 
    and Adrian Sandu, <b>&quot;Explicit time stepping methods with high stage order and monotonicity properties.&quot;</b> 
    International Conference on Computational Science (ICCS) 2009, Baton Rouge, Louisiana, 
    May 25-27, 2009 [ <a target="_blank" href="Repository/Papers/HighStageOrder.pdf"><img src="Pictures/icons_pdf.jpg" alt="PDF" width="18" height="19" border="0"></a> Preprint ANL/MCS-P1576-0109, January 2009].</p> <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>
 
 <li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
 <strong>&quot;On General Linear Time Stepping Methods.&quot;</strong> Presented by <span style="font-style: normal">Emil M. Constantinescu </span>at SIAM CS&amp;E 2009 meeting, Miami, FL, March 2-6, 2009.
 </p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
 </li> 
 
 <li>
 <p style="line-height: 125%; margin-top: 4; margin-bottom:0"> 
 <a target="_self" href="bib.php#Sandu_PA2008a"> <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a target="_blank" href="http://dx.doi.org/10.1007/978-3-642-12110-4_52"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a> Emil M. Constantinescu and Adrian Sandu, <b>&quot;On Extrapolated multirate  numerical integration methods.&quot;</b> 
       ECMI  2008 (Springer Mathematics  in Industry), 2008 -&gt; <a href="Repository/Papers/MRExtrap_TR.pdf" target="_self"><img border="0" src="Pictures/icons_pdf.jpg" width="18" height="19"></a> <a target="_self" href="bib.php#Constantinescu_TR2008a"> <img border="0" src="Pictures/icons_bib.jpg" width="18" height="19"></a> Technical report version.</p>
 <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
	  </li>
      
	<li>
  <p style="line-height: 125%; margin-top: 4; margin-bottom:0">
    <span style="font-style: normal"><a target="_self" href="bib.php#Constantinescu_PA2007b">
  <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. Constantinescu and Adrian Sandu, </span>
  <b>&quot;Strong stability preserving multirate schemes for hyperbolic conservation 
    laws.&quot;</b> SIAM Conference on Computational Science and Engineering&nbsp; (CSE 
    2007)<span style="font-style: normal">, Costa Mesa, CA</span>, February<span style="font-style: normal"> 
      18-23, 2007</span>.</p> <p style="line-height: 125%; margin-top: 4; margin-bottom:0">&nbsp;  </p> </li>

 <li>
  <p style="line-height: 125%; margin-top: 4; margin-bottom:0"> 
  <a target="_self" href="bib.php#Constantinescu_PA2005b">
  <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. Constantinescu 
  and Adrian Sandu, <b>&quot;On adaptive mesh refinement for atmospheric pollution 
  models.&quot; </b>International Conference on Computational Science (ICCS) 2005, pages 798-806 Atlanta, GA, 
  May 22-25, 2005.</p> <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
  </li>

  <li><p style="line-height: 125%; margin-top: 4; margin-bottom:0"> 
  <a target="_self" href="bib.php#Constantinescu_PA2005a">
  <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. Constantinescu, Wenyuan Liao, 
  and Adrian Sandu, <b>&quot;Mesh refinement strategies in air quality modeling.&quot;</b> High Performance Computing Symposium
   (HPC) 2005, pages 158-163 - San Diego, CA, April 2-8, 2005.</p>
  </li>

</ul>

      <p align="center">
  <span style="font-style: normal"><a href="#GLMDescription">GLM</a> | <a href="#IMEXDescription">IMEX</a> | <a href="#MRDescription">Multirate</a> - [<a href="#MRExample">Example</a>] | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>     
      
       <p>&nbsp;</p>
      <p>
      <span style="font-style: normal; font-weight:700"><font size="4"> &nbsp;&nbsp;&nbsp; <a name="TechnicalReports" id="TechnicalReports">Technical Reports</a>:</font></span>
      </p>


<ul  type="square">
        
  <li>
    <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#Constantinescu_S2008c" target="_self"></a><a target="_blank" href="Repository/Papers/GenLinReport.pdf"><img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a> <span style="margin-top: 4"> <a target="_self" href="bib.php#Constantinescu_TR2009a"> <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a></span> Emil M. Constantinescu and Adrian Sandu, <b>&quot;Optimal Explicit Strong-Stability-Preserving General Linear Methods: Complete Results.&quot; </b>Mathematics and Computer Science Division Technical Memorandum ANL/MCS-TM-304, Argonne National Laboratory, January 2009.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
   
    <li>
    <p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="bib.php#Constantinescu_S2008c" target="_self"></a><a target="_blank" href="Repository/Papers/GLMOrder.pdf"><img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a> <span style="margin-top: 4"> <a target="_self" href="bib.php#Constantinescu_TR2008c"> <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a></span> Emil M. Constantinescu and Adrian Sandu, <b>&quot;On the order of general linear methods.&quot;</b> Technical Report ANL/MCS/JA-62914, Mathematics and Computer Science, Argonne National Laboratory, Oct 2008.</p> <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
  
   <li><p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="Repository/Papers/MRExtrap_TR.pdf" target="_self"><img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a> <a target="_self" href="bib.php#Constantinescu_TR2008a"> <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. Constantinescu and Adrian Sandu, <b>&quot;On Extrapolated Multirate Methods.&quot;</b> Technical Report TR-08-12, Computer 
    Science, Virginia Tech, 2008.</p> <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
    
  <li><p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="Repository/Papers/TM-306.pdf" target="_self"><img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a> <a target="_self" href="bib.php#Constantinescu_TR2009b"> <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a></span> Emil M. Constantinescu and Adrian Sandu, <b>&quot;Achieving Very High  Order for Implicit Explicit Time Stepping: Extrapolation Methods.&quot;</b>Mathematics and Computer Science Division Technical Memorandum ANL/MCS-TM-306, Argonne National Laboratory, April 2009.</p> <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
  
  <li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
<a target="_blank" href="http://eprints.cs.vt.edu/archive/00000989/01/mradams.pdf">
<img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a><a href="http://eprints.cs.vt.edu/archive/00000989/01/mradams.pdf">
</a><a target="_top" href="bib.php#Constantinescu_TR2007b">
<img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Adrian Sandu and Emil M. Constantinescu, <b>&quot;Multirate explicit Adams methods for time integration of conservation laws.&quot;</b> Technical Report TR-07-30(989), Computer 
Science, Virginia Tech, 2007.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>

<li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
<a target="_blank" href="http://eprints.cs.vt.edu/archive/00000955/01/TR_07_12_MRK.pdf">
<img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a>
<a href="bib.php#Constantinescu_TR2007a" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. 
Constantinescu and Adrian Sandu, <b>&quot;Update on multirate timestepping 
methods for hyperbolic conservation laws.&quot;</b> Technical Report TR-07-12(955), Computer 
Science, Virginia Tech, 2007.</p> <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>


	<li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
<a target="_blank" href="http://eprints.cs.vt.edu/archive/00000913/01/mrk.pdf">
<img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a>
<a target="_self" href="bib.php#Constantinescu_TR2006d">
<img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. 
Constantinescu and Adrian Sandu, <b>&quot;Multirate timestepping 
methods for hyperbolic conservation laws.&quot;</b> Technical Report TR-06-15, Computer 
Science, Virginia Tech, 2006.</p> </li>

</ul>

       
      <p align="center">
      <span style="font-style: normal"><a href="#GLMDescription">GLM</a> | <a href="#IMEXDescription">IMEX</a> | <a href="#MRDescription">Multirate</a> - [<a href="#MRExample">Example</a>] | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>     
      
      <p>&nbsp;</p>
      <p>
      <span style="font-style: normal; font-weight:700; "><font size=4> <a name="Links" id="Links">Related Links:</a></font></span>
      </p>
      
      <table BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%" HEIGHT="633" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber1" >
        <tr>
          <td WIDTH="39%" HEIGHT="20"><span style="font-weight: 700; text-decoration: underline"> AMR's &amp; frameworks</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="3%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="20">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://www.physics.drexel.edu/~olson/paramesh-doc/Users_manual/amr.html">Paramesh</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19"><b>[NEW]</b> Version 4.0 (problems!!!)</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://www.sci.utah.edu/">SciRun</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">current mesh infrastructure</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://seesar.lbl.gov/ANAG/chombo/index.html">CHOMBO</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19"><b>[NEW]</b> Version 2.0</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://www.amath.washington.edu/~claw/"> CLAWPACK</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">finite volume framework</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><span style="text-decoration: underline; font-weight: 700"> Mathematical Software</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://wolfram.com/">Mathematica</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">Mathematica (<a href="http://demonstrations.wolfram.com/">demos</a>) and tutorials: <a href="http://url.wolfram.com/L8Fxvq0/">basic</a> and more <a href="http://url.wolfram.com/Fky6lHe/">advanced</a></td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><span style="text-decoration: underline; font-weight: 700"> Numerical methods</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://homepages.cwi.nl/~willem/willem.html" style="text-decoration: none"> Willem Hundsdorfer's web page</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://math.la.asu.edu/~gardner/ENO.ps"> http://math.la.asu.edu/~gardner/ENO.ps</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">ENO-WENO by C.-W. Shu</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><span style="text-decoration: underline; font-weight: 700"> Other</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a style="text-decoration: none" href="http://www.cc.gatech.edu/fac/Ellen.Zegura/EWZ.html">Ellen W. Zegura's homepage</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="5"><span style="text-decoration: underline; font-weight: 700"> Visualization programs</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top"> Top</a>]</td>
          <td WIDTH="3%" HEIGHT="5"></td>
          <td WIDTH="58%" HEIGHT="5"></td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://www.ssec.wisc.edu/~billh/vis5d.html">Vis5d</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://public.kitware.com/VTK/">VTK</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td HEIGHT="19"><a href="http://www.paraview.org">ParaView</a></td>
          <td HEIGHT="19">&nbsp;</td>
          <td HEIGHT="19">ParaView is an open-source, multi-platform data analysis and visualization application.</td>
        </tr>
        <tr>
          <td HEIGHT="19"><a href="http://ggobi.org">GGobi</a></td>
          <td HEIGHT="19">&nbsp;</td>
          <td HEIGHT="19">GGobi is an open source visualization program for exploring high-dimensional data.</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><u><b>Notes</b></u>&nbsp; 
            [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><span style="font-family: Times New Roman"> <a href="http://www.math.umn.edu/~cockburn/LectureNotes.html">Lecture Notes On 
            Discontinuous Galerkin Methods for convection-dominated problems</a></span></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://www.atmos.ucla.edu/~alistair/htmlpapers/TopoPaper/normal.html"> Height Coordinate Ocean Model</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://ce.et.tudelft.nl/~robbert/sparse_matrix_compression.html">Sparse 
            Matrix Compression Formats</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><u><b>Workaround</b></u>&nbsp; 
            [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://www.llnl.gov/CASC/Overture/henshaw/documentation/App/manual/node59.html"> SSH with MPI</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><u><b>Soft</b></u>&nbsp; 
            [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19"><a href="http://www.openfem.net/">An Open-Source 
            Finite Element Toolbox</a></td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="39%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="3%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="58%" HEIGHT="19">&nbsp;</td>
        </tr>
      </table>
     <p>&nbsp;</p>
      <p align="center">
      <span style="font-style: normal"><a href="#GLMDescription">GLM</a> | <a href="#IMEXDescription">IMEX</a> | <a href="#MRDescription">Multirate</a> - [<a href="#MRExample">Example</a>] | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>    
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>



<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-5887618-1");
pageTracker._trackPageview();
} catch(err) {}</script>

<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
var sc_project=9795177; 
var sc_invisible=1; 
var sc_security="651a6968"; 
var scJsHost = (("https:" == document.location.protocol) ?
"https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" +
scJsHost+
"statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript><div class="statcounter"><a title="site stats"
href="http://statcounter.com/free-web-stats/"
target="_blank"><img class="statcounter"
src="http://c.statcounter.com/9795177/0/651a6968/1/"
alt="site stats"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->
</body>

</html>
