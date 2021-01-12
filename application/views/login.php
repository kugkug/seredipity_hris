<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/serendipity_icon.png" />

  <title> Login </title>
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="lib/design/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="lib/design/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="lib/design/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="lib/design/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="lib/design/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="lib/design/dist/css/fontstyles.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="lib/design/plugins/iCheck/square/blue.css">

  <link href="lib/scripts/libs/toastr/build/toastr.css" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="lib/styles/mainStyle.css">

</head>
<body class="hold-transition login-page" style="overflow: hidden;">
<div class="login-box">
  <div class="login-logo">
    <a href="/peds">
        <img class="logo" src="images/serendipity.png" alt="Home Logo" style="height: 90px; width: 230px; margin-top: 3px;"/>
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form id="frm_login" name="frm_login">
        <div class="form-group has-feedback">
        <input type="text" class="form-control" name="txtUserName" id="txtUserName"  placeholder="Username" data="req">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>

      <!-- <div class="form-group has-feedback">
        <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Email" data="req">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div> -->

      <div class="form-group has-feedback">
        <input type="password" id="txtPassWord" name="txtPassWord" class="form-control" placeholder="Password" data="req">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <!-- <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div> -->
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="lib/design/bower_components/jquery/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="lib/design/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="lib/design/plugins/iCheck/icheck.min.js"></script>
<script src="lib/scripts/mainScript.js"></script>
<script src="lib/scripts/libs/toastr/toastr.js"></script>
<script>
  $(function () {
    $("#txtUserName").focus();

    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
