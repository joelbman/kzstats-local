<?php

  abstract class Server {

    public static function getInfo() {
      /*
        Using SourceQuery class by xPaw
        to get the server info.
        
        https://github.com/xPaw/PHP-Source-Query-Class/
      */
      require './class/SourceQuery/SourceQuery.class.php';
      require './settings.php';

      $query = new SourceQuery();

      try {
        $query->Connect($server['ip'], $server['port'], 1, SourceQuery :: SOURCE);
        $info = $query->GetInfo();
      }
      catch (Exception $e) {
        return array('error' => 'Server connection failed');
      }

      $result = array();
      $result['ip'] = $server['ip'].':'.$server['port'];
      $result['name'] = $info['HostName'];
      $result['players'] = $info['Players'];
      $result['maxplayers'] = $info['MaxPlayers'];
      $result['map'] = $info['Map'];

      return $result;

    }

  }