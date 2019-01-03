<?php if (session_status() == PHP_SESSION_NONE) {
    session_start(); }?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
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

  $showinput = 'Y';
	$msg = '';
	$msgcombo = '';
if (isset($_POST['SubmitAll']) AND $_POST['SubmitAll']  == 'Add Orders')  {
//echo $_POST['SubmitAll'];
//exit;
	$formnmb = array('0','1','2','3','4','5'); 	
?>

<?php for ($d=0; $d<6; $d++) { 
			$msg = $msg.$formnmb[$d];
			$item = $_POST['item_'.$formnmb[$d]];
         $nunits = $_POST['nunits_'.$formnmb[$d]];
         $unit = $_POST['unit_'.$formnmb[$d]];
         $every = $_POST['every_'.$formnmb[$d]];
         $evperiod = $_POST['evperiod_'.$formnmb[$d]];
         $fornum = $_POST['fornum_'.$formnmb[$d]];
         $forperiod = $_POST['forperiod_'.$formnmb[$d]];
         $comments = $_POST['comments_'.$formnmb[$d]];
if(!empty($scheddt)) { $scheddt = $_POST['scheddt_'.$formnmb[$d]]; }
if(!empty($schedtime)) { $schedtime = $_POST['schedtime_'.$formnmb[$d]]; }
		 $tstevery = 'false';
		 $minhrsdayweek = 'false';
		 if(strpos(" minutes hour(s) days(s) week(s) ", $evperiod) > 0 AND !empty($every) AND $every > 0 and $every < 60) {
			$tstevery = 'true';
			$minhrsdayweek = 'true';}
		 if(strpos(" OD Nocte BD TDS QDS PRN STAT ", $evperiod)>0) {$tstevery = 'true';}
		 $dn = $d + 1;
		 $msg_ord = '';

if(!empty($item) or !empty($nunits) or !empty($fornum) or !$tstevery == 'true'){ // check for any data
	if(strlen($item) < 3 ) { //&& ($nunits > 0 or $minhrsdayweek == 'true' or $fornum > 0 )  if(empty($item) and other fields entered)
		$msg = ' \\n'. $dn.' - - Drug Name must be more than 2 characters '; 
		$msg_ord = $msg_ord.' '.$msg;
	} else {				
		if(empty($nunits) or ($nunits !== null && !is_numeric( $nunits ))) { //if(empty($nunits))
			$msg= ' \\n'. $dn.' - - '.$item.' - -  number of units is blank or not a number';
			$msg_ord = $msg_ord.' '.$msg;}			
		if($tstevery == 'false') { //if(empty($every))
			$msg= ' \\n'. $dn.' - - '.$item.' - - number of EVERY hours, days, weeks not entered';
			$msg_ord = $msg_ord.' '.$msg;}			
		if(empty($fornum) or ($fornum !== null && !is_numeric( $fornum ))) { //if(empty($fornum))
			$msg= ' \\n'. $dn.' - - '.$item.' - - number of FOR hours, days, weeks not entered';
			$msg_ord = $msg_ord.' '.$msg;}	
		}
// summarize order messages
	if(empty($msg_ord)){	// if no errors		
		$msg= ' \\n'. $dn.' - - Drug Order for '.$item .':  '.$nunits.' '.$unit.'  every '.$every.' '.$evperiod.'  for '.$fornum.' '.$forperiod;
		$msgcombo = $msgcombo.' '.$msg;
	} else { // add failed message
		$msgcombo = $msgcombo.' '.$msg_ord.' \\n'. ' * * * * * * * ORDER FAILED * * * * * * * *  '.' \\n';	
	}	

if (isset($item) AND !empty($item) AND !empty($nunits) AND !empty($fornum) AND $tstevery == 'true') { //
  $insertSQL = sprintf("INSERT INTO orders (medrecnum, visitid, feeid, status, rate, ratereason, billstatus, item, nunits, unit, every, evperiod, fornum, forperiod, ofee, amtdue, amtpaid, urgency, doctor, comments, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "text"),
                       GetSQLValueString($_POST['visitid'], "int"),
                       GetSQLValueString($_POST['feeid'], "int"),
                       GetSQLValueString('RxOrdered', "text"),
                       GetSQLValueString($_POST['rate'], "int"),
                       GetSQLValueString($_POST['ratereason'], "int"),
                       GetSQLValueString('Ordered', "text"),
                       GetSQLValueString($item, "text"),
                       GetSQLValueString($nunits, "int"),
                       GetSQLValueString($unit, "text"),
                       GetSQLValueString($every, "int"),
                       GetSQLValueString($evperiod, "text"),
                       GetSQLValueString($fornum, "int"),
                       GetSQLValueString($forperiod, "text"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString(0, "int"),
                       GetSQLValueString($_POST['urgency'], "text"),
                       GetSQLValueString($_POST['doctor'], "text"),
                       GetSQLValueString($_POST['comments_5'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));
  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());
  
// check for empty date or time  
	if((empty($scheddt) && !empty($schedtime)) or (!empty($scheddt) && empty($schedtime))) {
				$msg= ' \\n'. $dn.' - - '.$item.' - - Date or Time not entered: Order not scheduled';
				$msgcombo = $msgcombo.' '.$msg;
	}
		

  if(!empty($scheddt) AND !empty($schedtime)) {  
	$schedt = strtotime($scheddt.' '.$schedtime);

	mysql_select_db($database_swmisconn, $swmisconn);   // find thge receipt number
	$query_maxid = "SELECT MAX(id) mxid from orders where visitid = ".$_POST['visitid']."";  
	$maxid = mysql_query($query_maxid, $swmisconn) or die(mysql_error());
	$row_maxid = mysql_fetch_assoc($maxid);
	$totalRows_maxid = mysql_num_rows($maxid);
  
	$begin = 0;
	$interval = 0;
	$end = 0;
 	$begin = $schedt;
	echo 'Begin: '.$begin. ' - '. date('Y-m-d h:i', $begin)."<br />";
    if(isset($evperiod)) {  // calculate interval in seconds
	   if($evperiod == 'minutes') {
	   		$interval = $every * 60; }
	   if($evperiod == 'hour(s)') {
	   		$interval = $every * 60 * 60; }
	   if($evperiod == 'day(s)') {
	   		$interval = $every * 60 * 60 * 24; }
	   if($evperiod == 'week(s)') {
	   		$interval = $every * 60 * 60 * 24 * 7; }
	   if($evperiod == 'OD') {
	   		$interval = 60 * 60 * 24; }
	   if($evperiod == 'Nocte') {
	   		$interval = 60 * 60 * 24; }
	   if($evperiod == 'BD') {
	   		$interval = 60 * 60 * 12; }
	   if($evperiod == 'TDS') {
	   		$interval = 60 * 60 * 8; }
	   if($evperiod == 'QDS') {
	   		$interval = 60 * 60 * 6; }
	   if($evperiod == 'PRN') {
	   		$interval = 60 * 60 * 24; }
	   if($evperiod == 'STAT') {
	   		$interval = 60 * 60 * 24; }
    } //$interval
	echo 'interval: '.$interval. ' - '. date('i', $interval)."<br />";
    if(isset($forperiod)) {
	   if($forperiod == 'minutes') {  // calculate end time in numeric format
	   		$end = $schedt + ($fornum * 60); }
	   if($forperiod == 'hour(s)') {
	   		$end = $schedt + ($fornum * 60 * 60); }
	   if($forperiod == 'day(s)') {
	   		$end = $schedt + ($fornum * 60 * 60 * 24); }
	   if($forperiod == 'week(s)') {
	   		$end = $schedt + ($fornum * 60 * 60 * 24 * 7); }
    } // $end
	echo 'end: '.$end. ' - '. date('Y-m-d h:i', $end)."<br />"."<br />";
	//exit;
	$zzz = 0;
		for ($dt = $begin; $dt < $end; $dt+=($interval)) {
   $zzz = $zzz + 1;	
   if($zzz > 20){
	   exit; }		
  $insertSQL = sprintf("INSERT INTO ipmeds (visitid, orderid, med, status, unit, nunits, schedt, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['visitid'], "int"),
                       GetSQLValueString($row_maxid['mxid'], "int"),
                       GetSQLValueString($item, "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($unit, "text"),
                       GetSQLValueString($nunits, "int"),
                       GetSQLValueString($dt, "int"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));
  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());
		} //datetime loop

				//if ($showinput == 'Y') {
//						echo 'item '.$item; ?><br/><?php
//						echo 'nunits '.$nunits; ?><br/><?php
//						echo 'unit '.$unit; ?><br/><?php
//						echo 'every '.$every; ?><br/><?php
//						echo 'evperiod '.$evperiod; ?><br/><?php
//						echo 'fornum '.$fornum; ?><br/><?php
//						echo 'forperiod '.$forperiod; ?><br/><?php
//						echo 'comments '.$comments; ?><br/><?php
//						echo 'scheddt '.$scheddt; ?><br/><?php
//						echo 'schedtime '.$schedtime; ?><br/><?php
//
//				}
				} // if Sched dt&time
  			} // item
		}// check for any data
	} //loop
// for ($m=0; $m<6; $m++) {
//	 $mymsg = $msg.$formnmb[$m] ;
 if(!empty($msgcombo)) {
	function phpAlert($msg) {
		 echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}
	phpAlert( $msgcombo ); 
  }
// }
?>
	<script>function out(){opener.location.reload(1); self.close()};</script>
    <script> out();</script>
<?php 
} //  if Submit ?>


<?php
 $colname_patype = 'InPatient';
 if(isset($_GET['patype'])) {  
 $colname_patype = (get_magic_quotes_gpc()) ? $_GET['patype'] : addslashes($_GET['patype']);
 }
 $colname_mrn = 3434;
 if(isset($_GET['mrn'])) {  
 $colname_mrn = (get_magic_quotes_gpc()) ? $_GET['mrn'] : addslashes($_GET['mrn']);
 }
//PATIENT
	mysql_select_db($database_swmisconn, $swmisconn);
	$query_patient = "SELECT lastName, firstName, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,dob)),'%y') AS age, gender FROM patperm WHERE medrecnum = ".$colname_mrn;
	$patient = mysql_query($query_patient, $swmisconn) or die(mysql_error());
	$row_patient = mysql_fetch_assoc($patient);
	$totalRows_patient = mysql_num_rows($patient);
//DOCTOR
	mysql_select_db($database_swmisconn, $swmisconn);
	$query_doctor = "SELECT userid FROM users WHERE active = 'Y' and docflag = 'Y' ORDER BY userid ASC";
	$doctor = mysql_query($query_doctor, $swmisconn) or die(mysql_error());
	$row_doctor = mysql_fetch_assoc($doctor);
	$totalRows_doctor = mysql_num_rows($doctor);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>RxMultiOrder3</title>

<script language="JavaScript" src="../../javascript_form/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
<script language="JavaScript" type="text/JavaScript">
//<!--
function out(){
	opener.location.reload(1); //This updates the data on the calling page
	  self.close();
}
//-->
</script>

<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table align="center">
   <tr>
      <td>
	     <form id="formrx0" name="formrx0" method="post" action=""> 
         <table width="20%" align="center">
			<tr>
			   <td><div align="center"><input name="button" style="background-color:#f81829" type="button" onClick="out()" value="Close" /></div></td>			  			   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			   <td colspan="3" nowrap="nowrap"><div align="center" class="BlueBold_20">ORDER DRUG </div></td>
  			   <td>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</td>
			   <td class="BlueBold_16"><?php echo $colname_patype ?></td>
  			   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			   <td nowrap="nowrap" bgcolor="#FFFFFF" class="BlackBold_16"><?php echo $row_patient['lastName'].', '.$row_patient['firstName'].' Age: '.$row_patient['age'].' Gender: '.$row_patient['gender']; ?></td>
 			   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		      <td><div align="center"><input name="button" style="background-color:#f81829" type="button" onClick="out()" value="Close" /></div></td>
			</tr>
         </table>








<!--##########################################################################################	-->	 
		  <table><tr><td class="BlackBold_11">&nbsp;</td></tr></table>


<!--******** Beginning Of 0  ****************************************-->
        <table border="1" align="center" bgcolor="#BCFACC">
          <tr>
            <td colspan="5" nowrap="nowrap"><div align="center"><span class="BlueBold_14">Prescriptions</span> </div></td>
          </tr>
             <tr>
              <td bgcolor="#000000" colspan="5" nowrap="nowrap"><div class="borderbottomthinblackBold14"> </div></td>
            </tr>
          <tr>
            <td><div align="right" class="Black_11">Drug:</div></td>
            <td><input name="item_0" type="text" class="BlackBold_11" id="item_0" size="30" maxlength="100" data-validation="length" data-validation-length="min2" /></td>
            <td align="right" nowrap="nowrap"><input name="nunits_0" type="text" class="BlackBold_11" id="nunits_0" size="2" maxlength="5" data-validation="length" />
                <select name="unit_0" class="BlackBold_11" id="unit_0">
                <option value="ml">ml</option>
                <option value="mg">mg</option>
                <option value="iu">iu</option>
                <option value="ug">ug</option>
                <option value="tabs/caps">tabs/caps</option>
              </select>			</td>
            <td class="Black_11"> Every
              <input name="every_0" type="text" class="BlackBold_11" id="every_0" size="2" maxlength="5" />
              <select name="evperiod_0" class="BlackBold_11" id="evperiod_0">
                  <option value="OD">OD</option>
                  <option value="Nocte">Nocte</option>
                  <option value="BD">BD</option>
                  <option value="TDS">TDS</option>
                  <option value="QDS">QDS</option>
                  <option value="PRN">PRN</option>
                  <option value="STAT">STAT</option>
                  <option value="minutes">minutes</option>
                <option value="hour(s)">hour(s)</option>
                  <option value="day(s)">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
            <td class="Black_11"> for
              <input name="fornum_0" type="text" class="BlackBold_11" id="fornum_0" size="2" maxlength="5" data-validation="length"/>
              <select name="forperiod_0" class="BlackBold_11" id="forperiod_0">
                  <option value="minutes">minutes</option>
                  <option value="hour(s)">hour(s)</option>
                  <option value="day(s)" selected="selected">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="right" class="Black_11" nowrap="nowrap">            Comments:</td>
          <td colspan="2" nowrap="nowrap"><textarea name="comments_0" cols="50" rows="1" class="BlackBold_11" id="comments_0"></textarea></td>
            <?php if($colname_patype == 'InPatient'){?>
          
          <td nowrap="nowrap" align="right" title="Inpatient only!"><input name="scheddt_0" type="text" class="BlackBold_11" id="scheddt_0" size="12" maxlength="15"/></td>
			  <td nowrap="nowrap" align="left"><input name="schedtime_0" type="text" class="BlackBold_11" id="schedtime_0" size="8" maxlength="10" /></td>
		<?php } else {?>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
		<?php }?>
          </tr>
		  </table>
		  
 <!--******** End Of 0  ****************************************-->
        
<!--******** Beginning Of _1  ****************************************-->

        <table border="1" align="center" bgcolor="#BCFACC">
             <tr>
              <td bgcolor="#000000" colspan="5" nowrap="nowrap"><div class="borderbottomthinblackBold14"> </div></td>
            </tr>
          <tr>
            <td><div align="right" class="Black_11">Drug:</div></td>
            <td><input name="item_1" type="text" class="BlackBold_11" id="item_1" size="30" maxlength="100" /></td>
            <td align="right" nowrap="nowrap"><input name="nunits_1" type="text" class="BlackBold_11" id="nunits_1" size="2" maxlength="5" />
              <select name="unit_1" class="BlackBold_11" id="unit_1">
                <option value="ml">ml</option>
                <option value="mg">mg</option>
                <option value="iu">iu</option>
                <option value="ug">ug</option>
                <option value="tabs/caps">tabs/caps</option>
              </select></td>
            <td class="Black_11"> Every
              <input name="every_1" type="text" class="BlackBold_11" id="every_1" size="2" maxlength="5" />
              <select name="evperiod_1" class="BlackBold_11" id="evperiod_1">
                  <option value="OD">OD</option>
                  <option value="Nocte">Nocte</option>
                  <option value="BD">BD</option>
                  <option value="TDS">TDS</option>
                  <option value="QDS">QDS</option>
                  <option value="PRN">PRN</option>
                  <option value="STAT">STAT</option>
                  <option value="minutes">minutes</option>
                  <option value="hour(s)">hour(s)</option>
                  <option value="day(s)">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
            <td class="Black_11"> for
              <input name="fornum_1" type="text" class="BlackBold_11" id="fornum_1" size="2" maxlength="5" />
              <select name="forperiod_1" class="BlackBold_11" id="forperiod_1">
                  <option value="minutes">minutes</option>
                  <option value="hour(s)">hour(s)</option>
                  <option value="day(s)" selected="selected">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="right" class="Black_11" nowrap="nowrap">            Comments:</td>
          <td colspan="2" nowrap="nowrap"><textarea name="comments_1" cols="50" rows="1" class="BlackBold_11" id="comments_1"></textarea></td>
            <?php if($colname_patype == 'InPatient'){?>
          
          <td nowrap="nowrap" align="right" title="Inpatient only!"><input name="scheddt_1" type="text" class="BlackBold_11" id="scheddt_1" size="12" maxlength="15"/></td>
			  <td nowrap="nowrap" align="left"><input name="schedtime_1" type="text" class="BlackBold_11" id="schedtime_1" size="8" maxlength="10" /></td>
		<?php } else {?>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
		<?php }?>
          </tr>
		  </table>
		  
 <!--******** End Of _1 ****************************************-->

<!--******** Beginning Of _2  ****************************************-->
        <table border="1" align="center" bgcolor="#BCFACC">
             <tr>
              <td bgcolor="#000000" colspan="5" nowrap="nowrap"><div class="borderbottomthinblackBold14"> </div></td>
            </tr>
          <tr>
            <td><div align="right" class="Black_11">Drug:</div></td>
            <td><input name="item_2" type="text" class="BlackBold_11" id="item_2" size="30" maxlength="100" /></td>
            <td align="right" nowrap="nowrap"><input name="nunits_2" type="text" class="BlackBold_11" id="nunits_2" size="2" maxlength="5" />
                <select name="unit_2" class="BlackBold_11" id="unit_2">
                <option value="ml">ml</option>
                <option value="mg">mg</option>
                <option value="iu">iu</option>
                <option value="ug">ug</option>
                <option value="tabs/caps">tabs/caps</option>
              </select>			</td>
            <td class="Black_11"> Every
              <input name="every_2" type="text" class="BlackBold_11" id="every_2" size="2" maxlength="5" />
              <select name="evperiod_2" class="BlackBold_11" id="evperiod_2">
                  <option value="OD">OD</option>
                  <option value="Nocte">Nocte</option>
                  <option value="BD">BD</option>
                  <option value="TDS">TDS</option>
                  <option value="QDS">QDS</option>
                  <option value="PRN">PRN</option>
                  <option value="STAT">STAT</option>
                  <option value="minutes">minutes</option>
                <option value="hour(s)">hour(s)</option>
                  <option value="day(s)">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
            <td class="Black_11"> for
              <input name="fornum_2" type="text" class="BlackBold_11" id="fornum_2" size="2" maxlength="5" />
              <select name="forperiod_2" class="BlackBold_11" id="forperiod_2">
                  <option value="minutes">minutes</option>
                  <option value="hour(s)">hour(s)</option>
                  <option value="day(s)" selected="selected">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" align="right" class="Black_11">            Comments:</td>
          <td colspan="2" nowrap="nowrap"><textarea name="comments_2" cols="50" rows="1" class="BlackBold_11" id="comments_2"></textarea></td>
            <?php if($colname_patype == 'InPatient'){?>
          
          <td  align="right" nowrap="nowrap" title="Inpatient only!"><input name="scheddt_2" type="text" class="BlackBold_11" id="scheddt_2" size="12" maxlength="15"/></td>
			  <td  align="left" nowrap="nowrap"><input name="schedtime_2" type="text" class="BlackBold_11" id="schedtime_2" size="8" maxlength="10" /></td>
		<?php } else {?>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
		<?php }?>
          </tr>
		  </table>
		  
 <!--******** End Of _2  ****************************************-->


<!--******** Beginning Of _3  ****************************************-->
        <table border="1" align="center" bgcolor="#BCFACC">
             <tr>
              <td bgcolor="#000000" colspan="5" nowrap="nowrap"><div class="borderbottomthinblackBold14"> </div></td>
            </tr>
          <tr>
            <td><div align="right" class="Black_11">Drug:</div></td>
            <td><input name="item_3" type="text" class="BlackBold_11" id="item_3" size="30" maxlength="100" /></td>
            <td align="right" nowrap="nowrap"><input name="nunits_3" type="text" class="BlackBold_11" id="nunits_3" size="2" maxlength="5" />
                <select name="unit_3" class="BlackBold_11" id="unit_3">
                <option value="ml">ml</option>
                <option value="mg">mg</option>
                <option value="iu">iu</option>
                <option value="ug">ug</option>
                <option value="tabs/caps">tabs/caps</option>
              </select>			</td>
            <td class="Black_11"> Every
              <input name="every_3" type="text" class="BlackBold_11" id="every_3" size="2" maxlength="5" />
              <select name="evperiod_3" class="BlackBold_11" id="evperiod_3">
                  <option value="OD">OD</option>
                  <option value="Nocte">Nocte</option>
                  <option value="BD">BD</option>
                  <option value="TDS">TDS</option>
                  <option value="QDS">QDS</option>
                  <option value="PRN">PRN</option>
                  <option value="STAT">STAT</option>
                  <option value="minutes">minutes</option>
                <option value="hour(s)">hour(s)</option>
                  <option value="day(s)">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
            <td class="Black_11"> for
              <input name="fornum_3" type="text" class="BlackBold_11" id="fornum_3" size="2" maxlength="5" />
              <select name="forperiod_3" class="BlackBold_11" id="forperiod_3">
                  <option value="minutes">minutes</option>
                  <option value="hour(s)">hour(s)</option>
                  <option value="day(s)" selected="selected">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="right" class="Black_11" nowrap="nowrap">            Comments:</td>
          <td colspan="2" nowrap="nowrap"><textarea name="comments_3" cols="50" rows="1" class="BlackBold_11" id="comments_3"></textarea></td>
            <?php if($colname_patype == 'InPatient'){?>
          
          <td  align="right" nowrap="nowrap" title="Inpatient only!"><input name="scheddt_3" type="text" class="BlackBold_11" id="scheddt_3" size="12" maxlength="15"/></td>
			  <td  align="left" nowrap="nowrap"><input name="schedtime_3" type="text" class="BlackBold_11" id="schedtime_3" size="8" maxlength="10" /></td>
		<?php } else {?>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
		<?php }?>
          </tr>
		  </table>
		  
 <!--******** End Of _3  ****************************************-->


<!--******** Beginning Of _4  ****************************************-->
        <table border="1" align="center" bgcolor="#BCFACC">
             <tr>
              <td bgcolor="#000000" colspan="5" nowrap="nowrap"><div class="borderbottomthinblackBold14"> </div></td>
            </tr>
          <tr>
            <td><div align="right" class="Black_11">Drug:</div></td>
            <td><input name="item_4" type="text" class="BlackBold_11" id="item_4" size="30" maxlength="100" /></td>
            <td align="right" nowrap="nowrap"><input name="nunits_4" type="text" class="BlackBold_11" id="nunits_4" size="2" maxlength="5" />
                <select name="unit_4" class="BlackBold_11" id="unit_4">
                <option value="ml">ml</option>
                <option value="mg">mg</option>
                <option value="iu">iu</option>
                <option value="ug">ug</option>
                <option value="tabs/caps">tabs/caps</option>
              </select>			</td>
            <td class="Black_11"> Every
              <input name="every_4" type="text" class="BlackBold_11" id="every_4" size="2" maxlength="5" />
              <select name="evperiod_4" class="BlackBold_11" id="evperiod_4">
                  <option value="OD">OD</option>
                  <option value="Nocte">Nocte</option>
                  <option value="BD">BD</option>
                  <option value="TDS">TDS</option>
                  <option value="QDS">QDS</option>
                  <option value="PRN">PRN</option>
                  <option value="STAT">STAT</option>
                  <option value="minutes">minutes</option>
                <option value="hour(s)">hour(s)</option>
                  <option value="day(s)">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
            <td class="Black_11"> for
              <input name="fornum_4" type="text" class="BlackBold_11" id="fornum_4" size="2" maxlength="5" />
              <select name="forperiod_4" class="BlackBold_11" id="forperiod_4">
                  <option value="minutes">minutes</option>
                  <option value="hour(s)">hour(s)</option>
                  <option value="day(s)" selected="selected">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="right" class="Black_11" nowrap="nowrap">            Comments:</td>
          <td colspan="2" nowrap="nowrap"><textarea name="comments_4" cols="50" rows="1" class="BlackBold_11" id="comments_4"></textarea></td>
            <?php if($colname_patype == 'InPatient'){?>
          
          <td  align="right" nowrap="nowrap" title="Inpatient only!"><input name="scheddt_4" type="text" class="BlackBold_11" id="scheddt_4" size="12" maxlength="15"/></td>
			  <td  align="left" nowrap="nowrap"><input name="schedtime_4" type="text" class="BlackBold_11" id="schedtime_4" size="8" maxlength="10" /></td>
		<?php } else {?>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
		<?php }?>
          </tr>
		  </table>
		  
 <!--******** End Of _4  ****************************************-->


<!--******** Beginning Of _5  ****************************************-->

        <table border="1" align="center" bgcolor="#BCFACC">
             <tr>
              <td bgcolor="#000000" colspan="5" nowrap="nowrap"><div class="borderbottomthinblackBold14"> </div></td>
            </tr>
          <tr>
            <td><div align="right" class="Black_11">Drug:</div></td>
            <td><input name="item_5" type="text" class="BlackBold_11" id="item_5" size="30" maxlength="100" /></td>
            <td align="right" nowrap="nowrap"><input name="nunits_5" type="text" class="BlackBold_11" id="nunits_5" size="2" maxlength="5" />
              <select name="unit_5" class="BlackBold_11" id="unit_5">
                <option value="ml">ml</option>
                <option value="mg">mg</option>
                <option value="iu">iu</option>
                <option value="ug">ug</option>
                <option value="tabs/caps">tabs/caps</option>
              </select></td>
            <td class="Black_11"> Every
              <input name="every_5" type="text" class="BlackBold_11" id="every_5" size="2" maxlength="5" />
              <select name="evperiod_5" class="BlackBold_11" id="evperiod_5">
                  <option value="OD">OD</option>
                  <option value="Nocte">Nocte</option>
                  <option value="BD">BD</option>
                  <option value="TDS">TDS</option>
                  <option value="QDS">QDS</option>
                  <option value="PRN">PRN</option>
                  <option value="STAT">STAT</option>
                  <option value="minutes">minutes</option>
                  <option value="hour(s)">hour(s)</option>
                  <option value="day(s)">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
            <td class="Black_11"> for
              <input name="fornum_5" type="text" class="BlackBold_11" id="fornum_5" size="2" maxlength="5" />
              <select name="forperiod_5" class="BlackBold_11" id="forperiod_5">
                  <option value="minutes">minutes</option>
                  <option value="hour(s)">hour(s)</option>
                  <option value="day(s)" selected="selected">day(s)</option>
                  <option value="week(s)">week(s)</option>
            </select>            </td>
          </tr>
          <tr>
            <td align="right" nowrap="nowrap" class="Black_11">            Comments:</td>
          <td colspan="2" nowrap="nowrap"><textarea name="comments_5" cols="50" rows="1" class="BlackBold_11" id="comments_5"></textarea></td>
            <?php if($colname_patype == 'InPatient'){?>
          
          <td  align="right" nowrap="nowrap" title="Inpatient only!"><input name="scheddt_5" type="text" class="BlackBold_11" id="scheddt_5" size="12" maxlength="15"/></td>
			  <td  align="left" nowrap="nowrap"><input name="schedtime_5" type="text" class="BlackBold_11" id="schedtime_5" size="8" maxlength="10" /></td>
		<?php } else {?>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
			  <td nowrap="nowrap" class="Black_11">&nbsp;</td>
		<?php }?>
          </tr>
		  </table>
		  
 <!--******** End Of _5 ****************************************-->



		        <!--<input name="quant" type="hidden" id="quant" value=""/> --> 
				<input name="medrecnum" type="hidden" id="medrecnum" value="<?php echo $_SESSION['mrn']; ?>" />
				<input name="visitid" type="hidden" id="visitid" value="<?php echo $_SESSION['vid']; ?>" />
				<input name="feeid" type="hidden" id="feeid" value="30" />
				<input name="ratereason" type="hidden" id="ratereason" value="103" />
				<input name="rate" type="hidden" id="rate" value="100" />
				<input type="hidden" name="status" value="ordered"/>
				<input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
				<input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i"); ?>" />

         <table width="20%" align="center">
			<tr>
			   <td><div align="center">
			     <input name="button2" style="background-color:#f81829" type="button" onClick="out()" value="Close" />
			   </div></td>      
			  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			   <td colspan="3" nowrap="nowrap"><div align="center" class="BlueBold_20">ORDER DRUG </div></td>

			   <td colspan="2" nowrap="nowrap">Urgency:
				 <select name="urgency" id="urgency">
				  <option value="Routine">Routine</option>
				  <option value="Scheduled">Scheduled</option>
				  <option value="ASAP">ASAP</option>
				  <option value="STAT">STAT</option>
				</select>
				Doctor:
				<select name="doctor">
				  <option value="NA">NA</option>
				  <?php do { ?>
 
				<option value="<?php echo $row_doctor['userid']?>"<?php if (!(strcmp($row_doctor['userid'], $_SESSION['user']))) {echo "selected=\"selected\"";} ?>><?php echo $row_doctor['userid']?></option>
				  <?php }
 while ($row_doctor = mysql_fetch_assoc($doctor));
  $rows = mysql_num_rows($doctor);
  if($rows > 0) {
      mysql_data_seek($doctor, 0);
	  $row_doctor = mysql_fetch_assoc($doctor);
  }
?>
				</select></td>
			  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		       <td  align="right" nowrap="nowrap"><input name="SubmitAll" type="submit" value="Add Orders" /></td>
			</tr>
         </table>
         </form>
      </td>
   </tr>
</table>


  <script  type="text/javascript">
   var frmvalidator = new Validator("formrx0");
 //frmvalidator.EnableMsgsTogether();

 frmvalidator.addValidation("doctor","dontselect=Select", "Please Select Doctor");
</script>

<script type="text/javascript" src="../../nogray_js/1.2.2/ng_all.js"></script>
<script type="text/javascript" src="../../nogray_js/1.2.2/components/calendar.js"></script>
<script type="text/javascript" src="../../nogray_js/1.2.2/components/timepicker.js"></script>
<script type="text/javascript">
ng.ready( function() {

	    var my_cal = new ng.Calendar({
        input:'scheddt_0'
    });
    var my_timepicker = new ng.TimePicker({
        input:'schedtime_0',
    });   
  
	    var my_cal = new ng.Calendar({
        input:'scheddt_1'
    });
    var my_timepicker = new ng.TimePicker({
        input:'schedtime_1',
    });   
  
	    var my_cal = new ng.Calendar({
        input:'scheddt_2'
    });
    var my_timepicker = new ng.TimePicker({
        input:'schedtime_2',
    });   
  
	    var my_cal = new ng.Calendar({
        input:'scheddt_3'
    });
    var my_timepicker = new ng.TimePicker({
        input:'schedtime_3',
    });   
  
	    var my_cal = new ng.Calendar({
        input:'scheddt_4'
    });
    var my_timepicker = new ng.TimePicker({
        input:'schedtime_4',
    });   
  
	    var my_cal = new ng.Calendar({
        input:'scheddt_5'
    });
    var my_timepicker = new ng.TimePicker({
        input:'schedtime_5',
    });   
  

});

</script>

</body>
</html>
