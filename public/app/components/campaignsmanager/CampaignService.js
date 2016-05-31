var campaignApp = angular.module('campaignApp', ['ngResource', 'ui.bootstrap'])
.factory('CampaignResource',['$resource', function ($resource){
    return $resource('api/campaign-manager/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}])
.service('CampaignService', ['CampaignResource', '$q', function (CampaignResource, $q) {
    var that = this;
    var campaigns = [];
	this.createCampaignProvider = function(data){
        if(typeof data['id'] != 'undefined') {
            return that.editCampaignProvider(data);
        }
		var defer = $q.defer(); 
        var temp  = new CampaignResource(data);
        temp.$save({}, function success(data) {
            defer.resolve(data);
            if(data.status != 0) {
                campaigns.push(data.campaign);
            }
        },
        function error(reponse) {
        	defer.resolve(reponse.data);
        });
        return defer.promise;  
	};

    this.editCampaignProvider = function(data){
        var defer = $q.defer(); 
        var temp  = new CampaignResource(data);
        temp.$update({id: data.id}, function success(data) {
        	if(data.status != 0) {
                for (var key in campaigns) {
                    if (campaigns[key].id == data.campaign.id){
                        campaigns[key] = data.campaign;
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

    this.deleteCampaign = function (id) {
        var defer = $q.defer(); 
        var temp  = new CampaignResource();
        temp.$delete({id: id}, function success(data) {
            for (var key in campaigns) {
                if (campaigns[key].id == id){
                    campaigns.splice(key, 1);
                    break;
                }
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    this.setCampaigns = function(data) {
        campaigns = data;
        return campaigns;
    }
    this.getCampaigns = function() {
        return campaigns;
    }

}])