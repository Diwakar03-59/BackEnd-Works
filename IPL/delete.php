<?php 
require_once 'dbconnect.php';
require_once 'admin.php';

$id = $_POST['id'];
$admin = new Admin();
$delete = $admin->deletePlayer($id);
if($delete) {
  return;
}
