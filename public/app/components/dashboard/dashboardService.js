var Dashboard = angular.module('uls');

Dashboard.factory('dashboardResource', ['$resource',function($resource) {
    return $resource('/api/dashboard/:method/:id', {method: '@method', id: '@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    });
}]);

Dashboard.service('dashboardService', ['dashboardResource','$q', function (dashboardResource, $q) {
    this.getActionRequiredByMe = function() {

        var defer = $q.defer();
        dashboardResource.get(function(data){
            defer.resolve(data);
        });
        return defer.promise;
    }

    this.setSessionFilterTicketType = function(typeId, typeParent, status, filterClosed) {
        var defer = $q.defer();
        data = {typeId:typeId, typeParent:typeParent, status: status, filterIncludeClosed: filterClosed};
        var temp = new dashboardResource(data);
        temp.$save({method : 'set-session-filter-ticket-type'},function(data){
            defer.resolve(data);
        });
        return defer.promise;
    }

    this.selectTypeShow = function(typeId) {
        var defer = $q.defer();

        data = {typeId:typeId};
        var temp = new dashboardResource(data);
        temp.$save({method : 'select-type-show'},function(data){
            defer.resolve(data);
        });
        return defer.promise;
    }
    this.saveSort = function(data) {
        var defer = $q.defer();
        var temp = new dashboardResource(data);
        temp.$save({method : 'save-sort'},function(data){
            defer.resolve(data);
        });
        return defer.promise;
    }

    this.removeTypeOnDashboard = function(typeSelected) {
        var defer = $q.defer();

        data = {types:typeSelected};
        var temp = new dashboardResource(data);
        temp.$save({method : 'remove-type-dashboard'},function(data){
            defer.resolve(data);
        });
        return defer.promise;
    }

    this.changeCollapse = function(data) {
        var defer = $q.defer();
        var temp = new dashboardResource(data);
        temp.$save({method : 'change-collapse'},function(data){
            defer.resolve(data);
        });
        return defer.promise;
    }

}]);