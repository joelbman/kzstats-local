'use strict';

// Player service
module.exports = function($http, $q) {

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

};