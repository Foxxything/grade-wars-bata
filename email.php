<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;

  require 'vendor/autoload.php';
  require 'functions.php';

  $msg = "
    YOOOOOO
  ";
  $to = 'f.pinkerton@sjasd.ca';

  sendEmail('noreply', $to, 'PHPMailer Test', $msg);
  echo '<br>======================<br>';
  sendEmail('gradewars', $to, 'PHPMailer Test', $msg);
?>