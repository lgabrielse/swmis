<?php

# FileName="Connection_php_mysql.htm"

# Type="MYSQL"

# HTTP="true"

$hostname_swmisconn = "localhost";

#$hostname_swmisconn = "swmisbethany.db.11407073.hostedresource.com";

$database_swmisconn = "swmisbethany";

$username_swmisconn = "swmis4005";

$password_swmisconn = "Stephen#R7";

$swmisconn = mysql_pconnect($hostname_swmisconn, $username_swmisconn, $password_swmisconn) or trigger_error(mysql_error(),E_USER_ERROR); 

?>