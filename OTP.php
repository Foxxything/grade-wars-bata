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
 
  function accountTypeEncrypt($type, $email) {
    $pre = $type . "|" . $email;
  
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = random_bytes($iv_length);
    $encryption_key = openssl_digest('ThatWasAlotOfEffortToGetThis', 'SHA256', true);
    $encryption = openssl_encrypt($pre, $ciphering, $encryption_key, $options, $encryption_iv);
  
    return $encryption;
  }
 
  function accountTypeDecrypt($type) {
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $decryption_iv = random_bytes($iv_length);
    $decryption_key = openssl_digest('ThatWasAlotOfEffortToGetThis', 'SHA256', true);
    $decryption = openssl_decrypt($type, $ciphering, $decryption_key, $options, $decryption_iv);
  
    return explode("|", $decryption);
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
      $accountType = accountTypeEncrypt($accountType, $email); // make the account type
      $decriypedAccountType = accountTypeDecrypt($accountType); // decrypt the account type
      $accountType = $decriypedAccountType[0]; // get the account type
 
      $sql = "INSERT INTO `pre_user` (`otp`, `email`, `type`) VALUES " . $code . "," . $email . "," . $accountType;
      echo $sql."\n";
      
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
