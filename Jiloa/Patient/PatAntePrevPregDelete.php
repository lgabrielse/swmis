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

if ((isset($_POST['id'])) && ($_POST['id'] != "" &&  isset($_POST["MM_delete"])) && ($_POST["MM_delete"] == "formpappd")) {
  $deleteSQL = sprintf("DELETE FROM anprevpregs WHERE id=%s",
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($deleteSQL, $swmisconn) or die(mysql_error());

  $deleteGoTo = "PatShow1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= str_replace('pge=PatAntePrevPregDelete.php','pge=PatAntePrevPregView.php',$_SERVER['QUERY_STRING']);
  }
  header(sprintf("Location: %s", $deleteGoTo));
}


$colname_prevpreg = "-1";
if (isset($_GET['prevpregid'])) {
  $colname_prevpreg = (get_magic_quotes_gpc()) ? $_GET['prevpregid'] : addslashes($_GET['prevpregid']);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_prevpreg = sprintf("SELECT id, medrecnum, pregid, numbabies, name, pregdur, DATE_FORMAT(dob,'%%b %%d, %%Y') dob, tob, labour, apgar1, apgar5, birthweight, babystatus, gender, babystatus, ebl_ml, cvx_per, placenta, entryby, entrydt FROM anprevpregs WHERE id = %s", $colname_prevpreg);
$prevpreg = mysql_query($query_prevpreg, $swmisconn) or die(mysql_error());
$row_prevpreg = mysql_fetch_assoc($prevpreg);
$totalRows_prevpreg = mysql_num_rows($prevpreg);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prev Preg Delete</title>
    <link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="80%" bgcolor="#FBD0D7">
  <tr>
    <td>
	<form name="formpappd" id="formpappd" method="POST" action="">
	<table width="100%" bgcolor="#FBD0D7">
	  <tr>
		<td nowrap="nowrap" class="Black_14"><div align="center">MRN</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_10">Preg<br />Record</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Number of<br />babies</div></td>

		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Baby's<br />
		  Name:</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Preg<br />Duration</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">DOB</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">TOB</div></td>
		<td nowrap="NOWRAP" class="Black_14"><div align="center">Labour</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">APGAR<br />1</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">APGAR<br />5</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Birth<br />Weight</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Gen<br />der</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Baby<br />Status</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Blood<br />loss ml</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Cervix<br />peritinium</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Placenta</div></td>
		<td><div align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePregView.php">Close</a></div></td>
	  </tr>
	  <tr>
		<td title="Last Entry By: <?php echo $row_prevpreg['entryby']; ?>&10#;Last Entry Date: <?php echo $row_prevpreg['entrydt']; ?>"><input name="medrecnum" type="text" id="medrecnum" size="5" maxlength="9" readonly="readonly" value="<?php echo $_SESSION['mrn'] ?>" /></td>
		<td><input name="pregid" type="text" id="pregid" value="<?php echo $row_prevpreg['pregid']; ?>" size="5" maxlength="9" readonly="readonly"/></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['numbabies']; ?></td>
		<td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_prevpreg['name']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['pregdur']; ?></td>
		<td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_prevpreg['dob']; ?></td>
		<td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_prevpreg['tob']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['labour']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['apgar1']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['apgar5']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['birthweight']; ?>kg</td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['gender']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['babystatus']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['ebl_ml']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['cvx_per']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['placenta']; ?></td>
		<td><input type="submit" name="Submit" value="Delete" />
		        <input type="hidden" name="id" id="id" value="<?php echo $row_prevpreg['id']; ?>"/>
	  			<input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
	  			<input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i"); ?>" />
				<input type="hidden" name="MM_delete" value="formpappd">
	  	</td>
	  </tr>
	</table>
	</form>
	</td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($prevpreg);
?>
