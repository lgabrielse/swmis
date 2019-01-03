<?php  $pt = "Home"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'?len/Jiloa/Master/Header.php'); ?> 
<?php
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
	<link href="/Len/css/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="80%" border="0" align="center">
  <tr>
    <th height="50" bgcolor="#6AF50E" class="subtitle" scope="col">Home page </th>
  </tr>
  <tr>
    <td><p>The structure Rule:<br /> 
      1. Use Master/Header on the top of each page. Provides Banner, Menu, Date Time, Login &amp; Logout </p>
      <p>2. Use Master/Footer on bottom of page  as needed </p></td>
  </tr>
  <tr>
    <td height="50" bgcolor="#ECF039" class="subtitle">Messages</td>
  </tr>
  <tr>
	<td>:::<?php  echo curPageURL(); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="50" bgcolor="#E2C45A" class="subtitle">Inspiration</td>
  </tr>
</table>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Footer.php'); ?> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

</body>
</html>
