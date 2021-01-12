<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>

    <body>
        <div class="row">
			<div class="col-sm-12 col-md-12">
				<form id="frmData">
					<div class="box box-warning">
						<div class="box-header with-border">
							<h3 class="box-title">
								<i class="fa fa-institution" style="font-size: 16px !important;"></i> 
								New Client Request
							</h3>

							<input type="text" data-key="DataId" style="display:none;" value="<?php echo isset($requestid) == true ? $requestid : ""; ?>">
						</div>

						<div class="box-body">

							<div class="row">
								<div class="col-md-9">
									<div class="form-group">
					    				<div class="row">
							    			<div class="col-sm-4">
							    				<label class="control-label" for="">Client / Business Partner: </label>
						        				<?=$clients;?>
						        			</div>

						        			<div class="col-sm-4 divBranch">
							                	<label for="" class="control-label">Work Location:</label>
							                	<?php
							                		if (isset($drpdown['branch'])) {
							                			echo $drpdown['branch'];
							                		} else {
							                			echo '<select class="form-control input-sm" data-key="BranchId" disabled=""></select>';		
							                		}
							                	?>							                    
							                </div>

							                <div class="col-sm-2">
							                	<label for="" class="control-label">Manpower:</label>
							                    <input type="type" class="form-control input-sm numOnly" placeholder="No." data-key="ReqManPower" data="req" value="<?php echo isset($request['request_man_power']) == true ? $request['request_man_power'] : ""; ?>" >
							                </div>
							               
						      			</div>
						      		</div>

						      		<div class="form-group">
					    				<div class="row">
							    			<div class="col-sm-5">
							    				<label class="control-label" for="">Contact Person </label>
						        				<input type="type" class="form-control input-sm " data-key="ReqContactPerson" data="req" value="<?php echo isset($request['request_contact_person']) == true ? $request['request_contact_person'] : ""; ?>" >
						        			</div>
						        			<div class="col-sm-3">
							    				<label class="control-label" for="">Contact No: </label>
						        				<input type="type" class="form-control input-sm numOnly" data-key="ReqContactNumber" data="req" value="<?php echo isset($request['request_contact_number']) == true ? $request['request_contact_number'] : ""; ?>" >
						        			</div>
						        			<div class="col-sm-4">
							    				<label class="control-label" for="">Email Address: </label>
						        				<input type="type" class="form-control input-sm" data-key="ReqContactEmail" data="req" value="<?php echo isset($request['request_contact_email']) == true ? $request['request_contact_email'] : ""; ?>" >
						        			</div>
						      			</div>
						      		</div>

						      		<div class="form-group">
					    				<div class="row">
							    			<div class="col-sm-8">
							    				<label class="control-label" for="">Salary / Other Benefits </label>
						        				<input type="type" class="form-control input-sm" placeholder="Salary and Other Benefits" data-key="ReqBenefits" data="req" value="<?php echo isset($request['request_benefits']) == true ? $request['request_benefits'] : ""; ?>" >
						        			</div>
						        			<div class="col-sm-2">
							    				<label class="control-label" for="">Interview Schedule </label>
						        				<input type="type" class="form-control input-sm datepickerfuture" data-key="ReqSchedDate" data="req" value="<?php echo isset($request['request_interview_date']) == true ? $request['request_interview_date'] : ""; ?>" >
						        			</div>
						        			<div class="col-sm-2">
							    				<label class="control-label" for="">&nbsp; </label>
						        				<input type="type" class="form-control input-sm timepicker" data-key="ReqSchedTime" data="req">
						        			</div>
						      			</div>
						      		</div>

						      		

						      		<div class="form-group">
					    				<div class="row">
							    			<div class="col-sm-3 divNature">
							    				<label class="control-label" for="">Nature of Request </label>
							    				<div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="New" data-key="ReqNature" <?php echo isset($nature) ? (in_array('New', $nature) ? " checked" : "") : "";?>>
									                  New
									                </label>
									            </div>
									            <div class="form-group">
								                
								                  	<label>
									                  <input type="checkbox" value="Augmentation" data-key="ReqNature" <?php echo isset($nature) ? (in_array('Augmentation', $nature) ? " checked" : "") : "";?>>
									                  Augmentation
									                </label>
								                </div>
								                <div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="Awol" data-key="ReqNature" <?php echo isset($nature) ? (in_array('Awol', $nature) ? " checked" : "") : "";?>>
									                  Awol
									                </label>

									             </div>
									             <div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="Replacement" data-key="ReqNature" <?php echo isset($nature) ? (in_array('Replacement', $nature) ? " checked" : "") : "";?>>
									                  Replacement
									                </label>
								                </div>
								                <div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="Reliever" data-key="ReqNature" <?php echo isset($nature) ? (in_array('Reliever', $nature) ? " checked" : "") : "";?>>
									                  Reliever / Seasonal
									                </label>
									                <?php 
									                	if (isset($nature)) {
									                		if (in_array('Reliever', $nature)) {
									                			$sDuration 	= $request['request_duration'];
									                			$sDis 		= "";
									                		} else {
									                			$sDuration 	= "";
									                			$sDis 		= "none;";
									                		}
									                	} else {
									                		$sDuration 	= "";
									                		$sDis 		= "none;";
									                	}
									                ?>
									                <input type="text" class="input-sm form-control" placeholder="Duration" data-key="NatureDuration" style="display: <?=$sDis;?>;" value="<?=$sDuration?>">
							    				</div>

							    				<div class="form-group">
							    					<label class="control-label">Start Date</label>

							    					<input type="text" class="input-sm form-control datepickerfuture" placeholder="Start Date" data="req" data-key="ReqStartDate" value="<?php echo isset($request['request_start_date']) == true ? $request['request_start_date'] : ""; ?>" >
							    				</div>
						        			</div>	

						        			<div class="col-sm-3 divQualifications">
							    				<label class="control-label" for="">Basic Qualifications </label>
							    				<div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="m" data-key="ReqQualifications" <?php echo isset($qualify) ? (in_array('m', $qualify) ? " checked" : "") : "";?>>
									                  Male
									                </label>
									            </div>
									            <div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="f" data-key="ReqQualifications" <?php echo isset($qualify) ? (in_array('f', $qualify) ? " checked" : "") : "";?>>
									                  Female
									                </label>
								                </div>
								                <div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="agelimit" data-key="ReqQualifications" <?php echo isset($qualify) ? (in_array('agelimit', $qualify) ? " checked" : "") : "";?>>
									                  Age Limit
									                </label>

									             </div>
									             <div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="h" data-key="ReqQualifications" <?php echo isset($qualify) ? (in_array('h', $qualify) ? " checked" : "") : "";?>> 
									                  High School Graduate
									                </label>
								                </div>
								                <div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="c" data-key="ReqQualifications" <?php echo isset($qualify) ? (in_array('c', $qualify) ? " checked" : "") : "";?>>
									                  College Level
									                </label>
							    				</div>
							    				<div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="cg" data-key="ReqQualifications" <?php echo isset($qualify) ? (in_array('cg', $qualify) ? " checked" : "") : "";?>>
									                  College Graduate
									                </label>
							    				</div>
							    				<div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="wexpe" data-key="ReqQualifications" <?php echo isset($qualify) ? (in_array('wexpe', $qualify) ? " checked" : "") : "";?>>
									                  With Experience
									                </label>
							    				</div>
							    				<div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="woexpe" data-key="ReqQualifications" <?php echo isset($qualify) ? (in_array('woexpe', $qualify) ? " checked" : "") : "";?>>
									                  Without Experience
									                </label>
							    				</div>
							    				<div class="form-group">
								                  	<label>
									                  <input type="checkbox" value="license" data-key="ReqQualifications" <?php echo isset($qualify) ? (in_array('license', $qualify) ? " checked" : "") : "";?>>
									                  With Driver's License
									                </label>

									                <?php 
									                	if (isset($qualify)) {
									                		if (in_array('license', $qualify)) {
									                			echo '
									                					<select class="form-control input-sm" data-key="BasicLicenseCode">
									                					<option value=""></option>
									                				';
									                			foreach (LICENSECODE as $key => $value) {
									                				$sSel =	$value == $request['request_license_code'] ? " selected" : "";

									                				echo '<option value="'.$value.'" '.$sSel.'>'.$value.'</option>';
									                			}
									                			echo '</select>';
									                		} else {
							                			?>
							                				<select class="form-control input-sm" data-key="BasicLicenseCode" style="display: none;">
											                	<option value=""></option>
											                	<option value="1">1</option>
											                	<option value="1,2">1,2</option>
											                	<option value="1,2,3">1,2,3</option>
											                </select>
							                			<?php
									                		}
									                	} else {
									                		?>
									                		<select class="form-control input-sm" data-key="BasicLicenseCode" style="display: none;">
											                	<option value=""></option>
											                	<option value="1">1</option>
											                	<option value="1,2">1,2</option>
											                	<option value="1,2,3">1,2,3</option>
											                </select>
									                <?php
									                	}
									                ?>

									                
							    				</div>
							    				
						        			</div>

						        			<div class="col-sm-3">
						        				<div class="form-group">
						        					<label class="control-label">Basic Job Description</label>
							    					<textarea rows="10" class="form-control input-sm" data-key="ReqJobDesc" data="req"><?php echo isset($request['request_job_description']) == true ? $request['request_job_description'] : ""; ?></textarea>
							    				</div>

							    				<div class="form-group">
						        					<label class="control-label">Requested By:</label>
							    					<input type="text" class="form-control input-sm" data-key="ReqRequestedBy" data="req" value="<?php echo isset($request['request_by']) == true ? $request['request_by'] : ""; ?>" >
							    				</div>
						        			</div>

						        			<div class="col-sm-3">
						        				<div class="form-group">
						        					<label class="control-label">Experience Needed:</label>
							    					<textarea rows="10" class="form-control input-sm" data-key="ReqExpeNeeded" data="req"><?php echo isset($request['request_experience']) == true ? $request['request_experience'] : ""; ?></textarea>
							    				</div>

							    				<div class="form-group">
						        					<label class="control-label">Noted By:</label>
							    					<input type="text" class="form-control input-sm" data-key="ReqNotedBy" data="req" value="<?php echo isset($request['request_noted_by']) == true ? $request['request_noted_by'] : ""; ?>" >
							    				</div>
						        			</div>
						      			</div>
						      		</div>

						      		<div class="row">
								  		<div class="col-md-12">
								  			<label class="control-label">Notes:</label>
								  			<textarea rows="5" class="form-control input-sm" data-key="ReqNotes" data="req"><?php echo isset($request['request_notes']) == true ? $request['request_notes'] : ""; ?></textarea>
								  		</div>
								  	</div>
						      	</div>

						      	<div class="col-md-3" >
						      		<label class="control-label">Positions</label>
						      		<div class="row">
						      			
						      			<div class="col-md-11 divPositions divScroll" style="height: 600px; overflow: auto;">
						      				<?php echo isset($positions) ? $positions : ""; ?>
						      				
						      			</div>
						      		</div>
						      	</div>
						  	</div>

						  	

						</div>
						<div class="box-footer">
							<button class="btn btn-warning btn-flat" data-trigger="save" data-form="frmData" >
									<i class="fa fa-save"></i> Save
								</button>
							<span class="pull-right">

								

								<button class="btn btn-danger btn-flat" data-trigger="clear" data-form="frmData">
									<i class="fa fa-undo"></i> Reset
								</button>

							</span>
						</div>

						
					</div>
				</form>
			</div>
		</div>
    </body>
</html>

<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/client_request.js"></script>
