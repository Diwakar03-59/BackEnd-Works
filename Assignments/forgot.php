<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot PASSWORD</title>
  <style>
    <?php include 'login.css';?>
  </style>
</head>

<body>
  <div class="back">
    <div class="container">
      <div class="contents">
        <form action="reset_password.php" method="post">
          <div style="padding: 40px 0px; text-align:center">
            <h3>Kindly enter your registered email. You will recieve a link on the same to reset your password.</h3>
          </div>
          Username:
          <input type="text" class="box" id="email" name="email" required placeholder="Enter your registered email address" onblur="validateEmail()">
          <span style="color: red;">*</span>
          <br>
          <span id="checkemail" class="checkemail" style="color: red;"></span>
          <br><br>

          <div class="flex">
            <input class="login" type="submit" name="submit" id="submit" value="Submit">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
