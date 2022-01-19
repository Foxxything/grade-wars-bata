<?php
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
    $key = openssl_digest('ThatWasAlotOfEffortToGetThis', 'SHA256', true);

    if($email != 'none') {
      // encript
      $encriptionString = $email . "|" . $typeString;
      $encryption = openssl_encrypt($encriptionString, $ciphering, $key, $options, $iv);
      return $encryption;
    } else {
      // decript

      $decryption = openssl_decrypt($typeString, $ciphering, $key, $options, $iv);
      var_dump($decryption);
      echo "\n";
      return explode("|", $decryption);
    }

  }

  // if the form is submitted
  if(true){
    // get the number of OTP
    $otp = 3;
    $accountType = 1;
 
    $accountTypeKey = [
      "none" => 0,
      "teacher" => 1,
      "admin" => 2,
      "both" => 3
    ];
 
    // create an array
    $otp_array = array();
    // loop through the number of OTP
    for($i=0; $i<$otp; $i++){
      // make an dummy email
      $email = rand(1000000, 9999999) . "@sjasd.ca";
      $code = makeCode($email, $accountType); // make the join code
      $accountType = accountType($accountType, $email); // make the account type
      $decriypedAccountType = accountType($accountType)[1]; // decrypt the account type
      var_dump($decriypedAccountType);
      echo "\n";
 
      $sql = "INSERT INTO `pre_user` (`otp`, `email`, `type`) VALUES " . $code . "," . $email . "," . $accountType;
      // echo $sql."\n";
      
      $finalCode = array(
        "email" => $email,
        "code" => $code,
        "accountType" => array_search($decriypedAccountType, $accountTypeKey)
      );
 
      // push the code to the array
      array_push($otp_array, $finalCode);
    }
    
    $json = json_encode($otp_array);
    echo $json;
}
?>
