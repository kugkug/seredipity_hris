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
                            <i class="fa fa-list" style="font-size: 16px !important;"></i> 
                            List of Employees
                        </h3>

                    </div>

                    <div class="box-body table-responsive">

                        <?=$employees; ?>

                    </div>                    
                </div>
            </div>
        </div>
    </body>
</html>
<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/workers.js"></script>
