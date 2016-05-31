var guideConfigurator = angular.module('databaseManager', ['ui.bootstrap', 'ngResource', 'ngTable'])
guideConfigurator.factory('GuideConfiguratorResource',['$resource', function ($resource){
    return $resource('/api/database-manager/guided-configurator/:method/:id/:title', {'method':'@method','id':'@id', 'title':'@title'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'},
        show : {method: 'get'},
    });
}])
.service('GuideConfiguratorService', ['GuideConfiguratorResource', '$q', function (GuideConfiguratorResource, $q) {
    var that = this;

    this.checkValueMinMax = function(data){
        var defer = $q.defer();
        var temp  = new GuideConfiguratorResource(data);
        temp.$save({method: 'check-value'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise; 
    };

    /**
     * [report description]
     *
     * @author [Kim Bang]  [bang@httsolution.com]
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    this.report = function(data) {
    	var defer = $q.defer();

    	var temp = new GuideConfiguratorResource(data);

    	temp.$save({method:'report'}, function success(result) {
    		defer.resolve(result);
    	}, function error(reponse) {
    		defer.resolve(reponse.data);
    	})

    	return defer.promise;
    };
    this.getLaserOfListPlatform = function(data){
        var defer =$q.defer();
        var temp = new GuideConfiguratorResource(data);
        temp.$save({method:'get-list-laser-of-platform'}, function success(data){
            defer.resolve(data);
        }, function error(reponse){
            defer.resolve(reponse.data);
        })
        return defer.promise;

    }

    this.getListPlatform = function(data) {
    	var defer = $q.defer();

    	var temp = new GuideConfiguratorResource(data);

    	temp.$save({method:'get-list-platform'}, function success(result) {
    		defer.resolve(result);
    	}, function error(reponse) {
    		defer.resolve(reponse.data);
    	})

    	return defer.promise;
    }
}]);
