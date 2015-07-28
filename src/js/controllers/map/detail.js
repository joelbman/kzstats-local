'use strict';

// Map detail controller
module.exports = /*@ngInject*/ function($scope, $stateParams, MapService) {

  $scope.records = [];
  $scope.mapname = $stateParams.mapName;
  $scope.loaded = false;

  var promise = MapService.getDetail($scope.mapname);
  promise.then(function(data) {
    $scope.loaded = true;
    $scope.records = data;
  });

};