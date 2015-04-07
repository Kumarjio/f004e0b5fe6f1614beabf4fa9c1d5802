<?php $session = $this->session->userdata('user_session'); ?>
<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3 Version: 1.0 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <title><?php echo @$page_title . ' | ' . $this->config->item('app_name'); ?></title>
        <!-- start: META -->
        <meta charset="utf-8" />
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="author" />

        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>summernote/summernote.min.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>iCheck/skins/all.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>perfect-scrollbar/src/perfect-scrollbar.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>chosen/chosen.min.css">
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>theme_light.css" id="skin_color">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>datatables/dataTables.bootstrap.css">
        <link href="<?php echo PLUGIN_URL; ?>icheck/skins/all.css" rel="stylesheet">

        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>bootstrap/css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo USER_FONT_URL; ?>style.css">
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>main.css">
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>main-responsive.css">
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>custom.css">
        <!--[if IE 7]>
            <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>font-awesome/css/font-awesome-ie7.min.css">
        <![endif]-->
        <link rel="shortcut icon" href="<?php echo USER_IMG_URL; ?>favicon.ico" />

        <script src="<?php echo USER_JS_URL; ?>jquery.min.js"></script>
        <script src="<?php echo USER_JS_URL; ?>jquery.validate.js"></script>
        
        <script src="<?php echo PLUGIN_URL; ?>datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>datatables/dataTables.bootstrap.js"></script>

        

        <script type="text/javascript">
            var http_host_js = '<?php echo USER_URL; ?>';

            function UpdateLang(ele) {
                $.ajax({
                    type: 'POST',
                    url: http_host_js + 'change_language/' + $(ele).data('lang'),
                    success: function() {
                        window.location.reload();
                    }
                });
            }
        </script>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="clip-list-2"></span>
                    </button>
                    <a href="<?php echo USER_URL; ?>" class="navbar-brand">
                        <?php echo $this->config->item('app_name'); ?>
                    </a>
                </div>
                <div class="navbar-tools">
                    <ul class="nav navbar-right">
                        <?php $languages = $this->config->item('custom_languages'); ?>
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="icon-magic"></i>
                                <span class="badge" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo ucwords($languages[$session->language]); ?>"><?php echo strtoupper($session->language); ?></span>
                            </a>
                            <ul class="dropdown-menu todo">
                                <li>
                                    <span class="dropdown-menu-title"><?php echo $this->lang->line('change_language_selection'); ?></span>
                                </li>
                                <li>
                                    <div class="drop-down-wrapper ps-container">
                                        <ul>
                                            <?php foreach ($this->config->item('custom_languages') as $key => $value) { ?>
                                                    <li class="<?php echo ($session->language == $key) ? 'unread' : ''; ?>"><a href="javascript:;" onclick="UpdateLang(this)" class="language" data-lang ="<?php echo $key; ?>" data-toggle="tooltip" data-original-title="<?php echo ucwords($value); ?>"><?php echo ucwords($value); ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>

                            </ul>
                        </li>
                        <li class="dropdown current-user">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img src="<?php echo USER_ASSETS_URL .'user_images/'. $session->profile_pic; ?>" class="circle-img" alt="">
                                <span class="username"><?php echo $session->name; ?></span>
                                <i class="clip-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo USER_URL; ?>">
                                        <i class="clip-user-2"></i>
                                        &nbsp;<?php echo $this->lang->line('my_profile'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo USER_URL; ?>">
                                        <i class="clip-key"></i>
                                        &nbsp;<?php echo $this->lang->line('change_password'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo USER_URL .'logout'; ?>">
                                        <i class="clip-exit"></i>
                                        &nbsp;<?php echo $this->lang->line('logout'); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-container">
            <div class="navbar-content">
                <div class="main-navigation navbar-collapse collapse">
  
                    <?php
                        $uri_1 = ($this->uri->segment(2) ? $this->uri->segment(2) : 'dashboard');
                        $uri_2 = ($this->uri->segment(2) ? $this->uri->segment(3) ? $this->uri->segment(3) : $this->uri->segment(2) : 'dashboard');
                    ?>
                    <ul class="main-navigation-menu">
                        <li class="<?php echo ($uri_1 == 'dashboard') ? 'active open' : ''; ?>">
                            <a href="<?php echo USER_URL; ?>"><i class="clip-home-3"></i>
                                <span class="title"><?php echo $this->lang->line('dashboard'); ?></span>
                            </a>
                        </li>

                        <?php if (hasPermission('roles', 'viewRole')) { ?>
                            <li class="<?php echo ($uri_1 == 'role') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'role'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('role'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('emails', 'viewEmail')) { ?>
                            <li class="<?php echo ($uri_1 == 'email') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'email'; ?>">
                                    <i class="icon-envelope-alt"></i>
                                    <span class="title"><?php echo $this->lang->line('email_templates'); ?></span></i>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('systemsettings', 'viewSystemSetting')) { ?>
                            <li class="<?php echo ($uri_1 == 'system_setting' && ($uri_2 == 'general' || $uri_2 == 'mail')) ? 'active open' : ''; ?>">
                                <a href="#">
                                    <i class="icon-cog"></i>
                                    <span class="title"><?php echo $this->lang->line('setting'); ?></span><i class="icon-arrow"></i>
                                </a>
                                <ul class="sub-menu">
                                    <li class="<?php echo ($uri_2 == 'general') ? 'active' : ''; ?>"><a href="<?php echo USER_URL .'system_setting/general'; ?>"><i class="fa fa-wrench"></i><span class="title"><?php echo $this->lang->line('genral_setting'); ?></span></a></li>
                                    <li class="<?php echo ($uri_2 == 'mail') ? 'active' : ''; ?>"><a href="<?php echo USER_URL .'system_setting/mail'; ?>"><i class="fa fa-wrench"></i><span class="title"><?php echo $this->lang->line('mail_setting'); ?></span></a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                    <!-- end: MAIN NAVIGATION MENU -->
                </div>
            </div>
            <div class="main-content">
                <div class="container">
                    <?php if ($this->session->flashdata('success') != '') { ?>
                        <div class="row mar-10">
                            <div class="auto-close alert alert-success fade in alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p class="text-center">
                                    <?php echo $this->session->flashdata('success'); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($this->session->flashdata('warning') != '') { ?>
                        <div class="row">
                            <div class="auto-close alert alert-warning fade in alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p class="text-center">
                                    <?php echo $this->session->flashdata('warning'); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($this->session->flashdata('info') != '') { ?>
                        <div class="row mar-tp-10">
                            <div class="auto-close alert alert-info fade in alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p class="text-center">
                                    <?php echo $this->session->flashdata('info'); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($this->session->flashdata('error') != '') { ?>
                        <div class="row">
                            <div class="auto-close alert alert-danger fade in alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p class="text-center">
                                    <?php echo $this->session->flashdata('error'); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>

                    <?php echo @$content_for_layout; ?>
                </div>
            </div>
        </div>
        <div class="footer clearfix">
            <p class="col-md-6"><?php echo $this->config->item('copyright_left'); ?></p>
            <p class="col-md-6 text-right"><?php echo $this->config->item('copyright_right'); ?></p>
            <div class="footer-items">
                <span class="go-top"><i class="clip-chevron-up"></i></span>
            </div>
        </div>
        <!-- end: FOOTER -->

        <!-- start: MAIN JAVASCRIPTS -->
        <!--[if lt IE 9]>
        <script src="<?php echo PLUGIN_URL; ?>respond.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>excanvas.min.js"></script>
        <![endif]-->
        <script src="<?php echo PLUGIN_URL; ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>blockUI/jquery.blockUI.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>iCheck/jquery.icheck.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>chosen/chosen.jquery.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>perfect-scrollbar/src/jquery.mousewheel.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>perfect-scrollbar/src/perfect-scrollbar.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>summernote/summernote.min.js"></script>
        <script src="<?php echo USER_JS_URL; ?>main.js"></script>
        <script src="<?php echo USER_JS_URL; ?>custom.js"></script>
        <script>
            jQuery(document).ready(function() {
                Main.init();
            });
        </script>
    </body>
    <!-- end: BODY -->
</html>




























<?php /* 

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <title><?php echo @$page_title . ' | ' . $this->config->item('app_name'); ?></title>

        <link href="<?php echo PLUGIN_URL; ?>summernote/summernote.min.css" rel="stylesheet">
        <link href="<?php echo PLUGIN_URL; ?>sweet-alert/sweet-alert.css" rel="stylesheet">
        <link href="<?php echo PLUGIN_URL; ?>datatables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?php echo PLUGIN_URL; ?>datepicker/datepicker.min.css" rel="stylesheet">
        <link href="<?php echo PLUGIN_URL; ?>chosen/chosen.min.css" rel="stylesheet">
        <link href="<?php echo ADMIN_CSS_URL; ?>bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo ADMIN_CSS_URL; ?>ionicons.min.css" rel="stylesheet" />
        <link href="<?php echo ADMIN_CSS_URL; ?>style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo ADMIN_CSS_URL; ?>custom.css" rel="stylesheet">

        <link href="<?php echo ADMIN_CSS_URL; ?>font-awesome.css" rel="stylesheet" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo ADMIN_JS_URL; ?>jquery.min.js"></script>
        <script src="<?php echo ADMIN_JS_URL; ?>jquery-ui-1.10.3.min.js"></script>
        <script src="<?php echo ADMIN_JS_URL; ?>jquery.validate.js"></script>
        
        <script src="<?php echo PLUGIN_URL; ?>datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>datatables/dataTables.bootstrap.js"></script>

        <link href="<?php echo PLUGIN_URL; ?>icheck/skins/all.css" rel="stylesheet">

        <script type="text/javascript">
            var http_host_js = '<?php echo ADMIN_URL; ?>';
        </script>
    </head>

    <body class="tooltips skin-blue">

        <header class="header">
            <a href="<?php echo ADMIN_URL; ?>" class="logo">
                <?php echo $this->config->item('app_name'); ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $session->name; ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <p><?php echo $session->name; ?>
                                    <small><?php echo $session->email; ?></small></p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        &nbsp;
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo ADMIN_URL. 'logout'; ?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <?php
                $uri_1 = ($this->uri->segment(2) ? $this->uri->segment(2) : 'dashboard');
                $uri_2 = ($this->uri->segment(2) ? $this->uri->segment(3) ? $this->uri->segment(3) : $this->uri->segment(2) : 'dashboard');
                ?>
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="<?php echo ($uri_1 == 'dashboard') ? 'active' : ''; ?>"><a href="<?php echo ADMIN_URL; ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a> </li>
                        <li class="<?php echo ($uri_1 == 'company') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'company'; ?>"><i class="fa fa-users"></i>Company</a></li>
                        <li class="<?php echo ($uri_1 == 'newsletter') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'newsletter'; ?>"><i class="fa fa-newspaper-o"></i>Campaign</a></li>
                        <li class="<?php echo ($uri_1 == 'scrap') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'scrap'; ?>"><i class="fa fa-table"></i>Scrap</a></li>
                        <li class="<?php echo ($uri_1 == 'balancesheet') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'balancesheet'; ?>"><i class="fa fa-money"></i>Expense</a></li>
                        <li class="<?php echo ($uri_1 == 'role') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'role'; ?>"><i class="fa fa-list-alt"></i>Roles</a></li>
                        <li class="<?php echo ($uri_1 == 'lead') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'lead'; ?>"><i class="fa fa-list-alt"></i>Lead</a></li>
                        <li class="treeview <?php echo ($uri_1 == 'businesscategory' || $uri_1 == 'businesssubcategory') ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-gears"></i> <span>Business</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                 <li class="<?php echo ($uri_1 == 'businesscategory') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'businesscategory'; ?>"><i class="fa fa-cog"></i>Category</a></li>

                                <li class="<?php echo ($uri_1 == 'businesssubcategory') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'businesssubcategory'; ?>"><i class="fa fa-cog"></i>Sub Category</a></li>
                            </ul>
                        </li>

                        <li class="treeview <?php echo ($uri_1 == 'batch' || $uri_1 == 'student') ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-gears"></i> <span>Tranning Center</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                 <li class="<?php echo ($uri_1 == 'batch') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'batch'; ?>"><i class="fa fa-cog"></i>Batch</a></li>

                                <li class="<?php echo ($uri_1 == 'student' && $uri_2 == 'student') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'student'; ?>"><i class="fa fa-cog"></i>Student</a></li>

                                <li class="<?php echo ($uri_1 == 'student' && $uri_2 == 'fee') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'student/fee'; ?>"><i class="fa fa-cog"></i>Student Fee</a></li>
                            </ul>
                        </li>

                    
                        <li class="treeview <?php echo ($uri_1 == 'page' || $uri_1 == 'email' || $uri_1 == 'newslettertemplate') ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-gears"></i> <span>Templates</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($uri_1 == 'page') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'page'; ?>"><i class="fa fa-file-text"></i>Page</a></li>

                                <li class="<?php echo ($uri_1 == 'email') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'email'; ?>"><i class="fa fa-envelope"></i>Email</a></li>

                                <li class="<?php echo ($uri_1 == 'newslettertemplate') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'newslettertemplate'; ?>"><i class="fa fa-envelope"></i>Newsletter</a></li>
                            </ul>
                        </li>

                        <li class="treeview <?php echo ($uri_1 == 'system_setting' && ($uri_2 == 'general' || $uri_2 == 'mail')) ? 'active' : ''; ?>">
                            <a href="#">
                                <i class="fa fa-gears"></i> <span>Settings</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="<?php echo ($uri_2 == 'general') ? 'active' : ''; ?>"><a href="<?php echo ADMIN_URL .'system_setting/general'; ?>"><i class="fa fa-wrench"></i> General Setting</a></li>
                                <li class="<?php echo ($uri_2 == 'mail') ? 'active' : ''; ?>"><a href="<?php echo ADMIN_URL .'system_setting/mail'; ?>"><i class="fa fa-wrench"></i> Mail Setting</a></li>
                            </ul>
                        </li>

                        <li class="<?php echo ($uri_1 == 'system_setting' && $uri_2 == 'login_credential') ? 'active selected' : ''; ?>"><a href="<?php echo ADMIN_URL . 'system_setting/login_credential'; ?>"><i class="fa fa-gears"></i>Edit Profile</a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <aside class="right-side">
                <?php if(!empty($page_h1_title)){ ?>
                    <section class="content-header">
                        <h1><?php echo @$page_h1_title; ?></h1>
                    </section>
                <?php } ?>

                <?php if ($this->session->flashdata('success') != '') { ?>
                    <div class="pad margin no-print">
                        <div class="auto-close alert alert-success fade in alert-dismissable">
                            <i class="fa fa-thumbs-o-up"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="text-center">
                                <?php echo $this->session->flashdata('success'); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->session->flashdata('warning') != '') { ?>
                    <div class="pad margin no-print">
                        <div class="auto-close alert alert-warning fade in alert-dismissable">
                            <i class="fa fa-warning"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="text-center">
                                <?php echo $this->session->flashdata('warning'); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->session->flashdata('info') != '') { ?>
                    <div class="pad margin no-print">
                        <div class="auto-close alert alert-info fade in alert-dismissable">
                            <i class="fa fa-info"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="text-center">
                                <?php echo $this->session->flashdata('info'); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($this->session->flashdata('error') != '') { ?>
                    <div class="pad margin no-print">
                        <div class="auto-close alert alert-danger fade in alert-dismissable">
                            <i class="fa fa-thumbs-o-down"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="text-center">
                                <?php echo $this->session->flashdata('error'); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

                <section class="content">
                     <?php echo @$content_for_layout; ?>
                </section>
            </aside>
        </div>

        
        <script src="<?php echo PLUGIN_URL; ?>summernote/summernote.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>sweet-alert/sweet-alert.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>datepicker/bootstrap-datepicker.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>chosen/chosen.jquery.min.js"></script>
        <script src="<?php echo ADMIN_JS_URL; ?>bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo ADMIN_JS_URL; ?>app.js" type="text/javascript"></script>
    </body>
    </html>

    */ ?>