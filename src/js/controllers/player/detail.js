'use strict';

// Player detail controller
module.exports = function($scope, $stateParams, PlayerSvc) {

  var promise = PlayerSvc.getDetail($stateParams.steamId);
  promise.then(function(data) {
    $scope.p = data;
  });
  
};