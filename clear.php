<?php
session_start();
unset($_SESSION['joinStage']);
session_destroy();
header('Location: ./user/userJoin.php');