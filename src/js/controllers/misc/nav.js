'use strict';

// Nav controller
module.exports = /*@ngInject*/ function($scope, $state, ServerService) {

  $scope.toggled = false;
  $scope.searchField = '';

  $scope.isActive = function(state) {
    return $state.includes(state);
  };

  $scope.search = function() {
    if ($scope.searchField.length > 1)
      $state.go('search', {'value': $scope.searchField });
  };

  $scope.joinServer = function(ip) {
    window.location.href = 'steam://connect/' + ip;
  };

  var promise = ServerService.getInfo();
  promise.then(function(data) {
    $scope.server = data;
    $scope.server.name = $scope.server.name.substring(0, 20);
  });

};