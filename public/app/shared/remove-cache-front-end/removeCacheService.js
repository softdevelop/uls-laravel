var permissionModule = angular.module('cache');
permissionModule.factory('RemoveCacheResource', ['$resource',function($resource){
	return $resource(window.urlFrontEnd + '/api/pages/:method/:id', {}, {
		add: {method: 'post'},
		save: {method: 'post'}
	})
}]).service('RemoveCacheService', ['$q', '$filter', 'RemoveCacheResource',  function($q, $filter, RemoveCacheResource){
    var notifications = [];
   
    /**
     * [get description]
     * @param  {[int]} id permission id
     * @return {[promise]}    promise
     */
     this.removeCache = function(id) {
        var defer = $q.defer();
        RemoveCacheResource.get({method: 'remove-cache', 'id' : id}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };

}])
