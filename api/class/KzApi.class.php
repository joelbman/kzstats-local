<?php

  class KzApi extends BaseApi {

    private $db;

    public function __construct($request) {
      parent::__construct($request);
      $this->db = new Db();
    }

    /**
     * Player endpoints
     */
    protected function player() {
      $player = new Player($this->db);
      if (count($this->args) < 1)
        return $player->getList();
      else {
        if ($this->args[1] == 'records')
          return $player->getRecords($this->args[0]);
        else if (!$this->args[1])
          return $player->getDetail($this->args[0]);
      }
    }

    /**
     * Jump endpoints
     */
    protected function jump() {
      $jump = new Jump($this->db);
      switch ($this->args[0]) {
        case 'lj': return $jump->getLj(); break;
        case 'bhop': return $jump->getBhop(); break;
        case 'dropbhop': return $jump->getDropBhop(); break;
        case 'mbhop': return $jump->getMbhop(); break;
        case 'wj': return $jump->getWj(); break;
        case 'ladderjump': return $jump->getLadderjump(); break;
        default: return $jump->getAll(); break;
      }
    }

    /**
     * Map endpoints
     */
    protected function map() {
      $map = new Map($this->db);
      if (count($this->args) == 1) {
        if ($this->args[0] == 'count')
          return $map->getCount();
        else
          return $map->getDetail($this->args[0]);
      }
      elseif (count($this->args) == 0) {
        return $map->getList();
      }
    }

  }