<?php

session_start();
require('db_connect.php');

$user_profile_pic = $_SESSION['loggedin_user'];
$usersPic = $user_profile_pic['profile_pic'];

if (isset($_POST['upload_pic'])) {

  // if (isset($_FILES['profile_pic'])) {
  //   echo 'File uploaded';
  // } else {
  //   echo 'File not uploaded';
  // }

  $_FILES['profile_pic'];

  $uploaded_file = $_FILES['profile_pic'];

  $accepted_file_types = ['png', 'JPG', 'jpeg', 'gif', 'svg', 'webp'];

  // //Method 1 of getting extension type of file uploaded by user.
  // $exploded_string = explode('.', $uploaded_file['name']);
  // $ext = array_pop($exploded_string);
  // echo "<br>";
  // echo $ext;


  // Method 2 of getting extension type of file uploaded by user. 
  $file_info = pathinfo($uploaded_file['name']);
  $ext = $file_info['extension'];



  if ($uploaded_file['size'] > 4000000) {
    echo 'File size is too large';
  } else if (!in_array($ext, $accepted_file_types)) {
    echo 'File type is not accepted';
  } else {
    move_uploaded_file($uploaded_file['tmp_name'], 'img/' . $uploaded_file['name']);


    $user_id = $_SESSION['loggedin_user']['id'];
    $file_name = $uploaded_file['name'];
    $query = "UPDATE users_tb SET profile_pic = '$file_name' WHERE id = '$user_id'";
    $updateduser = mysqli_query($connect_status, $query);
    //Update the user session
    $query = "SELECT * FROM users_tb WHERE id = '$user_id'";
    $result = mysqli_query($connect_status, $query);
    $found_user = mysqli_fetch_assoc($result);
    $_SESSION['loggedin_user'] = $found_user;
    header('Location: dashboard.php');



    echo 'File uploaded successfully';
  }
}




//Adding Product to Website Database
if (isset($_POST['add_product'])) {
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_description = $_POST['product_description'];
  $product_img = $_FILES['product_image'];

  if (empty($product_name) || empty($product_price) || empty($product_description) || empty($_FILES['product_image'])) {
    echo 'All fields are required';
  } else {
    require('db_connect.php');


    if ($connect_status) {
      $accepted_file_types = ['png', 'JPG', 'jpeg', 'gif', 'svg', 'webp'];
      $file_info = pathinfo($product_img['name']);
      $ext = $file_info['extension'];


      if ($product_img['size'] > 4000000) {
        echo 'File size is too large';
      } else if (!in_array($ext, $accepted_file_types)) {
        echo 'File type is not accepted';
      } else {
        move_uploaded_file($product_img['tmp_name'], 'img/' . $product_img['name']);
        $productImg = $product_img['name'];
        $query = "INSERT INTO products_tb (product_name, product_price, product_description, product_image) VALUES ('$product_name', '$product_price', '$product_description', '$productImg')";
        $result = mysqli_query($connect_status, $query);
        if ($result) {
          echo 'Product added successfully';
        } else {
          echo 'Product not added' . mysqli_error($connect_status);
        }

        echo 'File uploaded successfully';
      }
    } else {
      echo 'Database Connection failed' . mysqli_connect_error();
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body style="background-color:rgba(66, 154, 248, 0.33);">

  <div class="container   justify-content-center shadow-lg my-5 py-4 w-100">
    <h1 class="text-center my-5 ">Welcome to Your Dashboard <?php echo $_SESSION['loggedin_user']['full_name']; ?><span class="fs-5"> <a href="/PHP_2025_JAN_COHORT/forms/signup.php">(Logout)</a> </span></h1>

    <img src="./img/<?php echo $usersPic ?>" alt="" class="img-fluid d-block mx-auto mb-5" style="width: 100px; height: 100px;">



    <div class="accordion" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Update Your Profile Image
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <form action="dashboard.php" method="post" enctype="multipart/form-data" class="w-75 mx-auto">
              <div class="mb-3 ">
                <label for="profilePic" class="form-label fw-bold">Upload Profile Picture</label>
                <input type="file" class="form-control" name="profile_pic">
              </div>
              <button type="submit" name="upload_pic" class="btn btn-primary">Upload</button>
            </form>

          </div>
        </div>
      </div>
    </div>





  </div>

  <div class="container  d-flex justify-content-center shadow-lg my-5 py-4 w-100">
    <form action="dashboard.php" method="post" class="w-50" enctype="multipart/form-data">
      <h2 class="text-center mb-4">Add a Product</h2>
      <div class="mb-3">
        <label for="productName" class="form-label fw-bold">Product Name</label>
        <input type="text" class="form-control" name="product_name" required>
      </div>
      <div class="mb-3">
        <label for="productPrice" class="form-label fw-bold">Product Price</label>
        <input type="number" class="form-control" name="product_price" required>
      </div>
      <div class="mb-3">
        <label for="productDescription" class="form-label fw-bold">Product Description</label>
        <textarea class="form-control" name="product_description" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label for="productimage" class="form-label fw-bold">Product Image</label>
        <input type="file" class="form-control" name="product_image" rows="3" required></input>
      </div>
      <button type="submit" name="add_product" class="btn btn-primary mt-4">Add Product</button>
    </form>
  </div>






  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>