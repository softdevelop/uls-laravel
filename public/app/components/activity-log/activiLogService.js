var activityModule = angular.module('activityLog');
activityModule.factory('ActivityLogResource',['$resource',function($resource){
    return $resource('/api/activity-log/:method/:id/:paginate', {method: '@method', id: '@id', paginate:'@paginate'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    });
}])
.service('ActivityLogService',['ActivityLogResource', '$q', '$filter', function(ActivityLogResource, $q, $filter){

    // /**
    //  * get list users
    //  * @return {[promise]} promise contain list users
    //  */
    // this.query = function()
    // {
    //     var defer = $q.defer();
    //     UserResource.query().$promise.then(function(data) {
    //         defer.resolve(users);
    //     });

    //     return defer.promise;
    // };


    /**
     * get list users
     * @return {[promise]} promise contain list users
     */
     this.get = function(currentPage, data)
     {
        data.page = currentPage;
         var defer = $q.defer();

         ActivityLogResource.get(data, function(data) {
             defer.resolve(data);
         });

         return defer.promise;
     };

}]);
