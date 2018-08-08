<?php defined("APP") or die() ?>
<script>$('#pages-header').remove();</script>
<script>
 $(document).ready(function(){
    $('.menu-bar').click(function(){
        if($('.sidebar-menu').css('left')=='-300px')
            $('.sidebar-menu').animate({'left':'0'},400);
        else
            $('.sidebar-menu').animate({'left':'-300px'},400);
    });
	
    $elem.slice(1).hide();
    setTimeout(change, timeout);

});
</script>
        <div class="main">
                <div class="sidebar-menu">
                    <ul>
                        <li><a href="<?php echo $this->config["url"]?>/features"><?php echo e("Features")?></a></li>
                        <li><a href="<?php echo $this->config["url"]?>/terms"><?php echo e("Terms and Conditions")?></a></li>
						<li><a href="<?php echo $this->config["url"]?>/help"><?php echo e("Help")?></a></li>
                        <li><a href="<?php echo $this->config["url"]?>/contact"><?php echo e("Contact Us")?></a></li>
                        <li class="no-border"><a href="<?php echo Main::href("user/login") ?>"><?php echo e("Login") ?></a></li>
                    </ul>
                </div>
                    <div class="container">
                        <div class="col-lg-12 col-md-12 col-xs-12 head">
							<img class="brand" src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/logo.png" alt="<?php echo $this->config["title"] ?>" />
                            <ul class="menu-list">
                                <li><a href="<?php echo $this->config["url"]?>/features"><?php echo e("Features")?></a></li>
                                <li><a href="<?php echo $this->config["url"]?>/help"><?php echo e("Help")?></a></li>
                                <li class="no-border"><a href="<?php echo $this->config["url"]?>/contact"><?php echo e("Contact Us")?></a></li>
                                <li><a href="<?php echo Main::href("user/login") ?>"><?php echo e("Login") ?></a></li>
                            </ul>
                            <img class="menu-bar" src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/menu.png" />
                        </div>
                        <div class="col-lg-12 col-md-12 col-xs-12 contents-center">
                                <div class="col-md-4 register-section">
                                    <form role="form" class="register-form" method="post" action="<?php echo Main::href("user/register") ?>">
                                        <h1><?php echo e("Create a Free Account") ?></h1>
                                        <input type="email" placeholder="<?php echo e("Email address") ?>" id="email" name="email" />
                                        <input type="password" placeholder="<?php echo e("Password") ?>" id="pass" name="password" />
										<?php echo Main::csrf_token(TRUE) ?>         
                                        <button type="submit"><?php echo e("Create Account") ?></button>
									</form>
                                </div>
                                <div class="col-md-offset-1"></div>
                                <div class="col-md-7 slogan-section">
                                    <h1><?php echo e("Simple. Beautiful. Modern.") ?></h1>
                                    <p><?php echo e("Create beautifully designed polls in under a minute. Choose from a library of templates or customize your own template. With many types of customization, you will make the poll <strong>your</strong> poll. Create an account to unlock even more features.") ?></p>
									<a href="<?php echo Main::href("create") ?>" class="btn btn-transparent btn-lg"><?php echo e("Create your Poll") ?></a>
                                </div>
						    <div class="mouse-countainer"><a class="mouse" href="#"><div class="cursor"></div></a></div>
                        </div>
                    </div>
		</div>
        <section class="features">
             <div class="container">
               <div class="col-lg-12 col-md-12 col-xs-12 head">
                    <div class="col-md-4 f-item">
                        <img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/rocket.png" />
                        <h2><?php echo e("Blazing-Fast Loading") ?></h2>
                        <p><?php echo e("Our polls are desgined to fit your design and all screens. Each theme will automatically adjust itself to the size of the screen of the user, regardless of the device. We've also made them to work with older browsers, giving you the peace of mind.") ?></p>
                    </div>
                    <div class="col-md-4 f-item">
                        <img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/graph.png" />
                        <h2><?php echo e("Analyze Data") ?></h2>
                        <p><?php echo e("Our polls have many unique features that you will not find anywhere else. This allows you to create the most beautiful yet simple poll. Customize everything to make it your poll and say once and for all bye to those ugly polls.") ?></p>
                    </div>
                    <div class="col-md-4 f-item">
                        <img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/settings.png" />
                        <h2><?php echo e("Manage Polls") ?></h2>
                        <p><?php echo e("We've designed our polls to be as simple as possible by giving you the options to easily customize them as you or your company requires.") ?></p>
                    </div>
               </div>
            </div>
        </section>
        <section class="pr-coverage">
            <div class="cnt">
                <h1>حامیان ما</h1>
                <hr />
                <ul>
                    <li><a href="http://www.persianscript.ir/" target="_blank"><img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/persianscript.png" alt="پرشین اسکریپت - پایگاه تخصصی اسکریپت" title="پرشین اسکریپت - پایگاه تخصصی اسکریپت" /></a></li>
                    <li><a href="http://plink.ir/" target="_blank"><img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/plink.png" alt="پی‌لینک | کوتاه‌ کننده لینک" title="پی‌لینک | کوتاه‌ کننده لینک" /></a></li>
					<li><a href="http://beporsam.ir/" target="_blank"><img src="<?php echo $this->config["url"] ?>/themes/<?php echo $this->config["theme"] ?>/img/beporsam.png" alt="بپرسم -  مکانی برای آموزش و رفع مشکلات شما" title="بپرسم -  مکانی برای آموزش و رفع مشکلات شما" /></a></li>
                </ul>
            </div>
        </section>