<?php

namespace App\Controller;

use App\model\dbConnect;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class homeController extends AbstractController {

    /**
     * Home link. Displays all the tickets booked for today.
     *
     * @return Response
     */
  #[Route('/', name: 'app_home')]
  public function home(string $slug = NULL): Response {
    // echo 'Home';
    $conn = new dbConnect;
    $slots = $conn->getSlotsAvailable();
    $items = $conn->getTickets();
    $current_time = $conn->getCurrentStatus();
    $current_time = $current_time->fetch_array();
    $current = $current_time[0];
    $available_slot = "Occupied";
    return $this->render('Parking/home.html.twig', 
    ['slots'=> $slots, 'items'=>$items, 'current'=>$current, 'status'=>"Occupied", 'avail_slot'=>$available_slot]);
  }

  /**
   * Handles the booking / parking of a new vehicle.
   *
   * @return Response
   */
  #[Route('/book', name: 'app_book')]
  public function book(): Response {
    $conn = new dbConnect;
    //print_r($_POST);
    $slots = $conn->getSlotsAvailable();
    $items = $conn->getTickets();
    $current_time = $conn->getCurrentStatus();
    $current_time = $current_time->fetch_array();
    $current = $current_time[0];
    //die();
    $available_slot = "Occupied";
    // print_r($_POST);
    // die();
    if(isset($_POST['vehiclenumber']) && isset($_POST['vehicletype'])) {
      $vehicle_type = $_POST['vehicletype'];
      $vehicle_number = $_POST['vehiclenumber'];
      $insert = $conn->park($_POST);
      if ($insert == 'Occupied') {
        //$conn = new dbConnect;
        $status = $insert;
        $slots = $conn->getSlotsAvailable();
        $items = $conn->getTickets();
        $current_time = $conn->getCurrentStatus();
        $current_time = $current_time->fetch_array();
        $current = $current_time[0];
        return $this->render('Parking/home.html.twig', 
        ['slots'=> $slots, 'items'=>$items, 'current'=>$current, 'status'=>$status, 'avail_slot'=>$available_slot]);
      }
    
    }
    return $this->render('Parking/home.html.twig', 
      ['slots'=> $slots, 'items'=>$items, 'current'=>$current, 'status'=>"Occupied"]);
  }

  /**
   * Function to handle the release of a vehicle and update the list of tickets.
   *
   * @return Response
   */
  #[Route('/release', name: 'app_release')]
  public function release(): Response {
    $conn = new dbConnect;
    if(isset($_POST['slotID'])) {
      $available_slot = $_POST['slotID'];
      $update = $conn->release_parking($_POST['slotID']);
      if($update == 'Available') {
        $slots = $conn->getSlotsAvailable();
        $items = $conn->getTickets();
        $current_time = $conn->getCurrentStatus();
        $current_time = $current_time->fetch_array();
        $current = $current_time[0];
        return $this->render('Parking/home.html.twig', 
        ['slots'=> $slots, 'items'=>$items, 'current'=>$current, 'status'=>$update, 'avail_slot'=>$available_slot]);
        }
    }
    $available_slot = '';
    $slots = $conn->getSlotsAvailable();
    $items = $conn->getTickets();
    $current_time = $conn->getCurrentStatus();
    $current_time = $current_time->fetch_array();
    $current = $current_time[0];
    return $this->render('Parking/home.html.twig', 
    ['slots'=> $slots, 'items'=>$items, 'current'=>$current, 'status'=>"Occupied", 'avail_slot'=>$available_slot]);

  }
}

?>
