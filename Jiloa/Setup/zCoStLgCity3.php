<?php require_once('../../Connections/costlgci.php'); ?>
<?php session_start()?>
<?php //session_destroy();?>
<?php

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
	if(!isset($_SESSION['countryid']))  {$_SESSION['countryid'] = '0';}
	if(!isset($_SESSION['stateid']))    {$_SESSION['stateid'] = '0';}
	if(!isset($_SESSION['locgovtid']))  {$_SESSION['locgovtid'] = '0';}
	if(!isset($_SESSION['cityid']))     {$_SESSION['cityid'] = '0';}

//If Add Countrry is clicked	
if (isset($_POST['MM_update']) AND $_POST['MM_update'] == 'form2') {
//echo $_POST['MM_update'].$_POST['country'];	
$insertSQL = sprintf("INSERT INTO country (country) VALUES (%s)", GetSQLValueString($_POST['country2'], "text"));
mysql_select_db($database_costlgci, $costlgci);
$Result1 = mysql_query($insertSQL, $costlgci) or die(mysql_error());
}

//If Add State is clicked
if (isset($_POST['MM_update']) AND $_POST['MM_update'] == 'form3') {
//echo $_POST['MM_update'].'   '.$_POST['state'];
$insertSQL = sprintf("INSERT INTO state (countryid, state) VALUES (%s, %s)", GetSQLValueString($_SESSION['countryid'], "int"), GetSQLValueString($_POST['state2'], "text"));
mysql_select_db($database_costlgci, $costlgci);
$Result1 = mysql_query($insertSQL, $costlgci) or die(mysql_error());
}

//If Add Locgovt is clicked
if (isset($_POST['MM_update']) AND $_POST['MM_update'] == 'form4') {
echo $_POST['MM_update'].'   '.$_POST['locgovt2'];
$insertSQL = sprintf("INSERT INTO locgovt (stateid, locgovt) VALUES (%s, %s)", GetSQLValueString($_SESSION['stateid'], "int"), GetSQLValueString($_POST['locgovt2'], "text"));
mysql_select_db($database_costlgci, $costlgci);
$Result1 = mysql_query($insertSQL, $costlgci) or die(mysql_error());
}

//If Add City is clicked	
if (isset($_POST['MM_update']) AND $_POST['MM_update'] == 'form5') {
echo $_POST['MM_update'].'   '.$_POST['city2'];
$insertSQL = sprintf("INSERT INTO city (locgovtid, city) VALUES (%s, %s)", GetSQLValueString($_SESSION['locgovtid'], "int"), GetSQLValueString($_POST['city2'], "text"));
mysql_select_db($database_costlgci, $costlgci);
$Result1 = mysql_query($insertSQL, $costlgci) or die(mysql_error());
}
	
	
//List of countries for Drop down list
mysql_select_db($database_costlgci, $costlgci);
$query_countries = "SELECT id, country FROM country Order By country";
$countries = mysql_query($query_countries, $costlgci) or die(mysql_error());
$row_countries = mysql_fetch_assoc($countries);
$totalRows_countries = mysql_num_rows($countries);

//List of States for Drop down list
if (isset($_POST['country'])) {
	$_SESSION['countryid'] = (get_magic_quotes_gpc()) ? $_POST['country'] : addslashes($_POST['country']);
}  
$MM_states = $_SESSION['countryid'];
mysql_select_db($database_costlgci, $costlgci);
$query_states = sprintf("SELECT id, countryid, state FROM state WHERE countryid = %s ORDER BY state", $MM_states);
$states = mysql_query($query_states, $costlgci) or die(mysql_error());
$row_states = mysql_fetch_assoc($states);
$totalRows_states = mysql_num_rows($states);

//List of Local Govts for Drop down list

if (isset($_POST['state'])) {
	$_SESSION['stateid'] = (get_magic_quotes_gpc()) ? $_POST['state'] : addslashes($_POST['state']);
}
if($_SESSION['countryid'] == '0') {
	$_SESSION['stateid'] = '0';
}
$MM_locgovts = $_SESSION['stateid'];
mysql_select_db($database_costlgci, $costlgci);
$query_locgovts = sprintf("SELECT id, locgovt, stateid FROM locgovt WHERE stateid = %s ORDER BY locgovt", $MM_locgovts);
$locgovts = mysql_query($query_locgovts, $costlgci) or die(mysql_error());
$row_locgovts = mysql_fetch_assoc($locgovts);
$totalRows_locgovts = mysql_num_rows($locgovts);

//List of Cities for Drop down list

if (isset($_POST['locgovt'])) {
	$_SESSION['locgovtid'] = (get_magic_quotes_gpc()) ? $_POST['locgovt'] : addslashes($_POST['locgovt']);
}
if($_SESSION['stateid'] == '0') {
	$_SESSION['locgovtid'] = '0';
}
$MM_cities = $_SESSION['locgovtid'];
mysql_select_db($database_costlgci, $costlgci);
$query_cities = sprintf("SELECT id, locgovtid, city FROM city WHERE locgovtid = %s ORDER BY city", $MM_cities);
$cities = mysql_query($query_cities, $costlgci) or die(mysql_error());
$row_cities = mysql_fetch_assoc($cities);
$totalRows_cities = mysql_num_rows($cities);

if (isset($_POST['city'])) {
	$_SESSION['cityid'] = (get_magic_quotes_gpc()) ? $_POST['city'] : addslashes($_POST['city']);
}
if($_SESSION['locgovtid'] == '0') {
	$_SESSION['cityid'] = '0';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Country-City</title>
<link href="../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>
<body>

<table width="30%" border="0">
      <form id="form1" name="form1" method="post" action="">
		<?php $showid = 'true';
		if($showid == 'true') {?> 
       <tr>
          <td nowrap="nowrap"><?php if(isset($_SESSION['countryid']))  {?>
          <?php echo $_SESSION['countryid']; } ?></td>
          <td nowrap="nowrap"><?php if(isset($_SESSION['stateid']))  {?>
          <?php echo $_SESSION['stateid']; }?></td>
          <td nowrap="nowrap"><?php if(isset($_SESSION['locgovtid']))  {?>
           <?php echo $_SESSION['locgovtid']; }?></td>
          <td nowrap="nowrap"><?php if(isset($_SESSION['cityid']))  {?>
          <?php echo $_SESSION['cityid'] ; }?></td>
        </tr>
		<?php }?>
        <tr>
          <td colspan="4">Click Country Select to reset </td>
        </tr>
        <tr>
          <td colspan="2" nowrap="nowrap">Country</td>
          <td colspan="2"><select name="country" id="country" onchange="document.form1.submit();">
              <option value="0" <?php if (!(strcmp("", $_SESSION['countryid']))) {echo "selected=\"selected\"";} ?>>Select</option>
              <?php
do {  
?>
            <option value="<?php echo $row_countries['id']?>"<?php if (!(strcmp($row_countries['id'], $_SESSION['countryid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_countries['country']?></option>
              <?php
} while ($row_countries = mysql_fetch_assoc($countries));
  $rows = mysql_num_rows($countries);
  if($rows > 0) {
      mysql_data_seek($countries, 0);
	  $row_countries = mysql_fetch_assoc($countries);
  }
?>
            </select>          </td>
        </tr>
        <tr>
          <td colspan="2" nowrap="nowrap">State</td>
          <td colspan="2"><select name="state" id="state" onchange="document.form1.submit();">
              <option value="0" <?php if (!(strcmp("", $_SESSION['stateid']))) {echo "selected=\"selected\"";} ?>>Select</option>
              <?php
		do {  
		?>
            <option value="<?php echo $row_states['id']?>"<?php if (!(strcmp($row_states['id'], $_SESSION['stateid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_states['state']?></option>
              <?php
} while ($row_states = mysql_fetch_assoc($states));
  $rows = mysql_num_rows($states);
  if($rows > 0) {
      mysql_data_seek($states, 0);
	  $row_states = mysql_fetch_assoc($states);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td colspan="2" nowrap="nowrap">Local Govt </td>
          <td colspan="2"><select name="locgovt" id="locgovt" onchange="document.form1.submit();">
              <option value="0" <?php if (!(strcmp("", $_SESSION['locgovtid']))) {echo "selected=\"selected\"";} ?>>Select</option>
              <?php
do {  
?>
            <option value="<?php echo $row_locgovts['id']?>"<?php if (!(strcmp($row_locgovts['id'], $_SESSION['locgovtid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_locgovts['locgovt']?></option>
              <?php
} while ($row_locgovts = mysql_fetch_assoc($locgovts));
  $rows = mysql_num_rows($locgovts);
  if($rows > 0) {
      mysql_data_seek($locgovts, 0);
	  $row_locgovts = mysql_fetch_assoc($locgovts);
  }
?>
          </select></td>
        </tr>
        <tr>
          <td colspan="2" nowrap="nowrap">City</td>
          <td colspan="2"><select name="city" id="city" onchange="document.form1.submit();">
              <option value="0" <?php if (!(strcmp("", $_SESSION['cityid']))) {echo "selected=\"selected\"";} ?>>Select</option>
              <?php
do {  
?>
            <option value="<?php echo $row_cities['id']?>"<?php if (!(strcmp($row_cities['id'], $_SESSION['cityid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_cities['city']?></option>
              <?php
} while ($row_cities = mysql_fetch_assoc($cities));
  $rows = mysql_num_rows($cities);
  if($rows > 0) {
      mysql_data_seek($cities, 0);
	  $row_cities = mysql_fetch_assoc($cities);
  }
?>
          </select></td>
		</tr>
      </form>
     <?php if ($_SESSION['countryid']=='0') {?>
	   <tr>
        <form id="form2" name="form2" method="post" action="CoStLgCity3.php">
          <td colspan="2" nowrap="nowrap">New Country</td>
          <td colspan="2" nowrap="nowrap">
		  	<input type="text" name="country2" id="country2" />
			<input type="hidden" name="MM_update" value="form2" />
            <input type="submit" name="button2" id="button2" value="Add" /></td>
        </form>
	   </tr>
     <?php } ?>
	   
     <?php if ($_SESSION['countryid'] != '0' AND $_SESSION['stateid'] == '0') {?>
	   <tr>
        <form id="form3" name="form3" method="post" action="CoStLgCity3.php">
          <td colspan="2" nowrap="nowrap">New State</td>
          <td colspan="2" nowrap="nowrap">
		    <input type="text" name="state2" id="state2" />
		    <input type="hidden" name="MM_update" value="form3" />
            <input type="submit" name="button3" id="button3" value="Add" /></td>
        </form>
	   </tr>
     <?php } ?>
     <?php if ($_SESSION['countryid'] != '0' AND $_SESSION['stateid'] != '0' AND $_SESSION['locgovtid'] == '0') {?>
       <tr>
        <form id="form4" name="form4" method="post" action="CoStLgCity3.php">
          <td colspan="2">Add Loc Govt</td>
          <td colspan="2" nowrap="nowrap">
		  	<input type="text" name="locgovt2" id="locgovt2" />
			<input type="hidden" name="MM_update" value="form4" />
            <input type="submit" name="button4" id="button4" value="Add" /></td>
        </form>
       </tr>
     <?php } ?>
     <?php if ($_SESSION['countryid'] != '0' AND $_SESSION['stateid'] != '0' AND $_SESSION['locgovtid'] != '0' AND $_SESSION['cityid'] == '0') {?>
      <tr>
        <form id="form5" name="form5" method="post" action="CoStLgCity3.php">
          <td colspan="2">Add City</td>
          <td colspan="2" nowrap="nowrap">
		  	<input type="text" name="city2" id="city2" />
			<input type="hidden" name="MM_update" value="form5" />
            <input type="submit" name="button5" id="button5" value="Add" /></td>
        </form>
      </tr>
     <?php }?>
</table>
<p><a href="SetUpMenu.php">SetupMenu</a></p>
</body>
</html>
<?php
mysql_free_result($states);

mysql_free_result($locgovts);

mysql_free_result($cities);
?>
