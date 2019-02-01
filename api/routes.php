<?php

  // Only execute if included from index
  if (!isset($debug))
    exit;

  /**
   * Slim setup
   * ---------
   */
  require 'class/Slim/Slim.php';
  \Slim\Slim::registerAutoloader();
  /**
   * A bit of sanitization
   */
  \Slim\Route::setDefaultConditions(array(
    'name' => '[A-Za-z0-9\_]{3,}',
    'id' => '[0-9]{5,}'
  ));
  $app = new \Slim\Slim();
  $app->config('debug', $debug);

  /* Require custom autoloader for other classes
     after registering the Slim autoloader */
  require('utils/autoload.php');
  $api = new Api();

  /**
   * Error handling
   * ---------
   */
  
  // 500
  $app->error(function(Exception $e) use ($api) {
    http_response_code(500);
    $api->response(array('error' => $e));
  });

  // 404
  $app->notFound(function() use ($api) {
    http_response_code(404);
    $api->response(array('error' => 'not found'));
  });

  /**
   * Latest records endpoint
   * ---------
   */
  $app->get('/latest/', function() use ($api) {
    $db = $api->dbConnect();
    $player = new Player($db);
    $api->response($player->getLatest());
  });

  /**
   * Player endpoints
   * ---------
   */
  $app->group('/player', function() use ($app, $api) {

    $db = $api->dbConnect();
    $player = new Player($db);

    // Detail - info
    $app->get('/:id/', function($id) use ($player, $api) {
      $api->response($player->getDetail($id));
    });

    // Detail - Steam profile
    $app->get('/:id/steam/', function($id) use ($player, $api) {
      $api->response($player->getSteamProfile($id));
    });

    // Detail - records
    $app->get('/:id/records/', function($id) use ($player, $api) {
      $api->response($player->getRecords($id));
    });

    // List
    $app->get('/', function() use ($player, $api) {
      $api->response($player->getList());
    });

  });

  /**
   * Map endpoints
   * ---------
   */
  $app->group('/map', function() use ($app, $api) {

    $db = $api->dbConnect();
    $map = new Map($db);

    // Count
    $app->get('/count/', function() use ($map, $api) {
      $api->response($map->getCount());
    });

    // Detail
    $app->get('/:name/', function($name) use ($map, $api) {
      $api->response($map->getDetail($name));
    });

    // List
    $app->get('/', function() use ($map, $api) {
      $api->response($map->getList());
    });

  });

  /**
   * Jump endpoints
   * ---------
   */
  $app->get('/jump/:type/', function($type) use ($api) {

    $db = $api->dbConnect();
    $jump = new Jump($db);

    switch ($type) {
      case 'lj': $api->response($jump->getLj()); break;
      case 'bhop': $api->response($jump->getBhop()); break;
      case 'dropbhop': $api->response($jump->getDropBhop()); break;
      case 'mbhop': $api->response($jump->getMbhop()); break;
      case 'wj': $api->response($jump->getWj()); break;
      case 'ladderjump': $api->response($jump->getLadderjump()); break;
      case 'cj': $api->response($jump->getCountjump()); break;
      default: break;
    }

  });

  /**
   * Server endpoint
   * ---------
   */
  $app->get('/server/', function() use ($api) {
    $api->response(Server::getInfo());
  });

  /**
   * Search endpoint
   * ---------
   */
  $app->get('/search/:value/', function($value) use ($api) {
    if (empty($value)) {
      $api->response([]);
    } else {
      $db = $api->dbConnect();
      $map = new Map($db);
      $player = new Player($db);
  
      $result = [];
      $result['maps'] = $map->search($value);
      $result['players'] = $player->search($value);
  
      $api->response($result);
    }
  });

  $app->run();