'use strict';
/* globals ngModule, inject, describe, beforeEach, it */

require('../../../../test/js/test-helpers');

var assert = require('assert');

/*
 * Load module
 */

require('../');

describe('filters', function() {

  beforeEach(ngModule('kzApp.filters'));

  describe('convertTime', function() {
    it('should convert given runtime into dd.MM.yyyy HH:mm:ss.ms format', inject(function($filter) {
      assert.equal($filter('convertTime')('23.23'), '00:23.23');
    }));
  });

  describe('numOnly', function() {
    it('should strip all but numbers from given string', inject(function($filter) {
      assert.equal($filter('numOnly')('abcfg.{4343}_?'), '4343');
    }));
  });

  describe('startFrom', function() {
    it('should return an array starting from given point', inject(function($filter) {
      assert.equal($filter('startFrom')(['asd', 'qwe', 'abc', '123', 'moo'], 3), ['123', 'moo']);
    }));
  });

  describe('imgPath', function() {
    it('should return full image path for given flag countrycode', inject(function($filter) {
      assert.equal($filter('imgPath')('uk'), 'img/flag/uk.png');
    }));
  });



});