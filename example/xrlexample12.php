<?php
/*
Copyright (c) 2013, Tom Schoonjans
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
    * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
    * The names of the contributors may not be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY Tom Schoonjans ''AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL Tom Schoonjans BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

include("xraylib.php");

SetErrorMessages(0);

printf("Example of PHP program using xraylib\n");
printf("Density of pure Al: %f g/cm3\n", ElementDensity(13));
printf("Ca K-alpha Fluorescence Line Energy: %f\n",
	 LineEnergy(20,KA_LINE));
printf("Fe partial photoionization cs of L3 at 6.0 keV: %f\n",CS_Photo_Partial(26,L3_SHELL,6.0));
printf("Zr L1 edge energy: %f\n",EdgeEnergy(40,L1_SHELL));
printf("Pb Lalpha XRF production cs at 20.0 keV (jump approx): %f\n",CS_FluorLine(82,LA_LINE,20.0));
printf("Pb Lalpha XRF production cs at 20.0 keV (Kissel): %f\n",CS_FluorLine_Kissel(82,LA_LINE,20.0));
printf("Bi M1N2 radiative rate: %f\n",RadRate(83,M1N2_LINE));
printf("U M3O3 Fluorescence Line Energy: %f\n",LineEnergy(92,M3O3_LINE));

/*parser test for Ca(HCO3)2 (calcium bicarbonate)*/
if (($cdtest = CompoundParser("Ca(HCO3)2")) == NULL)
	exit(1);
printf("Ca(HCO3)2 contains %g atoms and %i elements\n",$cdtest["nAtomsAll"],$cdtest["nElements"]);
for ($i = 0 ; $i < $cdtest["nElements"] ; $i++)
    printf("Element %i: %f %%\n",$cdtest["Elements"][$i],$cdtest["massFractions"][$i]*100.0);

/*parser test for SiO2 (quartz)*/
if (($cdtest = CompoundParser("SiO2")) == NULL)
	exit(1);
printf("Ca(HCO3)2 contains %g atoms and %i elements\n",$cdtest["nAtomsAll"],$cdtest["nElements"]);
for ($i = 0 ; $i < $cdtest["nElements"] ; $i++)
    printf("Element %i: %f %%\n",$cdtest["Elements"][$i],$cdtest["massFractions"][$i]*100.0);

printf("Ca(HCO3)2 Rayleigh cs at 10.0 keV: %f\n",CS_Rayl_CP("Ca(HCO3)2",10.0) );

printf("CS2 Refractive Index at 10.0 keV : %f - %f i\n",Refractive_Index_Re("CS2",10.0,1.261),Refractive_Index_Im("CS2", 10.0, 1.261));
printf("C16H14O3 Refractive Index at 1 keV : %f - %f i\n",Refractive_Index_Re("C16H14O3", 1.0, 1.2),Refractive_Index_Im("C16H14O3", 1.0, 1.2));
printf("SiO2 Refractive Index at 5 keV : %f - %f i\n",Refractive_Index_Re("SiO2", 5.0, 2.65),Refractive_Index_Im("SiO2",5.0, 2.65));

printf("Compton profile for Fe at pz = 1.1 : %f\n",ComptonProfile(26,1.1));
printf("M5 Compton profile for Fe at pz = 1.1 : %f\n",ComptonProfile_Partial(26,M5_SHELL,1.1));
printf("M1->M5 Coster-Kronig transition probability for Au : %f\n",CosKronTransProb(79,FM15_TRANS));
printf("L1->L3 Coster-Kronig transition probability for Fe : %f\n",CosKronTransProb(26,FL13_TRANS));
printf("Au Ma1 XRF production cs at 10.0 keV (Kissel): %f\n", CS_FluorLine_Kissel(79,MA1_LINE,10.0));
printf("Au Mb XRF production cs at 10.0 keV (Kissel): %f\n", CS_FluorLine_Kissel(79,MB_LINE,10.0));
printf("Au Mg XRF production cs at 10.0 keV (Kissel): %f\n", CS_FluorLine_Kissel(79,MG_LINE,10.0));

printf("K atomic level width for Fe: %f\n", AtomicLevelWidth(26,K_SHELL));
printf("Bi L2-M5M5 Auger non-radiative rate: %f\n",AugerRate(86,L2_M5M5_AUGER));
printf("Bi L3 Auger yield: %f\n", AugerYield(86, L3_SHELL));

$symbol = AtomicNumberToSymbol(26);
printf("Symbol of element 26 is: %s\n",$symbol);

printf("Number of element Fe is: %d\n",SymbolToAtomicNumber("Fe"));

printf("Pb Malpha XRF production cs at 20.0 keV with cascade effect: %f\n",CS_FluorLine_Kissel(82,MA1_LINE,20.0));
printf("Pb Malpha XRF production cs at 20.0 keV with radiative cascade effect: %f\n",CS_FluorLine_Kissel_Radiative_Cascade(82,MA1_LINE,20.0));
printf("Pb Malpha XRF production cs at 20.0 keV with non-radiative cascade effect: %f\n",CS_FluorLine_Kissel_Nonradiative_Cascade(82,MA1_LINE,20.0));
printf("Pb Malpha XRF production cs at 20.0 keV without cascade effect: %f\n",CS_FluorLine_Kissel_no_Cascade(82,MA1_LINE,20.0));


printf("Al mass energy-absorption cs at 20.0 keV: %f\n", CS_Energy(13, 20.0));
printf("Pb mass energy-absorption cs at 40.0 keV: %f\n", CS_Energy(82, 40.0));
printf("CdTe mass energy-absorption cs at 40.0 keV: %f\n", CS_Energy_CP("CdTe", 40.0));

/* Si Crystal structure */

$cryst = Crystal_GetCrystal("Si");
if ($cryst == NULL) 
	exit(1);
printf ("Si unit cell dimensions are %f %f %f\n", $cryst["a"], $cryst["b"], $cryst["c"]);
printf ("Si unit cell angles are %f %f %f\n", $cryst["alpha"], $cryst["beta"], $cryst["gamma"]);
printf ("Si unit cell volume is %f\n", $cryst["volume"]);
printf ("Si atoms at:\n");
printf ("   Z  fraction    X        Y        Z\n");
for ($i = 0; $i < $cryst["n_atom"] ; $i++) {
    $atom = $cryst["atom"][$i];
    printf ("  %3d %f %f %f %f\n", $atom["Zatom"], $atom["fraction"], $atom["x"], $atom["y"], $atom["z"]);
  } 

/* Si diffraction parameters */
$energy = 8.0;
$debye_temp_factor = 1.0;
$rel_angle = 1.0;

printf ("\nSi111 at 8 KeV. Incidence at the Bragg angle:\n");

$bragg = Bragg_angle ($cryst, $energy, 1, 1, 1);
printf ("  Bragg angle: Rad: %f Deg: %f\n", $bragg, $bragg*180/PI);

$q = Q_scattering_amplitude ($cryst, $energy, 1, 1, 1, $rel_angle);
printf ("  Q Scattering amplitude: %f\n", $q);

list($f0, $fp, $fpp) = Atomic_Factors (14, $energy, $q, $debye_temp_factor);
printf ("  Atomic factors (Z = 14) f0, fp, fpp: %f, %f, i*%f\n", $f0, $fp, $fpp);

$FH = Crystal_F_H_StructureFactor ($cryst, $energy, 1, 1, 1, $debye_temp_factor, $rel_angle);
printf ("  FH(1,1,1) structure factor: (%f, %f)\n", $FH["re"], $FH["im"]);

$F0 = Crystal_F_H_StructureFactor ($cryst, $energy, 0, 0, 0, $debye_temp_factor, $rel_angle);
printf ("  F0=FH(0,0,0) structure factor: (%f, %f)\n", $F0["re"], $F0["im"]);


/* Diamond diffraction parameters */

$cryst = Crystal_GetCrystal("Diamond");

printf ("\nDiamond 111 at 8 KeV. Incidence at the Bragg angle:\n");

$bragg = Bragg_angle ($cryst, $energy, 1, 1, 1);
printf ("  Bragg angle: Rad: %f Deg: %f\n", $bragg, $bragg*180/PI);

$q = Q_scattering_amplitude ($cryst, $energy, 1, 1, 1, $rel_angle);
printf ("  Q Scattering amplitude: %f\n", $q);

list($f0, $fp, $fpp) = Atomic_Factors (6, $energy, $q, $debye_temp_factor);
printf ("  Atomic factors (Z = 6) f0, fp, fpp: %f, %f, i*%f\n", $f0, $fp, $fpp);

$FH = Crystal_F_H_StructureFactor ($cryst, $energy, 1, 1, 1, $debye_temp_factor, $rel_angle);
printf ("  FH(1,1,1) structure factor: (%f, %f)\n", $FH["re"], $FH["im"]);

$F0 = Crystal_F_H_StructureFactor ($cryst, $energy, 0, 0, 0, $debye_temp_factor, $rel_angle);
printf ("  F0=FH(0,0,0) structure factor: (%f, %f)\n", $F0["re"], $F0["im"]);

$FHbar = Crystal_F_H_StructureFactor ($cryst, $energy, -1, -1, -1, $debye_temp_factor, $rel_angle);
$dw = 1.0E10 * 2 * (R_E / $cryst["volume"]) * (KEV2ANGST * KEV2ANGST/ ($energy * $energy)) * 
                                                  sqrt(c_abs(c_mul($FH, $FHbar))) / PI / sin(2*$bragg);
printf ("  Darwin width: %f micro-radians\n", 1.0E6*$dw);

/* Alpha Quartz diffraction parameters */

$cryst = Crystal_GetCrystal("AlphaQuartz");

printf ("\nAlpha Quartz 020 at 8 KeV. Incidence at the Bragg angle:\n");

$bragg = Bragg_angle ($cryst, $energy, 0, 2, 0);
printf ("  Bragg angle: Rad: %f Deg: %f\n", $bragg, $bragg*180/PI);

$q = Q_scattering_amplitude ($cryst, $energy, 0, 2, 0, $rel_angle);
printf ("  Q Scattering amplitude: %f\n", $q);

list($f0, $fp, $fpp) = Atomic_Factors (8, $energy, $q, $debye_temp_factor);
printf ("  Atomic factors (Z = 8) f0, fp, fpp: %f, %f, i*%f\n", $f0, $fp, $fpp);

$FH = Crystal_F_H_StructureFactor ($cryst, $energy, 0, 2, 0, $debye_temp_factor, $rel_angle);
printf ("  FH(0,2,0) structure factor: (%f, %f)\n", $FH["re"], $FH["im"]);

$F0 = Crystal_F_H_StructureFactor ($cryst, $energy, 0, 0, 0, $debye_temp_factor, $rel_angle);
printf ("  F0=FH(0,0,0) structure factor: (%f, %f)\n", $F0["re"], $F0["im"]);

/* Muscovite diffraction parameters */

$cryst = Crystal_GetCrystal("Muscovite");

printf ("\nMuscovite 331 at 8 KeV. Incidence at the Bragg angle:\n");

$bragg = Bragg_angle ($cryst, $energy, 3, 3, 1);
printf ("  Bragg angle: Rad: %f Deg: %f\n", $bragg, $bragg*180/PI);

$q = Q_scattering_amplitude ($cryst, $energy, 3, 3, 1, $rel_angle);
printf ("  Q Scattering amplitude: %f\n", $q);

list($f0, $fp, $fpp) = Atomic_Factors (19, $energy, $q, $debye_temp_factor);
printf ("  Atomic factors (Z = 19) f0, fp, fpp: %f, %f, i*%f\n", $f0, $fp, $fpp);

$FH = Crystal_F_H_StructureFactor ($cryst, $energy, 3, 3, 1, $debye_temp_factor, $rel_angle);
printf ("  FH(3,3,1) structure factor: (%f, %f)\n", $FH["re"], $FH["im"]);

$F0 = Crystal_F_H_StructureFactor ($cryst, $energy, 0, 0, 0, $debye_temp_factor, $rel_angle);
printf ("  F0=FH(0,0,0) structure factor: (%f, %f)\n", $F0["re"], $F0["im"]);

printf ("\n");

/* compoundDataNIST tests */
$cdn = GetCompoundDataNISTByName("Uranium Monocarbide");
printf ("Uranium Monocarbide\n");
printf ("  Name: %s\n", $cdn["name"]);
printf ("  Density: %f g/cm3\n", $cdn["density"]);
for ($i = 0 ; $i < $cdn["nElements"] ; $i++) {
	printf("  Element %i: %f %%\n",$cdn["Elements"][$i],$cdn["massFractions"][$i]*100.0);
}

$cdn = GetCompoundDataNISTByIndex(NIST_COMPOUND_BRAIN_ICRP);
printf ("NIST_COMPOUND_BRAIN_ICRP\n");
printf ("  Name: %s\n", $cdn["name"]);
printf ("  Density: %f g/cm3\n", $cdn["density"]);
for ($i = 0 ; $i < $cdn["nElements"] ; $i++) {
	printf("  Element %i: %f %%\n",$cdn["Elements"][$i],$cdn["massFractions"][$i]*100.0);
}

$nistCompounds = GetCompoundDataNISTList();
printf ("List of available NIST compounds:\n");
for ($i = 0 ; $i < count($nistCompounds) ; $i++) {
	printf("  Compound %d: %s\n", $i, $nistCompounds[$i]);
}

printf ("\n");

/* radioNuclideData tests */
$rnd = GetRadioNuclideDataByName("109Cd");
printf ("109Cd\n");
printf ("  Name: %s\n", $rnd["name"]);
printf ("  Z: %d\n", $rnd["Z"]);
printf ("  A: %d\n", $rnd["A"]);
printf ("  N: %d\n", $rnd["N"]);
printf ("  Z_xray: %d\n", $rnd["Z_xray"]);
printf ("  X-rays:\n");
for ($i = 0 ; $i < $rnd["nXrays"] ; $i++) {
  	printf ("  %f keV -> %f %%\n", LineEnergy($rnd["Z_xray"], $rnd["XrayLines"][$i]), $rnd["XrayIntensities"][$i]*100.0);
}
printf ("  Gamma rays:\n");
for ($i = 0 ; $i < $rnd["nGammas"] ; $i++) {
  	printf ("  %f keV -> %f %%\n", $rnd["GammaEnergies"][$i], $rnd["GammaIntensities"][$i]*100.0);
}

$rnd = GetRadioNuclideDataByIndex(RADIO_NUCLIDE_125I);
printf ("RADIO_NUCLIDE_125I\n");
printf ("  Name: %s\n", $rnd["name"]);
printf ("  Z: %d\n", $rnd["Z"]);
printf ("  A: %d\n", $rnd["A"]);
printf ("  N: %d\n", $rnd["N"]);
printf ("  Z_xray: %d\n", $rnd["Z_xray"]);
printf ("  X-rays:\n");
for ($i = 0 ; $i < $rnd["nXrays"] ; $i++) {
  	printf ("  %f keV -> %f %%\n", LineEnergy($rnd["Z_xray"], $rnd["XrayLines"][$i]), $rnd["XrayIntensities"][$i]*100.0);
}
printf ("  Gamma rays:\n");
for ($i = 0 ; $i < $rnd["nGammas"] ; $i++) {
  	printf ("  %f keV -> %f %%\n", $rnd["GammaEnergies"][$i], $rnd["GammaIntensities"][$i]*100.0);
}

$radioNuclides = GetRadioNuclideDataList();
printf ("List of available radionuclides:\n");
for ($i = 0 ; $i < count($radioNuclides) ; $i++) {
	printf("  Radionuclide %d: %s\n", $i, $radioNuclides[$i]);
}
printf("\n--------------------------- END OF XRLEXAMPLE12 ------------------------------\n");
?>
