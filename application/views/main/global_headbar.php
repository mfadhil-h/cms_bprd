
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url();?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>BAPENDA</b></span>
      <!-- logo for regular state and mobile devices -->
      <!--   <span class="logo-lg"><b>CMS</b><?php echo(CMS_NAME)?></span> -->

	<span class="logo-lg"><b>BAPENDA</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="logo-jakarta" style="float: left;height: 50px;">
        <img src="<?php echo assets_site; ?>login/bprd.png" style="max-height: 90%;width: auto;top: 0;bottom: 0;margin: auto;position: absolute;">
      </div>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li><a href="<?php echo base_url('signin/logout');?>"><i class="fa fa-sign-out"></i> Sign out</a></li>
          <!-- <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Sadmin</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                <p>
                  Sadmin - Web Developer
                  <small>Member since</small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('signin/logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li> -->
        </ul>
      </div>

      <div class="logo-bprd" style="float: right;height: 50px;">
        <img src="<?php echo assets_site; ?>login/bprd2.png" style="max-height: 100%;width: auto;">
      </div>
       <div class="logo-bprd" style="float: right;height: 50px;">
        <img src="<?php echo assets_site; ?>login/bprd_bni.png" style="max-height: 87%;width: auto;">
      </div>
    </nav>
  </header>
