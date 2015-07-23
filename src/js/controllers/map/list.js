'use strict';

// Map list controller
module.exports = function($scope, MapService) {

  $scope.maplist = [];

  $scope.fields = [
    {name: 'Name', value: 'mapname'},
    {name: 'Time', value: 'runtime'}
  ];
  $scope.orderField = $scope.fields[0];

  var promise = MapService.getList();
  promise.then(function(data) {
    $scope.maplist = data;
  });

};