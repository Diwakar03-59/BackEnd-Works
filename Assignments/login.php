<?php session_start();
include 'php_validate.php';
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

  if (isset($_SESSION['login'])) {
    header('location:Assignment-4/index.php');
  }

  // Checking if new user or not.
  if (isset($_SESSION['log']) && $_SESSION['log']) {
    unset($_SESSION['log']);
    echo "<script>
    alert('Account Created!! Please Login');
    </script>";
  }

  // Creating session variables and storing the user credentials.
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['email'];
    $pass = $_POST['password'];

    // PHP validation.
    $valid = new validate();
    $user = $valid->test_input($user);
    $pass = $valid->test_input($pass);
    $_SESSION['username'] = $user;
    $_SESSION['password'] = $pass;

    if (!empty($_POST['password'])) {
      $login_status = $valid->login($user, $pass);
      if ($login_status) {
        echo $login_status;
        $_SESSION['login'] = TRUE;
        header('location:Assignment-4/index.php');
      } 
      else {
        echo "<span class='error'>Invalid Credentials</span>";
      }
    }
  }

  ?>

  <div class="back" id="back">
    <div class="container">
      <div class="contents">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
          Username:
          <input type="text" class="box" id="email" name="email" required placeholder="Enter your registered email address" onblur="validateEmail()">
          <span style="color: red;">*</span>
          <br>
          <span id="checkemail" class="checkemail" style="color: red;"></span>
          <br><br>
          Password:
          <input type="password" class="box" id="password" name="password" required password placeholder="Enter your password" onblur="loginPasswordValidate()">
          <span style="color: red;">*</span>
          <br>
          <span id="checkpass" class="checkpass" style="color: red;"></span>
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
