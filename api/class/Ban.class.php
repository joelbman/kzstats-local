<?php

  class Ban {

    private $db;

    public function __construct($db) {
      $this->db = $db;
    }

    public function getList() {
      return $this->db->fetchAll('SELECT * FROM bans LIMIT 100');
    }

  }