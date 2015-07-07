'use strict';

// Player list controller
module.exports = function($scope, PlayerService) {
  $scope.players = [];

  var promise = PlayerService.getList();
  promise.then(function(data) {
    $scope.players = data;
  });

};