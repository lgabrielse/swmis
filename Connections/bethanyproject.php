<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_bethanyproject = "localhost";  //p3nl50mysql907.secureserver.net
$database_bethanyproject = "bethanyproject"; 
$username_bethanyproject = "root";  //bethanyproject
$password_bethanyproject = "jiloa7";  //jiloa#R777
$bethanyproject = mysql_pconnect($hostname_bethanyproject, $username_bethanyproject, $password_bethanyproject) or trigger_error(mysql_error(),E_USER_ERROR); 
?>