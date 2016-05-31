
var activityModule = angular.module('activityLog');

activityModule.controller('ActivityLogController', ['$scope', '$filter', '$controller', '$timeout','ActivityLogService', function($scope, $filter, $controller, $timeout, ActivityLogService) {
    $scope.userAffected = window.userAffected;
    angular.element('.broker-class').removeClass('hidden');
    angular.element('.info-task-label').removeClass('hidden');
    $controller('BaseController', { $scope: $scope });
    $scope.search = {};
    $('#page-loading').css('display','block');
    var log = this;
    log.currentPage = 1;
    $scope.maxSize = 5;
    $scope.search.orderBy = 'desc';

    //set data items
    // $scope.items = window.logs.data;

    //init actions.
    $scope.actions = window.actions;
    //search characters.
    var searchLogs = [];

    /**
     * get data logs.
     * @return {[type]} [description]
     */
    var getLogs = function(callback) {
        var data = angular.copy($scope.search);
        data.id = window.userAffected.id;

        ActivityLogService.get(log.currentPage, data).then(function(data){
            $scope.items = data.logs.data;
        });
    }
    
    /**
     * getSearchData
     * @return {[type]} [description]
     */
    var getSearchData = function() {
        searchLogs[0].id = window.userAffected.id;
        ActivityLogService.get(log.currentPage, searchLogs[0]).then(function(data){
            $('#page-loading').css('display','none');
            $scope.totalItems = data.logs.total;
            $scope.itemsPerPage = data.logs.per_page;
            $scope.items = data.logs.data;
            searchLogs.splice(0,1);
            if(searchLogs.length > 0) {
                getSearchData();
            } else {
                isStartSearch = true;
            }

        });
    }

    /**
     * pageChanged.
     *
     * @author  Huy Nguyen <huy@httsolution.com>
     *
     * @return {[type]} [description]
     */
    log.pageChanged = function() {
       getLogs();

    };

    var isStartSearch = true;
    $scope.$watch('search', function(newVal, oldVal){
        if (angular.isUndefined(newVal)  || Object.keys(newVal).length == 0) return;
        searchLogs.push({query: newVal.query, orderBy:newVal.orderBy, created_at:newVal.created_at});
        if (isStartSearch) {
            isStartSearch = false;
            getSearchData();
        }

    },true);


    $scope.callbackLoadUserFinish = function(){};

}]);
