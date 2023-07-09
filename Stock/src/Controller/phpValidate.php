<?php

namespace App\Controller;

/**
 * Class to handle the php validation of the user input data.
 */
class phpValidate {

  public $email_error = '';
  public $checkpass = '';

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /**
   * Function to validate the email entered by the user.
   * 
   * @param string $text 
   *    Stores the email entered by the user.
   * 
   * @return string
   *    Returns a blank string if the email is valid, otherwise returns an error
   *    message as a string.
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
   * Function to validate the password entered by the user.
   *
   * @param string $password
   *    Stores the password entered by the user.
   *    
   * @return string
   *    Returns a blank string if the password is valid, otherwise returns an 
   *    error message as a string.
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
      if(!$uppercase || !$lowercase || !$number || !$specialChars || 
        strlen($password) < 8) {
        $this->checkpass = 'Password should be at least 8 characters in length 
        and should include at least one upper case letter, one number, and one 
        special character.';
      }
      else {
        $this->checkpass = '';
      }
    }
    return $this->checkpass;
  }
}
