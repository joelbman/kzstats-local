<?php

  class Player {

    private $db;

    public function __construct($db) {
      $this->db = $db;
    }

    // Returns top 25 players based on points
    public function getList() {
      $players = $this->db->fetchAll('SELECT * From playerrank ORDER BY points DESC LIMIT 50');
      
      for ($i = 0; $i < count($players); $i++)
        $players[$i]['countrycode'] = $this->countryCode($players[$i]['country']);
      
      return $players;
    }

    // Get jumpstats + rank etc. by given SteamID
    public function getDetail($id) {
      $player = [];

      $steamid = $this->convertId($id);

      // Basic info
      $player = $this->db->fetch('SELECT name, points, lastseen, country From playerrank WHERE steamid = "'.$steamid.'"');
      $player['countrycode'] = $this->countryCode($player['country']);
      $player['lastseen_timestamp'] = strtotime($player['lastseen']);

      // Jumpstats
      $player['jump'] = $this->db->fetch('SELECT multibhoprecord, bhoprecord, dropbhoprecord, ljrecord, ladderjumprecord, wjrecord FROM playerjumpstats3 WHERE steamid = "'.$steamid.'"');

      return $player;
    }

    // Get records by given SteamID
    public function getRecords($id, $merge = true) {
      $records = [];
      $steamid = $this->convertId($id);

      if (!$merge) {
        $records['tp'] = $this->db->fetchAll('SELECT steamid, mapname, runtime, teleports FROM playertimes WHERE steamid = "'.$steamid.'" ORDER BY mapname');
        $records['pro'] = $this->db->fetchAll('SELECT steamid, mapname, runtimepro FROM playertimes WHERE steamid = "'.$steamid.'" ORDER BY mapname'); 
      }
      else
        $records = $this->db->fetchAll('SELECT steamid, mapname, runtime, teleports, runtimepro FROM playertimes WHERE steamid = "'.$steamid.'" ORDER BY mapname');

      return $records;
    }

    // Get Steam profile info from Steam API
    public function getSteamProfile($id) {
      include(__DIR__.'/../settings.php');
      if ($apikey) {
        // Calculate 64-bit Steam ID (community ID)
        $idnum = substr($id, 1, 1);
        $accnum = substr($id, 2);
        $comid = bcadd(bcadd(($accnum * 2), '76561197960265728'), $idnum);

        $info = json_decode(file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$apikey.'&steamids='.$comid));
        return $info->response->players[0];
      }
    }

    // Search players
    public function search($string) {
      $players = $this->db->fetchAll('SELECT steamid, name, points, lastseen, country FROM playerrank WHERE name LIKE :search ESCAPE "=" AND points > 0 ORDER BY points DESC LIMIT 100', $string);

      for ($i = 0; $i < count($players); $i++)
        $players[$i]['countrycode'] = $this->countryCode($players[$i]['country']);

      return $players;
    }

    // Banlist
    public function getBans() {
      if (count($this->args) == 0)
        return $this->db->fetchAll('SELECT * FROM bans LIMIT 100');
    }

    // Latest records
    public function getLatest() {
      if (count($this->args) == 0) {
        $results = $this->db->fetchAll('SELECT * FROM latestrecords WHERE (map, runtime) IN (SELECT map, min(runtime) FROM latestrecords GROUP BY map)');
        for ($i = 0; $i < count($results); $i++)
          $results[$i]['timestamp'] = strtotime($results[$i]['date']);
        return $results;
      }
    }

    // Searches for a countrycode with given country name
    private function countryCode($country) {
      include(__DIR__.'/../utils/countrycodes.php');

      $result = 'UNK';
      $search = array_search($country, $countrycodes);

      if ($search)
        $result = $search;

      return $result;
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