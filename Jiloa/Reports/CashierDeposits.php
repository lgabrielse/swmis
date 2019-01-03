<?php require_once('../../Connections/swmisconn.php'); ?>
<?php
mysql_select_db($database_swmisconn, $swmisconn);
$query_deppos = "Select sum(deposit) deppos from PatPerm where deposit > 0";
$deppos = mysql_query($query_deppos, $swmisconn) or die(mysql_error());
$row_deppos = mysql_fetch_assoc($deppos);
$totalRows_deppos = mysql_num_rows($deppos);

mysql_select_db($database_swmisconn, $swmisconn);
$query_depneg = "Select sum(deposit) depneg from PatPerm where deposit < 0";
$depneg = mysql_query($query_depneg, $swmisconn) or die(mysql_error());
$row_depneg = mysql_fetch_assoc($depneg);
$totalRows_depneg = mysql_num_rows($depneg);

mysql_select_db($database_swmisconn, $swmisconn);
$query_depPats = "Select medrecnum, lastname, firstname, othername, gender, dob, est, deposit from patperm where deposit <> 0 order by deposit";
$depPats = mysql_query($query_depPats, $swmisconn) or die(mysql_error());
$row_depPats = mysql_fetch_assoc($depPats);
$totalRows_depPats = mysql_num_rows($depPats);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Deposits Report</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p align="center" class="BlueBold_20"><a href="CashierReptMenu.php"><span class="nav">Menu </span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Deposits Report  <span class="BlueBold_14"><?php echo date('m-d-Y') ?></span></p>
<p align="center">&nbsp;</p>
<?php $depbal = 0?>
<table width="20%" border="0" align="center">
  <tr>
    <td bgcolor="#FFFDDA">Total Positive Balances </td>
    <td align="right" bgcolor="#FFFFFF"><?php echo $row_deppos['deppos'] ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFDDA">Total Negative Balances </td>
    <td align="right" bgcolor="#FFFFFF"><?php echo $row_depneg['depneg'] ?></td>
  </tr>
  <?php $depbal = $row_deppos['deppos']+$row_depneg['depneg'] ?>
  <tr>
    <td bgcolor="#FFFDDA">Deposits Balance </td>
    <td align="right" bgcolor="#FFFFFF"><?php echo $depbal ; ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>

<table border="1" align="center">
  <tr>
    <td align="center" class="BlackBold_12">medrecnum</td>
    <td align="center" class="BlackBold_12">lastname</td>
    <td align="center" class="BlackBold_12">firstname</td>
    <td align="center" class="BlackBold_12">othername</td>
    <td align="center" class="BlackBold_12">gender</td>
    <td align="center" class="BlackBold_12">age</td>
    <td align="center" class="BlackBold_12">deposit</td>
  </tr>
  <?php do { ?>
  <?php  //calculate patient Age and assign it to $patage variable
		$patage = 0;
		$patdob = 0;
		$est = "";
		if ($row_depPats['est'] === "Y") {
			$est = "*";
		}
		if (strtotime($row_depPats['dob'])) {
			$c= date('Y');
			$y= date('Y',strtotime($row_depPats['dob']));
			$patage = $c-$y;
		//format date of birth
			$datetime = strtotime($row_depPats['dob']);
			$patdob = $est.date("d-M-Y", $datetime);
		}
?>

    <tr>
      <td bgcolor="#FFFFFF" class="BlackBold_11_11"><?php echo $row_depPats['medrecnum']; ?></td>
      <td bgcolor="#FFFFFF" class="BlackBold_11_11"><?php echo $row_depPats['lastname']; ?></td>
      <td bgcolor="#FFFFFF" class="BlackBold_11_11"><?php echo $row_depPats['firstname']; ?></td>
      <td bgcolor="#FFFFFF" class="BlackBold_11_11"><?php echo $row_depPats['othername']; ?></td>
      <td bgcolor="#FFFFFF" class="BlackBold_11_11"><?php echo $row_depPats['gender']; ?></td>
      <td bgcolor="#FFFFFF" class="BlackBold_11_11"><?php echo $patage; ?></td>
      <td bgcolor="#FFFFFF" class="BlackBold_11_11"><?php echo $row_depPats['deposit']; ?></td>
    </tr>
    <?php } while ($row_depPats = mysql_fetch_assoc($depPats)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($deppos);

mysql_free_result($depneg);

mysql_free_result($depPats);
?>
