'use strict';

var app = angular.module('kzApp');

app
  // Misc controllers
  .controller('FrontPageCtrl', require('./misc/front'))

  // Player controllers
  .controller('PlayerListCtrl', require('./player/list'))
  .controller('PlayerDetailCtrl', require('./player/detail'))

  // Jumpstats controllers
  .controller('JumpDetailCtrl', require('./jump/detail'));