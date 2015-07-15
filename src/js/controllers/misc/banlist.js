'use strict';

// Banlist controller
module.exports = function($scope, PlayerService) {

  $scope.banlist = [];

  var promise = PlayerService.banList();
  promise.then(function(data) { $scope.banlist = data; });

};