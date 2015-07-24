'use strict';

/**
 * Jump service
 */
module.exports = /*@ngInject*/ function($http) {

  // API query for jump
  this.getDetail = function(type) {
    return $http.get('api/jump/' + type).then(function(res) { return res.data; });
  };

};