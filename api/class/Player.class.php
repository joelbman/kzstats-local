<?php

  class Player {

    private $db;
    private $ignored;

    public function __construct($db) {
      include_once('utils/mapignore.php');
      $this->ignored = ignoredMaps();
      $this->db = $db;
    }

    // Returns top 25 players based on points
    public function getList() {
      $players = $this->db->fetchAll('SELECT steamid, name, country, points, lastseen From playerrank ORDER BY points DESC LIMIT 50');
      
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

      if ($player) {
        $player['countrycode'] = $this->countryCode($player['country']);
        $player['lastseen_timestamp'] = strtotime($player['lastseen']);

        // Jumpstats
        $js = $this->db->fetch('SELECT multibhoprecord, bhoprecord, dropbhoprecord, ljrecord, ladderjumprecord, wjrecord, cjrecord FROM playerjumpstats3 WHERE steamid = "'.$steamid.'"');
        if (count($js) > 0)
          $player['jump'] = $js; 
      }

      return $player;
    }

    // Get records by given SteamID
    public function getRecords($id) {
      $records = [];
      $steamid = $this->convertId($id);

      $records = $this->db->fetchAll('SELECT steamid, mapname, runtime, teleports, runtimepro FROM playertimes '.
        'WHERE steamid = "'.$steamid.'" AND mapname NOT IN ('.$this->ignored.') ORDER BY mapname');

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
      else
        return array('error' => 'API key not defined');
    }

    // Search players
    public function search($string) {
      $players = $this->db->fetchAll('SELECT steamid, name, points, lastseen, country FROM playerrank WHERE name LIKE :search ESCAPE "=" AND points > 0 ORDER BY points DESC LIMIT 100', $string);

      for ($i = 0; $i < count($players); $i++)
        $players[$i]['countrycode'] = $this->countryCode($players[$i]['country']);

      return $players;
    }

    // Latest records
    public function getLatest() {
      $results = $this->db->fetchAll('SELECT * FROM LatestRecords WHERE (map, runtime) IN '.
        '(SELECT map, min(runtime) FROM LatestRecords WHERE map NOT IN ('.$this->ignored.') GROUP BY map)');

      for ($i = 0; $i < count($results); $i++)
        $results[$i]['timestamp'] = strtotime($results[$i]['date']);
      
      return $results;
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