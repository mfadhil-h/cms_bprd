<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo(CMS_NAME)?>CMS | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo assets_site;?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo assets_site;?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo assets_site;?>plugins/iCheck/square/blue.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.1/js/bootstrap-dialog.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <style type="text/css">
    @media (max-width: 640px) {
      .login-page{
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
        background-image: url(<?php echo base_url('assets/images/bg_homescreen_xhdpi.jpg');?>);
      }

      .login-box{
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        /*width: 25vw;*/
        height:20vh;
        opacity: 1;
      }

      .login-box-body{
        position: relative;
        top: 80%;
        /*right: 110%;*/
        width: 100%;
      }

      .logo-compact{
        top: 50%;
        position: relative;
      }
    }

    @media (min-width: 641px) {
      .login-page{
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
        background-image: url(<?php echo base_url('assets/images/bg_homescreen.jpg');?>);
      }

      .login-box{
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        width: 25vw;
        height:20vh;
        opacity: 1;
      }

      .login-box-body{
        position: relative;
        top: 150%;
        right: 75%;
      }

      .logo-compact{
        top: 50%;
        position: relative;
      }
    }
    
    @media (min-width: 1281px) {
      .login-page{
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
        background-image: url(<?php echo base_url('assets/images/bg_homescreen.jpg');?>);
      }

      .login-box{
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        width: 25vw;
        height:20vh;
        opacity: 1;
      }

      .login-box-body{
        position: relative;
        top: 170%;
        right: 105%;
      }

      .logo-compact{
        top: 100%;position: absolute;right: 107%;
      }
    }

    .container-box{
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .logo-box{
       position: absolute;
       left: 0;
       right: 0;
       top: 0;
       bottom: 0;
    }

    .logo-box img{
      width:100%;
      height:100%;
    }

    .login-box-body{
      /*background: #339967;*/
      box-shadow: 1px 2px 5px 0px rgba(0,0,0,0.75);
    }

    .login-box-msg{
      color: white;
    }

    .login-box, .register-box {
      width: 360px;
      margin: auto;
    }


  </style>
</head>
<body class="hold-transition login-page">
