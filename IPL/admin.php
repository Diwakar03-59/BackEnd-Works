<?php
require_once 'dbconnect.php';

/**
 * Class to handle the working of the admin.
 * 
 * @var $obj 
 *    Stored the object of the dbconnect class.
 * 
 * @var $conn
 *    Stores the mysqli connection object rto connect to the database.
 * 
 */ 
class Admin {
  public $obj = '';
  public $conn = '';

  public function __construct() {
    $this->obj = new DbConnect();
    $this->conn = $this->obj->connect();
  }

  /**
   * This function validates whether the user is registered or not and 
   * implements login functionality.
   * 
   * @param [str] $user - This is the email entered by the user.
   * @param [str] $pass - This is the password entered by the user.
   * 
   * @return bool
   *    Returns TRUE if the user exists otherwise returns FALSE
   */
  public function login($user, $pass) {
    $sql = "select * from user_data where username = '$user' and 
    password = '$pass'";
    $result = mysqli_query($this->conn, $sql);
    if (mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
      if ($row['username'] === $user && $row['password'] === $pass) {
        return TRUE;
      }
      else {
        return FALSE;
      }
    }
    return FALSE;
  }

  /**
   * Function to add Player to the database.
   * 
   * @param array $data
   *    Stores the details of the player to be added.
   * 
   * @return bool
   *    Returns TRUE if the player id added successfully, otherwise returns 
   *    FALSE.
   */
  public function addPlayer(array $data) {
    $name = $data['name'];
    $score = $data['score'];
    $balls = $data['balls'];
    $strike_rate = ($score / $balls) * 100;
    $query = "insert into Score(name, runs, balls, strike_rate) values('$name', 
              '$score', '$balls', '$strike_rate')";
    $add_player = $this->conn->query($query);
    if($add_player) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to fetch all the players data from the database.
   *
   * @return mixed
   *    Returns the details of the players from the database, if exists 
   *    otherwise returns FALSE.
   */
  public function getPlayers() {
    $query = "select * from Score";
    $players = $this->conn->query($query);
    $player_data = [];
    if($players) {
      foreach($players as $player) {
        $player_data[] = $player;
      }
      return $player_data;
    }
    return FALSE;
  }

  /**
   * Function to delete the player from the database based on id.
   *
   * @param integer $id
   *    Stores the id of the player to be deleted.
   * 
   * @return bool
   */
  public function deletePlayer(int $id) {
    $query = "delete from Score where id = '$id'";
    $delete = $this->conn->query($query);
    if($delete) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to update the details of the player already present in the 
   * database.
   *
   * @param array $data
   *    Stores the updated data of the player.
   * @return bool
   */
  public function updatePlayer(array $data) {
    $name = $data['name'];
    $id = $data['id'];
    $runs = $data['runs'];
    $balls = $data['balls'];
    $strike_rate = ($runs / $balls) * 100;
    $sql = "update Score set name = '$name', runs = '$runs', balls = '$balls', 
            strike_rate = '$strike_rate'";
    $update = $this->conn->query($sql);
    if($update) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to return the man of the match of the game, based on the player
   * with highest strike rate.
   *
   * @return mixed
   */
  public function getMan() {
    $query = "select name from Score WHERE strike_rate=(select max(strike_rate) from Score)";
    $man = $this->conn->query($query);
    if($man) {
      return $man;
    }
    return FALSE;
  }
}
