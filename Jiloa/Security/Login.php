<?php
error_reporting(E_ALL);
 session_start(); 
	 //redirect to Stop page if session varables are already set
	if (isset($_SESSION['user']) OR isset($_SESSION['sysdata']) OR isset($_SESSION['sysconn'])) {
			  $LoginGoTo = "stop.php"; 
			  header(sprintf("Location: %s", $LoginGoTo));	
	}
?>
<?php $maint = 'TEST';  //use 'ON', 'TEST' or 'OFF':  Allows ADMIN to prevent system use?>
<?php  // get URL address to display Connection
function curPageURL() {
$isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
$port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
$port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
$url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
return $url;
}
?>

<?php
// Userid, password, and sysdata from Form
$colname_loguser = "-1";
$colname2_loguser = "-1";
$colname3_loguser = "-1";
define("SALT","swmis");   //comment to disable encryption
$myerror = "";
if (isset($_POST['userid']) && isset($_POST['password']) && isset($_POST['sysdata'])) {
	if(empty($_POST["userid"]) || empty($_POST["password"]))
	{
		$myerror = "Either user id or password is wrong";
	}
  $colname_loguser = (get_magic_quotes_gpc()) ? $_POST['userid'] : addslashes($_POST['userid']);
  $colname2_loguser = (get_magic_quotes_gpc()) ? $_POST['password'] : addslashes($_POST['password']);
  $colname3_loguser = (get_magic_quotes_gpc()) ? $_POST['sysdata'] : addslashes($_POST['sysdata']);
$encrypt_pass = crypt($colname2_loguser,SALT);  //comment to disable encryption

//echo $encrypt_pass;  // g  swfpR7sQ8re4M   easter swbUiLeeyGbew
//exit;
?>

<?php 
       $_SESSION['user'] = "";   // initialize user
	   $_SESSION['sysdata'] = "";  // initialize display system database
       $_SESSION['sysconn'] = "";  // initialize database connection
       $_SESSION['sysdata'] = $colname3_loguser;   // to display database name 
?>
<?php
	if ($colname3_loguser == 'BETHANY'){
		require_once($_SERVER['DOCUMENT_ROOT'].'/Len/Connections/bethanyconn.php');
		$_SESSION['sysconn'] = '/Len/Connections/bethanyconn.php'; 
	}
	if ($colname3_loguser == 'TRAINING'){
		require_once($_SERVER['DOCUMENT_ROOT'].'/Len/Connections/trainingconn.php');
		$_SESSION['sysconn'] = '/Len/Connections/trainingconn.php'; 
	}
		if ($colname3_loguser == 'SWMIS'){
		require_once($_SERVER['DOCUMENT_ROOT'].'/Len/Connections/swmisconn.php');
		$_SESSION['sysconn'] = '/Len/Connections/swmisconn.php'; 
	}

//query users datatable for userid and password
//coment the below code to disable password encryption
mysql_select_db($database_swmisconn, $swmisconn);
$query_loguser = sprintf("SELECT id, login, userid, lastname, firstname, password FROM users WHERE Active = 'Y' AND login = '%s' and password = '$encrypt_pass'", $colname_loguser, $colname2_loguser);
 //uncomment the code below for non encrypted password
//$query_loguser = sprintf("SELECT id, login, userid, lastname, firstname, password FROM users WHERE Active = 'Y' AND login = '%s' and password = '%s'", $colname_loguser,$colname2_loguser);
$loguser = mysql_query($query_loguser, $swmisconn) or die(mysql_error());
$row_loguser = mysql_fetch_assoc($loguser);
if(isset($row_loguser) && empty($row_loguser))
{
	$myerror = "Either user id or password is wrong";
}
$totalRows_loguser = mysql_num_rows($loguser);
// query role_permit and user_role tables for list of user permissions
mysql_select_db($database_swmisconn, $swmisconn);
$query_permit = sprintf("Select permitid, level from role_permit where roleid in (Select roleid from user_role where userid = '%s')", $row_loguser['id']);
$permit = mysql_query($query_permit, $swmisconn) or die(mysql_error());
$row_permit = mysql_fetch_assoc($permit);
$totalRows_permit = mysql_num_rows($permit);
?>
<!--/ set user session-->
<?php $_SESSION['user'] = $row_loguser['userid']; ?>
	
<!--/ set swmis session-->
<?php $sessionStr = " " ;  // space is deliberate to make function work
	if ($totalRows_loguser > 0) {
//	$sessionStr = "user:" . $row_loguser['userid'] . ", ";  // removed
	 do {
		$sessionStr = $sessionStr . $row_permit['level'] . ":" . $row_permit['permitid'] . ", ";
        } while ($row_permit = mysql_fetch_assoc($permit));
		$_SESSION['swmis'] = $sessionStr;
}
?>
<?php 
$uid_menu = "0";
if (isset($row_loguser['id'])) {
  $uid_menu = (get_magic_quotes_gpc()) ? $row_loguser['id'] : addslashes($row_loguser['id']);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_menu = sprintf("SELECT distinct main, sub1, sub2, sub3 FROM permits WHERE id in (Select permitid from role_permit where roleid in (Select roleid from user_role where userid = %s))", $uid_menu);
$menu = mysql_query($query_menu, $swmisconn) or die(mysql_error());
$row_menu = mysql_fetch_assoc($menu);
$totalRows_menu = mysql_num_rows($menu);
?>


<!-- set menu session-->
<?php
		$_SESSION['menuA'] = '';
		$_SESSION['menu1'] = '';
		$_SESSION['menu2'] = '';
		$_SESSION['menu3'] = '';
	  $sessionStr = "";
	  $sessionStrA = "" ;
      $sessionStr1 = "" ;
      $sessionStr2 = "" ;
      $sessionStr3 = "" ;
	if ($totalRows_menu > 0) {
	 do {
		$sessionStrA = $sessionStrA . ":" .  $row_menu['main'] . ", ";
		if (isset($row_menu['sub1'])) {$sessionStr1 = $sessionStr1 . ":" .  $row_menu['main'] . $row_menu['sub1'] . ", "; } 
		if (isset($row_menu['sub2'])) {$sessionStr2 = $sessionStr2 . ":" .  $row_menu['main'] . $row_menu['sub1'] . $row_menu['sub2'] . ", ";}
		if (isset($row_menu['sub3'])) {$sessionStr3 = $sessionStr3 . ":" .  $row_menu['main'] . $row_menu['sub1'] . $row_menu['sub2'] . $row_menu['sub3'] . ", "; }
        } while ($row_menu = mysql_fetch_assoc($menu));
		$_SESSION['menuA'] = $sessionStrA;
		$_SESSION['menu1'] = $sessionStr1;
		$_SESSION['menu2'] = $sessionStr2;
		$_SESSION['menu3'] = $sessionStr3;
}
?>

<?php echo $row_menu['main']; ?>
<?php // redirect to Home/Index page if user was found
if (isset($_SESSION['user']) ) {
	// print_r($_SESSION); die;
	$mysessioncookie = json_encode($_SESSION);
	setcookie("mySession",$mysessioncookie,0,"/");
    //$LoginGoTo = "../Home/index.php"; 
	//header(sprintf("Location: %s", $LoginGoTo));
// echo '<meta http-equiv="refresh" content="0; URL=../Home/index.php">';
header("location:../Home/index.php");
//echo '<meta http-equiv="Location" content="../Home/index.php">';	 
?>
<?php
    exit;
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LOGIN</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.style1 {font-size: 36px; height:40px; font-weight:bold}
</style> 
</head>

<body onLoad="document.forms.form1.userid.focus()">
<!--http://www.wrensoft.com/forum/showthread.php?42-Input-field-active-setting-the-focus-on-page-load -->
	<div>&nbsp;</div>
	<div align="center" class="style1">Softwise Medical Information System</div>
	<div align="center" class="style1">Bethany Hospital - Gboko, Nigeria</div>
<?php if($maint == 'ON'){ ?>
	<table width="600" border="1" align="center" bgcolor="#B1D5F8" class="promo">
		<tr>
			<td class="RedBold_36"><div align="center">System Off for Maintenance</div></td>
		</tr>
	</table>
<?php }	else {  //login enabled  ?>

<?php if($maint == 'TEST'){ ?>
	<table width="600" border="1" align="center" bgcolor="#B1D5F8" class="promo">
		<tr>
			<td class="RedBold_36"><div align="center">System on for testing only!</div></td>
		</tr>
	</table>
<?php } ?>
	<table width="300" border="1" align="center" bgcolor="#B1D5F8" class="promo">
     <form name="form1" action="Login.php" method="post">
	  <tr>
		<td nowrap="nowrap" scope="col"><strong>PLEASE LOGIN
		</strong></td>
		<td>
			<table width="300" border="1">
			  <tr>
			    <td scope="col"><strong>SYSTEM</strong></td>
			    <td scope="col"><select name="sysdata" id="sysdata">
			      <option value="BETHANY" selected="selected">BETHANY</option>
			      <option value="SWMIS">SWMIS</option>
			      <option value="TRAINING">TRAINING</option>
			      </select>
			    </td>
		      </tr>
			  <tr>
				<td scope="col"><strong>USER ID</strong></td>
				<td scope="col">
				  <input type="text" name="userid" autocomplete="off" /></td>
			  </tr>
			  <tr>
				<td><strong>PASSWORD</strong></td>
				<td><input type="password" name="password" autocomplete="off" /></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="Submit" value="LOGIN" /></td>
			  </tr>
		<?php if(!empty($myerror)) {  session_destroy(); ?>
			  <tr>
				<td colspan="2"><span style="color:#f00; font-size:16px"><?=$myerror;?></span></td>
			  </tr>
		<?php } ?>
			  <tr>
				<td colspan="2" nowrap="nowrap" title="<?php  echo curPageURL(); ?>">
<?php	$myUrl= curPageURL();
		
		switch ($myUrl)
		{
		case "http://localhost/Len/Jiloa/Security/Login.php":
		  echo "Server = Current Computer";
		  break;
		case "http://www.swmis.org/Len/Jiloa/Security/Login.php":
		  echo "Server = Len@Home-BethanyServer on SWMIS domain";
		  break;
		case "http://swmis.org/Len/Jiloa/Security/Login.php":
		  echo "Server = Len@Home-BethanyServer on SWMIS domain";
		  break;
		case "http://bethanyserver/Len/Jiloa/Security/Login.php":
		  echo "Server = Len@Home-BethanyServer on Home Network";
		  break;
		case "http://www.jiloa.org/Len/Jiloa/Security/Login.php":
		  echo "Server = GODaddy Server on JILOA domain";
		  break;
		default:
		  echo "Source Server Not Identified";
}
?>				</td>
			  </tr>
			</table>
		</td>
 	  </tr>
	 </form>
</table>
<?php }  // else login enabled ?>
</body>
</html>
<?php
if (isset($_POST['userid']) && isset($_POST['password'])) {

mysql_free_result($loguser);

mysql_free_result($permit);

mysql_free_result($menu);
}
?>
