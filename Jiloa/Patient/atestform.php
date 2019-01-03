<?php if(!isset($_POST['text1'])) {
$_POST['text1'] = "999"; }?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script language="JavaScript" src="../../javascript_form/examples/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
</head>

<body>
<p>&nbsp;</p>
<table width="40%" border="1" align="center" cellpadding="0" cellspacing="0">
<form id="formzzzz" name="formzzzz" method="post" action="">  <tr>
    <td><?php echo $_POST['text1'] ?></td>
  </tr>
  <tr>
    <td>
      <input name="text1" type="text" id="text1" />
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="Submit" value="Submit" /></td>
  </tr>
</form>
<script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("formzzzz");
  frmvalidator.EnableMsgsTogether();
  
  frmvalidator.addValidation("text1","req","Please enter your First Name");
  frmvalidator.addValidation("text1","maxlen=20",	"Max length for FirstName is 20");
  frmvalidator.addValidation("text1","alpha","Alphabetic chars only");
</script>
</table>
<p>&nbsp;</p>
</body>
</html>
