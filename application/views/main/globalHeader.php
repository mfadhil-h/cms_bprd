<!--
    Daterangepicker
    datepicker
    Select2
    Select
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Portal SAI</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="testing" name="description"/>
    <meta content="" name="haty"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="<?= base_url('assets/global/plugins/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet"
          type="text/css"/>
    <link href="<?= base_url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') ?>" rel="stylesheet"
          type="text/css"/>
    <link href="<?= base_url('assets/global/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet"
          type="text/css"/>
    <link href="<?= base_url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') ?>" rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?= base_url('assets/global/plugins/datatables/datatables.min.css') ?>" rel="stylesheet"
          type="text/css"/>
    <link href="<?= base_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') ?>"
          rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') ?>"
          rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/global/plugins//bootstrap-daterangepicker/daterangepicker.min.css') ?>"
          rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS
        <link href="<?= base_url('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url('assets/global/plugins/clockface/css/clockface.css') ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?= base_url('assets/global/plugins/select2/css/select2.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/global/plugins/select2/css/select2-bootstrap.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css') ?>" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?= base_url('assets/global/css/components.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/global/css/plugins.min.css') ?>" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?= base_url('assets/layouts/layout/css/layout.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/layouts/layout/css/themes/darkblue.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/layouts/layout/css/custom.min.css') ?>" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?= base_url("assets/global/jquery-1.10.2.js") ?>"></script>
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="<?= base_url('assets/layouts/layout/img/logo-pix.png') ?>"/>
</head>
<!-- END HEAD -->
<body class="page-header-fixed page-footer-fixed page-sidebar-closed-hide-logo page-content-white">
<!-- tutup di footer -->
<div class="page-wrapper"><!-- tutup di footer -->
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo" style="padding:0px">
                <a href="<?= base_url() ?>" style="color:#CCC">
                    <img src="<?= base_url('assets/layouts/layout/img/logo-pix2.png') ?>" alt="logo"
                         class="logo-default" style="margin:0px"/>
                    <!-- <span><small>Surya Abadi Isolasi</small></span>-->
                </a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
               data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle"
                                 src="<?= base_url('assets/layouts/layout/img/newuserjs.png') ?>"/>
                            <span class="username username-hide-on-mobile"><?= $this->session->userdata('nama_user') ?></span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu" style="width:275px">
                            <li>
                                <a href="#" class="removefromcart">
                                    <span class="details">
                                        <span class="label label-sm label-icon label-success">
                                            
                                        </span> Logged in Sebagai
                                        <?php
                                        $group_name_js = 'id="group_name_sel" class="form-control input-sm" ';
                                        echo form_dropdown('group_name_sel',$this->session->userdata('group_user'),$this->session->userdata('group_userAktif'),$group_name_js);
                                    ?>
                                    </span>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= base_url('logout') ?>">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"></div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">