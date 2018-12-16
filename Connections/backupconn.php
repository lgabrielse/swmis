<?php
# FileName="Connection_php_mysqli.htm"
# Type="MYSQLI"
# HTTP="true"
$hostname_backupconn = "localhost";
$database_backupconn = "swmisbackuplog";
$username_backupconn = "root";
$password_backupconn = "jiloa7";
$backupconn = mysqli_connect($hostname_backupconn, $username_backupconn, $password_backupconn, $database_backupconn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>