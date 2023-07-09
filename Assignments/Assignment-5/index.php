<?php session_start();?>
<?php require '../php_validate.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <link rel="stylesheet" href="index.css" type="text/css">
  <style>
    <?php include '../Assignment-4/index.css'; ?>
  </style>
  <script src="../script.js"></script>
  <title>Assignment-5</title>

</head>
<body>
  <?php
  // Validaing if the user is logged in or not.
  if (!isset($_SESSION['password'])) {
    header('location: ../login.php');
  }
  global $fname, $lname, $full_name;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check = new validate();
    $fname = $check->fname;
    $lname = $check->lname;
    $full_name = $fname . ' ' . $lname;
  }
  ?>

  <div class="nav centre">
    <div class="design top">
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

  <div class="centre profile">
    <div class="design container form-border">
      <div class="form-all">
        <h3>Assignment 5</h3>

        <form class="form" action="upload.php" method="post" enctype="multipart/form-data">
          <span class="form-data-head">First Name: </span>
          <input id="fname" class="box" type="text" name="fname" value="<?php echo $fname; ?>" required onblur="validateFirstName()" onkeyup="getFullName()">
          <span id="checkfname" class="error"></span>
          <br><br>
          <span class="form-data-head">Last Name:</span>
          <input id="lname" class="box" type="text" name="lname" value="<?php echo $lname; ?>" required onblur="validateLastName()" onkeyup="getFullName()">
          <span id="checklname" class="error"></span>
          <br><br>
          <span class="form-data-head">Full Name:</span>
          <input id="full_name" class="box" type="text" name="full_name" readonly value="<?php echo $full_name; ?>">
          <span id="checkfname" class="error"></span>
          <br>
          <br>
          <span class="form-data-head">Email ID:</span>
          <input id="email" class="box" type="text" name="email" value="" required onblur="validateEmail()">
          <span id="checkemail" class="error"></span>
          <br><br>
          <span class="form-data-head">Phone Number:</span>
          <input id="phone" class="box" type="text" name="phone" value="" required onblur="validatePhone()">
          <span id="checkphone" class="error"></span>
          <br><br>
          <span class="form-data-head">Your Image:</span>
          <input type="file" class="box" name="fileToUpload" id="fileToUpload">
          <span id="checkphone" class="error"></span>
          <br>
          <div class="flex">
            <div class="align-centre">
              <span class="form-data-head">Your Marks:</span>
              <textarea class="box marks-box" name="marks" id="marks" rows="5" cols="40" required></textarea>
            </div>
          </div>

          <div class="form-inner ">
            <input id="submit" class="submit" type="submit">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
