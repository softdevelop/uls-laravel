var requestAsset = angular.module('assetManager');

requestAsset.factory('RequestAssetResource',['$resource', function ($resource){
    return $resource('/api/asset-manager/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}]);

requestAsset.service('RequestAssetService', ['RequestAssetResource', '$q', function (RequestAssetResource, $q) {
    var that = this;
    var pages = [];
    /* create new page */
    this.requestAssetFile = function(data){
        if(typeof data['_id'] != 'undefined' && data['modal'] == 'request_translation') {
            return that.requestTranslation(data);
        }

        if(typeof data['_id'] != 'undefined' && data['modal'] == 'request_region') {
            return that.requestRegion(data);
        }


        var defer = $q.defer(); 
        var temp  = new RequestAssetResource(data);
        temp.$save({}, function success(data) {
            // if(data.status != 0) {
            //     pages.push(data.page);
            // }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

    this.requestTranslation = function(data) {
        var defer = $q.defer(); 
        var temp  = new RequestAssetResource(data);
        temp.$save({method:'request-translation'}, function success(data) {
            /* Create page success */
            if(data.status != 0) {
                /* Push new page to array pages */
                pages.push(data.page);
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.requestRegion = function(data) {
        var defer = $q.defer(); 
        var temp  = new RequestAssetResource(data);
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
        var temp  = new RequestAssetResource(data);
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