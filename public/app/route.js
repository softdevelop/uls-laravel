angular.module('uls').config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider) {
        $routeProvider
            .when('/cms/pages', {
                templateUrl: 'cms/pages/template',
                controller: 'PageController'
            })
            .when('/cms/asset-manager', {
                templateUrl: 'cms/asset-manager/template',
            })
            .when('/cms/template-content-manager', {
                templateUrl: 'cms/template-content-manager/template',
            })
            .when('/cms/block-manager', {
                templateUrl: 'cms/block-manager/template',
            })
            .when('/cms/database-manager', {
                templateUrl: 'cms/database/template',
            });
        $locationProvider.html5Mode(true);
    }
]);
