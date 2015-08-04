<?php

  error_reporting(E_ALL & ~E_NOTICE);
  header('Content-type: application/json; charset=utf-8');

  // Switch to true for development, false for production
  $debug = true;

  require('routes.php');
  