<?php

  class Player {

    private $db;

    public function __construct($db) {
      $this->db = $db;
    }

    // Returns top 25 players based on points
    public function getList() {
      return $this->db->fetchAll('SELECT * From playerrank ORDER BY points DESC LIMIT 25');
    }

    // Returns given SteamID's player data
    public function getDetail($id) {
      $steamid = $this->convertId($id);
      $player = [];
      $rank = $this->db->fetch('SELECT name, points, lastseen, country From `playerrank` WHERE steamid = "'.$steamid.'"');
      $rank['countrycode'] = $this->countryCode($rank['country']);
      $jumpstats = $this->db->fetch('SELECT multibhoprecord, bhoprecord, ljrecord FROM `playerjumpstats3` WHERE steamid = "'.$steamid.'"');
      return array_merge($player, $rank, $jumpstats);
    }

    // Searches for a countrycode with given country name
    private function countryCode($country) {
      include(__DIR__.'/../utils/countrycodes.php');
      return array_search($country, $countrycodes);
    }

    // Converts SteamID back to STEAM_X:Y:ZZZZZZZZ format
    private function convertId($id) {
      $idstr = (string)$id;
      $x = substr($idstr, 0, 1);
      $y = substr($idstr, 1, 1);
      $z = substr($idstr, 2);
      $steamid = 'STEAM_'.$x.':'.$y.':'.$z;
      return $steamid;
    }

  }