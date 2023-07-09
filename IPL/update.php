<?php 

require_once 'dbconnect.php';
require_once 'admin.php';

$admin = new Admin();
$data = $_POST;
$updatePlayer = $admin->updatePlayer($data);
if($updatePlayer) {
  return;
}

?>
