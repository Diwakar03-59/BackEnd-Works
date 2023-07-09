<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
</head>

<body>

<?php 

  session_start();
  if (!isset($_SESSION['username'])) {
    header('location: ../login.php');
  }
  echo "Reset password for" . $_SESSION['username'];

?>
  <div class="back">
    <div class="container">
      <div class="contents">
        <form action="update_password.php" method="post">
          Password:
          <input type="password" class="box" id="password" name="password" required password placeholder="Enter a password">
          <span style="color: red;">*</span>
          <br><br>
          Confirm Password:
          <input type="password" class="box" id="cpassword" name="cpassword" required password placeholder="Please enter password again">
          <span style="color: red;">*</span>
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
