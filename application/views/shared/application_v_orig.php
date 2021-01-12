<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head>
    	<link rel="stylesheet" href="lib/kg_esign_sdk/css/signature-pad.css">
    </head>
    <body>
        <div class="row">
			<div class="col-sm-12 col-md-12">
						
					<!-- <div class="box box-warning">
						<div class="box-body"> -->
							<div class="nav-tabs-custom">
	            				<ul class="nav nav-tabs">
		                            <li class="nav-item active"><a class="nav-link" id="liPerInfo" data-toggle="pill" href="#divPerInfo" role="tab" aria-controls="divPerInfo" aria-selected="true">Personal Information</a></li>
		                            <li class="nav-item disabled"><a class="nav-link" id="liAddress" data-toggle="pill" href="#divAddress" role="tab" aria-controls="divAddress" aria-selected="true">Address & Contacts</a></li>
		                            <li class="nav-item disabled"><a class="nav-link " id="liEducBack" data-toggle="pill" href="#divEducBack" role="tab" aria-controls="divEducBack" aria-selected="false">Education</a></li>
		                            <li class="nav-item disabled"><a class="nav-link" id="liSkills" data-toggle="pill" href="#divSkills" role="tab" aria-controls="divSkills" aria-selected="false">Skills</a></li>
		                            <li class="nav-item disabled"><a class="nav-link" id="liTrains" data-toggle="pill" href="#divTrains" role="tab" aria-controls="divTrains" aria-selected="false">Trainings</a></li>
		                            <li class="nav-item disabled"><a class="nav-link" id="liReq" data-toggle="pill" href="#divReq" role="tab" aria-controls="divReq" aria-selected="false">Government</a></li>
		                            <li class="nav-item disabled"><a class="nav-link" id="liEmpHist" data-toggle="pill" href="#divEmpHist" role="tab" aria-controls="divEmpHist" aria-selected="false">Employment History</a></li>
		                            <li class="nav-item disabled"><a class="nav-link" id="liMedRec" data-toggle="pill" href="#divMedRec" role="tab" aria-controls="divMedRec" aria-selected="false">Medical Records</a></li>
		                            
		                        </ul>

		                    	<div class="tab-content">
		                    		<!-- Start of Personal Information -->
		                    		<div class="tab-pane active" id="divPerInfo" role="tabpanel" aria-labelledby="divPerInfo" style="margin-top: 25px;">
		                    			<form class="form-horizontal" autocomplete="off">
				                        	<div class="row" >
												<div class="col-md-2" style="text-align: center;">
													<div class="form-group">							
											            <div class=" divPhoto">
											            	<img class="img-circle" src='images/no_photo.png' style='max-width: 130px; border: 1px solid #e5e5e5; padding: 10px;'>
											            	<input type="text" data-key="Photo" style="display: none;">
											            </div>
													</div>

													<div class="form-group">
											            <div class="divSign">
											            	<img src='' style='width: 150px; padding: 10px;'>
											            	<input type="text" data-key="Signature" style="display: none;">
											            </div>
													</div>
												</div>

												<div class="col-md-10">
													<div class="form-group">
														<div class="col-sm-2">
										                	<label for="" class="control-label">Desired Position (Option 1):</label>
										                    <select class="form-control input-sm" data-key="Position1" data="req">
			                                                    <option value=""></option>
			                                                    <option value="p1">Position 1</option>
			                                                    <option value="p2">Position 2</option>
			                                                    <option value="p3">Position 3</option>
			                                                    <option value="p4">Position 4</option>
			                                                    
			                                                </select>
										                </div>

										                <div class="col-sm-2">
										                	<label for="" class="control-label"> (Option 2):</label>
										                    <select class="form-control input-sm" data-key="Position2" data="req">
			                                                    <option value=""></option>
			                                                    <option value="p1">Position 1</option>
			                                                    <option value="p2">Position 2</option>
			                                                    <option value="p3">Position 3</option>
			                                                    <option value="p4">Position 4</option>
			                                                    
			                                                </select>
										                </div>

										                <div class="col-sm-2">
										                	<label for="" class="control-label">(Option 3):</label>
										                    <select class="form-control input-sm" data-key="Position3" data="req">
			                                                    <option value=""></option>
			                                                    <option value="p1">Position 1</option>
			                                                    <option value="p2">Position 2</option>
			                                                    <option value="p3">Position 3</option>
			                                                    <option value="p4">Position 4</option>
			                                                    
			                                                </select>
										                </div>

										                <div class="col-sm-2">
										                	<label for="txtLname" class="control-label">Expected Salary:</label>
										                    <input type="text" class="form-control input-sm autoNumeric" data="req" placeholder="Expected Salary" data-key="Salary">
										                </div>
													</div>
													<div class="form-group">
														<div class="col-sm-4">
										                	<label for="txtLname" class="control-label">Last Name:</label>
										                    <input type="text" class="form-control input-sm" data="req" placeholder="Last Name" data-key="LastName" maxlength="150">
										                </div>
										                
										                <div class="col-sm-4">
										                	<label for="txtFname" class="control-label">First Name:</label>
										                    <input type="text" class="form-control input-sm"  data="req" placeholder="First Name" data-key="FirstName" maxlength="150">
										                </div>

										                <div class="col-sm-4">
										                	<label for="txtMname" class="control-label">Middle Name:</label>
										                    <input type="text" class="form-control input-sm" data="req" placeholder="Middle Name" data-key="MiddleName" maxlength="150">
										                </div>
										            </div>
										            <div class="form-group">
										                
									                	<div class="col-sm-2">
									                		<label for="txtSuffix" class="control-label">Suffix Name:</label>
								                    		<input type="text" class="form-control input-sm"  placeholder="E.g. Jr, Sr, III" data-key="SuffixName" maxlength="50">
														</div>

														<div class="col-sm-2">
									                		<label for="txtNick" class="control-label">Nick Name:</label>
								                    		<input type="text" class="form-control input-sm" data="req" placeholder="Nick Name" data-key="NickName" maxlength="50">
														</div>

														<div class="col-sm-2">
										                	<label for="txtBday" class="control-label">Birthday:</label>
										                    <input type="text" class="form-control input-sm datepicker" data="req" placeholder="Birthday"  readOnly=""  data-key="DateOfBirth">
										                </div>

										                <div class="col-sm-2">
									                		<label for="txtSuffix" class="control-label">Age:</label>
								                    		<input type="text" class="form-control input-sm"  data="req" placeholder="" data-key="Age" readonly="">
														</div>

														<div class="col-sm-4">
			                                                <label for="txtBPlace" class="control-label">Birth Place:</label>
			                                                <input type="text" class="form-control input-sm" id="txtBPlace" name="txtBPlace" data="req" placeholder="Birthplace" data-key="BirthPlace">
			                                            </div>
														
										             </div>
										             <div class="form-group">
										             	<div class="col-sm-2">
									                		<label for="txtSuffix" class="control-label">Gender:</label>
								                    		 <select class="form-control input-sm" data-key="Gender" data="req">
			                                                    <option value=""></option>
			                                                    <option value="f">Female</option>
			                                                    <option value="m">Male</option>
			                                                </select>
														</div>

														<div class="col-sm-2">
										                	<label for="txtBday" class="control-label">Civil Status:</label>
										                    <select class="form-control input-sm" data-key="CivilStatus" data="req">
			                                                    <option value=""></option>
			                                                    <option value="s">Single</option>
			                                                    <option value="m">Married</option>
			                                                    <option value="d">Divorced</option>
			                                                    <option value="l">Leagally Separated</option>
			                                                    <option value="w">Widow</option>
			                                                    <option value="r">Widower</option>
			                                                </select>
										                </div>
														

														<div class="col-sm-2">
			                                                <label for="txtBday" class="control-label">Citizenship:</label>
			                                                <input type="text" class="form-control input-sm alphaOnly" data="req" placeholder="Citizenship" data-key="Citizenship">
			                                            </div>

			                                            <div class="col-sm-2">
			                                                <label for="txtGender" class="control-label">Religion:</label>
			                                                <input type="text" class="form-control input-sm alphaOnly" id="txtReligion" name="txtReligion" data="req" placeholder="Religion" data-key="Religion">
			                                            </div>

			                                            <div class="col-sm-2">
										                	<label for="txtBday" class="control-label">Height (inches):</label>
										                    <input type="text" class="form-control input-sm"  data="req" placeholder="Height(inches)" data-key="Height">
										                </div>

										                <div class="col-sm-2">
									                		<label for="txtSuffix" class="control-label">Weight (pounds):</label>
								                    		<input type="text" class="form-control input-sm numOnly"data="req" placeholder="Weight (pounds)" data-key="Weight">
														</div>
													</div>
													
												
												</div>
											</div>
										</form>
									</div>
									<!-- End of Personal Information -->


		                    	</div>

		                    	<div class="box-footer">
									<button class="btn btn-warning btn-flat" name="btnSubmit" id="btnSubmit" data-trigger="save"  data-form="divPerInfo"> <i class="fa fa-save"></i> Save </button>
									<span class="pull-right">
										<button type="button" class="btn btn-danger btn-flat" title="Add New Item" data-div="divPerInfo" style="display: none;"> <i class="fa fa-plus"></i> Add</button>
									</span>
								</div>						
		                    </div>
						<!-- </div> -->

						<!--  -->
					</div>
				</form>
			</div>

			<!-- <div class="col-sm-2 col-md-2">
				
			</div> -->
		</div>
    </body>

    <div class="modal fade in" id="modalUploadPhoto" style="padding-right: 17px;">
        <div class="modal-dialog modal-md">
        	<form id="frmUpload" name="frmUpload" enctype="multipart/form-data">
	            <div class="modal-content">
	              	<div class="modal-header">
	                	<h4 class="modal-title">Upload Photo / Signature</h4>
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

				        <div class="row">
			                <div class="col-md-12">
			                    <div id="signature-pad" class="signature-pad">
			                        <div class="signature-pad--body">
			                            <canvas></canvas>
			                        </div>
			                        <div class="signature-pad--footer">
			                            <div class="description">Please write your signature here <i class="fa fa-edit"></i></div>
			                        </div>
			                    </div>
			                </div>
			            </div>
	              	</div>
	              	<div class="modal-footer signature-pad--actions">
	                	<button type="button" class="btn button clear btn btn-primary pull-left" data-action="clear">Clear</button>
	                	<button class="btn save btn btn-success" data-action="save-png">Upload</button>
	              	</div>
	            </div>
            </form>
        </div>
    </div>

</html>

<script src="lib/design/bower_components/jquery/jquery.min.js"></script>

<script src="lib/kg_esign_sdk/js/signature_pad.umd.js"></script>
<script src="lib/kg_esign_sdk/js/kg-esign-sdk_v1.js"></script>

<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/general_information.js"></script>
