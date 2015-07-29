<?php

  class Api {

    private $db;

    public function __construct() {
      // ...
    }

    public function response($data) {
      echo json_encode($data, JSON_PRETTY_PRINT);
      exit;
    }

    public function dbConnect() {
      if ($this->db)
        return $this->db;

      require_once('settings.php');

      try {
        $this->db = new Db(
          'mysql:host='.$dbhost.';
          dbname='.$dbname.';
          port='.$dbport.';
          charset='.$dbcharset, 
          $dbuser, $dbpass);
        return $this->db;
      }
      catch (PDOException $e) {
        return 'null';
      }
    }

  }