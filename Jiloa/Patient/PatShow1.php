<?php ob_start(); ?>
<?php  $pt = "Patient Show1"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?> 
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/functions/FileList.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php
// get the last visit record id and discharge date (if any)
$colname_medrecnum = "-1";
if (isset($_GET['mrn'])) {
  $colname_medrecnum = (get_magic_quotes_gpc()) ? $_GET['mrn'] : addslashes($_GET['mrn']);
}
else {
	if (isset($_SESSION['mrn'])) {
  $colname_medrecnum = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']);
	}
}
$_SESSION['mrn'] = $colname_medrecnum;  //set session mrn variable

$colname_vid = "-1"; 
if(isset($_GET['vid'])) {
$colname_vid = (get_magic_quotes_gpc()) ? $_GET['vid'] : addslashes($_GET['vid']);

$_SESSION['vid'] = $_GET['vid'];
	
mysql_select_db($database_swmisconn, $swmisconn);
$query_lastvisit = "SELECT id, discharge, pat_type, location FROM `patvisit` WHERE medrecnum = $colname_medrecnum and id = $colname_vid";
$lastvisit = mysql_query($query_lastvisit, $swmisconn) or die(mysql_error());
$row_lastvisit = mysql_fetch_assoc($lastvisit);
$totalRows_lastvisit = mysql_num_rows($lastvisit);
}
else {
 
//get last visit
mysql_select_db($database_swmisconn, $swmisconn);
$query_lastvisit = "SELECT id, discharge, pat_type, location FROM `patvisit` WHERE medrecnum = $colname_medrecnum and id = (Select MAX(id) FROM `patvisit` WHERE medrecnum = $colname_medrecnum)";
$lastvisit = mysql_query($query_lastvisit, $swmisconn) or die(mysql_error());
$row_lastvisit = mysql_fetch_assoc($lastvisit);
$totalRows_lastvisit = mysql_num_rows($lastvisit);

}
// count the number of visits for this patient
  $_SESSION['mrn'] == $colname_medrecnum;  //set session variable
mysql_select_db($database_swmisconn, $swmisconn);
$query_visits = sprintf("SELECT count(id) visits FROM patvisit WHERE medrecnum = %s", $colname_medrecnum);
$visits = mysql_query($query_visits, $swmisconn) or die(mysql_error());
$row_visits = mysql_fetch_assoc($visits);
$totalRows_visits = mysql_num_rows($visits);
$_SESSION['vnum'] = $row_visits['visits'];  //set session variable
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Show Patient</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
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
<!-- Display PATIENT PERMANENT Data  -->
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
		<td valign="top"><?php $patview = "PatPermView.php" ?>
		        		  <?php require_once($patview); ?></td>
  </tr>
</table>

<!--   DISPLAY PATIENT INFORMATION  -->
<?php
// If link includes a value for "show', set $applic to show PATIENT INFORMATION, otherwise patient info is not displayed by default
$applic="";
if (isset($_GET["show"])) {
	$applic = $_GET['show'];
?>
		<table align="center">
			<tr>
				<td valign="top"><?php require_once($applic); ?></td>
		  </tr>
		</table>
<?php } ?>

<!-- DISPLAY PATIENT VISIT -->
<?php
	if(isset($_GET['vid'])) {
		$_SESSION['vid'] = $_GET['vid'];
	}
	else {
	$_SESSION['vid'] = $row_lastvisit['id']; // make visit record number avialable to "PatVisitView.php" 
	}
// If link includes a value for "visit', set $visitapp to show patient visit view, edit, add, or delete panel
  if (isset($_GET["visit"])) {  
	$visitapp = $_GET['visit'];
 } 
 else {  // if no value for 'visit' is sent, or the last visit is discharged
    if ($row_lastvisit['id'] <=0 or $row_lastvisit['discharge'] <> "") {  //	// no visit or discharged 
	$_SESSION['visits'] = $row_visits['visits'];  // make this number available for PatVisitNoneOpen.php page
	$visitapp="PatVisitNoneOpen.php";  // Display message - No Open Visits
	} 
 	  else { // if there is no value for 'visit' but there is an undischarged visit
		$visitapp="PatVisitView.php";  
	  }   
 }?>
<table width="50%" height="15" border="5" align="center"  bordercolor="#336699">
	<tr>
    	<td colspan="8"><?php require_once($visitapp); ?></td>
	</tr>
</table>
<?php mysql_free_result($visits);?>

<?php // Count number of notes for a patient visit
  $colname_mrn2 = "-1";
	if (isset($_SESSION['mrn'])) {
  $colname_mrn2 = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']);
	}
  $colname_vid = "-1";
	if (isset($_SESSION['vid'])) {
  $colname_vid = (get_magic_quotes_gpc()) ? $_SESSION['vid'] : addslashes($_SESSION['vid']);
	}
    else {
		if (isset($_GET['vid'])) {
	  $colname_vid = (get_magic_quotes_gpc()) ? $_GET['vid'] : addslashes($_GET['vid']);
	  $_SESSION['vid'] = $_GET['vid'];//set session variable
		}
	}
  $colname_notetype = "%";
		if (isset($_GET['notetype'])) {
	  $colname_notetype = (get_magic_quotes_gpc()) ? $_GET['notetype'] : addslashes($_GET['notetype']);
  }
mysql_select_db($database_swmisconn, $swmisconn); //count notes
$query_notes = "SELECT count(id) notes FROM patnotes WHERE medrecnum = '".$colname_mrn2."' and visitid = '".$colname_vid."' and notetype = 'OutPatient'";
$notes = mysql_query($query_notes, $swmisconn) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);

mysql_select_db($database_swmisconn, $swmisconn); //count notes
$query_allnotes = "SELECT count(id) notes FROM patnotes WHERE medrecnum = '".$colname_mrn2."' and visitid = '".$colname_vid."' and notetype like '%'";
$allnotes = mysql_query($query_allnotes, $swmisconn) or die(mysql_error());
$row_allnotes = mysql_fetch_assoc($allnotes);
$totalRows_allnotes = mysql_num_rows($allnotes);

if(isset($_SESSION['mrn'])) {  //count PDFs
  $patmrn = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']); 
  $z = 0;
  $dirlist = getFileList("../../DATA_SWMIS/SCANSNAP/"); 
  foreach($dirlist as $file) {
	$pdfmrn = explode('x',basename($file['name']));
    if($pdfmrn[0] == $patmrn) {
      $z = $z + 1;
    }
  }
}

mysql_select_db($database_swmisconn, $swmisconn);  //count lab orders
$query_labs = sprintf("SELECT count(o.id) labs FROM orders o, fee f WHERE o.feeid = f.id and f.dept = 'Laboratory' and medrecnum = %s and visitid = %s", $colname_mrn2, $colname_vid);
$labs = mysql_query($query_labs, $swmisconn) or die(mysql_error());
$row_labs = mysql_fetch_assoc($labs);
$totalRows_labs = mysql_num_rows($labs);

mysql_select_db($database_swmisconn, $swmisconn);  //count Rad orders
$query_rads = sprintf("SELECT count(o.id) rads FROM orders o, fee f WHERE o.feeid = f.id and f.dept = 'Radiology' and medrecnum = %s and visitid = %s", $colname_mrn2, $colname_vid);
$rads = mysql_query($query_rads, $swmisconn) or die(mysql_error());
$row_rads = mysql_fetch_assoc($rads);
$totalRows_rads = mysql_num_rows($rads);

mysql_select_db($database_swmisconn, $swmisconn);  //count PT orders
$query_pts = sprintf("SELECT count(o.id) pts FROM orders o, fee f WHERE o.feeid = f.id and f.dept = 'Physiotherapy' and medrecnum = %s and visitid = %s", $colname_mrn2, $colname_vid);
$pts = mysql_query($query_pts, $swmisconn) or die(mysql_error());
$row_pts = mysql_fetch_assoc($pts);
$totalRows_pts = mysql_num_rows($pts);

mysql_select_db($database_swmisconn, $swmisconn);  //count Surg orders
$query_surgs = sprintf("SELECT count(o.id) surgs FROM orders o, fee f WHERE o.feeid = f.id and f.dept = 'Surgery' and medrecnum = %s and visitid = %s", $colname_mrn2, $colname_vid);
$surgs = mysql_query($query_surgs, $swmisconn) or die(mysql_error());
$row_surgs = mysql_fetch_assoc($surgs);
$totalRows_surgs = mysql_num_rows($surgs);


?>

<!-- DISPLAY VISIT ACTIVITIES MENU BAR  // If there is a visit displayed, show menu bar for subsequent activities -->
<?php  
	  if ($visitapp != "PatVisitList.php" and $visitapp != "PatVisitNoneOpen.php" and $visitapp != "PatVisitAdd.php" and $visitapp != "PatVisitDelete.php") { 
?>
<table align="center">
  <form id="form1" name="form1" method="GET"    />
  <tr>
 
<!--<td><input type="button" name="button72" class="btngradblu25" value="EX" href="javascript:void(0)" onclick="MM_openBrWindow('PatExamPopResultAdd.php?mrn=<?php echo $row_visitview['medrecnum']; ?>&visitid=<?php echo $row_visitview['id']; ?>&locfeeid=<?php echo $row_visitview['vfeeid']; ?>','StatusView','scrollbars=yes,resizable=yes,width=900,height=400')" /></td>-->

    <!-- display PDF button -->
    <td><input type="button" name="button4" class="btngradblu55" value="PDFs(<?php echo $z; ?>)" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=PDF&pge=PatPDFView.php'" /></td>
    <!-- display notes button -->
    <?php if(allow(27,3) == 1) {?>
    <?php if($row_lastvisit['pat_type'] == "OutPatient"){ ?>
    <?php if ($row_notes['notes'] == 0) {?>
    <!--and allow(27,1) == 3-->
    <!--if pat notes = 0, display notes ADD, otherwise display notes view-->
    <td><input type="button" name = "button8" class="btngradblu75" value="OP Notes(<?php echo $row_notes['notes']; ?>)" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&notepage=PatNotesAdd.php&notetype=OutPatient'" /></td>
    <?php }
	  else {?>
    <td><input type="button" name = "button9" class="btngradblu75"  value="OP Notes(<?php echo $row_notes['notes']; ?>)" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&notepage=PatNotesView.php&notetype=OutPatient'" /></td>
    <?php }?>
    <?php }?>
    <?php }?>
    <!-- display LAB ORDER button -->
    <?php if(allow(46,1) == 1) { ?>
    <td><input type="button" name = "button22" class="btngradblu80" value="Lab Orders(<?php echo $row_labs['labs']; ?>)" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=lab&pge=PatLabView.php'" /></td>
    <?php }?>
    <!-- display LAB RESULT button -->
    <td><input type="button" name="button" class="btngradblu65" value="Lab Results" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=lab&pge=PatLabResults.php'" /></td>
    <!-- display Radiology ORDER button -->
    <?php if(allow(47,1) == 1) { ?>
    <td><input type="button" name = "button23" class="btngradblu80" value="Rad Orders(<?php echo $row_rads['rads']; ?>)" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=lab&pge=PatRadView.php'" /></td>
    <?php }?>
    <!-- display PT ORDER button -->
    <?php if(allow(49,1) == 1) { ?>
    <td><input type="button" name = "button24" class="btngradblu75" value="PT Orders(<?php echo $row_pts['pts']; ?>)" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=lab&pge=PatPtView.php'" /></td>
    <?php }?>
    <!-- display Surgery ORDER button -->
    <?php if(allow(51,1) == 1) { ?>
    <td><input type="button" name = "button25" class="btngradblu85" value="Surg Orders(<?php echo $row_surgs['surgs']; ?>)" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=lab&pge=PatSurgView.php'" /></td>
    <?php }?>
    <!-- display Dental ORDER button -->
    <?php if(allow(54,2) == 1) { ?>
    <td><input type="button" name = "button26" class="btngradblu55" value="Dental" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=lab&pge=PatDentalView.php'" /></td>
    <?php }?>
    <!-- display Pharmacy button -->
    <?php if(allow(45,1) == 1) { ?>
    <td><div align="center">
      <input type="button" name="button3" class="btngradblu25" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=pharm&pge=PatPharmOrderView.php&patype=<?php echo $row_lastvisit['pat_type']; ?>'" value=" Rx" size="1" maxlength="2" />
    </div></td>
    <?php }?>
    <!-- display Scheduling button -->
    <?php if(allow(29,1) == 1) { ?>
    <td nowrap="nowrap"><input type="button" name="button" class="btngradblu60" value="Schedule" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=sched&pge=PatSchedule.php&loc=<?php echo $row_lastvisit['location']; ?>'" /></td>
    <!-- PatSchedView.php -->
    <?php }?>
    <!-- display History button -->
    <td nowrap="nowrap">
        <div align="center">
          <input type="button" name="button7" class="btngradblu50" value=" History" onclick="window.open('PatHistAll.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>', '_blank');" />
      </div></td>
    <!-- display Orders button -->
    <?php if(allow(30,1) == 1) { ?>
    <td><div align="center">
      <input type="button" name="button" class="btngradblu50" value=" Orders " onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=hist&pge=PatOrdersView.php'" />
    </div></td>
    <?php }?>
    <?php if($row_lastvisit['pat_type'] == "OutPatient"){ ?>
    <td><input type="button" name="button6222" class="btngradblu75" value="AllNotes (<?php echo $row_allnotes['notes']; ?>)" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatNotesView.php&notetype=%'" /></td>
    <?php }?>
  </tr>
</table> 
  <!--((((((((((((((( ANTENATAL ))))))))))))   ((((((((((((((( ANTENATAL ))))))))))))-->
 <table align="center">
  <?php if($row_lastvisit['pat_type'] == "Antenatal"){ ?>
  <tr>
    <!-- display preg  button -->
    <?php if(allow(30,1) == 1) { ?>
    <td><input type="button" name="button6" class="btngradblu50" value="Preg View" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePregView.php'" /></td>
    <td><input type="button" name="button5" class="btngradblu75" value="Prev Preg" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePrevPregView.php'" /></td>
  </tr>
  <?php  }
	 }?>
 </table>
 <table align="center">
  <!--((((((((((((((( InPatient ))))))))))))   ((((((((((((((( Inpatient ))))))))))))-->
  <?php if($row_lastvisit['pat_type'] == "InPatient"){ ?>
  <tr>
    <!-- display Inpatient  buttons -->
    <?php //if(allow(35,1) == 1) { ?>
    <!--<td ><input name="button622" class="btngradblu75" value="Admission" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatInPatAdmitView.php'" /></td>-->
    <?php // }?>
    <?php if(allow(44,1) == 1) { ?>
    <td ><input type="button" name="button622" class="btngradblu65" value="AllNotes(<?php echo $row_allnotes['notes']; ?>)" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatNotesView.php&notetype=%'" /></td>
    <?php }?>
    <?php if(allow(38,1) == 1) { ?>
    <td ><input type="button" name="button623" class="btngradblu80" value="Doctor Notes" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatNotesView.php&notetype=InpatientDoc'" /></td>
    <?php }?>
    <?php if(allow(36,1) == 1) { ?>
    <td ><input type="button" name="button62" class="btngradblu80" value="Nurse Orders" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo	 $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatNurseOrderView.php'" /></td>
    <?php }?>
    <?php if(allow(37,1) == 1) { ?>
    <td ><input type="button" name="button622" class="btngradblu75" value="Nurse Notes" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatNotesView.php&notetype=InpatientNurse'" /></td>
    <?php }?>
    <?php //if(allow(39,1) == 1) { ?>
    <!--<td ><input name="button623" class="btngradblu100" value="Doctor Orders" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatInPatDocOrdersView.php'" /></td>-->
    <?php //}?>
    <?php if(allow(40,1) == 1) { ?>
    <td><div align="center">
      <input type="button" name="button5" class="btngradblu50" value=" Vitals" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatInPatVitals.php'" />
    </div></td>
    <?php }?>
    <?php if(allow(41,1) == 1) { ?>
    <td><input type="button" name="button5" class="btngradblu50" value=" Meds" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatInPatMeds.php&medid=%'" /></td>
    <?php }?>
    <?php if(allow(42,1) == 1) { ?>
    <td><div align="center">
      <input type="button" name="button52" class="btngradblu50" value=" Fluids" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatInPatFluids.php'" />
    </div></td>
    <?php }?>
    <?php if(allow(43,1) == 1) { ?>
    <td ><input type="button" name="button62" class="btngradblu75" value="Discharge" onclick="parent.location='PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatInPatDischView.php'" /></td>
    <?php }?>
  </tr>
  <?php  } ?>
</table>
</form>
<?php // if current visit is not set in $_SESSION['vid'] set it to the last undischarged visit
		if (!isset($_SESSION['vid'])) {
			$_SESSION['vid'] = $row_lastvisit['id'];
		}
?>
<?php
   if (isset($_GET['act']) and isset($_GET['pge'])) {
		if ($_GET['act'] == 'PDF'){
			$actapp = $_GET['pge'];
		}
		if ($_GET['act'] == 'sched'){
			$actapp = $_GET['pge'];
		}
		if ($_GET['act'] == 'lab'){
			$actapp = $_GET['pge'];
		} 
		if ($_GET['act'] == 'pharm'){
			$actapp = $_GET['pge'];
		}
		if ($_GET['act'] == 'hist'){
			$actapp = $_GET['pge'];
		} 
		if ($_GET['act'] == 'ante'){
			$actapp = $_GET['pge'];
		} 
		if ($_GET['act'] == 'inpat'){
				$actapp = $_GET['pge'];
		} 
?>
<table align="center">
				<tr>
					<td valign="top"><?php require_once($actapp); ?></td>
				<tr>
</table>	

<?php } //if act ?>
          <!--if there is a current preg record i.e. not in previous pregnancies, display that record here-->
<?php if($row_lastvisit['pat_type'] == "Antenatal" && (!isset($_GET['act'])) ) {  
			 //adding && (!isset($_GET['notepage'])) allows standard notes to be displayed, else pregview is displayed
		$_GET['act'] = 'ante';
		$_GET['pge'] = 'PatAntePregView.php';
		$anteapp = $_GET['pge']; 
?>
			<table align="center">
				<tr>
					<td valign="top"><?php require_once($anteapp); ?></td>
				<tr>
			</table>	

<?php  }?>



<!-- DISPLAY NOTES --> <!--((((((((((((((( NOTES ))))))))))))   (((((((((((((((NOTES ))))))))))))-->

<?php if (!isset($_GET['act']) and $row_lastvisit['pat_type'] == "OutPatient" && allow(27,1) == 1) {?>

<?php 		if (isset($_SESSION['vid'])) {
				if($row_notes['notes'] > 0) {  // DON'T DISPLAY EMPTY VIEW NOTES 
					$notetype = 'OutPatient';
					$notesview = "PatNotesView.php"; ?>
				<table width="80%" align="center">
					<tr>
						<td valign="top"><?php require_once($notesview); ?></td>
					<tr>
				</table>	
<?php				}
				else{
					if(allow(27,3) == 1) {
					$notetype = 'OutPatient';
					$notesview = "PatNotesAdd.php"; ?>
					<table align="center">
						<tr>
							<td valign="top"><?php require_once($notesview); ?></td>
						<tr>
					</table>	
<?php				}
				}
?>

<?php 		}
	 	   if (isset($_GET['notepage'])) {
				$notesapp = $_GET['notepage'];
?> 
				<table  align="center">
					<tr>
						<td><?php require_once($notesapp); ?></td>
					</tr>
				</table>
<?php	 	   }
			} ?>
<?php  } //else not antenatal ?>
</body>
</html>
<?php
//mysql_free_result($patperm);

mysql_free_result($lastvisit);

ob_end_flush();
//mysql_free_result($notes);
?>
