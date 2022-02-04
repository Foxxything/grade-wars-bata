<?php
  require_once('config.php'); // get the from from email
  require 'functions.php'; // get the functions

  //messageAdmin("test", "test");
  $to = 'kirsta.westman@sjasd.ca'; // email to send to
  $subject = 'Welcome To Gradewars'; // subject of email
  $message = 'Welcome to the gradewars program! Follow this link to complete the joining process http://206.45.49.15/beta/user/userJoin.php. \nYour join code is: "ee4fa1" '; // message to send

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