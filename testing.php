<link rel="stylesheet" href="css/bootstrap.css">

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php'); // get the sql connection
require 'functions.php'; // get the functions

$email = 'f.pinkerton@sjasd.ca';
$type = 1;

$code = makeCode($email, $type);
$type = accountType($type, $email);
$decoded = accountType($type);

$stmt = $conn->prepare("SELECT * FROM pre_user WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->reset();
  $stmt->close();
$rows = $result->num_rows;

if ($rows < 1) {
  $stmt = $conn->prepare("INSERT INTO pre_user (otp, email, type) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $code, $email, $type);
  $stmt->execute();
  $stmt->reset();
  $stmt->close();
} else {
  $stmt = $conn->prepare("UPDATE pre_user SET otp = ?, type = ? WHERE email = ?");
  $stmt->bind_param("sss", $code, $type, $email);
  $stmt->execute();
  $stmt->reset();
  $stmt->close();
}

$card = "+-----------------------------------------------------------+<br>";
$card .= "| Email: " . $email . "<br>";
$card .= "| Code: " . $code . "<br>";
$card .= "| Accout type code: " . $type . "<br>";
$card .= "| Account type: " . implode("|", $decoded) . "<br>";
$card .= "+----------------------------------------------------------+<br>";

echo $card;

echo "<a href='./user/userJoin.php'>Join</a>";
