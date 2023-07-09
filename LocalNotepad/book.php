<?php 
require_once "dbConnect.php";

$obj = new dbConnect;

// Connection to the database.
$conn = $obj->connect();

// Stores the current number of available parking slots.
$current_slots = $obj->getSlotsAvailable();

/*
Condition to check if the booking form is filled properly 
and handles the Booking of a parking slot.
If a previously available slot is available, it gets alloted to the user,
otherwise a new slot is booked.
*/
 
if(isset($_POST['vehiclenumber']) && isset($_POST['vehicletype'])) {
  $vehicle_type = $_POST['vehicletype'];
  $vehicle_number = $_POST['vehiclenumber'];

  // Finds if there are any previously booked slot which is currently available.
  $unoccupied = $obj->getUnoccupiedSlots();

  // If there is any previously booked slot currently available then,
  // that slot is booked for the incoming vehicle otherwise a new slot is booked. 
  if(!is_null($unoccupied)) {
    $id = $unoccupied[0];
    $book = $obj->bookUnoccupiedSlot($_POST, $id);
  }
  else {
    $book = $obj->bookSlot($_POST);
  }  

  if($book) {
    if($vehicle_type == '2_wheeler') {
      $two_wheeler_slots = $current_slots['2_wheeler'];
      $two_wheeler_slots = $two_wheeler_slots - 1;
      $obj->updateSlots($vehicle_type, $two_wheeler_slots);
      header('location: index.php');
    }
    if($vehicle_type == '4_wheeler') {
      $four_wheeler_slots = $current_slots['4_wheeler'];
      $four_wheeler_slots = $four_wheeler_slots - 1;
      $obj->updateSlots($vehicle_type, $four_wheeler_slots);
      header('location: index.php');
    }
  }
}

else {
  header('location: index.php');
}

?>
