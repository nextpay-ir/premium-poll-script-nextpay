<?php defined("APP") or die() ?>
  <?php if ($this->footerShow): ?>
        <footer class="official">
            <div class="container">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="right">
                    <a href="<?php echo Main::href("") ?>"><img class="footer-logo" src="<?php echo $this->config["url"] ?>/static/<?php echo $this->config["logo"] ?>" alt="<?php echo $this->config["title"] ?>" /></a>
                    <p class="copyright">تمامی حقوق برای <a href="<?php echo Main::href("") ?>" title="<?php echo $this->config["title"] ?>"><?php echo $this->config["title"] ?></a> محفوظ می‌باشد.</p>
                    </div>
                    <ul class="footer-social">
                        <li><a href="#">توییتر</a></li>
                        <li><a href="#">اینستاگرام</a></li>
                        <li><a href="#">فیسبوک</a></li>
                    </ul>
                    <ul class="footer-security">
                        <li><a href="<?php echo $this->config["url"]?>/help"><?php echo e("Help")?></a></li>
                        <li><a href="<?php echo $this->config["url"]?>/terms"><?php echo e("Terms and Conditions")?></a></li>
                        <li><a href="<?php echo $this->config["url"]?>/contact"><?php echo e("Contact Us")?></a></li>
                    </ul>
                    <ul class="footer-about">
                        <li><a href="#">درباره ما</a></li>
                        <li><a href="#">بلاگ</a></li>
                        <li><a href="<?php echo $this->config["url"]?>/features"><?php echo e("Features")?></a></li>
                    </ul>
                </div>
            </div>
        </footer>
  <?php else:  /* Close Container + User Panel Footer */?>
  <?php endif ?>  
  <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/application.js?v=1.0"></script>   
	<?php Main::enqueue('footer') ?>
	</body>
</html>