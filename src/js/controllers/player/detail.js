'use strict';

// Player detail controller
module.exports = function($scope, $http, $stateParams) {

  $http.get('api/player/' + $stateParams.steamId)
  .success(function(data) {
    $scope.player = data;
  });

};