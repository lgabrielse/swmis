<?php  $pt = "Setup Menu"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?> 
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php $_SESSION['CurrDateTime'] = date("Y-m-d  H:i"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>&nbsp;</p>
<p align="center" class="BlueBold_24">ROLE BASED ACCESS CONTROL SECURITY SYSTEM<br />
  sysconn:  
  <?php echo $_SESSION['sysconn'] ?>   sysdata: <?php echo $_SESSION['sysdata'] ?></p>
<table width="50%" align="center">
  <tr>
    <td bgcolor="#FFFFFF" class="BlueBold_14"><a href="UserResetPassword.php"> Reset User Password</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php if (allow(3,1) == 1) { ?>
  <tr>
    <td bgcolor="#FFFFFF" class="BlueBold_14"><a href="UserMenu.php">Users </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php } ?>
<?php if (allow(2,1) == 1) { ?>
 <tr>
    <td bgcolor="#FFFFFF" class="BlueBold_14"><a href="RoleMenu.php">Roles</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php } ?>
<?php if (allow(7,1) == 1) { ?>
  <tr>
    <td bgcolor="#FFFFFF" class="BlueBold_14"><a href="UserRoleMenu.php">User Roles</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php } ?>
<?php if (allow(6,1) == 1) { ?>
  <tr>
    <td bgcolor="#FFFFFF" class="BlueBold_14"><a href="PermitMenu.php">Permits</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php } ?>
<?php if (allow(8,1) == 1) { ?>
  <tr>
    <td bgcolor="#FFFFFF" class="BlueBold_14"><a href="RolePermitMenu.php">Role Permits</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="BlueBold_14"><a href="PermitLinks.php">Permit Links </a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="BlueBold_14"><a href="../medical/home/">New Version - Javascript</a> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
