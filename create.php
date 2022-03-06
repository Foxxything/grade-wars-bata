<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);

if (!isset($_GET['email'])) {
  echo "missing email prameter";
  die();
}
if (!isset($_GET['type'])) {
  echo "missing type prameter";
  die();
}

$email = $_GET['email'];
$type = intval($_GET['type']);

require 'functions.php';

newUser($email, $type, 'f.pinkerton@sjasd.ca');
