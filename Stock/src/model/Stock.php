<?php 

namespace App\model;

use App\Controller\HomeController;
use App\model\DbConnect;

/**
 * Class to handle all the database interaction regarding the Stocks stored in
 * the database.
 * 
 * @var object $obj 
 *    Stores an object of the DbConnect class.
 * 
 * @var object $conn
 *    Stores the mysli connection object which helps in interacting with the 
 *    database.
 */
class Stock {
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
   * Function to fetch all the stored Stock in the database at the current time.
   *
   * @return mixed 
   *    Returns an array of stocks data stored in the databse, 
   *    if the the database is empty, returns FALSE.
   */
  public function getStocks() {
    $sql = "select * from Stocks";
    $stocks = $this->conn->query($sql);
    $stocks_data = [];
    if($stocks) {
      foreach($stocks as $stock) {
        $stocks_data[] = $stock;
      }
      return $stocks_data;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Functuion to add a new stock to the database.
   *
   * @param array $data
   *    Stores the details of the stock to be added.
   * 
   * @param string $email
   *    Stores the email of the user who added the current stock.
   * 
   * @return bool
   *    Returns TRUE if the stock is added succesfully in the database, 
   *    otherwise returns FALSE.
   */
  public function addStock(array $data, string $email) {
    $name = $data['stock-name'];
    $price = $data['price'];
    $query = "insert into Stocks(name, price, created, created_by) 
              values('$name', '$price', CURRENT_DATE(), '$email')";
    $add = $this->conn->query($query);
    if($add) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to remove a previously added stock from the Stocks database.
   *
   * @param integer $id
   *    Stores the id of the stock to be removed.
   * 
   * @return bool
   *    Returns TRUE if the deletion of the stock is successful otherwise, 
   *    returns FALSE.
   */
  public function removeStock(int $id) {
    $query = "delete from Stocks where id = '$id'";
    $remove = $this->conn->query($query);
    if($remove) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to fetch the stock details based on a stoock id.
   *
   * @param string $user
   *    Stores the email of the user whose stocks is to be fetched.
   * 
   * @return mixed
   *    Returns the details of the stock requested if present, otherwise returns 
   *    FALSE.
   */
  public function getStockByUser(string $user) {
    $sql = "select name from Stocks where created_by = '$user'";
    $stock_data = $this->conn->query($sql);
    if($stock_data) {
      return $stock_data->fetch_array();
    }
    else {
      return FALSE;
    }
  }

  /**
   * Function to fetch all the previously added stocks of the user based 
   * on the email of the user.
   *
   * @param string $email
   *    Stores the email id of the user whose stocks addition details are to 
   *    be fetched.
   * 
   * @return mixed
   *    Returns the stocks details  as an array, if the user has added stocks
   *    previously.
   */
  public function getStockDetailsByEmail(string $email) {
    $sql = "select * from Stocks where created_by = '$email'";
    $stock_data = $this->conn->query($sql);
    $stocks = [];
    if($stock_data) {
      foreach($stock_data as $stock) {
        $stocks[] = $stock;
      }
      return $stocks;
    }
    else {
      return FALSE;
    }
  }
}
