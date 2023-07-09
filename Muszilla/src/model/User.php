<?php 

namespace App\model;

use App\Controller\HomeController;
use App\model\DbConnect;

/**
 * User class handles all the interaction with the database regarding the User 
 * entity.
 * 
 * @var object $obj 
 *    Object to create an object of the DbConnect which helps in connection to
 *    the database.
 * 
 * @var object $conn
 *    Object to store the mysqli connection to the database.
 * 
 */
class User {
  private $obj = '';
  private $conn = '';

  /**
   * Constructor to initialize the the mysli connection object which helps in 
   * interacting with the database.
   */
  public function __construct() {
    $this->obj = new DbConnect();
    $this->conn = $this->obj->connect();
  }

  /**
   * Function to handle the registration of the user. It checks whether the user
   * is already registered or not, if not it registers the user and updates the 
   * database.
   *
   * @param array $data 
   *    Array to store the data of the user that needs to be registered. 
   * 
   * @param mixed $img
   *    Stores the profile image of the user.
   * 
   * @return bool 
   *    Returns TRUE if the user regitration is successful, otherwise returns 
   *    FALSE.
   */
  public function register(mixed $data, mixed $img) {
    $name = $data['fname'];
    $email = $data['email'];
    $contact = $data['contact'];
    $interest = $this->genreString($data['genre']);
    $pass = $data['password'];
    $image = $img;
    $userexist = $this->userExist($email);
    $create = "create table if not exists Users(id int(10) auto_increment 
              primary key, name varchar(100) not null, email varchar(100) 
              not null, contact varchar(20) not null, interest varchar(100) 
              not null, image varchar(400), password varchar(40) not null)";

    $query1 = $this->conn->query($create);
    if(!$userexist) {
      $insert = "insert into Users (name, email, contact, interest, image, 
              password) values('$name', '$email', '$contact', '$interest', 
              '$image', '$pass')";
      $query2 = $this->conn->query($insert);
    }
    if($query2) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to check whether a user with the particular email exists or not.
   *
   * @param string $email
   *    Stores the email of the user to checked, whether registered or not.
   *  
   * @return bool 
   *    Returns TRUE if the user is already registered, otherwise returns FALSE.
   */
  public function userExist(string $email) {
    $user = $this->getUserData($email);
    if($user) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Handles the login of the registered user to the app.
   *
   * @param array $data
   *    Stores the credentials entered by the user to login.
   * 
   * @return bool
   *    Returns TRUE if the user exists and the credentials are correct.
   */
  public function login(array $data) {
    $email = $data['email'];
    $pass = $data['password'];
    $user_exist = "select * from Users where email = '$email' and password = '$pass'";
    $query = $this->conn->query($user_exist);
    print_r($query->num_rows);
    if($query->num_rows) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to fetch the user data based on the email.
   *
   * @param [string] $email
   *    Stores the email of the usedr whose data is to be fetched.
   *  
   * @return mixed
   */
  public function getUserData(string $email) {
    $user_data = "select * from Users where email = '$email'";
    $query = $this->conn->query($user_data);
    if($query->num_rows >= 1) {
      return $query->fetch_array();
    }
    return FALSE;
  }

  /**
   * Function to add music to the database. The function takes in the details 
   * of the music file to be added and adds it to the music database.
   *
   * @param array $data
   *    Stores the details of the song to be added.
   * 
   * @param mixed $music
   *    Stores the music file to be added.
   * 
   * @param mixed $cover
   *    Stores the cover image of the music file.
   * 
   * @return bool
   *    Returns TRUE if the music is added successfully, otherwise FALSE.
   */
  public function addMusic(array $data, mixed $music, mixed $cover) {
    $music_name = $data['music-name'];
    $music_cover = $cover;
    $music_singer = $data['singer'];
    $genre = $this->genreString($data['genre']);
    $add_music = "insert into Music (name, singer, cover, music, genre) values('$music_name', 
                  '$music_singer', '$music_cover', '$music', '$genre')";
    $query = $this->conn->query($add_music);
    if($query) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to handle the updation of Profile of the user and update the 
   * database accordingly.
   *
   * @param array $data
   *    Stores the updated data of the user.
   * 
   * @param string $email
   *    Stores the previous email of the user, which is already available in 
   *    the databses.
   * 
   * @return bool 
   *    Returns TRUE if the profile is updated successfully, otherwise FALSE.
   */
  public function updateProfile(array $data, string $email) {
    $contact = $data['contact'];
    $email_update = $data['email'];
    $genre = $this->genreString($data['interest']);
    $sql = "update Users set email = '$email_update', contact = '$contact', 
            interest = '$genre' where email = '$email'";
    $query = $this->conn->query($sql);
    if($query) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Function to generate a string of the user interest, to make it easier to
   * store in the database.
   *
   * @param array $genreArr
   *    Stores the interests of the user in an array.
   * 
   * @return string 
   *    Returns the a string containing user inyterests separated with space. 
   */
  public function genreString(array $genreArr) {
    $genre = "";
    foreach($genreArr as $checked) {
      $genre .= $checked . ' ';
    }
    return $genre;
  }
}
