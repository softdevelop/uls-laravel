var guideConfigurator = angular.module('databaseManager');

guideConfigurator.controller('GuideConfiguratorController', ['$scope', '$modal', 'GuideConfiguratorService', '$timeout', '$filter', 'ngTableParams','ConfiguratorService','ConfiguratorService', 
    function ($scope, $modal, GuideConfiguratorService, $timeout, $filter, ngTableParams, ConfiguratorService, ConfiguratorService) {
    angular.element('#guide-container').removeClass('hidden');
    $scope.data = [];
    $scope.listMarterialOldValue = [];

    $scope.detailConfiguaration = {};

    $scope.listAnswerMapData = angular.copy(window.listAnswer);

    $scope.currentStep = 1;

    $scope.reportData = false;
    $scope.dataInput = {};
    $scope.dataInput.answerQuestions = {};
    
    $scope.listP2MaxC = [];
    $scope.listP2GMinC = [];
    $scope.listDLSC = [];
    $scope.listMLCC = [];

    $scope.currentPlatForm = {};

    $scope.initTree = function(){
        $timeout(function(){
            $scope.tableParams = new ngTableParams({
                page: 1,
                count: 10,
                filter: {
                },
                sorting: {
                }
            }, {
                total: $scope.data.length,
                getData: function ($defer, params) {
                    var orderedData = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                    orderedData = params.sorting() ? $filter('orderBy')(orderedData, params.orderBy()) : orderedData;
                    $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                }
            });

            $("#tree").fancytree({
                extensions: ["glyph",'filter'],
                source: $scope.databaseTree,
                checkbox:true,
                autoScroll: true,
                filter: {
                    mode: "dimm"  // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
                },
                activate: function (event, data){
                    data.node.setExpanded(true);
                    if(!data.node.isFolder()) {
                        if(data.node.isSelected()) {
                            data.node.setSelected(false);
                        } else {
                            data.node.setSelected(true);                            
                        }
                    }
                },
                select : function(event, data) {
                    var check = $scope.data.map(function(e) { return e.id; }).indexOf(data.node.data.id);

                    if(check == -1) {
                        data.node.data.categoryId = data.node.parent.data.id;
                        data.node.data.categoryName = data.node.parent.title;
                        $scope.data.push(data.node.data);
                        $scope.listMarterialOldValue[data.node.data.content.id] = data.node.data.content;
                    } else {
                        $scope.data.splice(check,1);
                        $scope.listMarterialOldValue.splice(data.node.data.content.id);
                    }
                  
                    $scope.dataInput.materials = $scope.data;
                    $scope.tableParams.reload();
                }
            });

            $scope.getTree = $('#tree').fancytree('getTree');
        });
    }

    $scope.filterTree = function() {
        $scope.getTree.clearFilter();
        if($scope.treeFilter != '') {
            $scope.getTree.filterNodes($scope.treeFilter,{autoExpand:true, leavesOnly:true});
        }
    }

    $scope.checkEmail = function(email) {

        var regex_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i;
        if(regex_email.test(email) == false && angular.isDefined(email) && email !== '') {
            $scope.messageError = "Email Invalid"; 
            return $scope.messageError;
        } 
    }

    $('#guide-container').find('ul>li>a[href="#next"]').click(function() {

        $scope.changeStep();
    });
    
    $scope.changeStep = function() {

        $scope.reportData = false;

        $scope.dataInput.step = $scope.currentStep;
        //call data input for each step.
        $scope.addDataInputForEachStep(function(){
            $scope.currentStep ++;
            if ($scope.currentStep == 2) {
                $('#guide-container').find('.first').addClass('disabled');
            }
            if ($scope.currentStep == 3) {
                $('#guide-container').find('.done').addClass('disabled')
                $scope.isShowDetail = false;
                caculatorMaterialValueAndGetListPlatform();
            }
            $scope.dataInput.step = $scope.currentStep;
        }); 
    }

    $scope.addDataInputForEachStep = function(callback)
    {
        ConfiguratorService.create($scope.dataInput).then(function(data){
            console.log(data);
            if (angular.isDefined(data.item._id)) {
                $scope.dataInput._id = data.item._id;

                callback.call();

            }
        });
    }

    /**
     * [caculatorMaterialValueAndGetListPlatform description]
     * @return {[type]} [description]
     */
    function caculatorMaterialValueAndGetListPlatform() {

        if (angular.isDefined($scope.data) && Object.keys(angular.extend({}, $scope.data)).length) {

            passingEachListMarterial($scope.data, function(data) {

                $('#page-loading').css('display', 'block');

                var maxP2GMaxCValue = Math.max.apply(null, $scope.listP2MaxC);

                var indexP2MaxC = $scope.listP2MaxC.indexOf(maxP2GMaxCValue);

                getNearestALPWithMaxP2GMaxC(maxP2GMaxCValue);

                var dataValue = (angular.isDefined($scope.ALP))?{'alp':$scope.ALP}:null;
                if (angular.isDefined($scope.dataInput.question_third) && $scope.dataInput.question_third == 'productivity') {
                    dataValue['productivity'] = true;
                } else if(angular.isDefined($scope.dataInput.question_third)) {
                    dataValue['productivity'] = false;
                } else {
                    dataValue['productivity'] = null;
                }

                dataValue['dualLaser'] = (angular.isDefined($scope.listDLSC[indexP2MaxC]))?$scope.listDLSC[indexP2MaxC]:null;
                dataValue['multipleLaser'] = (angular.isDefined($scope.listMLCC[indexP2MaxC]))?$scope.listMLCC[indexP2MaxC]:null;

                GuideConfiguratorService.getListPlatform(dataValue).then(function(result) {

                    $('#page-loading').css('display', 'none');


                    if (result.result) {
                        $scope.isShowDetail = true;
                        $scope.currentPlatForm = result;
                        $scope.dataInput['platform_id'] = result.result.id;
                    }

                    showDetailGuidedConfig();

                    // showModelChoosePlastform(result.result);
                })                    
            });

        }
    }

    /**
     * [showDetailGuidedConfig description]
     * @return {[type]} [description]
     */
    function showDetailGuidedConfig() {
        $scope.detailConfiguaration['emailConfig'] = $scope.dataInput['email'];

        $scope.detailConfiguaration['question'] = {
            'question_first':$scope.dataInput['question_first'],
            'question_second' : $scope.dataInput['question_second'],
            'question_third' : $scope.dataInput['question_third'],
        };

        $scope.detailConfiguaration['platform_id'] = $scope.dataInput['platform_id'];

        $scope.detailConfiguaration['detailConfig'] = {};

        var material = $scope.dataInput['materials'];

        for (var key in material) {
            $scope.detailConfiguaration['detailConfig'][material[key].id] = material[key].content;
        }
    }

    /**
     * [passingEachListMarterial description]
     *
     * @author [Kim Bang]  [bang@httsolution.com]
     * @param  {[type]} listMarterial [description]
     * @return {[type]}               [description]
     */
    function passingEachListMarterial(listMarterial, callback) {
        for (var key in listMarterial) {
            var newData = listMarterial[key];
            var oldData = $scope.listMarterialOldValue[newData.content.id];


            $scope.caculator(oldData, newData);
        }

        callback.call(true, $scope.ALP);
    }

    /**
     * [caculator description]
     *
     * @author [Tan Luc] [luc@httsolution.com]
     * @param  {[type]} oldData [description]
     * @param  {[type]} newData [description]
     * @return {[type]}         [description]
     */
    $scope.caculator = function(oldData, newData) {
        $scope.P2Min = 0;
        $scope.P2Max = 0;

        var T1 = parseFloat(oldData.default_min_thickness);
        var T3 = parseFloat(oldData.default_max_thickness);
        var P1 = parseFloat(oldData.power_at_min_thickness);
        var P3 = parseFloat(oldData.power_at_max_thickness);
        var minT2 =  parseFloat(newData.content.min_thickness);
        var maxT2 =  parseFloat(newData.content.max_thickness);

        if(T1 == T3){
            $scope.P2Min = P1;
            $scope.P2Max = P1;
        } else {
            $scope.P2Min = (((minT2 - T1)*(P3 - P1))/(T3 - T1)) + P1;
            $scope.P2Max = (((maxT2 - T1)*(P3 - P1))/(T3 - T1)) + P1;
        }

        $scope.maxMPRC = Math.max(parseFloat(oldData.engrave_mark_recommended_power), parseFloat($scope.P2Min), parseFloat($scope.P2Max));

        $scope.minMPRC = Math.min(parseFloat(oldData.engrave_mark_recommended_power), parseFloat($scope.P2Min), parseFloat($scope.P2Max));

        caculatorGlobalLaser($scope.minMPRC, $scope.maxMPRC, function(result) {
            newData.content = angular.extend(newData.content, result);            
        });
    }

    /**
     * [caculatorGlobalLaser description]
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} minMPRC [description]
     * @param  {[type]} maxMPRC [description]
     * @return {[type]}         [description]
     */
    function caculatorGlobalLaser(minMPRC, maxMPRC, calback) {
        var P2GMinC = 0;
        var P2GMaxC = 0;
        var MLCC = false;
        var DLSC = false;

        var globalCaculator = {};

        // if (P2GMinC > 0 && minMPRC < P2GMinC) {
            P2GMinC = minMPRC;
        // }

        // if (maxMPRC > P2GMaxC) {
            P2GMaxC = maxMPRC;
        // }

        //Global Calculation: Material Type C02 Multiple Laser Configuration TRUE or FALSE
        var sub = P2GMaxC - P2GMinC;
        if (sub > 60) {
            MLCC = true;
        }

        if (sub > 75) {
            DLSC = true;
        }

        $scope.listP2MaxC.push(P2GMaxC);
        $scope.listP2GMinC.push(P2GMinC);
        $scope.listDLSC.push(DLSC);
        $scope.listMLCC.push(MLCC);

        globalCaculator = {
            'min_global_laser' : P2GMinC,
            'max_global_laser' : P2GMaxC,
            'mlcc' : MLCC,
            'dlsc' : DLSC,
        }

        calback.call(true, globalCaculator);
    }

    /**
     * [getNearestALPWithMaxP2GMaxC description]
     * @param  {[type]} value [description]
     * @return {[type]}       [description]
     */
    function getNearestALPWithMaxP2GMaxC(value) {
        var listALP = angular.copy(window.listALP);

        var maxValue = Math.max.apply(null, listALP);

        if (parseFloat(value) > parseFloat(maxValue)) {
            for (var i = value; i >= 0; i--) {
                if (listALP.indexOf(i) != -1) {
                    $scope.ALP = i;
                    break;
                }
            }
        } else {
            for (var i = value; i <= maxValue; i++) {
                if (listALP.indexOf(i) != -1) {
                    $scope.ALP = i;
                    break;
                }
            }
        }
    }

    $scope.getModalConfigMaterial = function(materials){
        var teamplate = '/app/components/database/views/config-material.html?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + teamplate,
            controller: 'ModalConfigMaterial',
            size: 'lg',
            resolve: {
                material: function() {
                    return materials;
                }
            }
            
        });

        modalInstance.result.then(function (data) {
        }, function () {

           });
    };

    $scope.removeMaterial = function(id) {
        var conf = confirm("Would you want to remove this material?");
        if(!conf) {
            return;
        }
        angular.forEach($scope.data, function(value,key){
            if(value.id == id) {
                // $scope.data.splice(key, 1);
                var tree = $('#tree').fancytree('getTree');
                var node = tree.getNodeByKey(String(id));
                node.setSelected(false);
                node.setActive(false);
                $scope.tableParams.reload();
            }
        });
    }

    $scope.addAccessories = function(value) {
        if (angular.isUndefined($scope.dataInput.selectedAccessories)) {
            $scope.dataInput.selectedAccessories = [];
        }

        if ($scope.dataInput.selectedAccessories.indexOf(value) !== -1) return;

        $scope.dataInput.selectedAccessories.push(value);
        
    }
   $scope.deleteAccessories = function(accessoryId) {
        for (var key in $scope.dataInput.selectedAccessories) {
            if ($scope.dataInput.selectedAccessories[key].id == accessoryId) {
                $scope.dataInput.selectedAccessories.splice(key, 1);
                break;
            }
        }
    }

    $scope.addDataInputForEachStep = function()
    {
        ConfiguratorService.create($scope.dataInput).then(function(data){
            if (angular.isDefined(data._id)) {
                $scope.dataInput._id = data._id;
            }
        });
    }


}]);
guideConfigurator.controller('ModalConfigMaterial', ['$scope', '$modalInstance', 'material', function ($scope, $modalInstance, material) {

    $scope.config = angular.copy(material);

    if($scope.config.content.engrave_mark_recommended_power == 0 ){
        $scope.engrave = true;
        $scope.config.content.engraving = false;
    } else {
        $scope.engrave = false;
        $scope.config.content.engraving = true
    }
    
    if($scope.config.content.min_thickness == 0 || $scope.config.content.max_thickness == 0){
        $scope.checkCutting = true;
    } else {
        $scope.checkCutting = false;
    }

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };

    $scope.next = function () {
        console.log($scope.config);
        $scope.formDataInvalid = false;

        var minThick = $scope.config.content.min_thickness;
        var maxThick = $scope.config.content.max_thickness;
        var defaultMin = $scope.config.content.default_min_thickness;
        var defaultMax = $scope.config.content.default_max_thickness;

        console.log(minThick, defaultMin,'lol');
        console.log(maxThick, defaultMax,'lol1');
        $scope.submitted = true;

        if($scope.config.content.cut && (minThick < defaultMin || maxThick > defaultMax || minThick > maxThick)) {
            $scope.minMaxThicknessInvalid = true;
            $scope.formDataInvalid = true;
        }

        if(!$scope.config.content.cut) {
            $scope.config.content.min_thickness = defaultMin;
            $scope.config.content.max_thickness = defaultMax;
        }

        if(angular.isUndefined($scope.config.content.width) || $scope.config.content.width < $scope.config.content.min_width) {
            $scope.minWidthInvalid = true;
            $scope.formDataInvalid = true;
        }

        if(angular.isUndefined($scope.config.content.height) ||  $scope.config.content.height < $scope.config.content.min_height) {
            $scope.minHeightInvalid = true;
            $scope.formDataInvalid = true;
        }

        if(angular.isUndefined($scope.config.content.depth) ||  $scope.config.content.depth < $scope.config.content.min_depth) {
            $scope.minDepthInvalid = true;
            $scope.formDataInvalid = true;
        }

        if($scope.formDataInvalid) {
            return;
        }
        console.log($scope.config);
        $modalInstance.close($scope.config);
    };

    $scope.convertUnit = function() {
        //1 inch = 25.4 millimeters
        console.log($scope.config.content.unit,'$scope.config.content.unit');
        if($scope.config.content.unit == 'inches') {
            //convert value validate from milimeters to inches
            $scope.config.content.default_min_thickness = $scope.config.content.default_min_thickness / 25.4;
            $scope.config.content.default_max_thickness = $scope.config.content.default_max_thickness / 25.4;
            $scope.config.min_height = $scope.config.min_height / 25.4;
            $scope.config.min_width = $scope.config.min_width / 25.4;
            $scope.config.min_depth = $scope.config.min_depth / 25.4;
        } else {
            //convert value validate from inches to milimeters
            $scope.config.content.default_min_thickness = $scope.config.content.default_min_thickness * 25.4;
            $scope.config.content.default_max_thickness = $scope.config.content.default_max_thickness * 25.4;
            $scope.config.min_height = $scope.config.min_height * 25.4;
            $scope.config.min_width = $scope.config.min_width * 25.4;
            $scope.config.min_depth = $scope.config.min_depth * 25.4;
        }
    }

    $scope.changeNameMaterial = function(data) {
        if(data == '') {
            return "Name field is required!";
        }
        $scope.config.name = data;
    }
}]);

