<?php  $pt = "Lab Patients"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?> 
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

<?php
	 $colname_daysback = "5";
    if (isset($_POST['daysback'])  && strlen($_POST['daysback'])>0 ) {   //&& ($_POST["MM_update"] == "form3")
     $colname_daysback = (get_magic_quotes_gpc()) ? $_POST['daysback'] : addslashes($_POST['daysback']);
}
mysql_select_db($database_swmisconn, $swmisconn);   //DATE_FORMAT(o.entrydt,'%Y-%m-%d') sortdt, DATE_FORMAT(o.entrydt,'%d-%b-%Y') entrydt, 
$query_labpats = "SELECT distinct MIN(o.entrydt),DATE_FORMAT(o.entrydt,'%Y-%m-%d') entrydt, p.medrecnum, p.lastname, p.firstname, p.othername, p.dob, p.gender, p.ethnicgroup, p.hospital, p.active, p.entryby, v.pat_type, v.location, o.urgency FROM `patperm` p join orders o on p.medrecnum = o.medrecnum join patvisit v on o.visitid = v.id join `fee` f on o.feeid = f.id where f.dept = 'Laboratory' and (o.status like '%ordered%' or o.status like '%Recollect%') and ((o.entrydt >= SYSDATE() - INTERVAL " .($colname_daysback)." DAY AND o.urgency IN ('Routine', 'ASAP', 'STAT')) or (o.entrydt >= SYSDATE() - INTERVAL 180 DAY AND o.urgency = 'Scheduled')) GROUP BY p.medrecnum, p.lastname, p.firstname, p.othername, p.dob, p.gender, p.ethnicgroup, p.hospital, p.active, p.entryby, v.pat_type, v.location, o.urgency order by DATE_FORMAT(o.entrydt,'%Y-%m-%d') desc";
$labpats = mysql_query($query_labpats, $swmisconn) or die(mysql_error());
$row_labpats = mysql_fetch_assoc($labpats);
$totalRows_labpats = mysql_num_rows($labpats);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="30%" align="center">
  <tr>
	<td nowrap="nowrap"><div align="center" class="subtitlebl"> CURRENT  LAB  COLLECTION  PATIENTS </div></td>
        <td>Days Back</td>
        <td>
		<form name="form1" id="form1" method="post">
          <select name="daysback" id="daysback" size="1" onChange="document.form1.submit();">    <!--onChange="document.form3.submit();"-->
            <option value="1" <?php if (!(strcmp(1, $colname_daysback))) {echo "selected=\"selected\"";} ?>>1</option>
            <option value="2" <?php if (!(strcmp(2, $colname_daysback))) {echo "selected=\"selected\"";} ?>>2</option>
            <option value="3" <?php if (!(strcmp(3, $colname_daysback))) {echo "selected=\"selected\"";} ?>>3</option>
            <option value="4" <?php if (!(strcmp(4, $colname_daysback))) {echo "selected=\"selected\"";} ?>>4</option>
            <option value="5" <?php if (!(strcmp(5, $colname_daysback))) {echo "selected=\"selected\"";} ?>>5</option>
            <option value="6" <?php if (!(strcmp(6, $colname_daysback))) {echo "selected=\"selected\"";} ?>>6</option>
            <option value="7" <?php if (!(strcmp(7, $colname_daysback))) {echo "selected=\"selected\"";} ?>>7</option>
            <option value="10" <?php if (!(strcmp(10, $colname_daysback))) {echo "selected=\"selected\"";} ?>>10</option>
            <option value="15" <?php if (!(strcmp(15, $colname_daysback))) {echo "selected=\"selected\"";} ?>>15</option>
            <option value="20" <?php if (!(strcmp(20, $colname_daysback))) {echo "selected=\"selected\"";} ?>>20</option>
            <option value="25" <?php if (!(strcmp(25, $colname_daysback))) {echo "selected=\"selected\"";} ?>>25</option>
            <option value="30" <?php if (!(strcmp(30, $colname_daysback))) {echo "selected=\"selected\"";} ?>>30</option>
            <option value="60" <?php if (!(strcmp(60, $colname_daysback))) {echo "selected=\"selected\"";} ?>>60</option>
            <option value="90" <?php if (!(strcmp(90, $colname_daysback))) {echo "selected=\"selected\"";} ?>>90</option>
            <option value="120" <?php if (!(strcmp(120, $colname_daysback))) {echo "selected=\"selected\"";} ?>>120</option>
            <option value="180" <?php if (!(strcmp(180, $colname_daysback))) {echo "selected=\"selected\"";} ?>>180</option>
            <option value="365" <?php if (!(strcmp(365, $colname_daysback))) {echo "selected=\"selected\"";} ?>>1 yr</option>
            <option value="1825" <?php if (!(strcmp(1825, $colname_daysback))) {echo "selected=\"selected\"";} ?>>5 yr</option>
          </select>	
		</form>
	</td>
  </tr>
</table>
<table width="50%" align="center">
  <tr>
<!--  <td nowrap="nowrap">
  	Add: search by med rec num  </td>-->
	<td>

		<form method="post" name="form2" id="form2" enctype="multipart/form-data">

      <table>
          <tr>
            <td>OrderDate</td>
            <td>Urgency</td>
            <td>MRN*</td>
            <td>lastname</td>
            <td>firstname</td>
            <td>othername</td>
            <td>gender</td>
            <td>ethnicgroup</td>
            <td>age</td>
            <td>&nbsp;</td>
          </tr>
          <?php do { 
				mysql_select_db($database_swmisconn, $swmisconn);   //DATE_FORMAT(o.entrydt,'%Y-%m-%d') sortdt, DATE_FORMAT(o.entrydt,'%d-%b-%Y') entrydt, 
				
				$query_mxorddt = "SELECT DATE_FORMAT(MAX(o.entrydt),'%Y-%m-%d') mxentrydt FROM patperm p join orders o on p.medrecnum = o.medrecnum where o.medrecnum = '".$row_labpats['medrecnum']."' and (o.status like '%ordered%' or o.status like '%Recollect%')";
				$mxorddt = mysql_query($query_mxorddt, $swmisconn) or die(mysql_error());
				$row_mxorddt = mysql_fetch_assoc($mxorddt);
				$totalRows_mxorddt = mysql_num_rows($mxorddt);
		  
		  ?>
          <tr>
            <td nowrap="nowrap" class="BlackBold_11"><?php echo $row_labpats['entrydt']; ?></td>		  
            <td class="BlackBold_11"><?php echo $row_labpats['urgency']; ?></td>		  
            <td class="nav11" title="Hospital: <?php echo $row_labpats['hospital']; ?>&#10;Active= <?php echo $row_labpats['active']; ?>&#10;Entry By: <?php echo $row_labpats['entryby']; ?>"><a href="LabSpecList.php?mrn=<?php echo $row_labpats['medrecnum']; ?>"><?php echo $row_labpats['medrecnum']; ?></a></td>
            <td class="nav11" title="Hospital: <?php echo $row_labpats['hospital']; ?>&#10;Active= <?php echo $row_labpats['active']; ?>&#10;Entry By: <?php echo $row_labpats['entryby']; ?>"><a href="LabSpecList.php?mrn=<?php echo $row_labpats['medrecnum']; ?>"><?php echo $row_labpats['lastname']; ?></a></td>
            <td class="BlackBold_11"><?php echo $row_labpats['firstname']; ?></td>
            <td class="BlackBold_11"><?php echo $row_labpats['othername']; ?></td>
            <td class="BlackBold_11"><?php echo $row_labpats['gender']; ?></td>
            <td class="BlackBold_11"><?php echo $row_labpats['ethnicgroup']; ?></td>
<?php  //calculate Age
	$patage = "";
	$patdob = "";
	if (strtotime($row_labpats['dob'])) {
		$c= date('Y');
		$y= date('Y',strtotime($row_labpats['dob']));
		$patage = $c-$y;
	//format date of birth
		$datetime = strtotime($row_labpats['dob']);
		$patdob = date("m/d/y", $datetime);
} ?>
            <td class="BlackBold_11"><?php echo $patage ; ?></td>
          </tr>
          <?php } while ($row_labpats = mysql_fetch_assoc($labpats)); ?>
      </table>
	  </form>
	</td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($labpats);
?>
