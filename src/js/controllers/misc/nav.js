'use strict';

// Nav controller
module.exports = function($scope, $state) {

  $scope.toggled = false;
  $scope.searchField = '';

  $scope.isActive = function(state) {
    return $state.includes(state);
  };

  $scope.search = function() {
    $state.go('search', {'value': $scope.searchField });
  };

};