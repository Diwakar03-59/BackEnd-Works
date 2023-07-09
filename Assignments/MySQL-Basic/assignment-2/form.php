<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MySQL 2</title>
  <style> 
    <?php include "style.css"; ?>
  </style>
</head>

<body>
  <div class="back">
    <div class="container">
      <div class="contents">
        <form action="sql.php" method="post">
          Employee ID:
          <input type="text" class="box" id="empid" name="empid" required placeholder="Enter your employee ID">
          <span style="color: red;">*</span>
          <br>
          <span id="checkemail" class="checkemail" style="color: red;"></span>
          <br><br>
          First Name:
          <input type="text" class="box" id="fname" name="fname" required placeholder="Enter your first name">
          <span style="color: red;">*</span>
          <br>
          <span id="checkemail" class="checkemail" style="color: red;"></span>
          <br><br>
          Last Name:
          <input type="text" class="box" id="lname" name="lname" required placeholder="Enter your last name">
          <span style="color: red;">*</span>
          <br>
          <span id="checkemail" class="checkemail" style="color: red;"></span>
          <br><br>
          Graduation Percentile:
          <input type="text" class="box" id="percentage" name="percentage" required placeholder="Enter your graduation percentile">
          <span style="color: red;">*</span>
          <br>
          <span id="checkemail" class="checkemail" style="color: red;"></span>
          <br><br>
          Salary:
          <input type="text" class="box" id="salary" name="salary" required placeholder="Enter your Salary">
          <span style="color: red;">*</span>
          <br>
          <span id="checkemail" class="checkemail" style="color: red;"></span>
          <br><br>
          Domain:
          <input type="text" class="box" id="domain" name="domain" required placeholder="Enter your Domain">
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
