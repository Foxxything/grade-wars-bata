<?php
  require_once('config.php'); // get the from from email

  $to = 'god@example.com'; // email to send to
  $subject = 'Subject of the email'; // subject of email
  $message = 'Body of the email'; // message to send

  // headers for email
  $headers = 'X-Mailer: PHP/' . phpversion() . "\r\n"; // mailer
  $headers .= 'From: ' . FROM . "\r\n"; // from
  $headers .= 'X-Priority: 1' . "\r\n"; // priority

  mail($to, $subject, $message, $headers);
?>