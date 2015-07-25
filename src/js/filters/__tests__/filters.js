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

  describe('kzDate', function() {
    it('should convert given date in to dd.MM.yyyy HH:mm format', inject(function($filter) {
      assert.equal($filter('kzDate')('12-12-1990'), '12.12.1990 00:00');
    }));
  });

});