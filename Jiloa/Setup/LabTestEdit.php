<?php require_once('../../Connections/swmisconn.php'); ?><?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

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
  $updateSQL = sprintf("UPDATE tests SET feeid1=%s, feeid2=%s, feeid3=%s, feeid4=%s, feeid5=%s, feeid6=%s, feeid7=%s, feeid8=%s, feeid9=%s, feeid0=%s, test=%s, description=%s, formtype=%s, ddl=%s, units=%s, reportseq=%s, flag1=%s, active=%s, entryby=%s, entrydt=%s WHERE id=%s",
                       GetSQLValueString($_POST['feeid1'], "int"),
                       GetSQLValueString($_POST['feeid2'], "int"),
                       GetSQLValueString($_POST['feeid3'], "int"),
                       GetSQLValueString($_POST['feeid4'], "int"),
                       GetSQLValueString($_POST['feeid5'], "int"),
                       GetSQLValueString($_POST['feeid6'], "int"),
                       GetSQLValueString($_POST['feeid7'], "int"),
                       GetSQLValueString($_POST['feeid8'], "int"),
                       GetSQLValueString($_POST['feeid9'], "int"),
                       GetSQLValueString($_POST['feeid0'], "int"),
                       GetSQLValueString($_POST['test'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['formtype'], "text"),
                       GetSQLValueString($_POST['dropdownlist'], "text"),
                       GetSQLValueString($_POST['units'], "text"),
                       GetSQLValueString($_POST['reportseq'], "text"),
                       GetSQLValueString($_POST['flag1'], "text"),
                       GetSQLValueString($_POST['active'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($updateSQL, $swmisconn) or die(mysql_error());

  $updateGoTo = "LabTests.php";
//  if (isset($_SERVER['QUERY_STRING'])) {
//    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
//    $updateGoTo .= $_SERVER['QUERY_STRING'];
//  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_test = "-1";
if (isset($_GET['tid'])) {
  $colname_test = (get_magic_quotes_gpc()) ? $_GET['tid'] : addslashes($_GET['tid']);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_test = sprintf("SELECT id, feeid1, feeid2, feeid3, feeid4, feeid5, feeid6, feeid7, feeid8, feeid9, feeid0, test, description, formtype, ddl, units, reportseq, flag1, active, entryby, entrydt FROM tests WHERE id = %s", $colname_test);
$test = mysql_query($query_test, $swmisconn) or die(mysql_error());
$row_test = mysql_fetch_assoc($test);
$totalRows_test = mysql_num_rows($test);

mysql_select_db($database_swmisconn, $swmisconn);
$query_fee = "Select id, name from fee where dept = 'Laboratory' order by name";
$fee = mysql_query($query_fee, $swmisconn) or die(mysql_error());
$row_fee = mysql_fetch_assoc($fee);
$totalRows_fee = mysql_num_rows($fee);

mysql_select_db($database_swmisconn, $swmisconn);
$query_list = "Select distinct d.list from dropdownlist d order by list";
$list = mysql_query($query_list, $swmisconn) or die(mysql_error());
$row_list = mysql_fetch_assoc($list);
$totalRows_list = mysql_num_rows($list);


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
      <table width="100%"   bgcolor="#F8FDCE">
        <tr>
          <td>&nbsp;</td>
          <td colspan="3" class="subtitlebk">Edit Lab Test </td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">OrderName:</div></td>
          <td><select name="feeid1" id="feeid1">
		  <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fee['id']?>"<?php if (!(strcmp($row_fee['id'], $row_test['feeid1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fee['name']?></option>
            <?php
} while ($row_fee = mysql_fetch_assoc($fee));
  $rows = mysql_num_rows($fee);
  if($rows > 0) {
      mysql_data_seek($fee, 0);
	  $row_fee = mysql_fetch_assoc($fee);
  }
?>
                    </select></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">OrderName:</div></td>
          <td colspan="3"><select name="feeid2" id="feeid2">
            <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fee['id']?>"<?php if (!(strcmp($row_fee['id'], $row_test['feeid2']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fee['name']?></option>
            <?php
} while ($row_fee = mysql_fetch_assoc($fee));
  $rows = mysql_num_rows($fee);
  if($rows > 0) {
      mysql_data_seek($fee, 0);
	  $row_fee = mysql_fetch_assoc($fee);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">OrderName:</div></td>
          <td colspan="3"><select name="feeid3" id="feeid3">
            <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fee['id']?>"<?php if (!(strcmp($row_fee['id'], $row_test['feeid3']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fee['name']?></option>
            <?php
} while ($row_fee = mysql_fetch_assoc($fee));
  $rows = mysql_num_rows($fee);
  if($rows > 0) {
      mysql_data_seek($fee, 0);
	  $row_fee = mysql_fetch_assoc($fee);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">OrderName:</div></td>
          <td colspan="3"><select name="feeid4" id="feeid4">
            <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fee['id']?>"<?php if (!(strcmp($row_fee['id'], $row_test['feeid4']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fee['name']?></option>
            <?php
} while ($row_fee = mysql_fetch_assoc($fee));
  $rows = mysql_num_rows($fee);
  if($rows > 0) {
      mysql_data_seek($fee, 0);
	  $row_fee = mysql_fetch_assoc($fee);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">OrderName:</div></td>
          <td colspan="3"><select name="feeid5" id="feeid5">
            <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fee['id']?>"<?php if (!(strcmp($row_fee['id'], $row_test['feeid5']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fee['name']?></option>
            <?php
} while ($row_fee = mysql_fetch_assoc($fee));
  $rows = mysql_num_rows($fee);
  if($rows > 0) {
      mysql_data_seek($fee, 0);
	  $row_fee = mysql_fetch_assoc($fee);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">OrderName:</div></td>
          <td colspan="3"><select name="feeid6" id="feeid6">
            <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fee['id']?>"<?php if (!(strcmp($row_fee['id'], $row_test['feeid6']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fee['name']?></option>
            <?php
} while ($row_fee = mysql_fetch_assoc($fee));
  $rows = mysql_num_rows($fee);
  if($rows > 0) {
      mysql_data_seek($fee, 0);
	  $row_fee = mysql_fetch_assoc($fee);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">OrderName:</div></td>
          <td colspan="3"><select name="feeid7" id="feeid7">
            <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fee['id']?>"<?php if (!(strcmp($row_fee['id'], $row_test['feeid7']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fee['name']?></option>
            <?php
} while ($row_fee = mysql_fetch_assoc($fee));
  $rows = mysql_num_rows($fee);
  if($rows > 0) {
      mysql_data_seek($fee, 0);
	  $row_fee = mysql_fetch_assoc($fee);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">OrderName:</div></td>
          <td colspan="3"><select name="feeid8" id="feeid8">
            <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fee['id']?>"<?php if (!(strcmp($row_fee['id'], $row_test['feeid8']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fee['name']?></option>
            <?php
} while ($row_fee = mysql_fetch_assoc($fee));
  $rows = mysql_num_rows($fee);
  if($rows > 0) {
      mysql_data_seek($fee, 0);
	  $row_fee = mysql_fetch_assoc($fee);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">OrderName:</div></td>
          <td colspan="3"><select name="feeid9" id="feeid9">
            <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fee['id']?>"<?php if (!(strcmp($row_fee['id'], $row_test['feeid9']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fee['name']?></option>
            <?php
} while ($row_fee = mysql_fetch_assoc($fee));
  $rows = mysql_num_rows($fee);
  if($rows > 0) {
      mysql_data_seek($fee, 0);
	  $row_fee = mysql_fetch_assoc($fee);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">OrderName:</div></td>
          <td colspan="3"><select name="feeid0" id="feeid0">
            <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_fee['id']?>"<?php if (!(strcmp($row_fee['id'], $row_test['feeid0']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fee['name']?></option>
            <?php
} while ($row_fee = mysql_fetch_assoc($fee));
  $rows = mysql_num_rows($fee);
  if($rows > 0) {
      mysql_data_seek($fee, 0);
	  $row_fee = mysql_fetch_assoc($fee);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">Test:</div></td>
          <td colspan="3"><input name="test" type="text" id="test" value="<?php echo $row_test['test']; ?>" /></td>
        </tr>

        <tr>
          <td class="BlackBold_14"><div align="right">Description:</div></td>
          <td colspan="3"><textarea name="description" cols="50" rows="2" id="description" type="text" ><?php echo $row_test['description']; ?></textarea></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">ReportSeq:</div></td>
          <td colspan="3"><input name="reportseq" type="text" id="reportseq" value="<?php echo $row_test['reportseq']; ?>" size="5" /></td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">Units:</div></td>
          <td colspan="3"><input name="units"type="text"  id="units" value="<?php echo $row_test['units']; ?>"  size="30" maxlength="30"/>              </td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">FormType:</div></td>
          <td colspan="3"><select name="formtype" id="formtype">
            <option value="TextField" <?php if (!(strcmp("TextField", $row_test['formtype']))) {echo "selected=\"selected\"";} ?>>TextField</option>
            <option value="DropDown" <?php if (!(strcmp("DropDown", $row_test['formtype']))) {echo "selected=\"selected\"";} ?>>DropDown</option>
            </select>          </td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">DropDownList:</div></td>
          <td colspan="3"><select name="dropdownlist" id="dropdownlist">
		  <option value="">Select</option>
            <?php
do {  
?>
            <option value="<?php echo $row_list['list']?>"<?php if (!(strcmp($row_list['list'], $row_test['ddl']))) {echo "selected=\"selected\"";} ?>><?php echo $row_list['list']?></option>
            <?php
} while ($row_list = mysql_fetch_assoc($list));
  $rows = mysql_num_rows($list);
  if($rows > 0) {
      mysql_data_seek($list, 0);
	  $row_list = mysql_fetch_assoc($list);
  }
?>
          </select>          </td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">Flag1:</div></td>
          <td colspan="3"><select name="flag1" id="flag1">
            <option value="" <?php if (!(strcmp("", $row_test['flag1']))) {echo "selected=\"selected\"";} ?>>None</option>
            <option value="P" <?php if (!(strcmp("P", $row_test['flag1']))) {echo "selected=\"selected\"";} ?>>P</option>
            <option value="N" <?php if (!(strcmp("N", $row_test['flag1']))) {echo "selected=\"selected\"";} ?>>N</option>
          </select>
          Use only for antibiotics. </td>
        </tr>
        <tr>
          <td class="BlackBold_14"><div align="right">Active:</div></td>
          <td colspan="3"><select name="active" id="active">
            <option value="Y" <?php if (!(strcmp("Y", $row_test['active']))) {echo "selected=\"selected\"";} ?>>Y</option>
            <option value="N" <?php if (!(strcmp("N", $row_test['active']))) {echo "selected=\"selected\"";} ?>>N</option>
          </select></td>
        </tr>
        <tr>
          <td><a href="LabTests.php">Close </a>
		      <input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
              <input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i:s"); ?>;" /></td>
          <td colspan="3"><p>
              <input type="submit" name="Submit" value="Edit Lab Test" />
          </p></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1">
      <input name="id" type="hidden" id="id" value="<?php echo $row_test['id']; ?>" />
    </form>
    </td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($test);

mysql_free_result($fee);

mysql_free_result($list);
?>
