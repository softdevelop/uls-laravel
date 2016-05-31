
var paginationModule = angular.module('pagination');

paginationModule.controller('PaginationUlsController', ['$scope', '$filter', '$timeout','PaginationService', function($scope, $filter, $timeout, PaginationService) {
    
    var pagination = this;

    pagination.currentPage = 1;
    pagination.maxSize = 5;

    $scope.$on('pagination', function(event, data) { 
        pagination.totalItems = data.galary.total;
        pagination.itemsPerPage = data.galary.per_page;
    });
    /**
     * get data logs.
     * @return {[type]} [description]
     */
    var getPagination = function(callback) {
        var myObject = {tagsIds: $scope.$parent.galaryCtrl.tagsIds};
        PaginationService.get(pagination.currentPage, myObject).then(function(data){
            $scope.$parent.galaryCtrl.items = data.galary.data;
            pagination.totalItems = data.galary.total;
            pagination.itemsPerPage = data.galary.per_page;
        });
    }

    /**
     * pageChanged.
     *
     * @author  Huy Nguyen <huy@httsolution.com>
     *
     * @return {[type]} [description]
     */
    pagination.pageChanged = function() {
       getPagination();
    };

    pagination.pageChanged();

}]);
