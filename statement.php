<?php
require('db_connect.php');

$full_name = "John Doe";
$email = "johndoe@gmail.com";

$query = "SELECT * FROM `users_tb` WHERE email = ?";

$stmt = $connect_status->prepare($query);
$stmt->bind_param('s', $email);
$result = $stmt->execute();

$found_user = mysqli_stmt_get_result($stmt);  // returns a mysqli_result object
$user = mysqli_fetch_assoc($found_user); // returns an associative array


print_r($user);
?>