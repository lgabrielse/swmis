<?php if (session_status() == PHP_SESSION_NONE) {
    session_start(); 
	}?>
	
<?php $colname_mrn = "-1";
if (isset($_SESSION['mrn'])) {
  $colname_mrn = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']);
}
mysql_select_db($database_swmisconn, $swmisconn);
$query_ordered = "SELECT o.id FROM orders o WHERE o.visitid = 0 AND o.medrecnum ='". $colname_mrn."' ORDER BY entrydt ASC";
$ordered = mysql_query($query_ordered, $swmisconn) or die(mysql_error());
$row_ordered = mysql_fetch_assoc($ordered);
$totalRows_ordered = mysql_num_rows($ordered);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
   var win_position = ',left=300,top=400,screenX=300,screenY=400';
   var newWindow = window.open(theURL,winName,features+win_position);
   newWindow.focus();
}
//-->
</script>
</head>

<body>
<table width="50%" align="center">
  <tr>
    <td>
	  <table width="100%" border="0">
       <tr>
        <td nowrap="nowrap" bgcolor="#F5F5F5"><div align="center">Previous Visits:
		
		<?php  if ($_SESSION['visits'] > 0) { ?>
   			<?php if(allow(20,1) == 1) { ?>
				<a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitList.php"><?php echo $_SESSION['visits'] ?></a>&nbsp;
			<?php  } ?>
		<?php  } 
			else {?>
    		 &nbsp; 0 &nbsp;
		<?php  } ?>		</td>
		
		<td nowrap="nowrap">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="subtitlebl">No Open Patient Visit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	<?php if(allow(20,3) == 1) { ?>		</td>
        <td nowrap="nowrap" bgcolor="#BCFACC">&nbsp;<a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&visit=PatVisitAdd.php" class="subtitlebl">Add Visit</a>
	<?php  } ?>			</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td nowrap="nowrap" bgcolor="#eeeeee"><a href="PatHistAll.php?mrn=<?php echo $_SESSION['mrn']; ?>" target="_blank">View History</a></td>
        <td>&nbsp;&nbsp;<?php //echo $_SESSION['visits'] ?> &nbsp;&nbsp;&nbsp;</td>
        <?php if(allow(30,1) == 1 AND $_SESSION['visits'] == 0 and $row_ordered['id'] > 0) { ?>
    <td nowrap="nowrap" bgcolor="#eeeeee"><div align="center">Registration Order<br />
      <a href="javascript:void(0)" onclick="MM_openBrWindow('PatOrdersEditPop.php?mrn=<?php echo $_SESSION['mrn']; ?>','StatusView','scrollbars=yes,resizable=yes,width=600,height=200')">Edit </a>&nbsp;&nbsp;&nbsp;
      <!--<a href="javascript:void(0)" onclick="MM_openBrWindow('PatOrdersDeletePop.php?mrn=<?php echo $_SESSION['mrn']; ?>','StatusView','scrollbars=yes,resizable=yes,width=600,height=200')">Delete </a>-->
    </div></td>
    <?php }?>
       </tr>
    </table></td>
  </tr>
</table>
