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

      <?php echo Main::message() ?>
      <form role="form" class="live_form form" id="login_form" method="post" action="<?php echo Main::href("index.php?a=user/login","user/login")?>">
        <div class="form-group">
          <input type="email" class="form-control email-text" id="email" placeholder="<?php echo e("Email address")?>" name="email">
        </div>
        <div class="form-group">
          <input type="password" class="form-control password-text" id="pass" placeholder="<?php echo e("Password")?>" name="password">
        </div>         
        <div class="form-group">
          <label>
              <input type="checkbox" name="rememberme" value="1" data-class="blue">  
              <span class="check-box"><?php echo e("Remember me")?></span>
          </label>
        </div>                  
        <?php echo Main::csrf_token(TRUE) ?>
        <button type="submit" class="btn btn-primary"><?php echo e("Login")?></button>
		<br /><br />
		<a href="#forgot" id="forgot-password" style="font-size:16px;"><?php echo e("Forgot Password")?></a>
		<br />
		<?php if($this->config["users"]): ?>
              <a href="<?php echo Main::href("index.php?a=user/register","user/register")?>" style="font-size:16px;"><?php echo e("Create account")?></a>
        <?php endif ?>
      </form>  

      <form role="form" class="live_form" id="forgot_form" method="post" action="<?php echo Main::href("index.php?a=user/forgot","user/forgot")?>">
	    <p style="font-size: 18px;"><?php echo e("Please Enter Email Address")?></p>
		<br />
        <div class="form-group">
          <input type="email" class="form-control email-text" id="email1" placeholder="<?php echo e("Email address")?>" name="email">
        </div>        
        <?php echo Main::csrf_token(TRUE) ?>
        <button type="submit" class="btn btn-primary"><?php echo e("Reset Password")?></button>
        <a href="<?php echo Main::href("user/login") ?>" class="pull-right" style="font-size:16px;"><?php echo e("Back to login")?></a>
      </form>        
		</div>
	</div>
</section>
<script>
(function($){

  $(function(){
    $('.live_form .email-text').focusin(function(){
        $('.live_form .email-text').css('text-align','left');
    });

    $('.live_form .email-text').focusout(function(){
       if($('.live_form .email-text').val()===''){
            $('.live_form .email-text').css('text-align','right');
       }
    });

    $('.live_form .password-text').focusin(function(){
        $('.live_form .password-text').css('text-align','left');
    });

    $('.live_form .password-text').focusout(function(){
       if($('.live_form .password-text').val()===''){
            $('.live_form .password-text').css('text-align','right');
       }
    });

  });
})(jQuery);
</script>