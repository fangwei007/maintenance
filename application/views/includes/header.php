<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>     <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>     <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?= isset($title) ? $title : '比橙-关注海外华人创业'; ?></title>
<link rel="icon" type="image/png" href="<?=  base_url(); ?>assets/images/site/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="<?=  base_url(); ?>assets/images/site/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="<?=  base_url(); ?>assets/images/site/favicon-16x16.png" sizes="16x16">
<link rel="stylesheet" href="<?=  base_url(); ?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=  base_url(); ?>assets/css/jquery.Jcrop.min.css">
<link rel="stylesheet" href="<?=  base_url(); ?>assets/css/main.css">

<!--[if IE]>  
     <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>  
<![endif]-->
<script src="<?=  base_url(); ?>assets/js/jquery.js"></script>  
<script src="<?=  base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type= "text/javascript" src = "<?= base_url();?>assets/js/countries_states.js"></script>
<script src="<?=  base_url(); ?>assets/js/my_js.js"></script>

</head>

<body>
<!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
<div align="center"><img src="<?=  base_url(); ?>assets/images/site/bg_pattern.jpg"  id="headerBg" /></div>
<div id="page" class="clearfix">
  <header id="header" class="header clearfix">
      <div id="logo"><a href="<?= base_url(); ?>"><img src="<?=  base_url(); ?>assets/images/site/logo.png"></a></div>
            <div id="navigation">
                <div class="clearfix">
                        <nav id="thirdary-menu" role="navigation">
                                <ul class="social-icon">
<!--                                        <li><a href="#" target="_blank"><img src="<?=  base_url(); ?>assets/images/site/social_weibo.jpg" /></a></li>
                                        <li><a href="#" target="_blank"><img src="<?=  base_url(); ?>assets/images/site/social_fb.jpg" /></a></li>-->
                                        <li><a href="#" target="_blank"><img src="<?=  base_url(); ?>assets/images/site/social_linkedin.jpg" /></a></li>
                                        <li><a href="mailto:info@bridgeous.com?Subject=联系比橙" target="_top"><img src="<?=  base_url(); ?>assets/images/site/social_email.jpg" /></a></li>
                                </ul>
                        </nav>
                        <nav id="secondary-menu" role="navigation">
                                <ul>
                                    <?php if(in_array($this->session->userdata('role'), $this->config->item('dashboard'))):?>
                                    <li><a href="<?=  base_url() ?>admin/dashboard"><?= lang('dashboard')?></a></li>
                                    <?php endif; ?>
                                    <?php if($this->session->userdata('logged_in')) {?>
                                    <li>
                                        <a href="<?=  base_url()?>my_account"><?= $this->session->userdata('nickname')?></a>
                                        <span class="dropdown">
                                            <a data-toggle="dropdown" href="#"><img src="<?=  base_url()?>assets/images/site/account_menu.jpg" alt="account menu"/></a>                                                                              
<!--                                            <div class="arrow"></div>-->
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="<?=  base_url(); ?>my_account/edit_my_profile"><span><?= lang('my_profile')?></span></a></li>
                                                <?php if(get_user_session('status') === 'V'):?>
                                                <li><a href="<?=  base_url(); ?>my_account/add_post"><span>发布新资讯</span></a></li>  
                                                <li><a href="<?=  base_url(); ?>my_account/add_position"><span>发布新职位</span></a></li>
                                                <?php endif; ?>
                                                <li><a href="<?=  base_url(); ?>logout"><span><?= lang('sign_out')?></span></a></li>
                                            </ul>
                                        </span>
                                        
                                    </li>
                                    <?php } else {?>
                                    <div class="">
                                        <li><a href="#" id="sign-up"><?= lang('register')?></a></li>
                                        <li><a href="#" id="sign-in"><?= lang('sign_in')?></a></li>
                                    </div>
                                    <?php }?>
                                </ul>
                        </nav>
                </div><!-- / clearfix -->
                <?= $this->load->view('includes/header/main_menu'); ?>
			
            </div><!-- / navigation -->
            <!-- Login&signup div -->
            <?= $this->load->view('includes/header/sign_up'); ?>
            <?= $this->load->view('includes/header/sign_in'); ?>
            <div id="to-top" style="display:none;"><a href="#header"><img src="<?= base_url();?>assets/images/site/top_btn.png" alt="back to top"/></a></div>
  </header>
    <div id="main">