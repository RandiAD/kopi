<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_koneksi_kopi = "localhost";
$database_koneksi_kopi = "db_kopi";
$username_koneksi_kopi = "root";
$password_koneksi_kopi = "";
$koneksi_kopi = mysql_pconnect($hostname_koneksi_kopi, $username_koneksi_kopi, $password_koneksi_kopi) or trigger_error(mysql_error(),E_USER_ERROR); 
?>