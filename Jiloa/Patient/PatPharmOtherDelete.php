<?php if (session_status() == PHP_SESSION_NONE) {
    session_start(); }?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php //require_once('../../Connections/swmisconn.php'); ?>
<?php //session_start() ?>

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
   $_SESSION['CurrDateTime'] =  date("Y-m-d H:i:s");

  $saved = "";

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

 if ((isset($_POST["MM_Delete"])) && ($_POST["MM_Delete"] == "formrx3")) {
	
  $deleteSQL = sprintf("DELETE FROM orders WHERE id=%s",
                       GetSQLValueString($_POST['ordid'], "int"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($deleteSQL, $swmisconn) or die(mysql_error());
  $saved = "true";

}
  ?>

<!--query for an order record-->
<?php
  $colname_ordid = (get_magic_quotes_gpc()) ? $_GET['ordid'] : addslashes($_GET['ordid']);

mysql_select_db($database_swmisconn, $swmisconn);
$query_editdel = "SELECT o.id, o.medrecnum, o.visitid, o.feeid, o.item, o.quant, o.ofee, o.rate, o.doctor, substr(o.status,1,7) status, o.comments, substr(o.urgency,1,1) urg, DATE_FORMAT(o.entrydt,'%d%b%y %H:%i') entrydt, o.entryby, Format(f.fee*(o.rate/100),0) as amtdue, o.amtpaid, f.dept, f.section, f.name, f.descr, f.fee FROM orders o, fee f WHERE o.feeid = f.id and f.dept in ('pharm', 'admin') and o.id = '". $colname_ordid ."'";
$editdel = mysql_query($query_editdel, $swmisconn) or die(mysql_error());
$row_editdel = mysql_fetch_assoc($editdel);
$totalRows_editdel = mysql_num_rows($editdel);

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
<form id="formrx3" name="formrx3" method="post" action="<?php echo $editFormAction; ?>"> 
    <table width="500" border="1" align="center" bgcolor="#FBD0D7">
   
     <tr>
       <td colspan="4" nowrap="nowrap"><div align="center" class="BlueBold_20">DELETE DRUG / DONATION </div></td>
       </tr>
     <tr>
		<td colspan="2" nowrap="nowrap">Drugs/Other Orders</td>
		<td colspan="2" nowrap="nowrap">Urg:
		  <select name="urgency" id="urgency">
		    <option value="Routine" <?php if (!(strcmp("Routine", $row_editdel['urg']))) {echo "selected=\"selected\"";} ?>>Routine</option>
		    <option value="Scheduled" <?php if (!(strcmp("Scheduled", $row_editdel['urg']))) {echo "selected=\"selected\"";} ?>>Scheduled</option>
		    <option value="ASAP" <?php if (!(strcmp("ASAP", $row_editdel['urg']))) {echo "selected=\"selected\"";} ?>>ASAP</option>
<option value="STAT" <?php if (!(strcmp("STAT", $row_editdel['urg']))) {echo "selected=\"selected\"";} ?>>STAT</option>
			</select>
			<input type="hidden" name="status" value="ordered"/>Doctor:
            <select name="doctor">
              <option value="Select" <?php if (!(strcmp("Select", $row_editdel['doctor']))) {echo "selected=\"selected\"";} ?>>Select</option>
              <?php
do {  
?>
              <option value="<?php echo $row_doctor['userid']?>"<?php if (!(strcmp($row_doctor['userid'], $row_editdel['doctor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_doctor['userid']?></option>
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
?>
		     <option value="<?php echo $row_other['id']?>"<?php if (!(strcmp($row_other['id'], $row_editdel['feeid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_other['name']?></option>
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
		  <input name="item" type="text" id="item" value="<?php echo $row_editdel['item']; ?>" size="30" maxlength="100" />      </td>
		<td nowrap="nowrap">Quant:
		  
		  <input name="quant" type="text" id="quant" value="<?php echo $row_editdel['quant']; ?>" size="8" />      </td>
		</tr>
	  <tr>
		<td rowspan="2" nowrap="nowrap">Order Comments:<br />
		Order #: <?php echo $row_editdel['id']; ?></td>
		<td colspan="2" rowspan="2" nowrap="nowrap"><textarea name="comments" cols="25" rows="3" id="comments"><?php echo $row_editdel['comments']; ?></textarea></td>
	    <td nowrap="nowrap">Naira:          
	      <input name="ofee" type="text" value="<?php echo $row_editdel['ofee']; ?>" size="8" /></td>
	    </tr>
	  <tr>
	    <td nowrap="nowrap"><input name="Submit" type="submit" id="Submit" value="Delete Order" /></td>
	    </tr>
	  
				<input name="medrecnum" type="hidden" id="medrecnum" value="<?php echo $_SESSION['mrn']; ?>" />
				<input name="visitid" type="hidden" id="visitid" value="<?php echo $_SESSION['vid']; ?>" />
				<input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
				<input name="entrydt" type="hidden" id="entrydt" value="<?php echo $_SESSION['CurrDateTime']; ?>" />
				<input name="ordid" type="hidden" id="ordid" value="<?php echo $_GET['ordid']; ?>" />
				<input name="MM_Delete" type="hidden" value="formrx3">
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
