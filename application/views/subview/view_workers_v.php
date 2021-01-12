<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>
    <body>
        <div class="row">
			<div class="col-sm-12 col-md-12">
						
					<div class="box <?=$boxheader;?>">
						<div class="box-header with-border">
							<h3 class="box-title">
								<i class="fa fa-info" style="font-size: 16px !important;"></i> 
								Employee Information
							</h3>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-xs-5 col-sm-4 col-md-4" style="text-align: center;">
											<div style="background-image: url('<?=$employee['part_photo'];?>'); background-size: cover; background-repeat: no-repeat; height: 123px; width: 123px; position: relative; left: 20%;"></div>
										</div>

										<div class="col-xs-7 col-sm-8 col-md-8">
											<div class="row invoice-info">
					                            <div class="col-sm-12 invoice-col">
					                              	<address>
					                              		<?=$employee['agent_empid'];?> - (<strong><?=strtoupper($employee['agent_status']);?></strong>)
					                              		<br />
					                                	<strong><?=ucwords(strtolower($employee['agent_lname'].", ".$employee['agent_fname']." ".$employee['agent_mname']));?></strong> (<?=GENDER[$employee['agent_gender']];?>)
					                                	<br />
					                                	<strong><?=strtoupper($employee['agent_celno']);?> / <?=strtoupper($employee['agent_telno']);?></strong>
					                                	<br />
					                                	
						                                	<strong>
						                                		<?=ucwords(strtolower($employee['agent_address']));?>, <?=ucwords(strtolower(($employee['brgy'])));?>
						                                		<br/>
						                                		<?=strtoupper($employee['city']);?> - <?=strtoupper($employee['region']);?>
						                                	</strong>
						                              	
					                                	<br>
					                                	Date Hired : <strong><?=date("F d, Y", strtotime($employee['agent_date_hired']));?></strong>

					                              	</address>
					                            </div>
					                        </div>

					                        
										</div>
									</div>
									
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">&nbsp;</div>
							</div>
							<!-- <div class="box box-widget"> -->

								<div class="divInfoWrapper">
									<div class="row invoice-info">
			                            <div class="col-sm-3 invoice-col">
			                              Full Name
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['agent_lname'].", ".$employee['agent_fname']." ".$employee['agent_mname']));?>
			                                	</strong>
			                              	</address>

			                              	Birthday
			                              	<address>
			                                	<strong>
			                                		<?=date("F, d Y", strtotime($employee['agent_bday']));?>
			                                	</strong>
			                              	</address>

			                              	Civil Status
			                              	<address>
			                              		<strong>
			                              			<?=CIVILSTATS[$employee['agent_civil_status']];?>
			                              		</strong>
			                              	</address>

			                              	Nationality
			                              	<address>
			                                	<strong>
			                                		<?=$employee['agent_citizenship'];?>
			                                	</strong>
			                              	</address>

			                              	Height
			                              	<address>
			                                	<strong>
			                                		<?=$employee['agent_ht_ft'];?>'<?=$employee['agent_ht_in'];?>
			                                	</strong>
			                              	</address>

			                              	Weight
			                              	<address>
			                                	<strong>
			                                		<?=$employee['agent_weight'];?> lbs.
			                                	</strong>
			                              	</address>

			                              	Religion
			                              	<address>
			                                	<strong>
			                                		<?=$employee['religion'];?>
			                                	</strong>
			                              	</address>
			                            </div>
			                            <div class="col-sm-3 invoice-col">

			                            	Position
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['position']));?>
			                                	</strong>
			                              	</address>

			                              	Shift
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['shift_sched']));?>
			                                	</strong>
			                              	</address>

			                              	Company Assigned
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['client_name']));?>
			                                		
			                                	</strong>
			                              	</address>

			                              	Work Location
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['branch']));?>
			                                	</strong>
			                              	</address>

			                              	Department
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['dept_name']));?>
			                                	</strong>
			                              	</address>

			                              	Supervisor
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['sup_lname'].", ".$employee['sup_fname']." ".$employee['sup_mname']));?> (<?=ucwords(strtolower($employee['sup_position']));?>)
			                                	</strong>
			                              	</address>

			                              	
			                            </div>

			                            <div class="col-sm-3 invoice-col">

			                            	SSS No.
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['agent_sssno']));?>
			                                	</strong>
			                              	</address>

			                              	TIN No.
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['agent_tinno']));?>
			                                	</strong>
			                              	</address>

			                              	PhilHealth No.
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['agent_philhealthno']));?>
			                                		
			                                	</strong>
			                              	</address>

			                              	Pag-ibig No.
			                              	<address>
			                                	<strong>
			                                		<?=ucwords(strtolower($employee['agent_pagibigno']));?>
			                                	</strong>
			                              	</address>

			                              	Signature
			                              	<address>
			                                	
			                                	<div style="background-image: url('<?=$employee['agent_signature'];?>'); background-size: contain; background-repeat: no-repeat; height: 54px; max-height: 54px position: relative;"></div>
			                                	
			                              	</address>

			                              	
			                            </div>
		                          	</div>
								
								</div>
							</div>	
                			
						<!-- </div> -->

                	<div class="box-footer">
						<!-- <button class="btn btn-warning btn-flat" name="btnSubmit" id="btnSubmit" data-trigger="save"  data-form="divPerInfo"> <i class="fa fa-save"></i> Save </button>
						<span class="pull-right">
							<button type="button" class="btn btn-danger btn-flat" title="Add New Item" data-div="divPerInfo" style="display: none;"> <i class="fa fa-plus"></i> Add</button>
						</span> -->
					</div>						
				</div>
			</div>

		</div>
    </body>


</html>

<script src="lib/design/bower_components/jquery/jquery.min.js"></script>

<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/general_information.js"></script>
