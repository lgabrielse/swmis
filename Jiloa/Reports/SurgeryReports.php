<?php require_once('../../Connections/swmisconn.php'); ?>
<?php $pt = "Surgery Reports"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?>
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
if(!isset($_GET['gender'])) 
   {$gender = '%';
	} else {$gender = $_GET['gender'];}
	
if(!isset($_GET['section'])) 
   {$section = '%';
	} else {$section = $_GET['section'];}

if(!isset($_GET['minage'])) 
   {$minage = '0';
	} else {$minage = $_GET['minage'];}

if(!isset($_GET['maxage'])) 
   {$maxage = '99';
	} else {$maxage = $_GET['maxage'];}

if(!isset($_GET['sort'])) 
   {$sort = 'entrydt';
	} else {$sort = $_GET['sort'];}


if(isset($_GET['scheddt_0'])) {
// get timestamp for posted variable - this takes unformattted input and creates a timestamp number
	$datebs = strtotime($_GET['scheddt_0']);
	$datees = strtotime($_GET['scheddt_1']);
// put date in format for mysql and for display
	$date1 = date("Y-m-d", $datebs);
	$date2 = date("Y-m-d", $datees);
	//$nbc = $_POST['nbc'];
}
else {
	$date2 = date ( 'Y-m-d');
	$date1 = strtotime ( '-1 month' , strtotime ( $date2 ) ) ;
   $date1 = date ( 'Y-m-d' , $date1 );
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_Recordset1 = "SELECT DATE_FORMAT(o.entrydt, '%Y-%m-%d') as entrydt, o.feeid, f.name, p.gender, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,p.dob)),'%y') AS age, p.dob, o.amtpaid, o.medrecnum  FROM orders o join patperm p on o.medrecnum = p.medrecnum join fee f on o.feeid = f.id where f.dept = 'surgery' and f.section like '" .$section. "'
 and p.gender like '" .$gender. "' and DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,p.dob)),'%y') > '".$minage."' and DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,p.dob)),'%y') <= '".$maxage."' and o.entrydt BETWEEN '". $date1 . "' AND '" . $date2 ."' order by ". $sort .""; 
 
$Recordset1 = mysql_query($query_Recordset1, $swmisconn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_swmisconn, $swmisconn);
$query_Section = "SELECT distinct `section` FROM `fee` WHERE Dept = 'Surgery' order by section ASC";
$Section = mysql_query($query_Section, $swmisconn) or die(mysql_error());
$row_Section = mysql_fetch_assoc($Section);
$totalRows_Section = mysql_num_rows($Section);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transaction Report</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>
<body>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		          <a href="ReportsMenu.php"><span class="navLink">Menu</span> </a>	                                            	        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>

<table width="40%" border="1" cellpadding="2" cellspacing="2" align="center">
  <tr>
    <td>
       <form id="form1" namew="form1" action="" method="get">
       <table cellpadding="2" cellspacing="2">
		  <tr>
		    <td>Begin</td> <!-- Go to 'http://www.nogray.com/api/calendar.php' for parameters -->

          <td><input name="scheddt_0" type="text" class="BlackBold_12" id="scheddt_0" size="12" maxlength="15" value="<?php echo $date1 ?>"/></td>
         
          <td nowrap="nowrap" align="right">End</td>

		    <td><input name="scheddt_1" type="text" class="BlackBold_12" id="scheddt_1" size="12" maxlength="15" value="<?php echo $date2 ?>"/></td>
		    <td>Section</td>
          <td><select name="section" id="section">
            <option value="%" <?php if (!(strcmp("%", $row_Section['section']))) {echo "selected=\"selected\"";} ?>>All</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Section['section']?>"<?php if (!(strcmp($section, $row_Section['section']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Section['section']?></option>
            <?php
} while ($row_Section = mysql_fetch_assoc($Section));
  $rows = mysql_num_rows($Section);
  if($rows > 0) {
      mysql_data_seek($Section, 0);
	  $row_Section = mysql_fetch_assoc($Section);
  }
?>
          </select>          </td>
		    <td>Gender</td>
		    <td><label for="gender"></label>
		      <select name="gender" id="gender">
		        <option value="%" <?php if (!(strcmp("%", $gender))) {echo "selected=\"selected\"";} ?>>All</option>
		        <option value="F" <?php if (!(strcmp("F", $gender))) {echo "selected=\"selected\"";} ?>>F</option>
		        <option value="M" <?php if (!(strcmp("M", $gender))) {echo "selected=\"selected\"";} ?>>M</option>
	         </select></td>
		    <td>Age</td>
		    <td><label for="minage"></label>
		      <input name="minage" type="text" id="minage" size="5" maxlength="2" value="<?php echo $minage ?>"/></td>
		    <td><label for="maxage"></label>
		      <input name="maxage" type="text" id="maxage" size="5" maxlength="2" value="<?php echo $maxage ?>"/></td>
		    <td nowrap="nowrap">Sort by</td>
		    <td><label for="sort"></label>
		      <select name="sort" id="sort">
		        <option value="o.entrydt" <?php if (!(strcmp("o.entrydt", "$sort"))) {echo "selected=\"selected\"";} ?>>Order Date</option>
		        <option value="f.name" <?php if (!(strcmp("f.name", "$sort"))) {echo "selected=\"selected\"";} ?>>Procedure</option>
		        <option value="p.dob DESC" <?php if (!(strcmp("p.dob DESC", "$sort"))) {echo "selected=\"selected\"";} ?>>Age</option>
<option value="o.medrecnum" <?php if (!(strcmp("o.medrecnum", "$sort"))) {echo "selected=\"selected\"";} ?>>MedRecNum</option>
	         </select></td>
		    <td><input type="submit" name="GO" id="GO" value="GO" /></td>
		  </tr>
   </table>

       
       
       </form>
    </td>
  </tr>
</table>


<!--*****************************************************Data**********************************************-->
<div align="center">Begin: <?php echo  $date1 ?>    End: <?php echo  $date2 ?> Section:  <?php echo  $section ?> Gender: <?php echo  $gender ?>   MinAge: <?php echo  $minage ?> MaxAge: <?php echo  $maxage ?>  Sort: <?php echo  $sort ?></dev>
  <p>&nbsp;</p>
<table border="1" cellpadding="1" cellspacing="1" align="center">
    <tr>
    	<td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">#</div></td>
      <td bgcolor="#CCFFFF"><div align="center">entrydt</div></td>
      <td bgcolor="#CCFFFF"><div align="center">feeid</div></td>
      <td bgcolor="#CCFFFF"><div align="center">name</div></td>
      <td bgcolor="#CCFFFF"><div align="center">gender</div></td>
      <td bgcolor="#CCFFFF"><div align="center">age</div></td>
      <td bgcolor="#CCFFFF"><div align="center">dob</div></td>
      <td bgcolor="#CCFFFF"><div align="center">amtpaid</div></td>
      <td bgcolor="#CCFFFF"><div align="center">medrecnum</div></td>
  </tr>
    <?php   $i = 0; ?>
    <?php do { 
  			$i = $i + 1;  ?>

      <tr>
        <td bgcolor="#FFFFFF"><?php echo $i; ?></td>
        <td bgcolor="#FFFFFF"><?php echo $row_Recordset1['entrydt']; ?></td>
        <td bgcolor="#FFFFFF"><?php echo $row_Recordset1['feeid']; ?></td>
        <td bgcolor="#FFFFFF"><?php echo $row_Recordset1['name']; ?></td>
        <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_Recordset1['gender']; ?></div></td>
        <td bgcolor="#FFFFFF"><?php echo $row_Recordset1['age']; ?></td>
        <td bgcolor="#FFFFFF"><?php echo $row_Recordset1['dob']; ?></td>
        <td bgcolor="#FFFFFF"><div align="right"><?php echo $row_Recordset1['amtpaid']; ?></div></td>
        <td bgcolor="#FFFFFF"><div align="center"><?php echo $row_Recordset1['medrecnum']; ?></div></td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </table>
  
<script type="text/javascript" src="../../nogray_js/1.2.2/ng_all.js"></script>
<script type="text/javascript" src="../../nogray_js/1.2.2/components/calendar.js"></script>
<script type="text/javascript" src="../../nogray_js/1.2.2/components/timepicker.js"></script>
<script type="text/javascript">
ng.ready( function() {

	    var my_cal = new ng.Calendar({
        input:'scheddt_0',
		  start_date: '01-01-2014',
		  display_date: new Date()   // the display date (default is start_date)
    });
  
	    var my_cal = new ng.Calendar({
        input:'scheddt_1',
		  start_date: '01-01-2014',
		  display_date: new Date()   // the display date (default is start_date)
    });
});

</script>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
