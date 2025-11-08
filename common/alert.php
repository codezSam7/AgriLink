<?php 
  if(isset($_SESSION["msg"])){ 
  ?>  
    <p class="alert alert-success text-center">
      <?php echo $_SESSION["msg"]; unset($_SESSION["msg"]); ?>
    </p>
  <?php 
    } 
  ?>

  <?php 
    if(isset($_SESSION["errormsg"])){ 
  ?>  
    <p class="alert alert-danger text-center">
      <?php echo $_SESSION["errormsg"]; unset($_SESSION["errormsg"]); ?>
    </p>
  <?php 
    } 
?>