<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_mrbs = "localhost";
$database_mrbs = "swmismrbs";
$username_mrbs = "root";
$password_mrbs = "jiloa7";
$mrbs = mysql_pconnect($hostname_mrbs, $username_mrbs, $password_mrbs) or trigger_error(mysql_error(),E_USER_ERROR); 
?>