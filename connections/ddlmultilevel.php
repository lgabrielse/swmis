<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ddlmultilevel = "localhost";
$database_ddlmultilevel = "ddlmultilevel";
$username_ddlmultilevel = "root";
$password_ddlmultilevel = "jiloa7";
$ddlmultilevel = mysql_pconnect($hostname_ddlmultilevel, $username_ddlmultilevel, $password_ddlmultilevel) or trigger_error(mysql_error(),E_USER_ERROR); 
?>