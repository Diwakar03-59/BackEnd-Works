<?php

namespace App\Controller;

use App\model\DbConnect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * This class handle all the operation of the Parking web app.
 * It handles the booking and release of a vehicle from the parking space
 * and has separate routes defined for each of them.
 */
class HomeController extends AbstractController {

  /**
   * @Route('/', name: 'app_home')
   */

   /**
   * Function to render the home page of the web app.
   * It gets the currently availabe slots and the booking for the 
   * same and updates the page accordingly. 
   *
   * @return Response -
   *    Returns the tickets booked for the day alongwith the status of available
   *    slots.
   */
  public function home(): Response {
    $obj = new DbConnect;
    $tickets = $obj->getTickets();
    $slots = $obj->getSlotsAvailable();
    return $this->render('Parking/home.html.twig', ['tickets' => $tickets, 'slots' => $slots]);
  }

  /**
   * @Route('/book', name: 'app_book')
   */

   /**
   * Function to book a parking slot. 
   * It checks whether the parking form is filled or not. I fnot, redirects to 
   * the home page without any operation otherwise parks the user vehicle based
   * on the details provided and updates the database accordingly, and then 
   * renders the updated home page. 
   *
   * @return Response
   */
  public function book(): Response {
    if(empty($_POST)) {
      return $this->redirectToRoute('app_home');
    }

    $obj = new DbConnect;
    $slots = $obj->getSlotsAvailable();
    
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

    // Updates the available slots if the booking is successful.
    if($book) {
      if($_POST['vehicletype'] == '2-wheeler') {
        $updated_2_wheeler_slots = $slots['2_wheeler'] - 1;
        $obj->updateSlots($_POST['vehicletype'], $updated_2_wheeler_slots);
      }
      else{
        $updated_4_wheeler_slots = $slots['4_wheeler'] - 1;
        $obj->updateSlots($_POST['vehicletype'], $updated_4_wheeler_slots);
      }
    }

    return $this->redirectToRoute('app_home');
  }

  /**
   * @Route('/release', name: 'app_release')
   */
  /**
   * Function to release a vehicle from the parking zone.
   * It checks whether the slot id requested to be released has booked a slot,
   * or not and does the operation accordingly. If the slot is booked, it 
   * releases the vehicle on the given slot otherwise asks the user to book
   * a slot at first and return the home page without performing any operation.
   *
   * @return Response
   */
  public function release(): Response {
    if(empty($_POST)) {
      return $this->redirectToRoute('app_home');
    }
    $obj = new DbConnect;
    // Stores the slot id for all the booked slots.
    $booked_slots = $obj->getBookedSlots();
    $occupied_slots = [];
    
    // Stores the available number of available slots for both 2-wheeler
    // and 4-wheeler.
    
    $current_number_of_slots = $obj->getSlotsAvailable();
    foreach($booked_slots as $booked) {
      $occupied_slots[] = $booked['slot_id'];
    }

    $request = Request::createFromGlobals();

    $id = $request->get('id');
    // $id = $_POST['id'];
    $booked = in_array($id, $occupied_slots);
    
    // If the slot was booked and the status is occupied, then the vehicle 
    // is released from the parking slot and the database is updated accordingly.
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
      }
      return $this->redirectToRoute('app_home');
    }
    else {
      die('Please book a slot first');
    }
  }
}
