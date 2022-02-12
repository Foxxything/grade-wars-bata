<link rel="stylesheet" href="css/bootstrap.css">

<button id='button' class="btn btn-danger">Kill Me</button>

<script>
  document.getElementById('button').addEventListener('click', function() {
    console.log('clicked');
    var http = new XMLHttpRequest();
    console.log(http);
    var url = "./testing.php";
    var params = "test=4";
    try {
      http.open("POST", url, true);
      console.log('opened');
      http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      http.send(params);
    } catch (error) {
      console.log(error);
    }
  });
</script>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  echo '<script>console.log("POST")</script>';
}
