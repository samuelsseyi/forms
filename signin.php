<?php
require('db_connect.php');
$err_message = "";
$success_message =  "";

session_start();


$_SESSION['message'] = "This is a demo message from session in signin page";

// if (!isset($_SESSION['session_ended'])) {
//   $err_message = "Session Expired! Please log in again";
// } else {
//   $err_message = "";
// }


if (isset($_POST['signin'])) {

  $email = $_POST['email'];
  $hashedpassword = $_POST['password'];


  if (empty($email) || empty($hashedpassword)) {
    $err_message = 'All fields are required';
  } else {
    $query = "SELECT * FROM users_tb WHERE email = '$email'";

    $result = mysqli_query($connect_status, $query);

    if (mysqli_num_rows($result) > 0) {
      echo "User Found";
      $found_user = mysqli_fetch_assoc($result);


      if (password_verify($hashedpassword, $found_user['password'])) {
        echo "Password Matched";
        $_SESSION['loggedin_user'] = $found_user;
        header('location: dashboard.php');

        $login_time = time();
        $_SESSION['login_time'] = $login_time;
      } else {
        echo "Password not Matched";
        $err_message =  "Incorrect Email or Password";
      }
    } else {
      echo "User not found!" . mysqli_error($connect_status);
      $err_message = 'User not found!';
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
            <h3>Sign In</h3>
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
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="d-grid">
                <button class="btn btn-primary" name="signin" type="submit">Sign In</button>
              </div>
            </form>
            <p class="text-center my-4">Don't have an account? <a href="http://localhost/PHP_2025_JAN_COHORT/forms/signup.php">Signup</a> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>