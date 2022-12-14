<div class="container-box2">
<div class="logo-box">
  <!-- <img src="<?php echo assets_site; ?>login/bprd.png" style="width: auto;max-height: 100vh;left: 0;right: 0;display: block;margin: auto;opacity: 0.8;z-index: -1000000;"> -->
</div>
<div class="login-box">
  <div class="login-logo">
   <!-- <a href="<?php echo base_url();?>" style="color: #FFF"><b><?php echo(CMS_NAME)?></b>CMS</a> -->
   <!-- <a href="<?php echo base_url();?>" style="color: #FFF"><b>BPRD</b>&nbsp; <br>CMS</a>  -->
  </div>
  <!-- /.login-logo -->

  <div class="logo-compact">
    <img src="<?php echo assets_site; ?>images/logo-compact.png" style="width: auto;max-height: 100vh;left: 0;right: 0;display: block;margin: auto;opacity: 0.8;z-index: -1000000;">
  </div>
  <div class="login-box-body">
    <p class="login-box-msg" style="color: #595959;">Silahkan Login</p>

    <form action="<?php echo base_url();?>signin/verify" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="username" id="username" class="form-control" placeholder="NOPD / NPWP / User Name">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- <div class="col-xs-8">
          <a href="#">I forgot my password</a><br>
        </div> -->
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
<!--
    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->

    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
</div>
<!-- <div id="header" style="position: absolute;top: 0;width: 100%;height: 15%;display: inline-block;">
<div id="header_left" style="height: 100%;display: inline;">
  <img src="<?php echo assets_site; ?>login/bprd2.png" style="max-height: 100%;width: auto;">
</div>
<div id="header_right" style="height: 100%;display: inline;position: absolute;right: 0;">
   <img src="<?php echo assets_site; ?>login/bprd_bni.png" style="max-height: 100%;width: auto;right: 0;">
</div>
</div> -->
