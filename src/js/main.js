'use strict';

require('angular');
require('angular-ui-router');
require('angular-ui-router-title');
require('angular-bootstrap');

var app = angular.module('kzApp', ['ui.router', 'ui.router.title', 'ui.bootstrap']);

require('./services');
require('./controllers');
require('./filters');

app.config(['$stateProvider', '$urlRouterProvider', '$compileProvider', function($stateProvider, $urlRouterProvider, $compileProvider) {

  // Redirect to front page if a state doesn't exist
  $urlRouterProvider.otherwise('/');

  $stateProvider

  // General states
  .state('front', {
    url: '/',
    templateUrl: 'templates/front.html',
    controller: 'FrontPageCtrl',
    resolve: { $title: function() { return 'Latest'; } }
  })
  .state('banlist', {
    url: '/bans/',
    templateUrl: 'templates/banlist.html',
    controller: 'BanListCtrl',
    resolve: { $title: function() { return 'Bans'; } }
  })

  // Map states
  .state('maps', {
    abstract: true,
    url: '/maps/',
    template: '<div ui-view></div>'
  })
  .state('maps.list', {
    url: '',
    templateUrl: 'templates/maps-list.html',
    controller: 'MapListCtrl',
    resolve: { $title: function() { return 'Maps'; } }
  })
  .state('maps.detail', {
    url: ':mapName/',
    templateUrl: 'templates/maps-detail.html',
    controller: 'MapDetailCtrl',
    resolve: { $title: function($stateParams) { return $stateParams.mapName; } }
  })

  // Jump states
  .state('jump', {
    abstract: true,
    url: '/jumps/',
    template: '<div ui-view></div>'
  })
  .state('jumps.list', {
    url: '',
    templateUrl: 'templates/jumps-list.html',
    controller: 'JumpListCtrl',
    resolve: { $title: function() { return 'Maps'; } }
  })
  .state('maps.detail', {
    url: ':jumpName/',
    templateUrl: 'templates/jumps-detail.html',
    controller: 'JumpDetailCtrl',
    resolve: { $title: function($stateParams) { return $stateParams.mapName; } }
  })

  // Player states
  .state('players', {
    abstract: true,
    url: '/players/',
    template: '<div ui-view></div>'
  })
  .state('players.list', {
    url: '',
    templateUrl: 'templates/players-list.html',
    controller: 'PlayerListCtrl',
    resolve: { $title: function() { return 'Players'; } }
  })
  .state('players.detail', {
    url: ':steamId/',
    templateUrl: 'templates/players-detail.html',
    controller: 'PlayerDetailCtrl',
    resolve: {
      player: function(PlayerService, $stateParams) {
        return PlayerService.getPlayerName($stateParams.steamId);
      },
      $title: function(player) { return player; }
    }
  });

  // Add Steam URLs to whitelist
  $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|steam):/);

}]);
