<?php $pt = "Exam Setup Menu"; ?>
<?php if (session_status() == PHP_SESSION_NONE) {
    session_start(); }?>

<?php require_once('../../Connections/swmisconn.php'); ?>
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
  $saved = "";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
/* echo '<script type="text/javascript">alert("'.$_POST['location'].'");<//script>';
 exit;*/
// put other_text into a string by finding the exam ids (which are other_text names) and concatinating ids and other_text and store in db:other_arr field
	mysql_select_db($database_swmisconn, $swmisconn);
	$query_exami = "Select id, examname from exam_exam where active = 'Y' and locfeeid = ".$_POST['locfeeid']." order by seq ";
	$exami = mysql_query($query_exami, $swmisconn) or die(mysql_error());
	$row_exami = mysql_fetch_assoc($exami);
	$totalRows_exami = mysql_num_rows($exami);
	$vare = '';
	$other = 'x';
	do { 
 		$vare = $row_exami['id'];
 	    if(strlen($_POST["$vare"]) > 0) {
		  $other = $other  . $row_exami['id'] . ':'.$_POST["$vare"]. ',';  // $row_exami['id'] is exam number, $_POST["$vare"] is the text
        } 
    } while ($row_exami = mysql_fetch_assoc($exami));
        $other = substr($other,0,strlen($other)-1);
$chkexsy = "x";

if(isset($_POST['chk_ex_sy'])) {
           $chkexsy = $chkexsy.implode(',', $_POST['chk_ex_sy']).',';  //comma added to end of string to be used as a delimiter later

}
  $insertSQL = sprintf("INSERT INTO exam_result (medrecnum, visitid, exam_arr, other_arr, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "int"),
                       GetSQLValueString($_POST['visitid'], "int"),
                       GetSQLValueString($chkexsy, "text"),
					   GetSQLValueString($other, "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());
  $saved = "true";
  
}
 ?> 
<?php //require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php
$colname_medrecnum = "-1";
if (isset($_GET['mrn'])) {
  $colname_medrecnum = (get_magic_quotes_gpc()) ? $_GET['mrn'] : addslashes($_GET['mrn']);
}

$colname_visitid = "-1";
if (isset($_GET['visitid'])) {
  $colname_visitid = (get_magic_quotes_gpc()) ? $_GET['visitid'] : addslashes($_GET['visitid']);
}

//redirect to edit if previous exam for visit exists
mysql_select_db($database_swmisconn, $swmisconn);
$query_prevexam = "Select id from exam_result where medrecnum = '".$colname_medrecnum."' and visitid = '".$colname_visitid."'";
$prevexam = mysql_query($query_prevexam, $swmisconn) or die(mysql_error());
$row_prevexam = mysql_fetch_assoc($prevexam);
$totalRows_prevexam = mysql_num_rows($prevexam);

if($totalRows_prevexam > 0){
	  $insertGoTo = "PatExamPopResultEdit.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }

  header(sprintf("Location: %s", $insertGoTo));
  }


$colname_locfeeid = "-1";
if (isset($_GET['locfeeid'])) {
  $colname_locfeeid = (get_magic_quotes_gpc()) ? $_GET['locfeeid'] : addslashes($_GET['locfeeid']);
}

mysql_select_db($database_swmisconn, $swmisconn);
$query_exam = "Select id, examname from exam_exam where locfeeid = ".$colname_locfeeid." order by seq ";
$exam = mysql_query($query_exam, $swmisconn) or die(mysql_error());
$row_exam = mysql_fetch_assoc($exam);
$totalRows_exam = mysql_num_rows($exam);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
function out(){
	opener.location.reload(1); //This updates the data on the calling page
	  self.close();
}
</script>

</head>
<?php if($saved == "true") { ?>
	<body onload="out()">
	<?php }?>
<p>&nbsp;</p>

<table border="0" align="center">
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">  <!--action="ExamData.php"-->
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><div align="center">
        <input name="button" style="background-color:#f81829" type="button" onclick="out()" value="Close" /></div></td>
		<td>&nbsp;</td>
		<td><input name="submit" type="submit" value="Save" /></td>
		<td>&nbsp;</td>
	</tr>
  <?php do { ?>
    <tr>
      <td bgcolor="#DEEAFA" class="BlueBold_1414"><?php echo $row_exam['examname']; ?></td>
      <td bgcolor="#DEEAFA"><label>
        <input type="checkbox" name="chk_ex_sy[]" value="<?php echo $row_exam['id'];?>:1" />Normal</label></td>
      <td Colspan="4" bgcolor="#DEEAFA"><label>
        <input type="checkbox" name="chk_ex_sy[]" value="<?php echo $row_exam['id'];?>:0" />NA</label><?php echo $colname_locfeeid ?></td>
    </tr>
  <?php 
	mysql_select_db($database_swmisconn, $swmisconn);
	$query_sympt = "Select s.id sid, s.symptom, s.seq, s.active, e.id eid, e.examname from exam_sympt s join exam_exam e on e.id = s.examid where  e.active = 'Y' and s.active = 'Y' and examid = ".$row_exam['id']." order by s.seq";
	$sympt = mysql_query($query_sympt, $swmisconn) or die(mysql_error());
	$row_sympt = mysql_fetch_assoc($sympt);
	$totalRows_sympt = mysql_num_rows($sympt);
  ?>	
  <?php $s=0 ?>
	<tr>
  <?php do { 
  		$s = $s + 1 ;  
  ?>
<?php       if($s >0 & $s <13) {	?>
		<td bgcolor="#ffffee"><input type="checkbox" name="chk_ex_sy[]" value="<?php echo $row_exam['id'].':'.$row_sympt['sid']; ?>"/>

	    <?php echo $row_sympt['symptom']; ?></td>
<?php } ?>
<?php       if($s == 6) {	// 6 items per row ?>
	</tr>
<?php } ?>
	   
  <?php } while ($row_sympt = mysql_fetch_assoc($sympt)); ?>
  		<!--<input name="chk_ex_sy[]" type="hidden" value="0:0" />-->
    <tr>
		<!--<td align="right">other_text:</td>-->
		<td align="right"><label><input type="checkbox" name="chk_ex_sy[]" value="<?php echo $row_exam['id'].':2' ?>"/>Other</label></td>
		<td colspan="5"><input name="<?php echo $row_exam['id'] ?>" type="text" size="80" maxlength="80" autocomplete="off" /></td>
	</tr>
  <?php } while ($row_exam = mysql_fetch_assoc($exam)); ?>
  		<input name="medrecnum" type="hidden" value="<?php echo $colname_medrecnum ;?>" />
		<input name="visitid" type="hidden" value="<?php echo $colname_visitid ;?>" />
		<input name="locfeeid" type="hidden" value="<?php echo $colname_locfeeid ;?>" />
	    <input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
        <input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i:s"); ?>;" />
		<input type="hidden" name="MM_insert" value="form1">
  </form>
</table>
<label>



</body>
</html>
<?php
mysql_free_result($exam);
?>
