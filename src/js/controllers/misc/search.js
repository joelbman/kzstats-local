'use strict';

// Search controller
module.exports = function($scope, $stateParams, SearchService) {

  $scope.players = [];
  $scope.maps = [];
  $scope.searched = false;
  $scope.bothcount = 0;

  var promise = SearchService.search($stateParams.value);

  promise.then(function(data) {
    $scope.players = data.players;
    $scope.maps = data.maps;
    $scope.bothcount = data.maps.length + data.players.length;
    $scope.searched = true;
  });

};