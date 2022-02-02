<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  session_start(); // start the session
  if (!$_SESSION['joinStage'] == 2) { // if user has not completed the join process
    header("Location: userJoin.php"); // redirect to join page
  } else {
    require_once('../config.php'); // get the sql connection

    // get values from session variables
    $email = $_SESSION['email'];
    $joinCode = $_SESSION['joinCode'];
    $accountType = $_SESSION['accountType'];
    var_dump($accountType);
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title id='title'>Create User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
  <div style="margin-top: 10px;"></div>
    <center>
      <div class="card" style="width: 40%;" >
        <div class="card-header">
          <h1>Create User</h1>
        </div>
        <div class="card-body">
          <form action='userCreation.php' method='post'>
            <!-- First name -->
            <label for="firstName" class="m-0">First Name</label>
            <input type="text" id="firstName" name='firstName' placeholder="Enter First Name" class="form-control"/>
            <div style="margin-top: 10px;"></div>

            <!-- Last name -->
            <label for="lastName" class="m-0">Last Name</label>
            <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" class="form-control"/>
            <div style="margin-top: 10px;"></div>

            <!-- title slecter -->
            <label for="title" class="m-0">Title</label>
            <select id="title" name='title' class="form-control">
              <option>Select Title</option>
              <option>Mr.</option>
              <option>Mrs.</option>
              <option>Miss.</option>
              <option>Ms.</option>
              <option>Mx.</option>
              <option>First Name</option>
            </select>
            

            <!-- password -->
            <label for="password" class="m-0">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter Password" class="form-control"/>
            <div style="margin-top: 10px;"></div>

            <!-- Confirm password -->
            <label for="confirmPassword" class="m-0">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" class="form-control"/>
            <div style="margin-top: 10px;"></div>

            <!-- Submit button -->
            <input id='submit' type='submit' class='btn btn-primary' value='Submit' style="margin-top: 10px;margin-bottom: 10px;"/>
          </form>
        </div>
      </div>
    </center>
  </body>
</html>

<?php

  // if the user has submitted the form
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // fetch the values from the form
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $title = $_POST['title'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password != $confirmPassword) { // check if the passwords match
      echo "<script>alert('Passwords do not match');</script>";
    } else {
      // check if email matchs the one in the db
      $stmt = $conn->prepare("SELECT email FROM pre_user WHERE otp = ?");
      $stmt->bind_param("s", $joinCode);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->reset();

      if ($result->num_rows > 0) { // if there is a match
        $row = $result->fetch_assoc();
        $emailEB = $row['email'];
        if ($email == $emailEB) { // if the email matches the join code

          $card = "<br>+--------------------------------------+<br>";
          $card .= "| Email: " . $email . "<br>";
          $card .= "| First name: " . $firstName . "<br>";
          $card .= "| Last name: " . $lastName . "<br>";
          $card .= "| Title: " . $title . "<br>";
          $card .= "| Password: " . $password . "<br>";
          $card .= "| Account Type: " . $accountType . "<br>";
          $card .= "+--------------------------------------+<br>";

          // send the card to the user
          echo $card;

          // insert the user into the database
          $stmt = $conn->prepare("INSERT INTO users WHERE email = ?, first_name = ?, last_name = ?, title = ?, password = ?, type = ?");
          $stmt->bind_param("sssssi", $email, $firstName, $lastName, $title, $password, $accountType);
          $stmt->execute();
          // get rows affected
          $rowsAffected = $stmt->affected_rows;
          if ($rowsAffected > 0) { // if the user was inserted
            echo "<script>alert('User created successfully');</script>";
          } else { // if the user was not inserted
            echo "<script>alert('User could not be created');</script>";
          }

          // delete the pre_user entry
          $stmt = $conn->prepare("DELETE FROM pre_user WHERE otp = ?");
          $stmt->bind_param("s", $joinCode);
          $stmt->execute();

          // delete the session variables
          unset($_SESSION['email']);
          unset($_SESSION['joinCode']);
          unset($_SESSION['accountType']);
          unset($_SESSION['joinStage']);
          session_destroy();

          // redirect to login page
          echo "<script>alert('old code deleted successfully');</script>";
          echo "<script>window.location.href = 'userJoin.php';</script>";
        } else { // if the email does not match the join code
          echo "<script>alert('Email does not match the join code');</script>";
        }
        
      } else { // if there is no match
        echo "<script>alert('Invalid code');</script>";
      }
    }
  }