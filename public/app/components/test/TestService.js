var app = angular.module('test');
app.factory('TestResource', ['$resource',function($resource){
    return $resource('/test/tags:method/:id', {}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'},
        tags: {method: 'post'}
    })
}]).service('TestService', ['$q', 'TestResource', function($q, TestResource){
	this.getTags = function(data){
		console.log(data);
		var defer = $q.defer();
        var temp = new TestResource(data);
        temp.$tags({},
            function success(data) {
                defer.resolve(data);
            },

            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
	}	
}])