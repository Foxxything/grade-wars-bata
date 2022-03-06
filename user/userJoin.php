<?php
  // open seesion amd create session variable
  session_start();

  if ($_SESSION['joinStage'] > 1) {
    // if the user has already entered the join code, then redirect to the next page
    header("Location: userCreation.php");
  }
  $_SESSION['joinStage'] = 1;

  require('../functions.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <title id='title'>Enter Join Code</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <div class='align-middle'>
      <center>
        <div style="margin-top: 10px;"></div>
        <div class='card' style="width: 60%;" id='card'>
          <div class='card-header'>
            <h1>Sign Up</h1>
          </div>
          <div id='firstPage' class='card-body'>
            <div class='row'>
              <form action='userJoin.php' method='get' style="width: 60%;">

                <!-- Join code input -->
                <div class='d-flex align-items-center' style="width: fit-content;">
                  <label for="joinCode" style="font-size:20px;font-weight:500" class="m-0" >Enter Join Code</label>
                </div>
                <div class="col-sm-9-5 col-12">
                  <input type="text" id="joinCode" name='joinCode' placeholder="Code" class="form-control"/>
                  <div style="margin-top: 5px;"></div>
                </div>
                <br>
                <!-- email input -->
                <div class='d-flex align-items-center' style="width: fit-content;">
                  <label for="email" class="m-0" style="font-size:20px;font-weight:500">Email</label>
                </div>
                <div class="col-sm-9-5 col-12">
                  <input type="email" id="email" name='email' placeholder="Email" class="form-control"/>
                  <div style="margin-top: 5px;"></div>
                </div>

                <!-- Submit button -->
                <input id='continue' type='submit' class='btn btn-primary' value='Continue' style="margin-top: 10px;margin-bottom: 10px;"/>
              </form>
            </div>
          </div>
      </center>
    </div>
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
  // Path: userJoin.php

  if (isset($_GET['joinCode'])) {
    require_once('../config.php'); // get the sql connection

    // get values from get request
    $joinCode = $_GET['joinCode'];
    $email = $_GET['email'];

    if (!isset($joinCode) || !isset($email)) { // if join code or email is not set
      echo "<script>alert('Please enter a join code and email.');</script>";
    }

    // check if join code is valid by get type and storing
    $stmt = $conn->prepare("SELECT type FROM pre_user WHERE email = ? and otp = ?"); // get the type of the user
      $stmt->bind_param("ss", $email, $joinCode); // bind the parameters
      $stmt->execute(); // execute the query
      $result = $stmt->get_result(); // get the result
      $stmt->reset(); // reset the query 
      $stmt->close(); // close the query

    if ($result->num_rows == 0) { // if the join code is not valid
      echo "<script>alert('Invalid join code.');</script>";
    } else { // if join code is valid
      // set session variables
      $rows = $result->fetch_assoc();
      $_SESSION['joinStage'] = 2;
      $_SESSION['email'] = $email;
      $_SESSION['joinCode'] = $joinCode;
      $_SESSION['accountType'] = intval(accountType($rows['type'])[1]);

      header("Location: userCreation.php"); // redirect to next page
    }
  }
