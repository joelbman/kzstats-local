'use strict';

var app = angular.module('kzApp');

app.filter('numOnly', function() {
  return function(input) {
    return input.replace(/\D/g, '');
  };
});

// Returns full image path, used with flag icons
// Flag icons from http://www.famfamfam.com/lab/icons/flags/
app.filter('imgPath', function() {
  return function(input) {
    if (typeof input != 'undefined') {
      if (input === '??')
        input = 'UNK';
      var path = 'img/' + input.toLowerCase() + '.png';
      return path;
    }
    return;
  };
});