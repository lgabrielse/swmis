<?php require_once('../../Connections/swmisconn.php'); ?>
<?php
mysql_select_db($database_swmisconn, $swmisconn);
$query_Recordset1 = "SELECT id, medrecnum, visitid, feeid, rate, ratereason, status, urgency, comments, entryby, entrydt, amtpaid, receiptnum FROM orders where receiptnum <> ''";
$Recordset1 = mysql_query($query_Recordset1, $swmisconn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>testAgeToDob.php</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div align="center"><span class="GreenBold_30">  testAgeToDob.php</span>
</div>
<table>
  <tr>
    <td>id</td>
    <td>medrecnum</td>
    <td>visitid</td>
    <td>feeid</td>
    <td>rate</td>
    <td>ratereason</td>
    <td>status</td>
    <td>urgency</td>
    <td>comments</td>
    <td>entryby</td>
    <td>entrydt</td>
    <td>amtpaid</td>
    <td>receiptnum</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['id']; ?></td>
      <td><?php echo $row_Recordset1['medrecnum']; ?></td>
      <td><?php echo $row_Recordset1['visitid']; ?></td>
      <td><?php echo $row_Recordset1['feeid']; ?></td>
      <td><?php echo $row_Recordset1['rate']; ?></td>
      <td><?php echo $row_Recordset1['ratereason']; ?></td>
      <td><?php echo $row_Recordset1['status']; ?></td>
      <td><?php echo $row_Recordset1['urgency']; ?></td>
      <td><?php echo $row_Recordset1['comments']; ?></td>
      <td><?php echo $row_Recordset1['entryby']; ?></td>
      <td><?php echo $row_Recordset1['entrydt']; ?></td>
      <td><?php echo $row_Recordset1['amtpaid']; ?></td>
      <td><?php echo $row_Recordset1['receiptnum']; ?></td>

<?php
	 			$calcdob = Date('Y-m-d', strtotime("- ".$row_Recordset1['receiptnum']." years"));

 ?>  
      <td><?php echo $calcdob ; ?></td>
  </tr>	  
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
