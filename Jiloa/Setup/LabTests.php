<?php ob_start(); ?>
<?php  $pt = "View LabTests"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?> 
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

<?php
mysql_select_db($database_swmisconn, $swmisconn);
$query_tests = "SELECT t.id tid, t.feeid1, t.feeid2, t.feeid3, t.feeid4, t.feeid5, t.feeid6, t.feeid7, t.feeid8, t.feeid9, t.feeid0, t.test, t.description, t.formtype, t.ddl, t.units, t.reportseq, t.flag1, t.active, t.entrydt, t.entryby, (select name from fee Where id = t.feeid1) as name1, (select name from fee Where id = t.feeid2) as name2, (select name from fee Where id = t.feeid3) as name3, (select name from fee Where id = t.feeid4) as name4, (select name from fee Where id = t.feeid5) as name5, (select name from fee Where id = t.feeid6) as name6, (select name from fee Where id = t.feeid7) as name7, (select name from fee Where id = t.feeid8) as name8, (select name from fee Where id = t.feeid9) as name9, (select name from fee Where id = t.feeid0) as name0 FROM tests t ORDER BY name1, t.reportseq ASC";
$tests = mysql_query($query_tests, $swmisconn) or die(mysql_error());
$row_tests = mysql_fetch_assoc($tests);
$totalRows_tests = mysql_num_rows($tests);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Fee Schedule</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>

<p>&nbsp;</p>
<table width="60%" align="center">
  <tr>
    <td valign="top">
	 <table width="100%">
      <tr>
        <td colspan="3"><div align="center"><a href="LabTests.php?act=LabTestAdd.php">Add</a></div></td>
        <td colspan="3" class="subtitlebl"><div align="center">Lab Tests </div></td>
        <td colspan="4" class="subtitlebl"><div align="center"><a href="SetUpMenu.php" class="navLink">Setup Menu</a></div></td>
        <td class="subtitlebl">&nbsp;</td>
      </tr>
      <tr>
        <td class="subtitlebl">&nbsp;</td>
        <td class="subtitlebl">&nbsp;</td>
        <td class="subtitlebl"><div align="center">id</div></td>
        <td class="subtitlebl"><div align="center">fee id-name</div></td>
        <td class="subtitlebl"><div align="center">test</div></td>
        <td class="subtitlebl"><div align="center">reportseq</div></td>
        <td class="subtitlebl"><div align="center">units</div></td>
        <td class="subtitlebl"><div align="center">formtype</div></td>
        <td class="subtitlebl">ddl</td>
        <td class="subtitlebl"><div align="center">flag1</div></td>
        <td class="subtitlebl"><div align="center">active</div></td>
        <td class="subtitlebl">entrydt</td>
        <td class="subtitlebl">entryby</td>
      </tr>
      <?php do { ?>
      <tr>
        <td bgcolor="#FFFFFF"><div align="center"><a href="LabTests.php?act=LabTestEdit.php&tid=<?php echo $row_tests['tid']; ?>">Edit</a></div></td>
        <td bgcolor="#FFFFFF"><div align="center"><a href="LabTests.php?act=LabTestDelete.php&tid=<?php echo $row_tests['tid']; ?>">Delete</a></div></td>
        <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_tests['tid']; ?></td>
        <td nowrap="nowrap" bgcolor="#FFFFFF" class="BlackBold_11">
			      <?php echo $row_tests['feeid1']; ?>:<?php echo $row_tests['name1']; ?>
<?php   if ($row_tests['feeid2'] > 0) {	?>
			<br /><?php echo $row_tests['feeid2']; ?>:<?php echo $row_tests['name2']; ?>
<?php }	if($row_tests['feeid3'] > 0) {	?>
			<br /><?php echo $row_tests['feeid3']; ?>:<?php echo $row_tests['name3']; ?>
<?php }	if($row_tests['feeid4'] > 0) {	?>
			<br /><?php echo $row_tests['feeid4']; ?>:<?php echo $row_tests['name4']; ?>
<?php }	if($row_tests['feeid5'] > 0) {	?>
			<br /><?php echo $row_tests['feeid5']; ?>:<?php echo $row_tests['name5']; ?>
<?php }	if($row_tests['feeid6'] > 0) {	?>
			<br /><?php echo $row_tests['feeid6']; ?>:<?php echo $row_tests['name6']; ?>
<?php }	if($row_tests['feeid7'] > 0) {	?>
			<br /><?php echo $row_tests['feeid7']; ?>:<?php echo $row_tests['name7']; ?>
<?php }	if($row_tests['feeid8'] > 0) {	?>
			<br /><?php echo $row_tests['feeid8']; ?>:<?php echo $row_tests['name8']; ?>
<?php }	if($row_tests['feeid9'] > 0) {	?>
			<br /><?php echo $row_tests['feeid9']; ?>:<?php echo $row_tests['name9']; ?>
<?php }	if($row_tests['feeid0'] > 0) {	?>
			<br /><?php echo $row_tests['feeid0']; ?>:<?php echo $row_tests['name0']; ?>
<?php } ?>        </td>
        <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_tests['test']; ?></td>
        <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_tests['reportseq']; ?></td>
        <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_tests['units']; ?></td>
        <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_tests['formtype']; ?></td>
        <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_tests['ddl']; ?></td>
        <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_tests['flag1']; ?></td>
        <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_tests['active']; ?></td>
        <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_tests['entrydt']; ?></td>
        <td bgcolor="#FFFFFF" class="BlackBold_11"><?php echo $row_tests['entryby']; ?></td>
      </tr>
      <?php } while ($row_tests = mysql_fetch_assoc($tests)); ?>
    </table>
  </td>
  <td valign="top">
<?php if (isset($_GET['act'])) {
	$feeact = $_GET['act'];
 ?>
    <table width="100%">
		  <tr>
			<td valign="top"><?php require_once($feeact); ?></td>
		  </tr>
	  </table>
<?php } ?>
	</td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($tests);
ob_end_flush();
?>
