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
      $q = 'SELECT steamid, name, ljrecord, ljpre, ljmax, ljstrafes, ljsync, ljheight FROM playerjumpstats3 ORDER BY ljrecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }

    // Bunnyhops
    public function getBhop() {
      $q = 'SELECT steamid, name, bhoprecord, bhoppre, bhopmax, bhopstrafes, bhopsync, bhopheight FROM playerjumpstats3 ORDER BY bhoprecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }
    
    // Multi-bunnyhops
    public function getMbhop() {
      $q = 'SELECT steamid, name, multibhoprecord, multibhoppre, multibhopmax, multibhopstrafes, multibhopsync, multibhopheight FROM playerjumpstats3 ORDER BY multibhoprecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }

    // Weirdjumps
    public function getWj() {
      $q = 'SELECT steamid, name, wjrecord, wjpre, wjmax, wjstrafes, wjsync, wjheight FROM playerjumpstats3 ORDER BY wjrecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }

    // Ladderjumps
    public function getLadderjump() {
      $q = 'SELECT steamid, name, ladderjumprecord, ladderjumppre, ladderjumpmax, ladderjumpstrafes, ladderjumpsync, ladderjumpheight FROM playerjumpstats3 ORDER BY ladderjumprecord DESC LIMIT 20';
      return $this->db->fetchAll($q);
    }

    // Get top results from all jump categories
    public function getAll() {

    }

  }