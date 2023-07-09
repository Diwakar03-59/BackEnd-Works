<!DOCTYPE html>
<html lang="en">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Advance Assignment 1</title>
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

//API call 1
//First Field - Web development-[15]
$base = 'https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services';
$arr_body = $json->get_json($base);

$i = 0;
//Field services link values
$link_arr = array();
$heading_arr = array();
$img_arr =  array();
foreach($arr_body->data as $apidata) {
  if (!($apidata->attributes->field_services) == null) {
    $link_arr[$i] = $apidata->attributes->field_services->value;
    $i++;
  }
}
$j = 0;
//Field services headings - 
foreach($arr_body->data as $apidata) {
  if (!($apidata->attributes->field_services) == null) {
    $heading_arr[$j] = $apidata->attributes->title;
    $j++;
  }
}
$k = 0;
//Field service images- 
foreach($arr_body->data as $apidata) {
  if (!($apidata->attributes->field_services) == null) {
    $self_link = $apidata->relationships->field_image->links->self->href;
    $self_body = $json->get_json($self_link);
    $relative_link = $self_body->links->related->href;
    $relative_body = $json->get_json($relative_link);
    $img_arr[$k] = $relative_body->data->attributes->uri->url;
    $k++;
  }
}

echo "<pre>";
//print_r($apidata->attributes->field_services->value);
print_r($link_arr);
print_r($heading_arr);
print_r($img_arr);
echo "</pre>";
    
  
  /*
  foreach($apidata->$i as $data){
    foreach($data->attributes as $final) {
      foreach($final->field_services as $value) {
        echo $value;
        $i++;
      }
    }*/
    //echo $data;
  
  //echo $apidata;//{
    //foreach($data->field_services as $data2) {
      //echo $data2;
    //}
  
//}



$img_link = $arr_body->data['15']->relationships->field_image->links->self->href;

$arr_body3 = $json->get_json($img_link);
$final_link = $arr_body3->links->related->href;

$arr_body4 = $json->get_json($final_link);

//Creating title and button links - [15]
$link_15 = $arr_body->data['15']->attributes->field_services->value;
//echo $link_15;
$alias_15 = $arr_body->data['15']->attributes->path->alias;
$redirect_15 = $var . $alias_15;


//Second  Field - Drupal - [12]
$img_link_12 = $arr_body->data['12']->relationships->field_image->links->self->href;

$arr_body12 = $json->get_json($img_link_12);
$final_link_12 = $arr_body12->links->related->href;

$arr_body12 = $json->get_json($final_link_12);

//Creating title and button links - [12]
$link_12 = $arr_body->data['12']->attributes->field_services->value;
//echo $link_12;
$alias_12 = $arr_body->data['12']->attributes->path->alias;
$redirect_12 = $var . $alias_12;


//Third  Field - Mobile - [13]
$img_link_13 = $arr_body->data['13']->relationships->field_image->links->self->href;

$arr_body13 = $json->get_json($img_link_13);
$final_link_13 = $arr_body13->links->related->href;

$arr_body13 = $json->get_json($final_link_13);

//Creating title and button links - [13]
$link_13 = $arr_body->data['13']->attributes->field_services->value;
//echo $link_13;
$alias_13 = $arr_body->data['13']->attributes->path->alias;
$redirect_13 = $var . $alias_13;

//Fourth  Field - Ecommerce - [14]
$img_link_14 = $arr_body->data['14']->relationships->field_image->links->self->href;

$arr_body14 = $json->get_json($img_link_14);
$final_link_14 = $arr_body14->links->related->href;

$arr_body14 = $json->get_json($final_link_14);

//Creating title and button links - [14]
$link_14 = $arr_body->data['14']->attributes->field_services->value;
//echo $link_14;
$alias_14 = $arr_body->data['14']->attributes->path->alias;
$redirect_14 = $var . $alias_14;
/*
$client = new Client([
  'base_uri' => 'https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services',
]);
$response = $client->request('GET', '',);
$body = $response->getBody();
$arr_body = json_decode($body);
print_r($arr_body->data['15']->attributes->field_services->value);
echo "<br>";
$img_link = $arr_body->data['15']->relationships->field_image->links->self->href;
*/
/*
//API call 2
$arr_body2 = $json->get_json($img_link);
$img_link2 = $arr_body2->links->self->href;
*/
/*
$client2 = new Client([
  'base_uri' => $img_link,
]);
$response2 = $client2->request('GET', '',);
$body2 = $response2->getBody();
$arr_body2 = json_decode($body2);
$img_link2 = $arr_body2->links->self->href;
*/

//Third api call //API call 3
//print_r($var . $arr_body4->data->attributes->uri->url);

/*
$client3 = new Client([
  'base_uri' => $img_link2,
]);
$response3 = $client3->request('GET', '',);
$body3 = $response3->getBody();
$arr_body3 = json_decode($body3);
$final_link = $arr_body3->links->related->href;
*/
//Using class to fetch json data from api

//Link to image of field_service[data->15]
//print_r($var . $arr_body4->data->attributes->uri->url);

/*
//API Call 4
$client4 = new Client([
  'base_uri' => $final_link,
]);
$response4 = $client4->request('GET', '',);
$body4 = $response4->getBody();
$arr_body4 = json_decode($body4);
print_r($var . $arr_body4->data->attributes->uri->url);
*/


//Field title
//print_r($arr_body->data['15']->attributes->field_secondary_title->value);
//echo "<br>";
//print_r($arr_body->data['0']->attributes->field_services->value);
/*
//Field title link
$link_15 = $arr_body->data['15']->attributes->field_services->value;
//echo $link_15;
$alias_15 = $arr_body->data['15']->attributes->path->alias;
$redirect_15 = $var . $alias_15;
//echo $redirect_15;
//echo "<br>";
//print_r($arr_body->data['11']->attributes->field_services->value);
//echo "<br>";
//Field title
//print_r($arr_body->data['12']->attributes->field_secondary_title->value);
//echo "<br>";
//Field title link
$link_12 = $arr_body->data['12']->attributes->field_services->value;
$alias_12 = $arr_body->data['12']->attributes->path->alias;
$redirect_12 = $var . $alias_12;
//print_r($arr_body->data['12']->attributes->field_services->value);
echo "<br>";
//Field title
//print_r($arr_body->data['15']->attributes->field_secondary_title->value);
//echo "<br>";
//Field title
print_r($arr_body->data['13']->attributes->field_secondary_title->value);
echo "<br>";
//Field title link
$link_13 = $arr_body->data['13']->attributes->field_services->value;
$alias_13 = $arr_body->data['13']->attributes->path->alias;
$redirect_13 = $var . $alias_13;
print_r($arr_body->data['13']->attributes->field_services->value);
echo "<br>";
//Field title
print_r($arr_body->data['14']->attributes->field_secondary_title->value);
echo "<br>";
//Field title link
$link_14 = $arr_body->data['14']->attributes->field_services->value;
$alias_14 = $arr_body->data['14']->attributes->path->alias;
$redirect_14 = $var . $alias_14;
print_r($arr_body->data['14']->attributes->field_services->value);
*/
//data.data['15']['relationships']['field_image']['links']['self'].href
//$client = new \GuzzleHttp\Client();


?>

<body>
  <div class="center">
    <div id="data">
      <div style="display: flex; width:100%; padding: 0px 10px">
        <a class="topic_link" href="<?php echo $redirect_15 ?>">
          <img src="<?php echo $var . $arr_body4->data->attributes->uri->url; ?>" alt="">
        </a>
      </div>
      <div style="display: flex; width:100%; padding: 0px 10px">
        <div class="web" style="width: 100%;">
          <h2 class="head">
            <a class="topic_link" href="<?php echo $redirect_15 ?>">
              <?php echo $arr_body->data['15']->attributes->field_secondary_title->value; ?>
            </a>
          </h2>
          <a class="topic_link" href="<?php echo $redirect_15; ?>"><?php echo $link_arr[5]; ?></a>
          <button class="but">
            <a href="<?php echo $redirect_15; ?>">EXPLORE MORE</a>
          </button>
        </div>
      </div>
    </div>

    <div id="data">
      <div style="display: flex; width:100%; padding: 0px 10px">
        <div class="web" style="width: 100%;">
          <h2 class="head">
            <a class="topic_link" href="<?php echo $redirect_12 ?>">
              <?php echo $arr_body->data['12']->attributes->field_secondary_title->value; ?>
            </a>
          </h2>
          <a class="topic_link" href="<?php echo $redirect_12; ?>"><?php echo $link_arr[2]; ?></a>
          <button class="but">
            <a href="<?php echo $redirect_12; ?>">EXPLORE MORE</a>
          </button>
        </div>
      </div>
      <div style="display: flex; width:100%; padding: 0px 10px">
        <a class="topic_link" href="<?php echo $redirect_12 ?>">
          <img src="<?php echo $var . $arr_body12->data->attributes->uri->url; ?>" alt="">
        </a>
      </div>
    </div>

    <div id="data">
      <div style="display: flex; width:100%; padding: 0px 10px">
        <a class="topic_link" href="<?php echo $redirect_13 ?>">
          <img src="<?php echo $var . $arr_body13->data->attributes->uri->url; ?>" alt="">
        </a>
      </div>
      <div style="display: flex; width:100%; padding: 0px 10px">
        <div class="web" style="width: 100%;">
          <h2 class="head">
            <a class="topic_link" href="<?php echo $redirect_13 ?>">
              <?php echo $arr_body->data['13']->attributes->field_secondary_title->value; ?>
            </a>
          </h2>
          <a class="topic_link" href="<?php echo $redirect_13; ?>"><?php echo $link_arr[3]; ?></a>
          <button class="but">
            <a href="<?php echo $redirect_13; ?>">EXPLORE MORE</a>
          </button>
        </div>
      </div>
    </div>

    <div id="data">
      <div style="display: flex; width:100%; padding: 0px 10px">
        <div class="web" style="width: 100%;">
          <h2 class="head">
            <a class="topic_link" href="<?php echo $redirect_14 ?>">
              <?php echo $arr_body->data['14']->attributes->field_secondary_title->value; ?>
            </a>
          </h2>
          <a class="topic_link" href="<?php echo $redirect_14; ?>"><?php echo $link_arr[4] ?></a>
          <button class="but">
            <a href="<?php echo $redirect_14; ?>">EXPLORE MORE</a>
          </button>
        </div>
      </div>
      <div style="display: flex; width:100%; padding: 0px 10px">
        <a class="topic_link" href="<?php echo $redirect_14 ?>">
          <img src="<?php echo $var . $arr_body14->data->attributes->uri->url; ?>" alt="">
        </a>
      </div>
    </div>
  </div>
  <?php
  ?>









  <!--
  <script type="text/javascript">
    $(document).ready(function() {
      $.ajax({
        url: 'https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services',
        type: "GET",
        success: function(data) {
          console.log(data)
          //$('#data').append(data.data[0])
        }
      })
    })




      
      $.getJSON(
        "https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services",
        function(data){
          console.log(data)
          $.each(data, function(key, value){
            //$('#data').append(value.data['5']['attributes']['field_services'] + "<br>")
          })
          $('#data').append(data.data['0']['attributes']['field_services']['value'] + "<br>")
          //$('#data').append(data.data['1']['attributes']['field_services'] + "<br>") 
          //$('#data').append(data.data['2']['attributes']['field_services'] + "<br>")
          //$('#data').append(data.data['3']['attributes']['field_services'] + "<br>")
          //$('#data').append(data.data['4']['attributes']['field_services'] + "<br>")
          //$('#data').append(data.data['5']['attributes']['field_services'] + "<br>")
          //$('#data').append(data.data['6']['attributes']['field_services'] + "<br>")
          //$('#data').append(data.data['7']['attributes']['field_services'] + "<br>")
          //$('#data').append(data.data['8']['attributes']['field_services'] + "<br>")
          //$('#data').append(data.data['9']['attributes']['field_services'] + "<br>")
          //$('#data').append(data.data['10']['attributes']['field_services'] + "<br>")
          
          $('#data').append(data.data['11']['attributes']['field_services']['value'] + "<br>")
          $('#data').append(data.data['15']['attributes']['field_services']['value'] + "<br>")
          var jpg =  'https://ir-dev-d9.innoraft-sites.com/jsonapi/node/services'
          //var jpg = ''
          $.getJSON(
            jpg,
            function(data) {
              $("#imag").append('<img src="' + data.data['15']['relationships']['field_image']['links']['self'].href + '">')
            }
          )

          
          console.log(jpg)

          $('#data').append(data.data['12']['attributes']['field_services']['value'] + "<br>")
          $('#data').append(data.data['13']['attributes']['field_services']['value'] + "<br>")
          $('#data').append(data.data['14']['attributes']['field_services']['value'] + "<br>")
          
          //$('#data').append(data.data['16']['attributes']['field_services'] + "<br>")

          
        }
      )
    }) */
  </script>
  -->
</body>
</html>
