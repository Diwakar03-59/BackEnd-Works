<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Employees";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$emp_id = $_POST['empid'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$percent = $_POST['percentage'];
$salary = $_POST['salary'];
$domain = $_POST['domain'];
$emp_code = 'su_' . strtolower($fname);

// Variables to check whether the tables exist or not.
$b =  $conn->query("show tables like 'employee_details'");
$c = $conn->query("show tables like 'employee_salary'");
$d = $conn->query("show tables like 'employee_code'");

// Updating the employee_code_name according to the employee_id.
$i = strtolower(substr($emp_id, strlen($emp_id) - 1, strlen($emp_id)));
if ($i%2 === 0) {
  $emp_code_name = 'ru_' . strtolower($fname);
  echo $i;
} 
else {
  $emp_code_name = strtolower(substr($_POST['fname'], 0, 1)) . 'u_' . strtolower($fname);
  echo $i;
}

$create = "create table employee_details (
  employee_id varchar(10) primary key,
  employee_first_name varchar(50) not null,
  employee_last_name varchar(50) not null,
  graduation_percentile varchar(10) not null
  )";

$create2 = "create table employee_salary (
  employee_id varchar(10),
  employee_salary varchar(50) not null,
  employee_code varchar(50) primary key,
  foreign key(employee_id) references employee_details(employee_id)
  )";

$create3 = "create table employee_code (
  employee_code varchar(50),
  employee_code_name varchar(50) not null,
  domain varchar(50) not null
  )";

$insert = "insert into employee_details 
  values('$emp_id', '$fname', '$lname', '$percent')";

$insert2 = "insert into employee_salary 
values('$emp_id', '$salary', '$emp_code')";

$insert3 = "insert into employee_code 
values('$emp_code', '$emp_code_name', '$domain')";

// Checking if tables exist or not, if exist then inserting the data. 
if ($b->num_rows > 0 && $c->num_rows > 0 && $d->num_rows > 0) {
  if (($conn->query($insert) === TRUE)
    && ($conn->query($insert2) === TRUE)
    && ($conn->query($insert3) === TRUE)
  ) {
    echo 'Data inserted!';
  }
} 

// Checking if tables exist or not, if not creating one and inserting the data.
else {
  if (($conn->query($create) === TRUE)
    && ($conn->query($create2) === TRUE)
    && ($conn->query($create3) === TRUE)) {
    if (($conn->query($insert) === TRUE) && ($conn->query($insert2) === TRUE) && ($conn->query($insert3) === TRUE)) {
      echo 'Tables created! <br>';
      echo 'Data inserted!';
    }
  }
}

$conn->close();

?>
