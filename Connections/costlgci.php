<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_costlgci = "localhost";
$database_costlgci = "costlgci";
$username_costlgci = "root";
$password_costlgci = "jiloa7";
$costlgci = mysql_pconnect($hostname_costlgci, $username_costlgci, $password_costlgci) or trigger_error(mysql_error(),E_USER_ERROR); 
?>