<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>

    <body>
       <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">

                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="box-title">
                                    <i class="fa fa-list" style="font-size: 16px !important;"></i> 
                                    List of Applicants
                                </h3>        
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label>Clients: </label>
                                    </div>
                                    <div class="col-md-5">
                                        <?=$clients;?>                
                                    </div>

                                    <div class="col-md-1">
                                        <label>Status: </label>
                                    </div>
                                    <div class="col-md-5">
                                        <?=$appstat;?>                
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                        
                            
                        
                    </div>

                    <div class="box-body table-responsive">
                        <?=$employees; ?>
                    </div>

                    <div class="box-footer">                        
                        <button class="btn btn-warning btn-flat disabled" data-trigger='texts'>
                            <i class="fa fa-envelope"></i>

                            Send a Message
                        </button>
                    </div>                   
                </div>
            </div>
        </div>
    </body>

    <div id="modalAppDetails" class="modal fade" role="dialog">
        <form class="form-horizontal" autocomplete="off">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> <i class="fa fa-send"></i> Applicant Details </h4>
                    </div>
                    <div class="modal-body divScroll">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 divData" style="padding: 10px 30px;" ></div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </form>
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
                                <textarea rows="10" class="input-sm form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <span class="pull-right">                            
                            <button class="btn btn-primary btn-flat" data-form="modalMessage" data-trigger='sendsms'>

                                <i class="fa fa-send"></i> Send Message
                            </button>

                        </span>
                    </div>

                </div>
            </div>
        </form>
    </div>
</html>
<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="lib/scripts/widgets.js"></script>
<script type="text/javascript" src="lib/scripts/modules/application.js"></script>

