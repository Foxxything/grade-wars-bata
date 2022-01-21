<?php
  // Path: endpoints\post.php
  // Description: This file contains the code for handling of all POST requests made.

  require_once('../config.php'); // get the sql connection

  $action = $_POST['action'];  // get value of 'action' from post request

  if ($action == 'userJoin') { // is action 'userJoin'
    $joinCode = $_POST['joinCode']; // get values from post request

    
  }