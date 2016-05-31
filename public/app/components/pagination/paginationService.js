var paginationModule = angular.module('pagination');

paginationModule.factory('PaginationResource',['$resource',function($resource){
    return $resource('/api/galary/:method/:id/:paginate', {method: '@method', id: '@id', paginate:'@paginate'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    });
}])
.service('PaginationService',['PaginationResource', '$q', '$filter', function(PaginationResource, $q, $filter){


    /**
     * get list users
     * @return {[promise]} promise contain list users
     */
     this.get = function(currentPage, tagsIds)
     {
         var data = {};
         data.page = currentPage;
         data.tagsIds = tagsIds;
         var defer = $q.defer();

         PaginationResource.get(data, function(data) {
             defer.resolve(data);
         });

         return defer.promise;
     };

}]);
