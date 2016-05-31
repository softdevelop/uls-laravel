var platformApp = angular.module('PlatformsApp');

platformApp.factory('PlatformsResource',['$resource', function ($resource){
    return $resource('/api/database-manager/platform/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    });
}])
.service('PlatformsService', ['PlatformsResource', '$q', function (PlatformsResource, $q) {
    var that = this;

    this.createPlatform = function(data){
        if(angular.isDefined(data['id'])) {
            return that.updatePlatform(data);
        }

        var defer = $q.defer();
        var temp  = new PlatformsResource(data);
        temp.$save({}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    this.updatePlatform = function(data) {
        var defer = $q.defer();
        var temp  = new PlatformsResource(data);
        temp.$update({}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };
}]);
