<?php

  class Player {

    private $pdo;

    public function __construct($pdo) {
      $this->pdo = $pdo;
    }

    public function getList() {
      $stmt = $this->pdo->prepare('SELECT * From playerrank ORDER BY points DESC LIMIT 25');
      if ($stmt->execute())
        return $stmt->fetchAll(2);
    }

  }