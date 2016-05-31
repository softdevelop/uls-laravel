var pageApp = angular.module('pageApp');
pageApp.factory('ReleaseVersionResource',['$resource', function ($resource){
    return $resource('/api/release-manager/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}])
.service('ReleaseVersionService', ['ReleaseVersionResource', '$q', function (ReleaseVersionResource, $q) {
    var that = this;
    var releaseVersions = [];
	this.createReleaseVersionProvider = function(data){
        if(typeof data['_id'] != 'undefined') {
            return that.editReleaseVersionProvider(data);
        }
		var defer = $q.defer(); 
        var temp  = new ReleaseVersionResource(data);
        temp.$save({}, function success(data) {
            defer.resolve(data);
            if(data.status != 0) {
                // releaseVersions.push(data.item);
            }
        },
        function error(reponse) {
        	defer.resolve(reponse.data);
        });
        return defer.promise;  
	};

    this.editReleaseVersionProvider = function(data){
        var defer = $q.defer(); 
        var temp  = new ReleaseVersionResource(data);
        temp.$update({id: data['_id']}, function success(data) {
            if(data.status != 0){
                for (var key in releaseVersions) {
                    if (releaseVersions[key]._id == data.item._id){
                        releaseVersions[key] = data.item;
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

    this.deleteReleaseVersion = function (id) {
        var defer = $q.defer(); 
        var temp  = new ReleaseVersionResource();
        temp.$delete({id: id}, function success(data) {
            for (var key in releaseVersions) {
                if (releaseVersions[key]._id == id){
                    releaseVersions.splice(key, 1);
                    break;
                }
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    this.changeVersion = function(data){
        var defer = $q.defer(); 
        var temp  = new ReleaseVersionResource(data);
        temp.$save({method: 'change-release-version'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

    this.setReleaseVersion = function(data) {
        releaseVersions = data;
        return releaseVersions;
    }
    
    this.getReleaseVersion = function() {
        return releaseVersions;
    }

    this.getPastVersion = function(){
        var defer = $q.defer(); 
        var temp  = new ReleaseVersionResource();
        temp.$save({method:'get-past-version'}, function success(data) {
            releaseVersions = data.pastVerssion;
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

}]);
