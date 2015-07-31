'use strict';

// Front page controller
module.exports = /*@ngInject*/ function($scope, PlayerService, ServerService) {

  $scope.records = [];
  $scope.startPoint = 0;
  $scope.pageSize = 10;

  $scope.showNext = function() { $scope.startPoint += $scope.pageSize; };
  $scope.showPrev = function() { $scope.startPoint -= $scope.pageSize; };

  var promise = PlayerService.getLatest();
  promise.then(function(data) { $scope.records = data; });

  var p = ServerService.getInfo();
  p.then(function(data) { $scope.serverName = data.name; });

};