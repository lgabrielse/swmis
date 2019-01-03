<?php require_once('../../Connections/swmisconn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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

mysql_select_db($database_swmisconn, $swmisconn);
$query_MRNS = "SELECT medrecnum FROM patperm where active = 'Y' Order By medrecnum";
$MRNS = mysql_query($query_MRNS, $swmisconn) or die(mysql_error());
$row_MRNS = mysql_fetch_assoc($MRNS);
$totalRows_MRNS = mysql_num_rows($MRNS);
 //require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p><a href="CashierReptMenu.php">Back to Menu</a></p>
<p>&nbsp;</p>
<p>Deposit Balances in System:</p>
<table border="1">
  <tr>
    <td>medrecnum</td>
    <td>Balance</td>
  </tr>
<?php do {
	$AcctBal = 0; 
	$colname_patperm = $row_MRNS['medrecnum'];

	mysql_select_db($database_swmisconn, $swmisconn);
?>

<?php 
$query_AcctDeposits = "SELECT SUM(IFNULL(ro.amtpaid,0)) sumamtpaid FROM rcptord ro join receipts r on r.id = ro.rcptid WHERE ro.status = 'Deposited' and r.medrecnum = '".$colname_patperm."' GROUP BY r.medrecnum";
$AcctDeposits = mysql_query($query_AcctDeposits, $swmisconn) or die(mysql_error());
$row_AcctDeposits = mysql_fetch_assoc($AcctDeposits);
$totalRows_AcctDeposits = mysql_num_rows($AcctDeposits);

$query_AcctPdByDep = "SELECT SUM(IFNULL(ro.amtpaid,0)) sumamtpaid FROM rcptord ro join receipts r on r.id = ro.rcptid WHERE ro.status = 'Paid' and r.nbc = 'Deposit' and r.medrecnum = '".$colname_patperm."' GROUP BY r.medrecnum";
$AcctPdByDep = mysql_query($query_AcctPdByDep, $swmisconn) or die(mysql_error());
$row_AcctPdByDep = mysql_fetch_assoc($AcctPdByDep);
$totalRows_AcctPdByDep = mysql_num_rows($AcctPdByDep);

$query_AcctRefToDep = "SELECT SUM(IFNULL(ro.amtpaid,0)) sumamtpaid FROM rcptord ro join receipts r on r.id = ro.rcptid WHERE ro.status = 'Refunded' and r.nbc = 'Deposit' and r.medrecnum = '".$colname_patperm."' GROUP BY r.medrecnum";
$AcctRefToDep = mysql_query($query_AcctRefToDep, $swmisconn) or die(mysql_error());
$row_AcctRefToDep = mysql_fetch_assoc($AcctRefToDep);
$totalRows_AcctRefToDep = mysql_num_rows($AcctRefToDep);

$query_AcctDepRefund = "SELECT SUM(IFNULL(ro.amtpaid,0)) sumamtpaid FROM rcptord ro join receipts r on r.id = ro.rcptid WHERE ro.status = 'DepRefund' and r.medrecnum = '".$colname_patperm."' GROUP BY r.medrecnum";
$AcctDepRefund = mysql_query($query_AcctDepRefund, $swmisconn) or die(mysql_error());
$row_AcctDepRefund = mysql_fetch_assoc($AcctDepRefund);
$totalRows_AcctDepRefund = mysql_num_rows($AcctDepRefund);


$AcctBal = $row_AcctDeposits['sumamtpaid'] + $row_AcctDepRefund['sumamtpaid'] + (0 - $row_AcctRefToDep['sumamtpaid']) - $row_AcctPdByDep['sumamtpaid'];


?>
<?php 
if($AcctBal <> 0){
?>
    <tr>
      <td><?php echo $row_MRNS['medrecnum']; ?></td>
      <td><?php echo $AcctBal; ?></td>
    </tr>
<?php }?>
    <?php } while ($row_MRNS = mysql_fetch_assoc($MRNS)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($MRNS);
mysql_free_result($AcctDeposits);
mysql_free_result($AcctPdByDep);
mysql_free_result($AcctRefToDep);


?>
