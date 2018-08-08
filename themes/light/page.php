<?php defined("APP") or die() ?>
<section>
  <div class="calltoaction">
    <div class="container">
      <span><?php echo e("Home") ?> / <?php echo $page->title ?></span>
    </div>
  </div>
  <div class="container">
    <div class="row page">
      <div class="col-md-8">
        <div class="post">
          <h3><?php echo $page->title ?></h3>
          <article>
            <?php echo $page->content ?>
          </article>
        </div>
      </div>
      <div class="col-md-4 side">
        <?php $this->ads(300) ?>
      </div>
    </div>    
  </div>
</section>