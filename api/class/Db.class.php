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
    public function fetchAll($q, $var = '') {
      $result = [];
      $stmt = $this->pdo->prepare($q);

      // This is mostly for WHERE ... LIKE queries (searching)
      if ($var) {
        // Escape with =
        $var = str_replace('=', '==', $var);
        $var = str_replace('%', '=%', $var);
        $var = str_replace('_', '=_', $var);
        $stmt->bindValue(':search', '%'.$var.'%');
      }
  
      $stmt->execute();
      $result = $stmt->fetchAll(2);

      return $result; 
    }

    // Fetch next row from SELECT query result set
    public function fetch($q) {
      $result = [];
      $stmt = $this->pdo->prepare($q);

      // Make sure single row fetch doesn't return false
      if ($stmt->execute()) {
        $data = $stmt->fetch(2);
        if ($data != false)
          $result = $data;
      }
      
      return $result; 
    }

    public function count($q) {
      $result = [];
      $stmt = $this->pdo->prepare($q);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_NUM);
      $result['count'] = $count[0];
      return $result;
    }

  }