<?php
$err_message = '';
$success_message = '';

if (isset($_POST['register'])) {
  $fullName = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $password = $_POST['password'];


  if (empty($fullName) || empty($email) || empty($phone) || empty($password)) {
    $err_message = 'All fields are required';
  } elseif (strlen($password) <= 8) {
    $err_message = 'Password must not be less than 8 characters';
  } else {

    require('db_connect.php');

    if ($connect_status) {
      $checkQuery = "SELECT * FROM users_tb WHERE email = '$email' OR phone_number = '$phone' ";
      $results = mysqli_query($connect_status, $checkQuery);

      if (mysqli_num_rows($results) > 0) {
        $err_message = "User already exist";
      } else {
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users_tb (full_name, email, phone_number, profile_pic, password) VALUES ('$fullName', '$email', '$phone', 'user_icon.png', '$hashedpassword')";
        $result = mysqli_query($connect_status, $query);
        if ($result) {
          echo "Data inserted successfully";
          header('Location: signin.php');
        } else {
          echo 'Data not inserted into the database table' . mysqli_error($connect_status);
        }
      }
    } else {
      echo 'Database Connection failed' . mysqli_connect_error();
      die();
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body style="background-color:rgba(66, 154, 248, 0.33);">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg">
          <div class="card-header bg-primary text-white text-center">
            <h3>Sign Up</h3>
          </div>
          <div class="card-body">
            <form action="" method="post">
              <div>
                <?php
                echo "<p class='text-danger text-center fs-5'>" . $err_message . "</p>";
                echo "<p class='text-success text-center fs-5'>" . $success_message . "</p>";
                ?>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
              <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="number" class="form-control" id="phone" name="phone">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="d-grid">
                <button class="btn btn-primary" name="register" type="submit">Register</button>
              </div>
            </form>
            <p class="text-center my-4">Have an account? <a href="http://localhost/PHP_2025_JAN_COHORT/forms/signin.php">Signin</a> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>