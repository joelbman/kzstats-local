'use strict';

// Player detail controller
module.exports = function($scope, $stateParams, PlayerService, MapService) {

  $scope.p = null;
  $scope.records = [];

  // Pagination settings
  $scope.currentPage = 1;
  $scope.pageSize = 10;
  $scope.startPoint = ($scope.currentPage - 1) * $scope.pageSize;

  var promise = PlayerService.getDetail($stateParams.steamId);
  promise.then(function(data) {
    $scope.p = data;

    var prom = PlayerService.getRecords($stateParams.steamId);
    prom.then(function(data) {
      $scope.records = data;

      $scope.tpcount = 0;
      $scope.procount = 0;

      for (var i = 0; i < data.length; i++) {
        if (data[i].runtime > 0)
          $scope.tpcount++;
        if (data[i].runtimepro > 0)
          $scope.procount++;
      }

    });

    var pro = PlayerService.getSteamProfile($stateParams.steamId);
    pro.then(function(data) {
      $scope.steamInfo = data;
    });

    var pr = MapService.getCount();
    pr.then(function(data) {
      $scope.mapCount = data.count;
    });

  });
  
};