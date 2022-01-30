<?php
  require_once('config.php'); // get the from from email

  $to = 'god@example.com'; // email to send to
  $subject = 'Subject of the email'; // subject of email
  $message = 'Body of the email'; // message to send

  // headers for email
  $headers = 'X-Mailer: PHP/' . phpversion() . "\r\n"; // mailer
  $headers .= 'From: ' . FROM . "\r\n"; // from
  $headers .= 'X-Priority: 1' . "\r\n"; // priority( 1 - 5 )
  /*
  1- highest
  2- high
  3- normal
  4- low
  5- lowest
  */

  mail($to, $subject, $message, $headers);
?>