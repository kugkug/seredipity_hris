<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>

    <body>
        <div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h3 class="box-title">
							<i class="fa fa-institution" style="font-size: 16px !important;"></i> 
							Client Requests List
						</h3>

						<div class="box-tools pull-right">

			 			 	<button  class="btn btn-primary btn-sm btn-flat" title="New Client" data-trigger="request">
			 					<i class="fa fa-plus"></i> New Request
			 				</button>

			          	
			                <!-- <button type="button" class="btn btn-box-tool btnCollapse" data-widget="collapse" id="btnCollapse"><i class="fa fa-minus"></i></button> -->
			            </div>
					</div>

					<div class="box-body table-responsive">

						<?=$requests?>

					</div>

					

					
				</div>
			</div>
		</div>


		

    </body>
</html>

<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/client_request.js"></script>
