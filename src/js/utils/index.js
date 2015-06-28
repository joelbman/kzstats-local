'use strict';

module.exports = {
  // Parse all but numbers from input
  numOnly: function(input) {
    return input.replace(/\D/g, '');
  }
};