<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/serendipity_icon.png" />

  <title>Serendipity | <?=$headtitle;?></title>
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="lib/design/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="lib/design/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="lib/design/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="lib/design/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="lib/design/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="lib/design/plugins/timepicker/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="lib/design/plugins/iCheck/all.css">

  <link rel="stylesheet" type="text/css" href="lib/scripts/libs/confirm/css/jquery-confirm.css"/>
  <link rel="stylesheet" type="text/css" href="lib/scripts/libs/confirm/demo/demo.css">
  
  <!-- <link rel="stylesheet" href="lib/scripts/libs/confirm/demo/libs/bundled.css"> -->

  <link rel="stylesheet" href="lib/dragdroptable/css/dragndrop.table.columns.css" />

  <!-- bootstrap datepicker -->
  <script src="lib/design/bower_components/moment/min/moment.min.js"></script>

  <link rel="stylesheet" href="lib/design/bower_components/select2/dist/css/select2.min.css">

  <link rel="stylesheet" href="lib/design/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="lib/design/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="lib/design/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="lib/design/dist/css/skins/_all-skins.min.css">

  <!-- <link rel="stylesheet" href="lib/design/dist/css/fontstyles.css"> -->
  <link rel="stylesheet" href="lib/design/plugins/iCheck/square/blue.css">

  <link href="lib/scripts/libs/toastr/build/toastr.css" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" type="text/css" href="lib/styles/mainStyle.css"  />
  <link rel="stylesheet" type="text/css" href="lib/styles/subStyle.css"  />
  <link rel="stylesheet" type="text/css" href="lib/styles/reportStyle.css"  />
  <link rel="stylesheet" type="text/css" href="lib/scripts/libs/confirm/css/jquery-confirm.css"/>

  <!-- PACE -->
  <!-- <link rel="stylesheet" href="lib/design/bower_components/PACE/themes/green/pace-theme-minimal.css"> -->
  <!-- <link rel="stylesheet" type="text/css" href="lib/design/plugins/pace/pace.min.css"> -->
</head>

<body class="hold-transition fixed skin-black collapsed sidebar-mini">

<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="<?=base_url();?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini" style="margin-left: -25px !important;">
                <img class="logo" src="images/serendipity_icon.png" alt="Home Logo" style="height: 40px; width: 70px; margin-top: 5px;">
            </span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" style="background-color: #FFFFFF !important;">
                <img class="logo" src="images/serendipity_logo.png" alt="Home Logo" style="height: 45px; width: 180px; margin-top: 3px;" />
            </span>    

        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">

            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"></a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="">Hi <?php echo ucfirst(strtolower($user));?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-body">
                                <!-- <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </div> -->
                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="changepassword" class="btn btn-info btn-flat">Change Password</a>
                                </div>  
                                <div class="pull-right">
                                    <a href="logout" class="btn btn-warning btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <?php echo $html; ?> 
        
        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1> 
          <span id="hPageTitle"><?=$title;?> </span>
          <!-- <button class="btn btn-warning btn-sm" data-trigger="refresh">
            <i class="fa fa-undo"></i>
          </button> -->
        </h1>
        
    </section>

    <!-- Main content -->
    <section id="main-div" class="content"> <?=$module;?> </section>

    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>&copy; Copyright <?=date("Y")?> </strong> - All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

</body>
</html>
<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<script src="lib/design/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="lib/design/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- <script src="lib/design/bower_components/PACE/pace.min.js"></script> -->
<script src="lib/design/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<script src="lib/design/bower_components/fastclick/lib/fastclick.js"></script>
<script src="lib/design/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="lib/design/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- bootstrap datepicker -->

<script src="lib/design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="lib/design/dist/js/adminlte.min.js"></script>
<script src="lib/design/plugins/iCheck/icheck.min.js"></script>
<!-- <script src="../../plugins/iCheck/icheck.min.js"></script> -->

<script src="lib/design/bower_components/chart.js/Chart.js"></script>
<script src="lib/design/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="lib/design/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- <script type="text/javascript" src="lib/design/pace/pace.js"></script> -->
<script type="text/javascript" src="lib/scripts/mainScript.js"></script>
<script type="text/javascript" src="lib/scripts/pager.js"></script>
<script type="text/javascript" src="lib/scripts/libs/toastr/toastr.js"></script>
<script type="text/javascript" src="lib/scripts/functions.js"></script>
<script type="text/javascript" src="lib/scripts/libs/confirm/js/jquery-confirm.js"></script>    
<script type="text/javascript" src="lib/scripts/libs/autoNumeric.js"></script>    

<script src="lib/dragdroptable/dist/for-jQuery3.x/dragndrop.table.columns.min.js" type="text/javascript"></script>
<!-- <script type="text/javascript">$(function(){_load('', '');});</script> -->
