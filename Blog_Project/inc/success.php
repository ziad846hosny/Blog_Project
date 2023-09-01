<?php

require_once 'connection.php';

if(isset($_SESSION['successes'])){?>

    <div class = "alert alert-success"><?php echo $_SESSION['successes'] ?></div>
   <?php 
   
   unset($_SESSION['successes']);

}