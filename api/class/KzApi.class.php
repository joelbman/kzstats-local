<?php

  class KzApi extends BaseApi {

    private $db;

    public function __construct($request) {
      parent::__construct($request);
    }

    protected function player() {
      $this->db = new Db();
      $player = new Player($this->db);
      if (count($this->args) < 1)
        return $player->getList();
      else
        return $player->getDetail($this->args[0]);
    }

  }