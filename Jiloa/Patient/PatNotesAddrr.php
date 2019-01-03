<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<!-- http://www.rrpowered.com/2014/07/auto-save-a-draft-with-php-and-jquery/-->




<?php $_SESSION['CurrDateTime'] =  date("Y-m-d H:i:s"); ?>
 
<?xml version="1.0" encoding="utf-8"?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  <!--  lang="en"-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />  <!--<meta charset="UTF-8" />-->
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../javascript_form/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
    <script rel="text/javascript" src="../../jquery-1.11.1.js"></script>
    <script rel="text/javascript" src="rrpowered-autosavedraft.js"></script>
</head>


<body>

<!--        <form>
            <input type="text" name="title" placeholder="Title" autofocus>
            <textarea type="text" name="body" placeholder="Body"></textarea>
            <input type="submit" value="Send">
        </form>
-->
<body>
<table width="60%" align="center">
  <caption align="top" class="subtitlebl">
   Add Patient Notes
  </caption>
  <tr>
    <td><form  id="formpn1" name="formpn1" method="POST" action="">
      <table width="100%" bgcolor="#BCFACC">
        <tr>
          <td valign="middle" nowrap="nowrap">*Notes:<br />
		    <a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php">Close</a></td>
		  <td><textarea name="notes" cols="80" rows="3" id="notes"></textarea></td>
		  <td width="10%" nowrap="nowrap" title="not required - must be a number 1 - 300">pulse
            <input name="pulse" type="text" id="pulse" size="5" maxlength="5" /></td>
          <td width="10%" nowrap="nowrap">temp
            <input name="temp" type="text" id="temp" size="5" maxlength="5" /></td>
          <td width="10%" nowrap="nowrap">systolic
            <input name="bp_sys" type="text" id="bp_sys"  size="5" maxlength="5" /></td>
         <td width="10%" nowrap="nowrap">diastolic
            <input name="bp_dia" type="text" id="bp_dia" size="5" maxlength="5" />
            <input name="medrecnum" type="hidden" id="medrecnum" value="<?php echo $_SESSION['mrn']; ?>" />
            <input name="visitid" type="hidden" id="visitid" value="<?php echo $_SESSION['vid']; ?>" />
            <input name="entryby" type="hidden" id="entryby" value="<?php echo $_SESSION['user']; ?>" />
            <input name="entrydt" type="hidden" id="entrydt" value="<?php echo $_SESSION['CurrDateTime']; ?>" /></td>
         <td width="10%" nowrap="nowrap"><input type="submit" value="Save Notes" />           </td>
        </tr>
      </table>
    </form>

	   <script language="JavaScript" type="text/javascript"
		xml:space="preserve">//<![CDATA[
	//You should create the validator only after the definition of the HTML form
	  var frmvalidator  = new Validator("formpn1");
	  frmvalidator.EnableMsgsTogether();
	  
 	  frmvalidator.addValidation("notes","req","Please enter Notes");
      frmvalidator.addValidation("notes","minlen=3", "Minumun length for Notes is 3");

	  frmvalidator.addValidation("pulse","num","Pulse: Numbers Only");
	  frmvalidator.addValidation("pulse","gt=0","Pulse: Min = 1");
	  frmvalidator.addValidation("pulse","lt=301","Pulse: Max = 300");

	  frmvalidator.addValidation("temp","num","Temp: Numbers Only");
	  frmvalidator.addValidation("temp","gt=29","Temp: Min = 30");
	  frmvalidator.addValidation("temp","lt=46","Temp: Max = 45");

	  frmvalidator.addValidation("bp_sys","num","Systolic: Numbers Only");
	  frmvalidator.addValidation("bp_sys","gt=9","Systolic: Min = 10");
	  frmvalidator.addValidation("bp_sys","lt=501","Systolic: Max = 500");

	  frmvalidator.addValidation("bp_dia","num","Diastolic: Numbers Only");
	  frmvalidator.addValidation("bp_dia","gt=9","Diastolic: Min = 10");
	  frmvalidator.addValidation("bp_dia","lt=501","Diastolic: Max = 500");

	  </script>
    </td>
  </tr>
</table>

</body>
</html>
