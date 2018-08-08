<?php if(!defined("APP")) die()?>
<div class="panel panel-default">
  <div class="panel-heading">
    <?php echo $header ?>
  </div>      
  <div class="panel-body">
    <form action="<?php echo Main::ahref("{$this->action}/delete") ?>" method="post">
      <table class="table table-striped">
        <thead>
          <tr>
            <?php echo $thead ?> 
          </tr>
        </thead>
        <tbody>
          <?php echo $tbody ?>            
        </tbody>
      </table>      
      <?php echo Main::csrf_token(TRUE) ?>
      <button tyoe="submit" id='deleteall' class='btn btn-danger' style='display:none;'>حذف همه</button>
    </form>
    <?php echo $pagination ?>  
  </div>
</div>