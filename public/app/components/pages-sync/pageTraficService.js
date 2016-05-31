var pageApp = angular.module('pageApp', ['ngResource', 'ui.bootstrap', 'ngSanitize', 'ngTable']);
// PageTuan.factory('PageSyncResource',['$resource', function ($resource){
//     return $resource('/api/seo/pages/:method/:id', {'method':'@method','id':'@id'}, {
//         add: {method: 'post'},
//         save:{method: 'post'},
//         update:{method: 'put'},
//         check: {method: 'post'}
//     });
// }])
// .service('PageSyncService', ['PageSyncResource', '$q', function (PageSyncResource, $q) {

// }])