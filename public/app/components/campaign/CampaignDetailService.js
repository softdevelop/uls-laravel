var campaignDetailApp = angular.module('campaignDetailApp', ['ngResource', 'ui.bootstrap'])
.factory('CampaignDetailResource',['$resource', function ($resource){
    return $resource('/api/campaign/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'},
    });
}])
.service('CampaignDetailService', ['CampaignDetailResource', '$q', function (CampaignDetailResource, $q) {
    var that = this;
    this.searchReportAdsAndGroupByDateRange = function(data){
        if(data['type'])
        var defer = $q.defer(); 
        var temp  = new CampaignDetailResource(data);
        temp.$save({method: data['type']}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };
}])