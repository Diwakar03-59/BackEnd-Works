<?php 

namespace App\model;

use App\Controller\HomeController;
use App\model\DbConnect;

/**
 * Class to handle all the database interaction regarding the music stored in
 * the database.
 * 
 * @var object $obj 
 *    Stores an object of the DbConnect class.
 * 
 * @var object $conn
 *    Stores the mysli connection object which helps in interacting with the 
 *    database.
 */
class Music {
  private $obj = '';
  private $conn = '';

  /**
   * Constructor to initialize the mysli connection object which helps in 
   * interacting with the database.
   */
  public function __construct() {
    $this->obj = new DbConnect();
    $this->conn = $this->obj->connect();
  }
  /**
   * Function to fetch all the stored music in the database at the current time.
   *
   * @return mixed 
   *    Returns an array of music data stored in the databse, if the the database 
   *    is empty, returns FALSE.
   */
  public function getMusic() {
    $sql = "select * from Music";
    $music = $this->conn->query($sql);
    $music_data = [];
    if($music) {
      foreach($music as $m) {
        $music_data[] = $m;
      }
      return $music_data;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Function to fetch the song details based on a music id.
   *
   * @param int $id
   *    Stores the id of the song whose data is to be fetched.
   * 
   * @return mixed
   *    Returns the details of the song requested if present, otherwise returns 
   *    FALSE.
   */
  public function getMusicById(int $id) {
    $sql = "select * from Music where id = '$id'";
    $music_data = $this->conn->query($sql);
    if($music_data) {
      return $music_data->fetch_array();
    }
    else {
      return FALSE;
    }
  }
}
