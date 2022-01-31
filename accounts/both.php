<?php
  session_start(); // start session

  if (!$_SESSION['AccType'] == '3' ) { // if no email in session
    header('Location: ../login.php'); // redirect to index
  }

  // function for teacher set up
  function teacher() {
    $_SESSION['AccType'] = '1';
    header('Location: teacher.html');
  }

  // function for admin set up
  function admin() {
    $_SESSION['AccType'] = '3';
    header('Location: admin.html');
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Selecter</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
  </head>
  <body>
    <div class="container h-100">
      <div style="margin-top: 10px;"></div>
      <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
          <div class="card h-100 justify-content-center">
            <div class="card-header">
              <h1 class="text-center">Navagation</h1>
            </div>
            <div class="card-body">
              <ul class="list-group">
                <li id='teacher' class="list-group-item" style="background-color: #165a72; cursor:pointer" onclick="<?php echo teacher() ?>"><a style="color: #fff;">Teacher</a> </li>
                <li id='admin' class="list-group-item" style="background-color: #165a72; cursor:pointer" onclick="<?php echo admin() ?>"><a style="color: #fff;">Admin</a> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>