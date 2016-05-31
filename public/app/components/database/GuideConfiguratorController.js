var guideConfigurator = angular.module('databaseManager');

guideConfigurator.controller('GuideConfiguratorController', ['$scope', '$modal', 'ngTableParams', '$timeout', 'GuideConfiguratorService', '$filter', '$templateCache', 'CmsService', function ($scope, $modal, ngTableParams, $timeout, GuideConfiguratorService, $filter, $templateCache, CmsService){

    // $scope.size = function(){
    //     CmsService.setHeightTable();
    // }

    $scope.GuideMe = function(){
        var teamplate = '/database-manager/guide-me?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: true,
            templateUrl: window.baseUrl + teamplate,
            controller: 'GuideMeController',
            size: 'lg',
            resolve: {
            }            
        });

        modalInstance.result.then(function (data) {
        }, function () {
        });
    };

    // function formatDataInfoGuide(url, email, material){
    //     $scope.Infor = [];
    //     $scope.Infor['inforConfigUser'] = {'url': url, 'email': email};
    //     $scope.Infor['material'] = {'material_id':material.id, 'min_cutting_thickness': material.min_cutting_thickness}; 
    // }

}]);
guideConfigurator.controller('GuideMeController', ['$scope', '$modal','$modalInstance', 'GuideConfiguratorService','CmsService', '$timeout', '$filter', 'ngTableParams', function ($scope, $modal, $modalInstance, GuideConfiguratorService, CmsService, $timeout, $filter, ngTableParams) {
    $scope.data = [];
    $scope.listMarterialOldValue = [];

    $scope.detailConfiguaration = {};

    $scope.listAnswerMapData = angular.copy(window.listAnswer);

    $scope.currentStep = 0;

    $scope.reportData = false;

    $scope.dataInput = {};

    $scope.listP2MaxC = [];
    $scope.listP2GMinC = [];
    $scope.listDLSC = [];
    $scope.listMLCC = [];

    $scope.maxHeight = null;
    $scope.maxWidth = null;
    $scope.maxDepth = null;
    $scope.requiresFiber = false;
    $scope.requiresCO2 = false;

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
                    console.log(data);
                    var check = $scope.data.map(function(e) { return e.id; }).indexOf(data.node.data.id);

                    if(check == -1) {
                        data.node.data.categoryId = data.node.parent.data.id;
                        data.node.data.categoryName = data.node.parent.title;
                        $scope.data.push(data.node.data);
                        $scope.listMarterialOldValue[data.node.data.content.id] = data.node.data.content;
                    } else {
                        $scope.data.splice(check,1);
                        $scope.listMarterialOldValue = angular.extend({}, $scope.listMarterialOldValue);

                        delete $scope.listMarterialOldValue[data.node.data.content.id];

                        $scope.listMarterialOldValue = angular.extend([], $scope.listMarterialOldValue);
                    }
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

    // window.onbeforeunload = function(event){
    //     console.log(event);
    //     reloadOrClodeBrowser();
    //     return 'test';
    //     console.log(event);
        
    // }

    // result = window.confirm('test');

    // if (window.confirm("test")) { 
    //     alert(1);
    // }

    $scope.size = function(){
        CmsService.setHeightTable();
    }   

    $scope.checkEmail = function(email) {

        var regex_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i;
        if(regex_email.test(email) == false && angular.isDefined(email) && email !== '') {
            $scope.messageError = "Email Invalid"; 
            return $scope.messageError;
        } 
    }

    $scope.changeStep = function() {

        $scope.reportData = false;

        if ($scope.currentStep == 0) {
            $scope.messageError = $scope.checkEmail($scope.dataInput.email);
            if (angular.isDefined($scope.messageError)) return;
        }

        $scope.dataInput.materials = $scope.data;

        if ($scope.currentStep == 2) {
            $scope.isShowDetail = false;
            caculatorMaterialValueAndGetListPlatform();
        }

        $scope.currentStep ++;
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

                dataValue['requiresFiber'] = ($scope.requiresFiber)?$scope.requiresFiber:false;
                dataValue['width'] = $scope.maxWidth;
                dataValue['height'] = $scope.maxHeight;
                dataValue['depth'] = $scope.maxDepth;

                dataValue['dualLaser'] = (angular.isDefined($scope.listDLSC[indexP2MaxC]))?$scope.listDLSC[indexP2MaxC]:false;
                dataValue['multipleLaser'] = (angular.isDefined($scope.listMLCC[indexP2MaxC]))?$scope.listMLCC[indexP2MaxC]:false;

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

    function showModelChoosePlastform(result) {
        var teamplate = '/database-manager/show-list-platform?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: true,
            templateUrl: window.baseUrl + teamplate,
            controller: 'PlatformModelController',
            // size: 'lg',
            resolve: {
                listPlatForm: function() {
                    return result;
                }
            }
        });

        modalInstance.result.then(function (data) {
            console.log(data);
        }, function () {
        });
    }

    // window.onbeforeunload = function () {
    //     return false;
    // };
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

        console.log($scope.detailConfiguaration, '$scope.detailConfiguaration');

        // $scope.reportData = true;
    }

    $scope.report = function() {
        GuideConfiguratorService.report($scope.detailConfiguaration).then(function(data){
        })
    }

    $scope.configMaterial = function(material) {
        if(angular.isUndefined($scope.dataInput.email)){
            var teamplate = '/app/components/database/views/modal/email-modal.html?v=' + new Date().getTime();
            var modalInstance = $modal.open({
                animation: true,
                templateUrl: window.baseUrl + teamplate,
                controller: 'EmailController',
                size: 'lg',
                resolve: {
                    dataInput: function() {
                        return $scope.dataInput;
                    }
                }            
            });

            modalInstance.result.then(function (data) {
                if(angular.isDefined($scope.dataInput.email)){
                    $scope.getConfigMaterial(material);
                }
            }, function () {
            });
        } else {
            $scope.getConfigMaterial(material);
        }
    }

    $scope.getConfigMaterial = function(material) {
        var teamplate = '/database-manager/config-material?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: true,
            templateUrl: window.baseUrl + teamplate,
            controller: 'ConfigMaterialController',
            size: 'lg',
            resolve: {
                material: function() {
                    return material;
                }
            }
        });

        modalInstance.result.then(function (data) {
            angular.forEach($scope.data, function(value, key) {
                if(value.id == material.id) {
                    $scope.data[key] = data;
                    $scope.tableParams.reload();
                    $scope.caculator(material.content, $scope.data[key]);
                }
            });
        }, function () {
        });
    }
    
    function reloadOrClodeBrowser()
    {
        if(angular.isUndefined($scope.dataInput.email)){
            var teamplate = '/app/components/database/views/modal/email-modal.html?v=' + new Date().getTime();
            var modalInstance = $modal.open({
                animation: true,
                templateUrl: window.baseUrl + teamplate,
                controller: 'EmailController',
                size: 'lg',
                resolve: {
                    dataInput: function() {
                        return $scope.dataInput;
                    }
                }            
            });

            modalInstance.result.then(function (data) {

            }, function () {
            });
        }
    }

    $scope.submitEmail = function(){
        $scope.messageError = $scope.checkEmail($scope.dataInput.email);
            if (angular.isDefined($scope.messageError)) return;
        $modalInstance.close(true);
    };

    $scope.cancelEmail = function(){
        $modalInstance.dismiss('cancel');
    }
    /**
     * [passingEachListMarterial description]
     *
     * @author [Kim Bang]  [bang@httsolution.com]
     * @param  {[type]} listMarterial [description]
     * @return {[type]}               [description]
     */
    function passingEachListMarterial(listMarterial, callback) {
        $scope.maxHeight = null;
        $scope.maxWidth = null;
        $scope.maxDepth = null;
        $scope.requiresFiber = false;
        $scope.requiresCO2 = false;

        for (var key in listMarterial) {
            var newData = listMarterial[key];
            var oldData = $scope.listMarterialOldValue[newData.content.id];

            $scope.caculator(oldData, newData);

            if (newData.content.laser_type == 'CO2') {
                $scope.requiresCO2 = true;
            }

            if (newData.content.laser_type == 'Fiber') {
                $scope.requiresFiber = true;
            }

            if(angular.isDefined(newData.content.width) && angular.isDefined(newData.content.depth) && (newData.content.depth > newData.content.width)){
                var tmp = newData.content.depth;
                newData.content.depth = newData.content.width;
                newData.content.width = $tmp;
            }


            if (angular.isDefined(newData.content.height) && ($scope.maxHeight == null || $scope.maxHeight < newData.content.height)) {
                $scope.maxHeight = newData.content.height;
            }
            if (angular.isDefined(newData.content.width) && ($scope.maxWidth == null || $scope.maxWidth < newData.content.width)) {
                $scope.maxWidth = newData.content.width;
            }
            if (angular.isDefined(newData.content.depth) && ($scope.maxDepth == null || $scope.maxDepth < newData.content.depth)) {
                $scope.maxDepth = newData.content.depth;
            }

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

    $scope.removeMaterial = function(id, name) {
        var conf = false;

        var teamplate = '/app/components/database/views/modal/confirm-modal.html?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: true,
            templateUrl:teamplate,
            controller: 'ConfirmModalController',
            size: 'lg',
            resolve: {
                name: function() {
                    return name;
                }
            }
        });

        modalInstance.result.then(function (data) {
            if(data){
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
        }, function () {
        });        
    }
}]);

guideConfigurator.controller('ConfigMaterialController', ['$scope', '$modalInstance', 'GuideConfiguratorService','CmsService', '$timeout', '$filter', 'material', function ($scope, $modalInstance, GuideConfiguratorService, CmsService, $timeout, $filter, material) {

    $scope.config = angular.copy(material);

    if($scope.config.content.engrave_mark_recommended_power == 0 ){
        console.log('123');
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
}]).controller('PlatformModelController', ['$scope', 'listPlatForm', '$modalInstance', function ($scope, listPlatForm, $modalInstance) {

    $scope.guideConfig = {};

    $scope.loadData = function() {
        $scope.listPlatForm = angular.copy(listPlatForm);
    }

    $scope.choosePlatform = function(validate, platformId) {
        $scope.submitted = false;
        if (validate) {
            $scope.submitted = true;
            return true;
        }

        for(var key in listPlatForm) {
            if (parseInt(listPlatForm[key]['id']) == parseInt(platformId)) {
                $modalInstance.close(listPlatForm[key]);
                return;
            }
        }
    }

    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
    }
    
}]).controller('ConfirmModalController', ['$scope', 'name', '$modalInstance', function ($scope, name, $modalInstance) {

    $scope.name = name;

    $scope.confirm = function() {
        $modalInstance.close(true);
    }

    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
    }
    
}]).controller('EmailController', ['$scope', 'dataInput', '$modalInstance', function ($scope, dataInput, $modalInstance) {

    $scope.dataInput = dataInput;

    $scope.submitEmail = function(){
        $scope.messageError = $scope.checkEmail($scope.dataInput.email);
            if (angular.isDefined($scope.messageError)) return;
        $modalInstance.close($scope.dataInput);
    };

    $scope.checkEmail = function(email) {

        var regex_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i;
        if(regex_email.test(email) == false && angular.isDefined(email) && email !== '') {
            $scope.messageError = "Email Invalid"; 
            return $scope.messageError;
        } 
    }


    $scope.cancelEmail = function(){
        $modalInstance.dismiss('cancel');
    }
    
}]);
