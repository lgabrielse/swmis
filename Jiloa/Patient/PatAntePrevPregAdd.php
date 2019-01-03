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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formpappa")) {

if(isset($_POST["dob"])) {
	      $_POST['dob'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['dob'])));
}

  $insertSQL = sprintf("INSERT INTO anprevpregs (medrecnum, pregid, numbabies, name, pregdur, dob, tob, labour, apgar1, apgar5, birthweight, gender, babystatus, ebl_ml, cvx_per, placenta, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "int"),
                       GetSQLValueString($_POST['pregid'], "int"),
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
                       GetSQLValueString($_POST['entrydt'], "date"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());

    $insertGoTo = "PatShow1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= str_replace('PatAntePrevPregAdd.php','PatAntePrevPregView.php',$_SERVER['QUERY_STRING']); 
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
          $( "#dob" ).datepicker();
       });
   </script>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
	<style type="text/css">@import url(../../jscalendar-1.0/calendar-win2k-1.css);</style>
	<script type="text/javascript" src="../../jscalendar-1.0/calendar.js"></script>
	<script type="text/javascript" src="../../jscalendar-1.0/lang/calendar-en.js"></script>
	<script type="text/javascript" src="../../jscalendar-1.0/calendar-setup.js"></script>
</head>

<body>
<table width="80%" bgcolor="#BCFACC">
  <tr>
    <td>
	<form name="formpappa" id="formpappa" method="POST" action="<?php echo $editFormAction; ?>">
	<table width="100%" bgcolor="#BCFACC">
	  <tr>
		<td nowrap="nowrap" class="Black_14"><div align="center">MRN</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Preg<br />Rec</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Number of<br />babies</div></td>

		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Baby's<br />
		  Name(s):</div></td>
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
		<td valign="top"><input name="medrecnum" id="medrecnum" type="num" style="background-color:#e3f0f9" size="3" maxlength="9" readonly="readonly" value="<?php echo $_SESSION['mrn'] ?>" /></td>
		<td valign="top"><input name="pregid" id="pregid" type="num" style="background-color:#e3f0f9" size="2" maxlength="9" readonly="readonly" value="<?php echo $_GET['pregid'] ?>"/></td>
		<td valign="top"><select name="numbabies" id="numbabies" type="text" maxlength="5">
		  <option value=" ">Select</option>
		  <option value="Singleton">Singleton</option>
		  <option value="Twins">Twins</option>
		  <option value="Triplets">Triplets</option>
		  <option value="Others">Others</option>
		</select>		</td>
		<td valign="top"><textarea name="name" id="name" cols="8" rows="2"></textarea></td>
		<td valign="top"><Select name="pregdur" id="pregdur" size="1" type="number" maxlength="30" >
		  <option value="0">0</option>
			<?php for ($i=20; $i<=45; $i++) {  ?>
            <option value="<?php echo $i;?>"><?php echo $i;?></option>
        <?php } ?>
      </Select></td>
		<td valign="top" nowrap="nowrap"><input name="dob" type="text" id="dob" style="font-size:12px;" size="7" maxlength="12" />
      <img src="../../jscalendar-1.0/img.gif" id="f_trigger_d" style="cursor: pointer; border: 1px solid red;" title="Date selector"
      onmouseover="this.style.background='red';" onmouseout="this.style.background=''" />
      </td>
		<td valign="top"><input name="tob" type="time" id="tob" size="5" maxlength="12" /></td>
		<td valign="top"><select name="labour" id="labour" maxlength="5">
		  <option value=" ">Select</option>
		  <option value="Normal/SVD">Normal/SVD</option>
		  <option value="Breech/Extr">Breech/Extr</option>
		  <option value="Vacuum">Vacuum</option>
		  <option value="Emerg C/S">Emerg C/S</option>
		  <option value="Elect C/S">Elect C/S</option>
		</select>		</td>
		<td valign="top"><Select name="apgar1" id="apgar1" type="number" size="1" maxlength="1" />
		  <option value="0">0</option>
			<?php for ($i=1; $i<=10; $i++) {  ?>
            <option value="<?php echo $i;?>"><?php echo $i;?></option>
         <?php } ?>
		</select>		</td>
		<td valign="top"><Select name="apgar5" id="apgar5" type="number" size="1" maxlength="1" />
		  <option value="0">0</option>
			<?php for ($i=1; $i<=10; $i++) {  ?>
            <option value="<?php echo $i;?>"><?php echo $i;?></option>
         <?php } ?>
		</select>		</td>
		<td valign="top" nowrap="nowrap"><input name="birthweight" type="text" id="birthweight" size="1" maxlength="3" />
		  kg</td>
		<td valign="top"><select name="gender" id="gender" type="text" maxlength="5">
		  <option value=" ">Select</option>
		  <option value="M">Male</option>
		  <option value="F">Female</option>
		</select>		</td>
		<td valign="top"><select name="babystatus" id="babystatus" type="text" maxlength="5">
		  <option value=" ">Select</option>
		  <option value="Alive">Alive</option>
		  <option value="FSB">FSB</option>
		  <option value="MSB">MSB</option>
		  <option value="INND">INND</option>
		</select>		</td>
		<td valign="top"><input name="ebl_ml" id="ebl_ml" type="text" size="3" maxlength="5"/>     </td>
		<td valign="top"><select name="cvx_per" id="cvx_per" type="text" maxlength="14">
		  <option value=" ">Select</option>
		  <option value="Intact">Intact</option>&deg;
		  <option value="1*laceration">1*laceration</option>
		  <option value="2*laceration">2*laceration</option>
		  <option value="3*laceration">3*laceration</option>
		</select>		</td>
		<td valign="top"><select name="placenta" id="placenta" type="text" maxlength="5">
		  <option value=" ">Select</option>
		  <option value="Complete">Complete</option>
		  <option value="Incomplete">Incomplete</option>
		</select>		</td>
 
		<td valign="top"><input type="submit" name="Submit" value="Add" />
			<input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
	  		<input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i"); ?>" />
		</td>
	  </tr>
	</table>
	<input type="hidden" name="MM_insert" value="formpappa">
	</form>
	</td>
  </tr>
</table>

<script type="text/javascript">
	     Calendar.setup({
        inputField     :    "dob",     // id of the input field
        ifFormat       :    "%b %e,%Y",      // format of the input field
        button         :    "f_trigger_d",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
//        displayArea    :    "show_c",       // ID of the span where the date is to be shown
//        daFormat       :    "%b %e, %Y",// format of the displayed date
        singleClick    :    true
    });

</script>


</body>
</html>
