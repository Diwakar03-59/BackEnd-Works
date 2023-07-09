<?php

require_once 'dbConnect.php';

$obj = new dbConnect;
$booked_slots = $obj->getBookedSlots();
$occupied_slots = [];
$current_number_of_slots = $obj->getSlotsAvailable();
foreach($booked_slots as $booked) {
  $occupied_slots[] = $booked['slot_id'];
}

// Checks if the slot requested to be released is occupied or not. 
// If previously booked then the vehicle is released and the slot is 
// marked available.
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['slot_id'])) {
  $id = $_POST['slot_id'];
  $booked = in_array($id, $occupied_slots);
  if($booked) {
    $data = $obj->getSlotDetail($id);
    $vehicle_type = $data[5];
    $release = $obj->releaseSlot($id);
    if($release) {
      if($vehicle_type == '2_wheeler') {
        $updated_2_wheeler_slots = $current_number_of_slots['2_wheeler'] + 1;
        $obj->updateSlots($vehicle_type, $updated_2_wheeler_slots);
      }
      else {
        $updated_4_wheeler_slots = $current_number_of_slots['4_wheeler'] + 1;
        $obj->updateSlots($vehicle_type, $updated_4_wheeler_slots);
      }
      header('location: index.php');
    }
  }
  else {
    echo 'Please book a parking slot first.';
    ?>
    <a href="index.php">Go Back</a>
    <?php
  }
}

else{
  echo 'invalid';
  //header('location: index.php');
}

?>
