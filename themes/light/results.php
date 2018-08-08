<?php defined("APP") or die() ?>
      <a href="#embed" id="poll_embed"><?php echo e("Embed")?></a>
      <div id="poll_embed_holder" class="live_form">
        <div class="input-group">
          <span class="input-group-addon"><?php echo e("Share")?></span>
          <input type="text" class="form-control" value="<?php echo Main::href($poll->uniqueid)?>">
        </div>              
        <div class="input-group">
          <span class="input-group-addon"><?php echo e("Embed")?></span>
          <input type="text" class="form-control form-embed-code"value="&lt;iframe src=&quot;<?php echo Main::href("embed/{$poll->uniqueid}")?>&quot; width=&quot;400&quot; height=&quot;500&quot; frameborder=&quot;0&quot;&gt;">
        </div>
        <div class="input-group">
          <a href="https://www.facebook.com/sharer.php?u=<?php echo Main::href($poll->uniqueid)?>" class="btn btn-transparent"><?php echo e("Share")?> on Twitter</a>
          <a href="https://twitter.com/share?url=<?php echo Main::href($poll->uniqueid)?>&amp;text=<?php echo urlencode($poll->question) ?>" class="btn btn-transparent"><?php echo e("Share on")?> Facebook</a>                                
        </div>            
      </div><!-- /#poll_embed_holder -->
     <div class='poll_results' data-action='".Main::href("results")."'  data-id='{$poll->uniqueid}'> 
      <div id='poll_question'>
        <h3><?php echo $poll->question?></h3>
      </div>
      <ul class='results'>
    <?php foreach ($options as $key => $value):?>
      <?php $percent=round($value->count*100/$poll->votes,0); ?>
        <li>
          <div class="holder">
            <?php echo $v->answer?>  
          </div>
          <div class="row">
            <div class="col-md-9">
              <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent?>">
                  <?php echo $percent?>%
                </div>
              </div>                      
            </div>
            <div class="col-md-3"><?php echo $v->count?> <?php echo e("Votes")?></div>
          </div>
        </li>
    <?php endforeach ?>