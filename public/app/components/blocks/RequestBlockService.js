var blockApp = angular.module('BlockApp');

blockApp.factory('RequestBlockResource',['$resource', function ($resource){
    return $resource('/api/block-manager/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}]);

blockApp.service('RequestBlockService', ['RequestBlockResource', '$q', function (RequestBlockResource, $q) {
    var that = this;
    /* create new page */
    this.requestBlock = function(data){
        if(typeof data['_id'] != 'undefined' && data['modal'] == 'request_translation') {
            return that.requestTranslation(data);
        }

        if(typeof data['_id'] != 'undefined' && data['modal'] == 'request_region') {
            return that.requestRegion(data);
        }

        var defer = $q.defer(); 
        var temp  = new RequestBlockResource(data);
        temp.$save({}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

    this.requestTranslation = function(data) {
        var defer = $q.defer(); 
        var temp  = new RequestBlockResource(data);
        temp.$save({method:'request-translation'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.requestRegion = function(data) {
        var defer = $q.defer(); 
        var temp  = new RequestBlockResource(data);
        temp.$save({method:'request-region'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.requestRevision = function(data) {
        var defer = $q.defer(); 
        var temp  = new RequestBlockResource(data);
        temp.$save({method:'request-revision'}, function success(data) {
            if(data.status != 0) {
                defer.resolve(data);
            }
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

}])