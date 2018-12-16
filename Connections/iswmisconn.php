<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

	$hostname_swmisconn = "localhost";
	$database_swmisconn = "swmisswmis";
	$username_swmisconn = "root";
	$password_swmisconn = "jiloa7";

$iswmisconn = mysqli_connect($hostname_swmisconn, $username_swmisconn, $password_swmisconn, $database_swmisconn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
