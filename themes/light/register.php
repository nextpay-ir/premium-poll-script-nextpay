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
          <input type="text" class="form-control username-text" id="name" placeholder="<?php echo e("Full Name")?>" name="name">
        </div>        
        <div class="form-group">
          <input type="email" class="form-control email-text" id="email" placeholder="<?php echo e("Email address")?>" name="email">
        </div>
        <div class="form-group">
          <input type="password" class="form-control password-text" id="pass" placeholder="<?php echo e("Password")?>" name="password">
        </div>     
        <div class="form-group">
          <input type="password" class="form-control cpassword-text" id="pass2" placeholder="<?php echo e("Confirm Password")?>" name="cpassword">
        </div>  
        <?php echo Main::captcha() ?>            
        <div class="form-group">
          <label>
              <input type="checkbox" name="terms" value="1" data-class="blue">  
              <span class="check-box"><a href="<?php echo $this->config["url"] ?>/terms" target="_blank"><?php echo e("terms and conditions")?></a> <?php echo e("I agree to the")?></span>
          </label>
        </div>          
        <?php echo Main::csrf_token(TRUE) ?>
        <button type="submit" class="btn btn-primary"><?php echo e("Create Account") ?></button>
      </form>        
		</div>
	</div>
</section>
<script>
(function($){

  $(function(){
    $('.live_form .username-text').focusin(function(){
        $('.live_form .username-text').css('text-align','left');
    });

    $('.live_form .username-text').focusout(function(){
       if($('.live_form .username-text').val()===''){
            $('.live_form .username-text').css('text-align','right');
       }
    });
	
	 $('.live_form .email-text').focusin(function(){
        $('.live_form .email-text').css('text-align','left');
    });

    $('.live_form .email-text').focusout(function(){
       if($('.live_form .email-text').val()===''){
            $('.live_form .email-text').css('text-align','right');
       }
    });
	
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

	$('.live_form .password-text').focusin(function(){
        $('.live_form .password-text').css('text-align','left');
    });

    $('.live_form .password-text').focusout(function(){
       if($('.live_form .password-text').val()===''){
            $('.live_form .password-text').css('text-align','right');
       }
    });
	
    $('.live_form .cpassword-text').focusin(function(){
        $('.live_form .cpassword-text').css('text-align','left');
    });

    $('.live_form .cpassword-text').focusout(function(){
       if($('.live_form .cpassword-text').val()===''){
            $('.live_form .cpassword-text').css('text-align','right');
       }
    });
	
  });
})(jQuery);
</script>