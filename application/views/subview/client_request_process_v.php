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
							<i class="fa fa-info" style="font-size: 16px !important;"></i> 
							Request Information - (<?=ucfirst($request['request_status']);?>)
						</h3>
						<input type="text" value="<?=$request['reqid']?>" data-key="DataId" style="display: none;">
					</div>

					<div class="box-body">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label"> Date:</label>
									<br />
									<span class="spnData">
										<?=date("M. d, Y", strtotime($request['entrydate']));?>
									</span>			
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label">Client:</label>
									<br />
									<span class="spnData">
										<?=$request['client_name'];?>
									</span>		
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label">Work Location:</label>
									<br />
									<span class="spnData">
										<?=$request['branch'];?>
									</span>		
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Manpower:</label>
									<br />
									<span class="spnData">
										<?=$request['request_man_power'];?>
									</span>		
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Contact Person:</label>
									<br />
									<span class="spnData">
										<?=$request['request_contact_person'];?>
									</span>		
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Contact Number:</label>
									<br />
									<span class="spnData">
										<?=$request['request_contact_number'];?>
									</span>		
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Contact Email:</label>
									<br />
									<span class="spnData">
										<?=$request['request_contact_email'];?>
									</span>		
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Interview:</label>
									<br />
									<span class="spnData">
										<?=date("F d, Y", strtotime($request['request_interview_date']))." " .$request['request_interview_time'];?>
									</span>		
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Requested By:</label>
									<br />
									<span class="spnData">
										<?=$request['request_by'];?>
									</span>		
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">Noted By:</label>
									<br />
									<span class="spnData">
										<?=$request['request_noted_by'];?>
									</span>		
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="control-label">Nature of Request:</label>
									<br />
									<span class="spnData">
										<?php

											echo $this->hatvclib->ArrayToLine($this->hatvclib->JsonToArray(json_decode($request['request_nature'])));
										?>
									</span>		
								</div>
							</div>

							<div class="col-md-8">
								<div class="form-group">
									<label class="control-label">Qualifications:</label>
									<br />
									<span class="spnData">
										<?php
											echo $this->hatvclib->getQualifications(json_decode($request['request_qualifications']));

											if (trim($request['request_license_code']) != "") {
												echo "(".$request['request_license_code'].")";
											}
										?>
									</span>		
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Position/s:</label>
									<br />
									<span class="spnData">
										<?php
											echo $this->hatvclib->getPositionLine(array(), $this->hatvclib->JsonToArray(json_decode($request['request_positions'])));
										?>
									</span>		
								</div>
							</div>
						</div>
							
					</div>
					
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 col-md-6">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h3 class="box-title">
							<i class="fa fa-users" style="font-size: 16px !important;"></i> 
							Candidates
						</h3>
					</div>

					<div class="box-body table-responsive divScroll divCandidates">

					</div>

					<?php
						if (strtolower($request['request_status']) == "new" || strtolower($request['request_status']) == "reprocess" || strtolower($request['request_status']) == "pending") {
					?>
					<div class="box-footer">
						<span class="pull-left">
							<button class="btn btn-info btn-flat" data-trigger="send">
								<i class="fa fa-send"></i> Send to Client
							</button>
						</span>
					</div>
					<?php		
						} else if (strtolower($request['request_status']) == "approved") {
					?>
					<div class="box-footer">
						<span class="pull-right">
							<button class="btn btn-warning btn-flat" data-trigger="texts">
								<i class="fa fa-envelope"></i> Inform Applicants
							</button>

							
						</span>

						<span class="pull-left">
							<button class="btn btn-info btn-flat" data-trigger="send">
								<i class="fa fa-send"></i> Send to Client
							</button>
						</span>
					</div>
					<?php
						} else if (strtolower($request['request_status']) == "completed") {
					?>

						<div class="box-footer">
							<span class="pull-left">
								<button class="btn btn-warning btn-flat" data-trigger="deploy">
									<i class="fa fa-flag-o"></i> Deploy
								</button>
							</span>
						</div>
					<?php
						}

					?>
					
					
				</div>
			</div>

			<div class="col-sm-6 col-md-6">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h3 class="box-title">
							<i class="fa fa-users" style="font-size: 16px !important;"></i> 
							Other Applicants
						</h3>
					</div>

					<div class="box-body table-responsive divScroll divApplicants">

					</div>					
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 col-md-6">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h3 class="box-title">
							<i class="fa fa-users" style="font-size: 16px !important;"></i> 
							Passed
						</h3>
					</div>

					<div class="box-body table-responsive divScroll divChosen">

					</div>
				</div>
			</div>
		</div>


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
		          					<textarea rows="10" class="input-sm form-control"> </textarea>
		          				</div>
		          			</div>
						</div>

						<div class="box-footer">
							<span class="pull-right">
								<input type="text" data-key='DataId' style="display:none;">
								<button class="btn btn-primary btn-flat" data-form="modalMessage">
									<i class="fa fa-send"></i> Send Message
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
<!-- <script type="text/javascript" src="lib/scripts/widgets.js"></script> -->
<script type="text/javascript" src="lib/scripts/modules/client_process_request.js"></script>
