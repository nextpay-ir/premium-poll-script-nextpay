<?php defined("APP") or die() ?>
<!DOCTYPE html>
<html dir="rtl" lang="fa" prefix="og: http://ogp.me/ns#">
  <head>    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0" />  
    <meta name="description" content="<?php echo Main::description() ?>" />
    <?php echo Main::ogp(); ?>    
    
    <title><?php echo Main::title() ?></title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $this->config["url"] ?>/themes/default/css/bootstrap.min.css" rel="stylesheet">
    <!-- Component CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/<?php echo $css?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/css/widgets.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config["url"] ?>/static/js/flat/_all.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config["url"] ?>/static/js/chosen.min.css">
    <!-- Javascript Files -->
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/js/jquery.min.js?v=1.11.0"></script>
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/js/chosen.min.js?v=0.8.5"></script>
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/js/icheck.min.js?v=1.0.1"></script>
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/js/jquery-ui.min.js?v=1.10.3"></script> 
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/application.fn.js?v=1.0"></script>   
    <script>
      var appurl="<?php echo $this->config["url"] ?>";
      var token="<?php echo $this->config["public_token"] ?>";
      <?php if($this->isPro()): ?>
      var max_count= <?php echo $this->config["max_count"] ?>;
      <?php else: ?>
      var max_count= <?php echo $this->max_free ?>;      
      <?php endif ?>
    </script>
    <?php Main::enqueue() ?>    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body<?php echo Main::body_class() ?>>    
  <?php if($this->headerShow): ?>
    <?php if(!$this->isUser): ?> <?php // Show Page Layout ?>

      <header>
        <div class="navbar" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="glyphicon glyphicon-list"></span>
              </button>    

              <div class="site_logo">
                <?php if (!empty($this->config["logo"])): ?>
                  <a class="navbar-brand" href="<?php echo $this->config["url"] ?>"><img src="<?php echo $this->config["url"] ?>/static/<?php echo $this->config["logo"] ?>" alt="<?php echo $this->config["title"] ?>"></a>
                <?php else: ?>
                  <a class="navbar-brand" href="<?php echo $this->config["url"] ?>"><?php echo $this->config["title"] ?></a>
                <?php endif ?>
              </div> 

            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav pull-right">
                <?php if(!$this->logged()): ?>
                  <?php if($this->config["users"]): ?>
                    <li><a href="<?php echo Main::href("user/register") ?>" class="active"><?php echo e("Get Started") ?></a></li>
                  <?php endif ?>
                  <li><a href="<?php echo Main::href("user/login") ?>"><?php echo e("Login") ?></a></li>
                <?php else: ?>
                  <?php if ($this->admin()): ?>
                    <li><a href="<?php echo $this->config["url"] ?>/admin" class="active"><?php echo e("Admin") ?></a></li>
                  <?php endif ?>
                  <?php if(!$this->isPro()): ?>
                    <li><a href="<?php echo Main::href("upgrade") ?>" class="active"><?php echo e("Upgrade") ?></a></li>       
                  <?php endif ?>
                  <li><a href="<?php echo Main::href("user") ?>"><?php echo e("My Account") ?></a></li>          
                  <li><a href="<?php echo Main::href("user/settings") ?>"><?php echo e("Settings") ?></a></li>
                  <li><a href="<?php echo Main::href("user/logout") ?>"><?php echo e("Logout") ?></a></li>
                <?php endif ?>
              </ul>
            </div>
          </div>
        </div>
        <?php if($this->isHome): ?>
        <div class="container">
          <div class="row widget">
              <div class="col-md-8 promo">
                <h2><?php echo e("Simple. Beautiful. Modern.") ?></h2>
                <p><?php echo e("Create beautifully designed polls in under a minute. Choose from a library of templates or customize your own template. With many types of customization, you will make the poll <strong>your</strong> poll. Create an account to unlock even more features.") ?></p>
                <a href="<?php echo Main::href("create") ?>" class="btn btn-transparent btn-lg"><?php echo e("Create your Poll") ?></a>
              </div>
              <div class="col-md-4">
                <div class="box-holder">
                  <h4><?php echo e("Create a Free Account") ?></h4>
                  <form role="form" class="live_form" method="post" action="<?php echo Main::href("user/register") ?>">
                    <div class="form-group">
                      <label for="email"><?php echo e("Email address") ?></label>
                      <input type="email" class="form-control" id="email" placeholder="<?php echo e("Enter email") ?>" name="email">
                    </div>
                    <div class="form-group">
                      <label for="pass"><?php echo e("Password") ?></label>
                      <input type="password" class="form-control" id="pass" placeholder="<?php echo e("Enter Password") ?>" name="password">
                    </div>     
                    <div class="form-group">
                      <label for="pass"><?php echo e("Confirm Password") ?></label>
                      <input type="password" class="form-control" id="pass" placeholder="<?php echo e("Enter Password") ?>" name="cpassword">                    
                    </div>  
                    <p class="help-block"><?php echo e("By creating an account you accept our") ?> <a href="<?php echo $this->config["url"] ?>/page/terms" target="_blank"><?php echo e("terms and conditions") ?></a>.</p>                                      
                    <?php echo Main::csrf_token(TRUE) ?>         
                    <input type="hidden" name="terms" value="1">  
                    <button type="submit" class="btn btn-primary"><?php echo e("Create Account") ?></button>
                  </form>   
                </div>         
              </div>        
          </div>
        </div>    
      <?php endif; ?>
      </header> 

    <?php else: ?> <?php // Show Users Layout ?>
      <header class="full">
        <div class="navbar" role="navigation">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-2">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="glyphicon glyphicon-align-justify"></span>
                  </button>
                  <a class="navbar-brand" href="<?php echo $this->config["url"] ?>"><?php echo $this->config["title"] ?></a>
                </div>            
              </div>
              <div class="navbar-collapse collapse">                  
                <ul class="nav navbar-nav navbar-right">
                  <?php if ($this->admin()): ?>
                    <li><a href="<?php echo $this->config["url"] ?>/admin" class="active"><?php echo e("Admin") ?></a></li>
                  <?php endif ?>
                  <?php if(!$this->isPro()): ?>
                    <li><a href="<?php echo Main::href("upgrade") ?>" class="active"><?php echo e("Upgrade") ?></a></li>       
                  <?php endif ?>
                  <li><a href="<?php echo Main::href("create") ?>" class="active"><?php echo e("Create your Poll") ?></a></li>          
                  <li><a href="<?php echo Main::href("user/logout") ?>"><?php echo e("Logout") ?></a></li>
                </ul>           
              </div>        
            </div>
          </div>
        </div>      
      </header>
      <section>
        <div class="container-fluid">          
          <div class="row">
            <div class="col-md-2 sidebar"> 
              <div class="sidebar-holder">
                <div class="box-holder profile">                              
                  <div class="row">
                    <div class="col-md-3 avatar"><img src="<?php echo $this->user->avatar ?>" alt="Gravatar"></div>
                    <div class="col-md-9">
                      <?php if(!empty($this->user->name)): ?>
                        <?php echo $this->user->name ?>
                      <?php else: ?>
                        <?php echo $this->user->email ?>
                      <?php endif ?>                      
                    </div>
                  </div>                               
                </div>                 
                <form action="<?php echo Main::href("user/search") ?>" class="search" id="poll_search_form">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                    <input type="text" class="form-control" id="poll_search_q" placeholder="<?php echo e("Search of a poll") ?>">
                  </div>              
                </form>                                                 
                <ul class="nav nav-sidebar">
                  <li><a href="<?php echo Main::href("user") ?>" class="active"><span class="glyphicon glyphicon-home"></span> <?php echo e("Dashboard") ?></a></li>
                  <li><a href="<?php echo Main::href("user/active") ?>"><span class="glyphicon glyphicon-th-list"></span> <?php echo e("Active Polls") ?></a></li>
                  <li><a href="<?php echo Main::href("user/expired") ?>"><span class="glyphicon glyphicon-time"></span> <?php echo e("Expired Polls") ?></a></li>
                  <li><a href="<?php echo Main::href("user/settings") ?>"><span class="glyphicon glyphicon-cog"></span> <?php echo e("Settings") ?></a></li>
                </ul>
                <h3><?php echo e("Account info") ?> <span class="label label-primary pull-right"><?php echo ucfirst($this->user->membership)?></span></h3>
                <div class="stats">
                  <p><span><?php echo $this->db->count("poll","userid='{$this->user->id}'") ?></span> <?php echo e("Polls") ?></p>
                  <p><span><?php echo $this->db->count("vote","polluserid='{$this->user->id}'") ?></span> <?php echo e("Votes") ?></p>                              
                </div>
                <?php if($this->isPro() && !$this->admin()): ?>              
                <h3><?php echo e("Next Payment Due") ?></h3>
                <div class="stats">
                  <span><?php echo date("F d, Y",strtotime($this->user->expires)) ?></span>
                </div>
                <?php endif; ?>
              </div>
            </div> 
            <div class="col-md-10 content">  
              <?php echo $this->ads(728) ?>
              <?php if($this->toExpires()): ?>
              <div class="calltoaction warning">
                <div class="row">
                  <div class="col-sm-10">
                    <span><?php echo e("Warning") ?></span> <?php echo e("Your membership is about to expire, please renew it as soon as possible or your account will be downgraded to free.") ?>
                  </div>
                  <div class="col-sm-2">
                    <a href="<?php echo Main::href("user/upgrade") ?>" class="btn btn-transparent pull-right"><?php echo e("Renew") ?></a>
                  </div>
                </div>
              </div>
              <?php endif; ?>                      
              <?php echo Main::message() ?>                          
    <?php endif; ?>
  <?php endif; ?>