regionApp.controller ('RegionController', ['$scope', '$modal','RegionService','$filter','ngTableParams', function ($scope, $modal,RegionService,$filter,ngTableParams) {
		angular.element('.st-container').removeClass('hidden');
		RegionService.setRegions(angular.copy(window.regions));
		$scope.isSearch= false;
		$scope.regions = RegionService.getRegions();

		$scope.tableParams = new ngTableParams({
	        page: 1,
	        count: 10,
	        sorting: {
	            name: 'asc'
	        },
	        filter: {
                name: ''
            }        
	    }, {
	        total: $scope.regions.length,
	        getData: function ($defer, params) {
	        	var filteredData = params.filter() ? $filter('filter')($scope.regions, params.filter()) : $scope.regions;
	            var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
	            params.total(filteredData.length);
	            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
	            
	        }
	    })

		$scope.getModalCreateRegion = function (id) {
			var teamplate = '/site-configuration/regions/create';
			if(typeof id != 'undefined'){
				teamplate = '/site-configuration/regions/'+ id + '/edit' + '?' + new Date().getTime();
			}
			var modalInstance = $modal.open ({
			    animation: $scope.animationsEnabled,
			    templateUrl: window.baseUrl + teamplate,
			    controller: 'ModalCreateRegionCtrl',
			    size: null,
			    resolve: {
			    }
			    
			});

			modalInstance.result.then(function (region) {
				$scope.regions = RegionService.getRegions();
				$scope.tableParams.reload();
			}, function () {

			   });
		};


		$scope.deleteRegion = function(id,index) {
			if(!confirm('Do you want delete this region?')) {
				return;
			} else {
				RegionService.deleteRegion(id).then(function (data) {
					if(data.status){
						$scope.regions = RegionService.getRegions();
						$scope.tableParams.reload();
					}
					
				})
			}
			
		};

}]);

regionApp.controller('ModalCreateRegionCtrl', ['$scope', '$modalInstance','$timeout', 'RegionService','$http',function ($scope, $modalInstance,$timeout, RegionService, $http) {
		$scope.selectionLangId = [];
		$timeout(function(){
			if(typeof $scope.region.languages != 'undefined'){
				$scope.selectionLangId = $scope.region.languages;
			}
		},500)

		/*When select a language to add*/		
		$scope.SelectLanguage = function SelectLanguage(languageId) {
			
			var idx = $scope.selectionLangId.indexOf(languageId);
			if (idx > -1) {
				$scope.selectionLangId.splice(idx, 1);
			}			 
			else {
				$scope.selectionLangId.push(languageId);
			}
		};


		$scope.createRegion = function (validate) {
			if($scope.selectionLangId.length == 0) {
				return;
			}
			$scope.region.languages = $scope.selectionLangId;
			$scope.region.alias_name = $scope.region.name.replace(/\s+/g,'_').toLowerCase();
			$scope.region.code = $scope.region.code.toLowerCase();
			RegionService.createRegion($scope.region).then(function (data) {
				if (data.status == 0) {
					$scope.errors = data.errors;
            	} else {
            		$modalInstance.close(data.region);
            	}
				
			});
		};

		$scope.cancel = function () {
		    $modalInstance.dismiss('cancel');
		};
}]);