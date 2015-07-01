'use strict';

// Jump detail controller
module.exports = function($scope, $http, $stateParams) {

  $scope.jumps = [];
  $scope.jumpType = '';

  switch ($stateParams.jumpName) {
    case 'lj': $scope.jumpType = 'Longjump'; break;
    case 'bhop': $scope.jumpType = 'Bunnyhop'; break;
    case 'dropbhop': $scope.jumpType = 'Drop-bunnyhop'; break;
    case 'mbhop': $scope.jumpType = 'Multi-bunnyhop'; break;
    case 'wj': $scope.jumpType = 'Weirdjump'; break;
    case 'ladderjump': $scope.jumpType = 'Ladderjump'; break;
    default: $scope.jumpType = ''; break;
  }

  if ($scope.jumpType) {
    $http.get('api/jump/' + $stateParams.jumpName)
    .success(function(data) {
      $scope.jumps = data;
    });
  }

};