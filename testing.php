<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php'); // get the sql connection
require 'functions.php'; // get the functions

$email = 'c.magel@sjasd.ca';
$type = 1;

$code = makeCode($email, $type);

$type = accountType($type, $email);

$stmt = $conn->prepare("INSERT INTO pre_user (otp, email, type) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $code, $email, $type);
$stmt->execute();
$decoded = accountType($type);

$card = "+--------------------------------------+<br>";
$card .= "| Email: " . $email . "<br>";
$card .= "| Code: " . $code . "<br>";
$card .= "| Accout type code: " . $type . "<br>";
$card .= "| Account type: " . implode("|", $decoded) . "<br>";
$card .= "+--------------------------------------+<br>";

echo $card;

echo "<a href='./user/userJoin.php'>Join</a>";
