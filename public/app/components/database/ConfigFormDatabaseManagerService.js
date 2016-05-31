
var configFormDatabaseApp = angular.module('configFormDatabaseApp')

configFormDatabaseApp.factory('ConfigFormDatabaseResource',['$resource', function ($resource){
    return $resource('/api/database-manager/:method/:id/:title', {'method':'@method','id':'@id', 'title':'@title'}, {
                add: {method: 'post'},
                save: {method: 'post'},
                update: {method: 'put'},
                show : {method: 'get'},
            }
        );
}])
.service('ConfigformDatabaseService', ['ConfigFormDatabaseResource', '$q', function (ConfigFormDatabaseResource, $q) {
    this.generalForm = function (tableName) {
        var defer = $q.defer(); 
        var temp  = new ConfigFormDatabaseResource();
        temp.$save({id: tableName, method:'general-form'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }
}])
