<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']);

 $_SESSION['CurrDateTime'] =  date("Y-m-d H:i:s"); ?>

<?php
if (isset($_SESSION['mrn'])) {
  $colname_mrn = (get_magic_quotes_gpc()) ? $_SESSION['mrn'] : addslashes($_SESSION['mrn']);
	}
if (isset($_SESSION['vid'])) {
  $colname_vid = (get_magic_quotes_gpc()) ? $_SESSION['vid'] : addslashes($_SESSION['vid']);
	}
mysql_select_db($database_swmisconn, $swmisconn);
$query_ordered = "SELECT o.id, o.medrecnum, o.visitid, o.feeid, o.item, o.quant, o.ofee, o.rate, o.doctor, o.status, o.comments, substr(o.urgency,1,1) urg, DATE_FORMAT(o.entrydt,'%d%b%y %H:%i') entrydt, o.entryby, Format(f.fee*(o.rate/100),0) as amtdue, o.amtpaid, f.dept, f.section, f.name, f.descr, f.fee FROM orders o, fee f WHERE o.feeid = f.id and f.dept in ('pharm', 'admin') and o.medrecnum ='". $colname_mrn."' and o.visitid ='". $colname_vid."' ORDER BY entrydt ASC";
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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
   var win_position = ',left=300,top=400,screenX=300,screenY=400';
   var newWindow = window.open(theURL,winName,features+win_position);
   newWindow.focus();
}
//-->
</script>

<script language="JavaScript" src="../../javascript_form/gen_validatorv4.js" type="text/javascript" xml:space="preserve"></script>
</head>

<body>

<table width="90%" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>
      <table width="100%" align="center">
        <tr>
		  <td bgcolor="#DCDCDC"><a href="javascript:void(0)" onclick="MM_openBrWindow('PatPharmOtherAdd.php?mrn=<?php echo $_SESSION['mrn']; ?>&user=<?php echo $_SESSION['user']; ?>','StatusView','scrollbars=yes,resizable=yes,width=800,height=350')">Add</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="MM_openBrWindow('PatPharmOrderAdd.php?mrn=<?php echo $_SESSION['mrn']; ?>&user=<?php echo $_SESSION['user']; ?>','StatusView','scrollbars=yes,resizable=yes,width=800,height=250')">Add 2</a></td>
		<?php // }  else  {?>
		 <!-- <td bgcolor="#DCDCDC">&nbsp;</td>-->
		<?php // }?>
          <td bgcolor="#DCDCDC"><div align="center" class="BlackBold_16">DRUG/Other Orders</div></td>
          <td bgcolor="#DCDCDC"><div align="center"><a href="PatShow1.php?mrn=<?php echo $_SESSION['mrn']; ?>&vid=<?php echo $_SESSION['vid']; ?>&visit=PatVisitView.php">Close</a></div></td>
        </tr>
        <tr>
          <td colspan="3" valign="top" bgcolor="#DCDCDC" class="subtitlebk"><div align="center">
            <table>
                  <tr>
                    <td nowrap="nowrap" class="BlackBold_11">&nbsp;</td>
                    <td nowrap="nowrap" class="BlackBold_11">&nbsp;</td>
                    <td nowrap="nowrap" class="BlackBold_11">#Date/Time</td>
                    <td nowrap="nowrap" class="BlackBold_11">Ord#*</td>
                    <td nowrap="NOWRAP" class="BlackBold_11">Test*</td>
                    <td nowrap="nowrap" class="BlackBold_11">Item*</td>
                    <td nowrap="nowrap" class="BlackBold_11">Quant</td>
                    <td nowrap="nowrap" class="BlackBold_11">Urg</td>
                    <td nowrap="nowrap" class="BlackBold_11">Status</td>
                    <td nowrap="nowrap" class="BlackBold_11">Amt</td>
                    <td nowrap="nowrap" class="BlackBold_11">Done</td>
                  </tr>
              <?php do { ?>
                  <tr>

			  	<?php if (!empty($row_ordered['id']) and ($row_ordered['amtpaid'] == 0 )) {?>
					<td class="BlackBold_11" nowrap="nowrap">					
					<a href="javascript:void(0)" onclick="MM_openBrWindow('PatPharmOtherDelete.php?mrn=<?php echo $_SESSION['mrn']; ?>&user=<?php echo $_SESSION['user']; ?>&ordid=<?php echo $row_ordered['id'] ?>','StatusView','scrollbars=yes,resizable=yes,width=800,height=350')">Del</a></td>

                    <td nowrap="nowrap" class="BlackBold_11">
					<a href="javascript:void(0)" onclick="MM_openBrWindow('PatPharmOtherEdit.php?mrn=<?php echo $_SESSION['mrn']; ?>&user=<?php echo $_SESSION['user']; ?>&ordid=<?php echo $row_ordered['id'] ?>','StatusView','scrollbars=yes,resizable=yes,width=800,height=350')">Edit</a></td>
				<?php } 
				else { ?>
                    <td nowrap="nowrap" class="BlackBold_11">&nbsp;</td>
                    <td nowrap="nowrap" class="BlackBold_11">&nbsp;</td>				
				<?php } ?>
                    <td nowrap="nowrap" class="BlackBold_11" title="VID: <?php echo $row_ordered['visitid']; ?> "><?php echo $row_ordered['entrydt']; ?></td>
                <td nowrap="nowrap" class="BlackBold_11" title="Doctor: <?php echo $row_ordered['doctor']; ?>"><div align="center"><?php echo $row_ordered['id']; ?></div></td>
                <td nowrap="NOWRAP" class="BlackBold_11" title="Dept:<?php echo $row_ordered['dept']; ?>&#10;Section:<?php echo $row_ordered['section']; ?>&#10;Descr:<?php echo $row_ordered['descr']; ?>&#10;Comments:<?php echo $row_ordered['comments']; ?>"><?php echo $row_ordered['name']; ?> <?php echo $row_ordered['fee']; ?></td>
                <td nowrap="NOWRAP" class="BlackBold_11" title="Order Comment: <?php echo $row_ordered['comments']; ?>"><?php echo $row_ordered['item']; ?></td>
                <td nowrap="NOWRAP" class="BlackBold_11" title="Order Comment: <?php echo $row_ordered['comments']; ?>"><?php echo $row_ordered['quant']; ?></td>
                <td nowrap="nowrap" class="BlackBold_11"><?php echo $row_ordered['urg']; ?></td>
                <td nowrap="nowrap" class="BlackBold_11"><?php echo $row_ordered['status']; ?></td>
                <td nowrap="nowrap" class="BlackBold_11"><div align="right"><?php echo $row_ordered['ofee']; ?></div></td>
                <td nowrap="nowrap" class="BlackBold_11"><div align="right"><?php echo $row_ordered['amtpaid']; ?></div></td>
              </tr>
              <?php } while ($row_ordered = mysql_fetch_assoc($ordered)); ?>
            </table>     	  </td>
        </tr>
      </table>
   </td>
  </tr>
</table>
</body>
</html>
