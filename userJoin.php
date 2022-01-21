<?php
  // open seesion amd create session variable
  session_start();
  $_SESSION['joinStage'] = 1;

  if ($_SESSION['joinStage'] > 1) {
    // if the user has already entered the join code, then redirect to the next page
    header("Location: userCreation.php");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <title id='title'>Enter Join Code</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <div class='align-middle'>
      <center>
        <div style="margin-top: 10px;"></div>
        <div class='card' style="width: 75%;" id='card'>
          <div class='card-header'>
            <h1>Sign Up</h1>
          </div>
          <div id='firstPage' class='card-body'>
            <div class='row'>
              <form action='/' method='post' style="width: max-content;">

                <!-- Join code input -->
                <div class='d-flex align-items-center' style="width: fit-content;">
                  <label for="joinCode" style="font-size:20px;font-weight:500" class="m-0" >Enter Join Code</label>
                </div>
                <div class="col-sm-9-5 col-12">
                  <input type="text" id="joinCode" placeholder="Code" class="form-control"/>
                  <div style="margin-top: 5px;"></div>
                </div>
                <br>
                <!-- email input -->
                <div class='d-flex align-items-center' style="width: fit-content;">
                  <label for="email" class="m-0" style="font-size:20px;font-weight:500">Email</label>
                </div>
                <div class="col-sm-9-5 col-12">
                  <input type="email" id="email" placeholder="Email" class="form-control"/>
                  <div style="margin-top: 5px;"></div>
                </div>

                <!-- Submit button -->
                <input id='continue' type='submit' class='btn btn-primary' value='Continue' style="margin-top: 10px;margin-bottom: 10px;"/>
              </form>

              <!--  hidden error page -->
              <div id='errorPage' class='card-body' style="display: none;">
                <div class='row'>
                  <div class='col-sm-9-5 col-12'>
                    <div class='alert alert-danger' role='alert'>
                      <h4 class='alert-heading'>Error</h4>
                      <p>
                        <span id='errorMessage'></span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
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

  if (isset($_POST)) {
    require_once('../config.php'); // get the sql connection
    $action = $_POST['action'];  // get value of 'action' from post request

    // get values from post request
    $joinCode = $_POST['joinCode'];
    $email = $_POST['email'];

    if (!isset($joinCode) || !isset($email)) { // if join code or email is not set
      echo "<script>document.getElementById('errorMessage').innerHTML = 'Please enter a join code and email.';</script>";
      echo "<script>document.getElementById('errorPage').style.display = 'block';</script>";
      exit();
    }

    // check if join code is valid for given email
    $sql = "SELECT * FROM users WHERE email = '$email' AND joinCode = '$joinCode'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) { // if join code is not valid
      echo "<script>document.getElementById('errorMessage').innerHTML = 'Invalid join code.';</script>";
      echo "<script>document.getElementById('errorPage').style.display = 'block';</script>";
      exit();
    } else { // if join code is valid
      // set session variables
      $_SESSION['joinStage'] = 2;
      $_SESSION['email'] = $email;
      $_SESSION['joinCode'] = $joinCode;

      // redirect to next page
      header("Location: userCreation.php");
    }

  }
