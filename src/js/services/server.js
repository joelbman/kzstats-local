'use strict';

/**
 * Server service
 */
module.exports = /*@ngInject*/ function($http) {

  var that = this;

  // API query for server info
  this.getInfo = function() {
    return $http.get('api/server/').then(function(res) {
      that.name = res.data.name;
      return res.data;
    });
  };

};