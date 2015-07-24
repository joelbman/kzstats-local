<?php

  class Map {

    private $db;

    public function __construct($db) {
      $this->db = $db;
    }

    // Get list of all maps with the best TP run time
    public function getList() {
      $records = $this->db->fetchAll('SELECT mapname, min(runtime) AS runtime FROM playertimes WHERE runtime > -1 GROUP BY mapname');
      for ($i = 0 ; $i < count($records); $i++) 
        $records[$i]['runtime'] = floatval($records[$i]['runtime']);
      return $records;
    }

    // Get records by given map name
    public function getDetail($name, $merge = false) {
      $records = [];
      
      $protimes = $this->db->fetchAll('SELECT steamid, name, runtimepro AS runtime FROM playertimes WHERE mapname = "'.$name.'" AND runtimepro > 0');
      $tptimes = $this->db->fetchAll('SELECT steamid, name, teleports, runtime FROM playertimes WHERE mapname = "'.$name.'" AND runtime > 0');

      if ($merge) {
        $both = array_merge($tptimes, $protimes);
        /**
         * Loop through the records, convert runtime to float for client side ordering
         * and set pro time teleports to 0
         */
        for ($i = 0; $i < count($both); $i++) {
          $both[$i]['runtime'] = floatval($both[$i]['runtime']);
          if (!$both[$i]['teleports'])
            $both[$i]['teleports'] = 0;
        }
        $records = $both;
      }
      else {
        // Float converisons
        for ($i = 0 ; $i < count($tptimes); $i++) 
          $tptimes[$i]['runtime'] = floatval($tptimes[$i]['runtime']);
        for ($i = 0 ; $i < count($protimes); $i++) 
          $protimes[$i]['runtime'] = floatval($protimes[$i]['runtime']);

        $records['tp'] = $tptimes;
        $records['pro'] = $protimes;
      }

      return $records;
    }

    // Count every unique map in playertimes table
    public function getCount() {
      return $this->db->count('SELECT COUNT(DISTINCT mapname) FROM playertimes');
    }

    // Map search
    public function search($string) {
      return $this->db->fetchAll('SELECT mapname, min(runtime) AS runtime FROM playertimes WHERE mapname LIKE :search ESCAPE "=" AND runtime > 0 GROUP BY mapname LIMIT 100', $string);
    }

  }