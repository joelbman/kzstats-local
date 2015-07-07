'use strict';

// Player detail controller
module.exports = function($scope, $stateParams, PlayerService, MapService) {

  // Pagination settings
  $scope.currentPage = 1;
  $scope.pageSize = 10;
  $scope.startPoint = ($scope.currentPage - 1) * $scope.pageSize;

  $scope.mapCount = 0;

  var promise = PlayerService.getDetail($stateParams.steamId);
  promise.then(function(data) {
    $scope.p = data;
  }, function() {
    $scope.p = null;
  });

  var prom = PlayerService.getRecords($stateParams.steamId);
  prom.then(function(data) {

    $scope.records = data;

    $scope.tpcount = 0;
    $scope.procount = 0;

    for (var i = 0; i < data.length; i++) {
      if ($scope.records[i].runtime > 0)
        $scope.tpcount++;
      if ($scope.records[i].runtimepro > 0)
        $scope.procount++;
    }

    var p = MapService.getCount();
    p.then(function(data) { $scope.mapCount = data.count; });

  }, function() {
    $scope.records = [];
  });
  
};