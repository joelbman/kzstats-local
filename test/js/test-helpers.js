'use strict';

var jsdom = require('jsdom').jsdom;

global.document = jsdom('<html><head><script></script></head><body></body></html>');
global.window = global.document.parentWindow;

global.window.mocha = require('mocha');
global.window.beforeEach = beforeEach;
global.window.afterEach = afterEach;

global.navigator = window.navigator = {};

require('../bower_components/angular');
require('../bower_components/angular-mocks');

global.angular = window.angular;
global.inject = global.angular.mock.inject;
global.ngModule = global.angular.mock.module;