<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang='en'>
    <head></head>

    <body>
        <div class="login-box">
            <div class="login-box-body">
            <p class="login-box-msg">Update Password</p>

            <form id="frmMain">
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Current Password" data="req" data-key="CurPass">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="New Password" data="req" data-key="NewPass">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Confirm Password" data="req" data-key="ConPass">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-8"></div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<script type="text/javascript" src="lib/scripts/modules/changepass.js"></script>