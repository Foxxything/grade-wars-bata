<?php
  // Path: config.php
  $host = '192.168.100.189';
  $user = 'Foxx';
  $DBpassword = 'B@nana0k';
  $database = 'gradewars';
  $conn = new mysqli($host, $user, $DBpassword, $database);
  unset($host, $user, $DBpassword, $database);

  if ($conn->connect_errno) {
    exit('Connect failed: '. $conn->connect_error);
  }

  // used for decrition and encryption
  define('KEY', 'ThatWasAlotOfEffortToGetThis'); // key for encrypting the password
  define('IV', 1850374592974628); // iv for encrypting and decrypting the type
  define('SALT', 'ThisIsASalt'); // salt for encrypting the password

  // used for email
  define('EMAIL', 'gradewars@gmail.com'); // email of the system
  define('FROM', 'Gradewars No Reply <'.EMAIL.'>'); // email to send from
  define('ADMIN_FROM', 'Gradewars Logger <'.EMAIL.'>'); // email to send from for admin


  /*
  * Email: gradewars@gmail.com
  * Password: sjasd.ltd
  */
?>