'use strict';

/**
 * Jump service
 */
module.exports = function($http, $q) {

  // API query for jump
  this.getDetail = function(type) {
    var deferred = $q.defer();
    $http.get('api/jump/' + type)
    .success(function(data) {
      deferred.resolve(data);
    })
    .error(function() {
      deferred.reject();
    });
    return deferred.promise;
  };

};