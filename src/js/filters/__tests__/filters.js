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

});