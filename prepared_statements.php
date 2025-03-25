<?php
require('db_connect.php');

$full_name = "John Doe";
$email = "johndoe@gmail.com";
$phone_number = "08012345678";
$password = "demopassword12";
$hased_password = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO `users_tb` (full_name, email, phone_number, password) VALUES (?, ?, ?, ?)";


// Step 1: Prepare the statement or query
$stmt = $connect_status->prepare($query); // returns a mysqli_stmt object

// Step 2: Bind the parameters to the query
$stmt->bind_param('ssss', $full_name, $email, $phone_number, $hased_password);

// Step 3: Execute the query
$save_status_affirmed = $stmt->execute();

if ($save_status_affirmed) {
  echo 'User added successfully';
} else {
  echo 'User not added' . mysqli_error($connect_status);
}
