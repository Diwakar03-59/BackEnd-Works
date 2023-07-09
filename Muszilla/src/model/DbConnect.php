<?php 

namespace App\model;

use App\Controller\HomeController;
use mysqli;

/**
 * Class to handle the connection to the database.
 * 
 * @var $servername
 *    Stores the working server name.
 * 
 * @var $username 
 *    Stores the username of the user working on the database.
 * 
 * @var $password 
 *    Stores the password of the user.
 * 
 * @var $dbname
 *    Stores the name of the database to be used. 
 */ 
class DbConnect {
  private $servername = '';
  private $username = '';
  private $password = '';
  private $dbname = '';

  /**
   * Constructor to initialize the connection varibles which are required during
   * the connection to the database.  
   */
  public function __construct() {
    $this->servername = "localhost";
    $this->username = "root";
    $this->password = "password";
    $this->dbname = "Muszilla";
  }

  /**
   * Function to handle the connection the databse according to the credentials 
   * provided.
   *
   * @return object 
   *    Returns a myslqli connection object if the connection is successful, 
   *    otherwise returns the error occured.
   */
  public function connect() {
    // Create connection
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
  }
  
}

