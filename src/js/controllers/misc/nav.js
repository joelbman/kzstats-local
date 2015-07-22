'use strict';

// Nav controller
module.exports = function($scope, $state, ServerService) {

  $scope.toggled = false;
  $scope.searchField = '';

  $scope.isActive = function(state) {
    return $state.includes(state);
  };

  $scope.search = function() {
    if ($scope.searchField.length > 1)
      $state.go('search', {'value': $scope.searchField });
  };

  var promise = ServerService.getInfo();
  promise.then(function(data) { $scope.server = data; });

};