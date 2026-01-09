<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Emil Constantinescu's research: Modeling and Simulation</title>
<!--<meta http-equiv="REFRESH" content="5;url=http://www.cs.vt.edu/~emconsta">-->
<style type="text/css">
<!--
.style2 {font-size: medium}
-->
</style>
</head>

<body>



<table width="870" height="233" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="142" valign="top">
	<?php include("contents.html"); ?></td>
	
    <td width="714" valign="top">
	
	  <p><a name="Top"></a>
	  <u><font size=+2><span style="font-style: normal; font-weight: 700">Modeling and Simulation</span></font></u>
	  </p>
      <p>
	  Adaptive mesh 
refinement (AMR): Inadequate grid resolution can be an important source of errors in 
modeling various physical processes. For example in convection-diffusion problems, where large spatial gradients cause large errors, 
mesh refinement plays a key role. Adaptive refinement is important in large 
scale applications. AMR alleviates discretization model errors by refining the 
time/space mesh according to a criterion that maximizes the efficiency and the 
effectiveness of the method.</p>
	   
      <p align="center">
      <span style="font-style: normal"><a href="#MRExample">Example</a> | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>   
	  <p>&nbsp;</p>
      <p>
      <span style="font-style: normal; font-weight: 700"><font size="4"> <a name="MRExample">Example</a></font></span>
	  </p>
	  <p>
      <span style="font-style: normal">An Example is given below that illustrates the 
main idea of <b>AMR</b> and <a target="_self" href="TimeStepping.php">multirate</a>. 
The 2D simulation models the transport of a (power plant) plume in the 
atmosphere (1 km mixing layer) with an Eastern wind (5 m/s) and a turbulent 
diffusivity of 100 m<sup>2</sup>/s. The simulation is run for 6 hours. The power 
plant is turned off and the plume dynamics is simulated for another six hours. 
Note how the fine grid resolution follows the features of the solution. Such an 
algorithm that dynamically adapts the grid for large scale models is presented 
in [<a href="#Modeling atmospheric chemistry and transport with dynamic adaptive resolution">Constantinescu 
et al. 2007; Comp. Geosci.</a>]. The fine resolution accurately resolves the 
fine features of the solution. In order to efficiently implement this <b>AMR</b> approach, different timesteps should be used for different resolutions: large 
timesteps for coarse resolutions and small timesteps for fine resolutions 
resulting in <a target="_self" href="TimeStepping.php">multirate</a> algorithms. 
Examples of such algorithms are found in [<a href="#Procedings">Constantinescu 
et al. 2007; Sci. Comp.</a>] or [<a href="multirate.html#Multirate explicit Adams methods for time integration of conservation laws">Sandu 
et al. 2007; Sci. Comp.</a>]</span>
	  </p>
	  <p>
      <img src="Movies/Case_242.gif" alt="simulation movie" border="0">
	  </p> 
      
      
      <p align="center">
      <span style="font-style: normal"><a href="#MRExample">Example</a> | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>   
      
       <p>&nbsp;</p>
      
      <p>
      <span style="font-style: normal; font-weight:700"><font size="4"> <a name="Publications" id="Publications">Selected journal publications, 
  proceedings, presentations</a></font></span>
      </p>
 
      <p>
      <span style="font-style: normal; font-weight:700"><font size="4"> &nbsp;&nbsp;&nbsp; <a name="Journal">Journal</a> publications:</font></span>
      </p>
      
  <ul type="square">
  <li><a href="https://arxiv.org/pdf/2303.17019.pdf"><img src="Pictures/icons_pdf.jpg" alt="" width="24" height="27" border="0"></a> 
<a href="https://doi.org/10.1016/j.jcp.2024.112954"><img src="Pictures/icons_doi.jpg" alt="" width="24" height="27" border="0"></a>
Johann Rudi, Max Heldman, Emil M. Constantinescu, Qi Tang, and Xian-Zhu Tang,
 <b>&quot;<strong>Scalable implicit solvers with dynamic mesh adaptation for a relativistic drift-kinetic Fokker-Planck-Boltzmann model</strong>.&quot;</b>  
  <em>Journal of Computational Physics</em>, Vol. 507, Pages 112954, DOI: 10.1016/j.jcp.2024.112954, 2024.
  [<a href="https://arxiv.org/abs/2303.17019">https://arxiv.org/abs/2303.17019</a>]
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>

     <li>
   <p style="line-height: 125%; margin-top: 4; margin-bottom:0">
     <a href="bib.php#Sandu_A2007" target="_self">
       <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a target="_blank" href="http://dx.doi.org/10.1007/s10915-008-9235-3">
<img border="0" src="Pictures/icons_doi.jpg" width="24" height="27"></a> Adrian Sandu and Emil M. Constantinescu, <b>&quot;Multirate explicit Adams methods for time integration of conservation laws.&quot;</b>    Vol. 38(2), Pages 229-249, Journal of 
     Scientific Computing, 2009. -&gt; <a target="_blank" href="http://eprints.cs.vt.edu/archive/00000989/01/mradams.pdf"> 
     <img border="0" src="Pictures/icons_pdf.jpg" width="18" height="19"></a> <a target="_self" href="bib.php#Constantinescu_TR2007b"> <img border="0" src="Pictures/icons_bib.jpg" width="18" height="19"></a> Technical report version.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p></li>
     
 <li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
<a target="_self" href="bib.php#Constantinescu_A2008a">
<img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> <a target="_blank" href="Repository/Papers/amr_aqm.pdf"> 
<img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a>
<a target="_blank" href="http://dx.doi.org/10.1007/s10596-007-9065-7">
<img border="0" src="Pictures/icons_doi.jpg" width="24" height="27"></a> Emil M. Constantinescu, Adrian Sandu, and Gregory R. Carmichael, <b>&quot;Modeling atmospheric chemistry and transport with dynamic adaptive resolution.&quot;</b>   Vol. 12(2), Pages 133-151, 
Computational Geosciences, 2008.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp; </p></li>  	

 	<li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
<a target="_self" href="bib.php#Constantinescu_A2007e">
<img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> 
<a target="_blank" href="http://dx.doi.org/10.1007/s10915-007-9151-y">
<img border="0" src="Pictures/icons_doi.jpg" width="24" height="27"></a> Emil M. Constantinescu and Adrian Sandu, <b>&quot;Multirate timestepping 
methods for hyperbolic conservation laws.&quot;</b> Vol. 33(3), Pages 239-278, Journal of 
Scientific Computing, 2007. -&gt;<a target="_blank" href="http://eprints.cs.vt.edu/archive/00000955/01/TR_07_12_MRK.pdf"> <img border="0" src="Pictures/icons_pdf.jpg" width="18" height="19"></a> <a target="_self" href="bib.php#Constantinescu_TR2006d"> <img border="0" src="Pictures/icons_bib.jpg" width="18" height="19"></a> Technical report version.</p> </li> 

</ul>

  
  
  
      <p align="center">
<span style="font-style: normal"><a href="#MRExample">Example</a> | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>   
               <p>&nbsp;</p>
 <p>
      <a name="Proceedings"><font size="4"> <span style="font-style: normal; font-weight: 700">&nbsp;&nbsp;&nbsp; </span> </font><span style="font-style: normal; font-weight:700"><font size="4"> Proceedings/Presentations/</font></span><font size="4"><span style="font-style: normal; font-weight:700">Posters</span></font></a><font size="4"><span style="font-style: normal; font-weight:700">:</span></font>
      </p>
     <ul  type="square">  
 <li>
  <p style="line-height: 125%; margin-top: 4; margin-bottom:0">Adrian Sandu and Emil M. Constantinescu, <b>&quot;Multirate time discretizations for hyperbolic partial differential equations.&quot;</b> Submitted to the International Conference of Numerical Analysis and Applied Mathematics 2009 (ICNAAM 2009), Crete, Greece, 18-22 September 2009.</p> 
  <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp;  </p>
</li>
 <li>
 <p style="line-height: 125%; margin-top: 4; margin-bottom:0"> 
 <a target="_self" href="bib.php#Sandu_PA2008a"> <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. Constantinescu and Adrian Sandu, <b>&quot;Extrapolated multirate  numerical integration methods.&quot;</b> 
       ECMI  2008 (Springer Mathematics  in Industry), 2008 -&gt; <a href="Repository/Papers/MRExtrap_TR.pdf" target="_self"><img border="0" src="Pictures/icons_pdf.jpg" width="18" height="19"></a> <a target="_self" href="bib.php#Constantinescu_TR2008a"> <img border="0" src="Pictures/icons_bib.jpg" width="18" height="19"></a> Technical report version.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp; </p>
 </li>

	<li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
  <a target="_blank" href="bib.php#Constantinescu_PA2006a">
  <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> 
Dan Negrut, Mihai Anitescu, Anter El-Azab, Steve Benson, Emil Constantinescu,
Peter Zapol, and Toby Heyn, 
  <b>&quot;A real-space parallel optimization model reduction approach for 
  electronic structure computation in large nanostructures using orbital-free 
  density functional theory.&quot;</b> IMECE 2006-15740, ASME International Mechanical Engineering Congress and 
Exposition, Chicago, IL, 2006.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp; </p>
	</li>


 <li>
  <p style="line-height: 125%; margin-top: 4; margin-bottom:0"> 
  <a target="_self" href="bib.php#Constantinescu_PA2005b">
  <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. Constantinescu 
  and Adrian Sandu, <b>&quot;On adaptive mesh refinement for atmospheric pollution 
  models.&quot; </b>International Conference on Computational Science (ICCS) 2005, pages 798-806 Atlanta, GA, 
  May 22-25, 2005.</p> <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp; </p>
  </li>

  <li><p style="line-height: 125%; margin-top: 4; margin-bottom:0"> 
  <a target="_self" href="bib.php#Constantinescu_PA2005a">
  <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. Constantinescu, Wenyuan Liao, 
  and Adrian Sandu, <b>&quot;Mesh refinement strategies in air quality modeling.&quot;</b> High Performance Computing Symposium
   (HPC) 2005, pages 158-163 - San Diego, CA, April 2-8, 2005.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp; </p>
  </li>

  <li><p style="line-height: 125%; margin-top: 4; margin-bottom:0"> 
  <a target="_self" href="bib.php#Belwal_PA2004">
  <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Chaitaniya Belwal, Adrian Sandu, and Emil 
  Constantinescu, <b>&quot;Adaptive resolution modeling of regional air quality.&quot;</b> ACM 
  Symposium on Applied Computing SAC 2004, pages 235-239, Nicosia, Cyprus, March 
  14-17, 2004.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp; </p>  </li>

	<li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
  <a target="_self" href="bib.php#Sandu_PA2004">
  <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Adrian Sandu, Chaitaniya Belwal, and Emil 
  Constantinescu,&nbsp;<b>&quot;Parallel adaptive simulations 
  of regional air quality.&quot;</b> Presented at SIAM Conference on Parallel Processing for Scientific 
  Computing; February 25-27, 2004.</p></li>
</ul>


       
      <p align="center">
      <span style="font-style: normal"><a href="#MRExample">Example</a> | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>   
 <p>&nbsp;</p>
 
 
<p><span style="font-style: normal; font-weight:700"><font size="4">
  &nbsp;&nbsp;&nbsp; <a name="TechnicalReports" id="TechnicalReports">Technical Reports</a>:</font></span></p>

<ul  type="square">  
   <li><p style="line-height: 125%; margin-top: 4; margin-bottom:0"><a href="Repository/Papers/MRExtrap_TR.pdf" target="_self"><img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a> <a target="_self" href="bib.php#Constantinescu_TR2008a"> <img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. Constantinescu and Adrian Sandu, <b>&quot;On Extrapolated Multirate Methods.&quot;</b> Technical Report TR-08-12, Computer 
    Science, Virginia Tech, 2008.</p> <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp; </p></li>

  
  <li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
<a target="_blank" href="http://eprints.cs.vt.edu/archive/00000989/01/mradams.pdf">
<img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a><a href="http://eprints.cs.vt.edu/archive/00000989/01/mradams.pdf">
</a><a target="_top" href="bib.php#Constantinescu_TR2007b">
<img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Adrian Sandu and Emil M. Constantinescu, <b>&quot;Multirate explicit Adams methods for time integration of conservation laws.&quot;</b> Technical Report TR-07-30(989), Computer 
Science, Virginia Tech, 2007.</p><p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp; </p></li>

<li>
<p style="line-height: 125%; margin-top: 4; margin-bottom:0">
<a target="_blank" href="http://eprints.cs.vt.edu/archive/00000955/01/TR_07_12_MRK.pdf">
<img border="0" src="Pictures/icons_pdf.jpg" width="24" height="27"></a>
<a href="bib.php#Constantinescu_TR2007a" target="_self"><img border="0" src="Pictures/icons_bib.jpg" width="24" height="27"></a> Emil M. 
Constantinescu and Adrian Sandu, <b>&quot;Update on multirate timestepping 
methods for hyperbolic conservation laws.&quot;</b> Technical Report TR-07-12(955), Computer 
Science, Virginia Tech, 2007.</p> <p style="line-height: 75%; margin-top: 4; margin-bottom:0">&nbsp; </p></li>

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
      <span style="font-style: normal"><a href="#MRExample">Example</a> | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>      
      
      <p>&nbsp;</p>
      
      <p>
      <span style="font-style: normal; font-weight:700; "><font size=4> <a name="Links" id="Links">Related Links:</a></font></span>
      </p>
  
      <table BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%" HEIGHT="272" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber1" >
        <tr>
          <td WIDTH="38%" HEIGHT="20"><span style="font-weight: 700; text-decoration: underline">AQM's</span>&nbsp; 
            [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="20">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.epa.gov/asmdnerl/models3/doc/science/science.html">EPA's
            product on air quality model</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="16"><span style="font-family: Times New Roman"> <a href="http://www.epa.gov/cgi-bin/airnow.cgi?PollName=OZONE&MapName=super&MapType=current_hour"> EPA AQI</a></span></td>
          <td WIDTH="2%" HEIGHT="16"></td>
          <td WIDTH="60%" HEIGHT="16"></td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="16"></td>
          <td WIDTH="2%" HEIGHT="16"></td>
          <td WIDTH="60%" HEIGHT="16"></td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="20"><span style="font-weight: 700; text-decoration: underline"> AMR's &amp; frameworks</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="20">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.physics.drexel.edu/~olson/paramesh-doc/Users_manual/amr.html">Paramesh</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19"><b>[NEW]</b> Version 4.0 (problems!!!)</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.sci.utah.edu/">SciRun</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">current mesh infrastructure</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://seesar.lbl.gov/ANAG/chombo/index.html">CHOMBO</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19"><b>[NEW]</b> Version 2.0</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.amath.washington.edu/~claw/"> CLAWPACK</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">finite volume framework</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a class="fixed" target="_blank" href="https://webmail.cs.vt.edu/horde-3.0.4/services/go.php?url=http://www-users.informatik.rwth-aachen.de/~roberts/software.html"> Mesh Software</a> </td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">mesh generation software list</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="20"><span style="text-decoration: underline; font-weight: 700"> File formats &amp; IO</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="20">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://hdf.ncsa.uiuc.edu/HDF5/">HDF5</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">file format
            that supports grid refinements, variable grids&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.unidata.ucar.edu/packages/netcdf/">NetCDF</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">file format
            for static fixed grids</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.emc.mcnc.org/products/ioapi/"> IOAPI</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">interface for NetCDF files</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="20"><span style="text-decoration: underline; font-weight: 700"> Software concepts</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="20">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="20">CCA</td>
          <td WIDTH="2%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="20">forum: <a href="http://www.cca-forum.org/">http://www.cca-forum.org/</a></td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="20">official: <a href="http://www.csm.ornl.gov/cca/">http://www.csm.ornl.gov/cca/</a></td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="20">study: <a href="http://pat.jpl.nasa.gov/public/dsk/papers/hpec02a.html">http://pat.jpl.nasa.gov/public/dsk/papers/hpec02a.html</a></td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="20">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="20">status &amp; plans (pdf): <a href="http://www.cca-forum.org/tutorials/2002-09-06/CCA.Status.and.Plans.Short.pdf">http://www.cca-forum.org/tutorials/2002-09-06/CCA.Status.and.Plans.Short.pdf</a></td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><span style="text-decoration: underline; font-weight: 700"> Meteorological codes</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://atmet.com/">RAMS code</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.wrf-model.org/">WRF</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><span style="text-decoration: underline; font-weight: 700"> Numerical methods</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://homepages.cwi.nl/~willem/willem.html" style="text-decoration: none"> Willem Hundsdorfer's web page</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><span style="text-decoration: underline; font-weight: 700"> Other</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a style="text-decoration: none" href="http://www.cc.gatech.edu/fac/Ellen.Zegura/EWZ.html">Ellen W. Zegura's homepage</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="5"><span style="text-decoration: underline; font-weight: 700"> Visualization programs</span>&nbsp; [<a href="#Links">Links</a> - <a href="#Top"> Top</a>]</td>
          <td WIDTH="2%" HEIGHT="5"></td>
          <td WIDTH="60%" HEIGHT="5"></td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.ssec.wisc.edu/~billh/vis5d.html">Vis5d</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://public.kitware.com/VTK/">VTK</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><u><b>Varia</b></u>&nbsp; 
            [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><span style="font-family: Times New Roman"> <a href="http://www.auth.ucar.edu/ucar-ca/loadroot/?URL=https://www.scd.ucar.edu/docs/password/internal/cryptocard/logon.html"> UCAR cryptocard</a></span></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><u><b>Notes</b></u>&nbsp; 
            [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><span style="font-family: Times New Roman"> <a href="http://www.math.umn.edu/~cockburn/LectureNotes.html">Lecture Notes On 
            Discontinuous Galerkin Methods for convection-dominated problems</a></span></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.atmos.ucla.edu/~alistair/htmlpapers/TopoPaper/normal.html"> Height Coordinate Ocean Model</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://ce.et.tudelft.nl/~robbert/sparse_matrix_compression.html">Sparse 
            Matrix Compression Formats</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><u><b>Workaround</b></u>&nbsp; 
            [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.llnl.gov/CASC/Overture/henshaw/documentation/App/manual/node59.html"> SSH with MPI</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.unidata.ucar.edu/packages/netcdf/Contrib.html"> User-Contributed netCDF Software</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www-c4.ucsd.edu/~cids/software/visual.html">NetCDF Visualization 
            Tools</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.pmel.noaa.gov/epic/software/mexeps.htm">Still NetCDF</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><u><b>Soft</b></u>&nbsp; 
            [<a href="#Links">Links</a> - <a href="#Top">Top</a>]</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.openfem.net/">An Open-Source 
            Finite Element Toolbox</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www2.ocgy.ubc.ca/~rich/map.html">A 
            mapping package for Matlab</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://dss.ucar.edu/datasets/">Topography 
            datasets</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://www.maproom.psu.edu/cgi-bin/ian/points/index.cgi">Country 
            delimiters</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19"><a href="http://gmt.soest.hawaii.edu/">Generic 
            mapping tools</a></td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
        <tr>
          <td WIDTH="38%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="2%" HEIGHT="19">&nbsp;</td>
          <td WIDTH="60%" HEIGHT="19">&nbsp;</td>
        </tr>
      </table>
       <p>&nbsp;</p>
      <p align="center">
      <span style="font-style: normal"><a href="#MRExample">Example</a> | <a href="#Publications">Publications</a> - [<a href="#Journals">Journals</a> - <a href="#Proceedings">Proceedings</a> - <a href="#TechnicalReports">Reports]</a> | <a href="#Links">Related links</a> | <a href="#Top">Top</a></span></p>   
      <p>&nbsp;</p>
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
