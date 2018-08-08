<?php defined("APP") or die() ?>
<section>
	<div class="container">    
		<div class="centered form">      
      <?php echo Main::message() ?>
      <form role="form" class="live_form" method="post" action="<?php echo Main::href("contact")?>">
      	<p><?php echo e("If you have any questions, feel free to contact us on this page."); ?></p>
      	<hr>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="<?php echo e("Full Name")?>" name="name" value="">	            
        </div>
        <div class="form-group">
          <input type="email" class="form-control" placeholder="<?php echo e("Email address")?>" name="email" value="" required>		            
        </div>  
        <div class="form-group">
          <textarea name="message" class="form-control" placeholder="<?php echo e("Message") ?>" rows="10" required></textarea>	            
        </div>          
				<div id="captcha" class="display">
					<?php echo Main::captcha() ?>				
				</div>	        
        <?php echo Main::csrf_token(TRUE) ?>
        <button type="submit" class="btn btn-primary"><?php echo e("Send") ?></button>        
      </form>        
		</div>
	<footer>
        <p>&copy; <?php echo date("Y")?> <a href="<?php echo $this->config["url"] ?>"><?php echo $this->config["title"] ?></a></p>
    </footer>
	</div>
</section>
  <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/application.js?v=1.0"></script>   
	</body>
</html>