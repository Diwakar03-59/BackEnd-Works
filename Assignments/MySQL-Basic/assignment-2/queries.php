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
// Array to store all the MySQL queries.
$queries = [];

// Array to store all the problems.
$ques = [];

$ques1 = "WAQ to list all employee first name with salary greater than 50k.";
$ques2 = "WAQ to list all employee last name with graduation percentile greater than 70%.";
$ques3 = "WAQ to list all employee code name with graduation percentile less than 70%.";
$ques4 = "WAQ to list all employee’s full name that are not of domain Java.";
$ques5 = "WAQ to list all employee_domain with sum of it's salary.";
$ques6 = "Write the above query again but dont include salaries which is less than 30k.";
$ques7 = "WAQ to list all employee id which has not been assigned employee code.";

$q1 = "select employee_first_name from employee_details inner join employee_salary on
employee_details.employee_id = employee_salary.employee_id where
employee_salary.employee_salary >'50k';"; 

$q2 =  "select employee_last_name from employee_details where graduation_percentile > '70%';";

$q3 = "select employee_code_name from employee_code inner join employee_salary on
employee_code.employee_code = employee_salary.employee_code inner join employee_details on
employee_salary.employee_id = employee_details.employee_id where graduation_percentile <
'70%';";

$q4 = "select concat(employee_first_name, ' ', employee_last_name) as Full_Name from employee_details inner join employee_salary on
employee_details.employee_id = employee_salary.employee_id inner join employee_code on
employee_code.employee_code = employee_salary.employee_code where domain not
like 'Java';";

$q5 = "select sum(employee_salary), domain from employee_salary inner 
join employee_code on employee_salary.employee_code = employee_code.employee_code
group by domain;";

$q6 = "select sum(employee_salary), domain from employee_salary inner join employee_code
on employee_salary.employee_code = employee_code.employee_code where employee_salary >
'30k' group by domain;";

$q7 = "select employee_id from employee_salary where employee_code is null;";

// Adding all the queries to $queries array.
$queries['1'] = $q1;
$queries['2'] = $q2;
$queries['3'] = $q3;
$queries['4'] = $q4;
$queries['5'] = $q5;
$queries['6'] = $q6;
$queries['7'] = $q7;

// Adding all the questions to $ques array.
$ques['1'] = $ques1;
$ques['2'] = $ques2;
$ques['3'] = $ques3;
$ques['4'] = $ques4;
$ques['5'] = $ques5;
$ques['6'] = $ques6;
$ques['7'] = $ques7;

$k = 1;
while ($k <= 7) {
  echo $ques[$k] . "<br>";
  foreach($conn->query($queries[$k]) as $result) {
    foreach($result as $res) {
      echo $res . "<br>";
    }
  }
  $k += 1;
  echo "<br>";
}

?>
