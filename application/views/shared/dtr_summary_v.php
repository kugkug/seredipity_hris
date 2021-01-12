<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head>
    	<style type="text/css">

    		.divSmoker, .divAlch {
    			display : none;
    		}
    	</style>
    </head>

    <body>
        <div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="box box-warning repBox">
					<div class="box-header with-border">
						<h3 class="box-title">
							<i class="fa fa-search" style="font-size: 16px !important;"></i> 
							List
						</h3>

						<div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool btnCollapse" data-widget="collapse" id="btnCollapse"><i class="fa fa-minus"></i></button>
			            </div>
					</div>

					<div class="box-body">
						<?php
						print_r($dtrlist);
						?>
					</div>

					<div class="box-footer">
						<span class="pull-right">

							<button class="btn btn-warning btn-flat" name="btnSubmit" id="btnSubmit" data-trigger="submit" data-form="frmData" >
								<i class="fa fa-filter"></i> Run Filter
							</button>

							<button class="btn btn-danger btn-flat" name="btnClear" id="btnClear" data-trigger="clear" data-form="frmData">
								<i class="fa fa-trash"></i> Clear
							</button>

						</span>
					</div>

				</div>
			</div>
		
		</div>

		<div id="modalLogPhotos" class="modal fade" role="dialog">
			
	    	<div class="modal-dialog modal-md">
	        	<div class="modal-content">
	          		<div class="modal-header">
	            		<button type="button" class="close" data-dismiss="modal">&times;</button>
	            		<h4 class="modal-title"> <i class="fa fa-image"></i> Timelog Photos </h4>
	          		</div>
	          		<div class="modal-body">

	          			<div class="row">
	          				
	          				<div class="col-md-6" style="text-align: center;">
	          					<h3>Time In</h3>
	          					<div id="divTimeIn"></div>
	          				</div>

	          				<div class="col-md-6" style="text-align: center;">
	          					<h3>Time Out</h3>
	          					<div id="divTimeOut"></div>
	          				</div>

	          			</div>
	          		</div>
	          	</div>
	          </div>

		 </div>
    </body>
</html>
<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/dtr_summary.js"></script>