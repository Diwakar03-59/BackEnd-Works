<?php session_start();

  // Destroying the session on logout and redirecting to login page.
  if(isset($_SESSION['user'])){
      session_unset();
      session_destroy();
      header('location: index.php');
  }

  header('location: login.php');

?>
