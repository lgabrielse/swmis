<?php  $pt = "Patient Visit View"; ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php $_SESSION['today'] = date("Y-m-d");  ?>

<?php
$colid_visitview = "-1";
if (isset($_GET['vid'])) {
  $colid_visitview = (get_magic_quotes_gpc()) ? $_GET['vid'] : addslashes($_GET['vid']);
}
else {
if (isset($_SESSION['vid'])) {
  $colid_visitview = (get_magic_quotes_gpc()) ? $_SESSION['vid'] : addslashes($_SESSION['vid']);
}}
	
$colmrn_visitview = "-1";
if (isset($_GET['mrn'])) {
  $colmrn_visitview = (get_magic_quotes_gpc()) ? $_GET['mrn'] : addslashes($_GET['mrn']);
}
else {
if (isset($_SESSION['mrn'])) {
  $colmrn_visitview = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']);
}}
mysql_select_db($database_swmisconn, $swmisconn); //get patient visit info
$query_visitview = sprintf("SELECT id, medrecnum, DATE_FORMAT(visitdate,'%%d-%%b-%%Y   %%H:%%i') visitdate, status, vfeeid, pat_type, location, urgency, height, weight, DATE_FORMAT(discharge,'%%d-%%b-%%Y') discharge, visitreason, diagnosis, entryby, DATE_FORMAT(entrydt,'%%d-%%b-%%Y') entrydt, vfeeid FROM patvisit WHERE id = %s AND medrecnum = %s", $colid_visitview,$colmrn_visitview);
$visitview = mysql_query($query_visitview, $swmisconn) or die(mysql_error());
$row_visitview = mysql_fetch_assoc($visitview);
$totalRows_visitview = mysql_num_rows($visitview);

mysql_select_db($database_swmisconn, $swmisconn); //find Registation fee paid
$query_RegFee = "Select feeid, rate, ratereason, amtpaid from orders where feeid = 19 and medrecnum= '".$colmrn_visitview."' and visitid = '0'";
$RegFee = mysql_query($query_RegFee, $swmisconn) or die(mysql_error());
$row_RegFee = mysql_fetch_assoc($RegFee);
$totalRows_RegFee = mysql_num_rows($RegFee);

	$regpaid = 'N';
if ($row_RegFee['rate'] == 0 or $row_RegFee['amtpaid'] > 0) {
	$regpaid = 'Y';
}

mysql_select_db($database_swmisconn, $swmisconn);  //find order number and visit fee paid
$query_visitfee = "Select id ordid, feeid, rate, ratereason, amtdue, billstatus, amtpaid from orders where medrecnum = ".$colmrn_visitview." and visitid = ".$colid_visitview." and feeid = ".$row_visitview['vfeeid']."";  //IN (Select id from fee where dept = 'Records')";
$visitfee = mysql_query($query_visitfee, $swmisconn) or die(mysql_error());
$row_visitfee = mysql_fetch_assoc($visitfee);
$totalRows_visitfee = mysql_num_rows($visitfee);

	$visitpaid = 'N';
if ($totalRows_visitfee >0 and ($row_visitfee['rate'] == 0 or $row_visitfee['amtpaid'] > 0)) {
	$visitpaid = 'Y';
}

//mysql_select_db($database_swmisconn, $swmisconn);  //find if exam exists
//$query_isexam = "Select id from exam_result where visitid = ".$colid_visitview."";  
//$isexam = mysql_query($query_isexam, $swmisconn) or die(mysql_error());
//$row_isexam = mysql_fetch_assoc($isexam);
//$totalRows_isexam = mysql_num_rows($isexam);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
   var win_position = ',left=300,top=300,screenX=300,screenY=300';
   var newWindow = window.open(theURL,winName,features+win_position);
   newWindow.focus();
}
//-->
</script>

</head>

<body>
  <table align="center">
	<tr>
		<td>
			<table align="center">
				<tr>
					<td align="center" nowrap="nowrap" class="BlueBold_12" title="Reg rate: <?php echo $row_RegFee['rate'] ?>&#10;Reg AmtPaid: <?php echo $row_RegFee['amtpaid'] ?>&#10;Visit Feeid=<?php echo $row_visitfee['feeid'] ?>&#10;Visit Rate: <?php echo $row_visitfee['rate'] ?>&#10;Visit AmtDue: <?php echo $row_visitfee['amtdue'] ?>&#10;Visit AmtPaid: <?php echo $row_visitfee['amtpaid'] ?>&#10;Visit Billstatus: <?php echo $row_visitfee['billstatus'] ?>">
					
					Paid: Reg:<?php echo $regpaid ?> Visit:<?php echo $visitpaid ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="right" class="subtitlebl">Status:&nbsp;</td>
					<td><input name="vstatus" type="text" size="8" maxlength="12" disabled="disabled" value="<?php echo $row_visitview['status']; ?>"/></td>
					<td><input name="visitdate" type="text" size="15" maxlength="20" disabled="disabled" value="<?php echo $row_visitview['visitdate']; ?>"/></td>
					<td align="center" class="subtitlebl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="center" nowrap="nowrap" class="subtitlebl">View Patient Visit</td>
					<td align="center" class="subtitlebl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<?php  if ($_SESSION['vnum'] > 0) { ?>
					<td nowrap="nowrap">Visits: &nbsp;
				      <?php if(allow(20,1) == 1) { ?>
				  
					<td align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitList.php"><?php echo $_SESSION['vnum']; ?></a>&nbsp;&nbsp;&nbsp;</td>
					<?php  } 
						else {?>
						<td nowrap="nowrap">Visits: &nbsp; 0 &nbsp;&nbsp;&nbsp;</td>
					<?php  } ?>
				<?php if(allow(20,4) == 1 and empty($row_visitview['discharge']) and $regpaid == 'N' ) { ?>
					<td align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitDelete.php&vid=<?php echo $row_visitview['id'] ?>">Delete</a></td>
				<?php  } ?>
					
						<td align="center" nowrap="nowrap">
					<?php if(allow(20,2) == 1 && empty($row_visitview['discharge']) && !empty($row_visitview['diagnosis'])) { ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatDischarge.php&vid=<?php echo $row_visitview['id'] ?>">Discharge!</a> &nbsp;
					<?php  } 
						else {
						if (empty($row_visitview['diagnosis'])) {?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No Diagnosis
					<?php  } 
						else { ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php  } ?>					</td>
				<?php  } ?>
		<?php  } ?>		
					<td align="center">&nbsp;&nbsp;&nbsp;<a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitEdit.php&vid=<?php echo $row_visitview['id'] ?>&vordid=<?php echo $row_visitfee['ordid'] ?>">Edit</a></td>
		  <?php if (!empty($row_visitview['diagnosis'])) { ?>
					<td align="center">&nbsp;&nbsp;&nbsp;<a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>">Close</a> Vfeeid=<?php echo $row_visitview['vfeeid']; ?></td>
		<?php  } ?>		
				</tr>
		  </table>		</td>	
	<tr>
    	<td><form id="form1" name="form1" method="post" action="">
    	  <table width="80%" border="0" align="center">
            <tr>

              <td nowrap="nowrap" title="Entry Date: <?php echo $row_visitview['entrydt']; ?>&#10; Entry By: <?php echo $row_visitview['entryby']; ?>"> <span class="Black_10">Visit#</span><span class="BlueBold_14"><?php echo $row_visitview['id'].'mrn#'.$row_visitview['medrecnum']; ?></span></td>
              <td nowrap="nowrap"><div align="right">Entry Date:</div></td>
              <td><input name="entrydt" type="text" disabled="disabled" id="visitdate" value="<?php echo $row_visitview['entrydt']; ?>" size="12" /></td>
              <td nowrap="nowrap"><div align="right">Type:</div></td>
              <td><input name="pat_type" type="text" readonly="readonly" id="pat_type" size="8" value="<?php echo $row_visitview['pat_type']; ?>" /></td>
              <td><div align="right">Location:</div></td>
              <td colspan="2"><input name="location" type="text" readonly="readonly" id="location" size="10" value="<?php echo $row_visitview['location']; ?>" /></td>
              <td>&nbsp;</td>
              <!--to replace urgency space-->
              <!--<td><div align="right">Urgency:</div></td>
				    <td><input name="urgency" type="text" readonly="readonly" id="urgency" value="<?php echo $row_visitview['urgency']; ?>" size="12" /></td>-->
              <td nowrap="nowrap"><div align="right">Discharge Date: </div></td>
              <td><input name="discharge" type="text" readonly="readonly" id="discharge"  size="8" value="<?php echo $row_visitview['discharge']; ?>"/>
                  <input type="hidden" name="todaydate" value="Date('Y-m-d H:i:s')"/>              </td>
            </tr>
		</table>
		<table align="center">
            <tr>
              <td nowrap="nowrap" class="Black_10"><div align="right">Visit<br />
                Reason </div></td>
              <td colspan="3"><textarea name="visitreason" cols="35" rows="2" readonly="readonly" id="visitreason"><?php echo $row_visitview['visitreason']; ?></textarea></td>
              <td>&nbsp;</td>
              <td class="Black_10">Height<br/>
                (cm)</td>
              <td height="12px"><input name="height" type="text" size="2"  readonly="readonly" value="<?php echo $row_visitview['height']; ?>"/></td>
              <td class="Black_10">Weight<br />
                (kilo)</td>
              <td height="12px"><input name="weight" type="text" size="2" readonly="readonly" value="<?php echo $row_visitview['weight']; ?>" /></td>
              <td class="Black_10"><div align="right">Diagnosis:</div></td>
              <td colspan="3"><textarea name="diagnosis" cols="35" rows="2" readonly="readonly" id="diagnosis"><?php echo $row_visitview['diagnosis']; ?></textarea></td>
            </tr>
          </table>
    	</form>		</td>
	</tr>
</table>

</body>
</html>
<?php
mysql_free_result($visitview);

mysql_free_result($RegFee);

mysql_free_result($visitfee);
?>
