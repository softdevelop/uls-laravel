var materialApp = angular.module('MaterialApp');

materialApp.factory('LaserResource',['$resource', function ($resource){
    return $resource('/api/database-manager/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'},
        editNameFolder: {method: 'edit-name-folder'}
    });
}])
.service('LaserService', ['LaserResource', '$q', function (LaserResource, $q) {
    var that = this;
    var blockManagers = [];

    this.create = function(data) {
        if(angular.isDefined(data['id'])) {
            return that.update(data);
        }
        var defer = $q.defer();
        var temp  = new LaserResource(data);
        temp.$save({ method:'create-laser'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

        /**
     * Call server to update role
     * @param  {[object]} data role info
     * @return {[promise]}      promise
     */
    this.update = function(data) {
        var defer = $q.defer();
        var temp = new LaserResource(data);
        temp.$update({method:'edit-laser', id:data['id']},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

}])
