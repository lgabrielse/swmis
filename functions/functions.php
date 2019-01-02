<!-- functions to be 'included'  -->


<!-- to check security permission and level --> 
<?php function allow($permit, $plevel) {   // define function 
		$stpos =(stripos($_SESSION["swmis"],':'.$permit.',')-1);   //$_SESSION["swmis"] contains array of user permits and levels 
		if ($stpos > 0 and substr($_SESSION["swmis"], $stpos,1) >= $plevel) {  //if found and user level => code defined level 
			return 1; 
		}
		else {
			return 0;
		}
	}
?>
