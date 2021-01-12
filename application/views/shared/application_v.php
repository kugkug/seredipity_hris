<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>
    <body>
        <div class="row">
			<div class="col-sm-12 col-md-12">
						
					<div class="box box-warning">
						<div class="box-body">
							
                			<form class="form-horizontal" autocomplete="off" name="divPerInfo" id="divPerInfo">
	                        	<div class="row" >
									<div class="col-md-2">
										<div class="form-group" style="text-align: center;">	
								            <div class=" divPhoto">
								            	<img class="img-circle" src='images/no_photo.png' style='max-width: 130px; border: 1px solid #e5e5e5; padding: 10px;'>
								            	<input type="text" data-key="Photo" style="display: none;">
								            </div>
										</div>
										<div class="form-group">							
								            <div class="col-sm-12">
							                	<label for="txtLname" class="control-label">Employee ID:</label>
							                    <input type="text" class="form-control input-sm" data="req" placeholder="Employee ID" data-key="EmpId" maxlength="150">
							                </div>
										</div>
										<div class="form-group">							
								            <div class="col-sm-12">
							                	<label for="txtLname" class="control-label">Shift Schedule:</label>
							                    <?=$dropdowns['shift'];?>
							                </div>
										</div>
									</div>

									<div class="col-md-10">
										
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
							            	

								    		<div class="col-sm-6">
								    			<label class="control-label">Client Address: </label>
							        			<input type="text" class="form-control input-sm" placeholder="House # or Lot/Blk/Phase, Street/Sitio, Purok/Subdivision" data="req" data-key="ClientAddress" value="<?php echo isset($clientinfo['ClientAddress']) ? $clientinfo['ClientAddress'] : "";?>">
							      			</div>

							      			<div class="col-sm-2">
							        			<label for="txtRegion" class="control-label">Region:</label>
							                    <?=$region;?>
							                </div>
							            
							                <div class="col-sm-2">
							                	<label for="txtProvince" class="control-label">City/Municipality/Province:</label>
							                	<select class="form-control input-sm" id="selCityMuniProv" name="selCityMuniProv" data="req" data-key="ClientCity" disabled=""></select>
							                	
							                </div>
							            
							                <div class="col-sm-2">
						                		
						                		<label for="txtBrgy" class="control-label">Barangay:</label>
						                		<select class="form-control input-sm" id="selBrgy" name="selBrgy" data-key="ClientBrgy" data="req" disabled=""></select>
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
                                                <label for="txtBPlace" class="control-label">Contact Number:</label>
                                                <div class="row">
                                                	<div class="col-md-6">
                                                		<input type="text" class="form-control input-sm"  data="req" placeholder="Telephone" data-key="EmpTelNo" maxlength="8">
                                                	</div>
                                                	<div class="col-md-6">
                                                		<input type="text" class="form-control input-sm"  data="req" placeholder="Mobile" data-key="EmpCellNo" maxlength="11">
                                                	</div>
                                                </div>
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
                                                <!-- <input type="text" class="form-control input-sm alphaOnly" id="txtReligion" name="txtReligion" data="req" placeholder="Religion" data-key="Religion"> -->
                                                <?=$dropdowns['religion'];?>
                                            </div>

                                            <div class="col-sm-2">
							                	<label for="txtBday" class="control-label">Height:</label>
							                	<div class="row">
							                		<div class="col-md-6">
							                			<input type="text" class="form-control input-sm"  data="req" placeholder="Ft." data-key="HeightFt">
							                		</div>
							                		<div class="col-md-6">
							                			<input type="text" class="form-control input-sm"  data="req" placeholder="In." data-key="HeightIn">
							                		</div>
							                	</div>
							                    
							                </div>

							                <div class="col-sm-2">
						                		<label for="" class="control-label">Weight (pounds):</label>
					                    		<input type="text" class="form-control input-sm numOnly"data="req" placeholder="Weight (pounds)" data-key="Weight">
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-4">
						                		<label for="" class="control-label">Company Assigned:</label>
					                    		<?=$clients;?>
											</div>
											<div class="col-sm-4">
						                		<label for="" class="control-label">Company Branch:</label>
					                    		<?=$dropdowns['branch'];?>
											</div>

											<div class="col-sm-4">
						                		<label for="" class="control-label">Supervisor:</label>
						                		<select class="form-control input-sm" data="req" data-key="SupId" disabled=""></select>
					                    		<!-- <?=$supervisors;?> -->
											</div>
										</div>
									
									</div>
								</div>
							</form>
						</div>

                	<div class="box-footer">
						<button class="btn btn-warning btn-flat" name="btnSubmit" id="btnSubmit" data-trigger="save"  data-form="divPerInfo"> <i class="fa fa-save"></i> Save </button>
						<span class="pull-right">
							<button type="button" class="btn btn-danger btn-flat" title="Add New Item" data-div="divPerInfo" style="display: none;"> <i class="fa fa-plus"></i> Add</button>
						</span>
					</div>						
				</div>
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

	              	</div>
	              	<div class="modal-footer signature-pad--actions">
	                	<!-- <button type="button" class="btn button clear btn btn-primary pull-left">Clear</button> -->
	                	<button class="btn save btn btn-success" data-action="save-png">Upload</button>
	              	</div>
	            </div>
            </form>
        </div>
    </div>

</html>

<script src="lib/design/bower_components/jquery/jquery.min.js"></script>

<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/general_information.js"></script>
