'use strict';

/**
 * Player service
 */
module.exports = function($http) {

  // API query for jumpstats, rank etc. by SteamID
  this.getDetail = function(id) {
    return $http.get('api/player/' + id).then(function(res) { return res.data; });
  };

  // API query for records by SteamID
  this.getRecords = function(id) {
    return $http.get('api/player/' + id + '/records/').then(function(res) { return res.data; });
  };

  // API query for Steam profile information
  this.getSteamProfile = function(id) {
    return $http.get('api/player/' + id + '/steam/').then(function(res) { return res.data; });
  };

  // API query for top players by points
  this.getList = function() {
    return $http.get('api/player/').then(function(res) { return res.data; });
  };

  // API query for banned players
  this.banList = function() {
    return $http.get('api/ban/').then(function(res) { return res.data; });
  };

  // API query for latest records
  this.getLatest = function() {
    return $http.get('api/latest/').then(function(res) { return res.data; });
  };

};