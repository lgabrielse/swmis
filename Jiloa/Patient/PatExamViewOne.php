<?php require_once('../../Connections/swmisconn.php'); ?>
<?php
 if (session_status() == PHP_SESSION_NONE) {
    session_start(); }
$colname_medrecnum = "-1";
if (isset($_GET['mrn'])) {
  $colname_medrecnum = (get_magic_quotes_gpc()) ? $_GET['mrn'] : addslashes($_GET['mrn']);
}

$colname_locfeeid = "-1";
if (isset($_GET['locfeeid'])) {
  $colname_locfeeid = (get_magic_quotes_gpc()) ? $_GET['locfeeid'] : addslashes($_GET['locfeeid']);
}

$colid_visitid = "-1";
if (isset($_GET['vid'])) {
  $colid_visitid = (get_magic_quotes_gpc()) ? $_GET['vid'] : addslashes($_GET['vid']);
}
else {
if (isset($_SESSION['vid'])) {
  $colid_visitid = (get_magic_quotes_gpc()) ? $_SESSION['vid'] : addslashes($_SESSION['vid']);
}}

if (isset($_SESSION['examresultid'])) {
  $colid_examresultid = (get_magic_quotes_gpc()) ? $_SESSION['examresultid'] : addslashes($_SESSION['examresultid']);
}
	
mysql_select_db($database_swmisconn, $swmisconn);
$query_exam_result = "Select e.id, e.medrecnum, e.visitid, substr(exam_arr,2, CHAR_LENGTH(exam_arr)-2) exam_arr, substr(other_arr,2) other_arr, e.entryby, DATE_FORMAT(e.entrydt,'%d-%b-%Y %H:%i') entrydt, f.id fid from exam_result e join patvisit v on e.visitid = v.id join fee f on f.name = v.location and f.section = v.pat_type where e.visitid = '".$colid_visitid."' and e.id = '".$colid_examresultid."'";
$exam_result = mysql_query($query_exam_result, $swmisconn) or die(mysql_error());
$row_exam_result = mysql_fetch_assoc($exam_result);
$totalRows_exam_result = mysql_num_rows($exam_result);

?>

<body>
<table border="0" class="tablebc">
<?php if($totalRows_exam_result > 0){?>
  <?php do { ?>
    <tr>
<!--      <td><?php echo $row_exam_result['id']; ?></td>
      <td><?php echo $row_exam_result['medrecnum']; ?></td>
      <td><?php echo $row_exam_result['visitid']; ?></td>
      <td><?php echo $row_exam_result['exam_arr']; ?></td>
      <td><?php echo $row_exam_result['other_arr']; ?></td>-->
      <td nowrap="nowrap" class="Black_9_9" title="ID:<?php echo $row_exam_result['id']; ?>&#10;VISIT: <?php echo $row_exam_result['visitid']; ?>"><?php echo $row_exam_result['entryby']; ?><br />
      <?php echo $row_exam_result['entrydt']; ?><br />	  
	  <a href="javascript:void(0)" onClick="MM_openBrWindow('PatExamPopResultadd.php?EDIT=Y&mrn=<?php echo $colname_medrecnum ?>&visitid=<?php echo $colid_visitid ?>&locfeeid=<?php echo $row_exam_result['fid'] ?>&id=<?php echo $row_exam_result['id']; ?>','StatusView','scrollbars=yes,resizable=yes,width=900,height=400')">EDIT</a></td>
      <td class="BlackBold_11_11">&nbsp;&nbsp;&nbsp;</td>
	<?php $examArr = explode(',',$row_exam_result['exam_arr']); ?>
	<?php $otherArr = explode(',',$row_exam_result['other_arr']); ?>
	  <td valign="top">
	  	<table>
	<?php $lastexamid = '0'; ?>
	<?php $lastexamname = '';?>
	<?php $symptomtxt = '' ?>
	<?php //$logg = 'N...';?>
	<?php foreach ($examArr as $couplet) { // loop through pairs of examid: symptoms (couplet)-------------------------------------?>
	<?php $coupletArr = explode(':',$couplet);  //splet each couplet into indiv values
			$examid = $coupletArr[0];
		  if($examid <> $lastexamid){
	?>				<tr> <!--display last one-->
					<td><?php //echo $couplet;?></td>
					<td  bgcolor="#DEEAFA" class="BlueBold_1212"><?php echo $lastexamname ; ?></td>
					<td bgcolor="#FFFFEE"><?php echo $symptomtxt ?></td>
					<td><?php //echo $logg ?></td>
				</tr>
	<?php 	$lastexamname  = '';
			$symptomtxt = '';
		}
			$sympid = $coupletArr[1];
		  if($examid <> 0){ //find exam name if exam name not = 0
				mysql_select_db($database_swmisconn, $swmisconn);
				$query_exam = "Select e.examname, e.locfeeid from exam_exam e where e.id = ".$examid."";
				$exam = mysql_query($query_exam, $swmisconn) or die(mysql_error());
				$row_exam = mysql_fetch_assoc($exam);
				$totalRows_exam = mysql_num_rows($exam);
				$examname = $row_exam['examname'];

		}
		if($sympid == 0){
					$symptomtxt = 'NA';
					$lastexamid = $examid;
					$lastexamname = $examname;
		} elseif($sympid == 1){
					$symptomtxt = 'Normal';
					$lastexamid = $examid;
					$lastexamname = $examname;
		} elseif($sympid >= 12){;
					mysql_select_db($database_swmisconn, $swmisconn);
					$query_examsympt = "Select s.symptom from exam_sympt s where s.examid = ".$examid." and s.id = ".$sympid."";
					$examsympt = mysql_query($query_examsympt, $swmisconn) or die(mysql_error());
					$row_examsympt = mysql_fetch_assoc($examsympt);
					$totalRows_examsympt = mysql_num_rows($examsympt);
					$symptomtxt = $symptomtxt.','. $row_examsympt['symptom'];
					$lastexamid = $examid;
					$lastexamname = $examname;
		} elseif($sympid == 2){
				foreach ($otherArr as $other) { //-------------------------------------
				  $otherArray = explode(':',$other);
				  $otherid = $otherArray[0];
				  $othertxt = $otherArray[1];
				  if($examid == $otherid){
				  $symptomtxt = $symptomtxt.';'.$othertxt ;
					$lastexamid = $examid;
					$lastexamname = $examname;
			  	}
			}
		}

?>
<?php
	//$logg = $logg.'Alpha:'.'couplet:'.$examid.':'.$sympid.':lastexam'.$lastexamid.' ExamName:'.$examname.' symptom:'.$symptomtxt."</br>"; ?>
<?php

?>		
<?php } ?>
				<tr> <!--display last one-->
					<td><?php //echo $couplet;?></td>
					<td bgcolor="#DEEAFA" class="BlueBold_1212"><?php echo $lastexamname ; ?></td>
					<td bgcolor="#FFFFEE"><?php echo $symptomtxt ?></td>
					<td><?php //echo $logg ?></td>
				</tr>
	  </table>	  </td>
    </tr>

<?php } while ($row_exam_result = mysql_fetch_assoc($exam_result)); ?>
<?php } ?>
</table>
</body>
</html>
<?php
mysql_free_result($exam_result);

?>










