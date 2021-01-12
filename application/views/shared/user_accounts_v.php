<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">User Accounts</h3>
 			 <div class="box-tools pull-right">
 			 	<button id="btnNewAccounts" name="btnNewAccounts" class="btn btn-primary btn-sm btn-flat" title="New Account" >
 					<i class="fa fa-user-plus"></i> New
 				</button>

           		<button id="btnDisable" name="btnDisable" class="btn btn-default btn-sm btn-flat btn-data disabled" title="Disable Accounts" value="d" disabled>
 					<i class="fa fa-ban"></i> Deactivate
 				</button>

 				<button id="btnRemove" name="btnRemove" class="btn btn-default btn-sm btn-flat btn-data disabled" title="Remove Accounts" value="r" disabled>
 					<i class="fa fa-user-times"></i> Remove
 				</button>
 				<button id="btnUnLocked" name="btnUnLocked" class="btn btn-default btn-sm btn-flat btn-data disabled" title="Unlock Accounts" value="k" disabled>
 					<i class="fa fa-unlock"></i> Unlock
 				</button>
          	</div>
		</div>
		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group has-feedback">
		        	<input type="text" class="form-control input-sm" id="txtSearch" name="txtSearch" placeholder="Search">
		        	<span class="glyphicon glyphicon-search form-control-feedback"></span>
	      		</div>
	      	</div>

	      	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="form-group has-feedback">
		        	<select name="txtFilter" id="txtFilter" class="form-control input-sm">
						<option value = ''></option>
						<option value = 'active'>Active</option>
						<option value = 'deactivated'>Deactivated</option>
						<option value = 'removed'>Removed</option>
						<option value = 'locked'>Locked</option>
					</select>
	      		</div>
	      	</div>
	      	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
	    </div>
	    
    		<div class="box-body">
    			<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="divData"></div>
        		</div>
        	</div>
        </div>
    </div>

	<div id="modalNewAccnt" class="modal fade" role="dialog">
		<form name="frmMain" id="frmMain" class="form-horizontal">
	    	<div class="modal-dialog">
	        	<div class="modal-content">
	          		<div class="modal-header modal-header-danger">
	            		<button type="button" class="close" data-dismiss="modal">&times;</button>
	            		<h4 class="modal-title">User Account </h4>
	          		</div>
	          		<div class="modal-body">
	            		<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="row">
							    	<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="txtTitle">Title </label>
							    	<div class="form-group col-xs-3 col-sm-3 col-md-3 col-lg-3" id="div_txtTitle">
						        		<select name="txtTitle" id="txtTitle" class="form-control input-sm" data="req">
											<option value = ''></option>
											<option value = 'Mr.'>Mr.</option>
											<option value = 'Ms.'>Ms.</option>
										</select>
						      		</div>
						      	</div>
								<div class="row">
							    	<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="txtFname">First Name </label>
							    	<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9" id="div_txtFname">
						        		<input type="text" class="form-control input-sm" id="txtFname" name="txtFname" placeholder="Firstname" data="req" maxlength="35">
						      		</div>
						      	</div>

						      	<div class="row">
						      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="txtLname">Last Name</label>
									<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9" id="div_txtLname">
						        		<input type="text" class="form-control input-sm" id="txtLname" name="txtLname" placeholder="Lastname" data="req" maxlength="35">
						      		</div>
							    </div>

							    <div class="row">
						      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="txtEmail">Email Address</label>
									<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9" id="div_txtEmail">
						        		<input type="text" class="form-control input-sm" id="txtEmail" name="txtEmail" placeholder="Email Address" data="req" maxlength="150">
						      		</div>
							    </div>

							    <div class="row">
						      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="txtUname">Username</label>
							    	<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9" id="div_txtUname">
						        		<input type="text" class="form-control input-sm" id="txtUname" name="txtUname" placeholder="Username" data="req">
						      		</div>
						      	</div>

						      	<div class="row">
						      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="txtPword">Password </label>
									<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9" id="div_txtPword">
						        		<input type="password" class="form-control input-sm" id="txtPword" name="txtPword" placeholder="Password" data="req">
						      		</div>
						      	</div>

						      	<div class="row">
						      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="txtConPword">Confirm</label>
									<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9" id="div_txtConPword">
						        		<input type="password" class="form-control input-sm" id="txtConPword" name="txtConPword" placeholder="Confirm Password" data="req">
						      		</div>
							    </div>

							     <div class="row">
						      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="txtAccess">Access Level</label>
									<div class="form-group col-xs-9 col-sm-9 col-md-9 col-lg-9" id="div_txtAccess">
						        		<select name="txtAccess" id="txtAccess" class="form-control input-sm" data="req">
											<option value = ''></option>
											<option value = '1'>Level 1 ( Office Recruiter )</option>
											<option value = '2'>Level 2 ( Account Administrator )</option>
											<option value = '3'>Level 3 ( System Administrator )</option>
										</select>
						      		</div>
						      	</div>

						      	<!-- <div class="row">
						      		<label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="txtStatus">Status</label>
									<div class="form-group col-xs-5 col-sm-5 col-md-5 col-lg-5" id="div_txtStatus">
						        		<input type="text" name="txtStatus" id="txtStatus" class="input-sm form-control" readonly="">
						      		</div>
						      	</div> -->

							    <!-- <div class="row"> <div id="tdLoader" class=" tdLoader col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;"> &nbsp; </div> </div> -->


						</div>
						<!-- <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
							<div class="row">
						     	<div id="divData" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;"> &nbsp;  </div>
						    </div>
						</div> -->
					</div>
	      		</div>
	          	<div class="modal-footer">
	            	<div class="row">
				    	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align: left;">
				    		<button id="btnAct" class="btn btn-primary btn-sm btn-flat btn-edit" title="Activate Account" value="a">
				 					<i class="fa fa-ban"></i> Activate
			 				</button>

					    	<button id="btnDeAct" class="btn btn-warning btn-sm btn-flat btn-edit" title="Disable Account" value="d">
				 					<i class="fa fa-ban"></i> Deactivate
			 				</button>

			 				<button id="btnRem" class="btn btn-danger btn-sm btn-flat btn-edit" title="Remove Account" value="r">
			 					<i class="fa fa-times-circle"></i> Remove
			 				</button>

			 				<button id="btnUnlock" class="btn btn-success btn-sm btn-flat btn-edit" title="Unlock Account" value="k">
			 					<i class="fa fa-unlock"></i> Unlock
			 				</button>

		 				</div>
				     	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align: right;">
				     		<input type="text" name="txtAcctId" id="txtAcctId" class="input_field" style="display : none;">
				     		<button id="btnSave" name="btnSave" class="btn btn-primary btn-sm btn-flat">
				     			<i class="fa fa-save"></i> Save
				     		</button>

				     		<button id="btnUpdate" class="btn btn-primary btn-sm btn-flat btn-edit" value="u">
				     			<i class="fa fa-save"></i> Update
				     		</button>


				     	</div>
				    </div>
	          	</div>
	    	</div>
    	</form>
  	</div>
<!-- </html> -->

<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<script src="lib/scripts/modules/user_accounts.js"></script>
