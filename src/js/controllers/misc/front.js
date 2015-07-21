'use strict';

// Front page controller
module.exports = function($scope, PlayerService) {

  $scope.records = [];

  var promise = PlayerService.getLatest();
  promise.then(function(data) { $scope.records = data; });

};