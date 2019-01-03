<?php  $pt = "Cashier Menu"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?> 
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

<?php  
$colname_search1 = "zzzzz";
$xyz = "";
if (isset($_POST['qrytxt']) AND strlen($_POST['qrytxt'])>1) {
  $colname_search1 = (get_magic_quotes_gpc()) ? $_POST['qrytxt'] : addslashes($_POST['qrytxt']);
  $xyz = $colname_search1;
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_search = "SELECT `patperm`.`medrecnum`, `patperm`.`lastname`, `patperm`.`firstname`, `patperm`.`othername`, `patperm`.`gender`, DATE_FORMAT(`patperm`.`dob`,'%d-%b-%Y') dob, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,dob)),'%y') AS age FROM patperm WHERE (concat(`patperm`.`lastname`, ' ',`patperm`.`firstname`, ' ', IFNULL(othername,' ')) like '%".$colname_search1."%') AND `patperm`.`active` = 'Y'";
$search = mysql_query($query_search, $swmisconn) or die(mysql_error());
$row_search = mysql_fetch_assoc($search);
$totalRows_search = mysql_num_rows($search);

  $colname_daysback = "3";
if (isset($_POST['daysback'])  && strlen($_POST['daysback'])>0 ) {   //&& ($_POST["MM_update"] == "form3")
  $colname_daysback = (get_magic_quotes_gpc()) ? $_POST['daysback'] : addslashes($_POST['daysback']);
}

$colname_pat_type = "%";
if (isset($_POST['pat_type'])  && strlen($_POST['pat_type'])>0) {
  $colname_pat_type = (get_magic_quotes_gpc()) ? $_POST['pat_type'] : addslashes($_POST['pat_type']);
}

mysql_select_db($database_swmisconn, $swmisconn);
/*$query_pats = "SELECT distinct DATE_FORMAT(o.entrydt,'%d %b %y') oentrydt, o.medrecnum, p.lastname, p.firstname, p.othername, p.gender, p.dob, CASE WHEN o.status = 'Refund' THEN 'Refund' ELSE (CASE WHEN o.status = 'RxCosted' THEN 'RxCosted' ElSE 'ordered' END) END status, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,dob)),'%y') AS age, p.ethnicgroup, p.active, p.hospital FROM `orders` o join `patperm` p on o.medrecnum = p.medrecnum WHERE (o.status = 'Refund' 
OR (o.amtpaid is null and rate > 0) 
OR (o.item is NOT null and o.Status in ('RxCosted', 'Refund'))) 
and o.status not in ('RxOrdered', 'RxPaid', 'RxDispensed', 'RxReferred') and o.entrydt >= SYSDATE() - INTERVAL " .$colname_daysback." DAY order by DATE(o.entrydt) DESC, lastname, firstname";*/
$query_pats = "SELECT distinct DATE_FORMAT(o.entrydt,'%d %b %y') oentrydt, o.medrecnum, o.billstatus, lastname, p.firstname, p.othername, p.gender, p.dob, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,dob)),'%y') AS age, p.ethnicgroup, p.active, p.hospital FROM `orders` o join `patperm` p on o.medrecnum = p.medrecnum WHERE billstatus In ('Due', 'Refund', 'PartPaid') and o.entrydt >= SYSDATE() - INTERVAL " .$colname_daysback." DAY order by DATE(o.entrydt) DESC, lastname, firstname";
/*
-----the query below allows pattype selection, but does not allow refund of visit orders----
$query_pats = "SELECT distinct DATE_FORMAT(o.entrydt,'%d %b %y') oentrydt, o.medrecnum, o.billstatus, lastname, p.firstname, p.othername, p.gender, p.dob, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,dob)),'%y') AS age, p.ethnicgroup, p.active, p.hospital, v.pat_type FROM `orders` o join `patperm` p on o.medrecnum = p.medrecnum right outer join patvisit v on o.visitid = v.id WHERE v.pat_type like '".$colname_pat_type."%' and billstatus In ('Due', 'Refund', 'PartPaid') and o.entrydt >= SYSDATE() - INTERVAL " .$colname_daysback." DAY order by DATE(o.entrydt) DESC, lastname, firstname";*/
$pats = mysql_query($query_pats, $swmisconn) or die(mysql_error());  //DATE_FORMAT(o.entrydt,'%Y-%m-%d') entrydt,
$row_pats = mysql_fetch_assoc($pats);
$totalRows_pats = mysql_num_rows($pats);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cash Search</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../javascript_form/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
</head>

<body onLoad="document.forms.formcps1.mrn.focus()">
<table width="800px" align="center">
  <tr>
    <td>
	   <table width="400px" align="center">
	    <form id="formdaysback" name="formdaysback" method="post" action="CashSearch.php">
        <tr>
          <td nowrap="nowrap"><div align="center" class="subtitlebl">CASHIER: UNPAID PATIENTS </div></td>
<!--   can't get query to work for patient type selection
          <td nowrap="nowrap"><div align="right">Patient Type:</div></td>
          <td><select name="pat_type" id="pat_type" onChange="document.formdaysback.submit();">
            <option value="%" <?php //if (!(strcmp("%", $colname_pat_type))) {echo "selected=\"selected\"";} ?>>All</option>
			<option value="OutPatient" <?php //if (!(strcmp("OutPatient", $colname_pat_type))) {echo "selected=\"selected\"";} ?>>OutPatient</option>
            <option value="InPatient" <?php //if (!(strcmp("InPatient", $colname_pat_type))) {echo "selected=\"selected\"";} ?>>InPatient</option>
            <option value="Antenatal" <?php //if (!(strcmp("Antenatal", $colname_pat_type))) {echo "selected=\"selected\"";} ?>>Antenatal</option>
          </select>          </td>
-->        <td nowrap="nowrap">Days Back</td>
        <td>
          <select name="daysback" id="daysback" size="1" onChange="document.formdaysback.submit();">    <!--onChange="document.form3.submit();"-->
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
          </select>			</td>
        </tr>
		</form>
      </table>
      <table width="500px">
    <form method="post" name="form2" id="form2" enctype="multipart/form-data">
            <tr>
              <!--<td>ordered</td>-->
              <td>MRN*</td>
              <td>lastname</td>
              <td>firstname</td>
              <td>othername</td>
              <td>gen<br />
              der</td>
              <td>ethnic<br />
              group</td>
              <td>age</td>
<!--              <td>Type</td>-->
              <td>billing <br />
              status</td>
              <td>&nbsp;</td>
            </tr>
	<?php  $rowdate = "";
		do { //bgcolor="#BCFACC" 
		if($row_pats['billstatus'] == 'Refund'){
			$bkgd = "#DDEEFF";
		} else {
			$bkgd = "#FFFFFF";
		}
		
		If($rowdate <> $row_pats['oentrydt']) {?>	
		   <tr>
			  <td colspan="10"><strong><?php echo $row_pats['oentrydt'] ?></strong></td>
		  </tr>
			<?php }	?>  
            <tr>
<!--              <td nowrap="nowrap" bgcolor="<?php echo $bkgd; ?>" class="nav11" title="Ordered: <?php echo $row_pats['oentrydt']; ?>&#10;Status: <?php echo $row_pats['status']; ?>&#10;Hospital: <?php echo $row_pats['hospital']; ?>&#10;Active= <?php echo $row_pats['active']; ?>"><?php echo $row_pats['oentrydt']; ?></td>-->
              <td bgcolor="<?php echo $bkgd; ?>" class="nav11" title="Ordered: <?php echo $row_pats['oentrydt']; ?>&#10;Hospital: <?php echo $row_pats['hospital']; ?>&#10;Active= <?php echo $row_pats['active']; ?>"><a href="CashShow.php?mrn=<?php echo $row_pats['medrecnum']; ?>&billstatus=<?php echo $row_pats['billstatus']; ?>"><?php echo $row_pats['medrecnum']; ?></a></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="nav11" title="Hospital: <?php echo $row_pats['hospital']; ?>&#10;Active= <?php echo $row_pats['active']; ?>"><a href="CashShow.php?mrn=<?php echo $row_pats['medrecnum']; ?>&billstatus=<?php echo $row_pats['billstatus']; ?>"><?php echo $row_pats['lastname']; ?></a></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><a href="CashShow.php?mrn=<?php echo $row_pats['medrecnum']; ?>&billstatus=<?php echo $row_pats['billstatus']; ?>"><?php echo $row_pats['firstname']; ?></a></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><a href="CashShow.php?mrn=<?php echo $row_pats['medrecnum']; ?>&billstatus=<?php echo $row_pats['billstatus']; ?>"><?php echo $row_pats['othername']; ?></a></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><?php echo $row_pats['gender']; ?></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><?php echo $row_pats['ethnicgroup']; ?></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><?php echo $row_pats['age']; ?></td>
<!--              <td bgcolor="<?php //echo $bkgd; ?>" class="BlackBold_11"><div align="center"><?php// echo substr($row_pats['pat_type'],0,1); ?></div></td>-->
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11" title="<?php?mrn=<?php echo $row_pats['medrecnum']; ?>&billstatus=<?php echo $row_pats['billstatus']; ?>"><a href="CashShowAll.php?mrn=<?php echo $row_pats['medrecnum']; ?>&billstatus=<?php echo $row_pats['billstatus']; ?>"><?php echo $row_pats['billstatus']; ?></a></td>

	<?php If($row_pats['medrecnum'] > 0) {?>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11" title="Display All Orders"><a href="CashShowAll.php?mrn=<?php echo $row_pats['medrecnum']; ?>">All</a></td>
			 <?php  }?>
            </tr>

            <?php $rowdate = $row_pats['oentrydt'];
			 } while ($row_pats = mysql_fetch_assoc($pats)); ?>
        </form> 
      </table>
</td>
    <td valign="top">
		<table width="500">
			<tr>
				<td>
					<table width="200px" align="center">
				  <form method="get" name="formcps0" id="formcps0" action="CashShowAll.php">
						<caption align="top" class="subtitlebl">CASHIER MRN SEARCH</caption>
					<tr>
					  <td align="center"><a href="CashShowAll.php?mrn=<?php echo $row_search['medrecnum']; ?>">Enter Patient </a><br />
				      Medical Record Number</td>
					</tr>
					<tr>
					  <td align="center"><input name="mrn" type="text" id="mrn" autocomplete="off" /></td>
					</tr>
					<tr>
					  <td align="center"><input type="submit" name="Submit" value="Search MRN" /></td>
					</tr>
				</form>					
				  </table>
				</td>
				<td valign="top">
				  <table width="250px" align="center">
				  <form method="post" name="formcps1" id="formcps1" enctype="multipart/form-data">
					<caption align="top" class="subtitlebl">
					  CASHIER PATIENT SEARCH
					  </caption>
					<tr>
					  <td align="center">Enter 3 or more Characters<br />
						of a Patient Name </td>
					</tr>
					<tr>
					  <td align="center"><input name="qrytxt" type="text" id="qrytxt" autocomplete="off" /></td>
					</tr>
					<tr>
					  <td align="center"><input type="submit" name="Submit2" value="Search Name" /></td>
					</tr>
				</form>
				  </table>
				</td>
			  </tr>
			  <tr>
				<td colspan="2" valign="top"><form id="form2" name="form2" method="post" action="">
				  <table bgcolor="F5F5F5" border="1">
					<tr>
					  <td><?php echo $colname_search1 ; ?></td>
					  <td class="subtitlebk"><div align="center">Last Name </div></td>
					  <td class="subtitlebk"><div align="center">First Name </div></td>
					  <td class="subtitlebk"><div align="center">Other Name </div></td>
					  <td class="subtitlebk"><div align="center">Gender</div></td>
					  <td class="subtitlebk"><div align="center">Age</div></td>
					  <td class="subtitlebk"><div align="center">DOB</div></td>
					</tr>
					<?php do { ?>
					<tr>
					  <td class="navLink"><a href="CashShowAll.php?mrn=<?php echo $row_search['medrecnum']; ?>"><?php echo $row_search['medrecnum']; ?></a></td>
					  <td bgcolor="#FFFFFF" class="sidebar"><a href="CashShow.php?mrn=<?php echo $row_search['medrecnum']; ?>"><?php echo $row_search['lastname']; ?></a></td>
					  <td bgcolor="#FFFFFF" class="sidebar"><?php echo $row_search['firstname']; ?></td>
					  <td bgcolor="#FFFFFF" class="sidebar"><?php echo $row_search['othername']; ?></td>
					  <td bgcolor="#FFFFFF" class="sidebar"><?php echo $row_search['gender']; ?></td>
<?php  //calculate Age
//	$patage = "";
//	$patdob = "";
//	if (strtotime($row_search['dob'])) {
//		$c= date('Y');
//		$y= date('Y',strtotime($row_search['dob']));
//		$patage = $c-$y;
//	//format date of birth
//		$datetime = strtotime($row_search['dob']);
//		$patdob = date("m/d/y", $datetime);
//} 
?>
					  <td bgcolor="#FFFFFF" class="sidebar"><?php echo $row_search['age']; ?></td>
					  <td bgcolor="#FFFFFF" class="sidebar"><?php echo $row_search['dob']; ?></td>
					</tr>
					<?php } while ($row_search = mysql_fetch_assoc($search)); ?>
				  </table>
			</form></td>
		 </tr>
	   </table>	</td>
  </tr>
</table>
<script  type="text/javascript">
var frmvalidator = new Validator("formcps1");
frmvalidator.addValidation("qrytxt","alnum_s","Allows only alphabetic, numeric and space characters ");
frmvalidator.addValidation("qrytxt","minlen=3","Allows MINIMUM OF 3 alphabetic, numeric, or space characters ");
var frmvalidator = new Validator("formcps0");
frmvalidator.addValidation("mrn","num","Numbers Only");

</script>

</body>
</html>
<?php
mysql_free_result($pats);
?>


