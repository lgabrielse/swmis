<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php //require_once('../../Connections/swmisconn.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formpaea")) {
  $updateSQL = sprintf("UPDATE anfollowup SET medrecnum=%s, visitid=%s, pregid=%s, hof=%s, prespos=%s, lie=%s, fetalheart=%s, bldpres=%s, weight=%s, oedema=%s, foluptext=%s, nextvisit=%s, entryby=%s, entrydt=%s WHERE id=%s",
                       GetSQLValueString($_POST['medrecnum'], "int"),
                       GetSQLValueString($_POST['visitid'], "int"),
                       GetSQLValueString($_POST['pregid'], "int"),
                       GetSQLValueString($_POST['hof'], "text"),
                       GetSQLValueString($_POST['prespos'], "text"),
                       GetSQLValueString($_POST['lie'], "text"),
                       GetSQLValueString($_POST['fetalheart'], "text"),
                       GetSQLValueString($_POST['bldpres'], "text"),
                       GetSQLValueString($_POST['weight'], "text"),
                       GetSQLValueString($_POST['oedema'], "text"),
                       GetSQLValueString($_POST['foluptext'], "text"),
                       GetSQLValueString($_POST['nextvisite'], "date"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($updateSQL, $swmisconn) or die(mysql_error());

    $insertGoTo = "PatShow1.php";
      if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $insertGoTo .= str_replace('&pge2=PatAnteFollowupEdit.php','',$_SERVER['QUERY_STRING']); // replace function takes &pge2=PatAnteFollowupEdit.php out of $_SERVER['QUERY_STRING'];     
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?><?php //require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php
$colname_folup = "-1";
if (isset($_GET['id'])) {
  $colname_folup = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_folup = sprintf("SELECT id, medrecnum, visitid, pregid, hof, prespos, lie, fetalheart, bldpres, weight, oedema, foluptext, nextvisit, entryby, entrydt FROM anfollowup WHERE id = %s", $colname_folup);
$folup = mysql_query($query_folup, $swmisconn) or die(mysql_error());
$row_folup = mysql_fetch_assoc($folup);
$totalRows_folup = mysql_num_rows($folup);
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
          $( "#nextvisite" ).datepicker();
       });
   </script>
    <link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form name="formpaea" id="formpafe" method="POST" action="<?php echo $editFormAction; ?>">

<table cellpadding="0" cellspacing="0" bgcolor="#F8FDCE">
  <tr>
    <td width="88" class="BlackBold_12"><div align="center">Edit<br />
      PregID,<br />
    FIUD</div></td>
    <td width="42" class="BlackBold_12"><div align="center">Date</div></td>
    <td width="76" class="BlackBold_12"><div align="center"> Fundus<br />
    Height</div></td>
    <td width="157" class="BlackBold_12"><div align="center">Lie</div></td>
    <td width="87" class="BlackBold_12" title="LOA = Left Occipital Anterior &#10;ROA = Right Occipital Anterior &#10;LOT = Left Occipital Transvers&#10;ROT = Right Occipital Posterior &#10;LOP = Left Occipital Anterior &#10;ROP = Right Occipital Posterior &#10;LSA = Left Sacral Anterior &#10;RSA = Right Sacral Anterior"><div align="center">Presentation<br />
    and Position </div></td>
    <td width="138" class="BlackBold_12"><div align="center">Foetal<br />
    Heart Rate</div></td>
    <td width="43" class="BlackBold_12"><div align="center">B/P</div></td>
    <td width="57" class="BlackBold_12"><div align="center">Weight</div></td>
    <td width="115" class="BlackBold_12"><div align="center">Oedema</div></td>
    <td width="45" class="BlackBold_12"><div align="center">Return</div></td>
    <td width="64" class="BlackBold_12">Examiner</td>
    <td width="50"><div align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePregView.php">Close</a></div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td Title="MRN: <?php echo $row_folup['medrecnum']; ?>&#10;VisitID: <?php echo $row_folup['visitid']; ?>&#10;PregID: <?php echo $row_folup['pregid']; ?>">
	      <input name="pregid" type="text" id="pregid" size="5" maxlength="9" class="BlackBold_10"  value="<?php echo $row_folup['pregid']; ?>, <?php echo $row_folup['id']; ?>" />
	      <input name="visitid" type="hidden" id="visitid" value="<?php echo $row_folup['visitid']; ?>" />
	      <input name="medrecnum" type="hidden" id="medrecnum" value="<?php echo $row_folup['medrecnum']; ?>" />
		  <input name="id" type="hidden" id="id" value="<?php echo $row_folup['id']; ?>"/>		  </td>
      <td><div align="center">
        <input name="entrydt" type="text" id="entrydt" size="7" maxlength="12" class="BlackBold_10" value="<?php echo date("Y-m-d H:i"); ?>" />
      </div></td>

      <td nowrap="nowrap"><div align="center">
        <input name="hof" type="text" id="hof" size="1" maxlength="3" style: align="middle" value="<?php echo $row_folup['hof']; ?>" />
        <strong>Cm</strong></div></td>

      <td><div align="center">
        <select name="lie" id="lie">
          <option value="None">None</option>
          <option value="Longitudinal" <?php if (!(strcmp("Longitudinal", $row_folup['lie']))) {echo "selected=\"selected\"";} ?>>Longitudinal</option>
          <option value="Transverse" <?php if (!(strcmp("Transverse", $row_folup['lie']))) {echo "selected=\"selected\"";} ?>>Transverse</option>
          <option value="Oblique" <?php if (!(strcmp("Oblique", $row_folup['lie']))) {echo "selected=\"selected\"";} ?>>Oblique</option>
        </select>
        </div></td>
      <td title="LOA = Left Occipital Anterior &#10;ROA = Right Occipital Anterior &#10;LOT = Left Occipital Transvers&#10;ROT = Right Occipital Posterior &#10;LOP = Left Occipital Anterior &#10;ROP = Right Occipital Posterior &#10;LSA = Left Sacral Anterior &#10;RSA = Right Sacral Anterior"><div align="center">
        <select name="prespos" id="prespos">
          <option value="LOA" <?php if (!(strcmp("LOA", $row_folup['prespos']))) {echo "selected=\"selected\"";} ?>>LOA</option>
          <option value="ROA" <?php if (!(strcmp("ROA", $row_folup['prespos']))) {echo "selected=\"selected\"";} ?>>ROA</option>
          <option value="LOT" <?php if (!(strcmp("LOT", $row_folup['prespos']))) {echo "selected=\"selected\"";} ?>>LOT</option>
          <option value="ROT" <?php if (!(strcmp("ROT", $row_folup['prespos']))) {echo "selected=\"selected\"";} ?>>ROT</option>
          <option value="LOP" <?php if (!(strcmp("LOP", $row_folup['prespos']))) {echo "selected=\"selected\"";} ?>>LOP</option>
          <option value="ROP" <?php if (!(strcmp("ROP", $row_folup['prespos']))) {echo "selected=\"selected\"";} ?>>ROP</option>
          <option value="LSA" <?php if (!(strcmp("LSA", $row_folup['prespos']))) {echo "selected=\"selected\"";} ?>>LSA</option>
          <option value="RSA" <?php if (!(strcmp("RSA", $row_folup['prespos']))) {echo "selected=\"selected\"";} ?>>RSA</option>
          <?php
do {  
?>
          <?php
} while ($row_folup = mysql_fetch_assoc($folup));
  $rows = mysql_num_rows($folup);
  if($rows > 0) {
      mysql_data_seek($folup, 0);
	  $row_folup = mysql_fetch_assoc($folup);
  }
?>
        </select>
      </div></td>

      <td nowrap="nowrap"><div align="center">
		<input name="fetalheart" type="text" id="fetalheart" size="1" maxlength="3" value="<?php echo $row_folup['fetalheart'];?>" />
		<strong>		BPM</strong></td>
      <td nowrap="nowrap"><div align="center">
        <input name="bldpres" type="text" id="bldpres" size="4" maxlength="7" style: align="middle" value="<?php echo $row_folup['bldpres']; ?>" />
		<strong>mm/Hg</strong></div></td>
      
        
      <td nowrap="nowrap"><div align="center">
        <input name="weight" type="text" id="weight" size="2" maxlength="3" style: align="middle" value="<?php echo $row_folup['weight']; ?>" />
        <strong>      Kg</strong></div></td>

      <td><div align="center">
        <select name="oedema" id="oedema" type="text" >
          <option value="0" <?php if (!(strcmp("0", $row_folup['oedema']))) {echo "selected=\"selected\"";} ?>>0</option>
          <option value="+" <?php if (!(strcmp("+", $row_folup['oedema']))) {echo "selected=\"selected\"";} ?>>+</option>
          <option value="++" <?php if (!(strcmp("++", $row_folup['oedema']))) {echo "selected=\"selected\"";} ?>>++</option>
          <option value="+++" <?php if (!(strcmp("+++", $row_folup['oedema']))) {echo "selected=\"selected\"";} ?>>+++</option>
          <option value="++++" <?php if (!(strcmp("++++", $row_folup['oedema']))) {echo "selected=\"selected\"";} ?>>++++</option>
          <?php
do {  
?>
          <?php
} while ($row_folup = mysql_fetch_assoc($folup));
  $rows = mysql_num_rows($folup);
  if($rows > 0) {
      mysql_data_seek($folup, 0);
	  $row_folup = mysql_fetch_assoc($folup);
  }
?>
        </select>
      </div></td>

      <td><div align="center">
        <input name="nextvisite" type="text" id="nextvisite" size="6" maxlength="12" class="BlackBold_10" value="<?php echo $row_folup['nextvisit']; ?>" />
      </div></td>

      <td><div align="center">
        <input name="entryby" type="text" id="entryby" size="6" maxlength="12" class="BlackBold_10" readonly="readonly" value="<?php echo $_SESSION['user']; ?>" />
      </div></td>
      <td><div align="center">
        <input type="submit" name="Submit" value="Edit" />
      </div></td>
    </tr>
	<tr>
		<td>Remarks</td>
        <td colspan="12" bgcolor="#FFE4E1"><textarea name="foluptext" cols="120" rows="2"><?php echo $row_folup['foluptext']; ?></textarea></td>
	</tr>
	
    <?php } while ($row_folup = mysql_fetch_assoc($folup)); ?>
</table>
<input type="hidden" name="MM_update" value="formpaea">
</form>
</body>
</html>
<?php
mysql_free_result($folup);
?>
