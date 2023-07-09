<?php

require_once 'dbconnect.php';

/**
 * This class is responsible for all the PHP validation. 
 */

class validate
{
  public $fname_error = '';
  public $email_error = '';
  public $checkpass = '';
  public $fname = '';
  public $exists = '';
  public $showAlert = '';
  public $showError =  '';
  public $error_arr = array();
  public $obj = '';
  public $conn = '';

  public function __construct() {
    $this->obj = new DbConnect();
    $this->conn = $this->obj->connect();
  }

  /**
   * This function is for removing the extra spaces, slashes and special 
   * characters from the data entered.
   * 
   * @param string $data 
   *    The parameter is the data entered by the user.
   * @return string
   *    Returns the string after removing all the trailing spaces and proper
   *    formatting.
   */
  function test_input(string $data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /**
   * This function validates the name entered by the user.
   * 
   * @param string $text - This is the first name entered by the user.
   * 
   * @return void
   */
  function validateFirstName(string $text) {
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
   * Function to validate the email entered by the user.
   * 
   * @param string $text - This is the email entered by the user.
   * This function validates the email entered by the user.
   * 
   * @return string
   *    Returns a blank string if the email is valid, otherwise returns an error
   *    accordingly.
   */
  function validateEmail(string $text) {
    if (empty($text)) {
      $this->email_error = "Email is required";
    } 
    else {
      $email = $this->test_input($text);
      if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
        $this->email_error = "Enter a valid email";
      }
    }
    return $this->email_error;
  }

  /**
   * This function validates the password entered by the user.
   * 
   * @param string $password 
   *    This is the password entered by the user.
   * 
   * @return string
   *    Returns a blank string if the password is valid, otherwise returns an 
   *    error accordingly.
   */
  function validatePassword(string $password) {
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
    }
    return $this->checkpass;
  }

}

?>
