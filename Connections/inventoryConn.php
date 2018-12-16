<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_inventoryConn = "localhost";
$database_inventoryConn = "bethanyinventory";
$username_inventoryConn = "root";
$password_inventoryConn = "jiloa7";
$inventoryConn = mysql_pconnect($hostname_inventoryConn, $username_inventoryConn, $password_inventoryConn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>