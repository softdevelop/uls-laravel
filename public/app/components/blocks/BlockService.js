var blockApp = angular.module('BlockApp', ['ui.bootstrap', 'ngResource','ngTable']);

blockApp.factory('BlockResource', ['$resource',function($resource) {
	return $resource('/api/blocks/:method/:id', {method: '@method', id: '@id'}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'},
        get : {method: 'get'},
	});
}]);

blockApp.service('BlockService', ['BlockResource','$q', function (BlockResource, $q) {
	this.createBlock = function(data) {
    	var defer = $q.defer();
    	var temp = new BlockResource(data);
    	temp.$save({},function success(data) {
    	 	defer.resolve(data);
        }, function error(reponse) {
           defer.resolve(reponse);
        });
		return defer.promise;
	};

	this.editBlock = function(data) {
		var defer = $q.defer ();
		var temp = new BlockResource (data);
		temp.$update ({id:data['_id']}, function success (data){
			defer.resolve(data);
		},
		function error (respone){
			defer.resolve(respone.data);
		});
		return defer.promise;
	};

	this.deleteBlock = function(id) {
		var defer = $q.defer ();
		var temp = new BlockResource (id);
		temp.$delete ({id:id}, function success (data){
			defer.resolve(data);
		},
		function error (respone){
			defer.resolve(respone.data);
		});
		return defer.promise;
	};

}]);