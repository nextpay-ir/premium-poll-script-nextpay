<?php defined("APP") or die() ?>
<?php // Show Password ?>
<?php if($protected):  ?>
  <div id="poll_widget" class="<?php echo $poll->theme ?> ">        
    <div id="poll_question">
      <h3><?php echo e("Please enter the password") ?></h3>
    </div>          
    <form action="<?php echo Main::href($this->action) ?>" method="post" class="live_form passform">            
        <p><?php echo e("This poll is password protected. Please enter the password to continue.") ?></p>                            
        <div class="input-group">                
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
          <input type="text" class="form-control" name="password">
        </div>              
        <?php echo Main::csrf_token(TRUE) ?>
        <button type="submit" class="btn btn-dark"><?php echo e("Submit") ?></button>
    </form>        
  </div><!--#poll_widget-->
<?php endif; ?>

<?php // Expired ?>
<?php if($expired): ?>
  <div id="poll_widget" class="<?php echo $poll->theme ?> ">        
    <div id="poll_question">
      <h3><?php echo e("This poll has either expired or has been closed.") ?></h3>
    </div>                 
  </div><!--#poll_widget-->      
<?php endif ?>

<?php // Show Poll ?>
<?php if(!$protected && !$expired): ?>
  <div id="poll_widget" class="<?php echo $poll->theme ?> ">
    <?php if(!$poll->visited): ?>          
      <form action="<?php echo Main::href("vote") ?>" method="post" id="poll_form" class="poll_form_widget">
        <?php if($poll->share || $poll->userid==$this->user->id): ?>
          <a href="#embed" id="poll_embed"><?php echo e("Embed")?></a>
          <div id="poll_embed_holder" class="live_form">
            <div class="input-group">
              <span class="input-group-addon"><?php echo e("Share")?></span>
              <input type="text" class="form-control" value="<?php echo Main::href($poll->uniqueid) ?>">
            </div>              
            <div class="input-group">
              <span class="input-group-addon"><?php echo e("Embed")?></span>
              <input type="text" class="form-control" value="&lt;iframe src=&quot;<?php echo Main::href("embed/{$poll->uniqueid}")?>&quot; width=&quot;400&quot; height=&quot;;<?php echo $height ?>&quot; frameborder=&quot;0&quot;&gt;">
            </div>
            <div class="input-group">
              <a href="https://www.facebook.com/sharer.php?u=<?php echo Main::href($poll->uniqueid) ?>" class="btn btn-transparent" target="_blank"><?php echo e("Share on")?> Facebook</a>
              <a href="https://twitter.com/share?url=<?php echo Main::href($poll->uniqueid) ?>&amp;text=<?php echo urlencode($poll->question) ?>" class="btn btn-transparent" target="_blank"><?php echo e("Share on")?> Twitter</a>                                
            </div>            
          </div><!-- /#poll_embed_holder -->             
        <?php endif  ?>
        <div id="poll_question">
          <h3><?php echo $poll->question ?></h3>
        </div>
        <ul id="poll_answers">
          <?php $i=1; ?>
          <?php foreach ($poll->answers as $key => $value): ?>
            <li id="poll-<?php echo $key ?>"> 
              <label>
                <?php if($poll->choice): ?>                    
                  <input type="checkbox" name="answer[<?php echo $key ?>]" value="<?php echo $key ?>"<?php echo ($i==1)?" checked":""; ?>> 
                <?php else: ?>
                  <input type="radio" name="answer" value="<?php echo $key ?>"<?php echo ($i==1)?" checked":""; ?>> 
                <?php endif ?>
                <span><?php echo ucfirst($value->answer) ?></span>
              </label>
            </li>
            <?php $i++; ?>
          <?php endforeach ?>
        </ul>
        <div id="poll_button">
          <?php echo Main::csrf_token(TRUE) ?>
          <input type="hidden" name="embed" id="embed" value="1">
          <input type="hidden" name="poll_id" id="poll_id" value="<?php echo $poll->uniqueid ?>">
          <input type="submit" class="btn btn-widget" value="<?php echo e("Vote")?>">
          <?php if ($poll->results): ?>
            <button type="button" onclick="javascript:update_results('<?php echo Main::href("results") ?>','<?php echo $poll->uniqueid ?>')" class="btn btn-widget" id="view-results"><?php echo e("View Results") ?></button>
          <?php endif ?>
          <?php if($user->membership!="pro"): ?>
            <span class="branding pull-right">
              <?php echo e("Powered by") ?> <a href="<?php echo $this->config["url"] ?>" target="_blank"><?php echo $this->config["title"] ?></a>
            </span>
          <?php endif ?>
        </div>
      </form>                    
    <?php else: ?>        
      <?php if(!$poll->results): ?>
        <div id="poll_question">
          <h3><?php echo e("Thank you for voting!")?></h3>
        </div>
      <?php else: ?>
        <?php $this->results($poll->id,"",TRUE); ?>
      <?php endif ?>
    <?php endif ?>
  </div><!--#poll_widget-->            
<?php endif  ?>   