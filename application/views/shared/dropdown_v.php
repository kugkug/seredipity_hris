<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>

    <body>
        <div class="row">
			

			<div class="col-sm-4 col-md-4">
				<div class="box box-warning box-dropdowns">
					<div class="box-header with-border">

			            <div class="row">
							<div class="col-md-5">
								<h3 class="box-title">
									<i class="fa fa-institution" style="font-size: 16px !important;"></i> 
									Religions
								</h3>
							</div>
							<div class="col-md-7">
								<div class="box-tools pull-right">
									<div class="input-group input-group-sm">
					                <input type="text" class="form-control" placeholder="New Religion" maxlength="150">
					                    <span class="input-group-btn">
					                      	<button type="button" class="btn btn-warning btn-flat" data-trigger="addreli">Add</button>
					                    </span>
					              	</div>
								</div>
							</div>
		            	</div>

					</div>

					<div class="box-body table-responsive divReligion divScroll">

						<?=$dropdowns['religion'];?>

					</div>


				</div>
			</div>

			<div class="col-sm-4 col-md-4">
				<div class="box box-warning box-dropdowns">
					<div class="box-header with-border">

			            <div class="row">
							<div class="col-md-3">
								<h3 class="box-title">
									<i class="fa fa-clock-o" style="font-size: 16px !important;"></i> 
									Shifts
								</h3>
							</div>

							<div class="col-md-9">
								<div class="box-tools pull-right">
									<div class="row">
										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
											<input type="text" class="form-control timepicker input-sm pull-right" placeholder="From" readonly="">
										</div>
									
										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
											<input type="text" class="form-control timepicker input-sm pull-right" placeholder="To" readonly="">	
										</div>

										<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
											<button type="button" class="btn btn-warning btn-flat pull-right" data-trigger="addshift">Add</button>
										</div>
									</div>
										
					                
								</div>
							</div>
		            	</div>

					</div>

					<div class="box-body table-responsive divShift divScroll">

						<?=$dropdowns['shift'];?>

					</div>


				</div>
			</div>

			<div class="col-sm-4 col-md-4">
				<div class="box box-warning box-dropdowns">
					<div class="box-header with-border">

						<div class="row">
							<div class="col-md-5">
								<h3 class="box-title">
									<i class="fa fa-calendar" style="font-size: 16px !important;"></i> 
									Timelog
								</h3>
							</div>
							<div class="col-md-7">
								<div class="box-tools pull-right">
									<div class="input-group input-group-sm">
					                <input type="text" class="form-control" placeholder="Timelog Types" maxlength="150">
					                    <span class="input-group-btn">
					                      	<button type="button" class="btn btn-warning btn-flat" data-trigger="addlogtype">Add</button>
					                    </span>
					              	</div>
								</div>
							</div>
		            	</div>
							
					</div>

					<div class="box-body table-responsive divTimelogs divScroll">

						<?=$dropdowns['timelogs'];?>

					</div>


				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="box box-warning box-dropdowns">
					<div class="box-header with-border">
						<div class="form-group">
							<h3 class="box-title">
								<i class="fa fa-building-o" style="font-size: 16px !important;"></i> 
								Work Location
							</h3>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-4">
									<label class="control-label">Client</label>
	            					<?=$clients;?>		
								</div>

								<div class="col-md-4">
									<label class="control-label">City/Municipality</label>
            						<?=$cities;?>
								</div>

								<div class="col-md-4">
									<label class="control-label">Work Location</label>		            		
						            <input type="text" class="form-control input-sm" placeholder="Branch Name" maxlength="150">
								</div>
							</div>				 	
						 	
		            	</div>

		            	<div class="form-group">
		            		<div class="row">
								<div class="col-md-4">
									<label class="control-label">Repesentative</label>
	            					<input type="text" class="form-control input-sm" placeholder="Contact Person" maxlength="250">
								</div>

								<div class="col-md-4">
									<label class="control-label">Contact Number</label>
	            					<input type="text" class="form-control input-sm numOnly" placeholder="Contact Number" maxlength="11">
								</div>

								<div class="col-md-4">
									<label class="control-label">Email Address</label>
	            					<input type="text" class="form-control input-sm" placeholder="Email Address" maxlength="150">
								</div>
							</div>
		            	</div>

		            	
	                     <button type="button" class="btn btn-warning btn-flat pull-right" data-trigger="addbranch">Add</button>
	                    
		            	
	            	</div>

					<div class="box-body table-responsive divBranch divScroll">

						<?=$dropdowns['branch'];?>

					</div>


				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 col-md-4">
				<div class="box box-warning box-dropdowns">
					<div class="box-header with-border">

						<div class="form-group">
							<h3 class="box-title">
								<i class="fa fa-building-o" style="font-size: 16px !important;"></i> 
								Positions
							</h3>
						</div>
						<div class="form-group">
						 	<label class="control-label">Client</label>
	            			<?=$clients;?>
		            	</div>
		            	<div class="form-group">
		            		<label class="control-label">Position</label>
		            		<div class="input-group input-group-sm">
		            		
				                <input type="text" class="form-control" placeholder="New Position" maxlength="150">
			                    <span class="input-group-btn">
			                      	<button type="button" class="btn btn-warning btn-flat" data-trigger="addposi">Add</button>
			                    </span>
			              	</div>
		            	</div>

						<!-- <div class="row">
							<div class="col-md-5">
								<h3 class="box-title">
								<i class="fa fa-users" style="font-size: 16px !important;"></i> 
								Positions
							</h3>
							</div>
							<div class="col-md-7">
								<div class="box-tools pull-right">
									<div class="input-group input-group-sm">
					                <input type="text" class="form-control" placeholder="New Position" maxlength="150">
					                    <span class="input-group-btn">
					                      	<button type="button" class="btn btn-warning btn-flat" data-trigger="addposi">Add</button>
					                    </span>
					              	</div>
								</div>
							</div>
		            	</div> -->

					</div>

					<div class="box-body table-responsive divPosition divScroll">

						<?=$dropdowns['position'];?>

					</div>

				</div>
			</div>

			<div class="col-sm-4 col-md-4">
				<div class="box box-warning box-dropdowns">
					<div class="box-header with-border">

			            <div class="row">
							<div class="col-md-5">
								<h3 class="box-title">
									<i class="fa fa-user" style="font-size: 16px !important;"></i> 
									Applicant Status
								</h3>
							</div>
							<div class="col-md-7">
								<div class="box-tools pull-right">
									<div class="input-group input-group-sm">
					                <input type="text" class="form-control" placeholder="New Status" maxlength="150">
					                    <span class="input-group-btn">
					                      	<button type="button" class="btn btn-warning btn-flat" data-trigger="addappstat">Add</button>
					                    </span>
					              	</div>
								</div>
							</div>
		            	</div>

					</div>

					<div class="box-body table-responsive divAppstat divScroll">

						<?=$dropdowns['appstat'];?>

					</div>


				</div>
			
		</div>


    </body>
</html>

<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/dropdowns.js"></script>
