<?php
$goodEmail = 'f.pinkerton@sjasd.ca';
$badEmail = 'howdy@gmail.com';

if (! function_exists('str_ends_with')) {
  /**
   * @param string $haystack The string to search in.
   * @param string $needle The string to search for.
   * @return bool True if the $haystack ends with the $needle.
   */
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
function valadateEmail(string $email):bool {
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

valadateEmail($goodEmail); // Valid email address
valadateEmail($badEmail); // Invalid email address