<?php session_start(); ?>
<?php require '../php_validate.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>Document</title>
  <style>
    <?php include 'index.css'; ?>
  </style>
</head>

<body>
  <?php

  // PHP validation of form data.
  $fname = $lname = '';
  global $email_api;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $php_check = new validate();
    $php_check->validate_First_Name($_POST['fname']);
    $php_check->validate_Last_Name($_POST['lname']);
    $fname_error = $php_check->fname_error;
    $lname_error = $php_check->lname_error;
    $email_error = $php_check->email_error;
    $phone_error = $php_check->phone_error;
  }
  $full_name = $fname . " " . $lname;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $marks = $_POST['marks'];
    $marks_output = explode("\n", $marks);
    $sub_info = array();
  }
  $full_name = $fname . " " . $lname;
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
      echo "File is an image - " . $check["mime"] . ".<br>";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }
  }

  // Check if file exist
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
  ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      //echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }

  $imag = $_FILES["fileToUpload"]["name"];
  $img = "uploads/" . $imag;

  ?>

  <div class="profile">
    <div>
      <?php
      if ($uploadOk != 0) {
        echo '<img class="image" src="' . $img . '" height="200" width="200" alt="This is what you Uploaded!!">';
        echo "<h2>Hello $full_name !!</h2>";
        foreach ($marks_output as $m) {
          $sub = explode("|", $m);
          if ($sub[1] >= 0 && $sub[1] <= 100) {
            $sub_info[$sub[0]] = $sub[1];
          } else {
            $sub_info[$sub[0]] = "NAN";
          }
        }

        echo "<table>";
        echo "<tr><th>Subjects</th><th>Marks</th></tr>";
        foreach ($sub_info as $x => $x_value) {
          echo  "<tr><td>$x</td> <td>$x_value</td></tr>";
        }
        echo "</table>";
        
      }

      ?>
    </div>
  </div>
</body>
</html>
