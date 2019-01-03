<?php  $pt = "Receipts Report"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

<?php  $datebm = date("m");
 $datebd = date("d");
?> 
<?php if ((!isset($_POST["MM_update"])) OR ($_POST["MM_update"] <> "form1")) {  // if form data is not posted
	$_POST['B_YYYY'] = Date('Y');
	$_POST['B_MM'] = Date('m');
	$_POST['B_DD'] = Date('d');
	$_POST['B_HH'] = "00"; //Date('H');
	$_POST['B_MIN'] = "00"; //Date('i');
	$_POST['E_YYYY'] = Date('Y');
	$_POST['E_MM'] = Date('m');
	$_POST['E_DD'] = Date('d');
	$_POST['E_HH'] = "23"; //Date('H');
	$_POST['E_MIN'] = "59"; //Date('H');
	}
?>

<?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {  // if form data is posted

//change posted values to a variable
	$dateb = $_POST['B_YYYY']."-".$_POST['B_MM']."-".$_POST['B_DD']." ".$_POST['B_HH'].":".$_POST['B_MIN'];
	$datee = $_POST['E_YYYY']."-".$_POST['E_MM']."-".$_POST['E_DD']." ".$_POST['E_HH'].":".$_POST['E_MIN'];
//strtotime explained: http://www.electrictoolbox.com/using-strtotime-with-php/
// get timestamp for posted variable - this takes unformattted input and creates a timestamp number
	$datebs = strtotime($dateb);
	$datees = strtotime($datee);
// put date in format for mysql and for display
	$date1 = date("Y-m-d H:i:s", $datebs);
	$date2 = date("Y-m-d H:i:s", $datees);
	$nbc = $_POST['nbc'];
?>

<?php
mysql_select_db($database_swmisconn, $swmisconn);
$query_Recd = "SELECT r.id rid, r.medrecnum, p.lastname, p.firstname, p.othername, p.gender, DATE_FORMAT(p.entrydt,'%d-%b-%Y') patentrydt,  p.entryby patentryby, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,p.dob)),'%y') AS age, DATE_FORMAT(p.dob,'%d-%b-%Y') dob, p.ethnicgroup, DATE_FORMAT(r.entrydt,'%d-%b-%Y') entrydt, r.entryby,  r.amt, r.nbc FROM receipts r join patperm p on r.medrecnum = p.medrecnum WHERE r.entrydt BETWEEN '". $date1 . "' AND '" . $date2 ."' AND nbc like '" . $nbc ."%'";
$Recd = mysql_query($query_Recd, $swmisconn) or die(mysql_error());
$row_Recd = mysql_fetch_assoc($Recd);
$totalRows_Recd = mysql_num_rows($Recd);
	} // end of If form was osted ?>

<?php mysql_select_db($database_swmisconn, $swmisconn);
$query_PayBy = "SELECT name FROM dropdownlist WHERE list = 'PayBy' ORDER BY seq ASC";
$PayBy = mysql_query($query_PayBy, $swmisconn) or die(mysql_error());
$row_PayBy = mysql_fetch_assoc($PayBy);
$totalRows_PayBy = mysql_num_rows($PayBy);
 ?>

<?php $Receipttot = 0;?>
<?php $AmtDuetot = 0;?>
<?php $roAmtPaidtot = 0;?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transaction Report</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		          <a href="CashierReptMenu.php"><span class="navLink">Menu</span> </a>	                                            	        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<span class="BlackBold_30">Receipt Transaction Report </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        
				  <!--<a href="CashReceiptDept.php"><span class="navLink">Receipt By Dept Section--></span></a></div>
<table width="40%" align="center">
  <tr>
  
<td>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" align="center">
    <tr>
      <td nowrap="nowrap" bgcolor="#FFFFFF" class="BlackBold_11"><p>Select Beginning and </p></td>
      <td>Begin:</td>
      <td nowrap="nowrap">YYYY
        <select name="B_YYYY">
            <option value="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></option>
            <?php 			$range = range(2012,2020);
				foreach ($range as $cm) { ?>
            <option value='<?php echo $cm ?>'  <?php if (!(strcmp($cm, $_POST['B_YYYY']))) {echo "selected=\"selected\"";} ?>><?php echo $cm ?></option>
          ";

          <?php } ?>
          </select>
        MM
        <select name="B_MM">
          <option value="<?php echo date("m"); ?>"><?php echo date("m"); ?></option>
          <?php 			$range = range(0,12);
				foreach ($range as $cm) { ?>
          <option value='<?php echo $cm ?>'  <?php if (!(strcmp($cm, $_POST['B_MM']))) {echo "selected=\"selected\"";} ?>><?php echo $cm ?></option>
          ";

          <?php }?>
        </select>
        DD
        <select name="B_DD">
          <option value="<?php echo date("d"); ?>"><?php echo date("d"); ?></option>
          <?php 			$range = range(0,31);
				foreach ($range as $cm) { ?>
          <option value='<?php echo $cm ?>'  <?php if (!(strcmp($cm, $_POST['B_DD']))) {echo "selected=\"selected\"";} ?>><?php echo $cm ?></option>
          ";

          <?php }?>
        </select>
        HH
        <select name="B_HH">
          <option value="00">00</option>
          <?php 			$range = range(0,24);
				foreach ($range as $cm) {?>
          <option value='<?php echo $cm ?>'  <?php if (!(strcmp($cm, $_POST['B_HH']))) {echo "selected=\"selected\"";} ?>><?php echo $cm ?></option>
          ";

          <?php }?>
        </select>
        MIN
        <select name="B_MIN">
          <option value="00">00</option>
          <?php 			$range = range(0,60,5);
				foreach ($range as $cm) {?>
          <option value='<?php echo $cm ?>'  <?php if (!(strcmp($cm, $_POST['B_MIN']))) {echo "selected=\"selected\"";} ?>><?php echo $cm ?></option>
          ";

          <?php }?>
        </select>
      </td>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Submit" /></td>
    </tr>
    <tr>
      <td nowrap="nowrap" bgcolor="#FFFFFF" class="BlackBold_11">ending date and time. </td>
      <td>End:</td>
      <td nowrap="nowrap">YYYY
        <select name="E_YYYY">
            <option value="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></option>
            <?php 			$range = range(2012,2020);
				foreach ($range as $cm) { ?>
            <option value='<?php echo $cm ?>'  <?php if (!(strcmp($cm, $_POST['E_YYYY']))) {echo "selected=\"selected\"";} ?>><?php echo $cm ?></option>
          ";

          <?php } ?>
          </select>
        MM
        <select name="E_MM">
          <option value="<?php echo date("m"); ?>"><?php echo date("m"); ?></option>
          <?php 			$range = range(1,12);
				foreach ($range as $cm) { ?>
          <option value='<?php echo $cm ?>'  <?php if (!(strcmp($cm, $_POST['E_MM']))) {echo "selected=\"selected\"";} ?>><?php echo $cm ?></option>
          ";

          <?php } ?>
        </select>
        DD
        <select name="E_DD">
          <option value="<?php echo date("d"); ?>"><?php echo date("d"); ?></option>
          <?php 			$range = range(0,31);
				foreach ($range as $cm) { ?>
          <option value='<?php echo $cm ?>'  <?php if (!(strcmp($cm, $_POST['E_DD']))) {echo "selected=\"selected\"";} ?>><?php echo $cm ?></option>
          ";

          <?php } ?>
        </select>
        HH
        <select name="E_HH">
          <option value="23">23</option>
          <?php 			$range = range(0,23);
				foreach ($range as $cm) { ?>
          <option value='<?php echo $cm ?>'  <?php if (!(strcmp($cm, $_POST['E_HH']))) {echo "selected=\"selected\"";} ?>><?php echo $cm ?></option>
          ";

          <?php } ?>
        </select>
        MIN
        <select name="E_MIN">
          <option value="59">59</option>
          <?php 			$range = range(0,59,5);
				foreach ($range as $cm) { ?>
          <option value='<?php echo $cm ?>'  <?php if (!(strcmp($cm, $_POST['E_MIN']))) {echo "selected=\"selected\"";} ?>><?php echo $cm ?></option>
          ";

          <?php } ?>
        </select>
      </td>
      <td>AS:</td>
      <td><select name="nbc" id="nbc">
	  	<option value="%">All</option>
        <?php do { ?>
	        <option value="<?php echo $row_PayBy['name']?>"><?php echo $row_PayBy['name']?></option>
        <?php } while ($row_PayBy = mysql_fetch_assoc($PayBy));
			  $rows = mysql_num_rows($PayBy);
			  if($rows > 0) {
				  mysql_data_seek($PayBy, 0);
				  $row_PayBy = mysql_fetch_assoc($PayBy);
			  } ?>
      </select>
      </td>
      
    </tr>
    
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
</td>

</tr>

</table>

<?php if(isset($totalRows_Recd) and $totalRows_Recd > 0) {
//echo $date1.'...'.$date2.'+++'.$dateb.'...'.$datee 
?>

<table align="center">
  <tr>
    <td valign="bottom" class="BlackBold_12"><div align="center">Receipt<br />
    number</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">Receipt<br />
    Date</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">med<br />
    rec<br />
    num</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">last<br />
    name</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">Receipt<br />
    Amt</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">Acct</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">Dept</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">Section</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">order</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">Rate</div></td>
    <td valign="bottom" class="BlackBold_12" title="Order Record Amount Due"><div align="center">RcptOrd<br />
    Amt<br />Due</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">RcptOrd<br />
    Amt<br />Paid</div></td>
    <td valign="bottom" class="BlackBold_12"><div align="center">RcptOrd<br />
      TransAx<br />
      Status</div></td>
    <td valign="bottom" class="BlackBold_12">&nbsp;</td>
    <td valign="bottom" class="BlackBold_12">Paid<br />
      Not By<br /> 
      Deposit </td>
    <td valign="bottom" class="BlackBold_12">Paid<br />
      By<br />
      Deposit</td>
    <td valign="bottom" class="BlackBold_12">Refund<br />
      Not to<br /> 
      Deposit </td>
    <td valign="bottom" class="BlackBold_12">Refund<br />
      to<br />
      Deposit</td>
    <td valign="bottom" class="BlackBold_12">Acct<br />
    Deposit</td>
    <td valign="bottom" class="BlackBold_12">Acct<br />
      Refund</td>
  </tr>
  <?php  $PdNotDep = 0; $PdByDep = 0; $RefNotToDep = 0; $RefToDep = 0; $AccDep = 0;  $AcctRef = 0;?>
  <?php do { ?>
    <tr>
      <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_Recd['rid']; ?></td>
      <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_Recd['entrydt']; ?></td>
      <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_Recd['medrecnum']; ?></td>
      <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_Recd['lastname'].', '.$row_Recd['firstname'].', '.$row_Recd['othername']?></td>
      <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_Recd['amt']; ?></td>
      <td align="right" nowrap="nowrap" bgcolor="#DEEAFA" class="BlackBold_10"><?php echo $row_Recd['nbc']; ?></td>
<?php $i = 0; ?>	  
<?php 		mysql_select_db($database_swmisconn, $swmisconn);
		//$query_rcptord = "SELECT r.id rid, ro.id rcptordid FROM receipts r join rcptord ro on r.id = ro.rcptid WHERE r.entrydt BETWEEN '". $date1 . "' AND '" . $date2 ."'";
		$query_rcptord = "SELECT o.amtpaid oamtpaid, o.amtdue oamtdue, o.status ostatus, o.billstatus, o.item, ro.amtdue roamtdue, ro.amtpaid roamtpaid, ro.unpaid, ro.status rostatus, f.fee, f.id feeid, left(f.dept,3) dept, f.section, f.name, o.id orderid, o.rate from receipts r join rcptord ro on r.id = ro.rcptid join orders o on ro.ordid = o.id join fee f on o.feeid = f.id WHERE r.id = '" . $row_Recd['rid']."'";
		$rcptord = mysql_query($query_rcptord, $swmisconn) or die(mysql_error());
		$row_rcptord = mysql_fetch_assoc($rcptord);
		$totalRows_rcptord = mysql_num_rows($rcptord);
?>
  <?php do {   //each order
  	$i = $i + 1; 
	if($i == 1 ){
	?>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['dept']; ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['section']; ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['name']; ?>  <?php echo $row_rcptord['item']; ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['rate']; ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo round($row_rcptord['roamtdue']); ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['roamtpaid']; ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['rostatus']; ?></td>
			<td>&nbsp;</td>
<?php 	if($row_Recd['nbc'] <> 'Deposit' and $row_rcptord['rostatus'] == 'Paid') { 
			$PdNotDep = $PdNotDep + $row_rcptord['roamtpaid'];?>
	  <td bgcolor="#F5F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#F5F5DC">&nbsp;</td>		
<?php 		}?>
<?php 	if($row_Recd['nbc'] == 'Deposit' and $row_rcptord['rostatus'] == 'Paid') {
			$PdByDep = $PdByDep + $row_rcptord['roamtpaid'];?>
			<td bgcolor="#F5F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#F5F5DC">&nbsp;</td>		
<?php 		}?>
<?php 	if($row_Recd['nbc'] <> 'Deposit' and $row_rcptord['rostatus'] == 'Refunded') { 
			$RefNotToDep = $RefNotToDep + $row_rcptord['roamtpaid'];?>
			<td bgcolor="#E9F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#E9F5DC">&nbsp;</td>		
<?php 		}?>
<?php 	if($row_Recd['nbc'] == 'Deposit' and $row_rcptord['rostatus'] == 'Refunded') {
			$RefToDep = $RefToDep + $row_rcptord['roamtpaid'];?>
			<td bgcolor="#E9F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#E9F5DC">&nbsp;</td>		
<?php 		}?>

<?php 	if($row_rcptord['rostatus'] == 'Deposited') { 
			$AccDep = $AccDep + $row_rcptord['roamtpaid']; ?>
			<td bgcolor="#F5F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#F5F5DC">&nbsp;</td>		
<?php 		}?>
<?php 	if($row_rcptord['rostatus'] == 'DepRefund') {
			$AcctRef = $AcctRef + $row_rcptord['roamtpaid'];?>
			<td bgcolor="#F5F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#F5F5DC">&nbsp;</td>		
<?php 		}?>
      <?php } else {?>
  <tr>
			<td bgcolor="#FFFFFF" class="BlackBold_11">&nbsp;</td>
			<td bgcolor="#FFFFFF" class="BlackBold_11">&nbsp;</td>
			<td bgcolor="#FFFFFF" class="BlackBold_11">&nbsp;</td>
			<td bgcolor="#FFFFFF" class="BlackBold_11">&nbsp;</td>
			<td bgcolor="#FFFFFF" class="BlackBold_11">&nbsp;</td>
			<td bgcolor="#FFFFFF" class="BlackBold_11">&nbsp;</td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['dept']; ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['section']; ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['name']; ?>  <?php echo $row_rcptord['item']; ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['rate']; ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo round($row_rcptord['roamtdue']); ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['roamtpaid']; ?></td>
			<td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_rcptord['rostatus']; ?></td>
			<td>&nbsp;</td>
<?php 	if($row_Recd['nbc'] <> 'Deposit' and $row_rcptord['rostatus'] == 'Paid') {  
			$PdNotDep = $PdNotDep + $row_rcptord['roamtpaid'];?>
			<td bgcolor="#F5F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#F5F5DC">&nbsp;</td>		
<?php 		}?>
<?php 	if($row_Recd['nbc'] == 'Deposit' and $row_rcptord['rostatus'] == 'Paid') {
			$PdByDep = $PdByDep + $row_rcptord['roamtpaid'];?>
			<td bgcolor="#F5F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#F5F5DC">&nbsp;</td>		
<?php 		}?>
<?php 	if($row_Recd['nbc'] <> 'Deposit' and $row_rcptord['rostatus'] == 'Refunded') { 
			$RefNotToDep = $RefNotToDep + $row_rcptord['roamtpaid']; ?>
			<td bgcolor="#E9F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#E9F5DC">&nbsp;</td>		
<?php 		}?>
<?php 	if($row_Recd['nbc'] == 'Deposit' and $row_rcptord['rostatus'] == 'Refunded') {
			$RefToDep = $RefToDep + $row_rcptord['roamtpaid'];?>
			<td bgcolor="#E9F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#E9F5DC">&nbsp;</td>		
<?php 		}?>

<?php 	if($row_rcptord['rostatus'] == 'Deposited') {  
			$AccDep = $AccDep + $row_rcptord['roamtpaid'];?>
			<td bgcolor="#F5F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#F5F5DC">&nbsp;</td>		
<?php 		}?>
<?php 	if($row_rcptord['rostatus'] == 'DepRefund') {?>
			<td bgcolor="#F5F5DC"><?php echo $row_rcptord['roamtpaid']; ?></td>
<?php 		} else {?>
            <td bgcolor="#F5F5DC">&nbsp;</td>		
<?php 		}?>    <?php }
?>
  </tr>

<?php } while ($row_rcptord = mysql_fetch_assoc($rcptord)); ?>

<?php } while ($row_Recd = mysql_fetch_assoc($Recd)); ?>

<tr>
	<td colspan="14">&nbsp;</td>
    <td bgcolor="#F5F5DC" valign="bottom" class="BlackBold_12">Paid<br />
      Not By<br /> 
      Deposit </td>
    <td bgcolor="#F5F5DC" valign="bottom" class="BlackBold_12">Paid<br />
      By<br />
      Deposit</td>
    <td bgcolor="#E9F5DC" valign="bottom" class="BlackBold_12">Refund<br />
      Not to<br /> 
      Deposit </td>
    <td bgcolor="#E9F5DC" valign="bottom" class="BlackBold_12">Refund<br />
      to<br />
      Deposit</td>
    <td bgcolor="#F5F5DC" valign="bottom" class="BlackBold_12">Acct<br />
    Deposit</td>
    <td bgcolor="#F5F5DC" valign="bottom" class="BlackBold_12">Acct<br />
      Refund</td>
</tr>
<tr>
	<td colspan="14">&nbsp;</td>
	<td bgcolor="#F5F5DC"><?php echo $PdNotDep ; ?></td>
	<td bgcolor="#F5F5DC"><?php echo $PdByDep ; ?></td> 
	<td bgcolor="#E9F5DC"><?php echo $RefNotToDep ; ?></td>
	<td bgcolor="#E9F5DC"><?php echo $RefToDep ; ?></td>
	<td bgcolor="#F5F5DC"><?php echo $AccDep ; ?></td>
	<td bgcolor="#F5F5DC"><?php echo $AcctRef  ; ?></td>
</tr>
</table>


<?php
mysql_free_result($Recd);

 ?> 
          <?php }?>
</body>
</html>
 
