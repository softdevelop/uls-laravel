var seoApp = angular.module('SeoAnalysisApp', ['ngResource', 'ui.bootstrap'])
.factory('SeoResource',['$resource', function ($resource){
    return $resource('/api/domain-statistics/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'},
    });
}])
.service('SeoService', ['SeoResource', '$q', function (SeoResource, $q) {
    
}])