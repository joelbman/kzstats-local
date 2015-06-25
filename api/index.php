<?php

  header('Content-type: application/json');
  error_reporting(E_ALL & ~E_NOTICE);

  $req = rtrim($_REQUEST['request'], '/');

  if ($req) {
    include_once('settings.php');

    $route = explode('/', $req);
    $endpoint = array_shift($route);
    
    if (file_exists('endpoint/'.$endpoint.'.php')) {
      $pdo = new PDO(
        'mysql:host='.DB_HOST.';
        dbname='.DB_NAME.';
        port='.DB_PORT.';
        charset='.DB_CHARSET, 
        DB_USER, DB_PASS);

      include_once('endpoint/'.$endpoint.'.php');
      
    }
    else
      http_response_code(404);
  }