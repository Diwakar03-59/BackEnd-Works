<?php 
  session_start();
  if (!isset($_SESSION['password'])) {
    header('location:login.php');
  }
  if (isset($_GET['q'])) {
    $page = $_GET['q'];
    header('location: Assignment-'.$page.'/index.php');
    /*
    if ($_GET['q'] == 1) {
      header('location: Assignment-1/index.php');
    }
    elseif ($_GET['q'] == 2) {
      header('location: Assignment-2/index.php');
    }
    elseif ($_GET['q'] == 3) {
      header('location: Assignment-3/index.php');
    }
    elseif ($_GET['q'] == 4) {
      header('location: Assignment-4/index.php');
    }
    elseif ($_GET['q'] == 5) {
      header('location: Assignment-5/index.php');
    }
    elseif ($_GET['q'] == 6) {
      header('location: Assignment-6/index.php');
    }*/
  }
  
?>
<style>
  <?php include 'index.css' ?>
  <?php include 'Assignment-4/index.css'?>
</style> 

<div class="nav centre">
    <div class="design top">
      <ul class="unorder-list">
        <li class="list-item">
          <a href="index.php">
            <img src="logo.jpg" alt="" height="50" width="50">
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

  <div class="centre nav">
    <div class="design top">
      <h2 class="welcome">Welcome to PHP Assignments!!</h2>
    </div>
    <div class="design top">
    <button class="login">
        <a href="login.php">Login</a>
      </button>
    </div>
  </div>
