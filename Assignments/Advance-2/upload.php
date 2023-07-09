<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require '../php_validate.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $php_check = new validate();
  $php_check->validate_Email($_POST['email']);
  $email_error = $php_check->email_error;
}

$mail =  new PHPMailer(TRUE);
try {
  // Server settings
  //$mail->SMTPDebug = 2; //SMTP::DEBUG_SERVER; // for detailed debug output
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = TRUE;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;

  $mail->Username = 'diwakar.tekie@gmail.com'; // YOUR gmail email
  $mail->Password = 'xcwgtdqasvauymsr'; // YOUR gmail password

  // Sender and recipient settings
  $mail->setFrom('diwakar.tekie@gmail.com', 'Diwakar Sah');
  $mail->addAddress($email, $email);
  $mail->addReplyTo('diwakar.tekie@gmail.com', 'Diwakar Sah'); // to set the reply to

  // Setting the email content
  $mail->IsHTML(TRUE);
  $mail->Subject = "Sent email using Gmail SMTP and PHPMailer";
  $mail->Body = '<b>Thank you for your submission.</b> ';
  $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

  $mail->send();
  echo "Email message sent.";
} 
catch (Exception $e) {
  echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
}

?>
