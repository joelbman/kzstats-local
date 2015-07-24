'use strict';

// Player list controller
module.exports = /*@ngInject*/ function($scope, PlayerService) {
  $scope.players = [];

  var promise = PlayerService.getList();
  promise.then(function(data) {
    $scope.players = data;
  });

};