var pageApp = angular.module('pageApp', ['ngResource', 'ui.bootstrap', 'ngSanitize', 'ngTable'])
pageApp.factory('PageSyncResource',['$resource', function ($resource){
    return $resource('/api/seo/pages/:method/:id', {'method':'@method','id':'@id'}, {
        add:    {method: 'post'},
        save:   {method: 'post'},
        update: {method: 'put'},
        check:  {method: 'post'},
        get:    {method: 'get'},

    });
}])
.service('PageSyncService', ['PageSyncResource', '$q', function (PageSyncResource, $q) {
    var that = this;
    var pages = [];
    /* Get data pages in traffic */
    this.syncPage = function(){
        var defer = $q.defer(); 
        var temp  = new PageSyncResource();
        temp.$get({method:'sync'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }
}])