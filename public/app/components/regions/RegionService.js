var regionApp = angular.module('RegionApp', ['ui.bootstrap', 'ngResource','ngTable']);

regionApp.factory('RegionResource', ['$resource',function($resource) {
	return $resource('/api/regions/:method/:id', {method: '@method', id: '@id'}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'}
	});
}]);

regionApp.service('RegionService', ['RegionResource','$q', function (RegionResource, $q) {
		var that = this;
		var regions = [];
		this.createRegion = function(data) {
			if(typeof data['id'] != 'undefined') {
				return that.editRegion(data);
			}

	    	var defer = $q.defer();
	    	var temp = new RegionResource(data);
	    	 temp.$save({},function success(data) {
	                defer.resolve(data);
	                if(data.status != 0) {
	                	regions.push(data.region);
	                }
	                
	            },
	            function error(reponse) {
	               defer.resolve(reponse);
	            });
    	return defer.promise;
    	};


    	this.editRegion = function(data) {
			var defer = $q.defer();
			var temp = new RegionResource(data);
			temp.$update({id:data['id']},function success(data) {
				if(data.status){
					for(var key in regions) {
	                    if(regions[key]['id'] == data['region']['id']){
	                         regions[key] = data['region'];
	                         break;
	                    }
                	}
				}
				
				defer.resolve(data);
			},
			function error (respone) {
				defer.resolve(respone.data);
			});
			return defer.promise;
		};

		this.deleteRegion = function(id) {
			var defer = $q.defer();
			$temp = new RegionResource();
			$temp.$delete({id:id},function success(data) {
				if(data.status){
	                for(var key in regions) {
	                    if(regions[key]['id'] == id) {
	                        regions.splice(key,1);
	                        break;
	                    }
	                }
            	}
				defer.resolve(data);
			},
			function error (respone) {
				defer.resolve(respone.data);
			});
			return defer.promise;
		};

		this.setRegions = function(data) {

			regions = data;
			return regions;
		}
		this.getRegions = function() {

			return regions;
		}

}]);