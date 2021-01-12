<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>
    <body>
        <div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="box box-widget">
					<div class="box-header with-border">
						<h3 class="box-title">
							<i class="fa fa-list" style="font-size: 16px !important;"></i> 
							Information -
						</h3>
						<span id="spnAppName" style="font-size: 16px; font-weight: bold;"><?=ucwords(mb_strtolower($employee['agent_lname']. ', '.$employee['agent_fname'].' '.$employee['agent_mname'], 'UTF-8'));?></span>
                    	<span id="spnAppTrxId" style="display: none;"><?=$trxid;?></span>

                    	<div class="box-tools pull-left" data-toggle="tooltip" title="" data-original-title="Status">

		                	<div class="btn-group" data-toggle="btn-toggle">
		                		
		                  		<button type="button" class="btn btn-default btn-sm text-blue btn-tools " data-trigger="deploy">
		                  			<i class="fa fa-flag"></i> Deploy
		                  		</button>
		                  		<button type="button" class="btn btn-default btn-sm text-green btn-tools " data-trigger="text">
		                  			<i class="fa fa-envelope"></i> SMS
		                  		</button>
		                  		<button type="button" class="btn btn-default btn-sm text-yellow btn-tools " data-trigger="cancel">
		                  			<i class="fa fa-undo"></i> Reset
		                  		</button>
		                  		<button type="button" class="btn btn-default btn-sm text-red btn-tools " data-trigger="remove">
		                  			<i class="fa fa-trash"></i> Remove
		                  		</button>

		                	</div>
			            </div>
					</div>

					<div class="box-body">

				        <div class="row">
							<div class="col-sm-12 col-md-12">
								<div class="nav-tabs-custom" style="box-shadow: 0px 0px 0px !important;">
			        				<ul class="nav nav-tabs" >
			                            <li class="nav-item active">
			                            	<a class="nav-link" id="liPerInfo" data-toggle="pill" href="#divPerInfo" role="tab" aria-controls="divPerInfo" aria-selected="true">
			                            		<i class="fa fa-circle text-red"></i>
			                            		Personal Information
			                            	</a>
			                            </li>
			                            
			                            <li class="nav-item">
			                            	<a class="nav-link" id="liEducBack" data-toggle="pill" href="#divEducBack" role="tab" aria-controls="divEducBack" aria-selected="false">
			                            		<i class="fa fa-circle text-red"></i>
			                            		Education
			                            	</a>
			                           	</li>
			                            <li class="nav-item">
			                            	<a class="nav-link" id="liSkills" data-toggle="pill" href="#divSkills" role="tab" aria-controls="divSkills" aria-selected="false">
			                            		<i class="fa fa-circle text-red"></i>
			                            		Skills
			                            	</a>
			                            </li>
			                            <li class="nav-item">
			                            	<a class="nav-link" id="liTrains" data-toggle="pill" href="#divTrains" role="tab" aria-controls="divTrains" aria-selected="false">
			                            		<i class="fa fa-circle text-red"></i>
			                            		Trainings
			                            	</a>
			                            </li>
			                            <li class="nav-item">
			                            	<a class="nav-link" id="liEmpHist" data-toggle="pill" href="#divEmpHist" role="tab" aria-controls="divEmpHist" aria-selected="false">
			                            		<i class="fa fa-circle text-red"></i>
			                            		Employment History
			                            	</a>
			                            </li>
			                            <li class="nav-item">
			                            	<a class="nav-link" id="liMedRec" data-toggle="pill" href="#divMedRec" role="tab" aria-controls="divMedRec" aria-selected="false">
			                            		<i class="fa fa-circle text-red"></i>
			                            		Medical Records
			                            	</a>
			                            </li>
			                            <li class="nav-item">
			                            	<a class="nav-link" id="liReq" data-toggle="pill" href="#divReq" role="tab" aria-controls="divReq" aria-selected="false">
			                            		<i class="fa fa-circle text-red"></i>
			                            		Requirements
			                            	</a>
			                            </li>
			                            
			                        </ul>

			                    	<div class="tab-content" >

			                    		<div class="tab-pane active" id="divPerInfo" role="tabpanel" aria-labelledby="divPerInfo" style="margin-top: 25px;">
			                    			
				                        	<div class="row">
												<div class="col-md-2">
													<div class="form-group" style="text-align: center;">	
											            <div class=" divPhoto">
											            	<!-- <div class="divOverlay1 text-green">Update Photo</div> -->
											            	<?php

											            		$aPhoto =	explode("/", $employee['part_photo']);
											            		$sPhoto =	$aPhoto[sizeof($aPhoto) - 1];
											            		$sUrlPhoto	=	str_replace("_photo", "_Photo", $employee['part_photo']);
											            	?>
											            	<input type="text" data="req" data-key="Photo" style="display: none;" value="<?=$sPhoto;?>">
											            	<div style="background-image: url('<?=$sUrlPhoto;?>'); background-size: cover; background-repeat: no-repeat; height: 123px; width: 123px; position: relative; left: 20%;"></div>
											            </div>
													</div>

												</div>

												<div class="col-md-10">



													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
										                		<label for="" class="control-label">Status:</label>
									                    		<?=$appstatus;?>
															</div>

															<div class="col-sm-4">
										                		&nbsp;
															</div>

															<div class="col-sm-4 divDeploy" style="display: none;">
										                		<label for="" class="control-label">Date Hired:</label>
									                    		<input type="text" class="form-control input-sm" data="req" placeholder="Last Name" data-key="LastName" maxlength="150" value="<?=date('Y-m-d');?>">
															</div>
														</div>														
													</div>

													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
										                		<label for="" class="control-label">Deployment:</label>
									                    		<?=$clients?>
															</div>

															<div class="col-sm-4 divBranch">
										                		<label for="" class="control-label">Work Location:</label>
									                    		<?=$branch?>
															</div>

															<div class="col-sm-4 divPosi">
										                		<label for="" class="control-label">Desired Position:</label>
									                    		<?=$position;?>
															</div>
														</div>

													</div>

													<div class="form-group divDeploy" style="display: none;">

														<div class="row">
														
															<div class="col-sm-4 divDepts">
										                		<label for="" class="control-label">Department:</label>
									                    		<!-- <select class="form-control input-sm" data-key="DeptId" disabled=""></select> -->
									                    		<?=$department;?>
															</div>
														
															<div class="col-sm-4">
										                		<label for="" class="control-label">Supervisor:</label>
									                    		<select class="form-control input-sm" data="req" data-key="SupId" disabled=""></select>
															</div>

															<div class="col-md-2">
											                	<label for="txtLname" class="control-label">Shift Schedule:</label>
											                    <?=$dropdowns['shift'];?>
											                </div>

											                <div class="col-md-2">
											                	<label for="txtLname" class="control-label">Date Hired:</label>
							                    				<input type="text" class="form-control input-sm datebday" data="req" placeholder="Date Hired" data-key="DateHired" maxlength="150" value="<?=date("m/d/Y");?>">	
											                </div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<div class="col-sm-4">
											                	<label for="txtLname" class="control-label">Last Name:</label>
											                    <input type="text" class="form-control input-sm" data="req" placeholder="Last Name" data-key="LastName" maxlength="150" value="<?=$employee['agent_lname']?>">
											                </div>
											                
											                <div class="col-sm-4">
											                	<label for="txtFname" class="control-label">First Name:</label>
											                    <input type="text" class="form-control input-sm"  data="req" placeholder="First Name" data-key="FirstName" maxlength="150" value="<?=$employee['agent_fname']?>">
											                </div>

											                <div class="col-sm-4">
											                	<label for="txtMname" class="control-label">Middle Name:</label>
											                    <input type="text" class="form-control input-sm" data="req" placeholder="Middle Name" data-key="MiddleName" maxlength="150" value="<?=$employee['agent_mname']?>">
											                </div>
											            </div>
										            </div>
										            <div class="form-group">
										                <div class="row">
										                	<div class="col-sm-2">
										                		<label for="txtSuffix" class="control-label">Suffix Name:</label>
									                    		<input type="text" class="form-control input-sm"  placeholder="E.g. Jr, Sr, III" data-key="SuffixName" maxlength="50" value="<?=$employee['agent_sname']?>">
															</div>

															<div class="col-sm-2">
										                		<label for="txtNick" class="control-label">Nick Name:</label>
									                    		<input type="text" class="form-control input-sm" placeholder="Nick Name" data-key="NickName" maxlength="50" value="<?=$employee['agent_nname']?>">
															</div>

															<div class="col-sm-2">
											                	<label for="txtBday" class="control-label">Birthday:</label>
											                    <input type="text" class="form-control input-sm datebday" data="req" placeholder="Birthday"  readOnly="" data-key="DateOfBirth" value="<?=$employee['agent_bday']?>">
											                </div>

											                <div class="col-sm-2">
										                		<label for="txtSuffix" class="control-label">Age:</label>
									                    		<input type="text" class="form-control input-sm"  data="req" placeholder="" data-key="Age" readonly="" value="<?=$employee['agent_age']?>">
															</div>

															<div class="col-sm-4">
					                                            
					                                            <div class="row">
					                                            	<div class="col-md-6">
					                                            		<label for="txtBPlace" class="control-label">Landline:</label>
					                                            		<input type="text" class="form-control input-sm numOnly"  placeholder="Telephone" data-key="EmpTelNo" maxlength="8" value="<?=$employee['agent_telno']?>">
					                                            	</div>
					                                            	<div class="col-md-6">
					                                            		<label for="txtBPlace" class="control-label">Mobile:</label>
					                                            		<input type="text" class="form-control input-sm numOnly"  data="req" placeholder="Mobile" data-key="EmpCellNo" maxlength="11" value="<?=$employee['agent_celno']?>">
					                                            	</div>
					                                            </div>
					                                        </div>
															
											             </div>
											        </div>

										            <div class="form-group">

										            	<div class="row">

												    		<div class="col-sm-6">
												    			<label class="control-label">Home Address: </label>
											        			<input type="text" class="form-control input-sm" placeholder="House # or Lot/Blk/Phase, Street/Sitio, Purok/Subdivision" data="req" data-key="EmpAddress" value="<?=$employee['agent_address']?>">
											      			</div>

											      			<div class="col-sm-2">
											        			<label for="txtRegion" class="control-label">Region:</label>
											                    <?=$region;?>
											                </div>
											            
											                <div class="col-sm-2">
											                	<label for="txtProvince" class="control-label">City/Municipality/Province:</label>
											                	<select class="form-control input-sm" id="selCityMuniProv" name="selCityMuniProv" data="req" data-key="ClientCity">
											                		<?=$city['message'];?>
											                	</select>
											                </div>
											            
											                <div class="col-sm-2">
										                		<label for="txtBrgy" class="control-label">Barangay:</label>
										                		<select class="form-control input-sm" id="selBrgy" name="selBrgy" data-key="ClientBrgy" data="req">
											                		<?=$brgy['message'];?>
										                		</select>
											                </div>
											            </div>
												   
										            </div>


										             <div class="form-group">
										             	<div class="row">
											             	<div class="col-sm-2">
										                		<label for="txtSuffix" class="control-label">Gender:</label>
									                    		 
									                    		 <?=$gender;?>
									                    		 
															</div>

															<div class="col-sm-2">
											                	<label for="txtBday" class="control-label">Civil Status:</label>
											                   	<?=$civilstat;?>
											                </div>
															

															<div class="col-sm-2">
					                                            <label for="txtBday" class="control-label">Citizenship:</label>
					                                            <input type="text" class="form-control input-sm alphaOnly" data="req" placeholder="Citizenship" data-key="Citizenship" value="<?=$employee['agent_citizenship']?>">
					                                        </div>

					                                        <div class="col-sm-2">
					                                            <label for="txtGender" class="control-label">Religion:</label>
					                                            
					                                            <?=$dropdown['religion'];?>
					                                        </div>

					                                        <div class="col-sm-2">
											                	
											                	<div class="row">

											                		<div class="col-md-6">
											                			<label for="txtBday" class="control-label">Height:</label>
											                			<input type="text" class="form-control input-sm numOnly"  data="req" placeholder="ft." data-key="HeightFt" value="<?=$employee['agent_ht_ft']?>">
											                		</div>
											                		<div class="col-md-6">
											                			<label for="txtBday" class="control-label">&nbsp;</label>
											                			<input type="text" class="form-control input-sm numOnly"  data="req" placeholder="in." data-key="HeightIn" value="<?=$employee['agent_ht_in']?>">
											                		</div>
											                	</div>
											                    
											                </div>

											                <div class="col-sm-2">
										                		<label for="" class="control-label">Weight (pounds):</label>
									                    		<input type="text" class="form-control input-sm numOnly"data="req" placeholder="Weight (pounds)" data-key="Weight" value="<?=$employee['agent_weight']?>">
															</div>
														</div>
													</div>
													
													

													<div class="form-group">
														<div class="row">	
															<div class="col-sm-2">
										                		<label for="txtSuffix" class="control-label">SSS No.:</label>
									                    		<input type="text" class="form-control input-sm numOnly" data="req" placeholder="" data-key="SssNo" maxlength="50" value="<?=$employee['agent_sssno']?>">
															</div>

															<div class="col-sm-2">
										                		<label for="txtNick" class="control-label">TIN No.</label>
									                    		<input type="text" class="form-control input-sm numOnly" data="req" placeholder="" data-key="TinNo" maxlength="50" value="<?=$employee['agent_tinno']?>">
															</div>

															<div class="col-sm-2">
											                	<label for="txtBday" class="control-label">Philhealth No.:</label>
											                    <input type="text" class="form-control input-sm numOnly" data="req" placeholder=""   data-key="PhilhealthNo" value="<?=$employee['agent_philhealthno']?>">
											                </div>

											                <div class="col-sm-2">
										                		<label for="txtSuffix" class="control-label">Pag-ibig No.:</label>
									                    		<input type="text" class="form-control input-sm numOnly"  data="req" placeholder="" data-key="PagibigNo" value="<?=$employee['agent_pagibigno']?>">
															</div>

															<div class="col-sm-4">
										                		<label for="txtSuffix" class="control-label">Facebook Link:</label>
									                    		<input type="text" class="form-control input-sm"  data="req" placeholder="" data-key="FacebookLink" value="<?=$employee['agent_facebook']?>">
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">	
															<div class="col-sm-3">
										                		<label for="txtSuffix" class="control-label">Emergency Contact Person</label>
									                    		<input type="text" class="form-control input-sm" placeholder="" data-key="EmerPerson" maxlength="250" value="<?=$employee['agent_emergency_person']?>">
															</div>

															<div class="col-sm-6">
										                		<label for="txtNick" class="control-label">Emergency Contact Address</label>
									                    		<input type="text" class="form-control input-sm" placeholder="" data-key="EmerAddress" value="<?=$employee['agent_emergency_address']?>">
															</div>

															<div class="col-sm-3">
											                	<label for="txtBday" class="control-label">Emergency Contact Number:</label>
											                    <input type="text" class="form-control input-sm numOnly" placeholder=""   data-key="EmerNumber" maxlength="50" value="<?=$employee['agent_emergency_contact']?>">
											                </div>

														</div>
													</div>

													<div class="form-group">
														<div class="row">	
															<div class="col-sm-12">

										                		<label for="txtSuffix" class="control-label">Please state your intent to apply for your  desired position with your qualification and related experience (if any).</label>

									                    		<textarea rows="5" class="form-control input-sm" data-key="AgentNote"><?php echo trim($employee['agent_note']);?></textarea>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">	
															<div class="col-sm-12">

										                		<label for="txtSuffix" class="control-label">Comments / Notes.</label>

									                    		<textarea rows="5" class="form-control input-sm" data-key="AgentComments"><?php echo trim($employee['agent_comments']);?></textarea>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<!-- Educational Background -->
			                    		<div class="tab-pane fade" id="divEducBack" role="tabpanel" aria-labelledby="divEducBack">
			                    			<?php
			                    				if (sizeof($details['educ']) > 0) 
			                    				{
			                    					$nCntr 	=	1;
			                    					foreach ($details['educ'] as $nKey => $aValue) {

			                    						$sCategory 	=	$this->hatvclib->DropEducAttain($aValue['educ_type']);
			                    						

			                    						$sRemove 	=	$nCntr > 1 ? '<button class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times" title="Remove"></i></button>' : '';
			                    						echo '<div class="row divOrig">
							                                    <div class="col-md-12">
							                                        <div class="row">
							                                            <div class="col-sm-2">
							                                                <label for="selEducCat" class="control-label">Category:</label>
							                                                '.$sCategory.'
							                                            </div>

							                                            <div class="col-sm-3">
							                                                <label for="" class="control-label">School Name:</label>
							                                                <input type="text" class="form-control input-sm" data="req" placeholder="School Name" data-key="EducSchool" value="'.ucwords(mb_strtolower($aValue['educ_school'], 'UTF-8')).'">
							                                            </div>

							                                            <div class="col-sm-3">
							                                                <label for="" class="control-label">Course Name:</label>
							                                                <input type="text" class="form-control input-sm" placeholder="Course Name" data-key="EducCourse"  value="'.ucwords(mb_strtolower($aValue['educ_course'], 'UTF-8')).'">
							                                            </div>
							                                           

							                                            <div class="col-sm-1">
							                                                <label for="" class="control-label">Year Start:</label>
							                                                <input type="text" class="input-sm form-control dateyearpicker numOnly" data="req" data-key="EducYearStart"  value="'.$aValue['educ_year_start'].'">
							                                            </div>
							                                            <div class="col-sm-1">
							                                                <label for="" class="control-label">Year End:</label>
							                                                <input type="text" class="input-sm form-control dateyearpicker numOnly" data="req" data-key="EducYearEnd" value="'.$aValue['educ_year_end'].'">
							                                            </div>

							                                            <div class="col-sm-1">
							                                                <label for="" class="control-label" title="Attach Image File">Attachment:</label>
							                                                <div class="form-group">
							                                                    <button class="btn btn-primary btn-attach" title="Attach Image File"><i class="fa fa-paperclip"></i></button>
							                                                    <input type="file" style="display:none;" class="fileInput" />
							                                                    <input type="text" style="display:none;" data-key="EducFile" value="'.$aValue['educ_attachment'].'">
							                                                </div>
							                                            </div>

							                                            <div class="col-sm-1 divRemove"> '.$sRemove.' </div>
							                                        </div>
							                                    </div>
							                                </div>';
							                            $nCntr++;

			                    					}
			                    				}
			                    				else 
			                    				{
			                    			?>
					                    			<div class="row divOrig">
					                                    <div class="col-md-12">
					                                        <div class="row">
					                                            <div class="col-sm-2">
					                                                <label for="selEducCat" class="control-label">Category:</label>
					                                                <select class="form-control input-sm" data="req" data-key="EducType">
					                                                    <option value=""></option>
					                                                    <option value="e">Elementary</option>
					                                                    <option value="h">High School</option>
					                                                    <option value="s">Senior High School</option>
					                                                    <option value="v">Vocational</option>
					                                                    <option value="c">College</option>
					                                                    <option value="m">Mastery/Doctorate</option>
					                                                </select>
					                                            </div>

					                                            <div class="col-sm-3">
					                                                <label for="" class="control-label">School Name:</label>
					                                                <input type="text" class="form-control input-sm" data="req" placeholder="School Name" data-key="EducSchool">
					                                            </div>

					                                            <div class="col-sm-3">
					                                                <label for="" class="control-label">Course Name:</label>
					                                                <input type="text" class="form-control input-sm" placeholder="Course Name" data-key="EducCourse">
					                                            </div>
					                                           

					                                            <div class="col-sm-1">
					                                                <label for="" class="control-label">Year Start:</label>
					                                                <input type="text" class="input-sm form-control dateyearpicker numOnly" data="req" data-key="EducYearStart">
					                                            </div>
					                                            <div class="col-sm-1">
					                                                <label for="" class="control-label">Year End:</label>
					                                                <input type="text" class="input-sm form-control dateyearpicker numOnly" data="req" data-key="EducYearEnd">
					                                            </div>

					                                            <div class="col-sm-1">
					                                                <label for="" class="control-label" title="Attach Image File">Attachment:</label>
					                                                <div class="form-group">
					                                                    <button class="btn btn-primary btn-attach" title="Attach Image File"><i class="fa fa-paperclip"></i></button>
					                                                    <input type="file" style="display:none;" class="fileInput" />
					                                                    <input type="text" style="display:none;" data-key="EducFile">
					                                                </div>
					                                            </div>

					                                            <div class="col-sm-1 divRemove"></div>
					                                        </div>
					                                    </div>
					                                </div>
			                    			<?php
			                    				}
			                    			?>
			                    			
			                    		</div>

			                    		<!-- Skills -->
			                    		<div class="tab-pane fade" id="divSkills" role="tabpanel" aria-labelledby="divSkills">

			                                
	                                    	<?php

	                                    		if (sizeof($details['skills']) > 0)
	                                    		{
	                                    			$nCntr 	=	1;
	                    							foreach ($details['skills'] as $nKey => $aValue) {
	                    								$sSkillLevel 	=	$this->hatvclib->DropSkillLevel($aValue['skills_level']);

	                    								$sRemove 	=	$nCntr > 1 ? '<button class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times" title="Remove"></i></button>' : '';
	                    								echo '<div class="row divOrig">
				                                    			<div class="col-md-12">
					                                    			<div class="row">
							                                            <div class="col-md-4">
							                                                <label for="txtSkills" class="control-label">Skills:</label>
							                                                <input type="text" class="form-control input-sm" data="req" placeholder="Skills" data-key="Skills" value="'.ucfirst(mb_strtolower($aValue['skills'], 'UTF-8')).'">
							                                            </div>
							                                            <div class="col-md-4">
							                                                <label for="txtSkillDetails" class="control-label">Description:</label>
							                                                <input type="text" class="form-control input-sm" data="req" placeholder="Description" data-key="SkillsDesc" value="'.ucfirst(mb_strtolower($aValue['skills_description'], 'UTF-8')).'">
							                                            </div>
							                                            <div class="col-md-2">
							                                                <label for="txtSkillLevel" class="control-label">Level:</label>
							                                                '.$sSkillLevel.'
							                                            </div>
							                                            
							                                        
							                                            <div class="col-md-1">
							                                                <label for="txtSkillAttach" class="control-label">Attachment:</label>
							                                                <div class="form-group">
							                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
							                                                    <input type="file" style="display:none;" />
							                                                    <input type="text" style="display:none;" data-key="SkillFile" value="'.ucfirst(mb_strtolower($aValue['skills_attachment'], 'UTF-8')).'">
							                                                </div>
							                                            </div>
							                                            <div class="col-sm-1 divRemove"> '.$sRemove.' </div>
							                                        </div>
							                                    </div>
							                                </div>';
							                             $nCntr++;
	                    							}
	                                    		}
	                                    		else 
	                                    		{

	                                    	?>
	                                    		<div class="row divOrig">
	                                    			<div class="col-md-12">
		                                    			<div class="row">
				                                            <div class="col-md-4">
				                                                <label for="txtSkills" class="control-label">Skills:</label>
				                                                <input type="text" class="form-control input-sm" data="req" placeholder="Skills" data-key="Skills">
				                                            </div>
				                                            <div class="col-md-4">
				                                                <label for="txtSkillDetails" class="control-label">Description:</label>
				                                                <input type="text" class="form-control input-sm" data="req" placeholder="Description" data-key="SkillsDesc">
				                                            </div>
				                                            <div class="col-md-2">
				                                                <label for="txtSkillLevel" class="control-label">Level:</label>
				                                                <select class="form-control input-sm" data-key="SkillsLevel">
				                                                    <option value=""></option>
				                                                    <option value="b">Beginner</option>
				                                                    <option value="i">Intermediate</option>
				                                                    <option value="p">Proficient</option>
				                                                    <option value="e">Expert</option>
				                                                </select>
				                                            </div>
				                                            
				                                        
				                                            <div class="col-md-1">
				                                                <label for="txtSkillAttach" class="control-label">Attachment:</label>
				                                                <div class="form-group">
				                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
				                                                    <input type="file" style="display:none;" />
				                                                    <input type="text" style="display:none;" data-key="SkillFile">
				                                                </div>
				                                            </div>
				                                            <div class="col-md-1 divRemove"></div>
				                                        </div>
				                                    </div>
				                                </div>
	                                    	<?php

	                                    		}

	                                    	?>

			                            </div>

			                            <!-- Trainings -->
			                            <div class="tab-pane fade" id="divTrains" role="tabpanel" aria-labelledby="divTrains" data-key="trainings">
			                            	<?php
			                            		if (sizeof($details['trains']) > 0) 
			                    				{
			                    					$nCntr 	=	1;
			                    					foreach ($details['trains'] as $nKey => $aValue) {

			                    						$sRemove 	=	$nCntr > 1 ? '<button class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times" title="Remove"></i></button>' : '';

			                    						echo '<div class="row divOrig">
					                                            <div class="col-sm-3">
					                                                <label for="txtTrainName" class="control-label">Name:</label>
					                                                <input type="text" class="form-control input-sm" data="req" placeholder="Training Name/Title" data-key="TrainTitle" value="'.ucwords(mb_strtolower($aValue['training_title'], 'UTF-8')).'">
					                                            </div>

					                                            <div class="col-sm-5">
					                                                <label for="txtTrainGrade" class="control-label">Training Description:</label>
					                                                <input type="text" class="form-control input-sm" data="req" placeholder="Description" data-key="TrainDesc" value="'.ucwords(mb_strtolower($aValue['training_description'], 'UTF-8')).'">
					                                            </div>

					                                            <div class="col-sm-2">
					                                                <label for="txtTrainRefNo" class="control-label">Document No.:</label>
					                                                <input type="text" class="form-control input-sm " data="req" placeholder="Reference No." data-key="TrainDocNo" value="'.ucwords(mb_strtolower($aValue['training_doc_no'], 'UTF-8')).'">
					                                            </div>

					                                            <div class="col-sm-1">
					                                                <label for="txtTrainAttach" class="control-label">Attachment:</label>
					                                                <div class="form-group">
					                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
					                                                    <input type="file" style="display:none;" />
					                                                    <input type="text" style="display:none;" data-key="TrainFile">
					                                                </div>
					                                            </div>
					                                            <div class="col-sm-1 divRemove"> '.$sRemove.' </div>
							                                </div>';
							                            $nCntr++;
	                                    			}
	                                    		} else {
	                                    	?>
	                                    		<div class="row divOrig">
		                                            <div class="col-sm-3">
		                                                <label for="txtTrainName" class="control-label">Name:</label>
		                                                <input type="text" class="form-control input-sm" data="req" placeholder="Training Name/Title" data-key="TrainTitle">
		                                            </div>

		                                            <div class="col-sm-5">
		                                                <label for="txtTrainGrade" class="control-label">Training Description:</label>
		                                                <input type="text" class="form-control input-sm" data="req" placeholder="Description" data-key="TrainDesc">
		                                            </div>

		                                            <div class="col-sm-2">
		                                                <label for="txtTrainRefNo" class="control-label">Document No.:</label>
		                                                <input type="text" class="form-control input-sm " data="req" placeholder="Reference No." data-key="TrainDocNo">
		                                            </div>

		                                            <div class="col-sm-1">
		                                                <label for="txtTrainAttach" class="control-label">Attachment:</label>
		                                                <div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="TrainFile">
		                                                </div>
		                                            </div>
		                                            <div class="col-sm-1 divRemove"></div>
				                                </div>	
	                                    	<?php
	                                    		}
	                                    	?>
			                                
			                            </div>


			                            <!-- Employment History -->
			                            <div class="tab-pane fade" id="divEmpHist" role="tabpanel" aria-labelledby="divEmpHist">
			                                
	                                    	<?php
			                            		if (sizeof($details['employ']) > 0) 
			                    				{
			                    					$nCntr 	=	1;
			                    					foreach ($details['employ'] as $nKey => $aValue) {

			                    						$sRemove 	=	$nCntr > 1 ? '<button class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times" title="Remove"></i></button>' : '';

			                    						echo '<div class="row divOrig">
						                                    <div class="col-sm-12">
						                                    	<div class="form-group">
							                                        <div class="row">
							                                            <div class="col-sm-3">
							                                                <label for="txtJobPosi" class="control-label">Job Position:</label>
							                                                <input type="text" class="form-control input-sm" data="req" placeholder="Job Position" data-key="JobPosition" value="'.ucwords(mb_strtolower($aValue['job_position'], 'UTF-8')).'">
							                                            </div>
							                                            <div class="col-sm-4">
							                                                <label for="txtJobEmp" class="control-label">Employer Name:</label>
							                                                <input type="text" class="form-control input-sm" data="req" placeholder="Employer Name" data-key="JobEmployer" value="'.ucwords(mb_strtolower($aValue['job_employer'], 'UTF-8')).'">
							                                            </div>

							                                            <div class="col-sm-5">
							                                                <label for="txtJobEmpAdd" class="control-label">Employer Address:</label>
							                                                <input type="text" class="form-control input-sm" data="req" placeholder="Employer Address" data-key="JobAddress" value="'.ucwords(mb_strtolower($aValue['job_address'], 'UTF-8')).'">
							                                            </div>

							                                        </div>
							                                    </div>
							                                    <div class="form-group">
							                                        <div class="row">
							                                            <div class="col-sm-3">
							                                                <label for="txtJobReason" class="control-label">Reason for Leaving:</label>
							                                                <textarea rows="10" class="form-control input-sm" data-key="JobReason">'.trim($aValue['job_reason']).'</textarea>
							                                            </div>
							                                            <div class="col-sm-3">
							                                                <label for="txtJobDuties" class="control-label">Duties/Responsibilities:</label>
							                                                <textarea rows="10" class="form-control input-sm" data-key="JobDuties">'.trim($aValue['job_duties']).'</textarea>
							                                            </div>
							                                            <div class="col-sm-3">
							                                                <label for="txtJobAccomp" class="control-label">Accomplishments:</label>
							                                                <textarea rows="10" class="form-control input-sm" data-key="JobAccomp"> '.trim($aValue['job_accomplishment']).'</textarea>
							                                            </div>
							                                            <div class="col-sm-3">
							                                            	<div class="row">
							                                                    <div class="col-md-12">
							                                                       <label for="txtJobDateStarted" class="control-label">Date Started:</label>
							                                                		<input type="text" class="form-control input-sm datepicker" data="req" placeholder="" data-key="JobStarted" value="'.$aValue['job_started'].'">
							                                                    </div>
							                                                </div>
							                                                <div class="row">
							                                                    <div class="col-md-12">
							                                                       <label for="txtJobDateEnded" class="control-label">Date Ended:</label>
							                                                		<input type="text" class="form-control input-sm datepicker" data="req" placeholder="" data-key="JobEnded" value="'.$aValue['job_ended'].'">
							                                                    </div>
							                                                </div>
							                                                
							                                                <div class="row">
							                                                    <div class="col-md-9">
							                                                        <label for="txtSkillAttach" class="control-label" title="Attach Certificate">Attachment:</label>
							                                                       	<div class="form-group">
									                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
									                                                    <input type="file" style="display:none;" />
									                                                    <input type="text" style="display:none;" data-key="JobFile">
									                                                </div>
							                                                    </div>
							                                                    <div class="col-sm-1 divRemove"> '.$sRemove.' </div>
							                                                </div>
							                                            </div>
							                                            
							                                        </div>
							                                    </div>
						                                    </div>
						                                </div>';
						                            	$nCntr++;
			                    					}
			                    				} else {
			                    			?>
		                    						<div class="row divOrig">
					                                    <div class="col-sm-12">
					                                    	<div class="form-group">
						                                        <div class="row">
						                                            <div class="col-sm-3">
						                                                <label for="txtJobPosi" class="control-label">Job Position:</label>
						                                                <input type="text" class="form-control input-sm" data="req" placeholder="Job Position" data-key="JobPosition">
						                                            </div>
						                                            <div class="col-sm-4">
						                                                <label for="txtJobEmp" class="control-label">Employer Name:</label>
						                                                <input type="text" class="form-control input-sm" data="req" placeholder="Employer Name" data-key="JobEmployer">
						                                            </div>

						                                            <div class="col-sm-5">
						                                                <label for="txtJobEmpAdd" class="control-label">Employer Address:</label>
						                                                <input type="text" class="form-control input-sm" data="req" placeholder="Employer Address" data-key="JobAddress">
						                                            </div>

						                                        </div>
						                                    </div>
						                                    <div class="form-group">
						                                        <div class="row">
						                                            <div class="col-sm-3">
						                                                <label for="txtJobReason" class="control-label">Reason for Leaving:</label>
						                                                <textarea rows="10" class="form-control input-sm" data-key="JobReason"></textarea>
						                                            </div>
						                                            <div class="col-sm-3">
						                                                <label for="txtJobDuties" class="control-label">Duties/Responsibilities:</label>
						                                                <textarea rows="10" class="form-control input-sm" data-key="JobDuties"></textarea>
						                                            </div>
						                                            <div class="col-sm-3">
						                                                <label for="txtJobAccomp" class="control-label">Accomplishments:</label>
						                                                <textarea rows="10" class="form-control input-sm" data-key="JobAccomp"></textarea>
						                                            </div>
						                                            <div class="col-sm-3">
						                                            	<div class="row">
						                                                    <div class="col-md-12">
						                                                       <label for="txtJobDateStarted" class="control-label">Date Started:</label>
						                                                		<input type="text" class="form-control input-sm datepicker" data="req" placeholder="" data-key="JobStarted">
						                                                    </div>
						                                                </div>
						                                                <div class="row">
						                                                    <div class="col-md-12">
						                                                       <label for="txtJobDateEnded" class="control-label">Date Ended:</label>
						                                                		<input type="text" class="form-control input-sm datepicker" data="req" placeholder="" data-key="JobEnded">
						                                                    </div>
						                                                </div>
						                                                
						                                                <div class="row">
						                                                    <div class="col-md-9">
						                                                        <label for="txtSkillAttach" class="control-label" title="Attach Certificate">Attachment:</label>
						                                                       	<div class="form-group">
								                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
								                                                    <input type="file" style="display:none;" />
								                                                    <input type="text" style="display:none;" data-key="JobFile">
								                                                </div>
						                                                    </div>
						                                                    <div class="col-sm-1 divRemove"></div>
						                                                </div>
						                                            </div>
						                                            
						                                        </div>
						                                    </div>
					                                    </div>
					                                </div>
			                    			<?php
			                    					
			                    				}
			                            	?>

			                            </div>

			                            <!-- Medical History -->
			                            <div class="tab-pane fade" id="divMedRec" role="tabpanel" aria-labelledby="divMedRec">
			                                
	                                    	<?php
			                            		if (sizeof($details['medic']) > 0) 
			                    				{
			                    					$nCntr 	=	1;
			                    					foreach ($details['medic'] as $nKey => $aValue) {

			                    						$sRemove 	=	$nCntr > 1 ? '<button class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times" title="Remove"></i></button>' : '';

			                    						echo '<div class="row divOrig">
							                                    <div class="col-sm-12">
							                                    	<div class="form-group">
								                                        <div class="row">
								                                            <div class="col-sm-4">
								                                                <label for="txtMedDesc" class="control-label">Medical Description:</label>
								                                                <input type="text" class="form-control input-sm" data="req" placeholder="Medical Description" data-key="MedDesc"  value="'.ucwords(mb_strtolower($aValue['medical_description'], 'UTF-8')).'">
								                                            </div>

								                                            <div class="col-sm-5">
								                                                <label for="txtMedHosp" class="control-label">Clinic / Hospital:</label>
								                                                <input type="text" class="form-control input-sm " data="req" placeholder="Clinic/Hospital" data-key="MedHosp"  value="'.ucwords(mb_strtolower($aValue['medical_hospital'], 'UTF-8')).'">
								                                            </div>

								                                            <div class="col-sm-3">
								                                                <label for="txtMedStatus" class="control-label">Status:</label>
								                                                <input type="text" class="form-control input-sm" placeholder="Medical Status" data-key="MedStatus"  value="'.ucwords(mb_strtolower($aValue['medical_status'], 'UTF-8')).'">
								                                            </div>
								                                        </div>
								                                    </div>
								                                    <div class="form-group">
								                                        <div class="row">
								                                        	<div class="col-sm-2">
								                                                <label for="txtMedDateTaken" class="control-label">Date Taken:</label>
								                                                <input type="text" class="form-control input-sm datepicker" data="req" placeholder="" data-key="MedTaken"  value="'.$aValue['medical_taken'].'">
								                                            </div>
								                                            <div class="col-sm-2">
								                                                <label for="txtMedIssuedDate" class="control-label">Date of Issuance:</label>
								                                                <input type="text" class="form-control input-sm datepicker" data="req" placeholder="" data-key="MedIssued"  value="'.$aValue['medical_issued'].'">
								                                            </div>
								                                            <div class="col-sm-2">
								                                                <label for="txtMedExpDate" class="control-label">Expiry Date:</label>
								                                                <input type="text" class="form-control input-sm datepicker" data="req" placeholder="" data-key="MedExpiry"  value="'.$aValue['medical_expiry'].'">
								                                            </div>


								                                            <div class="col-sm-1">
								                                                <label for="txtSkillAttach" class="control-label" title="Attach Certificate">Attachment:</label>
								                                               	<div class="form-group">
								                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
								                                                    <input type="file" style="display:none;" />
								                                                    <input type="text" style="display:none;" data-key="MedFile">
								                                                </div>
								                                            </div>
								                                            <div class="col-sm-1 divRemove"> '.$sRemove.' </div>
								                                        </div>
								                                    </div>
							                                    </div>
							                                </div>';
							                             $nCntr++;
			                    					}
			                    				}
			                    				else{
		                    				?>
		                    					<div class="row divOrig">
				                                    <div class="col-sm-12">
				                                    	<div class="form-group">
					                                        <div class="row">
					                                            <div class="col-sm-4">
					                                                <label for="txtMedDesc" class="control-label">Medical Description:</label>
					                                                <input type="text" class="form-control input-sm" data="req" placeholder="Medical Description" data-key="MedDesc">
					                                            </div>

					                                            <div class="col-sm-5">
					                                                <label for="txtMedHosp" class="control-label">Clinic / Hospital:</label>
					                                                <input type="text" class="form-control input-sm " data="req" placeholder="Clinic/Hospital" data-key="MedHosp">
					                                            </div>

					                                            <div class="col-sm-3">
					                                                <label for="txtMedStatus" class="control-label">Status:</label>
					                                                <input type="text" class="form-control input-sm" placeholder="Medical Status" data-key="MedStatus">
					                                            </div>
					                                        </div>
					                                    </div>
					                                    <div class="form-group">
					                                        <div class="row">
					                                        	<div class="col-sm-2">
					                                                <label for="txtMedDateTaken" class="control-label">Date Taken:</label>
					                                                <input type="text" class="form-control input-sm datepicker" data="req" placeholder="" data-key="MedTaken">
					                                            </div>
					                                            <div class="col-sm-2">
					                                                <label for="txtMedIssuedDate" class="control-label">Date of Issuance:</label>
					                                                <input type="text" class="form-control input-sm datepicker" data="req" placeholder="" data-key="MedIssued">
					                                            </div>
					                                            <div class="col-sm-2">
					                                                <label for="txtMedExpDate" class="control-label">Expiry Date:</label>
					                                                <input type="text" class="form-control input-sm datepicker" data="req" placeholder="" data-key="MedExpiry">
					                                            </div>


					                                            <div class="col-sm-1">
					                                                <label for="txtSkillAttach" class="control-label" title="Attach Certificate">Attachment:</label>
					                                               	<div class="form-group">
					                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
					                                                    <input type="file" style="display:none;" />
					                                                    <input type="text" style="display:none;" data-key="MedFile">
					                                                </div>
					                                            </div>
					                                            <div class="col-sm-1 divRemove"></div>
					                                        </div>
					                                    </div>
				                                    </div>
				                                </div>
	                    					<?php
			                    				}
			                            	?>

                        				</div>

                        				<div class="tab-pane fade" id="divReq" role="tabpanel" aria-labelledby="divReq">
                        					<div class="form-group">
												<div class="row">
													<div class="col-md-3">
								                		<label for="" class="control-label">NBI Clearance:</label>
								                		<div class="form-group">
	                                                    	<button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
	                                                    	<input type="file" style="display:none;" />
	                                                    	<input type="text" style="display:none;" data-key="NbiFile">
	                                                    </div>
													</div>

													<div class="col-md-3">
								                		<label for="" class="control-label">Police Clearance:</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="Policefile">
		                                                </div>
													</div>

													<div class="col-md-3">
								                		<label for="" class="control-label">Barangay Clearance:</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="BrgyFile">
		                                                </div>
													</div>

													<div class="col-md-3">
								                		<label for="" class="control-label">Proof of Residence</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="ResiFile">
		                                                </div>
													</div>
												</div>

											</div>

											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
								                		<label for="" class="control-label">Certificate of previous employment:</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="EmpCert">
		                                                </div>
													</div>

													<div class="col-md-3">
								                		<label for="" class="control-label">Birth Certificate:</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="BirthCert">
		                                                </div>
													</div>

													<div class="col-md-3">
								                		<label for="" class="control-label">Marriage Contract (if applicable):</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="MarrCont">
		                                                </div>
													</div>

													<div class="col-md-3">
								                		<label for="" class="control-label">Health Certificate</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="HealthCert">
		                                                </div>
													</div>
												</div>

											</div>

											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
								                		<label for="" class="control-label">Medical Results:</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="MedRes">
		                                                </div>
													</div>

													<div class="col-md-3">
								                		<label for="" class="control-label">X-ray Results:</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="XrayRes">
		                                                </div>
													</div>

													<div class="col-md-3">
								                		<label for="" class="control-label">Drug Test Results:</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="DrugRes">
		                                                </div>
													</div>

													<div class="col-md-3">
								                		<label for="" class="control-label">Professional Driver's License</label>
								                		<div class="form-group">
		                                                    <button class="btn btn-primary btn-attach"><i class="fa fa-paperclip"></i></button>
		                                                    <input type="file" style="display:none;" />
		                                                    <input type="text" style="display:none;" data-key="DriverLic">
		                                                </div>
													</div>
												</div>

											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-md-12">
														<i><p>Note : Green button indicates file was attached.</p></i>
													</div>
												</div>
											</div>
			                                
                        				</div>

                        				

			                    	</div>
			                    </div>
			                </div>

			            </div>
			        </div>
			        <div class="box-footer">
						<button type="submit" class="btn btn-success btn-flat" data-trigger="save" data-form="divPerInfo">
							<i class="fa fa-save"></i> <span>Update</span>
						</button>

                        <button type="button" class="btn btn-warning btn-flat fa-pull-right" title="Add New Item" data-div="divPerInfo" style="display: none;">
                        	<i class="fa fa-plus"></i> Add
                        </button>
					</div>
			    </div>
			</div>
		</div>

    </body>

    <div id="modalMessage" class="modal fade" role="dialog">
        <form class="form-horizontal" autocomplete="off">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> <i class="fa fa-send"></i> Send Message </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea rows="10" class="input-sm form-control" id="txtMessage"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <span class="pull-right">                            
                            <button class="btn btn-primary btn-flat" data-form="modalMessage" data-trigger='sendsms'>
                                <i class="fa fa-send"></i> Send Message
                            </button>

                        </span>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <div class="modal fade in" id="modalUploadPhoto" style="padding-right: 17px;">
        <div class="modal-dialog modal-sm">
        	<form id="frmUpload" name="frmUpload" enctype="multipart/form-data">
	            <div class="modal-content">
	              	<div class="modal-header">
	                	<h4 class="modal-title">Upload Photo</h4>
	                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
	              	</div>
	              	<div class="modal-body">
	              		<div class="row">
	              			<div class="col-md-12">
					            <div class="box-body box-photo" style="text-align: center;">

					            	<img src="images/no_photo.png">
					          	</div>

					          	<input type="file" name="txtPhoto" id="txtPhoto" class="form-control input-sm" style="display: none;" data="req">
	              			</div>
	              		</div>
	              	</div>
	              	<div class="modal-footer signature-pad--actions">
	                	<!-- <button type="button" class="btn button clear btn btn-primary pull-left" data-action="clear">Clear</button> -->
	                	<button class="btn save btn btn-success" data-action="save-png" disabled="">Upload</button>
	              	</div>
	            </div>
            </form>
        </div>
    </div>

   
</html>

<script src="lib/design/bower_components/jquery/jquery.min.js"></script>

<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/general_information.js"></script>
