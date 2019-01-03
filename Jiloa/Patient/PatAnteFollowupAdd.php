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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formpafa")) {
  $insertSQL = sprintf("INSERT INTO anfollowup (medrecnum, visitid, pregid, hof, prespos, lie, fetalheart, bldpres, weight, oedema, foluptext, nextvisit, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "int"),
                       GetSQLValueString($_POST['visitid'], "int"),
                       GetSQLValueString($_POST['pregid'], "int"),
                       GetSQLValueString($_POST['hof'], "text"),
                       GetSQLValueString($_POST['prespos'], "text"),
                       GetSQLValueString($_POST['lie'], "text"),
                       GetSQLValueString($_POST['fetalheart'], "text"),
                       GetSQLValueString($_POST['bldpres'], "text"),
                       GetSQLValueString($_POST['weight'], "int"),
                       GetSQLValueString($_POST['oedema'], "text"),
                       GetSQLValueString($_POST['foluptext'], "text"),
                       GetSQLValueString($_POST['nextvisita'], "date"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());
  
     $insertGoTo = "PatShow1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= str_replace('&pge2=PatAnteFollowupAdd.php','',$_SERVER['QUERY_STRING']); // replace function takes &pge2=PatAnteFollowupAdd.php out of $_SERVER['QUERY_STRING'];     
  }
  header(sprintf("Location: %s", $insertGoTo));

}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
          $( "#nextvisita" ).datepicker();
       });
   </script>
    <link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form name="formpafa" id="formpafa" method="POST" action="<?php echo $editFormAction; ?>"><table width="80%">
<table cellpadding="0" cellspacing="0" bgcolor="#BCFACC">
  <tr>
    <td class="BlackBold_12"><div align="center">FOLLOW-<br />
      UP for<br />
      Preg.
      ID</div></td>
    <td class="BlackBold_12"><div align="center">Follow-<br />
      Up 
      Date</div></td>
    <td class="BlackBold_12"><div align="center"> Fundus<br />
    Height</div></td>
    <td class="BlackBold_12"><div align="center">Lie</div></td>
    <td class="BlackBold_12" title="LOA = Left Occipital Anterior &#10;ROA = Right Occipital Anterior &#10;LOT = Left Occipital Transvers&#10;ROT = Right Occipital Posterior &#10;LOP = Left Occipital Anterior &#10;ROP = Right Occipital Posterior &#10;LSA = Left Sacral Anterior &#10;RSA = Right Sacral Anterior"><div align="center">Presentation<br />
    and Position </div></td>
    <td class="BlackBold_12"><div align="center">Foetal<br />
    Heart Rate</div></td>
    <td class="BlackBold_12"><div align="center">Blood<br />Pressure</div></td>
    <td class="BlackBold_12"><div align="center">Weight</div></td>
    <td class="BlackBold_12"><div align="center">Oedema</div></td>
    <td class="BlackBold_12"><div align="center">Return</div></td>
    <td class="BlackBold_12">Examiner</td>
    <td><div align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePregView.php">Close</a></div></td>
  </tr>
    <tr>
      <td Title="MRNM: <?php echo $_SESSION['mrn']; ?>&#10;VisitID: <?php echo $_SESSION['vid']; ?>&#10;PregID: <?php echo $row_preg['id']; ?>">
	      <input name="pregid" type="text" id="pregid" size="5" maxlength="9" class="BlackBold_10"  value="<?php echo $row_preg['id']; ?>" />
	      <input name="visitid" type="hidden" id="visitid" size="5" maxlength="9" value="<?php echo $_SESSION['vid']; ?>" />
	      <input name="medrecnum" type="hidden" id="medrecnum" size="3" maxlength="9" value=" <?php echo $row_preg['medrecnum']; ?>" />		  </td>
      <td><input name="entrydt" type="text" id="entrydt" size="7" maxlength="12" class="BlackBold_10" value="<?php echo date("Y-m-d H:i"); ?>" /></td>

      <td align="center" valign="middle" nowrap="nowrap">      
      <input name="hof" type="text" id="hof" size="1" maxlength="3" style="text-align:center;" />
      <strong class="BlackBold_11">Cm</strong></td>

      <td align="center"><select name="lie" id="lie">
        <option value="">Select</option>
        <option value="Longitudinal">Longitudinal</option>
        <option value="Transverse">Transverse</option>
        <option value="Oblique">Oblique</option>
      </select>
      </td>
      <td title="LOA = Left Occipital Anterior &#10;ROA = Right Occipital Anterior &#10;LOT = Left Occipital Transvers&#10;ROT = Right Occipital Posterior &#10;LOP = Left Occipital Anterior &#10;ROP = Right Occipital Posterior &#10;LSA = Left Sacral Anterior &#10;RSA = Right Sacral Anterior" align="center"><select name="prespos" id="prespos">
        <option value="">Select</option>
        <option value="LOA">LOA</option>
        <option value="ROA">ROA</option>
        <option value="LOT">LOT</option>
        <option value="ROT">ROT</option>
        <option value="LOP">LOP</option>
        <option value="ROP">ROP</option>
        <option value="LSA">LSA</option>
        <option value="RSA">RSA</option>
      </select></td>

      <td align="center"><strong>
        <input name="fetalheart" id="fetalheart" size="1" maxlength="12"/>
      BPM
      </strong></td>

      <td align="center" nowrap="nowrap"><input name="bldpres" type="text" id="bldpres" size="4" maxlength="7" />
      <strong>      mm/Hg</strong></td>

      <td align="center" nowrap="nowrap"><input name="weight" type="text" id="weight" size="6" maxlength="12" />
        <strong>Kg</strong></td>

      <td align="center"><select name="oedema" id="oedema" type="text" size="1" maxlength="8" >
        <option value="">Select</option>
        <option value="0">0</option>
        <option value="+">+</option>
        <option value="++">++</option>
        <option value="+++">+++</option>
        <option value="++++">++++</option>
      </select></td>


      <td align="center"><input name="nextvisita" type="text" id="nextvisita" size="6" maxlength="12" /></td>

      <td align="center"><input name="entryby" type="text" class="BlackBold_10" id="entryby" value="<?php echo $_SESSION['user']; ?>" size="10" maxlength="30"/></td>
      <td><input type="submit" name="Submit" value="Add" /></td>
    </tr>
	<tr>
      <td class="BlackBold_12"><div align="center">Remarks</div></td>
      <td colspan="12"><textarea name="foluptext" cols="120" rows="1"></textarea></td>
	</tr>
</table>
<input type="hidden" name="MM_insert" value="formpafa">
</form>


</body>
</html>
