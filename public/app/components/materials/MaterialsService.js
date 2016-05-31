var materialApp = angular.module('MaterialApp');

materialApp.factory('MaterialsResource',['$resource', function ($resource){
    return $resource('/api/database-manager/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'},
        editNameFolder: {method: 'edit-name-folder'}
    });
}])
.service('MaterialsService', ['MaterialsResource', '$q', function (MaterialsResource, $q) {
    var that = this;
    var blockManagers = [];

    this.createMaterial = function(data){
        var defer = $q.defer();
        var temp  = new MaterialsResource(data);
        temp.$save({ method:'create-new-material'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    this.updateMaterial = function(data){
        var defer = $q.defer();
        var temp  = new MaterialsResource(data);
        temp.$save({ method:'update-material'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };
}])
