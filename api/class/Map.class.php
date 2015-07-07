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
      $protimes = $this->db->fetchAll('SELECT steamid, name, runtimepro AS runtime FROM playertimes WHERE mapname = "'.$name.'" AND runtimepro > 0');
      $tptimes = $this->db->fetchAll('SELECT steamid, name, runtime, teleports FROM playertimes WHERE mapname = "'.$name.'" AND runtime > 0');
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

      return $both;
    }

    // Count every unique map in playertimes table
    public function getCount() {
      return $this->db->count('SELECT COUNT(DISTINCT mapname) FROM playertimes');
    }

  }