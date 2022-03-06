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
    $mail->Username = 'noreply@cshcgradewars.com';
    $mail->Password = NO_REPLY;
    $mail->setFrom('noreply@cshcgradewars.com', 'No Reply');
  } elseif ($from == 'admin') {
    $mail->Username = 'admin@cshcgradewars.com';
    $mail->Password = ADMIN;
    $mail->setFrom('admin@cshcgradewars.com', 'Grade Wars');
  } else {
    throw new Exception('Invalid sender');
  }
  $mail->addCustomHeader('X-mailer', 'X-Mailer: PHP/' . phpversion(). 'SCHS Gradewars Program');
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
  $admin = 'admin@cshcgradewars.com';
  $subject = 'Logger';
  $body = $message;
  sendEmail('admin', $admin, $subject, $body);
}

function DBlogger($type, $message) {
  $conn = $GLOBALS['conn'];
  $type = $conn->real_escape_string($type);
  $message = $conn->real_escape_string($message);
  $data = json_decode($message);
  if (is_null($data)) {
    // $message is not json
    $json = ['message' => $message];
    $message = json_encode($json);
  }
  $sql = "INSERT INTO `logs` (`type`, `message`) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ss', $type, $message);

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

function populateTables($email) {
  $studentCounted = [
    'pre_student_count',
    'counted_student_count',
  ];
  $foodhamper = [
    'pre_food_hamper',
    'counted_food_hamper'
  ];
  foreach ($studentCounted as $table) {
    $stmt = $GLOBALS['conn']->prepare("INSERT INTO $table (teacher_email) VALUES (?)");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->reset();
    $stmt->close();
  }
  foreach ($foodhamper as $table) {
    for ($grade = 9; $grade <= 12; $grade++) {
      $sql = "INSERT INTO $table (
        teacher_email,
        `non_perishable_food_Items`,
        peanut_butter,
        `toilet_paper_paper_towel`,
        `toothbrush_toothpaste_floss`,
        box_or_bag_of_feminine_products,
        `new_socks_new_underwear`,
        `laudry_soap_fabric_softner`,
        childrens_book,
        grade
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $GLOBALS['conn']->prepare($sql);
      $zero = 0;
      $stmt->bind_param("siiiiiiiii", $email, $zero, $zero, $zero, $zero, $zero, $zero, $zero, $zero, $grade);
      $stmt->execute();
      $stmt->reset();
      $stmt->close();
    }
  }
}

/**
 * @param string $email of the deleted user
 * @param string $whoAuthorized the email of the person who authorized the deletion
 */
function DeleteUser($email, $whoAuthorized) {
  $tables = [
    'pre_user',
    'pre_student_count',
    'pre_food_hamper',
    'counted_student_count',
    'counted_food_hamper',
    'users'
  ];
  foreach ($tables as $table) {
    $stmt = $GLOBALS['conn']->prepare("DELETE FROM $table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->reset();
    $stmt->close();
  }
  $adminMessage = "
    <h1>User Deleted</h1>
    <p>
      A user has been deleted from the GradeWars Program.
      <br>
      Email: $email
      <br>
      Deleted By: $whoAuthorized
    </p>
  ";
  logger($adminMessage);
  
  $clientMessage = "
    <h1>User Deleted</h1>
    <p>
      Your account has been deleted from the GradeWars Program.<br>
      Please contact the administrator if you believe this is an error.
      <a href='mailto:admin@cshcgradewars.com?subject=User Deleted'>
        Contact Admin
      </a>
    </p>
  ";
  sendEmail('noreply', $email, 'User Deleted', $clientMessage);
}