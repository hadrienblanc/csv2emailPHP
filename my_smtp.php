<?php
/**
*/

date_default_timezone_set('Etc/UTC');
require_once ('./PHPMailer/PHPMailerAutoload.php');
require_once('config.php');

function my_o365_send_email($content, $subject, $email_send_to, $attached_filename = "")
{
  $mail = new PHPMailer;
  $mail->isSMTP();
  $mail->SMTPDebug = 0;

  $mail->Debugoutput = 'html';
  $mail->Host = "smtp.office365.com";
  $mail->Port = 587;
  $mail->SMTPAuth = true;

  $mail->Username = USERNAME;
  $mail->Password = PASSWORD;

  $mail->CharSet = 'utf-8';

  $mail->setFrom(USERNAME, FULLNAME);

  $mail->addAddress($email_send_to);

  // in case you would like to cc somebody
  // $mail->addCC('email@epitech.eu', 'First Last');
  //Set an alternative reply-to address
  //$mail->addReplyTo('replyto@example.com', 'First Last');

  if ($attached_filename != "")
    {
      $mail->addAttachment($attached_filename);
    }

  $mail->Subject = $subject;

  $mail->msgHTML(nl2br($content . SIGNATURE));
  $mail->AltBody = $content . SIGNATURE;

  //Attach an image file
  //$mail->addAttachment('images/phpmailer_mini.png');

  if (!$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo . "\n";
  } else {
      echo "[". $email_send_to . "] Message sent\n";
  }
}
