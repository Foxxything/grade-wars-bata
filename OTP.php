<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require('config.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>OTP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/bootstrap.css">
  </head>
  <body>
    <div class='align-middle'>
      <center>
        <div class="card" style="width: max-content;">
          <div class="card-header">
            <h3>OTP Generator</h3>
          </div>
          <div class="card-body">
            <form action="OTP.php" method="post">
              <div class="form-group">
                <label for="amount">Amount of OTPs</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount of OTPs">
              </div>
              <div class="form-group">
                <label for="type">Type of OTP</label>
                <select class="form-control" id="type" name="type">
                  <option value="1">Teacher</option>
                  <option value="2">Admin</option>
                  <option value="3">Both</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Generate OTP</button>
            </form>
          </div>
        </div>
      </center>
    </div>
  </body>
</html>

<?php

  // global variables
  $otp_array = array();

  $accountTypeKey = [ // used to get name of account type
    "none" => 0,
    "teacher" => 1,
    "admin" => 2,
    "both" => 3
  ];

  // make the join code
  function makeCode($email, $accountType) {
    $code = rand(100000, 999999); // example: 123456
    $hash = md5($email . $accountType . $code); // example: e10adc3949ba59abbe56e057f20f883e
    $semiFinalCode = array();

    for ($i = 0; $i < 6; $i++) {
      // randoom character from the hash
      $semiFinalCode[$i] = $hash[rand(0, strlen($hash) - 1)];
    }
    
    return implode($semiFinalCode); // example: 8f8be9
  }

  function accountType($typeString, $email='none') {
    // consts
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $iv = "1850374592974628";
    $key = openssl_digest(KEY, 'SHA256', true);

    if($email != 'none') {
      // encript
      $encriptionString = $email . "|" . $typeString;
      $encryption = openssl_encrypt($encriptionString, $ciphering, $key, $options, $iv);
      return $encryption;
    } else {
      // decript

      $decryption = openssl_decrypt($typeString, $ciphering, $key, $options, $iv);
      echo "\n";
      return explode("|", $decryption);
    }
  }

  // Check if the form was submitted and the values are not empty
  if(isset($_POST) && isset($_POST['amount']) && isset($_POST['type'])) {
    // Get the values from the form
    $amount = $_POST['amount'];
    $preAccountType = $_POST['type'];

    for($i=0; $i<$amount; $i++){
      $email = rand(1000000, 9999999) . "@sjasd.ca"; // make an dummy email (example: 123456@sjasd.ca)
      $code = makeCode($email, $preAccountType); // make the join code
      $accountType = accountType($preAccountType, $email); // make the account type
      //$decriypedAccountType = accountType($accountType)[1]; // decrypt the account type
 
      // echo "<br>";
      // echo "+--------------------------------------+<br>";
      // echo "| Email: " . $email . "<br>";
      // echo "| Code: " . $code . "<br>";
      // echo "| Accout type code: " . $preAccountType . "<br>";
      // echo "| Account type: " . $accountType . "<br>";
      // echo "| Decoded Account: " . $decriypedAccountType . "<br>";
      // echo "+--------------------------------------+<br>";
      // echo "<br>";

      // get the account type in plain text
      $accountTypeStr = array_search($preAccountType, $accountTypeKey);

      $stmt = $conn->prepare("INSERT INTO pre_user (otp, email, type, type_plaintext, date) VALUES (?, ?, ?, ?, NOW())");
      $stmt->bind_param("ssss", $email, $code, $accountType, $accountTypeStr);
      $stmt->execute();

      if($conn -> error) {
        echo "Error: " . $conn -> error;
      }

      // $finalCode = array(
      //   "email" => $email,
      //   "code" => $code,
      //   "accountType" => array_search($decriypedAccountType, $accountTypeKey)
      // );
 
      // push the code to the array
      // array_push($otp_array, $finalCode);
    }
  }
?>