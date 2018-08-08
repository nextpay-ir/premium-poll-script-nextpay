<?php if(!defined("APP")) die()?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">
  <head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0" />  
    <meta name="description" content="<?php echo Main::description() ?>" />
    
    
    <title>Admin cPanel - <?php echo Main::title() ?></title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $this->config["url"] ?>/themes/default/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->url ?>/static/style.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $this->config["url"] ?>/static/js/flat/_all.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config["url"] ?>/static/js/chosen.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config["url"] ?>/static/js/jvector.css">

    <!-- Javascript Files -->
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/js/jquery.min.js?v=1.11.0"></script>
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/js/chosen.min.js?v=0.8.5"></script>
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/js/jquery-ui.min.js?v=1.10.3"></script> 
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/application.fn.js"></script>
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/bootstrap.min.js"></script>    
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/js/flot.js"></script>
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/js/jvector.js"></script>
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/js/jvector.world.js"></script>
    <script type="text/javascript" src="<?php echo $this->url ?>/static/dashboard.js"></script>
    <?php Main::admin_enqueue() ?>    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="navbar" role="navigation">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="glyphicon glyphicon-align-justify"></span>
              </button>
              <a class="navbar-brand" href="<?php echo $this->url ?>"><?php echo $this->config["title"] ?></a>
            </div>            
          </div>
          <div class="navbar-collapse collapse">         
            <form class="navbar-form navbar-left search" action="<?php echo Main::ahref("","search") ?>">
              <input type="text" class="form-control" size="80" placeholder="برای جستجوی کاربر‌ها، نظرسنجی‌ها و یا پرداختی ها را وارد کنید و اینتر را بزنید" name="q">
              <?php if(!$this->config["mod_rewrite"]): ?>
                <input type="hidden" name="a" value="search">
              <?php endif; ?>
            </form>             
            <ul class="nav navbar-nav navbar-right">
              <li><a href="<?php echo $this->config["url"] ?>" target="_blank"><span class="glyphicon glyphicon-globe"></span> نمایش سایت</a></li>
              <li><a href="<?php echo Main::href("user/logout") ?>"><span class="glyphicon glyphicon-log-out"></span> بیرون رفتن</a></li>
            </ul>           
          </div>        
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="<?php echo $this->url ?>/"><span class="glyphicon glyphicon-home"></span> پیشخوان</a></li>
            <li><a href="<?php echo Main::ahref("polls") ?>"><span class="glyphicon glyphicon-th-list"></span> نظرسنجی‌ها</a></li>
            <li><a href="<?php echo Main::ahref("users") ?>"><span class="glyphicon glyphicon-user"></span> کاربر‌ها</a></li>
            <li><a href="<?php echo Main::ahref("payments") ?>"><span class="glyphicon glyphicon-usd"></span> پرداختی‌ها</a></li>
            <li><a href="<?php echo Main::ahref("pages") ?>"><span class="glyphicon glyphicon-book"></span> صفحه‌ها</a></li>
            <li><a href="<?php echo Main::ahref("settings") ?>"><span class="glyphicon glyphicon-cog"></span> تنظیمات</a></li>
            <li><a href="<?php echo Main::ahref("help") ?>"><span class="glyphicon glyphicon-question-sign"></span> راهنما</a></li>
          </ul>
        </div>
        <div class="col-md-10 main">
          <?php echo Main::message() ?>
