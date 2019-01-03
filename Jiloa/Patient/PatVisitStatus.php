<?php require_once('../../Connections/swmisconn.php'); ?><?php if (session_status() == PHP_SESSION_NONE) {
    session_start(); }?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

<?php
$vid_Visit = "330";
if (isset($_GET["vid"])) {
  $vid_Visit = (get_magic_quotes_gpc()) ? $_GET["vid"] : addslashes($_GET["vid"]);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_Visit = sprintf("SELECT p.lastname, p.firstname, p.othername, p.gender, p.ethnicgroup, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,p.dob)),'%%y') AS age, p.entrydt, p.entryby, v.id, v.visitdate, DATEDIFF(CURRENT_DATE,v.visitdate) diagdays, v.status, v.medrecnum, v.pat_type, v.location, v.urgency, substr(v.urgency,1,2) urg, v.visitreason, v.diagnosis, v.discharge, DATE_FORMAT(v.entrydt,'%%d-%%b-%%Y   %%H:%%i') ventrydt, v.entryby ventryby, f.name, o.rate, o.amtpaid, o.status ostatus FROM patvisit v join patperm p ON p.medrecnum = v.medrecnum join orders o on o.visitid = v.id  join fee f on o.feeid = f.id WHERE f.name = 'visit' and v.id = %s", $vid_Visit);
$Visit = mysql_query($query_Visit, $swmisconn) or die(mysql_error());
$row_Visit = mysql_fetch_assoc($Visit);
$totalRows_Visit = mysql_num_rows($Visit);

mysql_select_db($database_swmisconn, $swmisconn);
$query_LAB = sprintf("SELECT DATE_FORMAT(o.entrydt,'%%d-%%b-%%Y   %%H:%%i') oentrydt, DATEDIFF(CURRENT_DATE,o.entrydt) orddays,  o.amtpaid, o.rate, o.status ostatus, f.name FROM patvisit v join orders o on o.visitid = v.id join fee f on o.feeid = f.id WHERE v.id = %s and f.dept = 'Laboratory'", $vid_Visit);
$LAB = mysql_query($query_LAB, $swmisconn) or die(mysql_error());
$row_LAB = mysql_fetch_assoc($LAB);
$totalRows_LAB = mysql_num_rows($LAB);

mysql_select_db($database_swmisconn, $swmisconn);
$query_Drugs = sprintf("SELECT DATE_FORMAT(o.entrydt,'%%d-%%b-%%Y   %%H:%%i') oentrydt, DATEDIFF(CURRENT_DATE,o.entrydt) orddays,  o.amtpaid, o.rate, o.status ostatus, o.item, o.ofee, f.name FROM patvisit v join orders o on o.visitid = v.id join fee f on o.feeid = f.id WHERE v.id = %s and f.dept = 'Pharm'", $vid_Visit);
$Drugs = mysql_query($query_Drugs, $swmisconn) or die(mysql_error());
$row_Drugs = mysql_fetch_assoc($Drugs);
$totalRows_Drugs = mysql_num_rows($Drugs);

mysql_select_db($database_swmisconn, $swmisconn);
$query_Other = sprintf("SELECT DATE_FORMAT(o.entrydt,'%%d-%%b-%%Y   %%H:%%i') oentrydt, DATEDIFF(CURRENT_DATE,o.entrydt) orddays,  o.amtpaid, o.rate, o.status ostatus, f.name FROM patvisit v join orders o on o.visitid = v.id join fee f on o.feeid = f.id WHERE v.id = %s and f.dept in ('Physiotherapy', 'Surgery','Radiology', 'Admn')", $vid_Visit);
$Other = mysql_query($query_Other, $swmisconn) or die(mysql_error());
$row_Other = mysql_fetch_assoc($Other);
$totalRows_Other = mysql_num_rows($Other);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
function out(){
	opener.location.reload(1); //This updates the data on the calling page
	  self.close();
}
</script>
</head>
<body>
<div align="center" class="BlueBold_20">Visit/Order Status </div>
<table width="300" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="center">
      <input name="button" style="background-color:#f81829" type="button" onclick="out()" value="Close" />
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>MRN:<span class="BlueBold_1414"><?php echo $row_Visit['medrecnum'] ?></span></td>
    <td class="BlueBold_1414"><?php echo $row_Visit['lastname'] ?>,&nbsp;<?php echo $row_Visit['firstname'] ?>&nbsp;(<?php echo $row_Visit['othername'] ?>)</td>
    <td>Gender:<?php echo $row_Visit['gender'] ?></td>
    <td nowrap="nowrap">Age: <?php echo $row_Visit['age'] ?></td>
    <td>Ethnic:<?php echo $row_Visit['ethnicgroup'] ?></td>
  </tr>
  <tr>
    <td class="BlueBold_1212"><?php echo $row_Visit['pat_type'] ?></td>
    <td class="BlueBold_1212"><?php echo $row_Visit['location'] ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#F8FDCE" class="BlueBold_14">Order</td>
    <td nowrap="nowrap" bgcolor="#F8FDCE" class="BlueBold_14">Order Date/Time</td>
    <td bgcolor="#F8FDCE" class="BlueBold_14"><div align="center">Paid</div></td>
    <td bgcolor="#F8FDCE" class="BlueBold_14"><div align="center">Status</div></td>
    <td bgcolor="#F8FDCE" class="BlueBold_14"><div align="center">Notice</div></td>
  </tr>
  <tr>
    <td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_Visit['name']; ?></td>
    <td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_Visit['ventrydt']; ?></td>
    <?php if($row_Visit['rate'] == 0){
  		$paid = '0 rate';?>
    <td bgcolor="#00FF00"><?php echo $paid; ?></td>
    <?php }
	else {
		$paid = $row_Visit['amtpaid'];
		if($paid > 0) {	?>
    <td bgcolor="#00FF00"><?php echo $paid; ?></td>
    <?php	}
 	else { ?>
    <td bgcolor="#FF99CC"><?php echo 'Not Paid'; ?></td>
    <?php 	}
	}  ?>
    <td bgcolor="#FFFFFF"><?php echo $row_Visit['ostatus']; ?></td>
    <?php if(isset($row_Visit['diagnosis'])){  ?>
    <td nowrap="nowrap" bgcolor="#00FF00">Has Dignosis</td>
    <?php	}

	else {
		if($row_Visit['diagdays'] > 1) {	?>
    <td nowrap="nowrap" bgcolor="#FF99CC" title="Diagnosis > 1 day since visit date">No Diagnosis</td>
    <?php	}
 	else { ?>
    <td nowrap="nowrap" bgcolor="#FFFFFF">No Diagnosis yet</td>
    <?php 	} 
		} ?>
  </tr>
  
  <?php 
  if ($totalRows_LAB > 0){
	do { ?>
  <tr>
    <td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_LAB['name']; ?></td>
    <td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_LAB['oentrydt']; ?></td>
    <?php if($row_LAB['rate'] == 0){
  		$paid = '0 rate';?>
    <td bgcolor="#00FF00"><?php echo $paid; ?></td>
    <?php }
	else {
		$paid = $row_LAB['amtpaid'];
		if($paid > 0) {	?>
    <td bgcolor="#00FF00"><?php echo $paid; ?></td>
    <?php	}
 	else { ?>
    <td bgcolor="#FF99CC"><?php echo 'Not Paid'; ?></td>
    <?php 	}
	}  ?>
    <td bgcolor="#FFFFFF"><?php echo $row_LAB['ostatus']; ?></td>
    <?php if($row_LAB['ostatus'] == 'ordered' and $row_LAB['orddays'] > 1){  ?>
    <td nowrap="nowrap" bgcolor="#FF99CC">Not Collected</td>
    <?php }  ?>
    <?php if($row_LAB['ostatus'] == 'ordered' and $row_LAB['orddays'] <= 1){  ?>
    <td nowrap="nowrap" bgcolor="#FFFFFF">Not Collected</td>
    <?php } ?>
    <?php if($row_LAB['ostatus'] == 'InLab' and $row_LAB['orddays'] > 1){  ?>
    <td nowrap="nowrap" bgcolor="#FF99CC">Not Resulted</td>
    <?php }  ?>
    <?php if($row_LAB['ostatus'] == 'InLab' and $row_LAB['orddays'] <= 1){  ?>
    <td nowrap="nowrap" bgcolor="#FFFFFF">Not Resulted</td>
    <?php } ?>
    <?php if($row_LAB['ostatus'] == 'Resulted' and $row_LAB['orddays'] > 1){  ?>
    <td nowrap="nowrap" bgcolor="#FF99CC">Not Reviewed</td>
    <?php }  ?>
    <?php if($row_LAB['ostatus'] == 'Resulted' and $row_LAB['orddays'] <= 1){  ?>
    <td nowrap="nowrap" bgcolor="#FFFFFF">Not Reviewed</td>
    <?php } ?>
    <?php if($row_LAB['ostatus'] == 'Reviewed'){  ?>
    <td nowrap="nowrap" bgcolor="#00FF00">&nbsp;&nbsp;&nbsp;</td>
    <?php } ?>
    <?php } while ($row_LAB = mysql_fetch_assoc($LAB));
  } ?>
  </tr>

  <?php 
  if ($totalRows_Drugs > 0){
	do { ?>
  <tr>
    <td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_Drugs['item'].'(N'.$row_Drugs['ofee'].')'; ?></td>
    <td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_Drugs['oentrydt']; ?></td>
    <?php if($row_Drugs['rate'] == 0){
  		$paid = '0 rate';?>
    <td bgcolor="#00FF00"><?php echo $paid; ?></td>
    <?php }
	else {
		$paid = $row_Drugs['amtpaid'];
		if($paid > 0) {	?>
    <td bgcolor="#00FF00"><?php echo $paid; ?></td>
    <?php	}
 	else { ?>
    <td bgcolor="#FF99CC"><?php echo 'Not Paid'; ?></td>
    <?php 	}
	}  ?>
    <td bgcolor="#FFFFFF"><?php echo $row_Drugs['ostatus']; ?></td>
    <?php if($row_Drugs['ostatus'] == 'RxOrdered' and $row_Drugs['orddays'] > 1){  ?>
    <td nowrap="nowrap" bgcolor="#FF99CC">?????</td>
    <?php }  ?>
    <?php if($row_Drugs['ostatus'] == 'RxOrdered' and $row_Drugs['orddays'] <= 1){  ?>
    <td nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;</td>
    <?php } ?>
    <?php if($row_Drugs['ostatus'] == 'RxPriced' and $row_Drugs['orddays'] > 1){  ?>
    <td nowrap="nowrap" bgcolor="#FF99CC">?????</td>
    <?php }  ?>
    <?php if($row_Drugs['ostatus'] == 'RxPriced' and $row_Drugs['orddays'] <= 1){  ?>
    <td nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;</td>
    <?php } ?>
    <?php if($row_Drugs['ostatus'] == 'RxPaid' and $row_Drugs['orddays'] > 1){  ?>
    <td nowrap="nowrap" bgcolor="#FF99CC">Not Dispensed</td>
    <?php }  ?>
    <?php if($row_Drugs['ostatus'] == 'RxPaid' and $row_Drugs['orddays'] <= 1){  ?>
    <td nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;</td>
    <?php } ?>
    <?php if($row_Drugs['ostatus'] == 'RxDispensed'){  ?>
    <td nowrap="nowrap" bgcolor="#00FF00">&nbsp;&nbsp;&nbsp;</td>
    <?php } ?>
    <?php if($row_Drugs['ostatus'] == 'RxReferred' and $row_Drugs['orddays'] <= 1){  ?>
    <td nowrap="nowrap" bgcolor="#00FF00">&nbsp;&nbsp;&nbsp;</td>
    <?php } ?>
    <?php } while ($row_Drugs = mysql_fetch_assoc($Drugs));
  } ?>
  </tr>


  <?php 
  if ($totalRows_Other > 0){
	do { ?>
  <tr>
    <td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_Other['name']; ?></td>
    <td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_Other['oentrydt']; ?></td>
    <?php if($row_Other['rate'] == 0){
  		$paid = '0 rate';?>
    <td bgcolor="#00FF00"><?php echo $paid; ?></td>
    <?php }
	else {
		$paid = $row_Other['amtpaid'];
		if($paid > 0) {	?>
    <td bgcolor="#00FF00"><?php echo $paid; ?></td>
    <?php	}
 	else { ?>
    <td bgcolor="#FF99CC"><?php echo 'Not Paid'; ?></td>
    <?php 	}
	}  ?>
    <td bgcolor="#FFFFFF"><?php echo $row_Other['ostatus']; ?></td>
    <?php if($row_Other['ostatus'] == 'ordered' and $row_Other['orddays'] > 1){  ?>
    <td nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp; <!--bgcolor="#FF99CC">  > 1 day--></td>
    <?php }  ?>
    <?php if($row_Other['ostatus'] == 'ordered' and $row_Other['orddays'] <= 1){  ?>
    <td nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;</td>
    <?php } ?>
    <?php } while ($row_Other = mysql_fetch_assoc($Other));
  } ?>
  </tr>

</table>
</body>
</html>
<?php
mysql_free_result($Visit);

mysql_free_result($LAB);

mysql_free_result($Drugs);

mysql_free_result($Other);

?>
