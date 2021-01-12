<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head>
    	<style type="text/css">
    		label {
    			font-size: 14px !important;
    		}

    		table td, th {
    			text-align: center !important;
    			vertical-align: middle !important; 
    		}
    	</style>
    </head>

    <body>
        <div class="row">
			<div class="col-sm-10 col-md-10">
				<div class="box box-danger repBox">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-user" style="font-size: 16px !important;"></i> Participant Details</h3>
						<div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool btnCollapse" data-widget="collapse"><i class="fa fa-minus"></i></button>
			            </div>
					</div>

					<div class="box-body">
						<div class="row">
							<div class="col-md-2">
								Participant Number : 
							</div>
							<div class="col-md-2">
								<label><?=$gen_info['part_id'];?></label>
							</div>

							<div class="col-md-2">
								Household code : 
							</div>
							<div class="col-md-2">
								<label> <?=$gen_info['part_household_code'];?></label>
							</div>

							<div class="col-md-2">
								Date Examined : 
							</div>
							<div class="col-md-2">
								<label><?=date("M. d, Y", strtotime($gen_info['entrydate']));?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								Drop Out? : 
							</div>
							<div class="col-md-1">
								<label>______</label>
							</div>

							
						</div>
					</div>
				</div>

				<div class="box box-danger repBox">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-user" style="font-size: 16px !important;"></i> General Information</h3>
						<div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool btnCollapse" data-widget="collapse"><i class="fa fa-minus"></i></button>
			            </div>
					</div>

					<div class="box-body">
						<div class="row">
							<div class="col-md-1">
							 	Region: 
							</div>
							<div class="col-md-3">
								<label><?=$gen_info['regDesc'];?></label>
							</div>

							<div class="col-md-1">
								Province:
							</div>
							<div class="col-md-3">
								<label> <?=$gen_info['provDesc'];?> </label>
							</div>

							<div class="col-md-1">
								Barangay:
							</div>
							<div class="col-md-3">
								<label> <?=$gen_info['brgyDesc'];?> </label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-1">
							 	Age(Yrs)/Sex: 
							</div>
							<div class="col-md-3">
								<label> <?=$gen_info['part_age'];?> / <?=$gen_info['part_gender'];?></label>
							</div>

							<div class="col-md-1">
								Occupation:
							</div>
							<div class="col-md-3">
								<label> <?=OCCUPATION[strtolower($gen_info['part_occupation'])];?> </label>
							</div>
						</div>
						
					</div>
				</div>


				<div class="box box-danger repBox">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-heartbeat" style="font-size: 16px !important;"></i> Health and Lifestyle</h3>
						<div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool btnCollapse" data-widget="collapse"><i class="fa fa-minus"></i></button>
			            </div>
					</div>

					<div class="box-body">

						<div class="row">
							<div class="col-md-2">
								Height (cm) :
							</div>
							<div class="col-md-1">
								<?php $fHeight =  isset($healthlife['bmi_bmi']['bmi_height']) ? $healthlife['bmi_bmi']['bmi_height'] : ""; ?>
								<label> <?=$fHeight;?> </label>
							</div>

							<div class="col-md-2">
								Weight (kg) :
							</div>
							<div class="col-md-1">
								
								<?php $fWeight =  isset($healthlife['bmi_bmi']['bmi_weight']) ? $healthlife['bmi_bmi']['bmi_weight'] : ""; ?>
								<label> <?=$fWeight;?> </label>
							</div>

							<div class="col-md-2">
								BMI (kg/m<sup>2</sup> :
							</div>
							<div class="col-md-2">
								
								<?php 
									$fBMI 		=  isset($healthlife['bmi_bmi']['txtBmi']) ? $healthlife['bmi_bmi']['txtBmi'] : ""; 
									$fBMIClass 	=  isset($healthlife['bmi_bmi']['txtBmi']) ? $healthlife['bmi_bmi']['txtBmiClass'] : ""; 
								?>
								<label> <?=$fBMI;?> </label> (<?=$fBMIClass;?>) 
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								Waist Cir (cm) :
							</div>
							<div class="col-md-1">
								<?php 
									$fWaistCir 		=  isset($healthlife['bmi_waist_hip']['whm_waist_circ']) ? $healthlife['bmi_waist_hip']['whm_waist_circ'] : ""; 
								?>
								<label> <?=$fWaistCir;?> </label>
							</div>

							<div class="col-md-2">
								Hip Cir (cm) :
							</div>
							<div class="col-md-1">
								
								<?php $fHipCir =  isset($healthlife['bmi_waist_hip']['whm_hip_circ']) ? $healthlife['bmi_waist_hip']['whm_hip_circ'] : ""; ?>
								<label> <?=$fHipCir;?> </label>
							</div>

							<div class="col-md-6">

								<div class="row">
									<div class="col-md-4">WHpR: </div>
									<div class="col-md-6">
										<?php 
											$fWHpR =  isset($healthlife['bmi_waist_hip']['txtWaistHipRatio']) ? $healthlife['bmi_waist_hip']['txtWaistHipRatio'] : ""; 
											$sWaistCirCls 	=  $fWaistCir != "" ? $this->customer->WaistToHeightClass(strtolower($gen_info['part_gender']), $fWHpR) : "";
									
										?>
										<label> <?=$fWHpR; ?> </label> (<?=$sWaistCirCls;?>)
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">WHtR: </div>
									<div class="col-md-6">
										<?php 
											$fWHtR =  isset($healthlife['bmi_waist_hip']['txtWaistHeightRatio']) ? $healthlife['bmi_waist_hip']['txtWaistHeightRatio'] : ""; 
											$sWaistHipCls 	=  $fWHtR != "" ? $this->customer->WaistToHeightClass(strtolower($gen_info['part_gender']), $fWHtR) : "";
										?>
										<label> <?=$fWHtR;?></label> (<?=$sWaistHipCls;?>)
									</div>
								</div>
								
							</div>
							
						</div>

						<div class="row">
							<div class="col-md-2">
								Blood Pressure (mmHg) :
							</div>
							<div class="col-md-1">
								<?php 
									$nSystolic =  isset($healthlife['bmi_vital_signs']['vs_bp_systolic']) ? $healthlife['bmi_vital_signs']['vs_bp_systolic'] : ""; 
									$nDiastolic =  isset($healthlife['bmi_vital_signs']['vs_bp_diastolic']) ? $healthlife['bmi_vital_signs']['vs_bp_diastolic'] : ""; 
								?>
								<label> <?=$nSystolic;?> / <?=$nDiastolic;?> </label>
							</div>

							<div class="col-md-2">
								Glucose Level(mg/dL) :
							</div>
							<div class="col-md-1">
								
								<?php $nGlucoseLevel =  isset($healthlife['bmi_vital_signs']['vs_glucose_level']) ? $healthlife['bmi_vital_signs']['vs_glucose_level'] : ""; ?>
								<label> <?=$nGlucoseLevel;?> </label>
							</div>

							<div class="col-md-2">
								Last Meal
							</div>
							<div class="col-md-2">
								
								<?php $sLastMealHrs =  isset($healthlife['bmi_vital_signs']['vs_last_meal_hrs']) ? $healthlife['bmi_vital_signs']['vs_last_meal_hrs'] : ""; ?>
								<label> <?=$sLastMealHrs;?> </label>
							</div>
						</div>

						<div class="box box-widget">
							<div class="box-header" style="padding-left: 0px;">
								<h4 class="box-title"></i> History</h4>
							</div>

							<div class="box-body">
								<?php
									if ($healthlife['hist_sys_dis'] != "") {

								?>
										<div class="row">
											<div class="col-xs-2 col-md-2"></div>
											<div class="col-xs-2 col-md-2">Systemic Disease</div>
											<div class="col-xs-2 col-md-2">Duration(month/s)</div>
										</div>
								<?php
										foreach ($healthlife['hist_sys_dis'] as $key => $aValues) 
										{
								?>
											<div class="row">
												<div class="col-xs-2 col-md-2"></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->hist_sys_disease;?></label></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->txtSysDisDurationAuto;?></label></div>
											</div>
								<?php
											if($key == 2) {
												echo "<br />";
												break;
											}
										}
									}
								?>

								<?php
									if ($healthlife['hist_life_con'] != "") {
								?>	
										<br />
										<div class="row">
											<div class="col-xs-2 col-md-2"></div>
										
											<div class="col-xs-2 col-md-2">Lifestyle Condition</div>
										
											<div class="col-xs-2 col-md-2">Duration(month/s)</div>
										</div>
								<?php
										foreach ($healthlife['hist_life_con'] as $key => $aValues) 
										{
											
								?>
											<div class="row">
												<div class="col-xs-2 col-md-2"></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->hist_life_condition;?></label></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->txtLifeConDurationAuto;?></label></div>
											</div>
								<?php
											if($key == 2) {
												break;
											}
										}
									}
								?>

								<?php
									if ($healthlife['hist_sys_med'] != "") {
								?>		
										<br />
										<div class="row">
											<div class="col-md-2"></div>
										
											<div class="col-xs-2  col-md-2">Systemic Medication</div>
											<div class="col-xs-2  col-md-2">Dose</div>
											<div class="col-xs-2  col-md-2">Duration(month/s)</div>
										</div>
								<?php
										foreach ($healthlife['hist_sys_med'] as $key => $aValues) 
										{
											
								?>
											<div class="row">
												<div class="col-md-2"></div>
												<div class="col-xs-2  col-md-2"><label><?=$aValues->hist_sys_medication;?></label></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->hist_sys_medication_dose;?></label></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->txtSysMedDurationAuto;?></label></div>
											</div>
								<?php
											if($key == 2) {
												break;
											}
										}
									}
								?>

								<?php
									//if ($healthlife['hist_ocu_med'] != "") {
								?>
										<!-- <br />
										<div class="row">
											<div class="col-md-2"></div>
										
											<div class="col-xs-2 col-md-2">Ocular Medication</div>
											<div class="col-xs-2 col-md-2">Dose</div>
											<div class="col-xs-2 col-md-2">Duration(month/s)</div>
										</div> -->
								<?php
										// foreach ($healthlife['hist_ocu_med'] as $key => $aValues) 
										// {
											
								?>
											<!-- <div class="row">
												<div class="col-md-2"></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->ocu_medication;?></label></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->ocu_medication_dose;?></label></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->txtOcuMedDurationAuto;?></label></div>
												
											</div> -->
								<?php
									// 		if($key == 2) {
									// 			break;
									// 		}
									// 	}
									// }
								?>

								<?php
									if ($healthlife['hist_diet_sup'] != "") {
								?>
										<br />
										<div class="row">
											<div class="col-md-2"></div>
										
											<div class="col-xs-2 col-md-2">Dietary Supplement</div>
											<div class="col-xs-2 col-md-2">Dose</div>
											<div class="col-xs-2 col-md-2">Duration(month/s)</div>
										</div>
								<?php
										foreach ($healthlife['hist_diet_sup'] as $key => $aValues) 
										{
											
								?>
											<div class="row">
												<div class="col-md-2"></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->diet_supplement;?></label></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->diet_supplement_dose;?></label></div>
												<div class="col-xs-2 col-md-2"><label><?=$aValues->txtDietSupDurationAuto;?></label></div>
											</div>
								<?php
											if($key == 2) {
												break;
											}
										}
									}
								?>
								
							</div>
						</div>
						<?php

							if (isset($healthlife['ih_smoke_alc']['sac_smoker']) && (strtolower($healthlife['ih_smoke_alc']['sac_smoker']) != "no" || strtolower($healthlife['ih_smoke_alc']['sac_smoker']) != "n_a")) {
						?>
							<div class="row">
								<div class="col-md-2">
									Smoking Pack Years:
								</div>
								<div class="col-md-1">
									<label> <?=$healthlife['ih_smoke_alc']['txtSmokeDuration']?> </label>
								</div>
							</div>
						<?php
							}
						?>

						<div class="row">
							<div class="col-md-2">
								Average Sun Exposure
							</div>
							<div class="col-md-1">
								<label> <?=(intval($healthlife['bmi_eh_sun_expo']['txtSunExpOutdoorAve']) + intval($healthlife['bmi_eh_sun_expo']['txtSunExpLifeStageAve'])) / 2?> </label>
							</div>
							<div class="col-md-2">
								Average Near Work (in hours):
							</div>
							<div class="col-md-1">
								<label> <?=(intval($healthlife['bmi_eh_near_work']['txtNearWorkLifeStageAve']) + intval($healthlife['bmi_eh_near_work']['txtNearWorkPerDayAve']) + intval($healthlife['bmi_eh_near_work']['txtNearWorkGadgetAve'])) / 3?> </label>
							</div>
						</div>
						<div class="row"> <div class="col-md-3">&nbsp;</div></div>
						<div class="row">
							<div class="col-md-3">
								GPS Lat^Long [Elevation mtrs]
							</div>
							<div class="col-md-2">
								<label> <?=$healthlife['bmi_eh_location']['txtGPSLoc']?> </label>
							</div>
							<div class="col-md-3">
								Distance from the sea (meters):
							</div>
							<div class="col-md-2">
								<label> <?=$healthlife['bmi_eh_location']['loc_dist_sea']?> </label>
							</div>
						</div>

						<div class="row"> <div class="col-md-3">&nbsp;</div></div>
						<div class="row">
							<div class="col-md-3">
								Socioeconomic cluster:
							</div>

							<div class="col-md-2">
								<label> <?=$socioeco['soc_house_fac']['txtSocieCluster']?> </label>
							</div>
						</div>
					</div>
				</div>


				<div class="box box-danger repBox">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-stethoscope" style="font-size: 16px !important;"></i> Eye Exam</h3>
						<div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool btnCollapse" data-widget="collapse"><i class="fa fa-minus"></i></button>
			            </div>
					</div>

					<div class="box-body">
						<div class="box box-widget">
							<div class="box-header">
								<h4 class="box-title"></i> History</h4>
							</div>

							<div class="box-body">
								

								<?php
									if ($eyeexam['hist_ocu_med'] != "") {
								?>
										<div class="row">
											<div class="col-md-2"></div>
										
											<div class="col-md-2">Ocular Medication</div>
											<div class="col-md-2">Dose</div>
											<div class="col-md-2">Eye</div>
											<div class="col-md-2">Duration(month/s)</div>
										</div>
								<?php
										foreach ($healthlife['hist_ocu_med'] as $key => $aValues) 
										{
											
								?>
											<div class="row">
												<div class="col-md-2"></div>
												<div class="col-md-2"><label><?=$aValues->ocu_medication;?></label></div>
												<div class="col-md-2"><label><?=$aValues->ocu_medication_dose;?></label></div>
												<div class="col-md-2"><label><?=$aValues->ocu_medication_eye;?></label></div>
												<div class="col-md-2"><label><?=$aValues->txtOcuMedDurationAuto;?></label></div>
												
											</div>
								<?php
											if($key == 2) {
												break;
											}
										}
									}
								?>
							</div>

						</div>

						<div class="box box-widget">
							<div class="box-header">
								<h4 class="box-title"></i> Symptoms</h4>
							</div>

							<div class="box-body">
								

								<?php
									if ($eyeexam['symp_ocu'] != "") {

								?>
										<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-3"></div>
											<div class="col-md-2">Symptom</div>
											<div class="col-md-2">Duration(month/s)</div>
										</div>
								<?php
										$aSymptoms = array();
										foreach ($eyeexam['symp_ocu'] as $key => $aValues) {
											if ($aValues->chkOcuSympOd == true) {
												$aSymptoms['OD']['symptoms'] 	= $aValues->symp_ocu_symptoms;
												$aSymptoms['OD']['duration'] 	= $aValues->symp_ocu_duration;
											} 
											if ($aValues->chkOcuSympOs == true) {
												$aSymptoms['OS']['symptoms'] 	= $aValues->symp_ocu_symptoms;
												$aSymptoms['OS']['duration'] 	= $aValues->symp_ocu_duration;
											} 
											if ($aValues->chkOcuSympPat == true) {
												$aSymptoms['PA']['symptoms'] 	= $aValues->symp_ocu_symptoms;
												$aSymptoms['PA']['duration'] 	= $aValues->symp_ocu_duration;
											}
										}
								?>
								

										<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-3"><label>Main Ocular Symptom, OD</label></div>
											<?php
												if (isset($aSymptoms['OD'])) {
													echo '
															<div class="col-md-2"><label>'.$aSymptoms['OD']['symptoms'].'</label></div>
															<div class="col-md-2"><label>'.$aSymptoms['OD']['duration'].'</label></div>
														';
												} else {
													echo '
															<div class="col-md-2"> <label>-</label> </div>
															<div class="col-md-2"> <label>-</label> </div>
														';
												}
											?>
										</div>
										<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-3"><label>Main Ocular Symptom, OS</label></div>
											<?php
												if (isset($aSymptoms['OS'])) {
													echo '
															<div class="col-md-2"><label>'.$aSymptoms['OS']['symptoms'].'</label></div>
															<div class="col-md-2"><label>'.$aSymptoms['OS']['duration'].'</label></div>
														';
												} else {
													echo '
															<div class="col-md-2"> <label>-</label> </div>
															<div class="col-md-2"> <label>-</label> </div>
														';
												}
											?>
										</div>
										<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-3"><label>Main Ocular Symptom, Patient</label></div>
											<?php
												if (isset($aSymptoms['PA'])) {
													echo '
															<div class="col-md-2"><label>'.$aSymptoms['PA']['symptoms'].'</label></div>
															<div class="col-md-2"><label>'.$aSymptoms['PA']['duration'].'</label></div>
														';
												} else {
													echo '
															<div class="col-md-2"> <label>-</label> </div>
															<div class="col-md-2"> <label>-</label> </div>
														';
												}
											?>
										</div>
								<?php } ?>

							</div>
							
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<th colspan="3" style="text-align: center;"> Visual Acuity </th>
										</tr>
										<tr>
											<th>Eye</th>
											<th>Best Vision</th>
											<th>W/O Corretion</th>
										</tr>
										<tr>
											<td>OD</td>
											<td><label><?=$eyeexam['va_vis_acu']['va_right_best_vision']?></label></td>
											<td><?=$eyeexam['va_vis_acu']['va_right_without_correction']?></label></td>
										</tr>
										<tr>
											<td>OS</td>
											<td><label><?=$eyeexam['va_vis_acu']['va_left_best_vision']?></label></td>
											<td><label><?=$eyeexam['va_vis_acu']['va_left_without_correction']?></label></td>
										</tr>
									</table>
								</div>
							</div>

							<div class="col-md-4">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<th colspan="4" style="text-align: center;"> Automated Refraction </th>
										</tr>
										<tr>
											<th>Sphere</th>
											<th>Cylinder</th>
											<th>Axis</th>
											<th>Pupil Distance</th>
										</tr>
										<tr>
											<td><label><?=$eyeexam['va_auto_refrac']['ar_od_sphere']?></label></td>
											<td><label><?=$eyeexam['va_auto_refrac']['ar_od_cylinder']?></label></td>
											<td><label><?=$eyeexam['va_auto_refrac']['ar_od_axis']?></label></td>
											<td rowspan="2"><label><?=$eyeexam['va_auto_refrac']['ar_pupil_distance']?></label></td>
										</tr>
										<tr>
											<td><label><?=$eyeexam['va_auto_refrac']['ar_os_sphere']?></label></td>
											<td><label><?=$eyeexam['va_auto_refrac']['ar_os_cylinder']?></label></td>
											<td><label><?=$eyeexam['va_auto_refrac']['ar_os_axis']?></label></td>
										</tr>
									</table>
								</div>
							</div>

							<div class="col-md-4">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<th colspan="4" style="text-align: center;"> Tonometry </th>
										</tr>
										<tr>
											<th>IOP (mmHg)</th>
											
										</tr>
										<tr>
											<td><label><?=$eyeexam['tono_dila']['intra_press_od'];?></label></td>
											
										</tr>
										<tr>
											<td><label><?=$eyeexam['tono_dila']['intra_press_os'];?></label></td>
										</tr>
									</table>
								</div>
							</div>
						</div>

						<div class="box box-widget">
							<div class="box-header">
								<h4 class="box-title"></i> Findings and Diagnosis</h4>
							</div>

							<div class="box-body">
								

								<?php
									if ($eyeexam['symp_ocu'] != "") {

								?>
										<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-3">Main Diagnosis</div>
											<div class="col-md-2">Diagnosis</div>
											<!-- <div class="col-md-2">Eye</div> -->
										</div>
								<?php
										$aFindings = array();
										foreach ($eyeexam['ocu_find_diag'] as $key => $aValues) {
											if ($aValues->chkDiagOd == true) {
												$aFindings['OD']['findings']= $aValues->ofd_findings_diagnosis;
												$aFindings['OD']['eye'] 	= $aValues->ofd_eye;
											} 
											if ($aValues->chkDiagOs == true) {
												$aFindings['OS']['findings']= $aValues->ofd_findings_diagnosis;
												$aFindings['OS']['eye'] 	= $aValues->ofd_eye;
											} 
											if ($aValues->chkDiagPat == true) {
												$aFindings['PA']['findings']= $aValues->ofd_findings_diagnosis;
												$aFindings['PA']['eye'] 	= $aValues->ofd_eye;
											} 
											if ($aValues->chkCauseVl == true) {
												$aFindings['VI']['findings']= $aValues->ofd_findings_diagnosis;
												$aFindings['VI']['eye'] 	= $aValues->ofd_eye;
											}
										}
								?>
								

										<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-3"><label>Main Diagnosis, OD</label></div>
											<?php
												if (isset($aFindings['OD'])) {
													echo '
															<div class="col-md-2"><label>'.$aFindings['OD']['findings'].'</label></div>
															
														';
														// /<div class="col-md-2"><label>'.$aFindings['OD']['eye'].'</label></div>
												} else {
													echo '
															<div class="col-md-2"> <label>-</label> </div>
															
														';
														//<div class="col-md-2"> <label>-</label> </div>
												}
											?>
										</div>
										<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-3"><label>Main Diagnosis, OS</label></div>
											<?php
												if (isset($aFindings['OS'])) {
													echo '
															<div class="col-md-2"><label>'.$aFindings['OS']['findings'].'</label></div>
															
														';
														//<div class="col-md-2"><label>'.$aFindings['OS']['eye'].'</label></div>
												} else {
													echo '
															<div class="col-md-2"> <label>-</label> </div>
															
														';
														//<div class="col-md-2"> <label>-</label> </div>
												}
											?>
										</div>
										<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-3"><label>Main Diagnosis, Patient</label></div>
											<?php
												if (isset($aFindings['PA'])) {
													echo '
															<div class="col-md-2"><label>'.$aFindings['PA']['findings'].'</label></div>
															
														';
														// <div class="col-md-2"><label>'.$aFindings['PA']['eye'].'</label></div>
												} else {
													echo '
															<div class="col-md-2"> <label>-</label> </div>
															
														';
														//<div class="col-md-2"> <label>-</label> </div>

												}
											?>
										</div>

										<div class="row">
											<div class="col-md-2"></div>
											<div class="col-md-3"><label>Main Cause of Visual Loss</label></div>
											<?php
												if (isset($aFindings['VI'])) {
													echo '
															<div class="col-md-2"><label>'.$aFindings['VI']['findings'].'</label></div>
														';
														// /<div class="col-md-2"><label>'.$aFindings['VI']['eye'].'</label></div>
												} else {
													echo '
															<div class="col-md-2"> <label>-</label> </div>
															
														';
														//<div class="col-md-2"> <label>-</label> </div>
												}
											?>
										</div>
								<?php } ?>

							</div>
							
						</div>

					</div>
				</div>

				<div class="box box-danger repBox">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-eye" style="font-size: 16px !important;"></i> Ocular Surgery/Laser/Procedure Objectively Seen During Examination</h3>
						<div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool btnCollapse" data-widget="collapse"><i class="fa fa-minus"></i></button>
			            </div>
					</div>

					<div class="box-body">
						<?php
							if ($eyeexam['ocu_exam'] != "") {
						?>
								<div class="row">
								
									<div class="col-md-2"> </div>
									<div class="col-md-2">Ocular Procedure</div>
									<div class="col-md-2">Eye</div>
									<div class="col-md-2">Surgery Outcome</div>
								</div>
						<?php
								foreach ($eyeexam['ocu_exam'] as $key => $aValues) 
								{
									
						?>
									<div class="row">
										<div class="col-md-2"></div>
										<div class="col-md-2"><label><?=$aValues->olsp_ocu_procedure;?></label></div>
										<div class="col-md-2"><label><?=$aValues->oslp_eye;?></label></div>
										<div class="col-md-2"><label><?=$aValues->oslp_proc_outcome;?></label></div>
										
									</div>
						<?php
									if($key == 2) {
										break;
									}
								}
							}
						?>
					</div>
				</div>

				<div class="box box-widget">

					<div class="box-body" style="text-align: center;">
						<button class="btn btn-success" id="btn-print">
							<i class="fa fa-print"></i> PRINT 
						</button>
					</div>
				</div>

			</div>

			<div class="col-sm-2 col-md-2">
				<div class="small-box bg-red" style="padding-top: 5px; position: fixed;">
					<center><h4 id="hPartId"><?=$this->customer->CheckInfoKey($gen_info, 'part_id');?></h4></center>
		            <div class="inner divPhoto" style="height: 130px; cursor: pointer;">
		            	<?=$gen_info['part_photo'];?>
		            </div>

		            
		            <span class="small-box-footer" style="height: 30px;">
		              	<label class="chkContainer">
		              		<?php
		              			$sChecked = $gen_info['part_household_head'] == "YES" ? "checked" : "";
		              		?>
                            <input type="checkbox" name="chkHHHead" id="chkHHHead" <?=$sChecked;?>>
                            <span class="checkmark"></span>
                        </label>
		            </span>
		        </div>
			</div>

		</div>
    </body>
</html>
<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/summary.js"></script>