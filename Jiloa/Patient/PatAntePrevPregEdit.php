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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formpappe")) {

if(isset($_POST["dob"])) {
	      $_POST['dob'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['dob'])));
}

  $updateSQL = sprintf("UPDATE anprevpregs SET numbabies=%s, name=%s, pregdur=%s, dob=%s, tob=%s, labour=%s, apgar1=%s, apgar5=%s, birthweight=%s, gender=%s, babystatus=%s, ebl_ml=%s, cvx_per=%s, placenta=%s, entryby=%s, entrydt=%s WHERE id=%s",
                       GetSQLValueString($_POST['numbabies'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['pregdur'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['tob'], "text"),
                       GetSQLValueString($_POST['labour'], "text"),
                       GetSQLValueString($_POST['apgar1'], "int"),
                       GetSQLValueString($_POST['apgar5'], "int"),
                       GetSQLValueString($_POST['birthweight'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['babystatus'], "text"),
                       GetSQLValueString($_POST['ebl_ml'], "int"),
                       GetSQLValueString($_POST['cvx_per'], "text"),
                       GetSQLValueString($_POST['placenta'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($updateSQL, $swmisconn) or die(mysql_error());

  $updateGoTo = "PatShow1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
     $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
   $updateGoTo .= str_replace('pge=PatAntePrevPregEdit.php','pge=PatAntePrevPregView.php',$_SERVER['QUERY_STRING']); 
   }
  header(sprintf("Location: %s", $updateGoTo));
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
<title>Untitled Document</title>
    <link rel="stylesheet" href="../../jquery-ui-1.11.2.custom/jquery-ui.css" />   
	<script src="../../jquery-1.11.1.js"></script>
    <script src="../../jquery-ui-1.11.2.custom/jquery-ui.min.js"></script>
	<script>
	$(document).ready(function(){
    $.datepicker.setDefaults({ 
     dateFormat: 'yy-mm-dd'
    });
	 dateFormat: "yy-mm-dd";
          $( "#dob" ).datepicker();
       });
   </script>
    <link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="80%" bgcolor="#F8FDCE">
  <tr>
    <td>
	<form name="formpappe" id="formpappe" method="POST" action="<?php echo $editFormAction; ?>">
	<table width="100%" bgcolor="#F8FDCE">
	  <tr>
		<td nowrap="nowrap" class="Black_14"><div align="center">MRN</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_10">Preg<br />Record</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Number of<br />babies</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Baby's<br />Name:</div></td>
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
		<td valign="top"><select name="numbabies" id="numbabies" type="text" maxlength="5">
		  <option value=" ">Select</option>
		  <option value="Singleton" <?php if (!(strcmp("Singleton", $row_prevpreg['numbabies']))) {echo "selected=\"selected\"";} ?>>Singleton</option>
		  <option value="Twins" <?php if (!(strcmp("Twins", $row_prevpreg['numbabies']))) {echo "selected=\"selected\"";} ?>>Twins</option>
		  <option value="Triplets" <?php if (!(strcmp("Triplets", $row_prevpreg['numbabies']))) {echo "selected=\"selected\"";} ?>>Triplets</option>
		  <option value="Others" <?php if (!(strcmp("Others", $row_prevpreg['numbabies']))) {echo "selected=\"selected\"";} ?>>Others</option>
		</select>		</td>
		<td valign="top"><textarea name="name" id="name" cols="8" rows="2"><?php echo $row_prevpreg['name']; ?></textarea></td>
		<td valign="top"><Select name="pregdur" id="pregdur" size="1" type="number" maxlength="30" >
		  <option value="0">0</option>
			<?php for ($i=20; $i<=45; $i++) {  ?>
<!--		  <?php if (!(strcmp("Yes", $row_prevpreg['pregdur']))) {echo "selected=\"selected\"";} ?>  -->
            <option value="<?php echo $i;?>" <?php if (!(strcmp($i, $row_prevpreg['pregdur']))) {echo "selected=\"selected\"";} ?>  
><?php echo $i;?></option>
        <?php } ?>
      </Select></td>
		<td valign="top" nowrap="nowrap"><input name="dob" type="text" id="dob" value="<?php echo $row_prevpreg['dob']; ?>" style="font-size:12px;" size="7" maxlength="12" />
      <img src="../../jscalendar-1.0/img.gif" id="f_trigger_d" style="cursor: pointer; border: 1px solid red;" title="Date selector"
      onmouseover="this.style.background='red';" onmouseout="this.style.background=''" />
      </td>
		<td valign="top"><input name="tob" type="time" id="tob" value="<?php echo $row_prevpreg['tob']; ?>" size="5" maxlength="12" /></td>
		<td valign="top"><select name="labour" id="labour" maxlength="5">
		  <option value=" ">Select</option>
		  <option value="Normal/SVD" <?php if (!(strcmp("Normal/SVD", $row_prevpreg['labour']))) {echo "selected=\"selected\"";} ?>>Normal/SVD</option>
		  <option value="Breech/Extr"<?php if (!(strcmp("Breech/Extr", $row_prevpreg['labour']))) {echo "selected=\"selected\"";} ?>>Breech/Extr</option>
		  <option value="Vacuum"<?php if (!(strcmp("Vacuum", $row_prevpreg['labour']))) {echo "selected=\"selected\"";} ?>>Vacuum</option>
		  <option value="Emerg C/S"<?php if (!(strcmp("Emerg C/S", $row_prevpreg['labour']))) {echo "selected=\"selected\"";} ?>>Emerg C/S</option>
		  <option value="Elect C/S"<?php if (!(strcmp("Elect C/S", $row_prevpreg['labour']))) {echo "selected=\"selected\"";} ?>>Elect C/S</option>
		</select>		</td>
		<td valign="top"><Select name="apgar1" id="apgar1" type="number" value="<?php echo $row_prevpreg['apgar1']; ?>" size="1" maxlength="1" />
		  <option value="0">0</option>
			<?php for ($i=1; $i<=10; $i++) {  ?>
            <option value="<?php echo $i;?>" <?php if (!(strcmp($i, $row_prevpreg['apgar1']))) {echo "selected=\"selected\"";} ?>><?php echo $i;?></option>
         <?php } ?>
		</select>		</td>
		<td valign="top"><Select name="apgar5" id="apgar5" type="number" value="<?php echo $row_prevpreg['apgar5']; ?>" size="1" maxlength="1" />
		  <option value="0">0</option>
			<?php for ($i=1; $i<=10; $i++) {  ?>
            <option value="<?php echo $i;?>" <?php if (!(strcmp($i, $row_prevpreg['apgar5']))) {echo "selected=\"selected\"";} ?>><?php echo $i;?></option>
         <?php } ?>
		</select>		</td>
		<td valign="top" nowrap="nowrap"><input name="birthweight" type="text" id="birthweight" value="<?php echo $row_prevpreg['birthweight']; ?>" size="1" maxlength="3" />
		  kg</td>
		<td valign="top"><select name="gender" id="gender" type="text" maxlength="5">
		  <option value=" " <?php if (!(strcmp(" ", $row_prevpreg['gender']))) {echo "selected=\"selected\"";} ?>>Select</option>
		  <option value="M" <?php if (!(strcmp("M", $row_prevpreg['gender']))) {echo "selected=\"selected\"";} ?>>Male</option>
		  <option value="F" <?php if (!(strcmp("F", $row_prevpreg['gender']))) {echo "selected=\"selected\"";} ?>>Female</option>
		</select>		</td>
		<td valign="top"><select name="babystatus" id="babystatus" type="text" maxlength="5">
		  <option value=" " <?php if (!(strcmp(" ", $row_prevpreg['babystatus']))) {echo "selected=\"selected\"";} ?>>Select</option>
		  <option value="Alive" <?php if (!(strcmp("Alive", $row_prevpreg['babystatus']))) {echo "selected=\"selected\"";} ?>>Alive</option>
		  <option value="FSB" <?php if (!(strcmp("FSB", $row_prevpreg['babystatus']))) {echo "selected=\"selected\"";} ?>>FSB</option>
		  <option value="MSB" <?php if (!(strcmp("MSB", $row_prevpreg['babystatus']))) {echo "selected=\"selected\"";} ?>>MSB</option>
		  <option value="INND" <?php if (!(strcmp("INND", $row_prevpreg['babystatus']))) {echo "selected=\"selected\"";} ?>>INND</option>
		</select>		</td>
		<td valign="top"><input name="ebl_ml" id="ebl_ml" type="text" value="<?php echo $row_prevpreg['ebl_ml']; ?>" size="3" maxlength="5"/>     </td>
		<td valign="top"><select name="cvx_per" id="cvx_per" type="text" maxlength="14">
		  <option value=" " <?php if (!(strcmp(" ", $row_prevpreg['cvx_per']))) {echo "selected=\"selected\"";} ?>>Select</option>
		  <option value="Intact" <?php if (!(strcmp("Intact", $row_prevpreg['cvx_per']))) {echo "selected=\"selected\"";} ?>>Intact</option>
		  <option value="1*laceration" <?php if (!(strcmp("1*laceration", $row_prevpreg['cvx_per']))) {echo "selected=\"selected\"";} ?>>1*laceration</option>
		  <option value="2*laceration" <?php if (!(strcmp("2*laceration", $row_prevpreg['cvx_per']))) {echo "selected=\"selected\"";} ?>>2*laceration</option>
		  <option value="3*laceration" <?php if (!(strcmp("3*laceration", $row_prevpreg['cvx_per']))) {echo "selected=\"selected\"";} ?>>3*laceration</option>
		</select>		</td>
		<td valign="top"><select name="placenta" id="placenta" type="text" maxlength="5">
		  <option value=" " <?php if (!(strcmp(" ", $row_prevpreg['placenta']))) {echo "selected=\"selected\"";} ?>>Select</option>
		  <option value="Complete" <?php if (!(strcmp("Complete", $row_prevpreg['placenta']))) {echo "selected=\"selected\"";} ?>>Complete</option>
		  <option value="Incomplete" <?php if (!(strcmp("Incomplete", $row_prevpreg['placenta']))) {echo "selected=\"selected\"";} ?>>Incomplete</option>
		</select>		</td>

		<td><input type="submit" name="Submit" value="Edit" />
		        <input type="hidden" name="id" id="id" value="<?php echo $row_prevpreg['id']; ?>"/>
	  			<input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
	  			<input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i"); ?>" />
	  	</td>
	  </tr>
	</table>
	<input type="hidden" name="MM_update" value="formpappe">
	</form>
	</td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($prevpreg);
?>
