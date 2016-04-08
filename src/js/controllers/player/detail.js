'use strict';

// Player detail controller
module.exports = /*@ngInject*/ function($scope, $stateParams, PlayerService, MapService) {

  $scope.p = null;
  $scope.loaded = false;
  $scope.steamError = false;

  $scope.records = [];
  $scope.originalRecords = [];
  $scope.prorecords = [];
  $scope.tprecords = [];

  // Pagination settings
  $scope.currentPage = 1;
  $scope.pageSize = 20;
  $scope.startPoint = ($scope.currentPage - 1) * $scope.pageSize;

  // Filters
  $scope.types = [
    {name: 'Both', value: 'both'},
    {name: 'TP', value: 'tp'},
    {name: 'Pro', value: 'pro'}
  ];

  $scope.showType = $scope.types[0];

  $scope.reloadResults = function() {
    switch ($scope.showType.value) {
      case 'both': $scope.records = $scope.originalRecords; break;
      case 'tp': $scope.records = $scope.tprecords; break;
      case 'pro': $scope.records = $scope.prorecords; break;
      default: break;
    }
  };

  PlayerService.getDetail($stateParams.steamId).then(function(data) {
    $scope.loaded = true;

    if (data.name)
      $scope.p = data;
    else
      return;

    PlayerService.getRecords($stateParams.steamId).then(function(data) {
      $scope.records = data;
      $scope.originalRecords = data;

      for (var i = 0; i < data.length; i++) {
        if (data[i].runtime > 0)
          $scope.tprecords.push(data[i]);
        if (data[i].runtimepro > 0)
          $scope.prorecords.push(data[i]);
      }

    });

    PlayerService.getSteamProfile($stateParams.steamId).then(function(data) {
      if (!data.error)
        $scope.steamInfo = data;
      else
        $scope.steamError = true;
    }, function() {
      $scope.steamError = true;
    });

    MapService.getCount().then(function(data) {
      $scope.tpMapCount = data.normal;
      $scope.proMapCount = data.normal + data.prokz;

      // Rank calculations
      var maxPointsFromMaps = $scope.proMapCount * 1300;
      var maxPointsFromJumps = 7 * 500;

      var skillGroups = [
        {name: 'PRO', percentage: 0.25},
        {name: 'SEMIPRO', percentage: 0.16},
        {name: 'EXPERT', percentage: 0.12},
        {name: 'SKILLED', percentage: 0.05},
        {name: 'REGULAR', percentage: 0.017},
        {name: 'CASUAL', percentage: 0.01},
        {name: 'TRAINEE', percentage: 0.003},
        {name: 'SCRUB', percentage: 0.00005}
      ];

      for (var i = 0; i < skillGroups.length; i++) {
        var group = skillGroups[i];
        var pointLimit = group.percentage * (maxPointsFromMaps + maxPointsFromJumps);

        if (pointLimit < $scope.p.points) {
          $scope.p.rank = group.name;
          break;
        }
      }
        
      if (!$scope.p.rank)
        $scope.p.rank = 'NEWB';
    });

  });
  
};