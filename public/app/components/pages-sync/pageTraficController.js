pageApp.controller('PageController', ['$scope', '$modal', '$filter', 'ngTableParams', '$timeout', function($scope, $modal, $filter, ngTableParams, $timeout) {
    $scope.setLink = function(pageId, tabType) {
        window.location.href= window.baseUrl + "/seo/pages/seo-page-report/"+pageId+"/"+tabType;
    }
}]);
pageApp.controller('PageControllerTraffic', ['$scope', '$modal', '$filter', 'ngTableParams', '$timeout', function($scope, $modal, $filter, ngTableParams, $timeout) {

    $scope.setLink = function(pageId, tabType) {
        window.location.href= window.baseUrl + "/seo/pages/seo-page-report/"+pageId+"/"+tabType;
    }
    var mobileArray = ['android', 'windows phone', 'ios', 'blackberry', 'ipad', 'ipod'];
    $scope.traffic = angular.copy(window.results);

    /* Declare dataReport for contain data plus session, users.... */
    $scope.dataReport = {};
    $scope.language = {};
    $scope.country = {};
    $scope.city = {};
    $scope.browser = {};
    $scope.operatingSystem = {};
    $scope.operatingSystemMobile = {};
    $scope.providerSystem = {};
    $scope.providerSystemMobile = {};
    $scope.screenResolution = {};
    $scope.screenResolutionMobile = {};

    /* Declare $scope dataRight to contain data of (language, country, city...) */
    $scope.dataRight = {
        language: {},
        city: {},
        country: {},
        browser: {},
        providerSystem: {
            mobile: {},
            noneMobile: {}
        },
        operatingSystem: {
            mobile: {},
            noneMobile: {}
        },
        screenResolution: {
            mobile: {}
        }

    };

    /* Get data to show chart */
    for(var i = 0; i < $scope.traffic.length; i++){
        (function(i){
        /* Get language with session */
        if (!angular.isDefined($scope.dataRight.language[$scope.traffic[i].rows[0]])) {
            $scope.dataRight.language[$scope.traffic[i].rows[0]] = 0;
        }
        $scope.dataRight.language[$scope.traffic[i].rows[0]] += parseInt($scope.traffic[i].rows[7]);

        /* Get country with session */
        if (!angular.isDefined($scope.dataRight.country[$scope.traffic[i].rows[1]])) {
            $scope.dataRight.country[$scope.traffic[i].rows[1]] = 0;
        }
        $scope.dataRight.country[$scope.traffic[i].rows[1]] += parseInt($scope.traffic[i].rows[7]);

        /* Get city with session */
        if (!angular.isDefined($scope.dataRight.city[$scope.traffic[i].rows[2]])) {
            $scope.dataRight.city[$scope.traffic[i].rows[2]] = 0;
        }
        $scope.dataRight.city[$scope.traffic[i].rows[2]] += parseInt($scope.traffic[i].rows[7]);

        /* Get browser with session */
        if (!angular.isDefined($scope.dataRight.browser[$scope.traffic[i].rows[3]])) {
            $scope.dataRight.browser[$scope.traffic[i].rows[3]] = 0;
        }
        $scope.dataRight.browser[$scope.traffic[i].rows[3]] += parseInt($scope.traffic[i].rows[7]);

        /* Get operating System with session */
        if (mobileArray.indexOf($scope.traffic[i].rows[4].toLowerCase()) == -1) {
            /* If $scope.dataRight.operatingSystem.noneMobile is undefined then declare = 0  */
            if (!angular.isDefined($scope.dataRight.operatingSystem.noneMobile[$scope.traffic[i].rows[4]])) {
                $scope.dataRight.operatingSystem.noneMobile[$scope.traffic[i].rows[4]] = 0;
            } else {/* Sum $scope.dataRight.operatingSystem.noneMobile with session */
                $scope.dataRight.operatingSystem.noneMobile[$scope.traffic[i].rows[4]] += parseInt($scope.traffic[i].rows[7]);
            }     
        }  else {
            /* If $scope.dataRight.operatingSystem.mobile is undefined then declare = 0  */
            if (!angular.isDefined($scope.dataRight.operatingSystem.mobile[$scope.traffic[i].rows[4]])) {
                $scope.dataRight.operatingSystem.mobile[$scope.traffic[i].rows[4]] = 0;
            } else {/* Sum $scope.dataRight.operatingSystem.mobile with session */
                $scope.dataRight.operatingSystem.mobile[$scope.traffic[i].rows[4]] += parseInt($scope.traffic[i].rows[7]);
            }
        } 

        /* Get provider System with session */
        if (mobileArray.indexOf($scope.traffic[i].rows[4].toLowerCase()) == -1) {
            /* If $scope.dataRight.providerSystem.noneMobile is undefined then declare = 0  */
            if (!angular.isDefined($scope.dataRight.providerSystem.noneMobile[$scope.traffic[i].rows[5]])) {
                $scope.dataRight.providerSystem.noneMobile[$scope.traffic[i].rows[5]] = 0;
            } else {/* Sum $scope.dataRight.providerSystem.noneMobile with session */
                $scope.dataRight.providerSystem.noneMobile[$scope.traffic[i].rows[5]] += parseInt($scope.traffic[i].rows[7]);
            }     
        }  else {
            /* If $scope.dataRight.providerSystem.mobile is undefined then declare = 0  */
            if (!angular.isDefined($scope.dataRight.providerSystem.mobile[$scope.traffic[i].rows[5]])) {
                $scope.dataRight.providerSystem.mobile[$scope.traffic[i].rows[5]] = 0;
            } else {/* Sum $scope.dataRight.providerSystem.mobile with session */
                $scope.dataRight.providerSystem.mobile[$scope.traffic[i].rows[5]] += parseInt($scope.traffic[i].rows[7]);
            }
        }

        /* Get Screen Resolution System with session */
        if (mobileArray.indexOf($scope.traffic[i].rows[4].toLowerCase()) != -1) {
            /* If $scope.dataRight.screenResolution.mobile is undefined then declare = 0  */
            if (!angular.isDefined($scope.dataRight.screenResolution.mobile[$scope.traffic[i].rows[6]])) {
                $scope.dataRight.screenResolution.mobile[$scope.traffic[i].rows[6]] = 0;
            } else {/* Sum $scope.dataRight.screenResolution.mobile with session */
                $scope.dataRight.screenResolution.mobile[$scope.traffic[i].rows[6]] += parseInt($scope.traffic[i].rows[7]);
            }     
        }

        /* If data report is emptype */
        if(typeof $scope.dataReport[$scope.traffic[i].rows[14]] != 'undefined')
        {/* Group data with date and sum data of session, users, pageViews.... */
            $scope.dataReport[$scope.traffic[i].rows[14]] = {
                'session':parseInt($scope.dataReport[$scope.traffic[i].rows[14]].session) +parseInt($scope.traffic[i].rows[7]),
                'users':parseInt($scope.dataReport[$scope.traffic[i].rows[14]].users) + parseInt($scope.traffic[i].rows[8]),
                'pageView':parseInt($scope.dataReport[$scope.traffic[i].rows[14]].pageView) + parseInt($scope.traffic[i].rows[9]),
                'pagesSecsion':parseInt($scope.dataReport[$scope.traffic[i].rows[14]].pagesSecsion) + parseInt($scope.traffic[i].rows[10]),
                'avgSessionDuration':parseInt($scope.dataReport[$scope.traffic[i].rows[14]].avgSessionDuration) + parseInt($scope.traffic[i].rows[11]),
                'bounceRate':parseInt($scope.dataReport[$scope.traffic[i].rows[14]].bounceRate) + parseInt($scope.traffic[i].rows[12]),
                'percentNewSessions':parseInt($scope.dataReport[$scope.traffic[i].rows[14]].percentNewSessions)+ parseInt($scope.traffic[i].rows[13])
            };
        }
        else{/* If data report not emptype then declare first value for it */
            $scope.dataReport[$scope.traffic[i].rows[14]] = {
                'session':parseInt($scope.traffic[i].rows[7]),
                'users':parseInt($scope.traffic[i].rows[8]),
                'pageView':parseInt($scope.traffic[i].rows[9]),
                'pagesSecsion':parseInt($scope.traffic[i].rows[10]),
                'avgSessionDuration':parseInt($scope.traffic[i].rows[11]),
                'bounceRate':parseInt($scope.traffic[i].rows[12]),
                'percentNewSessions':parseInt($scope.traffic[i].rows[13])
            };
        }
    })(i);
    }
    /* Declare value to contain value for show data in chart */
    $scope.dataSession = [];
    $scope.dataBounce = [];
    $scope.user = [];
    $scope.pageViews = [];
    $scope.pageViewsPerSession = [];
    $scope.avgSession = [];
    $scope.newSession = [];
    $scope.dateRange = [];

    var count = 0;
    /* foreach data report to sum data for show in chart */
    for (var key in $scope.dataReport) {
        count++;
        $scope.dateRange.push(key);
        $scope.dataSession.push($scope.dataReport[key].session);
        $scope.dataBounce.push($scope.dataReport[key].bounceRate);
        $scope.user.push($scope.dataReport[key].users);
        $scope.pageViews.push($scope.dataReport[key].pageView);
        $scope.pageViewsPerSession.push($scope.dataReport[key].pagesSecsion);
        $scope.avgSession.push($scope.dataReport[key].avgSessionDuration);
        $scope.newSession.push($scope.dataReport[key].percentNewSessions);
    }
    
    /* Sum session Of data input to show total of session in Demon graphic */
    var sumTotalSession = function(data){
        $scope.totalSession = 0;
        for (var key in data){
            $scope.totalSession += data[key];
        }
    }

    /* When page loaded to show default value in Demon graphic is language */
    $scope.showData = $scope.dataRight.language;
    sumTotalSession($scope.dataRight.language);
    $scope.firtNameColumb = 'Language';

    $('li.item-gg').click(function(e) {
        e.preventDefault(); //prevent the link from being followed
        $('li.item-gg').removeClass('active');
        $(this).addClass('active');
    });

    /* Get data of of language to show in Demon graphics */
    $scope.getDataLanguage = function(type){
        $scope.showData = $scope.dataRight.language;
        /* Call function to sum sessoion of language */
        sumTotalSession($scope.dataRight.language);
        $scope.firtNameColumb = type;
    }
    /* Get data of of country to show in Demon graphics */
    $scope.getDataCountry = function(type){
        $scope.showData = $scope.dataRight.country;
        /* Call function to sum sessoion of country */
        sumTotalSession($scope.dataRight.country);
        $scope.firtNameColumb = type;
    }
    /* Get data of of city to show in Demon graphics */
    $scope.getDataCity = function(type){
        $scope.showData = $scope.dataRight.city;
        /* Call function to sum sessoion of city */
        sumTotalSession($scope.dataRight.city);
        $scope.firtNameColumb = type;
    }
    /* Get data of of browser to show in Demon graphics */
    $scope.getDataBrowser = function(type){
        $scope.showData = $scope.dataRight.browser;
        /* Call function to sum sessoion of browser */
        sumTotalSession($scope.dataRight.browser);
        $scope.firtNameColumb = type;
    }
    /* Get data of of Oparating system none mobile to show in Demon graphics */
    $scope.getDataOperatingSystem = function(type){
        $scope.showData = $scope.dataRight.operatingSystem.noneMobile;
        /* Call function to sum sessoion of Operating System */
        sumTotalSession($scope.dataRight.operatingSystem.noneMobile);
        $scope.firtNameColumb = type;
    }
    /* Get data of of Oparating system mobile to show in Demon graphics */
    $scope.getDataOperatingSystemMobile = function(type){
        $scope.showData = $scope.dataRight.operatingSystem.mobile;
        /* Call function to sum sessoion of Operating system mobile */
        sumTotalSession($scope.dataRight.operatingSystem.mobile);
        $scope.firtNameColumb = type;
    }
    /* Get data of of provider system none mobile to show in Demon graphics */
    $scope.getDataProviderSystem = function(type){
        $scope.showData = $scope.dataRight.providerSystem.noneMobile;
        /* Call function to sum sessoion of Provider System */
        sumTotalSession($scope.dataRight.providerSystem.noneMobile);
        $scope.firtNameColumb = type;
    }
    /* Get data of of provider system mobile to show in Demon graphics */
    $scope.getDataProviderSystemMobile = function(type){
        $scope.showData = $scope.dataRight.providerSystem.mobile;
        /* Call function to sum sessoion of Provider system Mobile */
        sumTotalSession($scope.dataRight.providerSystem.mobile);
        $scope.firtNameColumb = type;
    }
    /* Get data of of screen resolution mobile to show in Demon graphics */
    $scope.getDataScreenResolutionMobile = function(type){
        $scope.showData = $scope.dataRight.screenResolution.mobile;
        /* Call function to sum sessoion of Screen Resolution Mobile */
        sumTotalSession($scope.dataRight.screenResolution.mobile);
        $scope.firtNameColumb = type;
    }

    /* Load First line of chart with default value below */
    $scope.dataFirstSelect = $scope.dataSession;
    $scope.typeFirstFilter = 'Sessions';

    /* Load Second line of chart with default value below */
    $scope.dataSecondSelect = $scope.pageViews;
    $scope.typeSecondFilter = 'Page Views';

    /* When user choosen first select then show the first line with data respective of typeFilterFirst in chart */
    $scope.filterFirstSelect = function (typeFilterFirst){
        switch(typeFilterFirst) {
            case 'Sessions':
                $scope.dataFirstSelect = $scope.dataSession;
                break;
            case 'Users':
                $scope.dataFirstSelect = $scope.user;
                break;
            case 'Page Views':
                $scope.dataFirstSelect = $scope.pageViews;
                break;
            case 'Pages/Sessions':
                $scope.dataFirstSelect = $scope.pageViewsPerSession;
                break;
            case 'Avg.Sessions':
                $scope.dataFirstSelect = $scope.avgSession;
                break;
            case 'Bounce':
                $scope.dataFirstSelect = $scope.dataBounce;
                break;
            case 'New Sessions':
                $scope.dataFirstSelect = $scope.newSession;
                break;
        }
        $scope.typeFirstFilter = typeFilterFirst;
        loadCharReport();
    }
    /* When user choosen second select then show the second line with data respective of typeFilterSecond in chart */
    $scope.filterSecondSelect = function (typeFilterSecond){
        switch(typeFilterSecond) {
            case 'Sessions':
                $scope.dataSecondSelect = $scope.dataSession;
                break;
            case 'Users':
                $scope.dataSecondSelect = $scope.user;
                break;
            case 'Page Views':
                $scope.dataSecondSelect = $scope.pageViews;
                break;
            case 'Pages/Sessions':
                $scope.dataSecondSelect = $scope.pageViewsPerSession;
                break;
            case 'Avg.Sessions':
                $scope.dataSecondSelect = $scope.avgSession;
                break;
            case 'Bounce':
                $scope.dataSecondSelect = $scope.dataBounce;
                break;
            case 'New Sessions':
                $scope.dataSecondSelect = $scope.newSession;
                break;
        }
        $scope.typeSecondFilter = typeFilterSecond;
        loadCharReport();
    }

    /* Call function to show all chart */
    $scope.$watch('newSession',function(newVal, oldVal){
        if(count ==  Object.keys($scope.dataReport).length){
            $timeout(function(){
                loadChartSession();
                loadChartUser();
                loadCharPageViews();
                loadCharPageViewsPerSession();
                loadCharAvgSession();
                loadCharBounce();
                loadChartNewSession();
                loadChartCrawlAvailability();
                loadCharReport();
            });             
        }
    });

    /* Each dateRange format date with 'MM-dd-yyyy' */
    for (var key in $scope.dateRange) {
        $scope.dateRange[key] = $filter('date')(new Date($scope.dateRange[key]), 'MM-dd-yyyy');
    }

    /* Load the first chart in traffic page */
    var loadCharReport = function(){

        var chart = $('#chart-1').highcharts({
            title: {
                text: 'Report Traffic Chart',
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
                    text: $scope.typeFirstFilter,
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    },
                },
                opposite: true

            }, { // Secondary yAxis
                labels: {
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    },
                    formatter: function () {
                        return this.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                },
                title: {
                    text: $scope.typeSecondFilter,
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                }
            }],
            legend: {
                layout: 'vertical',
                borderWidth: 0
            },
            // series: $scope.dataReportChart
            series: [{
                yAxis: 1,
                name: $scope.typeSecondFilter,
                data: $scope.dataSecondSelect,
                tooltip: {
                    valueSuffix: ' '
                }

            }, {
                name: $scope.typeFirstFilter,
                data: $scope.dataFirstSelect,
                tooltip: {
                    valueSuffix: ' '
                }
            }]
        });
    }
    /* Load chart session in traffic page */
    var loadChartSession = function (){
        $(function () {
            $('#chart-session').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'Sessions',
                    style: {
                        fontSize: '13px',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    enabled:false
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    labels: {
                        enabled: false
                    },
                    minorTickLength: 0,
                    tickLength: 0
                },
                yAxis: {
                    gridLineWidth: 0,
                    minorGridLineWidth: 0,
                    lineColor: 'transparent',        
                    labels: {
                       enabled: false
                    },
                    title: {
                        enabled: false
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: false
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    showInLegend: false,
                    name: 'Sessions', 
                    data: $scope.dataSession
                },]
            });
        });
    }
    /* Load chart users in traffic page */
    var loadChartUser = function (){
        $(function () {
            $('#chart-user').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'Users',
                    style: {
                        fontSize: '13px',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    enabled: false
                },

                credits: {
                    enabled: false
                },
                xAxis: {
                    labels: {
                        enabled: false
                    },
                    minorTickLength: 0,
                    tickLength: 0
                },
                yAxis: {
                    gridLineWidth: 0,
                    minorGridLineWidth: 0,
                    lineColor: 'transparent',        
                    labels: {
                       enabled: false
                    },
                    title: {
                        enabled: false
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: false
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    showInLegend: false, 
                    name: 'Users', 
                    data: $scope.user
                },]
            });
        });
    }
    /* Load chart page views in traffic page */
    var loadCharPageViews = function (){
        $(function () {
            $('#chart-pages-view').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'Page Views',
                    style: {
                        fontSize: '13px',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    enabled: false
                },

                credits: {
                    enabled: false
                },
                xAxis: {
                    labels: {
                        enabled: false
                    },
                    minorTickLength: 0,
                    tickLength: 0
                },
                yAxis: {
                    gridLineWidth: 0,
                    minorGridLineWidth: 0,
                    lineColor: 'transparent',        
                    labels: {
                       enabled: false
                    },
                    title: {
                        enabled: false
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: false
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    showInLegend: false, 
                    name: 'Page Views', 
                    data: $scope.pageViews
                },]
            });
        });
    }
    /* Load chart page views per session in traffic page */
    var loadCharPageViewsPerSession = function (){
        $(function () {
            $('#chart-pages-view-session').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'Pages/Sessions',
                    style: {
                        fontSize: '13px',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    enabled: false
                },

                credits: {
                    enabled: false
                },
                xAxis: {
                    labels: {
                        enabled: false
                    },
                    minorTickLength: 0,
                    tickLength: 0
                },
                yAxis: {
                    gridLineWidth: 0,
                    minorGridLineWidth: 0,
                    lineColor: 'transparent',        
                    labels: {
                       enabled: false
                    },
                    title: {
                        enabled: false
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: false
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    showInLegend: false, 
                    name: 'Pages/Sessions', 
                    data: $scope.pageViewsPerSession
                },]
            });
        });
    }
    /* Load chart Average Session in traffic page */
    var loadCharAvgSession = function (){
        $(function () {
            $('#chart-pages-avg-session').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'Avg. Sessions',
                    style: {
                        fontSize: '13px',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    enabled: false
                },

                credits: {
                    enabled: false
                },
                xAxis: {
                    labels: {
                        enabled: false
                    },
                    minorTickLength: 0,
                    tickLength: 0
                },
                yAxis: {
                    gridLineWidth: 0,
                    minorGridLineWidth: 0,
                    lineColor: 'transparent',        
                    labels: {
                       enabled: false
                    },
                    title: {
                        enabled: false
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: false
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    showInLegend: false, 
                    name: 'Avg. Sessions', 
                    data: $scope.avgSession
                },]
            });
        });
    }
    /* Load chart bounce rate in traffic page */
    var loadCharBounce = function (){
        $(function () {
            $('#chart-pages-bounce').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'Bounce',
                    style: {
                        fontSize: '13px',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    enabled: false
                },

                credits: {
                    enabled: false
                },
                xAxis: {
                    labels: {
                        enabled: false
                    },
                    minorTickLength: 0,
                    tickLength: 0
                },
                yAxis: {
                    gridLineWidth: 0,
                    minorGridLineWidth: 0,
                    lineColor: 'transparent',        
                    labels: {
                       enabled: false
                    },
                    title: {
                        enabled: false
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: false
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    showInLegend: false,
                    name: 'Bounce',  
                    data: $scope.dataBounce
                },]
            });
        });
    }
    /* Load chart new session in traffic page */
    var loadChartNewSession = function (){
        $(function () {
            $('#chart-pages-new-session').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'New Sessions',
                    style: {
                        fontSize: '13px',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    enabled: false
                },

                credits: {
                    enabled: false
                },
                xAxis: {
                    labels: {
                        enabled: false
                    },
                    minorTickLength: 0,
                    tickLength: 0
                },
                yAxis: {
                    gridLineWidth: 0,
                    minorGridLineWidth: 0,
                    lineColor: 'transparent',        
                    labels: {
                       enabled: false
                    },
                    title: {
                        enabled: false
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: false
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    showInLegend: false, 
                    name: 'New Sessions',  
                    data: $scope.newSession
                },]
            });
        });
    }
    /* Load chart craw availability in traffic page */
    var loadChartCrawlAvailability = function () {
        $('#chart-test').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            credits: {
                enabled: false
            },
            xAxis: {
                lineColor: 'transparent',        
                labels:
                {
                    enabled: false
                },
                title: {
                    enabled: false
                }
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: "Brands",
                colorByPoint: true,
                data: [{
                    name: "",
                    y: 56.33
                }, {
                    name: "",
                    y: 24.03,
                    
                }, {
                    name: "",
                    y: 10.38
                }]
            }]
        });
    }

}])