<?php
require_once 'config.php'; // get the sql connection

if (! function_exists('str_ends_with')) {
  function str_ends_with(string $haystack, string $needle): bool
  {
    $needle_len = strlen($needle);
    return ($needle_len === 0 || 0 === substr_compare($haystack, $needle, - $needle_len));
  }
}

/**
 * @param string $email the email to check
 * @return bool true if the email is valid and false if it is not
 */
function validEmail(string $email):bool {
  if (($email = filter_var($email, FILTER_VALIDATE_EMAIL)) !== false) { // Check if email is valid
    if (str_ends_with($email, '@sjasd.ca')) { // Check if email ends with @sjasd.ca
      echo "<script>console.log('Valid SJASD email');</script>";
      return true;
    } else { // Email does not end with @sjasd.ca
      echo "<script>console.log('Invalid SJASD email');</script>";
      return false;
    }
  } else { // Email is not valid
    echo "<script>console.log('Invalid email');</script>";
    return false;
  }
}

function accountType($typeString, $email='none') {
  // const's
  $ciphering = "AES-128-CTR";
  $options = 0;
  $key = openssl_digest(KEY, 'SHA256', true);

  if($email != 'none') {
    // encrypt
    $encryptionString = $email . "|" . $typeString;
    return openssl_encrypt($encryptionString, $ciphering, $key, $options, IV);
  } else {
    // decrypt
    $decryption = openssl_decrypt($typeString, $ciphering, $key, $options, IV);
    return explode("|", $decryption); // return array of email and type
  }
}

/**
 * @param string $email of the user
 * @param string $accountType of the user
 * @return string
 */
function makeCode(string $email, string $accountType): string { // make the join code
  $code = rand(100000, 999999); // example: 123456
  $hash = hash('sha256', $email . $accountType . $code);
  $semiFinalCode = array();

  for ($i = 0; $i < 6; $i++) {
    // random character from the hash
    $semiFinalCode[$i] = $hash[rand(0, strlen($hash) - 1)];
  }
  
  return implode($semiFinalCode); // example: 8f8be9
}

/**
 * @param string $message to send to the admin
 * @param string $subject of the email
 */
function messageAdmin(string $subject, string $message) {
  $to = EMAIL; // send message to admin email

  // mail headers
  $headers = 'X-Priority: 1' . "\r\n";
  $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
  $headers .= 'From: ' . ADMIN_FROM . "\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

  mail($to, $subject, $message, $headers); // send the message
}