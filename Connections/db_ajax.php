<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_db_ajax = "localhost";
$database_db_ajax = "db_ajax";
$username_db_ajax = "root";
$password_db_ajax = "jiloa7";
$ddlmultilevel = mysql_pconnect($hostname_db_ajax, $username_db_ajax, $password_db_ajax) or trigger_error(mysql_error(),E_USER_ERROR); 
?>