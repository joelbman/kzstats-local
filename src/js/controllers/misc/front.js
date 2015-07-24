'use strict';

// Front page controller
module.exports = /*@ngInject*/ function($scope, PlayerService) {

  $scope.records = [];

  var promise = PlayerService.getLatest();
  promise.then(function(data) { $scope.records = data; });

};