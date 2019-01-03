<?php  $pt = "Antenatal Hist Print"; ?>
<?php require_once('../../Connections/swmisconn.php'); ?><?php if (session_status() == PHP_SESSION_NONE) {
    session_start(); }?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

<?php
$colname_patperm = "1317";
if (isset($_GET['mrn'])) {
  $colname_patperm = (get_magic_quotes_gpc()) ? $_GET['mrn'] : addslashes($_GET['mrn']);
}  // Patient Perm data
mysql_select_db($database_swmisconn, $swmisconn);
$query_patperm = "SELECT medrecnum, hospital, active, entrydt, entryby, lastname, firstname, othername, gender, ethnicgroup, DATE_FORMAT(dob,'%d %b %Y') dob, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE, dob)),'%y') AS age, est FROM patperm WHERE medrecnum = '". $colname_patperm."'";
$patperm = mysql_query($query_patperm, $swmisconn) or die(mysql_error());
$row_patperm = mysql_fetch_assoc($patperm);
$totalRows_patperm = mysql_num_rows($patperm);

// previous pregnancy data
mysql_select_db($database_swmisconn, $swmisconn);
$query_prevpreg = sprintf("SELECT id, medrecnum, pregid, name, DATE_FORMAT(dob,'%%d-%%b-%%Y') dob, pregdur, plptext, birthweight, babystatus, living, entryby, entrydt FROM anprevpregs WHERE medrecnum = %s order by dob", $colname_patperm);
$prevpreg = mysql_query($query_prevpreg, $swmisconn) or die(mysql_error());
$row_prevpreg = mysql_fetch_assoc($prevpreg);
$totalRows_prevpreg = mysql_num_rows($prevpreg);

// Pregnancy data
$colname_preg = "1317";
if (isset($_SESSION['mrn'])) {
  $colname_preg = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_preg = sprintf("SELECT id, medrecnum, DATE_FORMAT(lmp,'%%d-%%b-%%Y') lmp, DATE_FORMAT(edd,'%%d-%%b-%%Y') edd, DATE_FORMAT(ussedd,'%%d-%%b-%%Y') ussedd, DATE_FORMAT(firstvisit,'%%d-%%b-%%Y') firstvisit, obg, obp, specpoints, HistPatHeart, HistPatChest, HistPatKidney, HistPatBldTransf, HistPatOperations, HistPatOther, HistFamMultPreg, HistFamTb, HistFamHypertens, HistFamHeart, HistFamOther, entryby, DATE_FORMAT(entrydt,'%%d-%%b-%%Y') entrydt FROM anpreg WHERE id = (Select Max(id) from anpreg where medrecnum = '".$colname_preg."') and medrecnum = %s ORDER BY id ASC", $colname_preg);
$preg = mysql_query($query_preg, $swmisconn) or die(mysql_error());
$row_preg = mysql_fetch_assoc($preg);
$totalRows_preg = mysql_num_rows($preg);

//  Followup Data
$colname_followup = "-1";
if (isset($row_preg['id'])) {
  $colname_followup = (get_magic_quotes_gpc()) ? $row_preg['id'] : addslashes($row_preg['id']);
  $_SESSION['pregid'] = $colname_followup;
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_followup = sprintf("SELECT id, medrecnum, visitid, pregid, hof, prespos, lie, fetalheart, bldpres, weight, oedema, foluptext, DATE_FORMAT(nextvisit,'%%d-%%b-%%Y') nextvisit, entryby, DATE_FORMAT(entrydt,'%%d-%%b-%%Y') entrydt FROM anfollowup WHERE pregid = %s", $colname_followup);
$followup = mysql_query($query_followup, $swmisconn) or die(mysql_error());
$row_followup = mysql_fetch_assoc($followup);
$totalRows_followup = mysql_num_rows($followup);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Patient Anenatal History</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- Begin PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT - PATIENT -   -->
  <a name="top"></a>
  <table width="800px">
	  <tr>
	  	<td><div align="center"><A HREF="javascript:window.print()">Print</A></td>
	    <td><div align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePregView.php">Close</a></td>
		<td nowrap="nowrap" class="BlueBold_16"><?php echo $row_patperm['hospital']; ?> Medical Center</td>
	    <td colspan="2" nowrap="nowrap" class ="BlueBold_18">Patient History</td>
	    <td colspan="2" align="right" class ="BlueBold_12">Printed:<?php echo date("d-M-Y") ?></td>
      </tr>
	  <tr>
	    <td class ="BlueBold_18">&nbsp;</td>
		<td nowrap="nowrap" Title="Entry Date: <?php echo $row_patperm['entrydt']; ?>&#10; Entry By: <?php echo $row_patperm['entryby']; ?>&#10;Active: <?php echo $row_patperm['active']; ?>">MRN:<span class="BlueBold_16"><?php echo $row_patperm['medrecnum']; ?></span></td>
		<td bgcolor="#FFFFFF" nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:<span class="BlueBold_20" ><?php echo $row_patperm['lastname']; ?></span>,<span class="BlueBold_18"><?php echo $row_patperm['firstname']; ?></span>(<span class="BlueBold_18"><?php echo $row_patperm['othername']; ?></span>)</td>
		<td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gender:<span class="BlueBold_16"><?php echo $row_patperm['gender']; ?></span></td>
		<td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ethnic Group: <span class="BlueBold_16"><?php echo $row_patperm['ethnicgroup']; ?></span></td>
		<td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Age: <span class="BlueBold_16"><?php echo $row_patperm['age']; ?></span></td>
		<td nowrap="nowrap">DOB:<span class="BlueBold_16"><?php echo $row_patperm['dob']; ?></span>:<?php echo $row_patperm['est']; ?></td>
	  </tr>
</table>

<?php if($totalRows_prevpreg >= 1){ ?> 
  	<table width="800px">
	  <tr bgcolor="#E8F0F4">
	    <td colspan="8" nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_18">PreviousPregnancies<?php echo $totalRows_preg ?></div></td>
      </tr>
	  <tr bgcolor="#E8F0F4">
	    <td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_10">Preg<br />Record</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Name:</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">DOB</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Preg.Duration</div></td>
		<td nowrap="NOWRAP" class="Black_14"><div align="center">Pregnancy, Labour, Pueperium</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Birth Weight </div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Baby Status </div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Gender</div></td>
	  </tr>

<?php do { ?>
	  <tr>
	    <td class="borderbottomthinblack" bgcolor="#E8F0F4"><?php echo $row_prevpreg['pregid']; ?></td>
		<td class="borderbottomthinblack" nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_prevpreg['name']; ?></td>
		<td class="borderbottomthinblack" nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_prevpreg['dob']; ?></td>
		<td class="borderbottomthinblack" bgcolor="#FFFFFF"><?php echo $row_prevpreg['pregdur']; ?></td>
		<td class="borderbottomthinblack" bgcolor="#FFFFFF"><?php echo $row_prevpreg['plptext']; ?></td>
		<td class="borderbottomthinblack" bgcolor="#FFFFFF"><?php echo $row_prevpreg['birthweight']; ?></td>
		<td class="borderbottomthinblack" bgcolor="#FFFFFF"><?php echo $row_prevpreg['babystatus']; ?></td>
		<td class="borderbottomthinblack" bgcolor="#FFFFFF"><?php echo $row_prevpreg['living']; ?></td>
	  </tr>
    <?php } while ($row_prevpreg = mysql_fetch_assoc($prevpreg)); ?>
   <tr>
</table>
<?php } ?>
<table>
   <tr>
  	<td Colspan="8"> <div align="center" class="BlackBold_16">----------------------------------------------- Pregnancy Record ------------------------------------------------------</div></td>
  </tr>
</table>

<?php do { ?>
   <table width="800px" bgcolor="#EDEDED">
     <form  id="formapv" name="formapv" method="POST">
      <tr>
        <td valign="top" nowrap="nowrap" class="borderbottomthinblackBold14" Title="Entryby: <?php echo $row_preg['entryby']; ?>&#10;Entrydt: <?php echo $row_preg['entrydt']; ?>">Pregnancy<br /> 
      ID: <?php echo $row_preg['id']; ?> </td>
        <td valign="top" nowrap="nowrap" class="borderbottomthinblack" >lmp:<br />
      <input name="lmp" type="text" id="lmp" size="8" maxlength="10" readonly="readonly" value="<?php echo $row_preg['lmp']; ?>"/></td>
        <td valign="top" nowrap="nowrap" class="borderbottomthinblack" >EDD:<br />
      <input name="edd" type="text" id="edd" size="8" maxlength="10" readonly="readonly" value="<?php echo $row_preg['edd']; ?>" /></td>
        <td valign="top" nowrap="nowrap" class="borderbottomthinblack" >USS EDD:<br />
      <input name="ussedd" type="text" id="ussedd" size="8" maxlength="10" readonly="readonly" value="<?php echo $row_preg['ussedd']; ?>" /></td>
        <td valign="top" nowrap="nowrap" class="borderbottomthinblack" >FirstVisit:<br />
      <input name="firstvisit" type="text" id="firstvisit" size="8" maxlength="10" readonly="readonly" value="<?php echo $row_preg['firstvisit']; ?>" /></td>
        <td valign="top" nowrap="nowrap" class="borderbottomthinblack" >OB Hist:<br />
          G
        <input name="obg" type="text" id="obg" size="1" maxlength="3" readonly="readonly" value="<?php echo $row_preg['obg']; ?>" /> 
        P
      <input name="obp" type="text" id="obp" size="1" maxlength="3" readonly="readonly" value="<?php echo $row_preg['obp']; ?>" /></td>
        <td valign="top" nowrap="nowrap" class="borderbottomthinblack" >Special<br />
        Points:</td>
        <td valign="top" bgcolor="#FFFFFF" class="borderbottomthinblack"><?php echo $row_preg['specpoints']; ?></td>
      </tr>
  <tr>                  
    <td valign="top" nowrap="nowrap" class="borderbottomthinblackBold14"><div align="center">Patient<br />
      History:</div></td>
	  <?php if($row_preg['HistPatHeart'] == "Y") { $bkg1 = "#FFFDDA";} else {$bkg1 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg1; ?> nowrap="nowrap" >Heart<br />
      Disease 
      <input name="HistPatHeart" type="text" id="HistPatHeart" size="2" maxlength="3" readonly="readonly" value="<?php echo $row_preg['HistPatHeart']; ?>" /></td>

	    <?php if($row_preg['HistPatChest'] == "Y") { $bkg2 = "#FFFDDA";} else {$bkg2 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg2; ?> nowrap="nowrap" >Chest<br />
      Disease 
      <input name="HistPatChest" type="text" id="HistPatChest" size="2" maxlength="3" readonly="readonly" value="<?php echo $row_preg['HistPatChest']; ?>" /></td>

	  <?php if($row_preg['HistPatKidney'] == "Y") { $bkg3 = "#FFFDDA";} else {$bkg3 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg3; ?> nowrap="nowrap" >Kidney<br />
      Disease 
      <input name="HistPatKidney" type="text" id="HistPatKidney" size="2" maxlength="3" readonly="readonly" value="<?php echo $row_preg['HistPatKidney']; ?>" /></td>

	  <?php if($row_preg['HistPatBldTransf'] == "Y") { $bkg4 = "#FFFDDA";} else {$bkg4 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg4; ?> nowrap="nowrap" >Blood<br />
      Transf'ns 
      <input name="HistPatBldTransf" type="text" id="HistPatBldTransf" size="2" maxlength="3" readonly="readonly" value="<?php echo $row_preg['HistPatBldTransf']; ?>" 
/></td>

	  <?php if($row_preg['HistPatOperations'] == "Y") { $bkg5 = "#FFFDDA";} else {$bkg5 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg5; ?> nowrap="nowrap" >Oper-<br />
      ations 
      <input name="HistPatOperations" type="text" id="HistPatOperations" size="2" maxlength="3" readonly="readonly" value="<?php echo $row_preg['HistPatOperations']; ?>" /></td>

    <td valign="top" nowrap="nowrap" class="borderbottomthinblack">Other:</td>
    <td valign="top" bgcolor="#FFFFFF" class="borderbottomthinblack"><?php echo $row_preg['HistPatOther']; ?></td>
  </tr>
  <tr>
    <td valign="top" nowrap="nowrap"  class="BlackBold_14"><div align="center">Family<br />
      History:</div></td>
	  <?php if($row_preg['HistFamMultPreg'] == "Y") { $bkg6 = "#FFFDDA";} else {$bkg6 = "#DCDCDC";} ?> 
    <td bgcolor=<?php echo $bkg6; ?> nowrap="nowrap" >Multiple<br />
      Preg's
        <input name="HistFamMultPreg" type="text" id="HistFamMultPreg" size="2" maxlength="3" readonly="readonly" value="<?php echo $row_preg['HistFamMultPreg']; ?>" /></td>

	  <?php if($row_preg['HistFamTb'] == "Y") { $bkg7 = "#FFFDDA";} else {$bkg7 = "#DCDCDC";} ?> 
    <td nowrap="nowrap" bgcolor=<?php echo $bkg7; ?> >Tuberc-<br />
      ulosis
      <input name="HistFamTb" type="text" id="HistFamTb" size="2" maxlength="3" readonly="readonly" value="<?php echo $row_preg['HistFamTb']; ?>" /></td>

	  <?php if($row_preg['HistFamHypertens'] == "Y") { $bkg8 = "#FFFDDA";} else {$bkg8 = "#DCDCDC";} ?> 
    <td nowrap="nowrap" bgcolor=<?php echo $bkg8; ?> >Hyper-<br />
      Tension 
      <input name="HistFamHypertens" type="text" id="HistFamHypertens" size="2" readonly="readonly" value="<?php echo $row_preg['HistFamHypertens']; ?>" maxlength="3" /></td>

	  <?php if($row_preg['HistFamHeart'] == "Y") { $bkg9 = "#FFFDDA";} else {$bkg9 = "#DCDCDC";} ?> 
    <td nowrap="nowrap" bgcolor=<?php echo $bkg9; ?> >Heart<br />
      Disease      
      <input name="HistFamHeart" type="text" id="HistFamHeart" size="2" maxlength="3" readonly="readonly" value="<?php echo $row_preg['HistFamHeart']; ?>" /></td>
    <td valign="top" nowrap="nowrap" class="borderbottomthinblack" ></td>
    <td valign="top" nowrap="nowrap" class="borderbottomthinblack" >Other:</td>
    <td valign="top" bgcolor="#FFFFFF" class="borderbottomthinblack" ><?php echo $row_preg['HistFamOther']; ?></td>
    </tr>
   </form>
  </table>
<?php  } while ($row_preg = mysql_fetch_assoc($preg));?>




<table width="800px" cellpadding="0" cellspacing="0">
  <tr>
  	<td Colspan="12"> <div align="center" class="BlackBold_14">--------------------------------------------------------------- Follow Up Visits -------------------------------------------------------------- </div></td>
  </tr>
  <tr>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center">Follow-Up<br />
    PregID,FID</div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center">Date</div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center"> Fundus<br />
    Height</div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center">Presentation<br />
    and Position </div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center">Relation of<br />
    Presenting<br />
    Part 
    to Brim</div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center">Foetal<br />
    Heart</div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center">Blood<br />
    Pressure</div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center">Weight</div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center">Oedema</div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center">Remarks</div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12"><div align="center">Return</div></td>
    <td bgcolor="#ffa07a" class="BlackBold_12">Examiner</td>
  </tr>
  
  
  
<?php
         do { ?>
    <tr>
      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack" Title="VisitID: <?php echo $row_followup['visitid']; ?>&#10;PregID: <?php echo $row_followup['pregid']; ?>&#10;FollowupID: <?php echo $row_followup['id']; ?>&#10;EntryBY: <?php echo $row_followup['entryby']; ?>&#10;EntryDt: <?php echo $row_followup['entrydt']; ?>">
	    <div align="center">
	      <input name="medrecnum" type="text" id="medrecnum" size="5" maxlength="9" readonly="readonly" value="<?php echo $row_followup['pregid']; ?>, <?php echo $row_followup['id']; ?>" />
      </div></td>
      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center">
        <input name="entrydt" type="text" id="entrydt" size="8" maxlength="12" class="Black_11" readonly="readonly" value="<?php echo $row_followup['entrydt']; ?>" />
      </div></td>

      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center">
        <input name="hof" type="text" id="hof" size="6" maxlength="12" readonly="readonly" value="<?php echo $row_followup['hof']; ?>" />
      </div></td>

      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center">
        <input name="prespos" type="text" id="prespos" size="6" maxlength="12" readonly="readonly" value="<?php echo $row_followup['prespos']; ?>" />
      </div></td>

      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center">
        <input name="lie" type="text" id="lie" size="6" maxlength="12" readonly="readonly" value="<?php echo $row_followup['lie']; ?>" />
      </div></td>

      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center">
        <input name="fetalheart" type="text" id="fetalheart" size="3" maxlength="12" readonly="readonly" value="<?php echo $row_followup['fetalheart']; ?>" />
      </div></td>

      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center">
        <input name="hgb" type="text" id="hgb" size="3" maxlength="12" readonly="readonly" value="<?php echo $row_followup['bldpres']; ?>" />
      </div></td>

      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center">
        <input name="hgb" type="text" id="hgb" size="3" maxlength="12" readonly="readonly" value="<?php echo $row_followup['weight']; ?>" />
      </div></td>

      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack">&nbsp;</td>
      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center">
        <input name="oedema" type="text" id="oedema" size="6" maxlength="12" readonly="readonly" value="<?php echo $row_followup['oedema']; ?>" />
      </div></td>

      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center"><?php echo $row_followup['foluptext']; ?></div></td>

      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center">
        <input name="nextvisit" type="text" id="nextvisit" size="8" maxlength="12" class="Black_11" readonly="readonly" value="<?php echo $row_followup['nextvisit']; ?>" />
      </div></td>

      <td valign="top"  bgcolor="#FFE4E1" class="borderbottomthinblack"><div align="center">
        <input name="entryby" type="text" id="entryby" size="10" maxlength="20" class="Black_11" readonly="readonly" value="<?php echo $row_followup['entryby']; ?>" />
      </div></td>
    </tr>
<?php 	 } while ($row_followup = mysql_fetch_assoc($followup));
?>
</table>
</body>
</html>
