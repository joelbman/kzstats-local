<?php

  abstract class Server {

    // Server information query
    public static function getInfo() {
      
      // Using SourceQuery class by xPaw
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
      $result['players'] = $info['Players'];
      $result['maxplayers'] = $info['MaxPlayers'];
      $result['map'] = $info['Map'];

      /*
        If settings file has a server name use it.
         Otherwise take the name from the query.
      */
      if ($server['name'])
        $result['name'] = $server['name'];
      else
        $result['name'] = $info['HostName'];

      return $result;

    }

  }