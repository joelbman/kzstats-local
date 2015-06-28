<?php

  class KzApi extends BaseApi {

    private $pdo = null;

    public function __construct($request) {
      parent::__construct($request);
    }

    private function dbConnect() {
      require(__DIR__.'/../settings.php');
      try {
        $this->pdo = new PDO(
          'mysql:host='.$dbhost.';
          dbname='.$dbname.';
          port='.$dbport.';
          charset='.$dbcharset, 
          $dbuser, $dbpass);
      }
      catch (PDOException $e) {
        $this->_error('Database connection failed');
      }
    }

    protected function player() {
      $this->dbConnect();
      $player = new Player($this->pdo);
      if (count($this->args) < 1)
        return $player->getList();
      else
        return $player->getDetail($this->args[0]);
    }

  }