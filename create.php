<?php
if (!isset($_GET['email'])) {
  echo "missing email parameter";
  die();
}
if (!isset($_GET['type'])) {
  echo "missing type parameter";
  die();
}

$email = $_GET['email'];
$type = intval($_GET['type']);

require 'functions.php';

newUser($email, $type);
