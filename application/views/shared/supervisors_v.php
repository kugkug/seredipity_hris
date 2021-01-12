<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>

    <body>
        <div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="box box-warning repBox">
					<div class="box-header with-border">
						<h3 class="box-title">
							<i class="fa fa-users" style="font-size: 16px !important;"></i> 
							Supervisor List
						</h3>

						<div class="box-tools pull-right">

							<button  class="btn btn-warning btn-sm btn-flat" title="New Client" data-trigger="newsup" data-form="modalNewSup">
	 							<i class="fa fa-plus"></i> Add New Supervisor
		 					</button>
			 				
			            </div>
					</div>

					<div class="box-body table-responsive">

						<?=$supervisors;?>

					</div>


				</div>
			</div>
		</div>

		<div id="modalNewSup" class="modal fade" role="dialog">
			<form class="form-horizontal" autocomplete="off">
		    	<div class="modal-dialog modal-sm">
		        	<div class="modal-content">
		          		<div class="modal-header">
		            		<button type="button" class="close" data-dismiss="modal">&times;</button>
		            		<h4 class="modal-title"> <i class="fa fa-user-plus"></i> Add Supervisor </h4>
		          		</div>
		          		<div class="modal-body">
		          			<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							    	<div class="form-group">
							    		<div class="col-sm-12">
						                	<label for="txtLname" class="control-label">Last Name:</label>
						                    <input type="text" class="form-control input-sm" data="req" placeholder="Last Name" data-key="SupLname">
						                </div>						             
						            </div>

						            <div class="form-group">

							    		<div class="col-sm-12">
						                	<label for="txtFname" class="control-label">First Name:</label>
						                    <input type="text" class="form-control input-sm" data="req" placeholder="First Name" data-key="SupFname">
						                </div>
						            </div>

						            <div class="form-group">

							    		<div class="col-sm-12">
						                	<label for="txtMname" class="control-label">Middle Name:</label>
						                    <input type="text" class="form-control input-sm" data="req" placeholder="Middle Name" data-key="SupMname">
						                </div>
						            </div>

						            <div class="form-group">

							    		<div class="col-sm-12">
						                	<label for="txtFname" class="control-label">Date of Birth:</label>
						                    <input type="text" class="form-control input-sm datebday" data="req" placeholder="Date of Birth" data-key="SupBday">
						                </div>
						            </div>

						            <div class="form-group">
							    		<div class="col-sm-12">
						                	<label for="" class="control-label">Company:</label>
						                    <?=$clients;?>
						                </div>
						            </div>

						            <div class="form-group">
							    		<div class="col-sm-12 divDepts">
						                	<label for="" class="control-label">Department:</label>
						                    <select class="form-control input-sm" data-key="DeptId" disabled=""></select>
						                </div>
						            </div>

						            <div class="form-group">
							    		<div class="col-sm-12 divBranch">
						                	<label for="" class="control-label">Work Location:</label>
						                    <select class="form-control input-sm" data-key="BranchId" disabled=""></select>
						                </div>
						            </div>
						            

						            <div class="form-group">
							    		<div class="col-sm-12">
						                	<label for="" class="control-label">Position:</label>
						                    <?=$dropdowns['position'];?>
						                </div>
						            </div>

								</div>
							</div>
						</div>

						<div class="box-footer">
							<span class="pull-right">
								<input type="text" data-key='DataId' style="display:none;">
								<button class="btn btn-warning btn-flat" data-trigger="save" data-form="modalNewSup">
									<i class="fa fa-save"></i> Save
								</button>

								<button class="btn btn-danger btn-flat" data-trigger="reset" data-form="modalNewSup">
									<i class="fa fa-undo"></i> Reset
								</button>

							</span>
						</div>

					</div>
				</div>
			</form>
		</div>

    </body>
</html>

<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/supervisors.js"></script>
