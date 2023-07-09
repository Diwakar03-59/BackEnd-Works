<?php

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "IPL";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Created Teams Table.
/*
$sql = "create table Teams (
  Name varchar(30) Primary Key,
  Captain varchar(30) not null
)";
*/
/*
$sql = "create table match_result (
  match_ID int ,
  captain_of_team1 varchar(30) not null,
  captain_of_team2 varchar(30) not null,
  toss_won_by varchar(30) not null,
  match_won_by varchar(30) not null,
  foreign key (match_ID) references Fixtures(match_ID)

)";
*/



if ($conn->query($sql) === TRUE) {
  echo "Created table match_results.";
}
else {
  echo "Error " . $conn->error;
}

$conn->close();

?>