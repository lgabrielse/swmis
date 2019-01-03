<?php require_once('../../Connections/swmisconn.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE development SET DevType=%s, EstHrs=%s, ActHrs=%s, Priority=%s, Status=%s, AssignedTo=%s, Summary=%s, entryby=%s, entrydt=%s, comments=%s, Description=%s WHERE id=%s" ,
                       GetSQLValueString($_POST['devtype'], "text"),
                       GetSQLValueString($_POST['esthrs'], "int"),
                       GetSQLValueString($_POST['acthrs'], "int"),
                       GetSQLValueString($_POST['priority'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['assignto'], "text"),
                       GetSQLValueString($_POST['summary'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['descr'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($updateSQL, $swmisconn) or die(mysql_error());

  $updateGoTo = "DevTrackSum.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
 $id_DEVLIST = "-1";
if (isset($_GET['id'])) {
  $id_DEVLIST = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_DEVLIST = sprintf("SELECT id, DevType, EstHrs, ActHrs, Priority, Status, AssignedTo, Summary, Description, entryby, entrydt, comments FROM development WHERE id=%s", $id_DEVLIST);
$DEVLIST = mysql_query($query_DEVLIST, $swmisconn) or die(mysql_error());
$row_DEVLIST = mysql_fetch_assoc($DEVLIST);
$totalRows_DEVLIST = mysql_num_rows($DEVLIST);

?>
<?php mysql_select_db($database_swmisconn, $swmisconn);
$query_DevType = "SELECT name FROM dropdownlist WHERE list = 'DevType' ORDER BY seq ASC";
$DevType = mysql_query($query_DevType, $swmisconn) or die(mysql_error());
$row_DevType = mysql_fetch_assoc($DevType);
$totalRows_DevType = mysql_num_rows($DevType);
?>
<?php mysql_select_db($database_swmisconn, $swmisconn);
$query_DevPriority = "SELECT name FROM dropdownlist WHERE list = 'DevPriority' ORDER BY seq ASC";
$DevPriority = mysql_query($query_DevPriority, $swmisconn) or die(mysql_error());
$row_DevPriority = mysql_fetch_assoc($DevPriority);
$totalRows_DevPriority = mysql_num_rows($DevPriority);
?>
<?php mysql_select_db($database_swmisconn, $swmisconn);
$query_DevStatus = "SELECT name FROM dropdownlist WHERE list = 'DevStatus' ORDER BY seq ASC";
$DevStatus = mysql_query($query_DevStatus, $swmisconn) or die(mysql_error());
$row_DevStatus = mysql_fetch_assoc($DevStatus);
$totalRows_DevStatus = mysql_num_rows($DevStatus);
?>
<?php mysql_select_db($database_swmisconn, $swmisconn);
$query_User = "SELECT u.userid FROM users u join user_role ur on u.id = ur.userid WHERE ur.roleid = '1' ORDER BY u.userid ASC";
$User = mysql_query($query_User, $swmisconn) or die(mysql_error());
$row_User = mysql_fetch_assoc($User);
$totalRows_User = mysql_num_rows($User);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Dev Tracking</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
   var win_position = ',left=100,top=600,screenX=100,screenY=600';
   var newWindow = window.open(theURL,winName,features+win_position);
   newWindow.focus();
}
//-->
</script>
</head>

<body>

<table width="50%" border="1" align="center" cellpadding="1" cellspacing="1">
<form name="form1" action="<?php echo $editFormAction; ?>" method="POST">  <tr>
    <td colspan="4"><div align="center" class="BlueBold_20"><span class="BlueBold_20">Edit SWMIS </span>Development Tracking </div></td>
    </tr>
  <tr>
    <td><div align="right">Summary</div></td>
    <td colspan="3"><textarea name="summary" cols="100" rows="5" id="summary"><?php echo $row_DEVLIST['Summary']; ?></textarea></td>
  </tr>
  <tr>
    <td><div align="right">AssignTo</div></td>
    <td><select name="assignto">
      <option value="Select" <?php if (!(strcmp("Select", $row_DEVLIST['AssignedTo']))) {echo "selected=\"selected\"";} ?>>Select</option>
      <?php
do {  
?>
      <option value="<?php echo $row_User['userid']?>"<?php if (!(strcmp($row_User['userid'], $row_DEVLIST['AssignedTo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_User['userid']?></option>
      <?php
} while ($row_User = mysql_fetch_assoc($User));
  $rows = mysql_num_rows($User);
  if($rows > 0) {
      mysql_data_seek($User, 0);
	  $row_User = mysql_fetch_assoc($User);
  }
?>
    </select></td>
    <td><div align="right">Status</div></td>
    <td><select name="status">
      <option value="Select" <?php if (!(strcmp("Select", $row_DEVLIST['Status']))) {echo "selected=\"selected\"";} ?>>Select</option>
      <?php
do {  
?>
      <option value="<?php echo $row_DevStatus['name']?>"<?php if (!(strcmp($row_DevStatus['name'], $row_DEVLIST['Status']))) {echo "selected=\"selected\"";} ?>><?php echo $row_DevStatus['name']?></option>
      <?php
} while ($row_DevStatus = mysql_fetch_assoc($DevStatus));
  $rows = mysql_num_rows($DevStatus);
  if($rows > 0) {
      mysql_data_seek($DevStatus, 0);
	  $row_DevStatus = mysql_fetch_assoc($DevStatus);
  }
?>
    </select></td>
  </tr>
  <tr>
    <td><div align="right">Dev Type</div></td>
    <td><select name="devtype">
      <option value="Select" <?php if (!(strcmp("Select", $row_DEVLIST['DevType']))) {echo "selected=\"selected\"";} ?>>Select</option>
      <?php
do {  
?>
      <option value="<?php echo $row_DevType['name']?>"<?php if (!(strcmp($row_DevType['name'], $row_DEVLIST['DevType']))) {echo "selected=\"selected\"";} ?>><?php echo $row_DevType['name']?></option>
      <?php
} while ($row_DevType = mysql_fetch_assoc($DevType));
  $rows = mysql_num_rows($DevType);
  if($rows > 0) {
      mysql_data_seek($DevType, 0);
	  $row_DevType = mysql_fetch_assoc($DevType);
  }
?>
    </select></td>
    <td><div align="right">EstHrs</div></td>
    <td><input name="esthrs" type="text" id="esthrs" value="<?php echo $row_DEVLIST['EstHrs']; ?>" size="5" maxlength="10" /></td>
  </tr>
  <tr>
    <td><div align="right">Priority</div></td>
    <td><select name="priority">
      <option value="Select" <?php if (!(strcmp("Select", $row_DEVLIST['Priority']))) {echo "selected=\"selected\"";} ?>>Select</option>
      <?php
do {  
?>
      <option value="<?php echo $row_DevPriority['name']?>"<?php if (!(strcmp($row_DevPriority['name'], $row_DEVLIST['Priority']))) {echo "selected=\"selected\"";} ?>><?php echo $row_DevPriority['name']?></option>
      <?php
} while ($row_DevPriority = mysql_fetch_assoc($DevPriority));
  $rows = mysql_num_rows($DevPriority);
  if($rows > 0) {
      mysql_data_seek($DevPriority, 0);
	  $row_DevPriority = mysql_fetch_assoc($DevPriority);
  }
?>
    </select></td>
    <td><div align="right">ActHrs</div></td>
    <td><input name="acthrs" type="text" id="acthrs" value="<?php echo $row_DEVLIST['ActHrs']; ?>" size="5" maxlength="10" /></td>
  </tr>
  <tr>
    <td><div align="right">Description</div></td>
    <td colspan="3"><textarea name="descr" cols="100" rows="10" id="descr"><?php echo $row_DEVLIST['Description']; ?></textarea></td>
  </tr>
  <tr>
    <td nowrap="nowrap">ID: <?php echo $row_DEVLIST['id']; ?></td>
    <td nowrap="nowrap"> <a href="DevTrackSum.php">Close </a></td>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="EDIT" />
      <input type="hidden" name="id" value="<?php echo $row_DEVLIST['id']; ?>" />
      <input type="hidden" name="entryby" Value = "<?php echo $_SESSION['user']; ?>"/>
      <input type="hidden" name="entrydt" Value = "<?php echo date("Y-m-d H:i"); ?>" /></td>
  </tr>
  <input type="hidden" name="MM_update" value="form1">
</form>
<!--************ Comments *********************************************-->
<tr>
    <td valign="top"><div align="right"><strong>Comments</strong></div>
    				<div align="center" class="navLink"><a href="javascript:void(0)" onclick="MM_openBrWindow('DevCommAdd.php?id=<?php echo $row_DEVLIST['id']; ?>','StatusView','scrollbars=yes,resizable=yes,width=600,height=300')">ADD</a></div>
	</td>

<td>
 
     <table>
<?php
mysql_select_db($database_swmisconn, $swmisconn);
$query_source = "Select id, comments, entryby, entrydt from develcomnts where devdocid =  '".$row_DEVLIST['id']."'";
$source = mysql_query($query_source, $swmisconn) or die(mysql_error());
$row_source = mysql_fetch_assoc($source);
$totalRows_source = mysql_num_rows($source);
?>
<?php do {   ?>
        <tr>
          <td><a href="DevCommAdd.php"><a href="javascript:void(0)" onclick="MM_openBrWindow('DevCommEdit.php?id=<?php echo $row_source['id'] ?>','StatusView','scrollbars=yes,resizable=yes,width=600,height=300')"><?php echo $row_source['entrydt'].':'.$row_source['entryby']; ?></a></td>
          <td><?php echo $row_source['comments']; ?></td>
        </tr>
        <?php } while ($row_source = mysql_fetch_assoc($source)); ?>
      </table>
    </div></td>
  </tr>
  <?php //}?>
  <?php //} while ($row_DevSumList = mysql_fetch_assoc($DevSumList)); ?>
</table>


</td>
</tr>
<!--************ End Comments *********************************************-->

</table>

</body>
</html>
<?php
mysql_free_result($DEVLIST);
?>
