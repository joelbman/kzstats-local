'use strict';

// Player detail controller
module.exports = function($scope, $stateParams, PlayerSvc) {

  // Pagination settings
  $scope.currentPage = 1;
  $scope.pageSize = 10;
  $scope.startPoint = ($scope.currentPage - 1) * $scope.pageSize;

  var promise = PlayerSvc.getDetail($stateParams.steamId);
  promise.then(function(data) {
    $scope.p = data;
  }, function() {
    $scope.p = null;
  });

  var prom = PlayerSvc.getRecords($stateParams.steamId);
  prom.then(function(data) {

    $scope.records = data;

    $scope.tpcount = 0;
    $scope.procount = 0;
    $scope.bothcount = 0;

    for (var i = 0; i < data.length; i++) {
      if ($scope.records[i].runtime > 0)
        $scope.tpcount++;
      if ($scope.records[i].runtimepro > 0)
        $scope.procount++;
    }

    $scope.bothcount = $scope.tpcount + $scope.procount;

  }, function() {
    $scope.records = [];
  });
  
};