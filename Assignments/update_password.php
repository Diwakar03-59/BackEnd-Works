<?php 
session_start();

if (!isset($_SESSION['username'])) {
  header('location: ../login.php');
}

include 'dbconnect.php';
if(isset($_SESSION['user'])){
  $user = $_SESSION['user'];
  if (!empty($_POST['password'])) {
    if ($_POST['password'] == $_POST['cpassword']) {
      $pass = $_POST['password'];
    }
    $sql = "select * from user_data where username = '$user'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num >= 1) {
      $update = "update user_data set password = '$pass' where username = '$user'";
      $result2 = mysqli_query($conn, $update); 
      session_unset();
      echo "<script>alert('Paswword reset successful. Kindly Login.')</script>";
      header('location:login.php');
    }
    else {
      echo "user does not exist!";
      header('locaton:registration.php');
    }
  }
}

?>
