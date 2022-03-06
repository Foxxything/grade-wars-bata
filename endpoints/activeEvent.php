<?php
  require_once '../config.php';
  $stmt = $conn->prepare("SELECT * FROM event");
  $events = [];
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $events[] = $row;
  }
  $stmt->close();
  $conn->close();
  echo json_encode($events);
?>