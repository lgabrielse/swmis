<?php require_once('../../Connections/swmisconn.php'); ?>
<?php
mysql_select_db($database_swmisconn, $swmisconn);
$query_DevList = "SELECT id, DevType, EstHrs, ActHrs, SUBSTR(Priority,1,1) Priority, Status, AssignedTo, Summary, Description, entryby, entrydt, comments FROM development order by id";
$DevList = mysql_query($query_DevList, $swmisconn) or die(mysql_error());
$row_DevList = mysql_fetch_assoc($DevList);
$totalRows_DevList = mysql_num_rows($DevList);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>View DEV Tracking</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>&nbsp;</p>
<p align="center" class="BlueBold_20">SWMIS Development Tracking </p>
<table border="1" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td><a href="DevTrackAdd.php">ADD</a></td>
    <td colspan="5"><a href="../Setup/SetUpMenu.php">Setup Menu </a></td>
  </tr>
  <?php do { ?>
    <tr>
		<td bgcolor="#FFFFCC"> valign="center" </td>
		<td colspan="5" bgcolor="#666666">*</td>
	</tr>
	<tr>
      <td><div align="right">AssignedTo</div></td>
      <td bgcolor="#FFFFFF" title="ID: <?php echo $row_DevList['id']; ?>&#10;entryby: <?php echo $row_DevList['entryby']; ?> &#10;Entrydt: <?php echo $row_DevList['entrydt']; ?>"><?php echo $row_DevList['AssignedTo']; ?></td>
      <td><div align="right">Priority</div></td>
      <td bgcolor="#FFFFFF"><?php echo $row_DevList['Priority']; ?></td>
      <td><div align="right">Summary</div></td>
      <td colspan="2" bgcolor="#FFFFFF"><?php echo $row_DevList['Summary']; ?></td>
	</tr>
    <tr>
      <td><div align="right">Status</div></td>
      <td bgcolor="#FFFFFF"><?php echo $row_DevList['Status']; ?></td>
      <td><div align="right">EstHrs</div></td>
      <td bgcolor="#FFFFFF"><?php echo $row_DevList['EstHrs']; ?></td>
      <td><div align="right">Description</div></td>
      <td colspan="2" bgcolor="#FFFFFF"><?php echo $row_DevList['Description']; ?></td>
	</tr>
    <tr>
    <td><div align="right">DevType</div></td>
      <td bgcolor="#FFFFFF"><?php echo $row_DevList['DevType']; ?></td>
      <td><div align="right">ActHrs</div></td>
      <td bgcolor="#FFFFFF"><?php echo $row_DevList['ActHrs']; ?></td>
      <td><div align="right">Comments</div></td>
      <td colspan="2" bgcolor="#FFFFFF"><?php echo $row_DevList['comments']; ?></td>
    </tr>
    <?php } while ($row_DevList = mysql_fetch_assoc($DevList)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($DevList);
?>
