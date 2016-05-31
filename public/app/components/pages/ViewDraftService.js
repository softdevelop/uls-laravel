var pageDraftModule = angular.module('viewDraft');

pageDraftModule.factory('ViewDraftResource', ['$resource',function($resource){
    return $resource('/api/pages/:method/:id/', {}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    })
}]);

pageDraftModule.service('ViewDraftService', ['$q', '$filter', 'ViewDraftResource', function($q, $filter, ViewDraftResource){
	this.approve = function(data) {
		var defer = $q.defer();
        var temp = new ViewDraftResource(data);
        temp.$save({id:data['id'], method:'approve'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
	}
    this.requestReview = function(data) {
        var defer = $q.defer();
        var temp = new ViewDraftResource(data);
        temp.$save({id:data['id'], method:'request-review'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }
    this.deny = function(data) {
        var defer = $q.defer();
        var temp = new ViewDraftResource(data);
        temp.$save({id:data['id'], method:'deny'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }
}]);
