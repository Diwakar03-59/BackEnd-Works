<?php
require 'dbconnect.php';
/**
 * This class is responsible for all the PHP validation. 
 */

class validate
{
  public $fname_error = '';
  public $lname_error = '';
  public $gender_error = '';
  public $email_error = '';
  public $phone_error = '';
  public $checkpass = '';
  public $fname = '';
  public $lname = '';
  public $gender = '';
  public $exists = '';
  public $showAlert = '';
  public $showError =  '';
  public $error_arr = array();

  /**
   * @param [str] $data - The parameter is the data entered by the user.
   * This function is for removing the extra spaces, slashes and special characters from the data entered.
   * @return string
   */
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /**
   * @param [str] $text - This is the first name entered by the user.
   * This function validates the first name entered by the user.
   * @return void
   */
  function validate_First_Name($text) {
    if (empty($text)) {
      $this->fname_error = "First Name is required";
    } 
    else {
      $fname = $this->test_input($text);
      if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
        $this->fname_error = "Only letters and white space allowed";
      }
    }
  }

    /**
   * @param [str] $text - This is the last name entered by the user.
   * This function validates the last name entered by the user.
   * @return void
   */
  function validate_Last_Name($text) {
    if (empty($text)) {
      $this->lname_error = "Last name is required";
    } 
    else {
      $lname = $this->test_input($text);
      if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
        $this->lname_error = "Only letters and white space allowed";
      }
    }
  }

    /**
   * @param [str] $text - This is the phone number entered by the user.
   * This function validates the phone number entered by the user.
   * @return void
   */
  function validate_Phone($text) {
    if (empty($text)) {
      $this->phone_error = "Phone number is required";
    } 
    else {
      $phone = $this->test_input($text);
      if (!preg_match("/^(\+91)[0-9]{10}$/", $phone)) {
        $this->phone_error = "Enter a valid mobile number with country code";
      }
    }
  }

  /**
   * @param [str] $text - This is the email entered by the user.
   * This function validates the email entered by the user.
   * @return void
   */
  function validate_Email($text) {
    if (empty($text)) {
      $this->email_error = "Email is required";
    } 
    else {
      $email = $this->test_input($text);
      if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
        $this->email_error = "Enter a valid email";
      }
    }
  }
    
  /**
   * @param [str] $text - This is the first name entered by the user.
   * This function validates the email entered by the user via API..
   * @return void
   */
  function validateEmail() {
    $email = $_POST['email'];
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.apilayer.com/email_verification/check?email=$email",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: text/plain",
        "apikey: Y5r66DpVyLcVDcntuj5yNVPdBKxzpor6"
      ),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET"
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $obj = json_decode($response);
    if ($obj->format_valid == TRUE && $obj->smtp_check == TRUE) {
      return TRUE;
    } 
    else {
      return FALSE;
    }
  }

  /**
   * @param [str] $user - This is the email entered by the user.
   * @param [str] $pass - This is the password entered by the user.
   * This function validates whether the user is registered or not and implements login functionality.
   * @return bool
   */
  function login($user, $pass) {
    include 'dbconnect.php';
    //$pass = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "select * from user_data where username = '$user'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
      if ($row['username'] === $user && password_verify($pass, $row['password'])) {
        return TRUE;
        exit();
      }
      else {
        return FALSE;
      }
    }
    else {
      return FALSE;
    }
  }

  /**
   * @param [str] $password - This is the password entered by the user.
   * This function validates the password entered by the user.
   * @return void
   */
  function validatePassword($password) {
    if (empty($password) ) {
      $this->checkpass = 'Password is required!';
    }
    else {
      // Validate password strength.
      $password = $this->test_input($password);
      $uppercase = preg_match('@[A-Z]@', $password);
      $lowercase = preg_match('@[a-z]@', $password);
      $number    = preg_match('@[0-9]@', $password);
      $specialChars = preg_match('@[^\w]@', $password);
      if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $this->checkpass = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
      }
      else {
        $this->checkpass = 'Strong password.';
      }
    }
  }

  function register($username, $password, $cpassword) {
    include 'dbconnect.php';
    $exists = FALSE;
    $showAlert = FALSE;
    $showError = FALSE;
    // This sql query is use to check if the username is already present or not in our Database.
    $sql = "Select * from user_data where username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 0) {
      if (($password == $cpassword) && $exists == FALSE) {
        //$hash = password_hash($password, PASSWORD_DEFAULT);

        // Query to insert data into database. 
        $sql = "INSERT INTO `user_data` ( `username`, 
            `password`) VALUES ('$username', 
            '$password')";

        $result = mysqli_query($conn, $sql);
        if ($result) {
          $showAlert = TRUE;
        } 
        else {
          $showError = "Passwords do not match";
        }
      } 
    }
    if ($num > 0) {
      $this->$exists = "Username not available";
    }
    $error_arr[] = $showAlert;
    $error_arr[] = $showError;
    $error_arr[] = $exists;
    return $error_arr;
  }

}

?>
