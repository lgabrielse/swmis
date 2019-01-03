<? $pt = "BankView"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?> 
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
  $errormsg = '';
  
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_addf")) {
  $insertSQL = sprintf("INSERT INTO bank (medrecnum, transtype, bankname, transnum, banktransdate, amount, comments, entrydt, entryby) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "int"),
                       GetSQLValueString($_POST['transtype'], "text"),
                       GetSQLValueString($_POST['bankname'], "text"),
                       GetSQLValueString($_POST['transnum'], "text"),
                       GetSQLValueString($_POST['banktransdate'], "date"),
                       GetSQLValueString($_POST['amount'], "int"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['entryby'], "text"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());

  $insertGoTo = "BankView.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
// TRANSFER From
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_transconf")) {
  $insertSQL = sprintf("INSERT INTO bank (medrecnum, transtype, bankname, transnum, amount, comments, entrydt, entryby) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "int"),
                       GetSQLValueString($_POST['transtype'], "text"),   //withdrawal
                       GetSQLValueString($_POST['medrecnumto'], "text"), // puts target MRN in bankname field
                       GetSQLValueString('TRANSFER', "text"),            // transnum = TRANSFER
                       GetSQLValueString($_POST['transamountconf'], "int"),
                       GetSQLValueString('Transfer to'.$_POST['medrecnumto'].'...'.$_POST['comments'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['entryby'], "text"));
					   
  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());
//Transfer to

  $insertSQL = sprintf("INSERT INTO bank (medrecnum, transtype, bankname, transnum, amount, comments, entrydt, entryby) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnumto'], "int"),
                       GetSQLValueString($_POST['transtypeto'], "text"), // deposit
                       GetSQLValueString($_POST['medrecnum'], "text"),  // puts source MRN in bankname field
                       GetSQLValueString('TRANSFER', "text"),            // transnum = TRANSFER
                       GetSQLValueString($_POST['transamountconf'], "int"),
                       GetSQLValueString('Transfer from'.$_POST['medrecnum'].'...'.$_POST['comments'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['entryby'], "text"));
					   
  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());



  $insertGoTo = "BankView.php?act=blank";
//  if (isset($_SERVER['QUERY_STRING'])) {
//    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
//    $insertGoTo .= $_SERVER['QUERY_STRING'];
//  }
  header(sprintf("Location: %s", $insertGoTo));
}


// DEDUCT from

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_deduct")) {
  $insertSQL = sprintf("INSERT INTO bank (medrecnum, transtype, bankname, transnum, amount, comments, entrydt, entryby) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "int"),
                       GetSQLValueString($_POST['transtype'], "text"),  //withdrawal
                       GetSQLValueString($_POST['bankname'], "text"),  // account list selected
                       GetSQLValueString($_POST['transnum'], "text"),  // DEDUCT
                       GetSQLValueString($_POST['amount'], "int"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['entryby'], "text"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());

  $insertGoTo = "BankView.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

// *** Get the patient permanent record and the ID of the patient info record
$colname_patperm = "3";
if (isset($_GET['mrn'])) {
  $colname_patperm = (get_magic_quotes_gpc()) ? $_GET['mrn'] : addslashes($_GET['mrn']);
  $_SESSION['mrn'] = $colname_patperm;  //set session variable
}
else {
	if (isset($_SESSION['mrn'])) {
  $colname_patperm = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']);
	}
  }
?>
<?php mysql_select_db($database_swmisconn, $swmisconn);  //CASE WHEN o.item is NULL THEN f.name ELSE o.item END as feename
$query_Status = "SELECT(Select sum(amount) FROM bank Where transtype = 'deposit' and  medrecnum = '".$colname_patperm."') deposited, (Select sum(amount) FROM bank Where transtype = 'withdrawal' and  medrecnum = '".$colname_patperm."') withdrawn
FROM bank ";
$Status = mysql_query($query_Status, $swmisconn) or die(mysql_error());
$row_Status = mysql_fetch_assoc($Status);
$totalRows_Status = mysql_num_rows($Status);
?>


<?php mysql_select_db($database_swmisconn, $swmisconn);
$query_Bank = "SELECT name FROM dropdownlist WHERE list = 'Bank' ORDER BY seq ASC";
$Bank = mysql_query($query_Bank, $swmisconn) or die(mysql_error());
$row_Bank = mysql_fetch_assoc($Bank);
$totalRows_Bank = mysql_num_rows($Bank);
?>
<?php if(isset($_GET['act']) and $_GET['act'] == 'transconf'){?> <!-- if this is confirmation -->
<?php mysql_select_db($database_swmisconn, $swmisconn);  //CASE WHEN o.item is NULL THEN f.name ELSE o.item END as feename
$query_Transto = "SELECT medrecnum, lastname, firstname, othername, dob, gender, ethnicgroup FROM patperm WHERE medrecnum = '".$_POST['transferto']."'";
$Transto = mysql_query($query_Transto, $swmisconn) or die(mysql_error());
$row_Transto = mysql_fetch_assoc($Transto);
$totalRows_Transto = mysql_num_rows($Transto);

}
?>
<?php mysql_select_db($database_swmisconn, $swmisconn);
$query_PayBy = "SELECT name FROM dropdownlist WHERE list = 'PayBy' ORDER BY seq ASC";
$PayBy = mysql_query($query_PayBy, $swmisconn) or die(mysql_error());
$row_PayBy = mysql_fetch_assoc($PayBy);
$totalRows_PayBy = mysql_num_rows($PayBy);
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
	<script src="../../jquery-1.11.1.js"></script> <!--needed for calendar-->
    <script src="../../jquery-ui-1.11.2.custom/jquery-ui.min.js"></script> <!--needed for calendar-->
    <link rel="stylesheet" href="../../jquery-ui-1.11.2.custom/jquery-ui.css" /> <!--needed for calendar-->
    
	<script> <!--needed for calendar...  input needs id defined-->
	$(document).ready(function(){
     //  $(function() {           // this and previous line work OK... don't know the difference
    $.datepicker.setDefaults({    //solution to 0000-00-00 http://stackoverflow.com/questions/9888000/jquery-datepicker-format-date-not-working
     dateFormat: 'yy-mm-dd'
    });
	 dateFormat: "yy-mm-dd";
          $( "#banktransdate" ).datepicker();
//          $( "#edd" ).datepicker();
//          $( "#ussedd" ).datepicker();
//          $( "#firstvisit" ).datepicker();
       });
   </script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
   var win_position = ',left=300,top=400,screenX=300,screenY=400';
   var newWindow = window.open(theURL,winName,features+win_position);
   newWindow.focus();
}
//-->
</script>
</head>

<body>
<!-- Display PATIENT PERMANENT Data  -->
<?php $patview = "../Patient/PatPermView.php"?>
S
<table align="center">
	<tr>
		<td valign="top"><?php require_once($patview); ?></td>
	</tr>

	<tr>
	   <td nowrap="nowrap" align="center" class="BlueBold_30"> Bank View &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<!-- where to go to when close is clicked -->
	  <?php if(strrpos($_SERVER['HTTP_REFERER'],'PatShow1') > 0) {?>
  	   <a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']?>" class="navLink">Close</a></td>
	  <?php } else if(strrpos($_SERVER['HTTP_REFERER'],'CashShow.php') > 0) {  ?>
	  	<a href="CashShow.php?mrn=<?php echo $_SESSION['mrn']?>&amp;Status=ordered" class="navLink">Close</a></td>
	  <?php } else if(strrpos($_SERVER['HTTP_REFERER'],'CashShowAll') > 0) {  ?>
	  	<a href="CashShowAll.php?mrn=<?php echo $_SESSION['mrn']?>&amp;Status=ordered" class="navLink">Close</a></td>
	  <?php } else if(strrpos($_SERVER['HTTP_REFERER'],'BankView') > 0) {  ?>
  	   <a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']?>" class="navLink">Close</a></td>
	  <?php }  ?>
	  <?php $balance = $row_Status['deposited'] - $row_Status['withdrawn']?>
	</tr>
		<td align="center">
			<table bgcolor="#CCFFFF" >
				<tr>
				   <td colspan="4"> <div align="center" class="subtitlegr">ACCOUNT STATUS</div></td>
				</tr>
				<tr>
				   <td>Deposited:<input name="deposit" style="text-align:center;" type="text" disabled size="10" readonly="true" value="<?php echo $row_Status['deposited']?>" /></td>
				   <td>Withdrawn:<input name="deposit" style="text-align:center;"type="text" disabled size="10" readonly="true" value="<?php echo $row_Status['withdrawn']?>"/></td>
				   <td>Balance:<input name="balance" style="text-align:center;" type="text" disabled size="10" readonly="true" value="<?php echo $row_Status['deposited'] - $row_Status['withdrawn']?>"/></td>
				   <td>&nbsp;</td>
				</tr>
				<tr>
				   <td> <div align="center" class="subtitlegr">&nbsp;</div></td>
				   <td>&nbsp;</td>
				   <td>&nbsp;</td>
				   <td><a href="javascript:void(0)" onclick="MM_openBrWindow('BankDetails.php?mrn=<?php echo $_SESSION['mrn']; ?>','StatusView','scrollbars=yes,resizable=yes,width=1000,height=800')">Details</a>
				   </td>
				</tr>
		  </table>
		</td>
	</tr>
	
<!--	*********************************************** ADD FUNDS ****************************************  -->
<?php if(allow(53,3) == 1) { ?>
	<tr>
	  <td colspan="4">
        <form name="form_addf" method="POST" action="<?php echo $editFormAction; ?>">
	     <table border="1" bordercolor="#00FF00" bgcolor="#00FF00">
          <tr>
            <td colspan="5"><div align="center" class="subtitlegr">ADD FUNDS TO PATIENT ACCOUNT </div></td>
          </tr>
          <tr>
            <td>Bank
              <select name="bankname" id="bankname">
				<?php do { ?>
					<option value="<?php echo $row_Bank['name']?>"><?php echo $row_Bank['name']?></option>
				<?php } while ($row_Bank = mysql_fetch_assoc($Bank));
					  $rows = mysql_num_rows($Bank);
					  if($rows > 0) {
						  mysql_data_seek($Bank, 0);
						  $row_Bank = mysql_fetch_assoc($Bank);
					  } ?>
              </select>              </td>
            <td>Document Number
              <input name="transnum" type="text" id="transnum" size="5" maxlength="7" /></td>
            <td>Deposit Date
              <input name="banktransdate" id="banktransdate" type="text" size="10" maxlength="10" /></td>
            <td nowrap="nowrap">Amount
              <input name="amount" type="text" id="amount" size="5" maxlength="7" /> 
              Naira </td>
            <td><input name="form_addf" type="submit" value="Add Funds" /></td>
          </tr>
          <tr>
            <td colspan="4">Comments<textarea name="comments" cols="80" rows="2" id="comments"></textarea></td>
            <td nowrap="nowrap"><div align="center">No Confirm<br />Page </div></td>
          
				<input name="medrecnum" type="hidden" value="<?php echo $_SESSION['mrn'] ?>" />
				<input name="transtype" type="hidden" value="deposit" /> 
				<input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
				<input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i"); ?>" />
				<input type="hidden" name="MM_insert" value="form_addf">

          </tr>
      	</table>
	  	</form>
	  </td>
	</tr>
<?php } ?>

<!--	*********************************************** TRANSFER FUNDS ****************************************  -->
<?php if(allow(53,3) == 1) { ?>
	<tr>
	  <td>
	     <table border="1" bordercolor="#FFFDDA" bgcolor="#FFFDDA">
          <tr>
            <td colspan="3"><div align="center" class="subtitlegr">TRANSFER FUNDS TO ANOTHER PATIENT ACCOUNT </div></td>
          </tr>
<?php if(isset($_GET['act']) and $_GET['act'] == 'transconf'){?> <!-- if this is confirmation -->
        <form name="form_transconf" method="POST" action="<?php echo $editFormAction; ?>">
          <tr>
            <td bgcolor="#FCEFA1"><span class="GreenBold_16">CONFIRM TRANSFER TO:</span>
              <?php echo $_POST['transferto']; ?>
            <input name="transfername" type="text" id="transfername" size="40" maxlength="50" value="<?php echo $row_Transto['lastname'].', '.$row_Transto['firstname'].', '.$row_Transto['othername'] ?>"/></td>
            <td bgcolor="#FCEFA1" nowrap="nowrap">Amount
              <input name="transamountconf" type="text" id="transamountconf" size="10" maxlength="10" value="<?php echo $_POST['transamount'] ?>" /> 
              Naira </td>
            <td nowrap="nowrap"><a href="BankView.php?mrn=<?php echo $_SESSION['mrn'] ?>">Close</a></td>
          </tr>
          <tr>
            <td bgcolor="#FCEFA1" colspan="2">Comments<textarea name="comments" cols="80" rows="2" id="comments"><?php echo $_POST['comments']?></textarea></td>
<?php   if($_POST['transamount'] > $balance){?>
			 <td bgcolor="#FF0000" title="Transfer amount is greater that available balance">ERROR</td>
<?php  } else {?>
            <td bgcolor="#FCEFA1"><input name="form_transconf" type="submit" value="Transfer" /></td>
<?php } ?>         
				<input name="medrecnumto" type="hidden" value="<?php echo $_POST['transferto']; ?>" />
				<input name="transtypeto" type="hidden" value="deposit" /> 
				
				<input name="medrecnum" type="hidden" value="<?php echo $_SESSION['mrn'] ?>" />
				<input name="transtype" type="hidden" value="withdrawal" /> 
				<input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
				<input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i"); ?>" />
				<input type="hidden" name="MM_insert" value="form_transconf">
         </tr>
	  	</form>

<?php } else {?>
        <form name="form_transf" method="POST" action="BankView.php?act=transconf">
          <tr>
            <td>Enter Medical Record Number:  TRANSFER TO MED REC NUM: 
              <input name="transferto" type="text" id="transferto" size="10" maxlength="10" /></td>
            <td nowrap="nowrap">Amount
              <input name="transamount" type="text" id="transamount" size="10" maxlength="10" /> 
              of <?php echo $balance ?> Naira</td>
            <td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2">Comments<textarea name="comments" cols="80" rows="2" id="comments"></textarea></td>
            <td><input name="form_addf2" type="submit" value="Go To Confirm" /></td>        
				<input name="medrecnum" type="hidden" value="<?php echo $_SESSION['mrn'] ?>" />
				<input name="balance" type="hidden" value="<?php echo $balance ?>" /> 
				<input type="hidden" name="MM_insert" value="Confirm">
          </tr>
	  	</form>
 <?php } ?>
     	</table>
	  </td>
	</tr>
<?php } ?>

<!--	*********************************************** DEDUCT FUNDS ****************************************  -->

<?php if(allow(53,3) == 1) { ?>
	<tr>
	  <td>
	     <table border="1" align="center" bordercolor="#FFcccc" bgcolor="#FFcccc">
          	<tr>
			   <td colspan="5" class="subtitlegr"><div align="center">DEDUCT FUNDS FROM PATIENT ACCOUNT</div></td>
			</tr>
        	<form name="form_deduct" method="POST" action="<?php echo $editFormAction; ?>">
			<tr>
			   <td>Refund To
			     <select name="bankname" id="bankname">
                   <?php do { ?>
                   <option value="<?php echo $row_PayBy['name']?>"><?php echo $row_PayBy['name']?></option>
                   <?php } while ($row_PayBy = mysql_fetch_assoc($PayBy));
			  $rows = mysql_num_rows($PayBy);
			  if($rows > 0) {
				  mysql_data_seek($PayBy, 0);
				  $row_PayBy = mysql_fetch_assoc($PayBy);
			  } ?>
                 </select></td>
			   <td>Amount:
		       <input name="amount" type="text" size="10" maxlength="10" /></td>
			   <td>Current Balance:</td>
			   <td><?php echo $balance ?></td>
			   <td><input name="deduct" type="submit" value="DEDUCT" />
			   		<input name="medrecnum" type="hidden" value="<?php echo $_SESSION['mrn'] ?>" />
					<input name="transtype" type="hidden" value="withdrawal" /> 
					<input name="transnum" type="hidden" value="DEDUCT" /> 
					<input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
					<input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i"); ?>" />
					<input type="hidden" name="MM_insert" value="form_deduct">				</td>
			</tr>
			<tr>
            	<td colspan="4">Comments<textarea name="comments" cols="60" rows="2" id="comments"></textarea></td>
            	<td nowrap="nowrap"><div align="center">No Confirm<br />Page </div></td>
			</tr>
			</form>
		</table>
	  </td>
   </tr>
<?php } ?>
</table>

</body>
</html>
