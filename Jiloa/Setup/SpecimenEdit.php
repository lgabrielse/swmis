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
  $updateSQL = sprintf("UPDATE specimens SET name=%s, method=%s, container=%s, minvolume=%s, preservative=%s, viablelimit=%s, storage=%s, instructions=%s, entryby=%s, entrydt=%s WHERE id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['method'], "text"),
                       GetSQLValueString($_POST['container'], "text"),
                       GetSQLValueString($_POST['minvolume'], "text"),
                       GetSQLValueString($_POST['preservative'], "text"),
                       GetSQLValueString($_POST['viablelimit'], "text"),
                       GetSQLValueString($_POST['storage'], "text"),
                       GetSQLValueString($_POST['instructions'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($updateSQL, $swmisconn) or die(mysql_error());

  $updateGoTo = "Specimens.php";
//  if (isset($_SERVER['QUERY_STRING'])) {
//    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
//    $updateGoTo .= $_SERVER['QUERY_STRING'];
//  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_spec = "-1";
if (isset($_GET['id'])) {
  $colname_spec = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_spec = sprintf("SELECT id, name, method, container, minvolume, preservative, viablelimit, storage, instructions FROM specimens WHERE id = %s", $colname_spec);
$spec = mysql_query($query_spec, $swmisconn) or die(mysql_error());
$row_spec = mysql_fetch_assoc($spec);
$totalRows_spec = mysql_num_rows($spec);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Fee Schedule</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>


<table width="50%" align="center">
  <tr>
    <td><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
      <table width="100%"  bgcolor="#F8FDCE">
        <tr>
          <td>&nbsp;</td>
          <td class="subtitlebk">Edit Specimen </td>
        </tr>

        <tr bgcolor="#F8FDCE">
          <td class="BlackBold_14"><div align="right">Name:</div></td>
          <td><input name="name" type="text" id="name" value="<?php echo $row_spec['name']; ?>" /></td>
        </tr>
        <tr bgcolor="#F8FDCE">
          <td class="BlackBold_14"><div align="right">Method:</div></td>
          <td><input name="method" type="text" id="method" value="<?php echo $row_spec['method']; ?>" /></td>
        </tr>
        <tr bgcolor="#F8FDCE">
          <td class="BlackBold_14"><div align="right">Container:</div></td>
          <td><input name="container" type="text" id="container" value="<?php echo $row_spec['container']; ?>" /></td>
        </tr>
        <tr bgcolor="#F8FDCE">
          <td class="BlackBold_14"><div align="right">Minvolume:</div></td>
          <td><input name="minvolume" type="text" id="minvolume" value="<?php echo $row_spec['minvolume']; ?>" /></td>
        </tr>
        <tr bgcolor="#F8FDCE">
          <td class="BlackBold_14"><div align="right">Preservative:</div></td>
          <td><input name="preservative"type="text"  id="preservative" value="<?php echo $row_spec['preservative']; ?>"  size="50" maxlength="50">
              </textarea></td>
        </tr>
        <tr bgcolor="#F8FDCE">
          <td class="BlackBold_14"><div align="right">ViableLimit:</div></td>
          <td><input name="viablelimit" type="text" id="viablelimit" value="<?php echo $row_spec['viablelimit']; ?>" /></td>
        </tr>
        <tr bgcolor="#F8FDCE">
          <td class="BlackBold_14"><div align="right">Storage:</div></td>
          <td><input name="storage" type="text" id="storage" value="<?php echo $row_spec['storage']; ?>" size="50" maxlength="50" /></td>
        </tr>
        <tr bgcolor="#F8FDCE">
          <td class="BlackBold_14"><div align="right">Instructions:</div></td>
          <td><textarea name="instructions" id="instructions"><?php echo $row_spec['instructions']; ?></textarea></td>
        </tr>
        
        <tr>
          <td><input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
            <input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i:s"); ?>" />
			<input name="id" type="hidden" value="<?php echo $row_spec['id']; ?>" /></td>

         <td><p>
            <input type="submit" name="Submit" value="Edit Specimen" />
          </p></td>
        </tr>
      </table>
        <input type="hidden" name="MM_update" value="form1">
    </form>
    </td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($spec);
?>
