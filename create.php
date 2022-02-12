<?php
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

newUser($email, $type);
