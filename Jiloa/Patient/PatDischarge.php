<?php if (session_status() == PHP_SESSION_NONE) {
    session_start(); }?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php //require_once('../../Connections/swmisconn.php'); ?>

<?php
if(!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
	
	  switch ($theType) {
		case "text":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;    
		case "long":
		case "int":
		  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
		  break;
		case "double":
		  $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
		  break;
		case "date":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;
		case "defined":
		  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		  break;
	  }
	  return $theValue;
	}
}

if (isset($_GET["vid"])) {
  $updateSQL = sprintf("UPDATE patvisit SET discharge=%s WHERE id=%s",
                       GetSQLValueString(Date('Y-m-d H:i:s'), "date"),
                       GetSQLValueString($_GET['vid'], "int"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($updateSQL, $swmisconn) or die(mysql_error());

  $updateGoTo = "PatShow1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= str_replace('&visit=PatDischarge.php','',$_SERVER['QUERY_STRING']); // replace function  $_SERVER['QUERY_STRING'];
  }
}


  header(sprintf("Location: %s", $updateGoTo));
?>


