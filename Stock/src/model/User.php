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
   * @return bool 
   *    Returns TRUE if the user regitration is successful, otherwise returns 
   *    FALSE.
   */
  public function register(mixed $data) {
    $name = $data['fname'];
    $email = $data['email'];
    $pass = $data['password'];
    $userexist = $this->userExist($email);
    $create = "create table if not exists Users(id int(10) auto_increment 
              primary key, name varchar(100) not null, email varchar(100) 
              not null, password varchar(80) not null)";

    $query1 = $this->conn->query($create);
    if(!$userexist) {
      $insert = "insert into Users (name, email, password) values('$name', 
                '$email', '$pass')";
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
    $user_exist = "select * from Users where email = '$email' and 
                  password = '$pass'";
    $query = $this->conn->query($user_exist);
    if($query->num_rows) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to udate the stocks added earlier by the user.
   *
   * @param array $data
   *    Stores the data of the stock to be updated.
   * 
   * @return bool
   *    Returns TRUE if the stock details ius updated successfully.
   */
  public function updateStock(array $data) {
    $name = $data['name'];
    $id = $data['id'];
    $price = $data['price'];
    $query = "update Stocks set name = '$name', price = '$price', updated = CURRENT_DATE() where id = '$id'";
    $update = $this->conn->query($query);
    if ($update) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to fetch the user data based on the email.
   *
   * @param string $email
   *    Stores the email of the usedr whose data is to be fetched.
   *  
   * @return mixed
   *    Returns an with user data, if a user exists with the current email
   *    otherwise returns error.
   */
  public function getUserData(string $email) {
    $user_data = "select * from Users where email = '$email'";
    $query = $this->conn->query($user_data);
    if($query->num_rows >= 1) {
      return $query->fetch_array();
    }
    return FALSE;
  }

}
