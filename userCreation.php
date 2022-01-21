<?php
  session_start(); // start the session
  if (!$_SESSION['joinStage'] == 2) { // if user has not completed the join process
    header("Location: userJoin.php"); // redirect to join page
  } else {
    // get values from session variables
    $email = $_SESSION['email'];
    $joinCode = $_SESSION['joinCode'];
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <title id='title'>Create User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <div style="margin-top: 10 px;"></div>
    <div class="card">
      <div class="card-header">
        <h1>Create User</h1>
      </div>
      <div class="card-body">
        <form action='/' method='post'>
          <!-- First name -->
          <label for="firstName" class="m-0">First Name</label>
          <input type="text" id="firstName" placeholder="Enter First Name" class="form-control"/>
          <div style="margin-top: 10px;"></div>

          <!-- Last name -->
          <label for="lastName" class="m-0">Last Name</label>
          <input type="text" id="lastName" placeholder="Enter Last Name" class="form-control"/>
          <div style="margin-top: 10px;"></div>

          <!-- title slecter -->
          <label for="title" class="m-0">Title</label>
          <select id="title" class="form-control">
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
          <input type="password" id="password" placeholder="Enter Password" class="form-control"/>
          <div style="margin-top: 10px;"></div>

          <!-- Confirm password -->
          <label for="confirmPassword" class="m-0">Confirm Password</label>
          <input type="password" id="confirmPassword" placeholder="Confirm Password" class="form-control"/>
          <div style="margin-top: 10px;"></div>

          <input type='button' id='submit' class='btn btn-primary' value='Submit'/>
        </form>
      </div>
    </div>
  </body>
</html>

<?php
  // if the user has submitted the form
  if (isset($_POST)) {
    require_once('../config.php'); // get the sql connection

    // fetch the values from the form
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $title = $_POST['title'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    
  }