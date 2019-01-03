<?php session_start(); // 'Start new or resume existing session'  $_SESSION['sysconn'] seems to unavailable default?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

<?php
//$editFormAction = $_SERVER['PHP_SELF'];
//if (isset($_SERVER['QUERY_STRING'])) {
//  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
//}
//
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formplv1")) {
	if (isset($_POST['laborder'])) {
//	    echo var_dump($_POST['laborder']);  // to see $_POST['laborder'] content
//		exit;
	   $order = $_POST['laborder'];
       $N = count($order);
//    echo("You selected $N order(s): ");
		for($i=0; $i < $N; $i++) {
		
	mysql_select_db($database_swmisconn, $swmisconn);
	$query_Fee = sprintf("SELECT fee from fee where id = '".$order[$i]."'");
	$Fee = mysql_query($query_Fee, $swmisconn) or die(mysql_error());
	$row_Fee = mysql_fetch_assoc($Fee);
	$totalRows_Fee = mysql_num_rows($Fee);
	
	$amtdue = $row_Fee['fee']*($_POST['rate']/100); 	
		
  $insertSQL = sprintf("INSERT INTO orders (medrecnum, visitid, feeid, rate, ratereason, amtdue, amtpaid, billstatus, status, urgency, doctor, comments, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "text"),
                       GetSQLValueString($_POST['visitid'], "int"),
                       $order[$i],
                       GetSQLValueString($_POST['rate'], "int"),
                       GetSQLValueString($_POST['ratereason'], "text"),
                       GetSQLValueString($amtdue, "int"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString('Due', "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['urgency'], "text"),
                       GetSQLValueString($_POST['doctor'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));


  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());
//echo 'arrived';
//exit;


		//  echo($order[$i] . " ");
		  
		}
	} // if laborder

	if (isset($_POST['anteorder'])) {
	//array(2) { [0]=> string(2) "49" [1]=> string(2) "28" }
	//array(4) { [0]=> string(2) "49" [1]=> string(2) "28" [2]=> string(2) "24" [3]=> string(2) "51" }
	   $ante = array(
		   "0" => "24",
		   "1" => "36",   
		   "2" => "37",   
		   "3" => "32",   
		   "4" => "33",   
		   "5" => "15",   
		   "6" => "73",   
	   );
    	$N = count($ante);
//    echo("You selected $N order(s): ");
		for($j=0; $j < $N; $j++) {  //loop to add orders
	
	  $insertSQL = sprintf("INSERT INTO orders (medrecnum, visitid, feeid, rate, ratereason, amtdue, billstatus, status, urgency, doctor, comments, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "text"),
                       GetSQLValueString($_POST['visitid'], "int"),
                       $ante[$j],
                       GetSQLValueString(0, "int"),
                       GetSQLValueString($_POST['ratereason'], "text"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString('Rate0', "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['urgency'], "text"),
                       GetSQLValueString($_POST['doctor'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());

		 // echo($N.' - '.$ante[$j] . " ");
    } //  FOR loop

	  $insertSQL = sprintf("INSERT INTO orders (medrecnum, visitid, feeid, item, ofee, rate, ratereason, amtdue, billstatus, status, urgency, doctor, comments, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "text"),
                       GetSQLValueString($_POST['visitid'], "int"),
                       '31', // feeid manually entered for Antenatal Routine Drugs                                            
                       GetSQLValueString('Rx-Ante-Routine', "text"),
                       GetSQLValueString(350*($_POST['rate']/100), "int"),  //fee manually entered
                       GetSQLValueString($_POST['rate'], "int"),
                       GetSQLValueString($_POST['ratereason'], "text"),
                       GetSQLValueString(350*($_POST['rate']/100), "int"),
                       GetSQLValueString('RxCosted', "text"),
                       GetSQLValueString('RxCosted', "text"),
                       GetSQLValueString($_POST['urgency'], "text"),
                       GetSQLValueString($_POST['doctor'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());

	
//exit;
  } // if anteorder
} // if form

  $insertGoTo = "PatShow1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_POST['qrystr'];
  }
  header(sprintf("Location: %s", $insertGoTo));

// PatShow1.php?mrn=3&vid=10&visit=PatVisitView.php&act=lab&pge=PatLabView.php

?>

