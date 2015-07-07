'use strict';

// Map list controller
module.exports = function($scope, MapService) {

  $scope.maplist = [];

  var promise = MapService.getList();
  promise.then(function(data) {
    $scope.maplist = data;
  });

};