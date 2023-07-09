<?php
require_once 'dbconnect.php';
require_once 'admin.php';

$admin = new  Admin();
$man_of_match = $admin->getMan();

// Retruns the man of the match with maximun strike rate. 
if($man_of_match) {
  return $man_of_match;
}
