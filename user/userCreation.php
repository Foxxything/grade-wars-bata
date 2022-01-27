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
    <link rel="stylesheet" href="../css/bootstrap.css">
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
        <form action='userCreation.php' method='post'>
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

          <!-- Submit button -->
          <input id='submit' type='submit' class='btn btn-primary' value='Submit' style="margin-top: 10px;margin-bottom: 10px;"/>
        </form>
      </div>
    </div>
  </body>
</html>

<script>

  // if continue button is clicked or if enter is pressed
  document.addEventListener('keydown', function(e) {
    if (e.keyCode == 13) {
      document.getElementById('submit').click();
    }
  });

  // if alt+ctrl+shift is pressed
  document.addEventListener('keydown', function(e) {
    if (e.altKey && e.ctrlKey && e.shiftKey) {
      <?php
        // distroy session variables
        session_destroy();
      ?>
    }
  });

</script>

<?php
  // if the user has submitted the form


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<script>console.log('Form Submitted');</script>";

    require_once('../config.php'); // get the sql connection

    class debuging {
      public function __construct($firstName, $lastName, $title, $password, $confirmPassword) {
        echo "<script>console.log('Debug Objects Created');</script>";
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->title = $title;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
      }
  
      public function getDebugArray() {
        $debugArray = array(
          'firstName' => $this->firstName,
          'lastName' => $this->lastName,
          'title' => $this->title,
          'password' => $this->password,
          'confirmPassword' => $this->confirmPassword
        );
        return $debugArray;
      }

      public function __destruct()
      {
        echo "<script>console.log('Debug Objects Destroyed');</script>";
      }
    }

    // fetch the values from the form
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $title = $_POST['title'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $debug = new debuging($firstName, $lastName, $title, $password, $confirmPassword); // create a new debug object
    $debugJson = json_encode($debug->getDebugArray()); // convert the debug object to json
    $debug = null; // destroy the debug object

    echo "<script>console.log('Debug Objects Created: $debugJson');</script>";
    echo "<pre> $debugJson </pre>";
  }