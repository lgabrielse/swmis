<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

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
  $updateSQL = sprintf("UPDATE roles SET role=%s, descr=%s, active=%s WHERE id=%s",
                       GetSQLValueString($_POST['role'], "text"),
                       GetSQLValueString($_POST['descr'], "text"),
                       GetSQLValueString($_POST['active'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($updateSQL, $swmisconn) or die(mysql_error());

  $updateGoTo = "RoleMenu.php";
  header(sprintf("Location: %s", $updateGoTo));
}

$MMID_EDIT = "1";
if (isset($_GET["id"])) {
  $MMID_EDIT = (get_magic_quotes_gpc()) ? $_GET["id"] : addslashes($_GET["id"]);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_EDIT = sprintf("SELECT id, role, descr, active FROM roles WHERE id = %s", $MMID_EDIT);
$EDIT = mysql_query($query_EDIT, $swmisconn) or die(mysql_error());
$row_EDIT = mysql_fetch_assoc($EDIT);
$totalRows_EDIT = mysql_num_rows($EDIT);
?>

<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css">


<table width="50%" border="1">
  <tr>
		<td valign="top">
      <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
		  <table width="100%"  bgcolor="#F8FDCE">
		  <caption class="subtitle">
			Edit Role 
		  </caption>
			  <tr>
				<td align="right">Role ID</td>
				<td><input name="role" type="text" id="role" value="<?php echo $row_EDIT['role']; ?>" /></td>
			  </tr>
			  <tr>
				<td align="right">Description </td>
				<td><input name="descr" type="text" id="descr" value="<?php echo $row_EDIT['descr']; ?>" /></td>
			  </tr>
			  <tr>
				<td align="right">Active</td>
				<td><select name="active" id="active">
				  <option value="Y" <?php if (!(strcmp("Y", $row_EDIT['active']))) {echo "selected=\"selected\"";} ?>>Y</option>
				  <option value="N" <?php if (!(strcmp("N", $row_EDIT['active']))) {echo "selected=\"selected\"";} ?>>N</option>
				  </select></td>
			  </tr>
			  <tr>
				<td><a href="RoleMenu.php">Close</a>
				  <input type="hidden" name="id" value="<?php echo $row_EDIT['id']; ?>">
				  <input type="hidden" name="MM_update" value="form1"></td><td><input type="submit" name="Submit" value="Edit Role" /></td>
			  </tr>
		</table>   
      </form>	</td>
  </tr>
</table>

<br />
<?php
mysql_free_result($EDIT);
?>