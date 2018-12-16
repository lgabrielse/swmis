<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_swmisconn = "localhost";
$database_swmisconn = "swmistraining";
$username_swmisconn = "root";
$password_swmisconn = "jiloa7";
$swmisconn = mysql_pconnect($hostname_swmisconn, $username_swmisconn, $password_swmisconn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>