<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'php_validate.php';
include 'dbconnect.php';

if (!isset($_SESSION['username'])) {
  header('location: ../login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $_SESSION['username'] = $_POST['email'];
  $email = $_POST['email'];
  $user = $email;
  $php_check = new validate();
  $php_check->validate_Email($_POST['email']);
  $email_error = $php_check->email_error;
}

if (!empty($_POST['email'])) {
  $sql = "select * from user_data where username = '$user'";
  $exists = mysqli_query($conn, $sql);
  if (mysqli_num_rows($exists) === 1) {
    $mail =  new PHPMailer(TRUE);
    try {
      // Server settings
      //$mail->SMTPDebug = 2; //SMTP::DEBUG_SERVER; // for detailed debug output
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = TRUE;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      $mail->Username = 'diwakar.tekie@gmail.com'; 
      $mail->Password = 'xcwgtdqasvauymsr'; 

      // Sender and recipient settings
      $mail->setFrom('diwakar.tekie@gmail.com', 'Diwakar Sah');
      $mail->addAddress($email, $email);
      $mail->addReplyTo('diwakar.tekie@gmail.com', 'Diwakar Sah');

      // Setting the email content
      $mail->IsHTML(TRUE);
      $mail->Subject = "Reset Password";
      $mail->Body = "<b>Click on the link below to reset your Password.</b>
                      <a href= 'www.assignments.com/reset.php'>Reset Password Link.</a> ";
      $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

      $mail->send();
      echo "Email message sent.";
      $_SESSION['user'] = $email;
    } 
    catch (Exception $e) {
      echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
    }
  }
  else {
    echo "Username does not exist!";
  }
}

?>
