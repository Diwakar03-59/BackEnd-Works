<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "Users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
/*
$sql = "create table First (
  id int(10) auto_increment primary key,
  name varchar(256) not null
  )"; */
$user = 'diwakar.sah@innoraft.com';
$pass = 'bnm';
$sql = "select * from user_data where username = '$user' and password = '$pass'";

//$sql = "select * from First limit 4";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["name"] . "<br>";
  }
} 
else {
  echo "0 results";
}

/*
if ($conn->query($sql) === TRUE) {
  echo "Table MyGuests created successfully";
} else {
  echo "Error creating table: " . $conn->error;
} */
/*
if ($conn->multi_query($ins) === TRUE) {
  echo "Data inserted successfully" ."<br>";
  echo $conn->insert_id;
} else {
  echo "Error inserting data : " . $conn->error;
}
*/

$conn->close();

?>
