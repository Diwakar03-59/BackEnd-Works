<?php

namespace App\Controller;

/**
 * Class to handle the uploading of the files to be uploaded by the users.
 */
class UploadCon {

  /**
   * Function to handle the uploading of image files uploaded by the user.
   *
   * @param mixed $data
   *    Stores the Files data uploaded by the user, that needs to be uploaded to
   *    the database and the server.
   * 
   * @return string
   *    Returns a string containing the path to the uploaded image file, if 
   *    uploaded successfully, otherwise returns a suitable error message.
   */
  public function uploadImage(mixed $data) {
    $target_dir = "uploads/";
    
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image.
    if (isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if ($check !== false) {
        $uploadOk = 1;
      } else {
        $uploadOk = 0;
      }
    }

    // Allow certain file formats.
    if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif"
    ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // If everything is ok, try to upload file otherwise return an error.
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    } 
    else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      } 
      else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
    
    $imag = $_FILES["fileToUpload"]["name"];
    $img = "uploads/" . $imag;

    return $img;
  }

  /**
   * Function to upload the music file uploaded by the user 
   * to the server and the databse.
   *
   * @param mixed $data
   *    Stores the Files data uploaded by the user, that needs to be uploaded to
   *    the database and the server.
   * 
   * @return string 
   *    Returns a string containing the path to the uploaded image file, if 
   *    uploaded successfully, otherwise returns a suitable error message.
   */
  public function uploadMusic(mixed $data) {

    $target_dir = "uploads/music/";
    
    $target_file = $target_dir . basename($_FILES["music-file"]["name"]);
    $uploadOk = 1;
    $audioFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allow certain file formats.
    if (
      $audioFileType != "mp3" && $audioFileType != "wav" 
    ) {
      echo "Sorry, only mp3, wav files are allowed.";
      $uploadOk = 0;
    }

    // If everything is ok, try to upload file.
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    } 
    else {
      if (move_uploaded_file($_FILES["music-file"]["tmp_name"], $target_file)) {
      } 
      else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
    
    $file = $_FILES["music-file"]["name"];
    $music = "uploads/music/" . $file;

    return $music;
  }
  
}

?>

