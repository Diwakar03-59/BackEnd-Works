<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    <?php include '../Assignment-4/index.css'; ?>
  </style>
  <script src="../script.js"></script>
</head>

<body>
  <div class="centre profile">
    <div class="design container form-border">
      <div class="form-all">
        <h3>PHP Advance Assignment 2</h3>
        <form class="form" action="upload.php" method="post">
          <span class="form-data-head">Email ID:</span>
          <input id="email" class="box" type="text" name="email" value="" required onblur="validateEmail()">
          <span id="checkemail" class="error"></span>
          <div class="form-inner ">
            <input id="submit" class="submit" type="submit">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
