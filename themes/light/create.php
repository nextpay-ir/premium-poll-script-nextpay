<?php defined("APP") or die() ?>
<section>
  <div class="container create">
    <div class="row">
      <div class="col-md-5">
        <div class="box-holder">
          <?php echo Main::message() ?>
          <form role="form" class="live_form" id="create-poll" method="post" action="<?php echo Main::href("create") ?>">
            <div id="container_questions" class="tabbed">
              <div class="form-group">
                <label for="questions"><?php echo e("Your Question")?></label>
                <span class="help-block"><?php echo e("No HTML allowed. Invalid question will be ignored.")?></span>
                <input type="text" class="form-control" id="questions" name="question">
              </div>
              <div class="form-group" id="widget_answers">
                <label><?php echo e("Answers")?></label>
                <span class="help-block"><?php echo e("Leave fields empty to ignore options. No HTML allowed. Invalid answers will be ignored.")?></span>
                <ul id="sortable">
                  <li id="poll_sort_1">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-move"></i></span>
                      <input type="text" class="form-control" name="option[]">
                    </div>                  
                  </li>
                  <li id="poll_sort_2">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-move"></i></span>
                      <input type="text" class="form-control" name="option[]">
                    </div>                  
                  </li>
                  <li id="poll_sort_3">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-move"></i></span>
                      <input type="text" class="form-control" name="option[]">
                    </div>                  
                  </li>                                
                </ul>
              </div>            
              <button type="button" data-id="customize" class="btn btn-primary tabs pull-right"><?php echo e("Customize")?> &larr;</button>
              <a href="#" id="add-field" class="btn btn-transparent"><small><?php echo e("Add Field")?></small></a>                
            </div>     
            <div id="customize" class="tabbed">       
              <ul class="form_opt" data-id="share" data-callback="update_share">
                <li class="label"><?php echo e("Sharing")?>
                <small><?php echo e("Allows users to share and embed poll.")?></small>
                </li>
                <li><a href="#" class="last" data-value="0"><?php echo e("No")?></a></li>
                <li><a href="#" class="first current" data-value="1"><?php echo e("Yes")?></a></li>
              </ul>
              <input type="hidden" name="share" id="share" value="1">

              <ul class="form_opt" data-id="results" data-callback="update_results_button">
                <li class="label"><?php echo e("Show Results")?>
                <small><?php echo e("Allows users to view results.")?></small>
                </li>
                <li><a href="#" class="last" data-value="0"><?php echo e("No")?></a></li>
                <li><a href="#" class="first current" data-value="1"><?php echo e("Yes")?></a></li>
              </ul>
              <input type="hidden" name="results" id="results" value="1"> 

              <ul class="form_opt" data-id="choice" data-callback="update_choice_type">
                <li class="label"><?php echo e("Multiple Choices")?>
                <small><?php echo e("Allows users to choose more than one option.")?></small>
                </li>
                <li><a href="#" class="last current" data-value="0"><?php echo e("No")?></a></li>
                <li><a href="#" class="first" data-value="1"><?php echo e("Yes")?></a></li>
              </ul>
              <input type="hidden" name="choice" id="choice" value="0">

              <?php if($this->isPro()): ?>
              <ul class="form_opt" data-id="vote">
                <li class="label"><?php echo e("Multiple Votes")?>
                <small><?php echo e("Allows users to vote more than once")?></small>
                </li>
                <li><a href="#" class="last current" data-value="off"><?php echo e("Off")?></a></li>
                <li><a href="#" data-value="day"><?php echo e("Daily")?></a></li>
                <li><a href="#" class="first" data-value="month"><?php echo e("Monthly")?></a></li>
              </ul>
              <input type="hidden" name="vote" id="vote" value="off">
              <?php else: ?>
              <ul class="form_opt" data-id="choice" data-callback="update_choice_type">
                <li class="label"><?php echo e("Multiple Votes")?>
                <small><?php echo e("Allows users to vote more than once")?></small>
                </li>
                <li><a href="<?php echo Main::href("upgrade") ?>" class='pull-right round'><?php echo e("Upgrade") ?></a></li>
              </ul>              
              <?php endif ?>                           
              <?php if($this->isPro()): ?>
                <div class="form-group">
                  <label for="pass"><?php echo e("Password")?></label>
                  <input type="text" class="form-control" id="pass" name="pass">
                </div>
              <?php else: ?>
                <div class="form-group">
                  <label for="pass"><?php echo e("Password")?> <a href="<?php echo Main::href("upgrade") ?>" class='pull-right'><small>(<?php echo e("Upgrade") ?>)</small></a></label>
                  <input type="text" class="form-control" id="pass" placeholder="<?php echo e("Please upgrade to a premium package to unlock this feature.") ?>" disabled>
                </div>              
              <?php endif ?>
              <div class="form-group">
                <label for="expires"><?php echo e("Expires in")?></label>
                <select id="expires" name="expires">
                  <option value="0"><?php echo e("Never")?></option>
                  <option value="1h">1 <?php echo e("hour")?></option>
                  <option value="5h">5 <?php echo e("hours")?></option>
                  <option value="1d">1 <?php echo e("day")?></option>
                  <option value="5d">5 <?php echo e("days")?></option>
                  <option value="1w">1 <?php echo e("week")?></option>
                  <option value="5w">5 <?php echo e("weeks")?></option>
                </select>
              </div>
              <button type="button" data-id="container_questions" class="btn btn-success tabs">&rarr; <?php echo e("Questions")?></button>
              <button type="button" data-id="theme" class="btn btn-primary tabs pull-right"><?php echo e("Theme")?> &larr;</button>              
            </div>    
            <div id="theme" class="tabbed">         
              <h3><?php echo e("Simple")?></h3>
              <ul class="themes">                
                <li class="dark"><a href="#" data-class="dark">Dark</a></li>
                <li class="light"><a href="#" data-class="light">Light</a></li>
                <li class="blue"><a href="#" data-class="blue" class="current">Blue</a></li>                
                <li class="red"><a href="#" data-class="red">Red</a></li>
                <li class="green"><a href="#" data-class="green">Green</a></li>
                <li class="yellow"><a href="#" data-class="yellow">Yellow</a></li>
              </ul> 
              <h3><?php echo e("Boxed")?></h3>
              <ul class="themes">                
                <li class="dark"><a href="#" data-class="bs dark">Dark</a></li>
                <li class="light"><a href="#" data-class="bs light">Light</a></li>
                <li class="blue"><a href="#" data-class="bs blue">Blue</a></li>                
                <li class="red"><a href="#" data-class="bs red">Red</a></li>
                <li class="green"><a href="#" data-class="bs green">Green</a></li>
                <li class="yellow"><a href="#" data-class="bs yellow">Yellow</a></li>
              </ul>     
              <h3><?php echo e("Inline")?></h3>
              <ul class="themes">                
                <li class="dark"><a href="#" data-class="is dark">Dark</a></li>
                <li class="light"><a href="#" data-class="is light">Light</a></li>
                <li class="blue"><a href="#" data-class="is blue">Blue</a></li>                
                <li class="red"><a href="#" data-class="is red">Red</a></li>
                <li class="green"><a href="#" data-class="is green">Green</a></li>
                <li class="yellow"><a href="#" data-class="is yellow">Yellow</a></li>
              </ul>                  
              <input type="hidden" name="theme" value="" id="poll_theme_value">    
              <br>
              <div class="form-group">
                <label for="background"><?php echo e("Custom Image Background URL")?></label>
                <input type="text" class="form-control" name="background" value="" id="background" dir="ltr" placeholder="e.g. http://picofile.com/background.png">
              </div>                        
              <?php //echo Main::captcha() ?>                   
              <button type="button" data-id="customize" class="btn btn-success tabs">&rarr; <?php echo e("Customize")?></button>
              <?php echo Main::csrf_token(TRUE) ?>
              <button type="submit" class="btn btn-primary pull-right"><?php echo e("Create")?></button>                 
            </div> 
          </form>                    
        </div>
      </div>
      <!--Preview Widget -->
      <div class="col-md-7">
        <div id="poll_widget">
          <a href="#embed" id="poll_embed"><?php echo e("Embed")?></a>
          <div id="poll_embed_holder" class="live_form">
            <div class="input-group">
              <span class="input-group-addon"><?php echo e("Share")?></span>
              <input type="text" class="form-control" value="Your permalink will show up here">
            </div>              
            <div class="input-group">
              <span class="input-group-addon"><?php echo e("Embed")?></span>
              <input type="text" class="form-control" value="Your embed code will show up here">
            </div>
            <div class="input-group">
              <a href="#" class="btn btn-transparent"><?php echo e("Share on Twitter")?></a>
              <a href="#" class="btn btn-transparent"><?php echo e("Share on Facebook")?></a>              
            </div>            
          </div><!-- /#poll_embed_holder -->            
          <div id="poll_question">
            <h3><?php echo e("Question")?></h3>
          </div>
          <ul id="poll_answers"></ul>
          <div id="poll_button">
            <button class="btn btn-widget"><?php echo e("Vote")?></button>
            <button class="btn btn-widget" id="view_results_button"><?php echo e("View Results")?></button>
            <?php if(!$this->logged() || ($this->logged() && !$this->isPro())): ?>
              <span class="branding pull-right">
                <?php echo e("Powered by")?> <a href="<?php echo $this->config["url"] ?>"><?php echo $this->config["title"] ?></a>
              </span>
            <?php endif; ?>
          </div>
        </div><!--Poll Widget -->
        <?php echo $this->ads(468) ?>
      </div>
    </div> 
    <footer>
        <p>&copy; <?php echo date("Y")?> <a href="<?php echo $this->config["url"] ?>"><?php echo $this->config["title"] ?></a></p>
    </footer>	
  </div>
</section>
  <script type="text/javascript" src="<?php echo $this->config["url"] ?>/static/application.js?v=1.0"></script>   
	</body>
</html>