'use strict';

require('angular');
require('angular-ui-router');
require('angular-bootstrap');

require('./filters');

var app = angular.module('kzApp', ['ui.router', 'ui.bootstrap', 'kzApp.filters']);

require('./services');
require('./controllers');

app.config(['$stateProvider', '$urlRouterProvider', '$compileProvider', function($stateProvider, $urlRouterProvider, $compileProvider) {

  // Redirect to front page if a state doesn't exist
  $urlRouterProvider.otherwise('/');

  $stateProvider

  // General states
  .state('front', {
    url: '/',
    templateUrl: 'templates/front.html',
    controller: 'FrontPageCtrl'
  })
  .state('banlist', {
    url: '/banlist/',
    templateUrl: 'templates/banlist.html',
    controller: 'BanListCtrl'
  })
  .state('search', {
    url: '/search/:value/',
    templateUrl: 'templates/search.html',
    controller: 'SearchCtrl'
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
    controller: 'MapListCtrl'
  })
  .state('maps.detail', {
    url: ':mapName/',
    templateUrl: 'templates/maps-detail.html',
    controller: 'MapDetailCtrl'
  })

  // Jump states
  .state('jumps', {
    abstract: true,
    url: '/jump/',
    template: '<div ui-view></div>'
  })
  .state('jumps.detail', {
    url: ':jumpName/',
    templateUrl: 'templates/jumps-detail.html',
    controller: 'JumpDetailCtrl'
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
    controller: 'PlayerListCtrl'
  })
  .state('players.detail', {
    url: ':steamId/',
    templateUrl: 'templates/players-detail.html',
    controller: 'PlayerDetailCtrl'
  });

  // Add Steam URLs to whitelist
  $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|steam):/);

}]);
