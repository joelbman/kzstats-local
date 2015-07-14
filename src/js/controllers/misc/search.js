'use strict';

// Search controller
module.exports = function($scope, $stateParams, SearchService) {

  $scope.players = [];
  $scope.maps = [];

  var promise = SearchService.search($stateParams.value);

  promise.then(function(data) {
    $scope.players = data.players;
    $scope.maps = data.maps;
  });

};