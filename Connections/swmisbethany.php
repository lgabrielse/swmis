<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_swmisbethany = "localhost";
$database_swmisbethany = "swmisbethany";
$username_swmisbethany = "root";
$password_swmisbethany = "jiloa7";
$swmisbethany = mysql_pconnect($hostname_swmisbethany, $username_swmisbethany, $password_swmisbethany) or trigger_error(mysql_error(),E_USER_ERROR); 
?>