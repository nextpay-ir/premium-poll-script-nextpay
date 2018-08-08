<?php defined("APP") or die() ?>
  <?php if ($this->footerShow): ?>
  <section>
    <div class="container">
      <footer class="row">
        <div class="pull-right footer"> 
          <?php foreach ($pages as $page): ?>
              <a href="<?php echo Main::href("page/{$page->slug}") ?>"><?php echo $page->title ?></a>
          <?php endforeach ?>
        <div class="languages">
          <a href="#lang" class="active" id="show-language"><i class="glyphicon glyphicon-globe"></i> <?php echo e("Language") ?></a>
          <div class="langs">
            <?php echo $this->lang(0) ?>
          </div>          
        </div>    
        </div>
        <p>&copy; <?php echo date("Y")?> <a href="<?php echo $this->config["url"] ?>"><?php echo $this->config["title"] ?></a></p>
      </footer>
    </div><!-- /.container -->     
  </section> 
  <?php else:  /* Close Container + User Panel Footer */?>
        </div><!--/.col -->        
      </div><!--/.row -->
    </div><!--/.container -->
  </section>
  <?php endif ?>  
  <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/application.js?v=1.0"></script>   
	<?php Main::enqueue('footer') ?>
	</body>
</html>