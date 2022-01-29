<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
  <div style="margin-top: 10px;"></div>
  <center>
    <div class="card" style="width: 40%;">
      <div class="card-header">
        <h3>Login</h3>
      </div>
      <div class="card-body">
        <form action="login.php">
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
  </center>
</body>
</html>

<script>
  // if continue button is clicked or if enter is pressed
  document.addEventListener('keydown', function(e) {
    if (e.keyCode == 13) {
      document.getElementById('continue').click();
    }
  });
</script>

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

    // fetch user from database with email (password, type)
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) { // if user exists
      $accountType = $result->fetch_assoc()['type']; // get account type
      $passwordHash = $result->fetch_assoc()['password']; // get password hash

      if (password_verify($password, $passwordHash)) { // if password is correct
        $pre = accountType($accountType); // get the account type and email array
        // split array into account type and decripted email
        $accountType = $pre[0];
        $decriptedEmail = $pre[1];

        // if emails arnt the same
        if ($email != $decriptedEmail) {
          echo "<script>alert('Somthing funky happened inside the program. An alert had been sent to the system admin and will be resolved ASAP! \nIn the meantime hang tight and an email will be sent when fixed!');</script>";
          // send email to admin
          $to = 'f.pinkerton@sjasd.ca';
          $subject = 'Error in login.php';
          $message = 'The email in the database is not the same as the email in the database. \nEmail in database: '.$decriptedEmail.' \nEmail in form: '.$email;
          $headers = 'From: f.pinkerton@sjasd.ca';
          mail($to, $subject, $message, $headers);
        }

      } else { // if password is incorrect
        echo "<script>alert('Invalid password');</script>";
      }
    } else { // if user does not exist
      echo "<script>alert(this spelled right? 'User can not be found. Please Try again. \nIf problems persist contact an administrator or \"f.pinkerton@sjasd.ca\"');</script>";
      return;
    }
  }
