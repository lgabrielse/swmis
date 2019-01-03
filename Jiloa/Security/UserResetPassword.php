<?php if (session_status() == PHP_SESSION_NONE) {
    session_start(); }?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); ?>
<?php // require_once('../../Connections/swmisconn.php'); ?>
<?php $pt = "Home";  ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/len/Jiloa/Master/Header.php'); ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::. Admin Reset User</title>
	<link href="/Len/css/Level3_1.css" rel="stylesheet" type="text/css" />
    <script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
    </script>
</head>

<body>
<table width="600px" height="205" align="center">
  <tr>
    <td width="312" colspan="2" align="center">
	<?php 
	//code to initialize variable error
	  if(isset($_GET['error'])) {
    $error = $_GET['error'];
  }
  else {
     $error = $_GET['error']= "";
  }
	// begining of code to get the list of users from the database
	if (isset($_GET["page"])) 
{ $page  = $_GET["page"]; } 
else { $page=1; };
$start_from = ($page-1) * 20;
	// CONNECT TO DB
require_once($_SERVER['DOCUMENT_ROOT'].$_SESSION['sysconn']); 
mysql_select_db($database_swmisconn, $swmisconn);
		$usersel = mysql_query("SELECT * FROM users ORDER BY lastname ASC LIMIT $start_from, 20") or die(mysql_error());
if($usersel && mysql_affected_rows()>=1) {
 //open connection to db
echo "<table  class=datatable align=centre>";
echo "<tr>$error</tr>";
echo "<caption> ADMIN RESET USER PASSWORD</>";
echo "<tr><th>USER ID</th><th>LASTNAME</th><th>FIRSTNAME</th><th>DOC FLAG</th><th>ACTIVE</th><th>Edit User</th></tr>";
			while($row = mysql_fetch_array($usersel))
			//Print contents in the table
			{
			$ids = $row['id'];
			echo "<tr><td>"; 
			echo stripslashes($row["userid"]);
			echo "</td><td>"; 
			echo stripslashes($row["lastname"]);
			echo "</td><td>"; 
			echo stripslashes($row["firstname"]);
			echo "</td><td>";
			echo $row["docflag"];
			echo "</td><td>";
			echo $row["active"];
			echo "</td><td>";
			echo "<a href=changePassword_admin.php?myid=$ids title='Edit User'><img src=../Home/b_edit.png></a>"; // by clicking on this link, the ID should be echoed in a hiiden field in the changePass_Admin_Link  Form GUI
			echo "</td></tr>"; 
			} 
			mysql_free_result($usersel);
			echo "</table>";
	}
	else{
		$alert ="No users yet";
		header("location:UserResetPassword.php?error=$alert");
		exit();	
		}	
?>
<?php
//CONNECT TO DB
mysql_select_db($database_swmisconn, $swmisconn);
$sql = "SELECT COUNT(*) FROM users";
$rs_result = mysql_query($sql);
$row = mysql_fetch_row($rs_result);
$total_records = $row[0];
$total_pages = ceil($total_records / 20);
for ($i=1; $i<=$total_pages; $i++) {
echo "<a href='UserResetPassword.php?page=".$i."'>".$i."</a> ";
};
?></td>
  </tr>
  
<?php if (allow(29,4) == 1) {	?>
<?php }?>
</table>

</body>
</html>
<?php
//mysql_free_result($ANNOUN);
?>
