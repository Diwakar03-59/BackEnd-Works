<?php

namespace App\model;

use App\Controller\HomeController;
use mysqli;

/**
 * This class contains all the functions to ineteract with the Database.
 */
class dbConnect extends HomeController{

  /**
   * Connection to the Database
   *
   * @return object
   */
  public function connect() {
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "Notepad";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
  }

  /**
   * Get all the slot details for the day.
   *
   * @return array
   */
  public function getSlotsAvailable() {
    $conn = $this->connect();
    $sql1 = "select two_wheeler, four_wheeler from Slots";
    $res = $conn->query($sql1);
    $slots = [];
    if($res) { 
      foreach ($res as $r) {
        $slots = $r;
      }
    }
    return $slots;
  }

  /**
   * To get the current date and time.
   *
   * @return object
   */
  public function getCurrentStatus() {
    $sql = "select NOW()";
    $conn = $this->connect();
    $res = $conn->query($sql);
    return $res;
  }

  /**
   * Get all the tickets details
   *
   * @return array
   */
  public function getTickets() {
    $conn = $this->connect();
    $sql = 'select * from Tickets order by slot_id desc';
    $res = $conn->query($sql);

    $tickets = [];
    foreach($res as $r) {
      $tickets[] = $r;
    }

    return $tickets;
  }

  /**
   * To book a parking slot based on the user given data.
   *
   * @param [array] $data - Post data of the user(vehicle type and vehicle number.)
   * @return string
   */
  public function park($data) {
    $conn = $this->connect();
    $vehicle_number = $data['vehiclenumber'];
    $vehicle_type = $data['vehicletype'];
    $current_slots = $this->getSlotsAvailable();
    $entry_time = $this->getCurrentStatus();
    $entry_time = $entry_time->fetch_array();
    $entry_time = $entry_time['0'];
    $sql = "insert into Tickets(vehicle_type, vehicle_number, 
    entry_time) values ( '$vehicle_type', '$vehicle_number', '$entry_time' )";
    $insert = $conn->query($sql);
    if ($insert) {
      if($vehicle_type == '2-wheeler') {
        $status = "Occupied";
        $current_slots = $current_slots['two_wheeler'];
        $current_slots = $current_slots - 1;
        $sql = "update Slots set two_wheeler = '$current_slots'";
        $res = $conn->query($sql);
        return $status;

      }
      if($vehicle_type == '4-wheeler') {
        $status = "Occupied";
        $current_slots = $current_slots['four_wheeler'];
        $current_slots = $current_slots - 1;
        $sql = "update Slots set four_wheeler = '$current_slots'";
        $res = $conn->query($sql);
        return $status;

      }
      return FALSE;
    }
    else {
      return FALSE;
    }

  } 

  /**
   * Function to release the parking slot and mark the slot as available.
   *
   * @param [string] $slotID - Slod ID to be released.
   * @return string
   */
  public function release_parking($slotID) {
    // $slotID = $slotID;
    $current_slots = $this->getSlotsAvailable();
    $conn = $this->connect();
    $sql2 = "select * from Tickets where slot_id = '$slotID'";
    $res2 = $conn->query($sql2);
    $exit = $this->getCurrentStatus();
    $current_time = $exit->fetch_array();
    $exit = $current_time[0];
    $sql_exit = "update Tickets set exit_time = '$exit' where slot_id = '$slotID'";
    $res9 = $conn->query($sql_exit);
    $current_slot_details = $res2->fetch_assoc();
    // print_r($res9);
    // dd();

    if($current_slot_details['vehicle_type'] == '2-wheeler') {
      $current_slot = $current_slots['two_wheeler'] += 1;
      $sql = "update Slots set two_wheeler = '$current_slot'";
      $res = $conn->query($sql);
    }
    elseif($current_slot_details['vehicle_type'] == '4-wheeler') {
      $current_slot = $current_slots['four_wheeler'] += 1;
      $sql = "update Slots set four_wheeler = '$current_slot'";
      $res = $conn->query($sql);
    } 
    $status = "Occupied";
    if ($sql2) {
      $status = "Available";
      return $status;
    }
    else {
      return $status;
    }
  }

}

?>
