<?php defined("APP") or die() ?>
<section>
	<div class="container">
		<div class="centered form">
      <div class="site_logo">
        <?php if (!empty($this->config["logo"])): ?>
          <a href="<?php echo $this->config["url"] ?>"><img src="<?php echo $this->config["url"] ?>/static/<?php echo $this->config["logo"] ?>" alt="<?php echo $this->config["title"] ?>"></a>
        <?php else: ?>
          <h3><a href="<?php echo $this->config["url"] ?>"><?php echo $this->config["title"] ?></a></h3>
        <?php endif ?>
      </div>      
      <form role="form" class="live_form" id="login_form" method="post" action="<?php echo Main::href("index.php?a=user/register","user/register")?>">
        <?php echo Main::message() ?>
        <div class="form-group">
          <label for="name"><?php echo e("Full Name")?></label>
          <input type="text" class="form-control" id="name" placeholder="<?php echo e("Enter name")?>" name="name">
        </div>        
        <div class="form-group">
          <label for="email"><?php echo e("Email address")?></label>
          <input type="email" class="form-control" id="email" placeholder="<?php echo e("Enter email")?>" name="email">
        </div>
        <div class="form-group">
          <label for="pass"><?php echo e("Password")?></label>
          <input type="password" class="form-control" id="pass" placeholder="<?php echo e("Enter Password")?>" name="password">
        </div>     
        <div class="form-group">
          <label for="pass2"><?php echo e("Confirm Password")?></label>
          <input type="password" class="form-control" id="pass2" placeholder="<?php echo e("Enter Password")?>" name="cpassword">
        </div>  
        <?php echo Main::captcha() ?>            
        <div class="form-group">
          <label>
              <input type="checkbox" name="terms" value="1" data-class="blue">  
              <span class="check-box"><?php echo e("I agree to the")?> <a href="<?php echo $this->config["url"] ?>/page/terms" target="_blank"><?php echo e("terms and conditions")?></a>.</span>
          </label>
        </div>          
        <?php echo Main::csrf_token(TRUE) ?>
        <button type="submit" class="btn btn-primary"><?php echo e("Create Account") ?></button>
      </form>        
		</div>
	</div>
</section>