'use strict';

// Player detail controller
module.exports = function($scope, $stateParams, PlayerSvc) {

  var promise = PlayerSvc.getDetail($stateParams.steamId);
  promise.then(function(data) {
    $scope.p = data;
  }, function() {
    $scope.p = null;
  });

  var prom = PlayerSvc.getRecords($stateParams.steamId);
  prom.then(function(data) {
    $scope.records = data;
  }, function() {
    $scope.records = [];
  });
  
};