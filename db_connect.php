<?php
$hostname = 'localhost';
$username = 'root';
$db_password = '';
$database = 'january_php';
$connect_status = mysqli_connect($hostname, $username, $db_password, $database);

if (!$connect_status) {
  echo 'Database Connection failed' . mysqli_connect_error();
}
?>