<?php $pt = "Rx Orders"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?> 
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>

<?php 	//check for session already set ... so when reselect form RxOrderslist.php is selected, the selected status will be used
		if(!isset($_POST['Rxstatus'])) {	 
			$_SESSION['Rxstatus'] = "'RxOrdered', 'RxPaid'";
			$_SESSION['RxstatusA'] = "'RxOrdRxPaid'";
	 	}

		//$_SESSION['Rxstatus'] = "'RxOrdered'";		

		if (isset($_POST['Rxstatus'])) { // if a new RxStatus is selected
	  		$colname_Rxstatus = (get_magic_quotes_gpc()) ? $_POST['Rxstatus'] : addslashes($_POST['Rxstatus']);
	 		if($colname_Rxstatus == 'RxOrdRxPaid'){
				$_SESSION['Rxstatus'] = "'RxOrdered', 'RxPaid'";		
				$_SESSION['RxstatusA'] = 'RxOrdRxPaid';		
			} elseif($colname_Rxstatus == 'RxOrdered') {
				$_SESSION['Rxstatus'] = "'RxOrdered'";
				$_SESSION['RxstatusA'] = 'RxOrdered';		
			} elseif($colname_Rxstatus == 'RxCosted') {
				$_SESSION['Rxstatus'] = "'RxCosted'";
				$_SESSION['RxstatusA'] = 'RxCosted';		
			} elseif($colname_Rxstatus == 'RxPaid') {
				$_SESSION['Rxstatus'] = "'RxPaid'";
				$_SESSION['RxstatusA'] = 'RxPaid';		
			} elseif($colname_Rxstatus == 'RxDispensed') {
				$_SESSION['Rxstatus'] = "'RxDispensed'";
				$_SESSION['RxstatusA'] = 'RxDispensed';		
			} elseif($colname_Rxstatus == 'RxReferred') {
				$_SESSION['Rxstatus'] = "'RxReferred'";
				$_SESSION['RxstatusA'] = 'RxReferred';		
//			} elseif($colname_Rxstatus == 'RxCancelled') {
//				$_SESSION['Rxstatus'] = "'RxCancelled'";
//				$_SESSION['RxstatusA'] = 'RxCancelled';		
			} elseif($colname_Rxstatus == 'RxRefund') {
				$_SESSION['RxStatus'] = "'RxRefund'";
				$_SESSION['RxstatusA'] = 'RxRefund';		
			} elseif($colname_Rxstatus == 'RxRefunded') {
				$_SESSION['Rxstatus'] = "'RxRefunded'";
				$_SESSION['RxstatusA'] = 'RxRefunded';		
			} elseif($colname_Rxstatus == 'All') {
				$_SESSION['Rxstatus'] = "'RxOrdered','RxCosted','RxPaid','Dispensed','RxDispensed','RxReferred'"; //,'RxCancelled', 'RxRefund', 'RxRefunded'
				$_SESSION['RxstatusA'] = 'All';
			} else {
				$_SESSION['Rxstatus'] = "'RxOrdered', 'RxPaid'";
				$_SESSION['RxstatusA'] = 'RxOrdRxPaid';		
			}
		}	 

		if(!isset($_SESSION['daysback'])) {	 
			$_SESSION['daysback'] = 20;
        }
		//$colname_daysback = "20";
		if (isset($_POST['daysback'])  && strlen($_POST['daysback'])>0 ) {   //&& ($_POST["MM_update"] == "form3")
		 	$colname_daysback = (get_magic_quotes_gpc()) ? $_POST['daysback'] : addslashes($_POST['daysback']);
			$_SESSION['daysback'] = $colname_daysback;
		}   

?>
<?php
$mydate = 20;
mysql_select_db($database_swmisconn, $swmisconn);//o.status, o.amtdue, amtpaid, billstatus, 
$query_Orders = "SELECT DISTINCT o.medrecnum, o.visitid, p.lastname, p.firstname, p.othername, p.gender, p.ethnicgroup, p.dob, DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,dob)),'%y') AS age, p.ethnicgroup, p.active, left(v.pat_type,1) pt FROM `orders` o join `patperm` p on o.medrecnum = p.medrecnum join fee f on o.feeid = f.id join patvisit v on o.visitid = v.id WHERE o.status in (".$_SESSION['Rxstatus'].") and f.dept = 'Pharm' and o.entrydt >= SYSDATE() - INTERVAL " .($_SESSION['daysback'])." DAY order by lastname, firstname";
$Orders = mysql_query($query_Orders, $swmisconn) or die(mysql_error());
$row_Orders = mysql_fetch_assoc($Orders);
$totalRows_Orders = mysql_num_rows($Orders);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rx Orders</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="800px" align="center">
  <tr>
    <td>
	  <table width="50%" align="center">
        <tr>
          <td nowrap="nowrap"><?php //echo $_POST['Rxstatus'] ?>
          <div align="center" class="subtitlebl">PHARMACY CURRENT PATIENTS </div></td>
          <td nowrap="nowrap">&nbsp;<a href="RxOrdersReport.php" class="navLink">VIEW ALL ORDERS</a> </td>
        </tr>
      </table>	</td>
  </tr>
  	<td>
		<table>
			<tr>
			<form id = "formStatus" name = "formStatus" method="POST" action="RxOrdersList.php">
			   <td nowrap="nowrap"><?php //echo $_SESSION['Rxstatus'] ?><div align="right">RxOrder Status:</div></td>
               <td>
			   	 <select name="Rxstatus" id="Rxstatus" onChange="document.formStatus.submit();">
					<option value="RxOrdRxPaid" <?php if (!(strcmp("RxOrdRxPaid", $_SESSION['RxstatusA']))) {echo "selected=\"selected\"";} ?>>RxOrdRxPaid</option>
					<option value="RxOrdered" <?php if (!(strcmp("RxOrdered", $_SESSION['RxstatusA']))) {echo "selected=\"selected\"";} ?>>RxOrdered</option>
					<option value="RxCosted" <?php if (!(strcmp("RxCosted", $_SESSION['RxstatusA']))) {echo "selected=\"selected\"";} ?>>RxCosted</option>
					<option value="RxPaid" <?php if (!(strcmp("RxPaid", $_SESSION['RxstatusA']))) {echo "selected=\"selected\"";} ?>>RxPaid</option>
					<option value="RxDispensed" <?php if (!(strcmp("RxDispensed", $_SESSION['RxstatusA']))) {echo "selected=\"selected\"";} ?>>RxDispensed</option>
					<option value="RxReferred" <?php if (!(strcmp("RxReferred", $_SESSION['RxstatusA']))) {echo "selected=\"selected\"";} ?>>RxReferred</option>
					<option value="RxCancelled" <?php if (!(strcmp("RxCancelled", $_SESSION['RxstatusA']))) {echo "selected=\"selected\"";} ?>>RxCancelled</option>
					<option value="RxRefund" <?php if (!(strcmp("RxRefund", $_SESSION['RxstatusA']))) {echo "selected=\"selected\"";} ?>>RxRefund</option>
					<option value="RxRefunded" <?php if (!(strcmp("RxRefunded", $_SESSION['RxstatusA']))) {echo "selected=\"selected\"";} ?>>RxRefunded</option>
					<option value="All" <?php if (!(strcmp("All", $_SESSION['RxstatusA']))) {echo "selected=\"selected\"";} ?>>All</option>
				 </select><?php // echo $_SESSION['Rxstatus'] ?>			   </td>
			</form>
			<form id = "formDays" name = "formDays" method="POST" action="">
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Days Back</td>
				<td>
				<select name="daysback" id="daysback" size="1" onChange="document.formDays.submit();">
					
					<option value="0" <?php if (!(strcmp(0, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>0</option>
					<option value="1" <?php if (!(strcmp(1, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>1</option>
					<option value="2" <?php if (!(strcmp(2, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>2</option>
					<option value="3" <?php if (!(strcmp(3, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>3</option>
					<option value="4" <?php if (!(strcmp(4, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>4</option>
					<option value="5" <?php if (!(strcmp(5, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>5</option>
					<option value="6" <?php if (!(strcmp(6, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>6</option>
					<option value="7" <?php if (!(strcmp(7, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>7</option>
					<option value="10" <?php if (!(strcmp(10, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>10</option>
					<option value="15" <?php if (!(strcmp(15, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>15</option>
					<option value="20" <?php if (!(strcmp(20, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>20</option>
					<option value="25" <?php if (!(strcmp(25, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>25</option>
					<option value="30" <?php if (!(strcmp(30, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>30</option>
					<option value="60" <?php if (!(strcmp(60, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>60</option>
					<option value="90" <?php if (!(strcmp(90, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>90</option>
					<option value="120" <?php if (!(strcmp(120, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>120</option>
					<option value="180" <?php if (!(strcmp(180, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>180</option>
					<option value="360" <?php if (!(strcmp(360, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>360</option>
					<option value="720" <?php if (!(strcmp(720, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>720</option>
					<option value="1080" <?php if (!(strcmp(1080, $_SESSION['daysback'] ))) {echo "selected=\"selected\"";} ?>>1080</option>
				</select>
				<input type="hidden" name="MM_update" value="formDays" />
	  		  Ordered</td>
		    </form>
			</tr>
	  </table>	</td>
  <tr>
    <td>  
        <form method="post" name="form2" id="form2" enctype="multipart/form-data">
          <table>
            <tr>
              <td>MRN*</td>
              <td>lastname</td>
              <td>firstname</td>
              <td>othername</td>
              <td>gender</td>
              <td>ethnicgroup</td>
              <td>age</td>
              <td>PT</td>
              <td>order status</td>
            </tr>
            <?php do { //bgcolor="#BCFACC" 
//				if($row_Orders['status'] == 'Refund'){
					$bkgd = "#DDEEFF";
//				} else {
//					$bkgd = "#FFFFFF";
//				}	
			?>
            <tr>
              <td bgcolor="<?php echo $bkgd; ?>" class="nav11"><a href="RxShowPatOrd.php?mrn=<?php echo $row_Orders['medrecnum']; ?>&status=<?php echo $_SESSION['Rxstatus'];?>"><?php echo $row_Orders['medrecnum']; ?></a></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="nav11"><a href="RxShowPatOrd.php?mrn=<?php echo $row_Orders['medrecnum']; ?>&status=<?php echo $_SESSION['Rxstatus'];?>"><?php echo $row_Orders['lastname']; ?></a></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><a href="RxShowPatOrd.php?mrn=<?php echo $row_Orders['medrecnum']; ?>&status=<?php echo $_SESSION['Rxstatus'];?>"><?php echo $row_Orders['firstname']; ?></a></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><a href="RxShowPatOrd.php?mrn=<?php echo $row_Orders['medrecnum']; ?>&status=<?php echo $_SESSION['Rxstatus'];?>"><?php echo $row_Orders['othername']; ?></a></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><?php echo $row_Orders['gender']; ?></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><?php echo $row_Orders['ethnicgroup']; ?></td>
              <?php  //calculate Age
?>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><?php echo $row_Orders['age']; ?></td>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><div align="center"><?php echo $row_Orders['pt']; ?></div></td>
              <?php if(isset($row_Orders['visitid'])) {?>
              <?php mysql_select_db($database_swmisconn, $swmisconn);
$query_status = "SELECT DISTINCT status FROM orders WHERE medrecnum = ".$row_Orders['medrecnum']." and visitid =  ".$row_Orders['visitid']." and feeid = 30  ORDER BY status ASC";
$status = mysql_query($query_status, $swmisconn) or die(mysql_error());
$row_status = mysql_fetch_assoc($status);
$totalRows_status = mysql_num_rows($status);
$statuses = '';		
           do {
			$statuses = $statuses . $row_status['status'] .', ';
			 } while ($row_status = mysql_fetch_assoc($status)); ?>
              <td bgcolor="<?php echo $bkgd; ?>" class="BlackBold_11"><?php echo $statuses; ?></td>
              <td><?php   }?>
            </td>
			<td><a href="RxShowPatOrd.php?mrn=<?php echo $row_Orders['medrecnum']; ?>&status='RxOrdered','RxCosted','RxPaid','Dispensed','RxDispensed','RxReferred'">All</a></td> <!--,'RxCancelled', 'RxRefund', 'RxRefunded'-->
            </tr>
            <?php } while ($row_Orders = mysql_fetch_assoc($Orders)); ?>
          </table>
        </form>	</td>
</table>



</body>
</html>
<?php
mysql_free_result($Orders);
?>
