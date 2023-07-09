<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>Advance-1 OOP</title>
  <style>
      <?php include 'style.css'; ?>
  </style>
</head>

<?php

require '../vendor/autoload.php';
include 'api.php';

use GuzzleHttp\Client;

$var = 'https://ir-dev-d9.innoraft-sites.com';
$json = new ApiData();

// Base API link.
$base = 'https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services';
// $arr_body -> Stores the entire data of the API in json format. 
$arr_body = $json->get_json($base);

$link_arr = $json->get_services_link($arr_body);
$heading_arr = $json->get_services_headings($arr_body);
$img_arr = $json->get_services_images($arr_body);
$button_link =  $json->get_button_links($arr_body);

// Traversing over the json data and printing the data in the required format.
for ($m = 0; $m < count($link_arr); $m++) {
  $img = $var . $img_arr[$m];
  $head = $heading_arr[$m];
  $body = $link_arr[$m];
  $redirect_link = $var . $button_link[$m];
  if ($m % 2 == 0) {
    echo"<div class='centre'>
          <div id='data'>
            <div class='center_img'>
              <a class='topic_link' href='$redirect_link'>
                <img src = '$img'>
              </a>
            </div>
            <div style='display: flex; width:100%; padding: 0px 10px'>
              <div class='web' style='width: 100%;''>
                <h2 class = 'head'>
                  <a class='topic_link' href='$redirect_link'>$head</a>
                </h2>
                <a class='topic_link'>$body</a>
                <button class='but'>
                  <a href='$redirect_link'>EXPLORE MORE</a>
                </button>
              </div>
            </div>
          </div>
        </div>";
  }
  else {
    echo"<div class='centre'>
          <div id='data'>
            <div style='display: flex; width:100%; padding: 0px 10px'>
              <div class='web' style='width: 100%;''>
                <h2 class = 'head'>
                  <a class='topic_link' href='$redirect_link'>$head</a>
                </h2>
                <a class='topic_link'>$body</a>
                <button class='but'>
                  <a href='$redirect_link'>EXPLORE MORE</a>
                </button>
              </div>
            </div>
            <div class='center_img''>
              <a class='topic_link' href='$redirect_link'>
                <img src = '$img'>
              </a>
            </div>
          </div>
        </div>";
  }
}

?>
<body>
</body>
</html>
