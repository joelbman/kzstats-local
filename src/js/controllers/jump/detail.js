'use strict';

// Jump detail controller
module.exports = /*@ngInject*/ function($scope, $stateParams, JumpService) {

  $scope.jumps = [];
  $scope.jumpType = '';

  switch ($stateParams.jumpName) {
    case 'lj': $scope.jumpType = 'Longjump'; break;
    case 'bhop': $scope.jumpType = 'Bunnyhop'; break;
    case 'dropbhop': $scope.jumpType = 'Drop-bunnyhop'; break;
    case 'mbhop': $scope.jumpType = 'Multi-bunnyhop'; break;
    case 'wj': $scope.jumpType = 'Weirdjump'; break;
    case 'ladderjump': $scope.jumpType = 'Ladderjump'; break;
    case 'cj': $scope.jumpType = 'Countjump'; break;
    default: $scope.jumpType = ''; break;
  }

  if ($scope.jumpType) {
    JumpService.getDetail($stateParams.jumpName).then(function(data) {
      $scope.jumps = data;
    });
  }

};