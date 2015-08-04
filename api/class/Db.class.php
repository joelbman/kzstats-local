<?php

  class Db extends PDO {
  
    protected $_config = array();
    protected $_connected = false;

    public function __construct($dsn, $user = null, $pass = null, $options = null) {
      $this->_config = array(
        'dsn' => $dsn,
        'user' => $user,
        'pass' => $pass,
        'options' => $options
      );
    }

    public function checkConnection() {
      if (!$this->_connected) {
        extract($this->_config);
        parent::__construct($dsn, $user, $pass, $options);
        $this->_connected = true;
      }
    }

    // Fetch all rows from SELECT query result set
    public function fetchAll($q, $var = '') {
      $this->checkConnection();

      $result = [];

      $stmt = parent::prepare($q);

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
      $this->checkConnection();

      $result = [];

      $stmt = parent::prepare($q);

      // Make sure single row fetch doesn't return false
      if ($stmt->execute()) {
        $data = $stmt->fetch(2);
        if ($data != false)
          $result = $data;
      }
      
      return $result; 
    }

    public function count($q) {
      $this->checkConnection();

      $stmt = parent::prepare($q);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_NUM);

      return $count[0];
    }

  }