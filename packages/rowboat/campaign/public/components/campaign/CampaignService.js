var campaignApp = angular.module('campaignApp', ['ngResource', 'ui.bootstrap'])
.factory('CampaignResource',['$resource', function ($resource){
    return $resource('/api/campaign/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'},
    });
}])
.service('CampaignService', ['CampaignResource', '$q', function (CampaignResource, $q) {
    this.searchReportCampaignByDateRange = function(data){
        var defer = $q.defer(); 
        var temp  = new CampaignResource(data);
        temp.$save({method:'search-report-campaign'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };
}])