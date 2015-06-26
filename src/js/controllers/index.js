'use strict';

var app = angular.module('kzApp');

// Misc controllers
app
  .controller('FrontPageCtrl', require('./misc/front'))

  .controller('PlayerListCtrl', require('./player/list'));