'use strict';

// Player list controller
module.exports = function($scope, $http) {
  $scope.players = [];

  $http.get('api/player/')
  .success(function(data) {
    $scope.players = data;
  });
};