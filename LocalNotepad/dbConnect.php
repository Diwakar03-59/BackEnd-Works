<?php
/**
 * Class tohandle all types of creation, insertion, updation, deletion 
 * of data into the Database.
 */
class dbConnect {

  /**
   * Function to connect to the database based on the paramaters given and 
   * returns a mysqli object to perfrom CRUD operation on the database.
   *
   * @return object
   */
  public function connect() {
    $servername = "localhost";
    $username = "root";
    $password = "password";
    $dbname = "Test_PHP";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
  }

  /**
   * Function to select all the available slots for the current day.
   * 
   * @var bool $result -
   *    Returns True or False based on whether the query 
   *    to the DB was succesful or not.
   *
   * @return array
   */
  public function getSlotsAvailable() {
    $conn = $this->connect();
    $query = "select * from Slots";
    $result = $conn->query($query);
    $slots = [];
    if($result) {
      foreach($result as $r) {
        $slots = $r;
      }
    }
    return $slots;
  }

  /**
   * Function to select all the tickets booked for the current day.
   * 
   * @var bool $result -
   *    Returns True or False based on whether the query 
   *    to the DB was succesful or not.
   * @var array $tickets -
   *    Stores the details of all the tickets/ parking slots 
   *    booked for the day.
   *
   * @return mixed
   */
  public function getTickets() {
    $conn = $this->connect();
    $query = "select * from Tickets";
    $result = $conn->query($query);
    $tickets = [];

    if($result->num_rows > 0) {
      foreach($result as $ticket) {
        $tickets[] = $ticket;
      }
      return $tickets;
    }
    else {
      return NULL;
    }
  }

  /**
   * Function to return all the previously booked slots today that are now
   * available for booking. 
   *
   * @var bool $result -
   *    Returns True or False based on whether the query 
   *    to the DB was succesful or not.
   * 
   * @return mixed - 
   *    returns an array of available slots if available, or NULL.
   */
  public function getUnoccupiedSlots() {
    $conn = $this->connect();
    $query = "select slot_id from Tickets where status = 'Available'";
    $result = $conn->query($query);
    $available_slot = [];

    if($result->num_rows >= 1) {
      foreach($result as $r) {
        $available_slot[] = $r;
      }
      return $available_slot;
    }
    else {
      return NULL;
    }
  }

  /**
   * Function to check if a previously booked slot is available for booking,
   * and book a slot for the same, if available.
   *
   * @param [array] $data -
   *    Contains the details about the vehicle to be parked.
   * @param [int] $id - 
   *    Contains the avialable slot id at which the vehicle is to be parked.
   * 
   * @return bool
   */
  public function bookUnoccupiedSlot($data, $id) {
    $vehicle_type = $data['vehicletype'];
    print_r($data);
    $id = $id['slot_id'];
    $vehicle_number = $data['vehiclenumber']; 
    $status = 'Occupied';
    $conn = $this->connect();
    $query = "update Tickets set vehicle_number = '$vehicle_number', 
              entry_time = NOW(), exit_time = NULL, status = '$status', 
              vehicle_type = '$vehicle_type' where slot_id = '$id'";
    $res = $conn->query($query);
    if($res) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * Function to find all the slot id which are currently occupied.
   *
   * @return array
   */
  public function getBookedSlots() {
    $conn = $this->connect();
    $query = "select slot_id from Tickets where status = 'Occupied'";
    $result = $conn->query($query);
    $booked_slots = [];
    foreach($result as $booked_slot) {
      $booked_slots[] = $booked_slot; 
    }
    return $booked_slots;
  }

  /**
   * Function to release a previously parked vehicle and update the slot status.
   *
   * @param [int] $id - 
   *    Slot id of the vehicle to be released.
   * 
   * @return bool
   */
  public function releaseSlot($id) {
    $conn = $this->connect();
    $query1 = "select entry_time from Tickets where slot_id = '$id'";
    $entry_time = $conn->query($query1)->fetch_array();
    $entry_time = $entry_time['entry_time'];
    $query2 = "update Tickets set exit_time = NOW(), status = 'Available' 
              where slot_id = '$id'";
    $result = $conn->query($query2);
    if($result) {
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

  /**
   * Updates the number of available slots of the vehicles of both types.
   *
   * @param [mixed] $vehicle_type -
   *    Stores the type of vehicle which booked a slot in the parking area
   *    or was released from the parking area.
   * @param [mixed] $updated_slots - 
   *    Stores the current number of slots available after the operation.
   * 
   * @return void
   */
  public function updateSlots($vehicle_type, $updated_slots) {
    $conn = $this->connect();
    if($vehicle_type == '2_wheeler') {
      $query = "update Slots set 2_wheeler = '$updated_slots'";
      $res = $conn->query($query);
    }
    else {
      $query = "update Slots set 4_wheeler = '$updated_slots'";
      $res = $conn->query($query);
    }
  }

  /**
   * Function to provide the details of a parked vehicle based on the slot id.
   *
   * @param [int] $id - 
   *    Stores the slot id of the vehicle whose details are needed.
   * 
   * @return array -
   *    Returns the data of the vehicle based on the id as an array.
   */
  public function getSlotDetail($id) {
    $conn = $this->connect();
    $query = "select * from Tickets where slot_id = '$id'";
    $data = $conn->query($query)->fetch_array();
    return $data;
  }

  /**
   * Function to book a slot if no previously booked slots are available for booking.
   * It takes in the data of the vehicle and bookes a new slot accordingly.
   *
   * @param [array] $data - 
   *    Stores the data of the vehicle to be parked.
   * 
   * @return bool - 
   *    Returns TRUE if the vehicle is parked successfully. 
   */
  public function bookSlot($data) {
    $vehicle_type = $data['vehicletype'];
    $vehicle_number = $data['vehiclenumber'];
    $status = 'Occupied';
    $conn = $this->connect();
    $query = "insert into Tickets( vehicle_number, 
    entry_time, status, vehicle_type) values ('$vehicle_number', NOW(), '$status', '$vehicle_type')";
    $res = $conn->query($query);
    if($res) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

}

?>
