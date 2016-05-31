var historyApp = angular.module('historyApp');

historyApp.factory('PageResource', ['$resource', function($resource) {
        return $resource('/api/pages/:method/:id', {'method': '@method', 'id': '@id'}, {
            add: {
                method: 'post'
            },
            save: {
                method: 'post'
            },
            update: {
                method: 'put'
            },
            check: {
                method: 'post'
            },
        });
    }])
    .service('PageService', ['PageResource', '$q', function(PageResource, $q) {
        

    }])
