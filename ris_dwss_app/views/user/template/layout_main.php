<?php 
    $session = $this->session->userdata('user_session'); 
    if(empty($session->language)){
        $session->language = 'en';
    }
?>
<!DOCTYPE html>
<!-- Template Name: Clip-One - Responsive Admin Template build with Twitter Bootstrap 3 Version: 1.0 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <title><?php echo @$page_title . ' | ' . $this->config->item($session->language . '_app_name'); ?></title>
        <!-- start: META -->
        <meta charset="utf-8" />
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="author" />

        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>summernote/summernote.min.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>datepicker/css/datepicker.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>icheck/skins/all.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>perfect-scrollbar/src/perfect-scrollbar.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>chosen/chosen.min.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>icheck/skins/all.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>bootstrap-fileupload/bootstrap-fileupload.min.css">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>sweet-alert/sweet-alert.css">

        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>bootstrap/css/bootstrap.min.css" media="screen">
        <link rel="stylesheet" href="<?php echo PLUGIN_URL; ?>font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo USER_FONT_URL; ?>style.css">
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>main.css">
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>main-responsive.css">
        <link rel="stylesheet" href="<?php echo USER_CSS_URL; ?>theme_light.css" id="skin_color">
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
    <body class="tooltips">
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="clip-list-2"></span>
                    </button>
                    <a href="<?php echo USER_URL; ?>" class="navbar-brand">
                        <?php echo $this->config->item($session->language . '_app_name'); ?>
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

                        <li class="dropdown">
                            <a data-toggle="modal" class="" role="button" href="#contact-details">
                                <i class="icon-phone"></i>
                                <span class="title"><?php echo $this->lang->line('contact_details'); ?></span>
                            </a>
                        </li>

                        <li class="dropdown">
                            <a class="" href="http://webmail.apmcbaroda.org/" target="_blank" rel="nofollow">
                                <i class="icon-envelope-alt"></i>
                                <span class="title"><?php echo $this->lang->line('webmail'); ?></span>
                            </a>
                        </li>
                        
                        <li class="dropdown current-user">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="username"><?php echo $session->{$session->language.'_fullname'}; ?></span>
                                <i class="clip-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <img src="<?php echo ASSETS_URL .'uploads/user_images/'. $session->profile_pic; ?>" class="userprofile-img" alt="">
                                </li>
                                <li>
                                    <a href="<?php echo USER_URL.'profile'; ?>">
                                        <i class="clip-user-2"></i>
                                        &nbsp;<?php echo $this->lang->line('my_profile'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo USER_URL .'password'; ?>">
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
                    <div class="navigation-toggler">
                        <i class="clip-chevron-left"></i>
                        <i class="clip-chevron-right"></i>
                    </div>
                    <?php
                        $uri_1 = ($this->uri->segment(2) ? $this->uri->segment(2) : 'dashboard');
                        $uri_2 = ($this->uri->segment(2) ? $this->uri->segment(3) ? $this->uri->segment(3) : $this->uri->segment(2) : 'dashboard');

                        $view_offer_requriment = false;
                        $view_advertisement = false;
                        $view_order_form = false;
                    ?>
                    <ul class="main-navigation-menu">
                        <li class="<?php echo ($uri_1 == 'dashboard') ? 'active open' : ''; ?>">
                            <a href="<?php echo USER_URL; ?>"><i class="clip-home-3"></i>
                                <span class="title"><?php echo $this->lang->line('dashboard'); ?></span>
                            </a>
                        </li>

                        <?php if (hasPermission('communications', 'viewCommunication')) { ?>
                            <li class="<?php echo ($uri_1 == 'communication') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'communication'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('communication'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if($this->session_data->role == 3) { ?>
                            <?php if (hasPermission('suppliers', 'manageProductSupplier')) { ?>
                                <li class="<?php echo ($uri_1 == 'supplier') ? 'active open' : ''; ?>">
                                    <a href="<?php echo USER_URL . 'supplier/product'; ?>"><i class="icon-asterisk"></i>
                                        <span class="title"><?php echo $this->lang->line('supplier_manage_product'); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($this->session_data->role ==1 || $this->session_data->role ==2) { ?>
                            <li class="<?php echo ($uri_1 == 'productcategory' || $uri_1 == 'product' || $uri_1 == 'productrate') ? 'active open' : ''; ?>">
                                <a href="#">
                                    <i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('product'); ?></span><i class="icon-arrow"></i>
                                </a>
                                <ul class="sub-menu">
                                    <?php if (hasPermission('product', 'viewProduct')) { ?>
                                        <li class="<?php echo ($uri_1 == 'product') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'product'; ?>"><i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('product'); ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (hasPermission('productcategories', 'viewProductcategory')) { ?>
                                        <li class="<?php echo ($uri_1 == 'productcategory') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'productcategory'; ?>"><i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('product_category'); ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (hasPermission('productrates', 'viewProductrate')) { ?>
                                        <li class="<?php echo ($uri_1 == 'productrate') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'productrate'; ?>"><i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('product_rate'); ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if ($this->session_data->role ==1 || $this->session_data->role ==2) { ?>
                            <li class="<?php echo ($uri_1 == 'supplier' || $uri_1 == 'selloffer' || $uri_1 == 'supplierrequriment') ? 'active open' : ''; ?>">
                                <a href="#">
                                    <i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('supplier'); ?></span><i class="icon-arrow"></i>
                                </a>
                                <ul class="sub-menu">
                                    <?php if (hasPermission('suppliers', 'viewSupplier')) { ?>
                                        <li class="<?php echo ($uri_1 == 'supplier') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'supplier'; ?>"><i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('supplier'); ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if(hasPermission('selloffers', 'viewSelloffer')) { ?>
                                        <li class="<?php echo ($uri_1 == 'selloffer') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'selloffer'; ?>"><i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('selloffer'); ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if(hasPermission('supplierrequriments', 'viewSupplierrequriment')) { ?>
                                        <li class="<?php echo ($uri_1 == 'supplierrequriment') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'supplierrequriment'; ?>"><i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('supplierrequriment'); ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } else if($this->session_data->role == 3) {
                                if(checkSuppliersupplierAmenities(4, $this->session_data->supplier_id)){
                                    $view_offer_requriment = true;
                                }
                            ?>

                            <?php if($view_offer_requriment && hasPermission('selloffers', 'viewSelloffer')) { ?>
                                <li class="<?php echo ($uri_1 == 'selloffer') ? 'active open' : ''; ?>">
                                    <a href="<?php echo USER_URL .'selloffer'; ?>"><i class="icon-asterisk"></i>
                                        <span class="title"><?php echo $this->lang->line('selloffer'); ?></span>
                                    </a>
                                </li>
                            <?php } ?>

                            <?php if($view_offer_requriment && hasPermission('supplierrequriments', 'viewSupplierrequriment')) { ?>
                                <li class="<?php echo ($uri_1 == 'supplierrequriment') ? 'active open' : ''; ?>">
                                    <a href="<?php echo USER_URL .'supplierrequriment'; ?>"><i class="icon-asterisk"></i>
                                        <span class="title"><?php echo $this->lang->line('supplierrequriment'); ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>

                        <?php if($this->session_data->role == 3) {
                            if(checkSuppliersupplierAmenities(5, $this->session_data->supplier_id)){
                                $view_order_form = true;
                            }
                        } ?>

                        <?php if ($view_order_form && hasPermission('packets', 'viewPacket')) { ?>
                            <li class="<?php echo ($uri_1 == 'packet') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'packet'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('manage_packet'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if($this->session_data->role == 1 || $this->session_data->role == 2){
                            $view_advertisement = true;
                        } else if($this->session_data->role == 3) {
                            if(checkSuppliersupplierAmenities(2, $this->session_data->supplier_id)){
                                $view_advertisement = true;
                            }
                        } ?>

                        <?php if ($view_advertisement && hasPermission('advertisements', 'viewAdvertisement')) { ?>
                            <li class="<?php echo ($uri_1 == 'advertisement') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'advertisement'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('advertisement'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        

                        <?php if (hasPermission('latestnews', 'viewLatestnews')) { ?>
                            <li class="<?php echo ($uri_1 == 'latestnews') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'latestnews'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('news'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('tenders', 'viewTender')) { ?>
                            <li class="<?php echo ($uri_1 == 'tender') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'tender'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('tender'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('galleries', 'viewGallery')) { ?>
                            <li class="<?php echo ($uri_1 == 'gallery') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'gallery'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('gallery'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('markets', 'viewMarket')) { ?>
                            <li class="<?php echo ($uri_1 == 'market') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'market'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('markets'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('villages', 'viewVillage')) { ?>
                            <li class="<?php echo ($uri_1 == 'village') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'village'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('villages'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('commodities', 'viewCommodity')) { ?>
                            <li class="<?php echo ($uri_1 == 'commodity') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'commodity'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('commodities'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('statistics', 'viewStatistic')) { ?>
                            <li class="<?php echo ($uri_1 == 'statistic') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'statistic'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('statistical_data'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('markets', 'updateMarketFees')) { ?>
                            <li class="<?php echo ($uri_1 == 'market' && $uri_2 == 'market_fee') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'market/market_fee'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('market_fees'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('bods', 'viewBod') || hasPermission('stafves', 'viewStaff')) { ?>
                            <li class="<?php echo ($uri_1 == 'bod' || $uri_1 == 'staff' || $uri_1 == 'user') ? 'active open' : ''; ?>">
                                <a href="#">
                                    <i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('users'); ?></span><i class="icon-arrow"></i>
                                </a>
                                <ul class="sub-menu">
                                    <?php if (hasPermission('users', 'viewUser')) { ?>
                                        <li class="<?php echo ($uri_1 == 'user') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'user'; ?>"><i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('users'); ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (hasPermission('bods', 'viewBod')) { ?>
                                        <li class="<?php echo ($uri_1 == 'bod') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'bod'; ?>"><i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('bod'); ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (hasPermission('stafves', 'viewStaff')) { ?>
                                        <li class="<?php echo ($uri_1 == 'staff') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'staff'; ?>"><i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('staff'); ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('pages', 'viewPage') || hasPermission('emails', 'viewEmail')) { ?>
                            <li class="<?php echo ($uri_1 == 'page' || $uri_1 == 'email') ? 'active open' : ''; ?>">
                                <a href="#">
                                    <i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('templates'); ?></span><i class="icon-arrow"></i>
                                </a>
                                <ul class="sub-menu">
                                    <?php if (hasPermission('pages', 'viewPage')) { ?>
                                        <li class="<?php echo ($uri_1 == 'page') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'page'; ?>"><i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('page_template'); ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>

                                    <?php if (hasPermission('emails', 'viewEmail')) { ?>
                                        <li class="<?php echo ($uri_1 == 'email') ? 'active open' : ''; ?>">
                                            <a href="<?php echo USER_URL .'email'; ?>">
                                                <i class="icon-asterisk"></i>
                                                <span class="title"><?php echo $this->lang->line('email_template'); ?></span></i>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('roles', 'viewRole')) { ?>
                            <li class="<?php echo ($uri_1 == 'role') ? 'active open' : ''; ?>">
                                <a href="<?php echo USER_URL .'role'; ?>"><i class="icon-asterisk"></i>
                                    <span class="title"><?php echo $this->lang->line('role'); ?></span>
                                </a>
                            </li>
                        <?php } ?>

                        <?php if (hasPermission('systemsettings', 'viewSystemSetting')) { ?>
                            <li class="<?php echo ($uri_1 == 'system_setting' && ($uri_2 == 'general' || $uri_2 == 'mail')) ? 'active open' : ''; ?>">
                                <a href="#">
                                    <i class="icon-asterisk"></i>
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

        <!--<div class="footer-items">
            <span class="go-top"><i class="clip-chevron-up"></i></span>
        </div> -->

        <div class="footer clearfix">
            <p class="col-md-6"><?php echo html_entity_decode($this->config->item($session->language . '_copyright_left')); ?></p>
            <p class="col-md-6 text-right"><?php echo html_entity_decode($this->config->item($session->language . '_copyright_right')); ?></p>
        </div>

<div class="modal fade" id="contact-details" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo USER_ASSETS_URL .'images/contact_us.png' ?>" class="img-responsive">
            </div>
        </div>
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
        <script src="<?php echo PLUGIN_URL; ?>icheck/jquery.icheck.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>chosen/chosen.jquery.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>perfect-scrollbar/src/jquery.mousewheel.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>perfect-scrollbar/src/perfect-scrollbar.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>summernote/summernote.min.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>sweet-alert/sweet-alert.js"></script>
        <script src="<?php echo PLUGIN_URL; ?>datepicker/bootstrap-datepicker.js"></script>
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