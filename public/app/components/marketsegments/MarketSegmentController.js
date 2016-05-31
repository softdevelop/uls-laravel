marketsegmentApp.controller('MarketSegmentController', ['$scope', '$modal', '$filter', 'ngTableParams', 'MarketSegmentService', function ($scope, $modal, $filter, ngTableParams, MarketSegmentService){
	$scope.data = MarketSegmentService.setMarketSegments(angular.copy(window.marketSegments));
	$scope.isSearch=false;
	$scope.tableParams = new ngTableParams({

        page: 1,
        count: 10,
        filter: {
            name: ''
        },
        sorting: {
            name: 'asc'
        }

    }, {

        total: $scope.data.length,

        getData: function ($defer, params) {
    		var orderedData = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
    		orderedData = params.sorting() ? $filter('orderBy')(orderedData, params.orderBy()) : orderedData;
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));

        }
    })

	$scope.createMarketSegment = function(id){
		var template = '/site-configuration/market-segments/create';
		if(typeof id != 'undefined'){
			template = '/site-configuration/market-segments/' + id + '/edit' + '?' + new Date().getTime();
		}
		var modalInstance = $modal.open({
		    animation: $scope.animationsEnabled,
		    templateUrl: window.baseUrl + template,
		    controller: 'ModalCreateMarketSegmentCtrl',
		    size: null,
		    resolve: {
		    }  
		});

		modalInstance.result.then(function (data) {
			$scope.data = MarketSegmentService.getMarketSegments();
			$scope.tableParams.reload();
		}, function () {
				
		   });
	};
	
}])
marketsegmentApp.controller('ModalCreateMarketSegmentCtrl', ['$scope', '$modalInstance', 'MarketSegmentService', function ($scope, $modalInstance, MarketSegmentService) {	

	$scope.submit = function (validate) {
		$scope.submitted  = true;  		
  		if(validate){
			return;
  		}

  		$scope.marketSegment.alias_name = $scope.marketSegment.name.replace(/\s+/g,'_').toLowerCase();
		MarketSegmentService.createMarketSegmentProvider($scope.marketSegment).then(function (data){
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

}]);	