'use strict';

/**
 * Player service
 */
module.exports = function($http, $q) {

  // API query for jumpstats, rank etc. by SteamID
  this.getDetail = function(id) {
    var deferred = $q.defer();
    $http.get('api/player/' + id)
    .success(function(data) {
      deferred.resolve(data);
    })
    .error(function() {
      deferred.reject();
    });
    return deferred.promise;
  };

  // API query for records by SteamID
  this.getRecords = function(id) {
    var deferred = $q.defer();
    $http.get('api/player/' + id + '/records/')
    .success(function(data) {
      deferred.resolve(data);
    })
    .error(function() {
      deferred.reject();
    });
    return deferred.promise;
  };

  // API query for top players by points
  this.getList = function() {
    var deferred = $q.defer();
    $http.get('api/player/')
    .success(function(data) {
      deferred.resolve(data);
    })
    .error(function() {
      deferred.reject();
    });
    return deferred.promise;
  };

};