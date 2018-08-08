<?php defined("APP") or die() ?>
 				<div class="panel panel-default panel-dark">
				  <div class="panel-heading">
				  	<?php echo e("Vote Charts") ?>
				  	<?php if($this->isPro() && $this->config["export"]): ?>
				  		<a href="<?php echo Main::href("user/export/{$poll->id}") ?>" class="btn btn-primary btn-xs pull-right"><?php echo e("Export") ?></a>
				  	<?php endif; ?>
				  </div>      
				  <div class="panel-body">
				     <div id="vote-chart" class='chart'></div>  
				  </div>  
				</div>	 				
 				<div class="panel panel-default panel-dark">
				  <div class="panel-heading"><?php echo e("Country Analysis") ?> (<?php echo e("Click country for more info") ?>)</div>  
				  <div class="panel-body">
				    <div class="col-md-6">
				      <div id="country-map" class='chart'></div>
				    </div>
				    <div class="col-md-6">
				      <div id="country_list">
				      	<h4><?php echo e("Top Countries") ?></h4>
					      <ol>
					      <?php foreach ($topcountries as $country => $count):?>
					        <li><a href="<?php echo Main::href("user/server") ?>" class="get_stats" data-id="<?php echo $this->id ?>" data-request="country" data-value="<?php echo Main::ccode($country,true) ?>" data-target="country_list"><?php echo $country ?></a> <span class="label label-primary pull-right"><?php echo $count ?></span></li>
					      <?php endforeach ?>
					      </ol>
				      </div>
				    </div>     
				  </div>  
				</div>	
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default panel-dark">
						  <div class="panel-heading"><?php echo e("IP Analysis") ?></div>      
						  <div class="panel-body">
					      <ol>
					      <?php foreach ($ips as $ip):?>
					        <li><?php echo $ip->ip ?> <span class="label label-primary pull-right"><?php echo $ip->count ?></span></li>
					      <?php endforeach ?>
					      </ol>				     
						  </div>  
						</div>				
					</div>
					<div class="col-md-6">
						<div class="panel panel-default panel-dark">
						  <div class="panel-heading"><?php echo e("Referral Analysis") ?></div>      
						  <div class="panel-body">
								<div id="source">
							    <ol>
						      <?php foreach ($refs as $ref):?>
						        <?php if (empty($ref->domain)): ?>
											<li><?php echo e("Direct, email and others") ?> <span class="label label-primary pull-right"><?php echo $ref->count ?></span></li>			        	
										<?php else: ?>
											<li><a href="<?php echo Main::href("user/server") ?>" class="get_stats" data-id="<?php echo $this->id ?>" data-request="source" data-value="<?php echo $ref->domain ?>" data-target="source"><?php echo $ref->domain ?></a> <span class="label label-primary pull-right"><?php echo $ref->count ?></span></li>								
						        <?php endif ?>
						      <?php endforeach ?>
						      </ol>									
								</div>
						  </div>  
						</div>				
					</div>
				</div>					
      </div>
    </div>
  </div>
</section>