<?php session_start();

  //destroying the session on logout and redirecting to login page.
  if(isset($_SESSION['password'])){
      session_unset();
      session_destroy();
      header('location: login.php');
  }

?>
