<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php
$colname_notetype = "";
if (isset($notetype)) {
    $colname_notetype = $notetype;
} else {
  if (isset($_GET['notetype'])){
    $colname_notetype = $_GET['notetype'];
  	}
 } 
$colid_mrn = "-1";
if (isset($_GET['mrn'])) {
  $colid_mrn = (get_magic_quotes_gpc()) ? $_GET['mrn'] : addslashes($_GET['mrn']);
}
else {
 if(isset($_SESSION['mrn'])) {
  $colid_mrn = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']); 
 }
}

$colid_visit = "-1";
if (isset($_GET['vid'])) {
  $colid_visit = (get_magic_quotes_gpc()) ? $_GET['vid'] : addslashes($_GET['vid']);
}
else {
 if(isset($_SESSION['vid'])) {
  $colid_visit = (get_magic_quotes_gpc()) ? $_SESSION['vid'] : addslashes($_SESSION['vid']); 
 }
}

mysql_select_db($database_swmisconn, $swmisconn);
$query_notes = "SELECT id, medrecnum, visitid, ordid, notetype, notes, temp, pulse, bp_sys, bp_dia, entryby, DATE_FORMAT(entrydt,'%d-%b-%Y  %H:%i') entrydt FROM patnotes WHERE notetype like '".$colname_notetype."%' and visitid = '".$colid_visit."' Order by id";
$notes = mysql_query($query_notes, $swmisconn) or die(mysql_error());
$row_notes = mysql_fetch_assoc($notes);
$totalRows_notes = mysql_num_rows($notes);
?>

<?php $notetitle = "";
 	if($colname_notetype <> "%"){
    $notetitle = $colname_notetype; 
} ?>

<?php mysql_select_db($database_swmisconn, $swmisconn);
$query_pt = "SELECT ptflag FROM users WHERE active = 'Y' and userid = '".$_SESSION['user']."' ORDER BY userid ASC";
$pt = mysql_query($query_pt, $swmisconn) or die(mysql_error());
$row_pt = mysql_fetch_assoc($pt);
$totalRows_pt = mysql_num_rows($pt);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<script src="../../tinymce/js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({ 
  	//selector:'textarea#visitreason',
	mode : 'textareas',
	editor_selector : 'notes',   //textarea  must have class="notes"
	content_css : '../../CSS/content.css',
	//inline: true,
	min_height: 20,
	width: 600,
    plugins: 'autoresize, preview',
	autoresize_max_height: 50,
	autoresize_min_height: 20,
	autoresize_bottom_margin: 1,
	//readonly: true,  //inactivates toolbar too so preview doesn't work, but textarea is readonly
	menubar: false,
	statusbar: false,
	toolbar: 'preview'
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
<!-- if no notes and not % allow adding notes for that notetype-->
<?php if($totalRows_notes == 0 and $colname_notetype <> "%"){?>

<table width="50%" border="1" align="center">
  <tr>
    <td nowrap="nowrap"><div align="center" class="BlueBold_14"><span class="BlackBold_16">No <?php echo $notetitle ?> Notes Yet</span> -----> <a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatNotesAdd.php&notetype=<?php echo $notetitle ?>">Add</a></div></td>
  </tr>
</table>
<?php } ?>


<?php if($totalRows_notes >= 1) { 
?>

		<form id="form1" name="form1" method="post" action="">
<table align="center">
  <tr>
    <td>
      <table>
        <?php if((allow(27,3) == 1 and $colname_notetype == 'OutPatient') or (allow(37,3) == 1 and $colname_notetype == 'InpatientNurse') or (allow(38,3) == 1 and $colname_notetype == 'InpatientDoc') or (allow(48,3) == 1 and $colname_notetype == 'Radiology') or (allow(50,3) == 1 and $colname_notetype == 'PhysioTherapy' and $row_pt['ptflag']=='Y') or (allow(52,3) == 1 and $colname_notetype == 'Surgery') or $colname_notetype == '%') { ?>
          <?php	if($colname_notetype == '%'){ ?>
        <tr>
          <td><div align="right">Add Notes </div></td>
          <td width="50" class="nav11"><div align="center"><a href="PatShow1.php?mrn=<?php echo $colid_mrn; ?>&vid=<?php echo $colid_visit; ?>&visit=PatVisitView.php&act=inpat&pge=PatNotesAdd.php&notetype=OutPatient">Outpatient</a> </div></td>
          <td width="50" class="nav11"><div align="center"><a href="PatShow1.php?mrn=<?php echo $colid_mrn; ?>&vid=<?php echo $colid_visit; ?>&visit=PatVisitView.php&act=inpat&pge=PatNotesAdd.php&notetype=InPatientDoc">InPatientDoc</a></div></td>
          <td width="50" class="nav11"><div align="center"><a href="PatShow1.php?mrn=<?php echo $colid_mrn; ?>&vid=<?php echo $colid_visit; ?>&visit=PatVisitView.php&act=inpat&pge=PatNotesAdd.php&notetype=InPatientNurse">InPatientNurse</a></div></td>
          <td width="150">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="7"><div align="center" class="subtitlebl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View <?php echo $notetitle; ?> Notes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
        </tr>
        <?php }	else { ?>
	<tr>
  		<td><div align="center"><a href="PatShow1.php?mrn=<?php echo $colid_mrn; ?>&vid=<?php echo $colid_visit; ?>&visit=PatVisitView.php&act=inpat&pge=PatNotesAdd.php&notetype=<?php echo $colname_notetype; ?>">Add</a></div></td>
        <td colspan="7"><div align="center" class="subtitlebl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View <?php echo $notetitle; ?> Notes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
	</tr>
    <?php } 
 }?>
      <?php if((allow(27,2) == 1 and $colname_notetype == 'OutPatient') or (allow(37,2) == 1 and $colname_notetype == 'InpatientNurse') or (allow(38,2) == 1 and $colname_notetype == 'InpatientDoc') or (allow(48,2) == 1 and $colname_notetype == 'Radiology') or (allow(50,2) == 1 and $colname_notetype == 'PhysioTherapy' and $row_pt['ptflag']=='Y' ) or (allow(52,2) == 1 and $colname_notetype == 'Surgery') or $colname_notetype == '%') { ?>


<?php do { ?>
  <tr>
    <td valign="top" title="NoteID: <?php echo $row_notes['id']; ?>&#10;MedRecNum: <?php echo $row_notes['medrecnum']; ?>&#10;VisitID:<?php echo $row_notes['visitid']; ?>">
<?php 	if($row_notes['ordid'] > 0){ 
	mysql_select_db($database_swmisconn, $swmisconn);
	$query_ord = "SELECT o.id ordid, o.status, f.name FROM orders o join fee f on o.feeid = f.id WHERE o.id = '".$row_notes['ordid']."'";
	$ord = mysql_query($query_ord, $swmisconn) or die(mysql_error());
	$row_ord = mysql_fetch_assoc($ord);
	$totalRows_ord = mysql_num_rows($ord);
?>
      <strong>NOTES:<?php echo $row_ord['status']; ?><br />
	  </strong>Type:<strong><?php echo $row_notes['notetype']; ?></strong><br />
	  </strong>Ord:<strong><?php echo $row_ord['name']; ?></strong><br />
<?php }  else {?>
      <strong>NOTES:<br />
	  </strong>Type:<strong><?php echo $row_notes['notetype']; ?></strong><br />
<?php    }?>
      Date:<?php echo $row_notes['entrydt']; ?><br/>
      User:<?php echo $row_notes['entryby']; ?>
<?php if($colname_notetype <> '%'){     ?>
	  <a href="PatShow1.php?mrn=<?php echo $row_notes['medrecnum']; ?>&vid=<?php echo $row_notes['visitid']; ?>&visit=PatVisitView.php&act=inpat&pge=PatNotesEdit.php&notetype=<?php echo $colname_notetype; ?>&noteid=<?php echo $row_notes['id']; ?>"><br />
        <br />
        Edit </a></td>
<?php   } ?>
    <td colspan="8" title="<?php echo $row_notes['notes']; ?>"><textarea class="notes" name="notes" readonly="readonly" value="<?php echo $row_notes['notes']; ?>"><?php echo $row_notes['notes']; ?> </textarea></td>
    <td valign="top" nowrap="nowrap"><div align="right"> temp
            <input name="temp" type="text" readonly="readonly" style="text-align: right;" value="<?php echo $row_notes['temp']; ?>" size="2"/>
      <br />
      pulse
      <input name="pulse" type="text" readonly="readonly" style="text-align: right;" value="<?php echo $row_notes['pulse']; ?>" size="2"/>
      <br />
      systolic
      <input name="bp_sys" type="text" readonly="readonly" style="text-align: right;" value="<?php echo $row_notes['bp_sys']; ?>" size="2"/>
      <br />
      diastolic
      <input name="bp_dia" type="text" readonly="readonly" style="text-align: right;" value="<?php echo $row_notes['bp_dia']; ?>" size="2"/>
    </div></td>
  </tr>

  <?php } while ($row_notes = mysql_fetch_assoc($notes)); ?>
  <?php } ?>
	  </table>
    </td>
  </tr>
</table>
<?php } // if notes ?> 
    </form>



</body>
</html>
<?php
mysql_free_result($notes);
?>
