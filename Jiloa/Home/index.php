<?php ob_start(); ?>
<?php $pt = "Home";  //Jiloa/home.index ?>
<?php //echo $_COOKIE['loggedin'] ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?> 
<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>

<?php // find server name
function curPageURL() {
$isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
$port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
$port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
$url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
return $url;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
	<link href="/Len/css/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="800" border="0" align="center">
  <tr>  <!--#151B8D  orig dk Blue  #99CCFF lt blue-->
    <td height="20" bgcolor="#2196f3" align="center"><span class="flagWhiteonBlue">Home Page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Not I, But Christ! </span></td>
  </tr>
<!--<p>The structure Rule:<br /> 
      1. Use Master/Header on the top of each page. Provides Banner, Menu, Date Time, Login &amp; Logout <br/>2. Use Master/Footer on bottom of page  as needed </p>-->
  <tr>
    <td height="20" align="center" >
<?php if (allow(29,1) == 1) {	?>
	<a href="../mrbs-1.4.10/web/index.php" target="_blank">Scheduling </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }?>
<?php if (allow(29,2) == 1) {	?>
	<a href="http://mrbs.sourceforge.net/" target="_blank">                MRBS</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }?>
<?php if (allow(29,4) == 1) {	?>
	<a href="../HelpnDoc/Output/Build pdf documentation/SWMIS Developer Documentation.pdf" target="_blank">DevDocuments</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php }?>
	<?php if (allow(29,1) == 1) {	?>
	<a href="../HelpnDoc/Output/Build pdf documentation/SWMIS User Documents.pdf" target="_blank">User Documents </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php }?>
<?php if (allow(27,1) == 1) {	?>
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../Patient/PatPtOrders.php">PT Pending</a>
<?php }?>
<?php if (allow(27,1) == 1) {	?>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../Home/SurgREOrders.php">Surg Results</a>
<?php }?>
<?php if (allow(27,1) == 1) {	?>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../Home/AnesthesiaREOrders.php">Anesthesia Results</a>
<?php }?>
<?php if (allow(27,1) == 1) {	?>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../Home/RadREOrders.php">Radiology Results</a>
    <?php }?>
<?php if (allow(27,1) == 1) {	?>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../Home/DentalREOrders.php">Dental Results</a>
    <?php }?>
	</td>
  </tr>
</table>

<table align="center">
  <tr>
    <td height="20" bgcolor="#deeafa" class="BlueBold_14" align="center"><a href="index.php?act=spurgeon">Inspiration</a>
<?php if(isset($_GET['act']) and $_GET['act'] == 'spurgeon') {
 ?>	
		 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?act=close">Close</a>
 <?php }?>	</td>
  </tr>
<?php $actapp = "";
   if (isset($_GET['act']) and $_GET['act'] == 'spurgeon') { 
   		$actapp = 'Spurgeon.php';?>
					<?php require_once($actapp); ?>
<?php }?>
</table>

<table width="600px" height="300px" align="center">
  <tr>
  	<td colspan="3" align="center"><img src="cc.jpg" alt="Bethany" width="600" height="240" /></td> <!--IMG_4743c-->
  </tr>
<!--  <tr>
  	<td><img src="IMG_4742c.jpg" alt="Dr Aba" width="200" height="270" /></td>
  	<td><img src="IMG_4734c.jpg" alt="Grace" width="200" height="270" /></td>
  	<td><img src="IMG_4842c.jpg" alt="Luper" width="200" height="270" /></td>
  </tr>
-->
<?php if (allow(29,4) == 1) {	?>
  <tr>
	<td colspan="3" ><?php  echo curPageURL(); ?>     <a href="../../PrintTestButton.php" target="_blank">Print Receipt Test </a> </td>
  </tr>
<?php }?>
</table>
<!-- Inactivate until later
    <td>
		<table>
			<tr>
				<td>id:</td>
				<td>Date:</td>
				<td>By:</td>
				<td>Expires</td>
				<td>Active</td>
			</tr>
  <?php //do { ?>
			<tr>
				<td colspan="5" ><textarea name="editor1" cols="80" rows="2" class="BlackBold_12" id="editor1"><?php //echo $row_ANNOUN['acontent']; ?>
            		</textarea>			  </td>
			</tr>
  <?php //} while ($row_ANNOUN = mysql_fetch_assoc($ANNOUN)); ?>
		</table>    </td>
  </tr>
-->        

<!--<blockquote>&nbsp;</blockquote>-->
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Footer.php'); ?> <!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->

</body>
</html>
<?php
//mysql_free_result($ANNOUN);
ob_end_flush();

?>
