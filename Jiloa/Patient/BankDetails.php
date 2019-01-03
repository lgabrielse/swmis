<?php if (session_status() == PHP_SESSION_NONE) {
    session_start(); }?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

<?php
$colname_patperm = "1330";
if (isset($_GET['mrn'])) {
  $colname_patperm = (get_magic_quotes_gpc()) ? $_GET['mrn'] : addslashes($_GET['mrn']);
  $_SESSION['mrn'] = $colname_patperm;  //set session variable
}
else {
	if (isset($_SESSION['mrn'])) {
  $colname_patperm = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']);
	}
  }

  // Patient Perm data
mysql_select_db($database_swmisconn, $swmisconn);
$query_patperm = "SELECT medrecnum, hospital, active, entrydt, entryby, lastname, firstname, othername, gender, ethnicgroup, DATE_FORMAT(dob,'%d %b %Y') dob, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE, dob)),'%y') AS age, est FROM patperm WHERE medrecnum = '". $colname_patperm."'";
$patperm = mysql_query($query_patperm, $swmisconn) or die(mysql_error());
$row_patperm = mysql_fetch_assoc($patperm);
$totalRows_patperm = mysql_num_rows($patperm);

// *** Get the patient permanent record and the ID of the patient info record
?>
<?php mysql_select_db($database_swmisconn, $swmisconn);  //CASE WHEN o.item is NULL THEN f.name ELSE o.item END as feename
$query_Detail = "SELECT medrecnum, transtype, bankname, transnum, bmcreceiptnum, amount, comments, entryby, entrydt From bank WHERE medrecnum = '".$colname_patperm."'";
$Detail = mysql_query($query_Detail, $swmisconn) or die(mysql_error());
$row_Detail = mysql_fetch_assoc($Detail);
$totalRows_Detail = mysql_num_rows($Detail);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
function out(){
	opener.location.reload(1); //This updates the data on the calling page
	  self.close();
}
function MM_closeBrWindow() { // this works too
  window.close(); 
}
//-->
</script>
</head>

<body>

<!-- Begin PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT -   -->
  <a name="top"></a>
<table width = "800px" align="center" >
	<tr>
		<td height="5px" bgcolor="#6699CC" class="legal"> <div align="center"><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><></div></td>
	</tr>
</table >
  <table width = "800px" align="center">
	  <tr>
	  	<td bgcolor="#32ff32"><div align="center"><A HREF="javascript:window.print()">Print</A></td>
	    <td><div align="center"><input name="button" style="background-color:#f81829" type="button" onclick="out()" value="Close" /></a></td>
		<td nowrap="nowrap" class="BlueBold_16"><?php echo $row_patperm['hospital']; ?> Medical Center - Transactions</td>
	    <td nowrap="nowrap" class ="BlueBold_14">Printed:<?php echo date("d-M-Y") ?></td>
      </tr>
	  <tr>
	    <td class ="BlueBold_18">&nbsp;</td>
		<td nowrap="nowrap" Title="Entry Date: <?php echo $row_patperm['entrydt']; ?>&#10; Entry By: <?php echo $row_patperm['entryby']; ?>&#10;Active: <?php echo $row_patperm['active']; ?>">MRN:<span class="BlueBold_16"><?php echo $row_patperm['medrecnum']; ?></span></td>
		<td bgcolor="#FFFFFF" nowrap="nowrap">&nbsp;&nbsp;&nbsp;Name:<span class="BlueBold_16" ><?php echo $row_patperm['lastname']; ?><?php echo $row_patperm['firstname']; ?>(<?php echo $row_patperm['othername']; ?>)</td>
		<td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gender:<span class="BlueBold_14"><?php echo $row_patperm['gender']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ethnic Group: <span class="BlueBold_14"><?php echo $row_patperm['ethnicgroup']; ?></span></td>
	  </tr>
</table>
<table width = "800px" align="center" >
	<tr>
		<td height="5px" bgcolor="#6699CC" class="legal"> <div align="center"><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><></div></td>
	</tr>
</table>
<table border="1" align="center">
	<tr>
		<td class="BlueBold_14"> <div align="center">MRN</div></td>
		<td class="BlueBold_14"> <div align="center">Tranaction<br/>
	  Type</div></td>
		<td class="BlueBold_14"> <div align="center">Bank Name</div></td>
		<td class="BlueBold_14"><div align="center">		    Transaction</div></td>
		<td class="BlueBold_14"> <div align="center">Amount</div></td>
		<td class="BlueBold_14"> <div align="center">Balance</div></td>
		<td class="BlueBold_14"> <div align="center">Comments</div></td>
		<td class="BlueBold_14"> <div align="center">Receipt<br />
	  Number</div></td>
		<td class="BlueBold_14"> <div align="center">Entry BY</div></td>
	  <td class="BlueBold_14"> <div align="center">Entry<br />
          <span class="BlueBold_14">Date</span></div></td>
	</tr>
    <?php $balance = 0;
		 do { ?>
    <tr>
      <td class="BlueBold_16"> <?php echo $row_Detail['medrecnum']; ?></td>
      <td bgcolor="#FFFFCC"><?php echo $row_Detail['transtype']; ?></td>
      <td bgcolor="#FFFFCC"><?php echo $row_Detail['bankname']; ?></td>
      <td bgcolor="#FFFFCC"><?php echo $row_Detail['transnum']; ?></td>
      <td bgcolor="#FFFFCC"><?php echo $row_Detail['amount']; ?></td>
<?php 	if($row_Detail['transtype'] == 'deposit'){ $balance = $balance + $row_Detail['amount'];}
		if($row_Detail['transtype'] == 'withdrawal'){ $balance = $balance - $row_Detail['amount'];}
?>
      <td bgcolor="#FFFFCC"><?php echo $balance; ?></td>
      <td bgcolor="#FFFFCC"><?php echo $row_Detail['comments']; ?></td>
      <td bgcolor="#FFFFCC"><?php echo $row_Detail['bmcreceiptnum']; ?></td>
      <td bgcolor="#FFFFCC"><?php echo $row_Detail['entryby']; ?></td>
	  <td bgcolor="#FFFFCC"><?php echo $row_Detail['entrydt']; ?></td>
    </tr>
    <?php } while ($row_Detail = mysql_fetch_assoc($Detail)); ?>
</table>
</body>
</html>
