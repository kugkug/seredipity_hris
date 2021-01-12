<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>

    <body>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form id="frmMain"> 
					<input type="text" data-key="DataId" value="<?php echo isset($clientinfo['DataId']) ? $clientinfo['DataId'] : "";?>" style="display: none;">
					<input type="text" data-key="ClientId" value="<?php echo isset($clientinfo['ClientId']) ? $clientinfo['ClientId'] : md5(date("Ymdhisu"));?>" style="display:none;">
					<div class="box box-warning">
						<div class="box-body">
							<div class="row">
								<div class="col-md-8">

									<div class="form-group">
					    				<div class="row">
							    			<div class="col-sm-10">
							    				<label class="control-label" for="">Client Name: </label>
						        				<input type="text" class="form-control input-sm" placeholder="Client Name" data="req" maxlength="150" data-key="ClientName" value="<?php echo isset($clientinfo['ClientName']) ? $clientinfo['ClientName'] : "";?>">
						      				</div>
						      			</div>
						      		</div>


						      		<div class="form-group">
							      		<div class="row">
								    		<div class="col-sm-6">
								    			<label class="control-label">Client Address: </label>
							        			<input type="text" class="form-control input-sm" placeholder="Client Address" data="req" data-key="ClientAddress" value="<?php echo isset($clientinfo['ClientAddress']) ? $clientinfo['ClientAddress'] : "";?>">
							      			</div>

							      			<div class="col-sm-2">
							        			<label for="txtRegion" class="control-label">Region:</label>
							                    <?=$region;?>
							                </div>
							            
							                <div class="col-sm-2">
							                	<label for="txtProvince" class="control-label">City/Municipality/Province:</label>
							                	
							                	<?php if (isset($citymuni)) {
							                			$sCities 	=	 $citymuni;
							                			$sDis 		=	"";
							                		} else {
							                			$sCities 	=	"";
							                			$sDis 		=	"disabled=''";
							                			
							                		}
							                	?>
							                	<select class="form-control input-sm" id="selCityMuniProv" name="selCityMuniProv" data="req" data-key="ClientCity" <?=$sDis;?>>
							                		<?=$sCities;?>
							                	</select>
							                	
							                </div>
							            
							                <div class="col-sm-2">
							                	<label for="txtBrgy" class="control-label">Barangay:</label>
							                	<?php if (isset($brgy)) {
							                			$sBrgys		=	 $brgy;
							                			$sDis 		=	"";
							                		} else {
							                			$sBrgys 	=	"";
							                			$sDis 		=	"disabled=''";
							                			
							                		}
							                	?>
							                		<select class="form-control input-sm" id="selBrgy" name="selBrgy" data-key="ClientBrgy" data="req" <?=$sDis;?>>
							                			<?=$sBrgys;?>
							                	</select>					                    
							                	
							                </div>
							      		</div>
							      	</div>

							      	<div class="form-group">
							      		<div class="row">
							      			<div class="col-sm-2">
								    			<label class="control-label">Segment: </label>
							        			<select class="form-control input-sm" data-key="ClientSegments" data-value="<?php echo isset($clientinfo['ClientSegments']) ? $clientinfo['ClientSegments'] : "";?>">
							        				<option value=""></option>
							        				<option value="luz">Luzon</option>
							        				<option value="vis">Visayas</option>
							        				<option value="min">Mindanao</option>
							        			</select>
							      			</div>

								    		<div class="col-sm-3">
								    			<label class="control-label">Contact: </label>
							        			<input type="text" class="form-control input-sm" placeholder="Contact" data="req" maxlength="15" data-key="ClientTel"  value="<?php echo isset($clientinfo['ClientTel']) ? $clientinfo['ClientTel'] : "";?>">
							      			</div>

							      			<div class="col-sm-5">
								    			<label class="control-label">Email Address: </label>
							        			<input type="text" class="form-control input-sm" placeholder="Email Address" data="req" maxlength="250" data-key="ClientEmail"  value="<?php echo isset($clientinfo['ClientEmail']) ? $clientinfo['ClientEmail'] : "";?>">
							      			</div>

							      			<div class="col-sm-2">
								    			<label class="control-label">TIN No.: </label>
							        			<input type="text" class="form-control input-sm" placeholder="TIN No" data="req" maxlength="15" data-key="ClientTinNo"  value="<?php echo isset($clientinfo['ClientTinNo']) ? $clientinfo['ClientTinNo'] : "";?>">
							      			</div>
							      		</div>
							      	</div>

							      	<div class="form-group">
						      			<div class="row">	
						    				<div class="col-md-4">
						    					<label class="control-label">Contract Period: </label>
						    					<input type="text" class="form-control input-sm datepicker" placeholder="Period From" data="req" maxlength="15" data-key="ClientPeriodFrom"  value="<?php echo isset($clientinfo['ClientPeriodFrom']) ? $clientinfo['ClientPeriodFrom'] : "";?>">
						    				</div>
						    				<div class="col-md-4">
						    					<label class="control-label">&nbsp; </label>
						    					<input type="text" class="form-control input-sm datepicker" placeholder="Period To" data="req" maxlength="15" data-key="ClientPeriodTo"  value="<?php echo isset($clientinfo['ClientPeriodTo']) ? $clientinfo['ClientPeriodTo'] : "";?>">
						    				</div>
						    				<div class="col-sm-4">
								    			<label class="control-label">Payroll Period: </label>
							        			<select class="form-control input-sm" data-key="ClientPayrollPeriod" data-value="<?php echo isset($clientinfo['ClientPayrollPeriod']) ? $clientinfo['ClientPayrollPeriod'] : "";?>" data-sub='<?php echo isset($payrolls) ? $payrolls : "";?>'>
							        				<option value=""></option>
							        				<option value="w">Weekly</option>
							        				<option value="sm">Semi-Monthly</option>
							        				<option value="m">Monthly</option>
							        			</select>
							      			</div>
							      		</div>
							      	</div>

							      	<div class="form-group">
							      		<div class="row">
						    				<div class="col-sm-6"  id="divCutOff">
						    					&nbsp;
						    				</div>
						    				<div class="col-sm-6" id="divPaySched">
						    					&nbsp;
						    				</div>
						    			</div>
							      	</div>

								</div>

								<div class="col-md-4">
									<div class="form-group">
							      		<div class="row">
							      			<div class="col-md-12">
								    			<label class="control-label">Departments:</label>
								    			<div class="input-group input-group-sm">
							        				<input type="text" class="form-control input-sm" placeholder="Client Department" id="txtClientDept">
							        				<span class="input-group-btn">
											          	<button type="button" class="btn btn-success btn-flat" title="Add Depertment" data-trigger="add_dept">
											          		<i class="fa fa-plus"></i>
											          	</button>
											        </span>
											    </div>
							      			</div>
							      		</div>
							      		<div class="row">
							      			<div class="col-md-12" style="height: 138px; overflow: auto;">
							      				<ul class="ulDept" id="ulDept">
							      					<?php
							      						if (isset($depts)) {
							      							foreach ($depts as $key => $value) {
							      								echo "<li><span>". $value ."</span><a class='text-danger btn-remove pull-right'><i class='fa fa-times' title='Remove'></i></a> </li>";
							      							}
							      						}

							      					?>
							      				</ul>
							      			</div>
							      		</div>
							      	</div>
								</div>
							</div>
							
				      		

				      	</div>
				      	
					    <div class="box-footer">
							<span class="pull-left">

								<button class="btn btn-warning btn-flat" data-trigger="save" data-form="frmData" >
									<i class="fa fa-save"></i> Save
								</button>

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
<script type="text/javascript" src="lib/scripts/modules/company.js"></script>
