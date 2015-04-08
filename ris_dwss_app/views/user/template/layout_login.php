<?php 
    $session = $this->session->userdata('user_session'); 
    if(empty($session) || empty($session->language)){
        $session = new stdclass();
        $session->language = $this->config->item('default_language');
    }
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <head>
        <title><?php echo @$page_title . ' | ' . $this->config->item($session->language . '_app_name'); ?></title>
        <meta charset="utf-8" />
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="author" />

        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>bootstrap/css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo USER_FONT_URL; ?>style.css">
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>main.css">
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>main-responsive.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>iCheck/skins/all.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>perfect-scrollbar/src/perfect-scrollbar.css">
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>theme_light.css" id="skin_color">
        
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>custom.css">
        <!--[if IE 7]>
            <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>font-awesome/css/font-awesome-ie7.min.css">
        <![endif]-->

        <!--[if lt IE 9]>
            <script src="<?php echo PLUGIN_URL; ?>respond.min.js"></script>
            <script src="<?php echo PLUGIN_URL; ?>excanvas.min.js"></script>
        <![endif]-->
        <script src="<?php echo USER_JS_URL; ?>jquery.min.js"></script>
        <script src="<?php echo USER_JS_URL; ?>jquery.validate.js"></script>
    </head>

    <body class="login example2">
        <div class="main-login col-sm-4 col-sm-offset-4">
            <div class="logo">
                <img src="<?php echo USER_IMG_URL; ?>logo.png   " alt="">
            </div>

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

            <?php echo @$content_for_layout; ?>
            
            <div class="copyright">
                <p><?php echo $this->config->item($session->language . '_copyright_left'); ?></p>
                <p><?php echo $this->config->item($session->language . '_copyright_right'); ?></p>
            </div>
        </div>
    </body>
</html>