
<?php if($_GET['SLC'] = "State"  AND isset($_GET['country']))
 {
	$country=intval($_GET['country']);
	$link = mysql_connect('localhost', 'root', 'jiloa7'); //changet the configuration in required
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('swmisswmis');
	$query="SELECT id, state FROM state WHERE countryid='$country'";
	$rstate=mysql_query($query);
	
	?>
<select name="state" onchange="getLocgovt(this.value)">
  <option>Select State</option>
  <?php while($rowState=mysql_fetch_array($rstate)) { ?>
  <option value=<?php echo $rowState['id']?>><?php echo $rowState['state']?></option>
  <?php } ?>
</select>
<?php } ?>



<?php if($_GET['SLC'] = "Locgovt" AND isset($_GET['state']))
  {
	$stateId=intval($_GET['state']);
	$link = mysql_connect('localhost', 'root', 'jiloa7'); //changet the configuration in required
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('swmisswmis');
	$query="SELECT id, locgovt FROM locgovt WHERE stateid='$stateId'";  //countryid='5' AND stateid='5'"; // 
	$rlocgovt=mysql_query($query);
	 
	?>
	<select name="locgovt" onchange="getCity(this.value)">
	<option>Select LocalGovt</option>
	<?php  while($rowLocgovt=mysql_fetch_array($rlocgovt)) { ?>
	<option value=<?php echo $rowLocgovt['id']?>><?php echo $rowLocgovt['locgovt']?></option>
	<?php  } ?>
	</select>
  
<?php } ?>



<?php if($_GET['SLC'] = "City"  AND isset($_GET['locgovt']))
  {
	$locgovtId=intval($_GET['locgovt']);
	$link = mysql_connect('localhost', 'root', 'jiloa7'); //changet the configuration in required
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('swmisswmis');
	$query="SELECT id, city FROM city WHERE locgovtid='$locgovtId'";
	//countryid='5' AND stateid='5' AND locgovtid='9'";
	$rcity=mysql_query($query);
	
	?>
	<select name="city">
	<option>Select City</option>
	<?php  while($rowCity=mysql_fetch_array($rcity)) { ?>
	<option value=<?php echo $rowCity['id']?>><?php echo $rowCity['city']?></option>
	<?php  } ?>
	</select>
  
<?php } ?>
  