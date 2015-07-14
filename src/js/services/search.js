'use strict';

/**
 * Search service
 */
module.exports = function($http) {

  // API query for searching maps/players
  this.search = function(value) {
    return $http.get('api/search/' + value).then(function(res) { return res.data; });
  };

};