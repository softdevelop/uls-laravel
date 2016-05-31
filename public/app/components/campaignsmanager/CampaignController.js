campaignApp.controller('campaignCtrl', ['$scope', '$modal', 'CampaignService', function ($scope, $modal, CampaignService) {

	$scope.campaigns = CampaignService.setCampaigns(angular.copy(window.campaignss));

	$scope.getModalCampaign = function(type, id){
		var teamplate = '/campaign-manager/create';
		if(id != 'null'){
			teamplate = '/campaign-manager/'+ id + '/edit' + '?' + new Date().getTime();
		}
		var modalInstance = $modal.open({
		    animation: $scope.animationsEnabled,
		    templateUrl: window.baseUrl + teamplate,
		    controller: 'ModalCampaignCtrl',
		    size: null,
		    resolve: {
		    	id: function(){
		    		return id;
		    	},
		    	campaigns: function(){
		    		return $scope.campaignss;
		    	},
		    	type: function(){
		    		return type;
		    	}

		    }
		    
		});

		modalInstance.result.then(function (data) {
			$scope.data = CampaignService.getCampaigns();
		}, function () {

		   });
	};

	$scope.removeCampaign = function(id){
		CampaignService.deleteCampaign(id).then(function (){
			$scope.cam = CampaignService.getCampaigns();
		});
	};
	
}])
.controller('ModalCampaignCtrl', ['$scope', '$modalInstance', 'type', 'CampaignService', function ($scope, $modalInstance, type, CampaignService) {
	$scope.type = type;
	
	$scope.submit = function (validate) {
		$scope.submitted  = true;
  		if(validate){
			return;
  		}
  		if(type != 'null'){
  			$scope.campaign.type = type;
  		}

  		$scope.campaign.alias_name = $scope.campaign.name.replace(/\s+/g,'_').toLowerCase();
		CampaignService.createCampaignProvider($scope.campaign).then(function (data){
			if(data.status == 0) {
				$scope.nameExists = data.error.alias_name[0];
			} else {
				$modalInstance.close(data);
			}
		})
	
	};

	$scope.cancel = function () {
	    $modalInstance.dismiss('cancel');
	};
}])
.filter('capitalize', function() {
  	return function(input, scope) {
    	if (input!=null)
    	input = input.toLowerCase();
    	return input.substring(0,1).toUpperCase()+input.substring(1);
  	};
});