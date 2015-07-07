'use strict';

/**
 * Map service
 */
module.exports = function($http, $q) {

  // API query for records by given map name
  this.getDetail = function(name) {
    var deferred = $q.defer();
    $http.get('api/map/' + name)
    .success(function(data) {
      deferred.resolve(data);
    })
    .error(function() {
      deferred.reject();
    });
    return deferred.promise;
  };

  // API query for map list
  this.getList = function() {
    var deferred = $q.defer();
    $http.get('api/map/')
    .success(function(data) {
      deferred.resolve(data);
    })
    .error(function() {
      deferred.reject();
    });
    return deferred.promise;
  };

};