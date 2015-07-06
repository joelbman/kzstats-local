<?php

  class Map {

    private $db;

    public function __construct($db) {
      $this->db = $db;
    }

    // Get list of all maps with the best TP run time
    public function getList() {
      return $this->db->fetchAll('SELECT mapname, min(runtime) AS runtime FROM playertimes WHERE runtime > -1 GROUP BY mapname');
    }

    // Get records by given map name
    public function getDetail($name) {
      return $this->db->fetchAll('SELECT * FROM playertimes WHERE mapname = "'.$name.'"');
    }

  }