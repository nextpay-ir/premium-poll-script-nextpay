<?php defined("APP") or die() ?>
<section>
  <div class="container">
     <?php echo Main::message() ?>
     <div class="row flat">            
        <div class="col-md-4">
            <ul class="plan plan1">
                <li class="plan-name"><?php echo e("Starter") ?></li><li class="plan-price"><strong><?php echo e("Free") ?></strong> Forever</li>
                <li><?php echo e("Limited Features") ?></li>
                <li><?php echo e("Branded Polls") ?> </li>    
                <li><?php echo e("Advertisements") ?></li>          
                <li><?php echo e("Limited Support") ?></li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="plan featured">
                <li class="plan-name"><?php echo e("Business")?></li>
                <li class="plan-price"><strong><?php echo Main::currency($this->config["currency"],$this->config["pro_monthly"]) ?></strong> / <?php echo e("month") ?></li>
                <li><strong><?php echo e("Unlimited") ?></strong> <?php echo e("Polls") ?></li>
                <li><?php echo e("Advanced Statistics") ?></li>
                <li><?php echo e("All Features") ?></li>
                <li><?php echo e("Google Analytics") ?></li>  
                <li><?php echo e("Brand-Free Polls") ?></li>
                <li><?php echo e("No Advertisements") ?></li>
                <li><?php echo e("Export Data") ?></li>
                <li><?php echo e("Prioritized Support") ?></li>
                <li class="plan-action"><a href="<?php echo Main::href("upgrade/monthly") ?>" class="btn btn-dark btn-lg btn-block"><?php echo e("Upgrade") ?></a></li>
            </ul>
        </div>
        <?php 
          $discount=round((($this->config["pro_monthly"]*12)-$this->config["pro_yearly"])*100/$this->config["pro_yearly"],0);
          $discount=($discount < 0)?"":(" (".e("Save")." $discount%)");
         ?>
        <div class="col-md-4">
            <ul class="plan featured">
                <li class="plan-name"><?php echo e("Business")?></li>
                <li class="plan-price"><strong><?php echo Main::currency($this->config["currency"],$this->config["pro_yearly"]) ?></strong> / <?php echo e("year") ?></li>
                <li><strong><?php echo e("Unlimited") ?></strong> <?php echo e("Polls") ?></li>
                <li><?php echo e("Advanced Statistics") ?></li>
                <li><?php echo e("All Features") ?></li>
                <li><?php echo e("Google Analytics") ?></li>  
                <li><?php echo e("Brand-Free Polls") ?></li>
                <li><?php echo e("No Advertisements") ?></li>
                <li><?php echo e("Export Data") ?></li>
                <li><?php echo e("Prioritized Support") ?></li>
                <li class="plan-action"><a href="<?php echo Main::href("upgrade/yearly") ?>" class="btn btn-dark btn-lg btn-block"><?php echo e("Upgrade") ?> <?php echo $discount ?></a></li>
            </ul>
        </div>        
    </div>         
  </div>
</section>