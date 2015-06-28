<?php

  class Db {

    private $pdo;

    public function __construct() {
      require(__DIR__.'/../settings.php');
      $this->pdo = new PDO(
        'mysql:host='.$dbhost.';
        dbname='.$dbname.';
        port='.$dbport.';
        charset='.$dbcharset, 
        $dbuser, $dbpass);
    }

    // Fetch all rows from SELECT query result set
    public function fetchAll($q) {
      $result = [];
      $stmt = $this->pdo->prepare($q);
      $stmt->execute();
      $result = $stmt->fetchAll(2);
      return $result; 
    }

    // Fetch next row from SELECT query result set
    public function fetch($q) {
      $result = [];
      $stmt = $this->pdo->prepare($q);
      $stmt->execute();
      $result = $stmt->fetch(2);
      return $result; 
    }

  }