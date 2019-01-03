<?php    $pt = "Add Patient Visit"; ?>
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

if ((isset($_POST["MM_update"])) && (isset($_POST["radio"])) && ($_POST["MM_update"] == "form1")) {

// find pat_type & location from fee table
mysql_select_db($database_swmisconn, $swmisconn);
$query_typ_loc = sprintf("Select id, section, name from fee where id = %s", $_POST['radio']);
$typ_loc = mysql_query($query_typ_loc, $swmisconn) or die(mysql_error());
$row_typ_loc = mysql_fetch_assoc($typ_loc);
$totalRows_typ_loc = mysql_num_rows($typ_loc);

 if(!empty($_POST['dischgd']) ){    //dont allow Type/Location or discharge change if discharged
 
	  $updateSQL = sprintf("UPDATE patvisit SET urgency=%s, height=%s, weight=%s, visitreason=%s, diagnosis=%s, entryby=%s, entrydt=%s WHERE id=%s",
                       GetSQLValueString($_POST['urgency'], "text"),
                       GetSQLValueString($_POST['height'], "text"),
                       GetSQLValueString($_POST['weight'], "text"),
                       GetSQLValueString($_POST['visitreason'], "text"),
                       GetSQLValueString($_POST['diagnosis'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['id'], "int"));
	
 } else {  //if not discharged
 
	  $updateSQL = sprintf("UPDATE patvisit SET visitdate=%s, status=%s, vfeeid = %s, pat_type=%s, location=%s, urgency=%s, height=%s, weight=%s, discharge=%s, visitreason=%s, diagnosis=%s, entryby=%s, entrydt=%s WHERE id=%s",
                       GetSQLValueString($_POST['visitdate'], "date"),
                       GetSQLValueString($_POST['vstatus'], "text"),
                       GetSQLValueString($row_typ_loc['id'], "text"),
                       GetSQLValueString($row_typ_loc['section'], "text"),
                       GetSQLValueString($row_typ_loc['name'], "text"),
                       GetSQLValueString($_POST['urgency'], "text"),
                       GetSQLValueString($_POST['height'], "text"),
                       GetSQLValueString($_POST['weight'], "text"),
                       GetSQLValueString($_POST['discharge'], "date"),
                       GetSQLValueString($_POST['visitreason'], "text"),
                       GetSQLValueString($_POST['diagnosis'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['id'], "int"));
 }
  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($updateSQL, $swmisconn) or die(mysql_error());
  
if(ISSET($_POST['ordid'])){	
	$_SESSION['ordid'] = $_POST['ordid'];
}

	mysql_select_db($database_swmisconn, $swmisconn);
	$query_Fee = sprintf("SELECT fee from fee where id = '".$_POST['radio']."'");
	$Fee = mysql_query($query_Fee, $swmisconn) or die(mysql_error());
	$row_Fee = mysql_fetch_assoc($Fee);
	$totalRows_Fee = mysql_num_rows($Fee);
	
	$amtdue = $row_Fee['fee']*($_POST['rate']/100); 	

if(!empty($_POST['amtpaid'] ) and $_POST['amtpaid'] > 0 and $row_typ_loc['name'] != $_POST['location']){    //add a new one
  $insertSQL = sprintf("INSERT INTO orders (medrecnum, visitid, feeid, rate, ratereason, amtdue, amtpaid, billstatus, status, urgency, doctor, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "int"),
					   GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($_POST['radio'], "int"),
                       GetSQLValueString($_POST['rate'], "int"),
                       GetSQLValueString($_POST['ratereason'], "int"),
                       GetSQLValueString($amtdue, "int"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString('Due', "text"),
                       GetSQLValueString('Visit', "text"),
                       GetSQLValueString($_POST['urgency'], "text"),
                       GetSQLValueString('NA', "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));
					   
  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());

   } else {  //if not paid

	if($row_typ_loc['section'] != $_POST['pat_type']) { // if patient type changes
   //create new visit order
 		 $insertSQL = sprintf("INSERT INTO orders (medrecnum, visitid, feeid, rate, ratereason, amtdue, amtpaid, billstatus, status, urgency, doctor, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "int"),
					   GetSQLValueString($_POST['id'], "int"),
					   GetSQLValueString($_POST['radio'], "int"),
                       GetSQLValueString($_POST['rate'], "int"),
                       GetSQLValueString($_POST['ratereason'], "int"),
                       GetSQLValueString($amtdue, "int"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString('Due', "text"),
                       GetSQLValueString('Visit', "text"),
                       GetSQLValueString($_POST['urgency'], "text"),
                       GetSQLValueString('NA', "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));
					   
  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());


 } else { //allow change of type/location


//echo $amtdue;
//exit;
    $updateSQL = sprintf("UPDATE orders SET feeid=%s, amtdue=%s, entryby=%s, entrydt=%s WHERE id=%s",
                       GetSQLValueString($row_typ_loc['id'], "int"),
                       GetSQLValueString($amtdue, "int"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['ordid'], "int"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($updateSQL, $swmisconn) or die(mysql_error());
 } 
} 
// if Antenatal:booking and not previously ordered
	if($row_typ_loc['section'] == 'Antenatal' AND $row_typ_loc['name'] == 'Booking' and $_POST['booking']== 0)  {  // 
	   $ante = array(
		   "0" => "24",
		   "1" => "36",   
		   "2" => "37",   
		   "3" => "32",   
		   "4" => "33",   
		   "5" => "15",   
		   "6" => "73",   
	   );
    	$N = count($ante);
//    echo("You selected $N order(s): ");
		for($j=0; $j < $N; $j++) {  //loop to add orders

	mysql_select_db($database_swmisconn, $swmisconn);
	$query_aFee = sprintf("SELECT fee from fee where id = '".$ante[$j]."'");
	$aFee = mysql_query($query_aFee, $swmisconn) or die(mysql_error());
	$row_aFee = mysql_fetch_assoc($aFee);
	$totalRows_aFee = mysql_num_rows($aFee);
	
	$amtdue = $row_aFee['fee']*($_POST['rate']/100); 	

	
	  $insertSQL = sprintf("INSERT INTO orders (medrecnum, visitid, feeid, rate, ratereason, amtdue, amtpaid, billstatus, status, urgency, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "text"),
                       GetSQLValueString($_POST['id'], "int"),
                       $ante[$j],
                       GetSQLValueString($_POST['rate'], "int"),
                       GetSQLValueString($_POST['ratereason'], "text"),
                       GetSQLValueString($amtdue, "int"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString($_POST['billstatus'], "text"),
                       GetSQLValueString($_POST['ordstatus'], "text"),
                       GetSQLValueString($_POST['urgency'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());

		 // echo($N.' - '.$ante[$j] . " ");
    } //  FOR loop
   } 	

  $updateGoTo = "PatShow1.php?mrn=".$_SESSION['mrn'];
//  if (isset($_SERVER['QUERY_STRING'])) {
//    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
//    $updateGoTo .= $_SERVER['QUERY_STRING'];
//  }
  header(sprintf("Location: %s", $updateGoTo));
  } 
?>

<?php
$colid_visitedit = "-1";
if (isset($_GET['vid'])) {
  $colid_visitedit = (get_magic_quotes_gpc()) ? $_GET['vid'] : addslashes($_GET['vid']);
}
$colmrn_visitedit = "-1";
if (isset($_GET['mrn'])) {
  $colmrn_visitedit = (get_magic_quotes_gpc()) ? $_GET['mrn'] : addslashes($_GET['mrn']);
  $_SESSION['MRN'] = $colmrn_visitedit;  // set to retrieve MRN in PatShow1.php when it goes back
}
$colvordid_visitedit = "-1";
if (isset($_GET['vordid'])) {
  $colvordid_visitedit = (get_magic_quotes_gpc()) ? $_GET['vordid'] : addslashes($_GET['vordid']);
}

mysql_select_db($database_swmisconn, $swmisconn);
$query_visitedit = sprintf("SELECT v.id, medrecnum, DATE_FORMAT(visitdate,'%%Y-%%m-%%d   %%H:%%i') visitdate, vfeeid, status, pat_type, location, urgency, height, weight, discharge, visitreason, diagnosis, v.entryby, DATE_FORMAT(v.entrydt,'%%Y-%%m-%%d') entrydt FROM patvisit v WHERE v.id = %s AND medrecnum = %s", $colid_visitedit,$colmrn_visitedit);
$visitedit = mysql_query($query_visitedit, $swmisconn) or die(mysql_error());
$row_visitedit = mysql_fetch_assoc($visitedit);
$totalRows_visitedit = mysql_num_rows($visitedit);
?>

<?php  // find the order and feeid of the visit order to be updated 
mysql_select_db($database_swmisconn, $swmisconn);
$query_feeid = "SELECT v.id visitid, o.id ordid, o.feeid, o.amtpaid, o.rate, o.ratereason, o.status FROM orders o join PATVISIT v ON o.visitid = v.id where o.visitid = '".$colid_visitedit."' and o.id = '".$colvordid_visitedit."'" ;
$feeid = mysql_query($query_feeid, $swmisconn) or die(mysql_error());
$row_feeid = mysql_fetch_assoc($feeid);
$totalRows_feeid = mysql_num_rows($feeid);

	$regpaid = 'N';
if ($row_feeid['rate'] == 0 or $row_feeid['amtpaid'] > 0) {
	$regpaid = 'Y';
}

// join fee f on o.feeid = f.id where f.section = '".$row_visitedit['pat_type']."' and f.name = '".$row_visitedit['location']."' and
?>
<?php //to display selections
mysql_select_db($database_swmisconn, $swmisconn);
$query_OutPatient = "SELECT id, dept, `section`, name, fee FROM fee WHERE Active = 'Y' and dept = 'Records' and Section = 'OutPatient' ORDER BY name ASC";
$OutPatient = mysql_query($query_OutPatient, $swmisconn) or die(mysql_error());
?>
<?php
mysql_select_db($database_swmisconn, $swmisconn);
$query_InPatient = "SELECT id, dept, `section`, name, fee FROM fee WHERE Active = 'Y' and dept = 'Records' and Section = 'InPatient' ORDER BY name ASC";
$InPatient = mysql_query($query_InPatient, $swmisconn) or die(mysql_error());
?>
<?php
mysql_select_db($database_swmisconn, $swmisconn);
$query_Antenatal = "SELECT id, dept, `section`, name, fee FROM fee WHERE Active = 'Y' and dept = 'Records' and Section = 'Antenatal' ORDER BY name ASC";
$Antenatal = mysql_query($query_Antenatal, $swmisconn) or die(mysql_error());
?>

<?php 
mysql_select_db($database_swmisconn, $swmisconn);
$query_booking = "SELECT o.id ordid FROM orders o join PATVISIT v ON o.visitid = v.id where o.visitid = '".$colid_visitedit."' and (o.feeid = 24 or o.feeid = 36)";
$booking = mysql_query($query_booking, $swmisconn) or die(mysql_error());
$row_booking = mysql_fetch_assoc($booking);
$totalRows_booking = mysql_num_rows($booking);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table align="center">
     <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
	 <tr>
		<td>
			<table align="center">
				<tr>                                   <?php //echo $_SESSION['ordid'] . ' - ' . echo $_SESSION['getfeedid'] ?>
				  <td align="right" class="subtitlebl">Status:&nbsp;<?php //echo $row_feeid['ordid']; ?><?php //echo $row_feeid['feeid']; ?></td>
				  <td align="left" class="subtitlebl">
					  <select name="vstatus">
                        <option value="HERE">HERE</option>
                        <!--<option value="Scheduled">Scheduled</option>-->
                      </select>				  </td>
					<td align="center" class="subtitlebl"><input name="visitdate" type="text" id="visitdate" value="<?php echo $row_visitedit['visitdate']; ?>" size="20"  data-validation="date"   data-validation-error-msg="Visit Date in format of YYYY-MM-DD (10 characters long) is required ******"/></td>
					<td align="center" class="subtitlebl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="center" class="subtitlebl">Edit Patient Visit</td>
					<td align="center" class="subtitlebl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<?php  if ($_SESSION['vnum'] > 0) { ?>
					<td nowrap="nowrap">Visits: &nbsp; </td>
				<?php if(allow(20,1) == 1) { ?>
				    <td align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitList.php"><?php echo $_SESSION['vnum']; ?></a></td>
					<?php  } ?>
				<?php  } 
						else {?>
					<td nowrap="nowrap">Visits: &nbsp; 0 &nbsp;</td>
				<?php  } ?>
					<td align="center" class="subtitlebl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<?php if(allow(20,4) == 1 and empty($row_visitedit['discharge']) and $regpaid == 'N') { ?>
					<td align="center"> <a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitDelete.php&vid=<?php echo $row_visitedit['id'] ?>">Delete</a></td>
				<?php  } ?>
				  	<td align="center" class="subtitlebl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
				<?php if(allow(20,1) == 1) { ?>
					<td align="center"> <a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitView.php&vid=<?php echo $row_visitedit['id'] ?>">View</a></td>
				<?php  } ?>
				</tr>
	      </table>		</td>
	  </tr>
<!-- next section -->
<?php if(!empty($row_visitedit['discharge']) ){    //dont allow Type/Location change if discharged
?>
		  <input name="radio" type="hidden" id="radio" value="<?php echo $row_feeid['feeid']; ?>" />
      <tr>
	  	<td align="center">Visit is discharged.  Visit Type, Location, Entry Date, Discharge cannot be changed. <br />
	  	    	    Only Visit Reason, Height, Weight, and Diagnosis can be edited. </td>
	  </tr>
<?php } else { ?>
	  <tr>	
		<td bgcolor="#F8FDCE">
			<table border="1" align="center" class="tablebc"> <!--for pat_type & location-->
				<tr>
<!-- ***************** Out Pat ******************************* -->		  
		            <td>
						<table>	 <!--The container table with $cols columns-->
						  <tr>
							<td align="center" class="Black_1010">OutPatient</td>
						  </tr>
        <?php   
	    $cols=2; 		// Here we define the number of columns
	    do{ ?>
					      <tr>
        <?php   
		
		for($i=1;$i<=$cols;$i++){	// All the rows will have $cols columns even if
									// the records are less than $cols
			$row=mysql_fetch_array($OutPatient);
			
			if($row){
		?>      
							<td>
								<table>
									<tr valign="top">
  										<td><input name="radio" type="radio" class="BlackBold_11_11" value="<?php echo $row['id']; ?>" <?php echo ($row_visitedit['vfeeid'] == $row['id'])?'checked':'' ?>/></td>
										<td class="BlackBold_11_11"><?php echo $row['name'] ?></td>
										<td class="BlackBold_11_11"> (<?php echo $row['fee'] ?>)</td>									
										<!--<td class="BlackBold_11_11" width="20">&nbsp;</td>-->	<!-- Create gap between columns -->
									</tr>
							   </table>							</td>
<?php
			}
//			else{
//				echo "<td class='BlackBold_11_11'>--</td>";	//If there are no more records at the end, add a blank column
//			}
		} ?>
						</tr>
<?php			} while($row);
 ?>	
					  </table>	      			</td>		  
<!-- ***************** In Pat ******************************* -->		  
		            <td>  <!--valign="top"  height="15"> <span class="BlackBold_11_11"> InPatient: </span> <br/-->
						<table>	 <!--The container table with $cols columns-->
						  <tr>
							<td align="center" class="Black_1010">InPatient</td>
						  </tr>
<?php   
	    $cols=2; 		// Here we define the number of columns
	    do{
?>						  <tr>
<?php   		
		for($i=1;$i<=$cols;$i++){	// All the rows will have $cols columns even if
									// the records are less than $cols
			$row=mysql_fetch_array($InPatient);
			
			if($row){
		?>      
							<td>
								<table>
									<tr valign="top">
  										<td><input name="radio" type="radio" class="BlackBold_11_11" value="<?php echo $row['id']; ?>" <?php echo ($row_visitedit['vfeeid'] == $row['id'])?'checked':'' ?>/></td>
										<td class="BlackBold_11_11"><?php echo $row['name'] ?></td>
										<td class="BlackBold_11_11"> (<?php echo $row['fee'] ?>)</td>									
										<!--<td class="BlackBold_11_11" width="20">&nbsp;</td>-->	<!-- Create gap between columns -->
									</tr>
							   </table>							</td>
<?php
			}
//			else{
//				echo "<td class='BlackBold_11_11'>--</td>";	//If there are no more records at the end, add a blank column
//			}
		}
?>						</tr>
<?php
			} while($row);
 ?>	
						</table>	      			</td>		  
<!-- ***************** Antenatal ******************************* -->		  
		            <td>  <!--valign="top"  height="15"> <span class="BlackBold_11_11"> Antenatal: </span> <br/-->
						<table>	 <!--The container table with $cols columns-->
						  <tr>
							<td align="center" class="Black_1010">Antenatal</td>
        <?php   
	    $cols=2; 		// Here we define the number of columns
	    do{
?>						 <tr>
        <?php   
		for($i=1;$i<=$cols;$i++){	// All the rows will have $cols columns even if
									// the records are less than $cols
			$row=mysql_fetch_array($Antenatal);
			
			if($row){
		?>      
							<td>
								<table>
									<tr valign="top">
  										<td><input name="radio" type="radio" class="BlackBold_11_11" value="<?php echo $row['id']; ?>" <?php echo ($row_visitedit['vfeeid'] == $row['id'])?'checked':'' ?>/></td>
										<td class="BlackBold_11_11"><?php echo $row['name'] ?></td>
										<td class="BlackBold_11_11"> (<?php echo $row['fee'] ?>)</td>									
										<!--<td class="BlackBold_11_11" width="20">&nbsp;</td>	<!-- Create gap between columns -->
									</tr>
							   </table>							</td>
<?php
			}
//			else{
//				echo "<td class='BlackBold_11_11'>--</td>";	//If there are no more records at the end, add a blank column
//			}
		}
?>						</tr>
<?php
			} while($row);
 ?>
 					</table>	      			</td>	
<!--End of antenatal -->
				</tr>
		  </table>		</td>
	  </tr>
<?php } ?> <!-- end of if not paid-->
	  <tr>
        <td>
          <table width="100%" border="0" bgcolor="#F8FDCE">
			<tr>
			  <td nowrap="nowrap"><span class="BlueBold_14">#<?php echo $row_visitedit['id']; ?></span></td>
			  <td nowrap="nowrap"><div align="right">Entry Date:</div></td>
			  <td title="VID: <?php echo $row_visitedit['id']; ?>"><input name="entrydt" type="text" id="entrydt" readonly="readonly" value="<?php echo $row_visitedit['entrydt']; ?>" size="12" /></td>
	
				    <td nowrap="nowrap"><div align="right">Type:</div></td>
				    <td><input name="pat_type" type="text" readonly="readonly" id="pat_type" size="8" value="<?php echo $row_visitedit['pat_type']; ?>" /></td>
          			<td><div align="right">Location:</div></td>
          			<td><input name="location" type="text" readonly="readonly" id="location" size="8" value="<?php echo $row_visitedit['location']; ?>"/></td>
					<input name="urgency" type="hidden" value="Routine" />			 <!-- <td><div align="right">Urgency:</div></td>
			  <td><select name="urgency" id="urgency">
					<option value="Routine">Routine</option>
					<option value="Scheduled">Scheduled</option>
					<option value="ASAP">ASAP</option>
					<option value="STAT">STAT</option>
			     </select>          </td>-->
				 <td>&nbsp;</td>
			  <?php if (!empty($row_visitedit['diagnosis'])) { ?>
			  <td nowrap="nowrap"><div align="right"> Discharged: <span class="BlackBold_11">yyyy-mm-dd</span>: </div></td>
			  <td><input name="discharge" type="text" id="discharge" value="<?php echo $row_visitedit['discharge']; ?>" size="8" /></td>
			  <?php } else { ?>
			  <td nowrap="nowrap"><input name="discharge" type="hidden" id="discharge" value="<?php echo $row_visitedit['discharge']; ?>" size="12" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No Diagnosis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php // echo $row_feeid['ordid'] ?></td>
			  <td>&nbsp;</td>
			  <?php }?>
			  <td align="right"><input type="submit" name="Submit" value="Edit Visit" /></td>
			</tr>
			<tr>
			  
			  <td>Visit<br/>Reason</td>
			  <td colspan="4"><textarea name="visitreason" cols="40" rows="2" id="visitreason" data-validation="required" data-validation-length="min3" data-validation-error-msg="Visit Reason Required - Min = 3 Characters ********************************"><?php echo $row_visitedit['visitreason']; ?></textarea></td>
			  <td colspan="2">
				<table width="100%">
					<tr>
						<td>Height</td>
					  <td nowrap="nowrap"><input name="height" type="text" size="5" value="<?php echo $row_visitedit['height']; ?>" data-validation="number"  data-validation-allowing="range[1;200]" data-validation-optional="true"  data-validation-error-msg="Height: Number between 1 and 200 Required ********************************"/>&nbsp;cm</td>
					</tr>
					<tr>
						<td>Weight</td>
					  <td nowrap="nowrap"><input name="weight" type="text" size="5" value="<?php echo $row_visitedit['weight']; ?>" data-validation="number" data-validation-allowing="range[1;300]" data-validation-optional="true"   data-validation-error-msg="Weight: Number between 1 and 300 Required ********************************" />&nbsp;kilo</td>
					</tr>
			  </table>			</td>

          		  
          <td><div align="right">Diagnosis:<?php // echo $totalRows_booking ?></div></td>
          <td colspan="4"><textarea name="diagnosis" cols="40" rows="2" id="diagnosis"><?php echo $row_visitedit['diagnosis']; ?></textarea>

     			  <input name="billstatus" type="hidden" id="billstatus" value="Due" />
         		  <input name="booking" type="hidden" id="booking" value="<?php echo $totalRows_booking ?>" />
          		  <input name="rate" type="hidden" id="rate" value="<?php echo $row_feeid['rate']; ?>" />
		          <input name="ratereason" type="hidden" id="ratereason" value="<?php echo $row_feeid['ratereason']; ?>" />
		          <input name="status" type="hidden" id="status" value="<?php echo $row_feeid['status']; ?>" />
		          <input name="ordstatus" type="hidden" id="ordstatus" value="Ordered" />
		          <input name="ordid" type="hidden" id="ordid" value="<?php echo $row_feeid['ordid']; ?>" />
		          <input name="feeid" type="hidden" id="feeid" value="<?php echo $row_feeid['feeid']; ?>" />
		          <input name="amtpaid" type="hidden" id="amtpaid" value="<?php echo $row_feeid['amtpaid']; ?>" />
		          <input name="id" type="hidden" id="id" value="<?php echo $row_visitedit['id']; ?>" />
		          <input name="dischgd" type="hidden" id="dischgd" value="<?php echo $row_visitedit['discharge']; ?>" />
		          <input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i:s"); ?>" />
        		  <input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
        		  <input name="medrecnum" type="hidden" id="medrecnum" value="<?php echo $_SESSION['mrn']; ?>" />		 </td>
          <input type="hidden" name="MM_update" value="form1" />
          </tr>
      </table>
  </form>
    </td>
  </tr>
</table>
<script src="../../jquery-1.11.1.js"></script>
<script src="../../jQuery-Form-Validator-master/form-validator/jquery.form-validator.min.js"></script>
<script>
/* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
    $.validate({
	//modules : 'date, security'    //options: 'date',  'security', 'location', 'file'
	validateOnBlur : false, // disable validation when input looses focus
    errorMessagePosition : 'top', // Instead of 'element' which is default
    scrollToTopOnError : false // Set this property to true if you have a long form

 });</script>


</body>
</html>
<?php
mysql_free_result($visitedit);
?>
