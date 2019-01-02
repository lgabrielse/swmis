<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_bethanyconn2 = "localhost";
$database_bethanyconn2 = "swmisbethany";
$username_bethanyconn2 = "root";
$password_bethanyconn2 = "jiloa7";
$bethanyconn2 = mysql_pconnect($hostname_bethanyconn2, $username_bethanyconn2, $password_bethanyconn2) or trigger_error(mysql_error(),E_USER_ERROR); 
?>