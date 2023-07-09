<?php 
session_start();
require_once 'php_validate.php';
require_once 'admin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    <?php
    include 'login.css';
    ?>
  </style>
  <script src="script.js?newversion"></script>
  <title>Login</title>
</head>

<body>
  <?php

  $error = '';
  $user_check = '';
  $pass_check = '';

  if (isset($_SESSION['login'])) {
    header('index.php');
  }

  // Checking if new user or not.
  if (isset($_SESSION['user'])) {
    header('location: index.php');
  }

  // Creating session variables and storing the user credentials.
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['email'];
    $pass = $_POST['password'];

    // PHP validation.
    $valid = new validate();
    $admin = new Admin();
    $user_check = $valid->validateEmail($user);
    $pass_check = $valid->validatePassword($pass);
    $_SESSION['username'] = $user;
    $_SESSION['password'] = $pass;

    if ($user_check == '' && $pass_check == '') {
      $login_status = $admin->login($user, $pass);
      if ($login_status) {
        $_SESSION['user'] = $user;
        header('location: index.php');
      } 
      else {
        $error = 'Invalid credentials';
      }
    }
  }

  ?>

  <div class="back" id="back">
  <span class='error'><?php echo $error ; ?></span>
    <div class="container">
      <div class="contents">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
          Username:
          <input type="text" class="box" id="email" name="email" required placeholder="Enter your registered email address" onblur="validateEmail()">
          <span style="color: red;">*</span>
          <br>
          <span id="checkemail" class="checkemail" style="color: red;"><?php echo $user_check; ?></span>
          <br><br>
          Password:
          <input type="password" class="box" id="password" name="password" required password placeholder="Enter your password" onblur="loginPasswordValidate()">
          <span style="color: red;">*</span>
          <br>
          <span id="checkpass" class="checkpass" style="color: red;"><?php echo $pass_check;?></span>
          <br><br>
          <span><a class="error" href="forgot.php">Forgot Password</a></span>
          <br><br>
          <div class="flex">
            <input class="login" type="submit" name="submit" id="submit" value="Login">
          </div>
          <div class="create">
            <p class="black">Don't have an account? <a class="error" href="registration.php">Create one.</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.birds.min.js"></script>
<script>
VANTA.BIRDS({
  el: "#back",
  mouseControls: true,
  touchControls: true,
  gyroControls: false,
  minHeight: 200.00,
  minWidth: 200.00,
  scale: 1.00,
  scaleMobile: 1.00,
  backgroundColor: 0x97b6dc,
  quantity: 4.00
})
</script>

</html>
