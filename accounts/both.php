<?php
  session_start(); // start session

  if ($_SESSION['AccType'] != 3 ) { // if not both account type
    header('Location: ../login.php'); // redirect to login
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Selecter</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
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
              <form action='both.php' method='post'>
                <div class="row">
                  <div class="col-6">
                    <input name='admin' type='submit' class="btn btn-primary btn-block" value='Admin'></input>
                  </div>
                  <div class="col-6">
                    <input name='teacher' type='submit' class="btn btn-primary btn-block" value='Teacher'></input>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<?php

  if (isset($_POST['admin'])) {
    $_SESSION['AccType'] = 2;
    header('Location: admin.php');
  } elseif (isset($_POST['teacher'])) {
    $_SESSION['AccType'] = 1;
    header('Location: teacher.php');
  }