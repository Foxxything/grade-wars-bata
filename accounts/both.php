<?php
  session_start(); // start session

  if ($_SESSION['AccType'] != 3 ) { // if not both account type
    echo "<script>alert('You are already logged in! ".$_SESSION['AccType']."');</script>";
    header('Location: ../login.php'); // redirect to login
  }
  
  echo '<script>alert('."'".$_SESSION['AccType']."'".');</script>';
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
                <li id='teacher' class="list-group-item" style="background-color: #165a72; cursor:pointer;" onclick="byeBye('teacher.html')"><a style="color: #fff;">Teacher</a> </li>
                <li id='admin' class="list-group-item" style="background-color: #165a72; cursor:pointer;" onclick="byeBye('admin.html')"><a style="color: #fff;">Admin</a> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<script>
  function byeBye(page) {
    console.log('Redirecting to ' + page);
    window.location.href = './' + page;
    if (page == 'teacher.html') {
      <?php $_SESSION['AccType'] = 1; ?>
    } else if (page == 'admin.html') {
      <?php $_SESSION['AccType'] = 2; ?>
    }
  }
</script>