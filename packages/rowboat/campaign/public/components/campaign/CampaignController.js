campaignApp.controller('campaignCtrl', ['$scope', '$modal', '$filter', '$timeout', 'CampaignService', 'ngTableParams', function ($scope, $modal, $filter, $timeout, CampaignService, ngTableParams) {
	$scope.isLoading = false;
	$scope.isLoadingChart = false;
	var campaignsData = [];


	$scope.campaigns = angular.copy(window.campaigns);

	for(var key in $scope.campaigns) {
		$scope.campaigns[key]['campaignId'] = key;

		campaignsData.push($scope.campaigns[key]);
	}


	$scope.labels 	 = angular.copy(window.labels);
	$scope.total 	 = angular.copy(window.total);
	$scope.campaign  = {};
	$scope.campaign.endDate   = angular.copy(window.endDate);
	$scope.campaign.startDate = angular.copy(window.startDate);

	$scope.dateRange = angular.copy(window.dateRange);
	$scope.dataReportChart = angular.copy(window.dataReportChart);

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


	$scope.open = function($event, type) {
    	$event.preventDefault();
    	$event.stopPropagation();
    	$scope.opened = {};
    	$scope.opened[type] = true;
  	};
  	
  	$scope.format = 'yyyy/MM/dd';

  	var loadChartReport = function (){
  		var chart = $('#container').highcharts({
	        title: {
	            text: 'Report Campaign Chart',
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

	$scope.getSearchModalCampaign = function(validate){
		$scope.isLoading = true;
		$scope.campaign.start_date = $filter('date')(new Date($scope.campaign.startDate), 'yyyyMMdd');
  		$scope.campaign.end_date = $filter('date')(new Date($scope.campaign.endDate), 'yyyyMMdd');

  		$scope.submitted  = true;

  		if(validate || $scope.campaign.start_date > $scope.campaign.end_date) {
  			if($scope.campaign.start_date > $scope.campaign.end_date){
  				alert('End date is bigger Start date.');
  			}
  			return;
  		}
  
		CampaignService.searchReportCampaignByDateRange($scope.campaign).then(function(data){
			
			//set data search
			$scope.campaigns = data.campaigns;
			$scope.labels 	 = data.labels;
			$scope.total 	 = data.total;

			//set data chart
			$scope.dateRange = data.dateRange;
			$scope.dataReportChart = data.dataReportChart;
			
			$timeout(function(){
				loadChartReport();
			})
			
			$scope.isLoading = false;
		})
	}
	
}])