<?php

  class Map {

    private $db;
    private $ignored = '';

    public function __construct($db) {
      include_once('utils/mapignore.php');
      $this->ignored = ignoredMaps();
      $this->db = $db;
    }

    // Get list of all maps with the best TP run time
    public function getList() {
      $q = 'SELECT mapname, min(runtime) AS runtime FROM playertimes '.
           'WHERE runtime > -1 AND mapname NOT IN ('.$this->ignored.') GROUP BY mapname';

      $records = $this->db->fetchAll($q);

      for ($i = 0 ; $i < count($records); $i++) 
        $records[$i]['runtime'] = floatval($records[$i]['runtime']);

      return $records;
    }

    // Get records by given map name
    public function getDetail($name) {
      $records = [];
      
      $protimes = $this->db->fetchAll('SELECT steamid, name, runtimepro AS runtime FROM playertimes WHERE mapname = "'.$name.'" AND runtimepro > 0 LIMIT 50');
      $tptimes = $this->db->fetchAll('SELECT steamid, name, teleports, runtime FROM playertimes WHERE mapname = "'.$name.'" AND runtime > 0 LIMIT 50');

      // Float converisons
      for ($i = 0 ; $i < count($tptimes); $i++) 
        $tptimes[$i]['runtime'] = floatval($tptimes[$i]['runtime']);

      for ($i = 0 ; $i < count($protimes); $i++) 
        $protimes[$i]['runtime'] = floatval($protimes[$i]['runtime']);

      if ($tptimes || $protimes) {
        $records['tp'] = $tptimes;
        $records['pro'] = $protimes;
      }

      return $records;
    }

    // Count every unique map in playertimes table
    public function getCount() {
      $result = array();

      $result['normal'] = (int)$this->db->count('SELECT COUNT(DISTINCT mapname) FROM playertimes WHERE mapname NOT IN ('.$this->ignored.') AND mapname NOT LIKE "prokz%"');
      $result['prokz'] = (int)$this->db->count('SELECT COUNT(DISTINCT mapname) FROM playertimes WHERE mapname NOT IN ('.$this->ignored.') AND mapname LIKE "prokz%"');

      return $result;
    }

    // Map search
    public function search($string) {
      $q = 'SELECT mapname, min(runtime) AS runtime FROM playertimes '.
           'WHERE mapname LIKE :search ESCAPE "=" AND runtime > 0 AND mapname NOT IN ('.$this->ignored.') GROUP BY mapname LIMIT 100';
      return $this->db->fetchAll($q, $string);
    }

  }