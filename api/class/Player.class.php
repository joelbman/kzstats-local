<?php

  class Player {

    private $pdo;

    public function __construct($pdo) {
      $this->pdo = $pdo;
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

    public function getList() {
      $stmt = $this->pdo->prepare('SELECT * From playerrank ORDER BY points DESC LIMIT 25');
      if ($stmt->execute())
        return $stmt->fetchAll(2);
    }

    public function getDetail($id) {
      $steamid = $this->convertId($id);
      $player = [];
      $stmt = $this->pdo->prepare('SELECT points, name From playerrank WHERE steamid = '.$steamid);
      $stmt->execute();
      $rank = $stmt->fetchAll(2);
      $stmt = $this->pdo->prepare('SELECT multibhoprecord, bhoprecord, ljrecord FROM playerjumpstats3 WHERE steamid = '.$steamid);
      $stmt->execute();
      $jumpstats = $stmt->fetchAll(2);
      array_merge($player, $rank, $jumpstats);
    }

  }