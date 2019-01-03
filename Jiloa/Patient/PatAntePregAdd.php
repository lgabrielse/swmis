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
// solution from http://www.webdeveloper.com/forum/showthread.php?249403-Submitting-dates-to-a-Database
//print_r($_POST); use this and disable 'insertgoto' to display date format being posted
//
//$date=$_POST['date']; //or $_GET 
////check date format here before continuing.
//list($day,$month,$year)=explode('/',$date);
//$timestamp=mktime(0,0,0,$month,$day,$year);
//$final_date=date('Y-m-d',$timestamp); 
 
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formapa")) {
//	if(isset($_POST['lmp'])) {  //  && $_POST['edd'] = '' ??
//   $edd = $_POST['lmp'];  //date_add($_POST['lmp'],date_interval_create_from_date_string("10 days"));
//	} else {
//	$edd = '';
//	}
	//$edd = lmp + 280 days
if(isset($_POST["lmp"])) {
	      $_POST['lmp'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['lmp'])));
}
if(isset($_POST["f_calcdate"])) {
	      $_POST['f_calcdate'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['f_calcdate'])));
}
if(isset($_POST["ussedd"])) {
	      $_POST['ussedd'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['ussedd'])));
}
if(isset($_POST["firstvisit"])) {
	      $_POST['firstvisit'] = date('Y-m-d', strtotime(str_replace('-', '/', $_POST['firstvisit'])));
//	echo $_POST['firstvisit'];
//} else {
//	echo 'no firstvisit';
//exit;
}
//if(isset($_POST['HistPatHeart'])) {
//	echo $_POST['HistPatHeart'];
//	} else {
//	echo 'not set';
//	}
//exit;
  $insertSQL = sprintf("INSERT INTO anpreg (medrecnum, visitid, lmp, edd, ussedd, ega, firstvisit, obg, obp, specpoints, HistPatHeart, HistPatChest, HistPatKidney, HistPatBldTransf, HistPatOperations, HistPatHTN, HistPatSCD, HistPatSeiz, HistPatDM, HistPatOther, HistFamMultPreg, HistFamTb, HistFamHypertens, HistFamHeart, HistFamDM, HistFamOther, entryby, entrydt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['medrecnum'], "int"),
                       GetSQLValueString($_POST['visitid'], "int"),
                       GetSQLValueString($_POST['lmp'], "date"),
                       GetSQLValueString($_POST['f_calcdate'], "date"),  //$edd, "date"),
                       GetSQLValueString($_POST['ussedd'], "date"),
                       GetSQLValueString($_POST['ega'], "text"),
                       GetSQLValueString($_POST['firstvisit'], "date"),
                       GetSQLValueString($_POST['obg'], "text"),
                       GetSQLValueString($_POST['obp'], "text"),
                       GetSQLValueString($_POST['specpoints'], "text"),					                          
                       GetSQLValueString($_POST['HistPatHeart'], "text"),
                       GetSQLValueString($_POST['HistPatChest'], "text"),
                       GetSQLValueString($_POST['HistPatKidney'], "text"),
                       GetSQLValueString($_POST['HistPatBldTransf'], "text"),
                       GetSQLValueString($_POST['HistPatOperations'], "text"),
                       GetSQLValueString($_POST['HistPatHTN'], "text"),
                       GetSQLValueString($_POST['HistPatSCD'], "text"),
                       GetSQLValueString($_POST['HistPatSeiz'], "text"),
                       GetSQLValueString($_POST['HistPatDM'], "text"),
                       GetSQLValueString($_POST['HistPatOther'], "text"),
                       GetSQLValueString($_POST['HistFamMultPreg'], "text"),
                       GetSQLValueString($_POST['HistFamTb'], "text"),
                       GetSQLValueString($_POST['HistFamHypertens'], "text"),
                       GetSQLValueString($_POST['HistFamHeart'], "text"),
                       GetSQLValueString($_POST['HistFamDM'], "text"),
                       GetSQLValueString($_POST['HistFamOther'], "text"),
                       GetSQLValueString($_POST['entryby'], "text"),
                       GetSQLValueString($_POST['entrydt'], "date"));

  mysql_select_db($database_swmisconn, $swmisconn);
  $Result1 = mysql_query($insertSQL, $swmisconn) or die(mysql_error());

   $insertGoTo = "PatShow1.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= str_replace('pge=PatAntePregAdd.php','pge=PatAntePregView.php',$_SERVER['QUERY_STRING']); // replace function takes &notepage=PatNotesAdd.php out of $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!--   <link rel="stylesheet" href="runnable.css" /> -->
   <link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" href="../../jquery-ui-1.11.2.custom/jquery-ui.css" /> <!--needed for calendar-->

   <!--<script src="../../ckeditor/ckeditor.js"></script>-->
	<style type="text/css">@import url(../../jscalendar-1.0/calendar-win2k-1.css);</style>
	<script type="text/javascript" src="../../jscalendar-1.0/calendar.js"></script>
	<script type="text/javascript" src="../../jscalendar-1.0/lang/calendar-en.js"></script>
	<script type="text/javascript" src="../../jscalendar-1.0/calendar-setup.js"></script>
    
	 
   
</head>
  <body>
  
<form  id="formapa" name="formapa" method="POST" action="<?php echo $editFormAction; ?>">
    <table width="80%" cellpadding="2" cellspacing="2" bgcolor="#BCFACC">
      <tr>
        <td nowrap="nowrap" >MRN:<br />
    <?php echo $_SESSION['mrn'] ?>
    <input name="medrecnum" type="hidden" value="<?php echo $_SESSION['mrn'] ?>" /></td>
        <td class="borderbottomthinblackBold14" nowrap="nowrap" >Pregnancy<br />       #
        </td>
 	     <td nowrap="nowrap" bgcolor="#C0E8D5" class="borderbottomthinblack" >LMP:
<img src="../../jscalendar-1.0/img.gif" id="f_trigger_a" style="cursor: pointer; border: 1px solid red;" title="Date selector"
      onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br />
        		 <input name="lmp" type="text" style="font-size:12px;" id="lmp" size="7" maxlength="12" />
        </td>
	     <td nowrap="nowrap" bgcolor="#C0E8D5" class="borderbottomthinblack" >EDD:
<img src="../../jscalendar-1.0/img.gif" id="f_trigger_b" style="cursor: pointer; border: 1px solid red;" title="Date selector"
      onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br />
           <input name="f_calcdate" type="text" id="f_calcdate" style="font-size:12px;" size="7" maxlength="12" />
        </td>
       <td nowrap="nowrap" bgcolor="#C0E8D5" class="borderbottomthinblack" >EGA:<br/>
           <input type="text" name="ega" id="ega" style="font-size:12px;" size="7" maxlength="12" value="" />
       </td>

       <td nowrap="nowrap" bgcolor="#C0E8D5" class="borderbottomthinblack" >USS LMP:
<img src="../../jscalendar-1.0/img.gif" id="f_trigger_us" style="cursor: pointer; border: 1px solid red;" title="Date selector"
      onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br />
       <input name="ussedd" type="text" id="ussedd" style="font-size:12px;" size="7" maxlength="12" />
      </td>
      
        <td class="borderbottomthinblack" nowrap="nowrap" >FirstVisit:
<img src="../../jscalendar-1.0/img.gif" id="f_trigger_fv" style="cursor: pointer; border: 1px solid red;" title="Date selector"
      onmouseover="this.style.background='red';" onmouseout="this.style.background=''" /><br />	
      <input name="firstvisit" type="text" id="firstvisit" style="font-size:12px;" size="7" maxlength="12" /> 
        </td>
        <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" >OB Hist:<br />
          G
        <input name="obg" type="text" id="obg" size="1" maxlength="3" /> 
        P
      <input name="obp" type="text" id="obp" size="1" maxlength="3" />
        </td>
        <td class="BlueBold_24" nowrap="nowrap" ><div align="center">Add Pregnancy</td>
        <td  bgcolor="#C0E8D5"nowrap="nowrap" ><div align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePregView.php">Close</a></div></td>
      </tr>
  <tr>
    <td nowrap="nowrap" >VisitID:<br />
    <?php echo $_SESSION['vid'] ?>
    <input name="visitid" type="hidden" value="<?php echo $_SESSION['vid'] ?>" /></td>
    
    <td class="borderbottomthinblackBold14" nowrap="nowrap" ><div align="center">Patient<br />
      History:</div></td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
    <input type="hidden" name="HistPatHeart" value="N" />
    <input type="checkbox" name="HistPatHeart" id="HistPatHeart" value="Y" >
      Heart <br /> &nbsp;&nbsp;&nbsp;Disease 
    </div></td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
      <input type="hidden" id="HistPatChest" name="HistPatChest" value="N">
      <input type="checkbox" id="HistPatChest" name="HistPatChest" value="Y">
      Chest <br />&nbsp;&nbsp;&nbsp;&nbsp;Disease  
      </div>  </td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
       <input type="hidden" id="HistPatKidney" name="HistPatKidney" value="N">
      <input type="checkbox" id="HistPatKidney" name="HistPatKidney" value="Y">
      Kidney<br/>Disease &nbsp;&nbsp;&nbsp; 
      </div>  </td>
 
    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
      <input type="hidden" id="HistPatBldTransf" name="HistPatBldTransf" value="N">
      <input type="checkbox" id="HistPatBldTransf" name="HistPatBldTransf" value="Y">
      Blood<br />&nbsp;&nbsp;&nbsp;&nbsp;Transf'ns 
    </div></td>
	
    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
      <input type="hidden" id="HistPatOperations" name="HistPatOperations" value="N">
      <input type="checkbox" id="HistPatOperations" name="HistPatOperations" value="Y">
      <br />&nbsp;&nbsp;&nbsp;&nbsp;Operations
    </div></td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" >Special<br />
        Points:
    </td>
    <td class="borderbottomthinblack" nowrap="nowrap" ><textarea name="specpoints" cols="40" rows="1" id="specpoints"></textarea></td>
    <td bgcolor="#C0E8D5" nowrap="nowrap" >
    </td>
  </tr>

<!--third row-->

  <tr>
    <td nowrap="nowrap" ></td>
    <td class="borderbottomthinblackBold14" nowrap="nowrap" ><div align="center">Patient<br />
      History:</div></td>
    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
    <input type="hidden" name="HistPatHTN" id="HistPatHTN" value="N" />
    <input type="checkbox" name="HistPatHTN" id="HistPatHTN" value="Y" >
      Hyper <br /> &nbsp;&nbsp;&nbsp;tension 
    </div></td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" >
      <input type="hidden" id="HistPatSCD" name="HistPatSCD" value="N">
      <input type="checkbox" id="HistPatSCD" name="HistPatSCD" value="Y">
      SCD <br />&nbsp;&nbsp;&nbsp;&nbsp;
    </td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" >
       <input type="hidden" id="HistPatSeiz" name="HistPatSeiz" value="N">
      <input type="checkbox" id="HistPatSeiz" name="HistPatSeiz" value="Y">
      Seizures<br/> &nbsp;&nbsp;&nbsp;
 
  <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" >
      <input type="hidden" id="HistPatDM" name="HistPatDM" value="N">
      <input type="checkbox" id="HistPatDM" name="HistPatDM" value="Y">
     Diabetes<br />&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
	
    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ></td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" >Other:</td>
    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><textarea name="HistPatOther" cols="40" rows="1" id="HistPatOther"></textarea></td>
    <td bgcolor="#C0E8D5" nowrap="nowrap" ></td>
    </tr>


<!--fourth row-->
  <tr>
    <td nowrap="nowrap" >&nbsp;</td>
    <td class="borderbottomthinblackBold14" nowrap="nowrap" ><div align="center">Family<br />
      History:</div></td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
    <input type="hidden" name="HistFamHeart" id="HistFamHeart" value="N" />
    <input type="checkbox" name="HistFamHeart" id="HistFamHeart" value="Y" >
      Heart <br /> &nbsp;&nbsp;&nbsp;Disease 
    </div></td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
    <input type="hidden" name="HistFamHypertens" id="HistFamHypertens" value="N" />
    <input type="checkbox" name="HistFamHypertens" id="HistFamHypertens" value="Y" >
      Hyper <br /> &nbsp;&nbsp;&nbsp;tension 
    </div></td>
	
    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
    <input type="hidden" name="HistFamTb" id="HistFamTb" value="N" />
    <input type="checkbox" name="HistFamTb" id="HistFamTb" value="Y" >
      Tuberc- <br /> &nbsp;&nbsp;&nbsp;ulosis
    </div></td>
		
  <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
      <input type="hidden" id="HistFamDM" name="HistFamDM" value="N">
      <input type="checkbox" id="HistFamDM" name="HistFamDM" value="Y">
     Diabetes<br />&nbsp;&nbsp;&nbsp;&nbsp;
    </div></td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><div align="left">
    <input type="hidden" name="HistFamMultPreg" id="HistFamMultPreg" value="N" />
    <input type="checkbox" name="HistFamMultPreg" id="HistFamMultPreg" value="Y" >
    Multiple<br /> &nbsp;&nbsp;&nbsp;Preg's 
    </div></td>

    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" >Other:</td>
    <td bgcolor="#C0E8D5" class="borderbottomthinblack" nowrap="nowrap" ><textarea name="HistFamOther" cols="40" rows="1" id="HistFamOther"></textarea></td>
    <td bgcolor="#C0E8D5" nowrap="nowrap" ><input type="submit" name="Submit" value="Save" />
    
      <input name="MM_insert" type="hidden" value="formapa" />
      <input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
      <input name="entrydt" type="hidden" id="entrydt" value="<?php echo date("Y-m-d H:i"); ?>" /></td>
    </tr>
  </table>
</form>
    <p>&nbsp;</p>  <!--https://github.com/virasak/jscalendar/blob/master/simple-1.html   <br />
							 has some date definitions... ues php format http://php.net/manual/en/function.strftime.php-->
                      


<script type="text/javascript">
    function catcalc(cal) {
        var date = cal.date;
 		  var days = 280;
        var time = date.getTime()
        // use the _other_ field
        var field = document.getElementById("f_calcdate");
        if (field == cal.params.inputField) {
            field = document.getElementById("f_date_a");
            time = date.setTime( time - days * 86400000 ); // substract one week
        } else {
            time = date.setTime( time + days * 86400000 ); // add one week
        } 
				//var newDate = new Date(date.setTime( date.getTime() + days * 86400000 ));
        
        var date2 = new Date(time);
        field.value = date2.print("%Y-%m-%d");
    }
	 
	  ////https://www.htmlgoodies.com/html5/javascript/calculating-the-difference-between-two-dates-in-javascript.html
	  //// datepart: 'y', 'm', 'w', 'd', 'h', 'n', 's'  

//Date.dateDiff = function(datepart, fromdate, todate) {	
//  datepart = datepart.toLowerCase();	
//  var diff = todate - fromdate;	
//  var divideBy = { w:604800000, 
//                   d:86400000, 
//                   h:3600000, 
//                   n:60000, 
//                   s:1000 };	
//  
//  return Math.floor( diff/divideBy[datepart]);
//}
////Set the two dates
//
//var lmp  = DateFormat(document.getElementById("lmp"), ;
//var today = new Date();
////var ega = Date.dateDiff('w', lmp, today); //displays num weeks
//  //document.write(ega);
//  document.getElementById("ega").value = Math.round(Date.dateDiff('w', lmp, today));
	 
 
    Calendar.setup({
        inputField     :    "lmp",   // id of the input field
        ifFormat       :    "%b %e,%Y",       // format of the input field  e.g. "%Y-%m-%d" for entry into mysql
        //showsTime      :    true,
        //timeFormat     :    "24",
//       displayArea    :    "show_a",       // ID of the span where the date is to be shown
//        daFormat       :    "%b %e, %Y",// format of the displayed date
        button         :    "f_trigger_a",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl" use "T1" for top)
        singleClick    :    true,
        onUpdate       :    catcalc
	
	  
		  
    });

    Calendar.setup({
        inputField     :    "f_calcdate",
        ifFormat       :    "%b %e,%Y",
        //showsTime      :    true,
        //timeFormat     :    "24",
        button         :    "f_trigger_b",  // trigger for the calendar (button ID)
//        displayArea    :    "show_b",       // ID of the span where the date is to be shown
//        daFormat       :    "%b %e, %Y",// format of the displayed date
        align          :    "Tl",           // alignment (defaults to "Bl" use "T1" for top)
        singleClick    :    true,
        onUpdate       :    catcalc
    });
	 
	     Calendar.setup({
        inputField     :    "ussedd",     // id of the input field
        ifFormat       :    "%b %e,%Y",      // format of the input field
        button         :    "f_trigger_us",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
//        displayArea    :    "show_c",       // ID of the span where the date is to be shown
//        daFormat       :    "%b %e, %Y",// format of the displayed date
        singleClick    :    true
    });

	     Calendar.setup({
        inputField     :    "firstvisit",     // id of the input field
        ifFormat       :    "%b %e,%Y",      // format of the input field
        button         :    "f_trigger_fv",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
//        displayArea    :    "show_c",       // ID of the span where the date is to be shown
//        daFormat       :    "%b %e, %Y",// format of the displayed date
        singleClick    :    true
    });

</script>

  </body>
</html>

<!--medrecnum, lmp,edd, ussedd, firstvisit, obg, obp, specpoints, HistPatHeart,	HistPatChest, HistPatKidney, HistPatBldTransf, HistPatOperations, HistPatOther, 	HistFamMultPreg, HistFamTb, HistFamHypertens, HistFamHeart, HistFamOther -->