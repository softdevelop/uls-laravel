campaignDetailApp.controller('campaignDetailCtrl', ['$scope', '$modal', '$filter', 'CampaignDetailService', '$timeout', 'ngTableParams', function ($scope, $modal, $filter, CampaignDetailService, $timeout, ngTableParams) {
	
	$scope.isLoading = false;
	$scope.isLoadingChart = false;

	$scope.campaigns = angular.copy(window.campaigns);

	var campaignsData = [];
	for(var key in $scope.campaigns) {
		$scope.campaigns[key]['groupId'] = key;

		campaignsData.push($scope.campaigns[key]);
	}

	$scope.tableParams = new ngTableParams({
	    page: 1, // show first page
	    count: 10, // count per page
	    sorting: {
	        'name': 'asc' // initial sorting
	    }
		}, {
		    total: campaignsData.length, // length of data
		    getData: function($defer, params) {
		        var orderedData = params.sorting() ? $filter('orderBy')(campaignsData, params.orderBy()) : campaignsData;
		        orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
		        params.total(orderedData.length);
		        $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
		    }
	});

	$scope.labels = angular.copy(window.labels);
	$scope.total = angular.copy(window.total);
	$scope.campaignId = angular.copy(window.campaignId);
	$scope.groupId = angular.copy(window.groupId);

	$scope.campaign = {};
	$scope.campaign.endDate = angular.copy(window.endDate);
	$scope.campaign.startDate = angular.copy(window.startDate);

	$scope.dateRange = angular.copy(window.dateRange);
	$scope.dataReportChart = angular.copy(window.dataReportChart);

	$scope.open = function($event, type) {
    	$event.preventDefault();
    	$event.stopPropagation();
    	$scope.opened = {};
    	$scope.opened[type] = true;
  	};
  	
  	$scope.format = 'yyyy/MM/dd';

  	var loadChartReport = function (){
  		$('#container').highcharts({
	        title: {
	            text: 'Report Chart',
	            x: -20 //center
	        },
	        
	        xAxis: {
	            categories: $scope.dateRange
	        },
	        credits: {
			      enabled: false
			},
	        yAxis: {
	            title: {
	                text: 'Axis Title'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: ' clicks'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: $scope.dataReportChart
	    });
  	}

  	loadChartReport();

	$scope.getSearchModalAds = function($type, validate){
		/* When click search then show incon loading and waiting for data result */
		$scope.isLoading = true;
		/* Format date */
		$scope.campaign.start_date = $filter('date')(new Date($scope.campaign.startDate), 'yyyyMMdd');
  		$scope.campaign.end_date = $filter('date')(new Date($scope.campaign.endDate), 'yyyyMMdd');
		/* Validate */
  		$scope.submitted  = true;
  		if(validate || $scope.campaign.start_date > $scope.campaign.end_date) {
  			/* If start date smaller than end date then return */
  			if($scope.campaign.start_date > $scope.campaign.end_date){
  				alert('End date is bigger Start date.');
  				return;
  			}
  			return;
  		}
  		/* Declare data for search */
  		if($type == 'search-report-group'){
  			$scope.campaign.campaignId = $scope.campaignId;
  		}else{
  			$scope.campaign.groupId = $scope.groupId;
  		}
  		$scope.campaign.type = $type;

		CampaignDetailService.searchReportAdsAndGroupByDateRange($scope.campaign).then(function(data){
			$scope.campaigns = data.campaigns;
			$scope.labels 	 = data.labels;
			$scope.total 	 = data.total;

			//chart
			$scope.dateRange = data.dateRange;
			$scope.dataReportChart = data.dataReportChart;
			
			$timeout(function(){
				loadChartReport();
			})
			

			$scope.isLoading = false;
		})
	}
}])