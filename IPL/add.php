<?php 
require_once 'admin.php';

$admin = new Admin();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(!empty($_POST)) {
    try {
      $data = $_POST;
      $add_player = $admin->addPlayer($data);
      if($add_player) {
        header('location: index.php');
      }
    }
    catch (Exception $e) {
      print_r($e);
    }
  }
}
?>
