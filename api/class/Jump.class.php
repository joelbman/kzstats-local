<?php

  /**
   * Jumpstats class
   */
  class Jump {

    private $db;

    public function __construct($db) {
      $this->db = $db;
    }

    // Longjumps
    public function getLj() {
      $q = 'SELECT steamid, name, ljrecord AS record, ljpre AS pre, ljmax AS max, ljstrafes AS strafes, ljsync AS sync, ljheight AS height '.
           'FROM playerjumpstats3 WHERE ljrecord > 100 ORDER BY ljrecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }

    // Bunnyhops
    public function getBhop() {
      $q = 'SELECT steamid, name, bhoprecord AS record, bhoppre AS pre, bhopmax AS max, bhopstrafes AS strafes, bhopsync AS sync, bhopheight AS height '.
           'FROM playerjumpstats3 WHERE bhoprecord > 100 ORDER BY bhoprecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }
    
    // Drop-bunnyhops
    public function getDropBhop() {
      $q = 'SELECT steamid, name, dropbhoprecord AS record, dropbhoppre AS pre, dropbhopmax AS max, dropbhopstrafes AS strafes, dropbhopsync AS sync, dropbhopheight AS height '.
           'FROM playerjumpstats3 WHERE dropbhoprecord > 100 ORDER BY dropbhoprecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }

    // Multi-bunnyhops
    public function getMbhop() {
      $q = 'SELECT steamid, name, multibhoprecord AS record, multibhoppre AS pre, multibhopmax AS max, multibhopstrafes AS strafes, multibhopsync AS sync, multibhopheight AS height '.
           'FROM playerjumpstats3 WHERE multibhoprecord > 100 ORDER BY multibhoprecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }

    // Weirdjumps
    public function getWj() {
      $q = 'SELECT steamid, name, wjrecord AS record, wjpre AS pre, wjmax AS max, wjstrafes AS strafes, wjsync AS sync, wjheight AS height '.
           'FROM playerjumpstats3 WHERE wjrecord > 100 ORDER BY wjrecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }

    // Ladderjumps
    public function getLadderjump() {
      $q = 'SELECT steamid, name, ladderjumprecord AS record, ladderjumppre AS pre, ladderjumpmax AS max, ladderjumpstrafes AS strafes, ladderjumpsync AS sync, ladderjumpheight AS height '.
           'FROM playerjumpstats3 WHERE ladderjumprecord > 100 ORDER BY ladderjumprecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }

  }