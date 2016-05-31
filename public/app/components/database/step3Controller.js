var guideConfigurator = angular.module('databaseManager');

guideConfigurator.controller('Step3Controller', ['$scope', '$modal', 'ngTableParams', '$timeout', 'GuideConfiguratorService', '$filter', '$templateCache', function ($scope, $modal, ngTableParams, $timeout, GuideConfiguratorService, $filter, $templateCache){
    var step3Ctrl = this;

    step3Ctrl.option = {
        message: {
            ok: 'I\'m Done Adding Accessories',
            no: 'Yes'
        }
    };

    step3Ctrl.addingAccessory = function() {

        var data = [ 
        {  "id" : 1,
            "name" : "VLS2.30",
            "fiber" : 0,
            "width" : 16,
            "height": 12,
            "depth" : 4,
            "width_exceptions": 0,
            "max_co2_lsrpwr": 30
        },
        {
            "id" : 2,
            "name" : "VLS3.50",
            "fiber" : 0,
            "width" : 24,
            "height" : 12,
            "depth" : 4,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 50
        },
        {
            "id" : 3,
            "name" : "VLS3.60",
            "fiber" : 0,
            "width" : 24,
            "height" : 12,
            "depth" : 9,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 60
        },
        {
            "id" : 4,
            "name" : "VLS4.60",
            "fiber" : 0,
            "width" : 24,
            "height" : 18,
            "depth" : 9,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 60
        },
        {
            "id" : 5,
            "name" : "VLS6.60",
            "fiber" : 0,
            "width" : 32,
            "height" : 18,
            "depth" : 9,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 60
        },
        {
            "id" : 6,
            "name" : "PLS4.75",
            "fiber" : 0,
            "width" : 24,
            "height" : 18,
            "depth" : 9,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 75
        },
        {
            "id" : 7,
            "name" : "PLS6.75",
            "fiber" : 0,
            "width" : 32,
            "height" : 18,
            "depth" : 9,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 75
        },
        {
            "id" : 8,
            "name" : "PLS6.150D",
            "fiber" : 0,
            "width" : 32,
            "height" : 18,
            "depth" : 9,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 150
        },
        {
            "id" : 8,
            "name" : "PLS6.150D",
            "fiber" : 0,
            "width" : 32,
            "height" : 18,
            "depth" : 9,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 150
        },
        {
            "id" : 9,
            "name" : "PLS6MW",
            "fiber" : 0,
            "width" : 32,
            "height" : 18,
            "depth" : 9,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 75
        },
        {
            "id" : 10,
            "name" : "ILS9.150D",
            "fiber" : 0,
            "width" : 36,
            "height" : 24,
            "depth" : 12,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 150
        },
        {
            "id" : 11,
            "name" : "ILS12.150D",
            "fiber" : 0,
            "width" : 48,
            "height" : 24,
            "depth" : 12,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 150
        },
        {
            "id" : 12,
            "name" : "XLS10.150D",
            "fiber" : 0,
            "width" : 40,
            "height" : 24,
            "depth" : 12,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 150
        },
        {
            "id" : 13,
            "name" : "XLS10MWH",
            "fiber" : 0,
            "width" : 40,
            "height" : 24,
            "depth" : 12,
            "width_exceptions" : 0,
            "max_co2_lsrpwr" : 150
        }
        ];
        GuideConfiguratorService.getLaserOfListPlatform(data).then( function(data){

        });
    }
}]);



