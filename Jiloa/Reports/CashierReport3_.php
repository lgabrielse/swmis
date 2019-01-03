<?php require_once('../../Connections/swmisconn.php'); ?>

<?php
$colname_begin = date('Y-m-d');
if (isset($_POST['begin'])) {
  $colname_begin = (get_magic_quotes_gpc()) ? $_POST['begin'] : addslashes($_POST['begin']);
}
$colname_end = date('Y-m-d');
if (isset($_POST['end'])) {
  $colname_end = (get_magic_quotes_gpc()) ? $_POST['end'] : addslashes($_POST['end']);
}

mysql_select_db($database_swmisconn, $swmisconn);
//$query_ByDept = "Select f.dept, SUM(o.amtpaid) amtpaid, 
//(SELECT SUM(d.amtdue) from orders d join fee g on d.feeid = g.id WHERE DATE_FORMAT(d.entrydt,'%Y-%m-%d') >= '".$colname_begin."' and DATE_FORMAT(d.entrydt,'%Y-%m-%d') <= '".$colname_end."' AND d.billstatus = 'due' and g.dept = f.dept) as amtdue 
//from orders o join fee f on o.feeid = f.id WHERE DATE_FORMAT(o.entrydt,'%Y-%m-%d') >= '".$colname_begin."' and DATE_FORMAT(o.entrydt,'%Y-%m-%d') <= '".$colname_end."' group by f.dept order by f.dept";
$query_ByDept = "Select f.dept, SUM(ro.amtdue) amtdue, SUM(Case When ro.amtpaid > 0 then ro.amtpaid ELSE 0 End) amtpaid, SUM(CASE WHEN ro.amtpaid < 0 THEN  ro.amtpaid Else 0 END) Refunded from orders o join fee f on o.feeid = f.id join rcptord ro on o.id = ro.ordid join receipts r on ro.rcptid = r.id WHERE DATE_FORMAT(r.entrydt,'%Y-%m-%d') >= '".$colname_begin."' and DATE_FORMAT(r.entrydt,'%Y-%m-%d') <= '".$colname_end."' group by f.dept order by f.dept";
$ByDept = mysql_query($query_ByDept, $swmisconn) or die(mysql_error());
$row_ByDept = mysql_fetch_assoc($ByDept);
$totalRows_ByDept = mysql_num_rows($ByDept);

mysql_select_db($database_swmisconn, $swmisconn);
$query_BySection = "Select f.dept, f.section, SUM(ro.amtdue) amtdue, SUM(ro.amtpaid) amtpaid, SUM(Case When ro.amtpaid > 0 then ro.amtpaid ELSE 0 End) amtpaid, SUM(CASE WHEN ro.amtpaid < 0 THEN  ro.amtpaid Else 0 END) Refunded from orders o join fee f on o.feeid = f.id join rcptord ro on o.id = ro.ordid join receipts r on ro.rcptid = r.id WHERE DATE_FORMAT(r.entrydt,'%Y-%m-%d') >= '".$colname_begin."' and DATE_FORMAT(r.entrydt,'%Y-%m-%d') <= '".$colname_end."' group by f.dept, f.section order by f.dept";
$BySection = mysql_query($query_BySection, $swmisconn) or die(mysql_error());
$row_BySection = mysql_fetch_assoc($BySection);
$totalRows_BySection = mysql_num_rows($BySection);

//echo $colname_begin;
//echo $colname_end;
//exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cashier Summary</title>
	<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../../jquery-ui-1.11.2.custom/jquery-ui.css" />
	<script src="../../jquery-1.11.1.js"></script>
    <script src="../../jquery-ui-1.11.2.custom/jquery-ui.min.js"></script>
   	<script>
	$(document).ready(function(){
     //  $(function() {           // this and previous line work OK... don't know the difference
    $.datepicker.setDefaults({    //solution to 0000-00-00 http://stackoverflow.com/questions/9888000/jquery-datepicker-format-date-not-working
     dateFormat: 'yy-mm-dd'
    });
	 dateFormat: "yy-mm-dd";
          $( "#begin" ).datepicker();
          $( "#end" ).datepicker();
//          $( "#ussedd" ).datepicker();
//          $( "#firstvisit" ).datepicker();
       });
   </script>
</head>

<body>
<table width="50%" border="1" align="center" class="tablebc">
<form id="form1" name="form1" method="post" action="CashierReport3.php">
  <tr>
    <td><a href="CashierReptMenu.php">Menu</a></td>
    <td align="center" nowrap="nowrap"><span class="BlackBold_36">Cashier Department Report</span><span class="BlackBold_16">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date: <?php echo date('Y-m-d'); ?></span></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">&nbsp;&nbsp;Begin:
      <input type="text" id="begin"name="begin" value="<?php echo $colname_begin; ?>" size="10" maxlength="12" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; End:
      <input type="text" id="end" name="end" value="<?php echo $colname_end; ?>" size="10" maxlength="12"  />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
      <input type="submit" name="SelDate" value="Select Date Range" />
      </div></td>
    </tr>
  </form>
</table>
<p>&nbsp;</p>
<p align="center" class="BlueBold_16">By DEPARTMENT </p>
<p align="center" class="BlueBold_16">
  <!--By DEPARTMENT --------By DEPARTMENT --------By DEPARTMENT --------By DEPARTMENT ---------->
</p>
<table border="1" align="center" cellpadding="1" cellspacing="1" class="tablebc">
  <tr>
    <td>Department</td>
    <td>Amount Due </td>
    <td>Amount Paid</td>
    <td>Refunds</td>
  </tr>
  <?php
		$totamtduero = 0;
		$totamtpaidro = 0;
		$totrefundro = 0;	
 		do {   ?>
    <tr>
      <td><?php echo $row_ByDept['dept']; ?></td>
      <td align="right" bgcolor="#FFFFFF"><?php echo $row_ByDept['amtdue']; ?></td>
      <td align="right" bgcolor="#FFFFFF"><?php echo $row_ByDept['amtpaid']; ?></td>
      <td align="right" bgcolor="#FFFFFF"><?php echo $row_ByDept['Refunded']; ?></td>
    </tr>
<?php 	$totamtduero = $totamtduero + $row_ByDept['amtdue'];
		$totamtpaidro = $totamtpaidro + $row_ByDept['amtpaid'];
		$totrefundro = $totrefundro + $row_ByDept['Refunded'];	
?>
    <?php } while ($row_ByDept = mysql_fetch_assoc($ByDept)); ?>
	<tr>
		<td align="right" bgcolor="#CCCCFF">Total:</td>
		<td align="right" bgcolor="#CCCCFF"><?php echo $totamtduero; ?></td>
		<td align="right" bgcolor="#CCCCFF"><?php echo $totamtpaidro; ?></td>
	    <td align="right" bgcolor="#CCCCFF"><?php echo $totrefundro; ?></td>
	</tr>
</table>

 <p>&nbsp;</p>
 <p align="center">
   <!--By Section ------By Section ------By Section ------By Section ------By Section ------By Section ------By Section -------->
</p>
 <p align="center" class="BlueBold_16">By SECTION  </p>
 <table border="1" align="center" cellpadding="1" cellspacing="1" class="tablebc">
  <tr>
    <td>Department</td>
    <td>Section</td>
    <td>Amount Due </td>
    <td>Amount Paid</td>
    <td>Refunds</td>
  </tr>
 <?php
		$totamtduesro = 0;
		$totamtpaidsro = 0;
		$totrefundsro = 0;	
 		do {   
?>
    <tr>
      <td><?php echo $row_BySection['dept']; ?></td>
      <td><?php echo $row_BySection['section']; ?></td>
      <td align="right" bgcolor="#FFFFFF"><?php echo $row_BySection['amtdue']; ?></td>
      <td align="right" bgcolor="#FFFFFF"><?php echo $row_BySection['amtpaid']; ?></td>
      <td align="right" bgcolor="#FFFFFF"><?php echo $row_BySection['Refunded']; ?></td>
      
    </tr>
<?php 	$totamtduesro = $totamtduesro + $row_BySection['amtdue'];
		$totamtpaidsro = $totamtpaidsro + $row_BySection['amtpaid'];
		$totrefundsro = $totrefundsro + $row_BySection['Refunded'];	
?>
    <?php } while ($row_BySection = mysql_fetch_assoc($BySection)); ?>
	<tr>
		<td bgcolor="#CCCCFF">&nbsp;</td>
		<td align="right" bgcolor="#CCCCFF">Total:</td>
		<td align="right" bgcolor="#CCCCFF"><?php echo $totamtduesro; ?></td>
		<td align="right" bgcolor="#CCCCFF"><?php echo $totamtpaidsro; ?></td>		
		<td align="right" bgcolor="#CCCCFF"><?php echo $totrefundsro; ?></td>		
	</tr>

</table>

</body>
</html>
<?php
mysql_free_result($BySection);
?>
<?php
mysql_free_result($ByDept);
?>
