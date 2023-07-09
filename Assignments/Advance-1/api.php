<?php 

require '../vendor/autoload.php';

use GuzzleHttp\Client;

/**
 * Class for extracting data from the API.
 * Contains functions for extracting the data from the API and storing in an array.
 */
class ApiData {

  // Array to store the body links of each section.
  public $link_arr = array();

  // Array to store the heading of each section.
  public $heading_arr = array();

  // Array to store the image of each section.
  public $img_arr =  array();

  // Array to store the redirect links.
  public $redirect_link = array();

  /**
   * This Function accepts a url and return the data fetched from the api link in json format.
   * @param [$url] -> API Link sent by the user.
   * @return Array.
   */
  function get_json($url) {
    $client = new Client([
      'base_uri' => $url,
    ]);
    $response = $client->request('GET', '',);
    $body = $response->getBody();
    $arr_body = json_decode($body);
    return $arr_body;
  }

  /**
   * This function returns the body data of each section along with its link. 
   * @param [$data] -> JSON data sent by the user which needs to be searched for the links.
   * @return Array.
   */
  function get_services_link($data) {
    foreach($data->data as $apidata) {
      if (!($apidata->attributes->field_services) == null) {
        $link_arr[] = $apidata->attributes->field_services->value;
      }
    }
    return $link_arr;
  }

  /**
   * This function returns the heading data of each section. 
   * @param [$data] -> JSON data sent by the user which needs to be searched for the heading.
   * @return Array.
   */
  function get_services_headings($data) {
    foreach($data->data as $apidata) {
      if (!($apidata->attributes->field_services) == null) {
        if (($apidata->attributes->field_secondary_title) == null) {
          $heading_arr[] = $apidata->attributes->title;
        }
        else {
          $heading_arr[] = $apidata->attributes->field_secondary_title->value;
        }
      }
    }
    return $heading_arr;
  }

  /**
   * This function returns the images of each section. 
   * @param [$data] -> JSON data sent by the user which needs to be searched for the image.
   * $self_body -> json data after fetching the response from the self link. 
   * $relative_body -> json data after fetching the response from the relative link.
   * @return Array.
   */
  function get_services_images($data) {
    foreach($data->data as $apidata) {
      if (!($apidata->attributes->field_services) == null) {
        $self_link = $apidata->relationships->field_image->links->self->href;
        $self_body = $this->get_json($self_link);
        $relative_link = $self_body->links->related->href;
        $relative_body = $this->get_json($relative_link);
        $img_arr[] = $relative_body->data->attributes->uri->url;
      }
    }
    return $img_arr;
  }

  /**
   * This function returns the redirect links of each section. 
   * @param [$data] -> JSON data sent by the user which needs to be searched for the links.
   * $alias -> redirect link to be attached after the base link. 
   * @return Array.
   */
  function get_button_links($data) {
    foreach($data->data as $apidata) {
      if (!($apidata->attributes->field_services) == null) {
        $alias = $apidata->attributes->path->alias;
        $redirect_link[] = $alias;
      }
    }
    return $redirect_link;
  }

}

?>