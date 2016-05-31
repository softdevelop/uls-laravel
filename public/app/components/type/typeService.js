var typeModule = angular.module('type');
typeModule.factory('TypeResource', ['$resource',function($resource){
	return $resource('/api/type/:method/:id', {method: '@method', id: '@id'}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'}
	})
}])
.service('TypeService', ['$q', '$filter', 'TypeResource', function($q, $filter, TypeResource){
    var types = [];
    var that = this;
    this.query = function(){
    	var defer = $q.defer();
    	TypeResource.query().$promise
    	.then(function(data){
    		types = data;
    		defer.resolve(types);
    	})
    return defer.promise;
    }

    this.getPermissions = function(){
        var defer = $q.defer();
        TypeResource.get({method:'get-permissions'}).$promise
        .then(function(data){
            defer.resolve(data);
        })
    return defer.promise;
    }

    this.create = function(data){
    	if(typeof data['id'] != 'undefined'){
            return that.update(data);

        }
    	var defer = $q.defer();
    	var temp = new TypeResource(data);
    	temp.$save({},function success(data){
    		if(data.status && data.item){
    			types.push(data.item);
    			defer.resolve(data);
    		}
    	}, function error(reponse){
            defer.resolve(reponse.data);
    	  })
    return defer.promise;
    }
     this.update = function(data) {
        var defer = $q.defer();
        var temp = new TypeResource(data);
        temp.$update({'id':data['id']},
            function success(data) {
                if(data.status){
                    for(var key in types){
                        if(types[key]['id'] == data['item']['id']){
                             types[key] = data['item'];
                             break;
                        }
                       
                    }
                }
               defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    this.remove = function(id) {
    var defer = $q.defer();
    TypeResource.delete({ id: id}, function(data) {
        if(data.status){
            for(var key in types){
                if(types[key]['id'] == id){
                     types.splice(key, 1);
                     break;
                }
            }
        }
        defer.resolve(data);
    });
     return defer.promise;
    }
    this.getTypes = function(){
    	return types;
    }
}]);
 