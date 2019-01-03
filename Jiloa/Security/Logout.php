<?php ob_start(); ?>
<?php session_start(); 
	  session_unset();     // unset $_SESSION variable for the run-time 
      session_destroy();   // destroy session data in storage
	  setcookie("mySession",$mysessioncookie,time()-100,"/");
	  $insertGoTo = '../Security/Login.php';
      header(sprintf("Location: %s", $insertGoTo));
?>
<?php
ob_end_flush();
?>
