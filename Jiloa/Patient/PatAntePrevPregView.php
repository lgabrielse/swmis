<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php
$colname_prevpreg = "-1";
if (isset($_SESSION['mrn'])) {
  $colname_prevpreg = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_prevpreg = sprintf("SELECT id, medrecnum, pregid, numbabies, name, pregdur, DATE_FORMAT(dob,'%%b %%d, %%Y') dob, tob, labour, apgar1, apgar5, birthweight, babystatus, gender, babystatus, ebl_ml, cvx_per, placenta, entryby, entrydt FROM anprevpregs WHERE medrecnum = %s order by dob", $colname_prevpreg);
$prevpreg = mysql_query($query_prevpreg, $swmisconn) or die(mysql_error());
$row_prevpreg = mysql_fetch_assoc($prevpreg);
$totalRows_prevpreg = mysql_num_rows($prevpreg);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php if($totalRows_prevpreg > 0){?>    
<table width="80%">
  <tr>
    <td>
	<table width="100%">
	  <tr bgcolor="#E8F0F4">
	    <td colspan="5" nowrap="nowrap" title="Do Not use this to make a current pregnancy&#10; record into a previous pregnancy record. &#10;  Use Pregnancy Outcome link in the current&#10; record to make the current one a previous pregnancy."><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePrevPregAdd.php">Add pregnancy that is not in computer. </a></td>
	    <td nowrap="nowrap" class="BlackBold_16"><div align="right">Previous</div></td>
	    <td nowrap="NOWRAP" class="BlackBold_16">Pregnancies</td>
	    <td nowrap="nowrap" class="Black_14">&nbsp;</td>
	    <td nowrap="nowrap" class="Black_14">&nbsp;</td>
	    <td><div align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePregView.php">Close</a></div></td>
	    </tr>
	  <tr bgcolor="#E8F0F4">
	    <td nowrap="nowrap" class="Black_14">&nbsp;</td>
		<td nowrap="nowrap" class="Black_14"><div align="center">MRN</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Preg<br />Rec</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Number of<br />babies</div></td>

		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Baby's<br />
		  Name:</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Preg<br />Duration</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">DOB</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">TOB</div></td>
		<td nowrap="NOWRAP" class="Black_14"><div align="center">Labour</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">APGAR<br />1</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">APGAR<br />5</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Birth<br />Weight</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Gen<br />der</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Baby<br />Status</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center" class="BlackBold_11">Blood<br />loss ml</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Cervix<br />peritinium</div></td>
		<td nowrap="nowrap" class="Black_14"><div align="center">Placenta</div></td>
	  </tr>

<?php do { ?>
	  <tr>
	    <td bgcolor="#E8F0F4"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePrevPregEdit.php&prevpregid=<?php echo $row_prevpreg['id']; ?>">Edit</a><br />
		<a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePrevPregDelete.php&prevpregid=<?php echo $row_prevpreg['id']; ?>">Delete</a></td>
		<td bgcolor="#E8F0F4"><?php echo $row_prevpreg['medrecnum']; ?></td>
	    <td bgcolor="#E8F0F4"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePregView.php&pregid=<?php echo $row_prevpreg['pregid']; ?>"><?php echo $row_prevpreg['pregid']; ?></a></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['numbabies']; ?></td>
		<td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_prevpreg['name']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['pregdur']; ?></td>
		<td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_prevpreg['dob']; ?></td>
		<td nowrap="nowrap" bgcolor="#FFFFFF"><?php echo $row_prevpreg['tob']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['labour']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['apgar1']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['apgar5']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['birthweight']; ?>kg</td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['gender']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['babystatus']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['ebl_ml']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['cvx_per']; ?></td>
		<td bgcolor="#FFFFFF"><?php echo $row_prevpreg['placenta']; ?></td>
	  </tr>
    <?php } while ($row_prevpreg = mysql_fetch_assoc($prevpreg)); ?>
	</table>	</td>
  </tr>
  <tr>
  	<td><div align="center">Use 'History' to view details of previous pregnancies</div></td>
  </tr>
</table>
<?php  } else {?>
 
 <div class="RedBold_24">
   <div align="center" title="Do Not use this to make a current pregnancy&#10; record into a previous pregnancy record. &#10;  Use Pregnancy Outcome link in the current&#10; record to make the current one a previous pregnancy.">No Previous Pregnancies    <a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitView.php&act=ante&pge=PatAntePrevPregAdd.php">Add</a></div>
 </div>
<?php }?>
</body>
</html>
<?php
mysql_free_result($prevpreg);
?>
