<?php
  session_start(); // start the session
  if (!$_SESSION['joinStage'] == 2) { // if user has not completed the join process
    header("Location: userJoin.php"); // redirect to join page
  } else {
    require_once('../config.php'); // get the sql connection

    // get values from session variables
    $email = $_SESSION['email'];
    $joinCode = $_SESSION['joinCode'];

    $stmt = $conn->prepare("SELECT type FROM pre_user WHERE email = ? and otp = ?"); // prepare the sql statement
    $stmt->bind_param("ss", $email, $joinCode); // bind the parameters
    $stmt->execute(); // execute the sql statement
    $result = $stmt->get_result(); // get the result

    $accoutType = $result->fetch_assoc()['type']; // get the type of user from the result
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

<script>

  // if continue button is clicked or if enter is pressed
  document.addEventListener('keydown', function(e) {
    if (e.keyCode == 13) {
      document.getElementById('submit').click(); // click the submit button
    }
  });

</script>

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

      $password = password_hash($password, PASSWORD_DEFAULT); // hash the password

      // insert the values into the user table
      $stmt = $conn->prepare("INSERT INTO users SET `email` = ?, `first_name` = ?, `last_name` = ?, `title` = ?, `password` = ?, `type` = ?"); // prepare the sql statement
      $stmt->bind_param("ssssss", $email, $firstName, $lastName, $title, $password, $accoutType); // bind the parameters
      $stmt->execute(); // execute the sql statement


      // check if the query was successful
      if ($stmt->affected_rows == 1) {
        // delete from pre_user table
        $stmt = $conn->prepare("DELETE FROM pre_user WHERE email = ? and otp = ?"); // prepare the sql statement
        $stmt->bind_param("ss", $email, $joinCode); // bind the parameters
        $stmt->execute(); // execute the sql statement

        echo "<script>alert('User Created');</script>";
        // echo "<script>window.location.href = '../index.php';</script>";
      } else {
        echo "<script>alert('Error creating user');</script>";
      }
    }
  }