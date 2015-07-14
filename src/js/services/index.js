'use strict';

var app = angular.module('kzApp');

app
  .service('PlayerService', require('./player'))
  .service('MapService', require('./map'))
  .service('JumpService', require('./jump'))
  .service('SearchService', require('./search'));