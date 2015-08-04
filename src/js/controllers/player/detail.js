'use strict';

// Player detail controller
module.exports = /*@ngInject*/ function($scope, $stateParams, PlayerService, MapService) {

  $scope.p = null;
  $scope.loaded = false;
  $scope.steamError = false;

  $scope.records = [];
  $scope.originalRecords = [];
  $scope.prorecords = [];
  $scope.tprecords = [];

  // Pagination settings
  $scope.currentPage = 1;
  $scope.pageSize = 20;
  $scope.startPoint = ($scope.currentPage - 1) * $scope.pageSize;

  // Filters
  $scope.types = [
    {name: 'Both', value: 'both'},
    {name: 'TP', value: 'tp'},
    {name: 'Pro', value: 'pro'}
  ];

  $scope.showType = $scope.types[0];

  $scope.reloadResults = function() {
    switch ($scope.showType.value) {
      case 'both': $scope.records = $scope.originalRecords; break;
      case 'tp': $scope.records = $scope.tprecords; break;
      case 'pro': $scope.records = $scope.prorecords; break;
      default: break;
    }
  };

  var promise = PlayerService.getDetail($stateParams.steamId);
  promise.then(function(data) {
    $scope.loaded = true;

    if (data.name)
      $scope.p = data;
    else
      return;

    var recordPromise = PlayerService.getRecords($stateParams.steamId);
    recordPromise.then(function(data) {
      $scope.records = data;
      $scope.originalRecords = data;

      for (var i = 0; i < data.length; i++) {
        if (data[i].runtime > 0)
          $scope.tprecords.push(data[i]);
        if (data[i].runtimepro > 0)
          $scope.prorecords.push(data[i]);
      }

    });

    var steamPromise = PlayerService.getSteamProfile($stateParams.steamId);
    steamPromise.then(function(data) {
      if (!data.error)
        $scope.steamInfo = data;
      else
        $scope.steamError = true;
    }, function() {
      $scope.steamError = true;
    });

    var mapPromise = MapService.getCount();
    mapPromise.then(function(data) {
      $scope.tpMapCount = data.normal;
      $scope.proMapCount = data.normal + data.prokz;
    });

  });
  
};