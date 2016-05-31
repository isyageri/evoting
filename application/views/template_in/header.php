<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>E-Voting | Media</title>

    <meta name="description" content="overview &amp; stats"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>

    <!-- Favicon -->
    <link type="image/x-icon" href="<?php echo base_url(); ?>favicon.png" rel="shortcut icon"/>

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css"/>

    <!--JqGrid-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ui.jqgrid.css"/>

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-fonts.css"/>
<!--    <link rel="stylesheet" href="--><?php //echo base_url(); ?><!--assets/css/spinners.css"/>-->

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.css" class="ace-main-stylesheet"
          id="main-ace-style"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/preload/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/preload/main.css">

    <!--[if lte IE 9]>
    <!--<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-part2.css" class="ace-main-stylesheet"/>-->
    <![endif]-->

    <!--[if lte IE 9]>
    <!--<link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.css"/>-->
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
<!--    <script src="--><?php //echo base_url(); ?><!--assets/js/ace-extra.js"></script>-->

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
    <!--<script src="<?php echo base_url();?>assets/js/html5shiv.js"></script>-->
<!--    <script src="--><?php //echo base_url();?><!--assets/js/respond.js"></script>-->
    <![endif]-->
</head>

<body class="no-skin">
<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed')
        } catch (e) {
        }
    </script>

    <div class="navbar-container" id="navbar-container">
        <!-- #section:basics/sidebar.mobile.toggle -->
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <!-- /section:basics/sidebar.mobile.toggle -->
        <div class="navbar-header pull-left">
            <!-- #section:basics/navbar.layout.brand -->
            <a href="<?php echo site_url('apps');?>" class="navbar-brand">
                <small>
                    <i class="fa fa-cubes"></i>
                    Evoting
                </small>
            </a>

        </div>

        <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">

                <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="<?php echo base_url(); ?>assets/avatars/avatar.png"
                             alt="Avatar"/>
								<span class="user-info">
									<small>Welcome,</small>
                                    <?php echo $this->session->userdata("admin_name"); ?>
								</span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="#">
                                <i class="ace-icon fa fa-cog"></i>
                                Settings
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo site_url("/auth/profile"); ?>">
                                <i class="ace-icon fa fa-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo site_url("auth"); ?>">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- /section:basics/navbar.user_menu -->
            </ul>
        </div>

        <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
</div>

<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
    <?php $this->load->view('template_in/sidebar');?>
    <div class="main-content">
        <div class="main-content-inner">
            <div id="ajaxContent">

               <!-- <script type="text/javascript">
                    $(function() {
                       // $('.nav a[href~="#"]').parents('li').addClass('active open');
                        $('.nav a[href~="' + location.href + '"]').parents('li').addClass('active');
                    });
                </script>-->
