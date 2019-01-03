<?php  $pt = "List of Orders"; ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/Len/Jiloa/Master/Header.php'); ?> 
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>


<?php if(!isset($_POST['dept'])) {
	$qdept = "Laboratory";
	}
	else {
	$qdept = $_POST['dept'];
	}
?>
<?php if(!isset($_POST['section'])) {
	$qsection = "%";
	}
	else {
	$qsection = $_POST['section'];
	}
?>
<?php if(!isset($_POST['status'])) {
	$qstatus = "%";
	}
	else {
	$qstatus = $_POST['status'];
	}
?>
<?php if(!isset($_POST['urgency'])) {
	$qurgency = "%";
	}
	else {
	$qurgency = $_POST['urgency'];
	}
?>
<?php if(!isset($_POST['pat_type'])) {
	$qpat_type = "%";
	}
	else {
	$qpat_type = $_POST['pat_type'];
	}
?>
<?php if(!isset($_POST['location'])) {
	$qlocation = "%";
	}
	else {
	$qlocation = $_POST['location'];
	}
?>
<?php if(!isset($_POST['paid'])) {
	$qpaid = "%";
	}
	else {
	$qpaid = $_POST['paid'];
	}
?>
<?php if(!isset($_POST['mydays'])) {
	$qmydays = "1";
	}
	else {
	$qmydays = $_POST['mydays'];
	}
?>
<?php
// if ((isset($_POST["MM_update"])) AND ($_POST["MM_update"] = "form1")) {  // if form data is posted  , o.entrydt >= SYSDATE() - INTERVAL " .$qmydays." DAY mydays
	mysql_select_db($database_swmisconn, $swmisconn);
//	if(!isset($_POST['dept'])) {
	$query_orders = "SELECT p.medrecnum, p.lastname, p.firstname, p.othername,DATE_FORMAT(p.dob,'%d-%b-%Y') dob, p.gender, p.ethnicgroup, o.entryby, DATE_FORMAT(o.entrydt,'%d-%b-%Y') entrydt, o.urgency, o.status, o.comments, CASE WHEN o.amtpaid > 4 THEN 'Y' ELSE 'N' END paid, o.feeid, o.visitid, v.id, v.pat_type, v.location, f.Dept, f.section, f.name FROM `patperm` p join orders o on p.medrecnum = o.medrecnum join patvisit v on o.visitid = v.id join `fee` f on o.feeid = f.id Where dept like '{$qdept}%' AND f.section like '%{$qsection}%' AND o.status like '%{$qstatus}%' AND o.urgency like '%{$qurgency}%' AND v.pat_type like '%{$qpat_type}%' AND v.location like '%{$qlocation}%' AND CASE WHEN o.amtpaid > 4 THEN 'Y' ELSE 'N' END like '%{$qpaid}%' AND o.entrydt >= CURDATE() - INTERVAL " .$qmydays." DAY order by o.entrydt";
	$orders = mysql_query($query_orders, $swmisconn) or die(mysql_error());
	$row_orders = mysql_fetch_assoc($orders);
	$totalRows_orders = mysql_num_rows($orders);
//	}
//  }
mysql_select_db($database_swmisconn, $swmisconn);
$query_dept = "SELECT name, seq FROM dropdownlist where list like '%dept%' order by seq";
$dept = mysql_query($query_dept, $swmisconn) or die(mysql_error());
$row_dept = mysql_fetch_assoc($dept);
$totalRows_dept = mysql_num_rows($dept);

mysql_select_db($database_swmisconn, $swmisconn);
$query_section = "SELECT name, seq FROM dropdownlist where list like '%section' order by seq";
$section = mysql_query($query_section, $swmisconn) or die(mysql_error());
$row_section = mysql_fetch_assoc($section);
$totalRows_section = mysql_num_rows($section);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>List of Orders</title>
<link href="../../CSS/Level3_1.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div align="center"><span class="BlueBold_16"> List of Orders</span> (Registration Orders not included - no visit record) </div>
<table width="50%" align="center">
  <tr>
    <td><form id="form1" name="form1" method="post" action="Orders.php">
      <table width="60%" align="center">
        <tr>
          <td class="BlackBold_11"><div align="center">Days Back</div></td>
          <td class="BlackBold_11"><div align="center">Urgency</div></td>
          <td class="BlackBold_11"><div align="center">Status</div></td>
          <td class="BlackBold_11"><div align="center">Paid</div></td>
          <td class="BlackBold_11"><div align="center">Type</div></td>
          <td class="BlackBold_11"><div align="center">Location</div></td>
          <td class="BlackBold_11"><div align="center">Dept</div></td>
          <td class="BlackBold_11"><div align="center">Section</div></td>
          <td><?php echo date('H:i', time()) ?></td>
        </tr>
        <tr>
          <td><input name="mydays" type="text" id="mydays" value="<?php echo $qmydays ?>" size="2" /></td>
          <td><select name="urgency" id="urgency">
            <option value="%" <?php if (!(strcmp("%", $qurgency))) {echo "selected=\"selected\"";} ?>>All</option>
            <option value="Routine" <?php if (!(strcmp("Routine", $qurgency))) {echo "selected=\"selected\"";} ?>>Routine</option>
            <option value="Scheduled" <?php if (!(strcmp("Scheduled", $qurgency))) {echo "selected=\"selected\"";} ?>>Scheduled</option>
            <option value="ASAP" <?php if (!(strcmp("ASAP", $qurgency))) {echo "selected=\"selected\"";} ?>>ASAP</option>
            <option value="STAT" <?php if (!(strcmp("STAT", $qurgency))) {echo "selected=\"selected\"";} ?>>STAT</option>
          </select></td>
          <td><select name="status">
              <option value="%" <?php if (!(strcmp("%", $qstatus))) {echo "selected=\"selected\"";} ?>>All</option>
              <option value="Ordered" <?php if (!(strcmp("Ordered", $qstatus))) {echo "selected=\"selected\"";} ?>>Ordered</option>
              <option value="InLab" <?php if (!(strcmp("InLab", $qstatus))) {echo "selected=\"selected\"";} ?>>InLab</option>
              <option value="Complete" <?php if (!(strcmp("Complete", $qstatus))) {echo "selected=\"selected\"";} ?>>Complete</option>
              <option value="ReOrdered" <?php if (!(strcmp("ReOrdered", $qstatus))) {echo "selected=\"selected\"";} ?>>ReOrdered</option>
            </select>
          </td>
          <td><select name="paid"  id="paid">
              <option value="%" <?php if (!(strcmp("%", $qpaid))) {echo "selected=\"selected\"";} ?>>All</option>
              <option value="Y" <?php if (!(strcmp("Y", $qpaid))) {echo "selected=\"selected\"";} ?>>Y</option>
              <option value="N" <?php if (!(strcmp("N", $qpaid))) {echo "selected=\"selected\"";} ?>>N</option>
            </select>          </td>
          <td><select name="pat_type" id="pat_type">
            <option value="%" <?php if (!(strcmp("%", $qpat_type))) {echo "selected=\"selected\"";} ?>>All</option>
            <option value="OutPatient" <?php if (!(strcmp("OutPatient", $qpat_type))) {echo "selected=\"selected\"";} ?>>OutPatient</option>
            <option value="InPatient" <?php if (!(strcmp("InPatient", $qpat_type))) {echo "selected=\"selected\"";} ?>>InPatient</option>
            <option value="Antenatal" <?php if (!(strcmp("Antenatal", $qpat_type))) {echo "selected=\"selected\"";} ?>>Antenatal</option>
          </select></td>
          <td><select name="location" id="location">
            <option value="%" <?php if (!(strcmp("%", $qlocation))) {echo "selected=\"selected\"";} ?>>All</option>
            <option value="Clinic" <?php if (!(strcmp("Clinic", $qlocation))) {echo "selected=\"selected\"";} ?>>Clinic</option>
            <option value="SpecialistClinic" <?php if (!(strcmp("SpecialistClinic", $qlocation))) {echo "selected=\"selected\"";} ?>>SpecialistClinic</option>
            <option value="EyeClinic" <?php if (!(strcmp("EyeClinic", $qlocation))) {echo "selected=\"selected\"";} ?>>EyeClinic</option>
            <option value="Labour" <?php if (!(strcmp("Labour", $qlocation))) {echo "selected=\"selected\"";} ?>>Labour</option>
            <option value="Ward:Female" <?php if (!(strcmp("Ward:Female", $qlocation))) {echo "selected=\"selected\"";} ?>>Ward:Female</option>
            <option value="Ward:Male" <?php if (!(strcmp("Ward:Malec", $qlocation))) {echo "selected=\"selected\"";} ?>>Ward:Male</option>
            <option value="Ward:Amenity" <?php if (!(strcmp("Ward:Amenity", $qlocation))) {echo "selected=\"selected\"";} ?>>Ward:Amenity</option>
            <option value="Booking" <?php if (!(strcmp("Booking", $qlocation))) {echo "selected=\"selected\"";} ?>>Booking</option>
            <option value="Clinic" <?php if (!(strcmp("Clinic", $qlocation))) {echo "selected=\"selected\"";} ?>>Clinic</option>
          </select></td>
          <td><select name="dept" id="dept">
              <option value="%" <?php if (!(strcmp("%", $qdept))) {echo "selected=\"selected\"";} ?>>All</option>
              <?php
do {  
?>
            <option value="<?php echo $row_dept['name']?>"<?php if (!(strcmp($row_dept['name'], $qdept))) {echo "selected=\"selected\"";} ?>><?php echo $row_dept['name']?></option>
              <?php
} while ($row_dept = mysql_fetch_assoc($dept));
  $rows = mysql_num_rows($dept);
  if($rows > 0) {
      mysql_data_seek($dept, 0);
	  $row_dept = mysql_fetch_assoc($dept);
  }
?>
            </select>          </td>
          <td><select name="section" id="section">
              <option value="%" <?php if (!(strcmp("%", $qsection))) {echo "selected=\"selected\"";} ?>>All</option>
              <?php
do {  
?>
            <option value="<?php echo $row_section['name']?>"<?php if (!(strcmp($row_section['name'], $qsection))) {echo "selected=\"selected\"";} ?>><?php echo $row_section['name']?></option>
              <?php
} while ($row_section = mysql_fetch_assoc($section));
  $rows = mysql_num_rows($section);
  if($rows > 0) {
      mysql_data_seek($section, 0);
	  $row_section = mysql_fetch_assoc($section);
  }
?>
            </select>          </td>
          <td><input type="submit" name="Submit" value="Select" /></td>
        </tr>
      </table>
	        <input type="hidden" name="MM_update" value="form1">

        </form>
    </td>
  </tr>
</table>
<br />
<?php // if ((isset($_POST["MM_update"])) AND ($_POST["MM_update"] = "form1")) {  // if form data is posted?>

<table border="0" align="center" bordercolor="#000000" border-collapse="collapse">
  <tr>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">#</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Name</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Age</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Sex</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Order Date</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Urg</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Status</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Paid</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Pat. Type</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Location</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Dept</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Section</div></td>
    <td bgcolor="#f5f5f5" class="BlackBold_11"><div align="center">Order</div></td>
  </tr>
<?php   $i = 0; ?>
  <?php do {
  $i = $i + 1;  ?>
    <tr>
      <td bgcolor="#FFFFFF"><?php echo $i; ?></td>
      <td nowrap="nowrap" bgcolor="#FFFFFF" title="MedRecNum: <?php echo $row_orders['medrecnum']; ?> &#10;Ethnicity: <?php echo $row_orders['ethnicgroup']; ?>"><?php echo $row_orders['lastname']; ?>,<?php echo $row_orders['firstname']; ?> ( <?php echo $row_orders['othername']; ?>)</td>
	  
<?php //calculate patient Age and assign it to $patage variable
$patage = 0;
$patdob = 0;
if (strtotime($row_orders['dob'])) {
	$c= date('Y');
	$y= date('Y',strtotime($row_orders['dob']));
	$patage = $c-$y;
//format date of birth
	$datetime = strtotime($row_orders['dob']);
	$patdob = date("m/d/y", $datetime);
	}
?>
      <td bgcolor="#FFFFFF"><?php echo $patage; ?></td>
      <td bgcolor="#FFFFFF"><?php echo $row_orders['gender']; ?></td>
      <td bgcolor="#FFFFFF" title="<?php echo $row_orders['entryby']; ?>"><?php echo $row_orders['entrydt']; ?></td>
      <td bgcolor="#FFFFFF"><?php echo $row_orders['urgency']; ?></td>
      <td bgcolor="#FFFFFF"><?php echo $row_orders['status']; ?></td>
      <td bgcolor="#FFFFFF"><?php echo $row_orders['paid']; ?></td>
      <td bgcolor="#FFFFFF" title="<?php echo $row_orders['visitid']; ?>"><?php echo $row_orders['pat_type']; ?></td>
      <td bgcolor="#FFFFFF"><?php echo $row_orders['location']; ?></td>
      <td bgcolor="#FFFFFF"><?php echo $row_orders['Dept']; ?></td>
      <td bgcolor="#FFFFFF"><?php echo $row_orders['section']; ?></td>
      <td bgcolor="#FFFFFF" title="Order ID: <?php echo $row_orders['id']; ?>&#10;Fee ID: <?php echo $row_orders['feeid']; ?>&#10;Comments: <?php echo $row_orders['comments']; ?>"><?php echo $row_orders['name'] ?></td>
    </tr>
    <?php } while ($row_orders = mysql_fetch_assoc($orders)); ?>
</table>
<?php mysql_free_result($orders);
	//} ?>
</body>
</html>
<?php

mysql_free_result($dept);

mysql_free_result($section);
?>
