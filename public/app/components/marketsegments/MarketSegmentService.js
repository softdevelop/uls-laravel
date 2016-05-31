var marketsegmentApp = angular.module('MarketsegmentApp', ['ui.bootstrap', 'ngResource', 'ngTable'])
.factory('MarketSegMentResource',['$resource', function ($resource){
    return $resource('/api/market-segments/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}])
.service('MarketSegmentService', ['MarketSegMentResource', '$q', function (MarketSegMentResource, $q) {
    var that = this;
    var marketSegments = [];
    this.createMarketSegmentProvider = function(data){
        if(typeof data['id'] != 'undefined' && data['id'] != '') 
            return that.editMarketSegmentProvider(data);

        var defer = $q.defer(); 
        var temp  = new MarketSegMentResource(data);
        temp.$save({}, function success(data) {
            defer.resolve(data);
            if(data.status != 0) {
                marketSegments.push(data.marketSegment);
            }
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

    this.editMarketSegmentProvider = function(data){
        var defer = $q.defer(); 
        var temp  = new MarketSegMentResource(data);
        temp.$update({id: data['id']}, function success(data) {
            if(data.status != 0) {
                for (var key in marketSegments) {
                    if (marketSegments[key].id == data.marketSegment.id){
                        marketSegments[key] = data.marketSegment;
                        break;
                    }
                }  
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

    this.setMarketSegments = function(data) {
        marketSegments = data;
        return marketSegments;
    };
    
    this.getMarketSegments = function() {
        return marketSegments;
    };
}]);