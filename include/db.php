<?php
$server = "localhost";
$user = "root";
$password = "";
$database = "jejaring";

mysql_connect ($server, $user, $password) or die ("Koneksi Gagal");
mysql_select_db ($database) or die ("Database tidak bisa dibuka");
?>