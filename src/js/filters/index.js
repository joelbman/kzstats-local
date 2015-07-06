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

// Pagination start point
app.filter('startFrom', function() {
  return function(input, startPoint) {
    if (!input) return;
    startPoint = parseInt(startPoint, 10);
    return input.slice(startPoint);
  };
});

// Time conversion from ss.ms to HH:mm:ss.ms
app.filter('convertTime', function() {
  return function(time) {

    var seconds =  0,
        minutes = 0,
        hours = 0,
        milliseconds = 0,
        finalTime = '';

    // Fixed 2 decimals
    time = parseFloat(time).toFixed(2);

    // Change type from float to string for splitting
    time = time.toString();

    var split = time.split('.');
    seconds = parseInt(split[0], 10);
    milliseconds = split[1];

    // Calculate minutes and remaining seconds
    minutes = parseInt(seconds / 60, 10);
    seconds = seconds % 60;

    // If there are over 59 minutes, calculate hours
    if (minutes > 59) {
      hours = parseInt(minutes / 60, 10);
      minutes = minutes % 60;
    }

    // If there are less than 10 seconds and minutes, prefix them with 0
    if (seconds < 10)
      seconds = '0' + seconds;
    if (minutes < 10)
      minutes = '0' + minutes;

    // Add minutes, seconds and milliseconds to the time string
    finalTime = minutes + ':' + seconds + '.' + milliseconds;

    // Finally, add hours only if there are any
    if (hours > 0)
      finalTime = hours + ':' + finalTime;

    return finalTime;
  };
});