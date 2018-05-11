'use strict';

var app = angular.module('kzApp');

app.directive('loader', function() {
  return function($scope) {
    $scope.$on('loader_show', function() {
      $scope.loading = true;
    });
    $scope.$on('loader_hide', function() {
      $scope.loading = false;
    });
  };
});