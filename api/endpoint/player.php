<?php

  if (!$route) {
    $stmt = $pdo->prepare('SELECT * From playerrank LIMIT 25');
    if ($stmt->execute)
      echo json_encode($stmt->fetchAll(2));
  }