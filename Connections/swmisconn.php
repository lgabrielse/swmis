<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
error_reporting(E_ALL ^ E_DEPRECATED); # stop error message about not using mysqli
$hostname_swmisconn = "localhost";
$database_swmisconn = "swmisbethany";
$username_swmisconn = "root";
$password_swmisconn = "jiloa7";
$swmisconn = mysql_pconnect($hostname_swmisconn, $username_swmisconn, $password_swmisconn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>