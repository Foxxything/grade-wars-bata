<?php
require_once 'config.php'; // get the sql connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';


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
  // consts
  $ciphering = "AES-128-CTR";
  $iv_length = openssl_cipher_iv_length($ciphering);
  $options = 0;
  $key = openssl_digest(KEY, 'SHA256', true);

  if($email != 'none') {
    // encript
    $encriptionString = $email . "|" . $typeString;
    $encryption = openssl_encrypt($encriptionString, $ciphering, $key, $options, IV);
    return $encryption;
  } else {
    // decript
    $decryption = openssl_decrypt($typeString, $ciphering, $key, $options, IV);
    return explode("|", $decryption); // return array of email and type
  }
}

/**
 * @param string $email of the user
 * @param string $accountType of the user
 */
function makeCode(string $email, string $accountType) { // make the join code
  $code = rand(100000, 999999); // example: 123456
  $hash = hash('sha256', $email . $accountType . $code);
  $semiFinalCode = array();

  for ($i = 0; $i < 6; $i++) {
    // randoom character from the hash
    $semiFinalCode[$i] = $hash[rand(0, strlen($hash) - 1)];
  }
  
  return implode($semiFinalCode); // example: 8f8be9
}

/**
 * @param string $from - the email of the sender ex: 'gradewars' or 'noreply'
 * @param string $to - the email of the receiver
 * @param string $subject - the subject of the email
 * @param string $message - the message of the email
 * @return bool true if the email was sent and error if it was not
 */
function sendEmail($from, $to, $subject, $body) {
  $mail = new PHPMailer();

  //Tell PHPMailer to use SMTP
  $mail->isSMTP();
  $mail->SMTPDebug = SMTP::DEBUG_OFF;

  $mail->Host = 'box5774.bluehost.com';
  $mail->Port = 465;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->SMTPAuth = true;

  if ($from == 'noreply') {
    $mail->Username = 'noreply@foxxything.com';
    $mail->Password = NO_REPLY;
    $mail->setFrom('noreply@foxxything.com', 'No Reply');
  } elseif ($from == 'gradewars') {
    $mail->Username = 'gradewars@foxxything.com';
    $mail->Password = GRADE_WARS;
    $mail->setFrom('gradewars@foxxything.com', 'Grade Wars');
  } else {
    throw new Exception('Invalid sender');
  }

  $mail->addAddress($to);
  $mail->Subject = $subject;
  $mail->msgHTML($body);

  if (!$mail->send()) {
    return $mail->ErrorInfo;
  } else {
    return true;
  }
  $mail->smtpClose();
}

function logger($message) {
{
  $admin = 'gradewars@foxxything.com';
  $subject = 'Logger';
  $body = $message;
  sendEmail('noreply', $admin, $subject, $body);
}

/**
 * @param string $email of the new user
 * @param int $type of the new user
 * @param string $madeBy the email of the person who made the account
 * @description: create a new user and emails both admin and user
 */
function newUser(string $email, int $type, string $madeBy) { // create a new pre_user

  $code = makeCode($email, $type); // make the join code
  $accountType = accountType($type, $email); // make the account type

  $stmt = $GLOBALS['conn']->prepare("INSERT INTO pre_user (otp, email, type) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $code, $email, $accountType);
  $stmt->execute();
  $stmt->reset();
  $stmt->close();

  // message to send to the user
  $message = "
    <h1>Welcome to the GradeWars Program</h1>
    <p>
      You have been invited to join the GradeWars program.<br>
      Please click the link below to confirm your email and join the program.<br>
      <a href='http://206.45.49.15/beta/user/userJoin.php?joinCode=$code&email=$email'>
        GradeWars Sign Up
      </a>
    </p>
  ";
  echo $message;

  $adminMessage = "
    <h1>New User</h1>
    <p>
      A new user has been added to the GradeWars Program.
      <br>
      Email: $email
      <br>
      Account Type: $type
      <br>
      Made By: $madeBy
    </p>
  ";

  sendEmail('noreply', $email, 'Welcome to GradeWars', $message); // send email to user
  logger($adminMessage); // log the new user
}