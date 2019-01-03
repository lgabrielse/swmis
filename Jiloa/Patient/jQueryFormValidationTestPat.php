<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php /*if (!isset($messages)) {
	$messages = ""; 
}*/?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>Form validation testing</p>
<table width="60%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="1" cellspacing="0" cellpadding="0">
<?php //if($messages <> ""){?>
        <tr>
          <td>Errors:</td>
          <td ><a id="errmsg"></td>
        </tr>
<?php // }?>
        <tr>
          <td>Patient Name (Req, 2-30 char) </td>
          <td><input name="name" type="text" id="name" data-validation="length" data-validation-length="3-30" /></td>
        </tr>
        <tr>
          <td>Gender DDL value must be &quot;&quot; to get error </td>
          <td><select name="gender" id="gender" data-validation="required" type="text">
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            </select>
            </td>
        </tr>
        <tr>
          <td>Require Field </td>
          <td><input name="text" type="text" id="text" data-validation="required" data-validation-error-msg="Required!" data-validation-help="Please give us some more information"/></td>
        </tr>
        <tr>
          <td>Date of Birth  YYYY-MM-DD</td>
          <td><input name="DOB" type="text" id="DOB" data-validation="date" /></td>
        </tr>
        <tr>
          <td>What's your favorite color?</td>
          <td><input name="color" data-suggestions="White, Green, Blue, Black, Brown"/></td>
        </tr>
        <tr>
          <td>Array suggestions</td>
          <td><input name="the-input" id="the-input" data-validation="required" data-validation-error-msg="Required!" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="Submit" value="Submit" /></td>
        </tr>
      </table>
        </form>
<script src="../../jquery-1.11.1.js"></script>
<script src="../../jQuery-Form-Validator-master/form-validator/jquery.form-validator.min.js"></script>
<script>
/* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
    $.validate({
		//modules : 'date, security'
    });</script>
	
	<script>
  var largeArray = [];
  largeArray.push('Something');
  largeArray.push('Something else');
  $.formUtils.suggest( $('#the-input'), largeArray );
</script>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
