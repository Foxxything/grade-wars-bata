<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  session_start();
  // if session var accType is 1 (teacher) or 2 (admin) or 3 (both) then redirect to dashboard
  if (isset($_SESSION['AccType'])) {
    echo "You are logged in as " . $_SESSION['AccType'];
    if ($_SESSION['AccType'] == 1) {
      echo "<script>alert('login line 10')</script>";
      //header('Location: ./accounts/teacher.html');
    } else if ($_SESSION['AccType'] == 2) {
      echo "<script>alert('login line 13')</script>";
      //header('Location: ./accounts/admin.html');
    } else if ($_SESSION['AccType'] == 3) {
      echo "<script>alert('login line 16')</script>";
      //header('Location: ./accounts/both.php');
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
  <div style="margin-top: 10px;"></div>
  <div style="text-align: center;">
    <div class="card" style="width: 40%;">
      <div class="card-header">
        <h3>Login</h3>
      </div>
      <div class="card-body">
        <form action="login.php" method="POST">
          <!-- Email -->
          <label for="email" class="m-0">Email</label>
          <input type="text" id="email" name='email' placeholder="Enter Email" class="form-control"/>
          <div style="margin-top: 10px;"></div>
          
          <!-- Password -->
          <label for="password" class="m-0">Password</label>
          <input type="password" id="password" name='password' placeholder="Enter Password" class="form-control"/>
          <div style="margin-top: 10px;"></div>

          <!-- Submit -->
          <input id='submit' type="submit" value="Login" class="btn btn-primary"/>
          <div style="margin-bottom: 10px;"></div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>

<?php
  // Path: login.php

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get email and password from form
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once 'config.php'; // get the sql connection
    require 'functions.php'; // get the functions

    // check if email is valid
    if (!validEmail($email)) {
      echo "<script>alert('Invalid email');</script>";
      return;
    }
    echo '<script>console.log("Valid email")</script>';
    // fetch user from database with email (password, type)
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) { // if user exists
      $account = $result->fetch_assoc();
      $accountType = $account['type'];
      $passwordHash = $account['password'];
      $firstName = $account['first_name'];
      $lastName = $account['last_name'];
      $title = $account['title'];

      if (password_verify($password, $passwordHash)) { // if password is correct
        echo '<script>console.log("Password correct")</script>';
        $pre = accountType($accountType); // get the account type and email array
        // split array into account type and decrypted email
        $accountType = $pre[1];
        $decryptedEmail = $pre[0];
        
        if ($email != $decryptedEmail) { // if emails arnt the same
          echo "<script>alert('Something funky happened inside the program. An alert had been sent to the system admin and will be resolved ASAP! In the meantime hang tight and an email will be sent when fixed!');</script>";
          
          // send email to admin
          $subject = 'Email Mismatch from '.$email;
          $message = 'The email address '.$email.' was used to login but the email address '.$decryptedEmail.' was stored in the database. Requested by '.$_SERVER['REMOTE_ADDR'] . ' on ' . date('Y-m-d H:i:s'). '. Please resolve this issue as soon as possible.';
          messageAdmin($subject, $message);
          die();
        }
        echo '<script>console.log("Email correct")</script>';

        $user = $result->fetch_assoc();
        $_SESSION['accountType'] = $accountType; // set session account type
        $_SESSION['email'] = $email; // set session email
        $_SESSION['firstName'] = $firstName; // set session first name
        $_SESSION['lastName'] = $lastName; // set session last name
        $_SESSION['title'] = $title; // set session title

        $card = '<br>+------------------------+';
        $card .= "<br>| Account Type: " . $accountType;
        $card .= "<br>| Email: " . $email;
        $card .= "<br>| Decripted Email: " . $decryptedEmail;
        $card .= "<br>| First Name: " . $firstName;
        $card .= "<br>| Last Name: " . $lastName;
        $card .= "<br>| Title: " . $title;
        $card .= "<br>+------------------------+";
        //echo $card;

        // redirect to account page
        if ($accountType == 1) {
          $_SESSION['AccType'] = 1;
          echo '<script>console.log("Redirecting to teacher page")</script>';
          header('Location: ./accounts/teacher.html');
        } else if ($accountType == 2) {
          $_SESSION['AccType'] = 2;
          echo '<script>console.log("Redirecting to admin page")</script>';
          header('Location: ./accounts/admin.html');
        } else if ($accountType == 3) {
          $_SESSION['AccType'] = 3;
          echo '<script>console.log("Redirecting to both page")</script>';
          header('Location: ./accounts/both.php');
        }
      } else { // if password is incorrect
        echo "<script>alert('Invalid password');</script>";
      }
    } else { // if user does not exist
      echo "<script>alert('User can not be found. Please Try again. If problems persist contact \"f.pinkerton@sjasd.ca\"');</script>";
      die();
    }
  }



