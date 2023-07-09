<?php

require_once 'dbConnect.php';

$conn = new dbConnect;

// Contains all the slots available for booking.
$slots = $conn->getSlotsAvailable();

// Contains all the tickets booked for the current day.
$tickets = $conn->getTickets();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="index.css">
  <script lang="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="app.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <div class="back">
    <div class="container">
      <div class="section1">
        <p>Availability</p>
        <div class="slots">
          <h4>2 wheelers Slots Available</h3>
          <h4>4 wheelers Slots Available</h3>
        </div>
        <div class="slots">
          <h2><?php echo $slots['2_wheeler']; ?></h2>
          <h2><?php echo $slots['4_wheeler']; ?></h2>
        </div>
      </div>
      <div class="section2">
        <div class="head">
          <h3>Tickets</h3>
        </div>
        <div class="data">
          <table>
            <thead>
              <tr>
                <th>Slot Number</th>
                <th>Vehicle Number</th>
                <th>Time of Entry</th>
                <th>Time of Exit</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              /**
               * Updating the section to view all the tickets booked for a particular day.
               */
              if($tickets != NULL) {
                foreach($tickets as $ticket) {
                  $slot_id = $ticket['slot_id'];
                  $vehicle_no = $ticket['vehicle_number'];
                  $entry_time = $ticket['entry_time'];
                  $exit_time = $ticket['exit_time'];
                  $status = $ticket['status'];
              ?>
               <tr>
                  <th><?php echo $slot_id; ?></th>
                  <td><?php echo $vehicle_no; ?></td>
                  <td><?php echo $entry_time; ?></td>
                  <td><?php echo $exit_time; ?></td>
                  <td><?php echo $status; ?></td>
                </tr>
              <?php }} ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="section3">
        <div class="head">
          <h3>Booking</h3>
        </div>
        <div class="data">
          <form action="book.php" method="post" >
          <label class="label" for="vehiclenumber"> Vehicle Number</label><br>
          <input type="text" required id="vehiclenumber" name="vehiclenumber"><br>
            <p>Type of Vehicle</p>
            <label class="label" for="vehicletype"> Bike</label>
            <input type="radio" id="vehicletype" name="vehicletype" value="2_wheeler">
            <label class="label" for="vehicletype"> Car</label>            
            <input class="input" type="radio" id="vehicletype" name="vehicletype" value="4_wheeler">
            <br>
            <input class="submit" id="submit" name="submit" type="submit" value="Book">
          </form>
        </div>
      </div>
      <div class="section4">
        <div class="head">
          <h3>Release</h3>
        </div>
        <div class="data">
          <form action="release.php" method="post" >
            <label class="label" for="slot_id"> Slot ID: </label><br>
            <input type="text" required id="slot_id" name="slot_id"><br>
            <input class="submit" id="release" name="release" type="submit" value="Release">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
