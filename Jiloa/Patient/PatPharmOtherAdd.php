<?php if (session_status() == PHP_SESSION_NONE) {
    session_start(); }?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php // require_once('../../Connections/swmisconn.php'); ?>
<?php // session_start()?>

<?php
if(!function_exists("GetSQLValueString")) {
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
}
  $saved = "";

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['SubmitAll']) AND isset($_POST['feeid']) AND $_POST['SubmitAll']  == 'Add Order')  {

mysql_select_db($database_swmisconn, $swmisconn);
$query_myfee = "Select fee from fee where id = ".$_POST['feeid']."";
$myfee = mysql_query($query_myfee, $swmisconn) or die(mysql_error());
$row_myfee = mysql_fetch_assoc($myfee);
$totalRows_myfee = mysql_num_rows($myfee);

  $insertSQL = sprintf("INSERT INTO orders (medrecnum, visitid, feeid, status, rate, ratereason, item, quant, ofee, urgency, doctor, comments, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "text"),
                       GetSQLValueString($_POST['visitid'], "int"),
                       GetSQLValueString($_POST['feeid'], "int"),
                       GetSQLValueString('RxOrdered', "text"),
                       GetSQLValueString($_POST['rate'], "int"),
                       GetSQLValueString($_POST['ratereason'], "int"),
                       GetSQLValueString($_POST['item'], "text"),
                       GetSQLValueString($_POST['quant'], "int"),
                       GetSQLValueString($_POST['ofee'], "int"),
                       GetSQLValueString($_POST['urgency'], "text"),
                       GetSQLValueString($_POST['doctor'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());
  $saved = "true";

  }
  
 $_SESSION['CurrDateTime'] =  date("Y-m-d H:i:s");

mysql_select_db($database_swmisconn, $swmisconn);
$query_doctor = "SELECT userid FROM users WHERE active = 'Y' and docflag = 'Y' ORDER BY userid ASC";
$doctor = mysql_query($query_doctor, $swmisconn) or die(mysql_error());
$row_doctor = mysql_fetch_assoc($doctor);
$totalRows_doctor = mysql_num_rows($doctor);

mysql_select_db($database_swmisconn, $swmisconn);
$query_other = "Select id, dept, section, name, descr from fee where dept in ('pharm', 'admin') Order By id";
$other = mysql_query($query_other, $swmisconn) or die(mysql_error());
$row_other = mysql_fetch_assoc($other);
$totalRows_other = mysql_num_rows($other);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../javascript_form/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function out(){
	opener.location.reload(1); //This updates the data on the calling page
	  self.close();
}
//-->
</script>
</head>

<?php if($saved == "true") {?>
	<body onload="out()">
<?php }?>

<body>

<table align="center">
  <tr>
   <td>
<form id="formrx1" name="formrx1" method="post" action="PatPharmOtherAdd.php"> 
    <table border="1" align="center" bgcolor="#BCFACC">
     <tr>
       <td colspan="4" nowrap="nowrap"><div align="center" class="BlueBold_20">ADD DRUG / DONATION </div></td>
       </tr>
     <tr>
		<td colspan="2" nowrap="nowrap">Drug<br />
		  Other Orders</td>
		<td colspan="2" nowrap="nowrap">Urg:
		  <select name="urgency" id="urgency">
			  <option value="Routine">Routine</option>
			  <option value="Scheduled">Scheduled</option>
			  <option value="ASAP">ASAP</option>
			  <option value="STAT">STAT</option>
			</select>
			Doctor:
            <select name="doctor">
              <option value="Select">Select</option>
              <?php
	do {  
	?>
              <option value="<?php echo $row_doctor['userid']?>"><?php echo $row_doctor['userid']?></option>
              <?php
	} while ($row_doctor = mysql_fetch_assoc($doctor));
	  $rows = mysql_num_rows($doctor);
	  if($rows > 0) {
		  mysql_data_seek($doctor, 0);
		  $row_doctor = mysql_fetch_assoc($doctor);
	  }
	?>
         </select></td>
		</tr>
	    <tr>
		  <td colspan="2"><label>
		   <select name="feeid">
			 <?php
	do {  
	?><option value="<?php echo $row_other['id']?>"><?php echo $row_other['name']?></option>
			 <?php
	} while ($row_other = mysql_fetch_assoc($other));
	  $rows = mysql_num_rows($other);
	  if($rows > 0) {
		  mysql_data_seek($other, 0);
		  $row_other = mysql_fetch_assoc($other);
	  }
	?>
		   </select>
		 </label></td>
		<td nowrap="nowrap">Item:
		  <input name="item" type="text" id="item" size="30" maxlength="100" />      </td>
		<td nowrap="nowrap">Drug Quant:
		  
		  <input name="quant" type="text" id="quant" size="8" />      </td>
		</tr>
	  <tr>
		<td rowspan="2" nowrap="nowrap">Order <br />
		  Comments:      </td>
		<td colspan="2" rowspan="2" nowrap="nowrap"><textarea name="comments" cols="25" rows="3" id="comments"></textarea></td>
	    <td nowrap="nowrap">Total Naira:          
	      <input name="ofee" type="text" value="0" size="8" /></td>
	    </tr>
	  <tr>
	    <td nowrap="nowrap"><input name="SubmitAll" type="submit" value="Add Order" /></td>
	    </tr>
	  
				<input name="medrecnum" type="hidden" id="medrecnum" value="<?php echo $_SESSION['mrn']; ?>" />
				<input name="visitid" type="hidden" id="visitid" value="<?php echo $_SESSION['vid']; ?>" />
				<input name="ratereason" type="hidden" id="ratereason" value="103" />
				<input name="rate" type="hidden" id="rate" value="100" />
				<input type="hidden" name="status" value="ordered"/>
				<input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
				<input name="entrydt" type="hidden" id="entrydt" value="<?php echo $_SESSION['CurrDateTime']; ?>" />
				<input type="hidden" name="MM_insert" value="formrx1">
	  </table>
     </form>
    </td>
  </tr>
</table>
<script  type="text/javascript">
// var frmvalidator = new Validator("formplv1");
 //frmvalidator.EnableMsgsTogether();

 frmvalidator.addValidation("doctor","dontselect=Select", "Please Select Doctor");
</script>



</body>
</html>
