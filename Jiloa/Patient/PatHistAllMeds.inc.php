<!--Begin ORDERS - ORDERS - ORDERS - ORDERS - ORDERS - ORDERS - ORDERS - ORDERS - ORDERS - ORDERS - ORDERS - ORDERS - -->
<?php 
//echo 'MEDS: '.$visitid;
mysql_select_db($database_swmisconn, $swmisconn);
$query_ordered = "SELECT o.id, o.visitid, o.item, o.nunits, o.unit, o.every, o.evperiod, o.fornum, o.forperiod, o.doctor, o.status, o.comments, substr(o.urgency,1,1) urg, DATE_FORMAT(o.entrydt,'%d%b%y %H:%i') entrydt, o.entryby, o.amtpaid FROM orders o WHERE o.visitid ='".$visitid."' and feeid = '30' ORDER BY o.id ASC";  //".$visitid."
$ordered = mysql_query($query_ordered, $swmisconn) or die(mysql_error());
$row_ordered = mysql_fetch_assoc($ordered);
$totalRows_ordered = mysql_num_rows($ordered);


/*mysql_select_db($database_swmisconn, $swmisconn);
$query_orders = "Select o.id ordid, DATE_FORMAT(o.entrydt,'%d-%b-%Y %H:%i') entrydt, o.status, o.urgency, o.doctor, o.entryby, o.comments, f.name, f.dept from orders o join fee f on o.feeid = f.id where f.dept in ('Physiotherapy', 'Radiology', 'Surgery') and visitid = '".$visitid."'";
$orders = mysql_query($query_orders, $swmisconn) or die(mysql_error());
$row_orders = mysql_fetch_assoc($orders);
$totalRows_orders = mysql_num_rows($orders);
*/
?>
<?php if($totalRows_ordered > 0) { ?>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css">
<table>
	<tr>
		<td nowrap bgcolor="#c2f4bd"><span class="subtitlegr">MEDS </span> ordered</td>	
		<td bgcolor="#c2f4bd">Status</td>	
		<td bgcolor="#c2f4bd">Doctor</td>	
		<td bgcolor="#c2f4bd">Medication</td>	
		<td bgcolor="#c2f4bd">Prescription</td>	
    </tr> 
       <?php do { //check to se if it is scheduled
		    $bkds="btngradgrn";
			//$bkds="btngradblu100";
			$bkgd="#F5F5F5";
			//$bkgd="#32ff32";
	   ?>
	     <tr>
		  <td bgcolor="<?php echo $bkgd ?>"><?php echo $row_ordered['entrydt']; ?></td>			 
		  <td bgcolor="<?php echo $bkgd ?>"><?php echo $row_ordered['status']; ?></td>			 
		  <td bgcolor="<?php echo $bkgd ?>"><?php echo $row_ordered['doctor']; ?></td>			 
		  <td bgcolor="<?php echo $bkgd ?>" title="Order#: <?php echo $row_ordered['id']; ?>&#10; Doctor: <?php echo $row_ordered['doctor']; ?>&#10; EntryDt: <?php echo $row_ordered['entrydt']; ?>&#10; EntryBy: <?php echo $row_ordered['entryby']; ?>&#10; Order Comments: <?php echo $row_ordered['comments']; ?>">
		  <input name="item2" id="item2" size="20" class="" value="<?php echo $row_ordered['item']; ?>" /></td>  
		  <!-- adding type="button" centers the text -->
		<td nowrap="nowrap" bgcolor="<?php echo $bkgd ?>"><input name="nunits" type="text" id="nunits" size="1" disabled="disabled" class="center" Value="<?php echo $row_ordered['nunits']; ?>" />
		  <input name="unit" type="text" id="unit" size="5" disabled="disabled" Value="<?php echo $row_ordered['unit']; ?>" />
		  Every
		  <input name="every" type="text" id="every" size="1" class="center" disabled="disabled" Value="<?php echo $row_ordered['every']; ?>" />
		  <input name="every" type="text" id="every" size="3" disabled="disabled" Value="<?php echo $row_ordered['evperiod']; ?>" />
		  for
		  <input name="fornum" type="text" id="fornum" size="1"  class="center" disabled="disabled" Value="<?php echo $row_ordered['fornum']; ?>" />
		  <input name="forperiod" type="text" id="forperiod" size="3" disabled="disabled" Value="<?php echo $row_ordered['forperiod']; ?>" /></td>
		 </tr>
     <?php } while ($row_ordered = mysql_fetch_assoc($ordered)); ?>
    </table>




<?php } ?>
