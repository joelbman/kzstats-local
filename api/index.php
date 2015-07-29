<?php

  
  error_reporting(E_ALL & ~E_NOTICE);

  // Slim
  require 'class/Slim/Slim.php';
  \Slim\Slim::registerAutoloader();
  $app = new \Slim\Slim();

  // Autoloader for other classes
  require('autoload.php');

  $db = null;

  // Database connection
  function dbConnect() {
    global $db;

    require_once('settings.php');

    if ($db)
      return $db;

    try {
      $db = new Db(
        'mysql:host='.$dbhost.';
        dbname='.$dbname.';
        port='.$dbport.';
        charset='.$dbcharset, 
        $dbuser, $dbpass);
      return $db;
    }
    catch (PDOException $e) {
      die();
    }
  }

  // JSON response
  function response($data) {
    header('Content-type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
  }

  /**
   * Latest records endpoint
   * ---------
   */
  $app->get('/latest/', function() {
    $db = dbConnect();
    $player = new Player($db);
    response($player->getLatest());
  });

  /**
   * Player endpoints
   * ---------
   */
  $app->group('/player', function() use ($app) {

    $db = dbConnect();
    $player = new Player($db);

    // Detail - info
    $app->get('/:id/', function($id) use ($player) {
      response($player->getDetail($id));
    });

    // Detail - Steam profile
    $app->get('/:id/steam/', function($id) use ($player) {
      response($player->getSteamProfile($id));
    });

    // Detail - records
    $app->get('/:id/records/', function($id) use ($player) {
      response($player->getRecords($id));
    });

    // List
    $app->get('/', function() use ($player) {
      response($player->getList());
    });

  });

  /**
   * Map endpoints
   * ---------
   */
  $app->group('/map', function() use ($app) {

    $db = dbConnect();
    $map = new Map($db);

    // Count
    $app->get('/count/', function() use ($map) {
      response($map->getCount());
    });

    // Detail
    $app->get('/:name/', function($name) use ($map) {
      response($map->getDetail($name));
    });

    // List
    $app->get('/', function() use ($map) {
      response($map->getList());
    });

  });

  /**
   * Jump endpoints
   * ---------
   */
  $app->get('/jump/:type/', function($type) {

    $db = dbConnect();
    $jump = new Jump($db);

    switch ($type) {
      case 'lj': response($jump->getLj()); break;
      case 'bhop': response($jump->getBhop()); break;
      case 'dropbhop': response($jump->getDropBhop()); break;
      case 'mbhop': response($jump->getMbhop()); break;
      case 'wj': response($jump->getWj()); break;
      case 'ladderjump': response($jump->getLadderjump()); break;
      default: break;
    }

  });

  /**
   * Server endpoint
   * ---------
   */
  $app->get('/server/', function() {
    response(Server::getInfo());
  });

  /**
   * Search endpoint
   * ---------
   */
  $app->get('/search/:value/', function($value) {
    $db = dbConnect();
    $map = new Map($db);
    $player = new Player($db);

    $result = [];
    $result['maps'] = $map->search($value);
    $result['players'] = $player->search($value);
    response($result);
  });

  $app->run();
