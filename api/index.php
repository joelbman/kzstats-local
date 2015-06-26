<?php

  header('Content-type: application/json');
  error_reporting(E_ALL & ~E_NOTICE);

  spl_autoload_extensions('.php, .class.php');

  function classLoader($class) {
    require('./class/'.$class.'.class.php');
  }

  spl_autoload_register('classLoader');

  $request = rtrim($_REQUEST['request'], '/');

  if ($request) {
    
    $api = new KzApi($request);
    $api->_process();

  }