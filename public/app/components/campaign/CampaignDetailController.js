campaignDetailApp.controller('campaignDetailCtrl', ['$scope', '$modal', '$filter', 'CampaignDetailService', '$timeout', 'ngTableParams', function ($scope, $modal, $filter, CampaignDetailService, $timeout, ngTableParams) {
	
	$scope.isLoading = false;
	$scope.isLoadingChart = false;

	Number.prototype.round = function(places) {
  return +(Math.round(this + "e+" + places)  + "e-" + places);
}

	$scope.campaigns = angular.copy(window.campaigns);
	$scope.totalCampaign = {'CPA':0, 'AvgCPC':0};
	$scope.campaignsData = [];
	for(var key in $scope.campaigns) {
		$scope.campaigns[key]['groupId'] = key;
		$scope.totalCampaign['CPA']+= $scope.campaigns[key].CPA;
		$scope.totalCampaign['AvgCPC']+= $scope.campaigns[key].AvgCPC;
		$scope.campaignsData.push($scope.campaigns[key]);
	}

	$scope.tableParams = new ngTableParams({
	    page: 1, // show first page
	    count: 10, // count per page
	    sorting: {
	        'name': 'asc' // initial sorting
	    }
		}, {
		    total: $scope.campaignsData.length, // length of data
		    getData: function($defer, params) {
		        var orderedData = params.sorting() ? $filter('orderBy')($scope.campaignsData, params.orderBy()) : $scope.campaignsData;
		        orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
		        params.total(orderedData.length);
		        $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
		    }
	});

	$scope.total = angular.copy(window.total);
		$scope.total['CPA'] = $scope.totalCampaign['CPA'];
	$scope.total['AvgCPC'] = $scope.totalCampaign['AvgCPC'].round(5);

	$scope.campaignId = angular.copy(window.campaignId);
	$scope.groupId = angular.copy(window.groupId);

	/* Init scope campaign*/
	$scope.campaign = {};

	/* Format start and end date with style 'MM-dd-yyyy' */
	$scope.campaign.endDate   = $filter('date')(new Date(window.endDate), 'MM-dd-yyyy');
	$scope.campaign.startDate = $filter('date')(new Date(window.startDate), 'MM-dd-yyyy');

	/* Set dateRang scope data */
	$scope.dateRange = window.dateRange;

	/* Each dateRange format date with 'MM-dd-yyyy' */
	for (var key in $scope.dateRange) {
		$scope.dateRange[key] = $filter('date')(new Date(dateRange[key]), 'MM-dd-yyyy');
	}

	/* Data report to show in chart */
	$scope.dataReportChart = angular.copy(window.dataReportChart);

	$scope.open = function($event, type) {
    	$event.preventDefault();
    	$event.stopPropagation();
    	$scope.opened = {};
    	$scope.opened[type] = true;
  	};
  	
  	$scope.format = 'MM-dd-yyyy';

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
	        yAxis: [{ // Primary yAxis
	            labels: {
	                style: {
	                    color: Highcharts.getOptions().colors[1]
	                },
	                formatter: function () {
	                    return this.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	                }
	            },
	            title: {
	                text: $scope.typeSecondFilter,
	                style: {
	                    color: Highcharts.getOptions().colors[1]
	                }
	            },
	            opposite: true

	        }, { // Secondary yAxis
	            title: {
	                text: $scope.typeFirstFilter,
	                style: {
	                    color: Highcharts.getOptions().colors[0]
	                }
	            },
	            labels: {
	                style: {
	                    color: Highcharts.getOptions().colors[0]
	                },
	                formatter: function () {
	                    return this.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	                }
	            }

	        }],
	        tooltip: {
	            valueSuffix: ' clicks'
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [{
	            name: $scope.typeFirstFilter,
	            yAxis: 1,
	            data: $scope.dataFirstSelect,
	            tooltip: {
	                valueSuffix: ' '
	            }

	        }, {
	            name: $scope.typeSecondFilter,
	            data: $scope.dataSecondSelect,
	            tooltip: {
	                valueSuffix: ' '
	            }
	        }]
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
			$scope.totalCampaign = {'CPA':0, 'AvgCPC':0};
			/* Set array null*/
			$scope.campaignsData = [];

			/* Set data result of report for scope campaigns */
			$scope.campaigns = data.campaigns;
			
			/* Data range for x-Axis in chart */
			$scope.dateRange = data.dateRange;
			/* Each dateRange format date with 'MM-dd-yyyy' */
			for (var key in $scope.dateRange) {
				$scope.dateRange[key] = $filter('date')(new Date($scope.dateRange[key]), 'MM-dd-yyyy');
			}

			/* Data for line in chart */
			$scope.dataReportChart = data.dataReportChart;
			
			/* Format data report to show in table */
			for(var key in $scope.campaigns) {
				$scope.campaigns[key]['groupId'] = key;
				$scope.totalCampaign['CPA']+= $scope.campaigns[key].CPA;
				$scope.totalCampaign['AvgCPC']+= $scope.campaigns[key].AvgCPC;
				$scope.campaignsData.push($scope.campaigns[key]);
			}

			/* Row total in table */
			$scope.total = data.total;
			$scope.total['CPA'] = $scope.totalCampaign['CPA'];
			$scope.total['AvgCPC'] = $scope.totalCampaign['AvgCPC'].round(5);
			/*set agina filter*/
			$scope.filterFirstSelect($scope.firstSelect.typeFilterFirst);
			$scope.filterSecondSelect($scope.secondSelect.typeFilterSecond);
			/* Reload ng-table */
			$scope.tableParams.reload();

			/* Load chart */
			$timeout(function(){
				loadChartReport();
			})
			
			/* Stop icon loading */
			$scope.isLoading = false;
		})
	}

	/* When user choosen first select then show the first line with data respective of typeFilterFirst in chart */
    $scope.filterFirstSelect = function (typeFilterFirst){
        $scope.dataFirstSelect = $scope.dataReportChart[typeFilterFirst].data;
        $scope.typeFirstFilter = $scope.dataReportChart[typeFilterFirst].name;
        if($scope.typeFirstFilter == 'Avg. CPC') $scope.typeFirstFilter = 'Conv. Rate';
        loadChartReport();
    }

    /* When user choosen second select then show the second line with data respective of typeFilterSecond in chart */
    $scope.filterSecondSelect = function (typeFilterSecond){
    	$scope.dataSecondSelect = $scope.dataReportChart[typeFilterSecond].data;
        $scope.typeSecondFilter = $scope.dataReportChart[typeFilterSecond].name;
        if($scope.typeSecondFilter == 'Avg. CPC') $scope.typeSecondFilter = 'Conv. Rate';
        loadChartReport();
    }

}])