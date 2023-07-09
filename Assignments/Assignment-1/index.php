<?php session_start(); ?>
<?php require '../php_validate.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <link rel="stylesheet" href="index.css" type="text/css">
  <style>
    <?php include '../Assignment-4/index.css' ?><?php include 'index.css'; ?>
  </style>
  <script src="../script.js"></script>
  <title>Assignment-1</title>
</head>

<body>

  <?php

  // Validating if the user is logged in or not.
  if (!isset($_SESSION['password'])) {
    header('location: ../login.php');
  }

  // PHP validation of form data.
  global $fname, $lname;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $php_check = new validate();
    $php_check->validate_First_Name($_POST['fname']);
    $php_check->validate_Last_Name($_POST['lname']);
    //$php_check->validate_Email($_POST['email']);
    //$php_check->validate_Phone($_POST['phone']);
    //$email_api = $php_check->validateEmail($_POST['email']);
    $fname_error = $php_check->fname_error;
    $lname_error = $php_check->lname_error;
  }
  $full_name = $fname . ' ' . $lname;

  ?>

  <div class="nav">
    <div class="top">
      <ul class="unorder-list">
        <li class="list-item">
          <a href="">
            <img src="../logo.jpg" alt="" height="50" width="50">
          </a>
        </li>
      </ul>

      <ul class="unorder-list">
        <li class="list-item">
          <a class="list-item-link" href="../Assignment-1/index.php">Assignment1</a>
        </li>
        <li class="list-item">
          <a class="list-item-link" href="../Assignment-2/index.php">Assignment2</a>
        </li>
        <li class="list-item">
          <a class="list-item-link" href="../Assignment-3/index.php">Assignment3</a>
        </li>
        <li class="list-item">
          <a class="list-item-link" href="../Assignment-4/index.php">Assignment4</a>
        </li>
        <li class="list-item">
          <a class="list-item-link" href="../Assignment-5/index.php">Assignment5</a>
        </li>
        <li class="list-item">
          <a class="list-item-link" href="../Assignment-6/index.php">Assignment6</a>
        </li>
        <li class="list-item">
          <a class="list-item-link" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>

  <div class="centre">
    <div class="design1">
      <div class="form-all">
        <div style="text-align:center;">
          <h3>Assignment 1</h3>
        </div>
        <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
          First Name: <input id="fname" class="box" type="text" name="fname" value="<?php echo $fname; ?>" required onblur="validateFirstName()" onkeyup="getFullName()">
          <span id="checkfname" class="error"></span>
          <br><br>
          Last Name: <input id="lname" class="box" type="text" name="lname" value="<?php echo $lname; ?>" required onblur="validateLastName()" onkeyup="getFullName()">
          <span id="checklname" class="error"></span>
          <br><br>
          Full Name: <input id="full_name" class="box" type="text" name="full_name" readonly value="<?php echo $full_name; ?>">
          <br>
          <br>
          <div class="form-inner ">
            <input id="submit" class="submit" type="submit">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="output">
    <div class="output-content">
      <?php
      $full_name = $fname . " " . $lname;
      echo "<h2 >Hello $full_name &#128075</h2>";
      ?>
    </div>
  </div>
</body>
</html>
