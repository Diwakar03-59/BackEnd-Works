<?php

namespace App\model;

use App\Controller\HomeController;
use mysqli;

class dbConnect extends HomeController {

  public function connect() {
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "Social";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
  }

  public function createTable() {
    $sql = "create table if not exists Posts (
      id int(10) primary key auto_increment,
      email varchar(100) not null,
      data varchar(2000) not  null,
      img varchar(500) not null
      )";

    $conn = $this->connect();
    $conn->query($sql);
  }

  public function addPost(array $d) {
    $conn = $this->connect();
    $email = $d['0'];
    $data = $d['1'];
    $postimg = $d['2'];

    $sql = "insert into Posts (email, data, img)
    values ('$email', '$data', '$postimg'
    )";
    $result = $conn->query($sql);
    if($result) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  public function getCurrentUser($email) {
    $conn = $this->connect();
    $sql = "select * from Users where email = '$email'";
    $res = $conn->query($sql);
    $user = [];
    foreach($res as $user) {
      $user[] = $user['fname'];
      $user[] = $user['lname'];
      $user[] = $user['email'];
      $user[] = $user['image'];
    }
    return $user;
  }


  public function getAllPosts() {
    $conn = $this->connect();
    $sql = "select distinct Posts.id, concat(fname, ' ', lname) as fullname, email, image, data, img from Users right join Posts using (email) order by Posts.id desc limit 10 " ;
    $res = $conn->query($sql);
    $posts = [];
    foreach($res as $r) {
      $posts[] = $r;
    }
    return $posts;
  }

  public function loadmore($id) {
    $conn = $this->connect();
    $limit = $id * 10;
    $id = $id * 10;
    $sql = "select distinct Posts.id, concat(fname, ' ', lname) as fullname, email, image, data, img from Users right join Posts using (email) order by Posts.id desc limit 10, $limit " ;
    $res = $conn->query($sql);
    $moreposts = [];
    foreach($res as $r) {
      $moreposts[] = $r;
    }
    return $moreposts;
  }

  public function updateProfile($data) {
    $conn = $this->connect();
    $fname = $data['0'];
    $lname = $data['1'];
    $email = $data['2'];
    $img = $data['3'];
    $sql = "update Users set fname = '$fname', lname = '$lname', email = '$email', 
    image = '$img' where email = '$email'";
    $res = $conn->query($sql);
    if ($res) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  public function signup(array $data) {
    $conn = $this->connect();
    $sql = "create table if not exists Users(
      id int(30) primary key auto_increment not null,
      fname varchar(100) not null,
      lname varchar(100) not null,
      email varchar(100) not null,
      password varchar(100) not null,
      image varchar(300) not null
      )";
    $fname = $data['0'];
    $lname = $data['1'];
    $email = $data['2'];
    $password = $data['3'];
    $image = $data['4'];

    $exist = "select * from Users where email = '$email'";

    $sql2 = "insert into Users (fname, lname, email, password, image)
    values ('$fname', '$lname', '$email', '$password', '$image')";

    $result = $conn->query($sql);
    $res = $conn->query($exist);
    if ($res->num_rows > 0) {
      return False;
    }
    else {
      $insert = $conn->query($sql2);
      return TRUE;
    }
    
  }

  public function login(array $data) {
    $conn = $this->connect();
    $email = $data['0'];
    $password = $data['1'];
    $sql = "select * from Users where email = '$email' and password = '$password'";
    $logged = $conn->query($sql);
    if ($logged->num_rows >= 1 ) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }
}

?>
