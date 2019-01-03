<?php   $pt = "View Patient Info"; ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formpape")) {

if(isset($_POST["lmp"])) {
	      $_POST['lmp'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['lmp'])));
}
if(isset($_POST["edd"])) {
	      $_POST['edd'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['edd'])));
}
if(isset($_POST["ussedd"])) {
	      $_POST['ussedd'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['ussedd'])));
}
if(isset($_POST["firstvisit"])) {
	      $_POST['firstvisit'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['firstvisit'])));
}
if(isset($_POST['HistPatHeart']) && $_POST['HistPatHeart'] == 'on'){$_POST['HistPatHeart'] = 'Y';} else {$_POST['HistPatHeart'] = 'N';}
if(isset($_POST['HistPatChest']) && $_POST['HistPatChest'] == 'on'){$_POST['HistPatChest'] = 'Y';} else {$_POST['HistPatChest'] = 'N';}
if(isset($_POST['HistPatKidney']) && $_POST['HistPatKidney'] == 'on'){$_POST['HistPatKidney'] = 'Y';} else {$_POST['HistPatKidney'] = 'N';}
if(isset($_POST['HistPatBldTransf']) && $_POST['HistPatBldTransf'] == 'on'){$_POST['HistPatBldTransf'] = 'Y';} else {$_POST['HistPatBldTransf'] = 'N';}
if(isset($_POST['HistPatOperations']) && $_POST['HistPatOperations'] == 'on'){$_POST['HistPatOperations'] = 'Y';} else {$_POST['HistPatOperations'] = 'N';}
if(isset($_POST['HistPatHTN']) && $_POST['HistPatHTN'] == 'on'){$_POST['HistPatHTN'] = 'Y';} else {$_POST['HistPatHTN'] = 'N';}
if(isset($_POST['HistPatSCD']) && $_POST['HistPatSCD'] == 'on'){$_POST['HistPatSCD'] = 'Y';} else {$_POST['HistPatSCD'] = 'N';}
if(isset($_POST['HistPatSeiz']) && $_POST['HistPatSeiz'] == 'on'){$_POST['HistPatSeiz'] = 'Y';} else {$_POST['HistPatSeiz'] = 'N';}
if(isset($_POST['HistPatDM']) && $_POST['HistPatDM'] == 'on'){$_POST['HistPatDM'] = 'Y';} else {$_POST['HistPatDM'] = 'N';}
if(isset($_POST['HistFamHeart']) && $_POST['HistFamHeart'] == 'on'){$_POST['HistFamHeart'] = 'Y';} else {$_POST['HistFamHeart'] = 'N';}
if(isset($_POST['HistFamHypertens']) && $_POST['HistFamHypertens'] == 'on'){$_POST['HistFamHypertens'] = 'Y';} else {$_POST['HistFamHypertens'] = 'N';}
if(isset($_POST['HistFamTb']) && $_POST['HistFamTb'] == 'on'){$_POST['HistFamTb'] = 'Y';} else {$_POST['HistFamTb'] = 'N';}
if(isset($_POST['HistFamDM']) && $_POST['HistFamDM'] == 'on'){$_POST['HistFamDM'] = 'Y';} else {$_POST['HistFamDM'] = 'N';}
if(isset($_POST['HistFamMultiPreg']) && $_POST['HistFamMultiPreg'] == 'on'){$_POST['HistFamMultiPreg'] = 'Y';} else {$_POST['HistFamMultiPreg'] = 'N';}
//exit;
	
  $updateSQL = sprintf("UPDATE anpreg SET medrecnum=%s, lmp=%s, edd=%s, ega=%s, ussedd=%s, firstvisit=%s, obg=%s, obp=%s, specpoints=%s, HistPatHeart=%s, HistPatChest=%s, HistPatKidney=%s, HistPatBldTransf=%s, HistPatOperations=%s, HistPatOther=%s, HistPatHTN=%s, HistPatSCD=%s, HistPatSeiz=%s, HistPatDM=%s, HistFamHeart=%s, HistFamHypertens=%s, HistFamTb=%s, HistFamDM=%s, HistFamMultPreg=%s, HistFamOther=%s, entryby=%s, entrydt=%s WHERE id=%s",
                       GetSQLValueString($_POST['medrecnum'], "int"),
                       GetSQLValueString($_POST['lmp'], "date"),
                       GetSQLValueString($_POST['edd'], "date"),
                       GetSQLValueString($_POST['ega'], "date"),
                       GetSQLValueString($_POST['ussedd'], "date"),
                       GetSQLValueString($_POST['firstvisit'], "date"),
                       GetSQLValueString($_POST['obg'], "text"),
                       GetSQLValueString($_POST['obp'], "text"),
                       GetSQLValueString($_POST['specpoints'], "text"),					                          
                       GetSQLValueString($_POST['HistPatHeart'], "text"),
                       GetSQLValueString($_POST['HistPatChest'], "text"),
                       GetSQLValueString($_POST['HistPatKidney'], "text"),
                       GetSQLValueString($_POST['HistPatBldTransf'], "text"),
                       GetSQLValueString($_POST['HistPatOperations'], "text"),
                       GetSQLValueString($_POST['HistPatOther'], "text"),
                       GetSQLValueString($_POST['HistPatHTN'], "text"),
                       GetSQLValueString($_POST['HistPatSCD'], "text"),
                       GetSQLValueString($_POST['HistPatSeiz'], "text"),
                       GetSQLValueString($_POST['HistPatDM'], "text"),

                       GetSQLValueString($_POST['HistFamHeart'], "text"),
                       GetSQLValueString($_POST['HistFamHypertens'], "text"),
                       GetSQLValueString($_POST['HistFamTb'], "text"),
                       GetSQLValueString($_POST['HistFamDM'], "text"),
                       GetSQLValueString($_POST['HistFamMultPreg'], "text"),
                       GetSQLValueString($_POST['HistFamOther'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"),
                       GetSQLValueString($_POST['id'], "int"));


  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($updateSQL, $swmisconn) or die(mysql_error());

  $updateGoTo = "PatShow1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= str_replace('pge=PatAntePregEdit.php','pge=PatAntePregView.php',$_SERVER['QUERY_STRING']); 
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>

<?php
$colname_mrn = "-1";
if (isset($_SESSION['mrn'])) {
  $colname_mrn = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']);
}
$colname_preg = "-1";
if (isset($_GET['pregid'])) {
  $colname_preg = (get_magic_quotes_gpc()) ? $_GET['pregid'] : addslashes($_GET['pregid']);
}

mysql_select_db($database_swmisconn, $swmisconn);
$query_preg = sprintf("SELECT id, medrecnum, DATE_FORMAT(lmp,'%%b %%d, %%Y') lmp, DATE_FORMAT(edd,'%%b %%d, %%Y') edd, ega, DATE_FORMAT(ussedd,'%%b %%d, %%Y') ussedd, DATE_FORMAT(firstvisit,'%%b %%d, %%Y') firstvisit, obg, obp, specpoints, HistPatHeart, HistPatChest, HistPatKidney, HistPatBldTransf, HistPatOperations, HistPatOther, HistPatHTN, HistPatSCD, HistPatSeiz, HistPatDM, HistFamHeart, HistFamHypertens, HistFamTb, HistFamDM, HistFamMultPreg, HistFamOther FROM anpreg WHERE medrecnum = %s AND id = %s ORDER BY id ASC", $colname_mrn, $colname_preg);
$preg = mysql_query($query_preg, $swmisconn) or die(mysql_error());
$row_preg = mysql_fetch_assoc($preg);
$totalRows_preg = mysql_num_rows($preg);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="../../jquery-ui-1.11.2.custom/jquery-ui.css" />
   <!--<script src="../../ckeditor/ckeditor.js"></script>-->
	<style type="text/css">@import url(../../jscalendar-1.0/calendar-win2k-1.css);</style>
	<script type="text/javascript" src="../../jscalendar-1.0/calendar.js"></script>
	<script type="text/javascript" src="../../jscalendar-1.0/lang/calendar-en.js"></script>
	<script type="text/javascript" src="../../jscalendar-1.0/calendar-setup.js"></script>
    
    <link rel="stylesheet" href="runnable.css" />
    <link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>
  <body>
  
 <form  id="formpape" name="formpape" method="POST">
   <table width="80%" bgcolor="#F8FDCE">
      <tr>
        <td nowrap="nowrap" Title="PregID:<?php echo $row_preg['id']; ?>">MRN:<br />
   	  <input name="medrecnum" type="text" value="<?php echo $_SESSION['mrn'] ?>" size="3" maxlength="9" /></td>

        <td nowrap="nowrap"  class="borderbottomthinblackBold14">Pregnancy<br />
        ID: <?php echo $row_preg['id']; ?></td>
        
        <td class="borderbottomthinblack" nowrap="nowrap" >LMP:
        <img src="../../jscalendar-1.0/img.gif" id="f_trigger_lmp" style="cursor: pointer; border: 1px solid red;" title="Date selector"
      onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br />
      <input name="lmp" type="text" id="lmp" size="8" maxlength="12" value="<?php echo $row_preg['lmp']; ?>"/></td>

        <td class="borderbottomthinblack" nowrap="nowrap" >EDD:
        <img src="../../jscalendar-1.0/img.gif" id="f_trigger_edd" style="cursor: pointer; border: 1px solid red;" title="Date selector"
      onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br />
      <input name="edd" type="text" id="edd" size="8" maxlength="12" value="<?php echo $row_preg['edd']; ?>" /></td>

        <td class="borderbottomthinblack" nowrap="nowrap" >EGA:<br />
      <input name="ega" type="text" id="ega" size="8" maxlength="12" class="BlackBold_12" readonly="readonly" value="<?php echo $row_preg['ega']; ?>" /></td>

        <td class="borderbottomthinblack" nowrap="nowrap" >USS EDD:																																						
        <img src="../../jscalendar-1.0/img.gif" id="f_trigger_uss" style="cursor: pointer; border: 1px solid red;" title="Date selector"
      onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br />
      <input name="ussedd" type="text" id="ussedd" size="8" maxlength="12" value="<?php echo $row_preg['ussedd']; ?>" /></td>
 
        <td class="borderbottomthinblack" nowrap="nowrap" >FirstVisit:
        <img src="../../jscalendar-1.0/img.gif" id="f_trigger_fir" style="cursor: pointer; border: 1px solid red;" title="Date selector"
      onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br />
      <input name="firstvisit" type="text" id="firstvisit" size="8" maxlength="10" value="<?php echo $row_preg['firstvisit']; ?>" /></td>

        <td class="borderbottomthinblack" nowrap="nowrap" >OB Hist:<br />
          G
      <input name="obg" type="text" id="obg" size="1" maxlength="3" value="<?php echo $row_preg['obg']; ?>" /> 
        P
      <input name="obp" type="text" id="obp" size="1" maxlength="3" value="<?php echo $row_preg['obp']; ?>" /></td>
 
       <td nowrap="nowrap" ><div align="center" class="BlueBold_24">Edit Pregnancy</div></td>
       
       <td><div align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePregView.php">Close</a></div></td>
      </tr>
 
  
  <tr>
    <td nowrap="nowrap" >&nbsp;</td>
    <td class="borderbottomthinblackBold14" nowrap="nowrap" ><div align="center">Patient<br />
      History:</div></td>
	  
	  <?php if($row_preg['HistPatHeart'] == "Y") { $bkg1 = "#FFFDDA"; } else {$bkg1 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg1; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistPatHeart" id="HistPatHeart" <?php if ($row_preg['HistPatHeart'] == "Y") {echo "checked=\"checked\"";} ?>  />
      Heart<br /> Disease</td> 

	  <?php if($row_preg['HistPatChest'] == "Y") {$bkg2 = "#FFFDDA"; } else {$bkg2 = "#DCDCDC";} ?> 
	<td class="borderbottomthinblack" bgcolor=<?php echo $bkg2; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistPatChest" id="HistPatChest" style="text-align: center;" size="1" maxlength="1" <?php if ($row_preg['HistPatChest'] == "Y") {echo "checked=\"checked\"";} ?> />
      Chest<br />Disease</td>
	  
	  <?php if($row_preg['HistPatKidney'] == "Y") { $bkg3 = "#FFFDDA";} else {$bkg3 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg3; ?> nowrap="nowrap" > 
      <input type="checkbox" name="HistPatKidney" id="HistPatKidney" style="text-align: center;" size="1" maxlength="1" <?php if ($row_preg['HistPatKidney'] == "Y") {echo "checked=\"checked\"";} ?>  />
      Kidney<br /> Disease</td>

	  <?php if($row_preg['HistPatBldTransf'] == "Y") { $bkg4 = "#FFFDDA";} else {$bkg4 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg4; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistPatBldTransf" id="HistPatBldTransf" style="text-align: center;" size="1" maxlength="1" <?php if ($row_preg['HistPatBldTransf'] == "Y") {echo "checked=\"checked\"";} ?> />
      Blood<br />Transf'ns </td>

	  <?php if($row_preg['HistPatOperations'] == "Y") { $bkg5 = "#FFFDDA";} else {$bkg5 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg5; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistPatOperations" id="HistPatOperations" style="text-align: center;" size="1" maxlength="1" <?php if ($row_preg['HistPatOperations'] == "Y") {echo "checked=\"checked\"";} ?>  />
      Operations<br/>&nbsp; </td>

        <td class="borderbottomthinblack" nowrap="nowrap" >Special<br />
        Points:</td>
      <td class="borderbottomthinblack" nowrap="nowrap" ><textarea name="specpoints" cols="40" rows="1" id="specpoints" ><?php echo $row_preg['specpoints']; ?></textarea></td>
    <td width="8" nowrap="nowrap" ></td>
  </tr>

<!--line 3-->

  <tr>
    <td nowrap="nowrap" >&nbsp;</td>
    <td class="borderbottomthinblackBold14" nowrap="nowrap" ><div align="center">Patient<br />
      History:</div></td>
	  
	  <?php if($row_preg['HistPatHTN'] == "Y") { $bkg1 = "#FFFDDA"; } else {$bkg1 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg1; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistPatHTN" id="HistPatHTN" <?php if ($row_preg['HistPatHTN'] == "Y") {echo "checked=\"checked\"";} ?>  />
      Hyper-<br />Tension</td> 

	  <?php if($row_preg['HistPatSCD'] == "Y") {$bkg2 = "#FFFDDA"; } else {$bkg2 = "#DCDCDC";} ?> 
	<td class="borderbottomthinblack" bgcolor=<?php echo $bkg2; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistPatSCD" id="HistPatSCD" style="text-align: center;" size="1" maxlength="1" <?php if ($row_preg['HistPatSCD'] == "Y") {echo "checked=\"checked\"";} ?> />
      SCD<br />&nbsp;</td>
	  
	  <?php if($row_preg['HistPatSeiz'] == "Y") { $bkg3 = "#FFFDDA";} else {$bkg3 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg3; ?> nowrap="nowrap" > 
      <input type="checkbox" name="HistPatSeiz" id="HistPatSeiz" style="text-align: center;" size="1" maxlength="1" <?php if ($row_preg['HistPatSeiz'] == "Y") {echo "checked=\"checked\"";} ?>  />
      Seizures<br />&nbsp;</td>
 
	  <?php if($row_preg['HistPatDM'] == "Y") { $bkg4 = "#FFFDDA";} else {$bkg4 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg4; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistPatDM" id="HistPatDM" style="text-align: center;" size="1" maxlength="1" <?php if ($row_preg['HistPatDM'] == "Y") {echo "checked=\"checked\"";} ?> />
      Diabetes<br />&nbsp; </td>
      
   <td nowrap="nowrap" >&nbsp;</td>

    <td class="borderbottomthinblack" nowrap="nowrap" >Other:</td>
    <td class="borderbottomthinblack" nowrap="nowrap" ><textarea name="HistPatOther" cols="40" rows="1" id="HistPatOther"><?php echo $row_preg['HistPatOther']; ?></textarea></td>
    <td width="8" nowrap="nowrap" ><input type="submit" name="Submit" value="Save&#10;Edit" /></td>
  </tr>


<!--line 4-->


  <tr>
    <td nowrap="nowrap"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePregDelete.php&pregid=<?php echo $row_preg['id']; ?>">Delete</a></td>
    <td class="borderbottomthinblackBold14" nowrap="nowrap" ><div align="center">Family<br />
      History:</div></td>

	  <?php if($row_preg['HistFamHeart'] == "Y") { $bkg1 = "#FFFDDA"; } else {$bkg1 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg1; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistFamHeart" id="HistFamHeart" <?php if ($row_preg['HistFamHeart'] == "Y") {echo "checked=\"checked\"";} ?>  />
      Heart<br /> Disease</td> 
	  
	  <?php if($row_preg['HistFamHypertens'] == "Y") { $bkg1 = "#FFFDDA"; } else {$bkg1 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg1; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistFamHypertens" id="HistFamHypertens" <?php if ($row_preg['HistFamHypertens'] == "Y") {echo "checked=\"checked\"";} ?>  />
      Hyper-<br />Tension</td> 

	  <?php if($row_preg['HistFamTb'] == "Y") {$bkg2 = "#FFFDDA"; } else {$bkg2 = "#DCDCDC";} ?> 
	<td class="borderbottomthinblack" bgcolor=<?php echo $bkg2; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistFamTb" id="HistFamTb" style="text-align: center;" size="1" maxlength="1" <?php if ($row_preg['HistFamTb'] == "Y") {echo "checked=\"checked\"";} ?> />
      Tuberc-<br />ulosis</td>

	  <?php if($row_preg['HistFamDM'] == "Y") { $bkg4 = "#FFFDDA";} else {$bkg4 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg4; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistFamDM" id="HistFamDM" style="text-align: center;" size="1" maxlength="1" <?php if ($row_preg['HistFamDM'] == "Y") {echo "checked=\"checked\"";} ?> />
      Diabetes<br />&nbsp; </td>

	
	  <?php if($row_preg['HistFamMultPreg'] == "Y") { $bkg1 = "#FFFDDA"; } else {$bkg1 = "#DCDCDC";} ?> 
    <td class="borderbottomthinblack" bgcolor=<?php echo $bkg1; ?> nowrap="nowrap" >
      <input type="checkbox" name="HistFamMultPreg" id="HistFamMultPreg" <?php if ($row_preg['HistFamMultPreg'] == "Y") {echo "checked=\"checked\"";} ?>  />
      Multiple<br /> Pregnancies</td> 

    <td class="borderbottomthinblack" nowrap="nowrap" >Other:</td>
    <td class="borderbottomthinblack" nowrap="nowrap" ><textarea name="HistFamOther" cols="40" rows="1" id="HistFamOther"><?php echo $row_preg['HistFamOther']; ?></textarea></td>
    <td nowrap="nowrap" >
      <input type="hidden" name="MM_update" value="formpape" />
      <input type="hidden" name="id" id="id" value="<?php echo $row_preg['id']; ?>">
	  <input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
	  <input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i"); ?>" />	</td>
    </tr>
  </table>
</form>
    <p>&nbsp;</p>
    <script type="text/javascript">
	     Calendar.setup({
        inputField     :    "lmp",     // id of the input field
        ifFormat       :    "%b %e,%Y",      // format of the input field
        button         :    "f_trigger_lmp",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
//        displayArea    :    "show_c",       // ID of the span where the date is to be shown
//        daFormat       :    "%b %e, %Y",// format of the displayed date
        singleClick    :    true
    });

	     Calendar.setup({
        inputField     :    "edd",     // id of the input field
        ifFormat       :    "%b %e,%Y",      // format of the input field
        button         :    "f_trigger_edd",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
//        displayArea    :    "show_c",       // ID of the span where the date is to be shown
//        daFormat       :    "%b %e, %Y",// format of the displayed date
        singleClick    :    true
    });
	 
	     Calendar.setup({
        inputField     :    "ussedd",     // id of the input field
        ifFormat       :    "%b %e,%Y",      // format of the input field
        button         :    "f_trigger_uss",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
//        displayArea    :    "show_c",       // ID of the span where the date is to be shown
//        daFormat       :    "%b %e, %Y",// format of the displayed date
        singleClick    :    true
    });

	     Calendar.setup({
        inputField     :    "firstvisit",     // id of the input field
        ifFormat       :    "%b %e,%Y",      // format of the input field
        button         :    "f_trigger_fir",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
//        displayArea    :    "show_c",       // ID of the span where the date is to be shown
//        daFormat       :    "%b %e, %Y",// format of the displayed date
        singleClick    :    true
    });

</script>

  </body>
</html>