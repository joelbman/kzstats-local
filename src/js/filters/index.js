'use strict';

var app = angular.module('kzApp');

app.filter('numOnly', function() {
  return function(input) {
    return input.replace(/\D/g, '');
  };
});