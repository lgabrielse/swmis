<?php ob_start(); ?>
<?php  $pt = "Add DDL"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?> 
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

<?php
mysql_select_db($database_swmisconn, $swmisconn);
$query_ddl = "SELECT id, list, name, seq, DATE_FORMAT(entrydt, '%m-%d-%Y %H:%i') entrydt, entryby FROM dropdownlist WHERE list = 'list' ORDER BY  seq ASC";
$ddl = mysql_query($query_ddl, $swmisconn) or die(mysql_error());
$row_ddl = mysql_fetch_assoc($ddl);
$totalRows_ddl = mysql_num_rows($ddl);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Setup DropDownList</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>

<p>&nbsp;</p>
<table width="800px" align="center">
  <tr>
    <td valign="top">
	 <table width="400px">
      <tr>
        <td colspan="2"><div align="center" class="navLink"><a href="DrpDwnList.php?act=DrpDwnNamesAdd.php">Add</a></div></td>
        <td colspan="3" nowrap="nowrap" class="subtitlebl"><div align="center">Drop Down List
          <span><a href="DDL_TestRELists.php" target="_blank" class="nav">Summary</a></span> </div></td>
        <td class="subtitlebl"><a href="SetUpMenu.php" class="navLink">Setup Menu</a></td>
      </tr>
      <tr>
        <td class="subtitlebl">&nbsp;</td>
        <td class="subtitlebl">&nbsp;</td>
        <td class="subtitlebl"><div align="center">Name</div></td>
        <td class="subtitlebl"><div align="center">Seq</div></td>
      </tr>
      <?php do { ?>
      <tr>
        <td bgcolor="#FFFFFF"><div align="center"><a href="DrpDwnList.php?act=DrpDwnNamesEdit.php&id=<?php echo $row_ddl['id'] ?>">E</a></div></td>
        <td bgcolor="#FFFFFF"><div align="center"><a href="DrpDwnList.php?act=DrpDwnNamesDelete.php&id=<?php echo $row_ddl['id'] ?>">D</a></div></td>
        <td bgcolor="#FFFFFF" class="BlackBold_12" title="Entered By: <?php echo $row_ddl['entryby']; ?>&#10;Entered: <?php echo $row_ddl['entrydt']; ?>"><a href="DropDownList.php?list=<?php echo $row_ddl['name']; ?>"><?php echo $row_ddl['name']; ?></a></td>
        <td bgcolor="#FFFFFF" class="BlackBold_12"><?php echo $row_ddl['seq']; ?></td>
     </tr>
      <?php } while ($row_ddl = mysql_fetch_assoc($ddl)); ?>
    </table>
  </td>
  <td valign="top" ><?php if (isset($_GET['act'])) {
	$feeact = $_GET['act'];
 ?>
    <table width="400px">
		  <tr>
			<td valign="top"><?php require_once($feeact); ?></td>
		  </tr>
	  </table>
<?php }
	else {
?>		
    <table width="400px">
		  <tr>
			<td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		  </tr>
	  </table>

<?php	} ?>
	</td>
  </tr>
</table>

<p>Notes:<br />
Use Listname = list to create a new list. For this use only lowercase letters.<br />
Items on the Dropdownlist will be displayed in sequence defined in Seq field.<br />
Click on Add to ad a new list item.<br />
Click on E to change a list item.<br />
CLick on D to Delete an item. <br />
</p>
</body>
</html>
<?php
mysql_free_result($ddl);
ob_end_flush();
?>
