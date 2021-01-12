<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>

    <body>
    	<div class="row">
	        <div class="col-sm-10 col-md-10">
				<form class="form-horizontal" name="frmNotes" id="frmNotes">
					<div class="box box-danger repBox">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-sticky-note-o" style="font-size: 16px !important;"></i> Participant Notes</h3>
							<div class="box-tools pull-right">
				                <button type="button" class="btn btn-box-tool btnCollapse" data-widget="collapse"><i class="fa fa-minus"></i></button>
				            </div>
						</div>

						<div class="box-body">
							<textarea class="form-control" rows="20" style="width: 100%; resize: none;" id="txtNotes" name="txtNotes"><?=$part_notes;?></textarea>
						</div>
						<div class="box-footer">
							<span class="pull-right">
					            <button class="btn btn-primary" btn-trigger="update" data-form="frmNotes"  title="Save Notes">
					              	<i class="fa fa-save"></i> Save
					            </button>
							</span>
						</div>
					</div>
				</form>
			</div>
			<div class="col-sm-2 col-md-2">
				<div class="small-box bg-red" style="position: fixed;">
		            <div class="inner divPhoto">
		            	<center>
		              		<h4><?=$part_id;?></h4>

		              		<img src="photos/<?=$part_photo;?>" style="height: 150px;">
		              	</center>
		            </div>
		            
		            <span class="small-box-footer">
		              	<!-- Household Head -->
		            </span>
		        </div>
			</div>
		</div>
    </body>
</html>
<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/notes.js"></script>