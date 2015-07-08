'use strict';

/**
 * Map service
 */
module.exports = function($http) {

  // API query for records by given map name
  this.getDetail = function(name) {
    return $http.get('api/map/' + name).then(function(res) { return res.data; });
  };

  // API query for map list
  this.getList = function() {
    return $http.get('api/map/').then(function(res) { return res.data; });
  };

  // API query for total map count
  this.getCount = function() {
    return $http.get('api/map/count/').then(function(res) { return res.data; });
  };

};