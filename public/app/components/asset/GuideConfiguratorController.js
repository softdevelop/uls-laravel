var guideConfigurator = angular.module('databaseManager');

guideConfigurator.controller('GuideConfiguratorController', ['$scope', '$modal', 'GuideConfiguratorService', 'ConfiguratorService', '$timeout', '$filter', 
    function ($scope, $modal, GuideConfiguratorService, ConfiguratorService, $timeout, $filter) {
    angular.element('#guide-container').removeClass('hidden');
    angular.element('.back-to-top').remove();
    $scope.data = [];
    $scope.tmpMarterials = [];
    $scope.listMarterialOldValue = [];
    $scope.dataInput = [];

    $scope.detailConfiguaration = {};

    $scope.listAnswerMapData = angular.copy(window.listAnswer);

    $scope.currentStep = 1;

    $scope.report = false;

    $scope.reportData = false;

    $scope.listP2MaxC = [];
    $scope.listP2GMinC = [];
    $scope.listDLSC = [];
    $scope.listMLCC = [];
    $scope.listMaxT2 = [];

    $scope.currentPlatForm = {};
    $scope.maxHeight = null;
    $scope.maxWidth = null;
    $scope.maxDepth = null;
    $scope.requiresFiber = false;
    $scope.requiresCO2 = false;

    if(Object.keys(angular.extend({}, window.dataInput)).length > 0) {

        $scope.dataInput = angular.copy(window.dataInput); 
        $scope.data = $scope.dataInput.materials;

        $scope.tmpMarterials = $scope.dataInput.materials;
        $scope.currentStep = window.dataInput.last_step_completed;

        if(angular.isDefined(window.dataInput.materials)) {
            $scope.listMarterialOldValue = window.dataInput.materials;
        }

        if (typeof window.dataInput != 'undefined') {
            if (Object.keys(window.dataInput).length > 0) {
                for(var i = 0; i < window.dataInput.last_step_completed - 1; i++) {
                    $("#wizard").steps("next");
                }
            }
        }

        $scope.issetUrl = true;

        setStep();

    } else {

        $scope.dataInput = {};
       
    }

    if (angular.isUndefined($scope.dataInput.answerQuestions)) {
        $scope.dataInput.answerQuestions = {};
    }


    if(window.email) {

        $scope.dataInput.email = window.email;
    }
    
    function getId() {
        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }

    /**
     * 
     * get modal message 
     *
     * @author Minhthan
     * 
     * @return {[type]} [description]
     */
    function getModalInputEmail() {

        var teamplate = '/app/components/database/views/email.html?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl:  teamplate,
            controller: 'ModalInputEmail',
            windowClass: 'fix-modal',
            size: 'lg',
            resolve: {
                dataInput: function() {
                    return $scope.dataInput;
                }
            }
        });
        modalInstance.result.then(function (data) {

            
        }, function (data) {
            
        });   
    }
    
    var showModalInputMail = false;

    $(window).bind("beforeunload", function(event) { 
        
        if((angular.isUndefined($scope.dataInput.email) || !$scope.dataInput.email) && !showModalInputMail) {
            showModalInputMail = true;
            getModalInputEmail();
            return 'do you want input email ?';
        }
    });


    $scope.initTree = function() {
        $timeout(function(){

            $("#tree").fancytree({
                extensions: ["glyph", 'filter'],
                source: $scope.databaseTree,
                checkbox:true,
                autoScroll: true,
                filter: {
                    autoApply: true,  // Re-apply last filter if lazy data is loaded
                    counter: true,  // Show a badge with number of matching child nodes near parent icons
                    fuzzy: false,  // Match single characters in order, e.g. 'fb' will match 'FooBar'
                    hideExpandedCounter: true,  // Hide counter badge, when parent is expanded
                    highlight: true,  // Highlight matches by wrapping inside <mark> tags
                    mode: "hide"  // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
                },
                activate: function (event, data){
                  console.log(data, 'data');
                    data.node.setExpanded(true);
                    if(!data.node.isFolder()) {
                        if(data.node.isSelected()) {
                            data.node.setSelected(false);
                        } else {
                            data.node.setSelected(true);                            
                        }
                    } else {

                        if (data.node.data.type == 'other') {

                            $scope.newConfigMaterialOther = {
                                name: '',
                                id: getId(),
                                type: 'other',
                                'content': {
                                    'unit': 'inches',
                                    'cut': '',
                                    'min_thickness': '',
                                    'max_thickness': '',
                                    'engraving': '',
                                    'marking': '',
                                    'other': '',
                                    'width': '',
                                    'height': '',
                                    'depth': '',
                                }
                            };

                            $scope.getModalConfigMaterialOther($scope.newConfigMaterialOther);
                          data.node.setActive(false);
                        }
                    }
                },
                select : function(event, data) {
                    var check = -1;
                    if(angular.isDefined($scope.dataInput.materials)) {
                        check = $scope.dataInput.materials.map(function(e) { return e.id; }).indexOf(data.node.data.id);                        
                    }

                    if (angular.isUndefined($scope.issetUrl) || $scope.issetUrl == false) {
                        if(check == -1 && data.node.isSelected()) {
                            data.node.data.categoryId = data.node.parent.data.id;
                            data.node.data.categoryName = data.node.parent.title;
                            data.node.data.content.cut = false;
                            data.node.data.content.min_thickness = null;
                            data.node.data.content.max_thickness = null;
                            $scope.getModalConfigMaterial(data.node.data, 'active');
                        } else if(check != -1){
                            $scope.tmpMarterials.splice(check,1);
                            $scope.listMarterialOldValue.splice(data.node.data.content.id);
                            $scope.dataInput.materials = $scope.tmpMarterials;
                            $timeout(function(){
                                $scope.$apply();    
                            });
                        }
                    }
                }
            });

            $scope.getTree = $('#tree').fancytree('getTree');

            angular.forEach($scope.dataInput.materials, function(value, key){
                if(angular.isDefined(value.categoryId)) {
                    var node = $scope.getTree.getNodeByKey(value.categoryId.toString());
                    node.setExpanded(true);    
                    var nodeSelected = $scope.getTree.getNodeByKey(value.id.toString());
                    nodeSelected.setSelected(true);
                }
            });
            var checkLastStep = $scope
            if (angular.isDefined($scope.dataInput.last_step_completed)) {
                $('.first').next().removeClass('disabled');
                $('.first').next().addClass('done');
                button = $("#guide-container").find('ul>li>a[href="#next-disabled"]');
                button.attr("href", '#next');
                button.parent().removeClass();
            }

            $scope.issetUrl = false;
        });
    }

    $scope.filterTree = function() {
        if($scope.treeFilter != '') {
            var resultFilter = $scope.getNodeFilter($scope.databaseTree,[]);
            $scope.getTree.reload(resultFilter);
        } else {
            $scope.getTree.reload();
        }

    }

    $scope.getNodeFilter = function(nodes, arr = []) {
        angular.forEach(nodes, function(value,key){
            if((!value.folder || value.type == 'other') && value.title.toLowerCase().indexOf($scope.treeFilter.toLowerCase()) != -1) {
                var check = $scope.data.map(function(e) { return e.id; }).indexOf(value.id);
                if(check != -1) {
                    value.selected = true;
                }
                arr.push(value);
            }
            if(angular.isDefined(value.children) && value.children.length) {
                $scope.getNodeFilter(value.children, arr);
            }
        });
        return arr;
    }

    $scope.getModalConfigMaterialOther = function(material, type){
        var teamplate = '/app/components/database/views/config-material-other.html?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl:  teamplate,
            controller: 'ModalConfigMaterialOther',
            windowClass: 'fix-modal',
            size: 'lg',
            resolve: {
                material: function() {
                    return material;
                }
            }
            
        });

        modalInstance.result.then(function (data) {

            button = $("#guide-container").find('ul>li>a[href="#next-disabled"]');
            button.attr("href", '#next');
            button.parent().removeClass();

            $('.first').next().removeClass('disabled');
            $('.first').next().addClass('done');

            if(type == 'click') {
                angular.forEach($scope.dataInput.materials, function(value, key) {            
                    if(value.id == material.id) {
                        $scope.dataInput.materials[key] = data;
                        $scope.caculator(material.content, $scope.dataInput.materials[key]);
                    }
                });
            } else {
                $scope.tmpMarterials.push(data);
                $scope.dataInput.materials = $scope.tmpMarterials;                
            }
            
        }, function () {
        });
    };


    $scope.getModalConfigMaterial = function(material, type){

        var teamplate = '/app/components/database/views/config-material.html?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl:  teamplate,
            controller: 'ModalConfigMaterial',
            windowClass: 'fix-modal',
            size: 'lg',
            resolve: {
                material: function() {
                    return material;
                },
                type : function() {
                    return type;
                }
            }
            
        });

        modalInstance.result.then(function (data) {

            button = $("#guide-container").find('ul>li>a[href="#next-disabled"]');
            button.attr("href", '#next');
            button.parent().removeClass();

            $('.first').next().removeClass('disabled');
            $('.first').next().addClass('done');

            if(type == 'active') {
                $scope.tmpMarterials.push(data);
                $scope.dataInput.materials = $scope.tmpMarterials;
                $scope.listMarterialOldValue[data.content.id] = data.content;

            } else {
                angular.forEach($scope.dataInput.materials, function(value, key) {
            
                    if(value.id == material.id) {
                        $scope.dataInput.materials[key] = data;
                        $scope.caculator(material.content, $scope.dataInput.materials[key]);
                    }
                });
            }

        }, function (data) {
            var nodeEdit = $scope.getTree.getNodeByKey(String(material.id));

            if(angular.isDefined(nodeEdit) && type == 'active') {
                nodeEdit.setSelected(false);
                nodeEdit.setActive(false);
            }
        });
    };

    /**
     * 
     * get modal message 
     *
     * @author Minhthan
     * 
     * @return {[type]} [description]
     */
    $scope.getModalMessage = function() {

        var teamplate = '/app/components/database/views/message.html?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl:  teamplate,
            controller: 'ModalMessage',
            windowClass: 'fix-modal',
            size: 'lg',
            resolve: {
                materials: function() {

                    return $scope.dataInput.materials;
                },
            }
        });

        modalInstance.result.then(function (data) {
            $scope.changeStep('click');
        }, function (data) {
            $scope.changeStep('click');
        });

    }
    
    $('#guide-container').find('ul>li>a[href="#next"]').click(function() {

        if($('#guide-container').find('ul>li>a[href="#next-disabled"]').length == 0) {

            $scope.changeStep('click');

            /**
             * If in step 1 and all materials has type is other
             * @author Thanh Tuan <tuan@httsolution.com>
             * @param  {Int} $scope.currentStep Current step
             * @return {Void}                    
             */
            if ($scope.currentStep == 3) {

                $scope.allOther = true;

                angular.forEach($scope.dataInput.materials, function (value, key) {
                    if (!angular.isDefined(value.type) || value.type != 'other') {
                        $scope.allOther = false;
                        return;
                    }
                });

                if ($scope.allOther) {
                    $scope.report = true;
                }
            }
        }
    });


    $('#guide-container').find('ul>li>a[href="#wizard-h-0"]').click(function() {

            $scope.currentStep = 1;

            if($scope.tmpMarterials.length > 0) {

                button = $('#guide-container').find('ul>li>a[href="#next-disabled"]');
                button.attr("href", '#next');
                button.parent().removeClass(); 
                
            }

    });

    $('#guide-container').find('ul>li>a[href="#wizard-h-1"]').click(function() {

        element = $('#guide-container').find('ul>li>a[href="#wizard-h-1"]');

        if(!element.parent().hasClass('disabled')) {

            $scope.currentStep = 2;
            $scope.changeStep('tab');
        } 
    });

    $('#guide-container').find('ul>li>a[href="#wizard-h-2"]').click(function() {
        
        if(!$('.last').hasClass('disabled')) {
            $scope.currentStep = 3;
            $scope.changeStep('tab');
        } 
        setStep();

    });

    $timeout(function() {

        if ($scope.currentStep == 1) {

            button = $("#guide-container").find('ul>li>a[href="#next"]');

            button.attr("href", '#next-disabled');
            button.parent().addClass("disabled");
        }        
    })

    $scope.backToStep1 = function() {

        $scope.currentStep = 1;
        $scope.report = false;
        $("#wizard").steps('previous');
        $("#wizard").steps('previous');
    }
    
    
    function step3() {

        var $mySticky = $('.my-sticky-element');

        //store the initial position of the element
        var TopMySticky = $mySticky.offset().top - parseFloat($mySticky.css('margin-top').replace(/auto/, 0));


        var footTop = $('footer').offset().top - parseFloat($('footer').css('marginTop').replace(/auto/, 0));


        var HeightBoxSeLected = $('.my-sticky-element').outerHeight();


        var MaxHeightBoxSeLected = HeightBoxSeLected + 200;



        var maxY = footTop - MaxHeightBoxSeLected;



        var HeightBoxListiTem = $('.wrap-step-tree .set-height').outerHeight();


        if (HeightBoxListiTem > MaxHeightBoxSeLected){

            $(window).scroll(function (event){

                var y = $(this).scrollTop();

                if (y >= TopMySticky) {
                    if (y < maxY){
                        $mySticky.addClass('stuck');

                    }
                    else {
                        $mySticky.removeClass('stuck');
                    }

                }else {
                    $mySticky.removeClass('stuck');
                }
            });
        }
    
    }
    var checkExitAllOtherMAT = function(fn) {

        var allOther = true;

        for(var i in $scope.dataInput.materials) {

            if(angular.isUndefined($scope.dataInput.materials['type'])) {

                allOther = false;
                break
            }
        }

        fn.call(allOther);       
    }

      
    function setStep() {

        if ($scope.currentStep == 3) {

            $scope.isShowDetail = false;

            GuideConfiguratorService.getPlatform($scope.dataInput).then(function(data) {

                if (data['status'] == 0) {
                    $scope.report = true;
                } else {
                    $scope.currentPlatForm = data['result'];
                    $scope.contentDetail = data['arrayValueToShowDetail'];
                    $scope.dataInput.platform = $scope.currentPlatForm.result;

                    $scope.dataInput.platform = data['result'].result;

                    $scope.listMaterialMapData = data['listMaterialMapData'];

                    $scope.laserRequirements = $scope.contentDetail.laserRequirements;
                }

                

                if(angular.isUndefined($scope.dataInput.platform) || $scope.dataInput.platform.length == 0) {
                    
                    $timeout(function(){
                        $scope.finishStep();
                    });
                    
                }
                selectedAccessoriesStateIsS();
                $timeout(function(){
                    step3();
                });
            });
            
        }

        $scope.dataInput.step = $scope.currentStep;
    }

    $scope.changeStep = function(type) {

        $scope.reportData = false;
        $scope.dataInput.step = angular.copy($scope.currentStep);

        if(angular.isDefined(type) && type == 'next') {

            $scope.currentStep ++;
        }
        
        if ($scope.currentStep == 2) {

            invalidAnswerQuestion = showAndHideButtonNext();

            if(invalidAnswerQuestion) {

                $('.last').addClass('disabled');
                $('.last').removeClass('done');
                
                button = $("#guide-container").find('ul>li>a[href="#next"]');
                button.attr("href", '#next-disabled');
                button.parent().addClass("disabled"); 

            } else {
                button = $('#guide-container').find('ul>li>a[href="#next-disabled"]');
                button.attr("href", '#next');
                button.parent().removeClass();       
            }

            checkExitAllOtherMAT(function(allOther) {

                if(allOther) {

                    getModalMessage();
                }
            });

        }

        // ConfiguratorService.create($scope.dataInput).then(function(data){
        //     if (angular.isDefined(data.item) && angular.isDefined(data.item._id)) {
        //         $scope.dataInput._id = data.item._id;
        //         $scope.dataInput.created_at = data.item.created_at;

        //         if(data.item.url) {
        //             $scope.dataInput.url = data.item.url;
        //         }
                
        //     }                  
        //     setStep();

        // });            

    }

    /**
     * [saveDataStep description]
     * @param  {[type]} dataRecommanded [description]
     * @return {[type]}                 [description]
     */
    $scope.saveDataStep = function(dataRecommanded, finish) {
        ConfiguratorService.create(dataRecommanded).then(function(data){
            if (angular.isDefined(data.item) && angular.isDefined(data.item._id)) {
                $scope.dataInput._id = data.item._id;
                $scope.dataInput.created_at = data.item.created_at;

                if(data.item.url) {
                    $scope.dataInput.url = data.item.url;
                }
                
            }                  
            setStep();

        }); 
    }

    $scope.changeAnserQuestion = function() {

        invalidAnswerQuestion = showAndHideButtonNext();

        $timeout(function() {

            if(!invalidAnswerQuestion) {

                button = $('#guide-container').find('ul>li>a[href="#next-disabled"]');
                button.attr("href", '#next');
                button.parent().removeClass();

                $('.last').removeClass('disabled');
                $('.last').addClass('done');

            } else {
                
                button = $("#guide-container").find('ul>li>a[href="#next"]');
                button.attr("href", '#next-disabled');
                button.parent().addClass("disabled");

                $('.last').addClass('disabled');
                $('.last').removeClass('done');
            }
        })
    }
    /**
     * set default anser question
     *
     * @author Minh than
     */
    var setDefaultAnserQuestion = function () {

        $scope.dataInput.answerQuestions.question_first = {};
        $scope.dataInput.answerQuestions.question_first.visual = false;
        $scope.dataInput.answerQuestions.question_first.dimensional = false;

        $scope.dataInput.answerQuestions.question_second = false;
        $scope.dataInput.answerQuestions.question_third = false;

    }

    setDefaultAnserQuestion();

    var showAndHideButtonNext = function () {

        var invalidAnswerQuestion = false; // default invaild

        // check user has chosse question option 1
        if(!$scope.dataInput.answerQuestions.question_first.visual && 
            !$scope.dataInput.answerQuestions.question_first.dimensional) {
            
            invalidAnswerQuestion = true;
        }
        // check user has chosse question option 2
        if(!$scope.dataInput.answerQuestions.question_second) {
            
            invalidAnswerQuestion = true;
        }
        // check user has chosse question option 3
        if(!$scope.dataInput.answerQuestions.question_third) {
            
            invalidAnswerQuestion = true;

        } 

        return invalidAnswerQuestion;     
    }

    var selectedAccessoriesStateIsS = function () {

        // angular.forEach($scope.currentPlatForm.accessories, function(value, key) {
        //     angular.forEach(value, function(accessory, keyAcessory) {
        //         $scope.addAccessories(accessory.category_id, accessory);
        //     });
        // });

        for(var key in $scope.currentPlatForm.categories) {

            for(var i in $scope.currentPlatForm.accessories[key]) {

                if($scope.currentPlatForm.accessories[key][i]['pivot']['state'] == 'S') {

                    $scope.currentPlatForm.accessories[key][i]['selected'] = true;
                    $scope.addAccessories(key, $scope.currentPlatForm.accessories[key][i]);
                }
            }            
        }

    }

    /**
     * [caculatorMaterialValueAndGetListPlatform description]
     * @return {[type]} [description]
     */
    function caculatorMaterialValueAndGetListPlatform(callback) {

        if (angular.isDefined($scope.tmpMarterials) && Object.keys(angular.extend({}, $scope.tmpMarterials)).length) {
            // alert(1);
            passingEachListMarterial($scope.tmpMarterials, function(data) {

                $('#page-loading').css('display', 'block');

                if ($scope.listP2MaxC.length == 0) return;

                var maxP2GMaxCValue = Math.max.apply(null, $scope.listP2MaxC);

                $scope.dataInput['maxP2gMaxc'] = maxP2GMaxCValue;

                $scope.dataInput['isCutting']  = false;
              
                var indexP2MaxC = $scope.listP2MaxC.indexOf(maxP2GMaxCValue);
    

                if (angular.isDefined($scope.tmpMarterials[indexP2MaxC])) {

                    if($scope.tmpMarterials[indexP2MaxC].content.cut == true) {

                        $scope.dataInput['isCutting']  = true;
                    }
                    
                    $scope.dataInput['nameMaterial'] = $scope.tmpMarterials[indexP2MaxC].name;
                  
                }
              
              $scope.dataInput['maxT2'] = $scope.listMaxT2[indexP2MaxC];
              
                getNearestALPWithMaxP2GMaxC(maxP2GMaxCValue);

                if(angular.isDefined($scope.ALP)) {

                    var dataValue = (angular.isDefined($scope.ALP))?{'alp':$scope.ALP}:{'alp':null};

                    if (angular.isDefined($scope.dataInput.answerQuestions.question_third) && $scope.dataInput.answerQuestions.question_third == 'productivity') {

                        dataValue['productivity'] = true;

                    } else if(angular.isDefined($scope.dataInput.answerQuestions.question_third)) {

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

                            $scope.dataInput['selected_platformId'] = result.result.id;
                            $scope.dataInput.platform = result.result;

                        }
                        if(angular.isUndefined($scope.dataInput.platform) || $scope.dataInput.platform.length == 0) {
                            
                            $timeout(function(){
                                $scope.finishStep();
                            });
                            
                        }
                        showDetailGuidedConfig();
                        callback.call();
                        // showModelChoosePlastform(result.result);
                    })  
                } else {

                    $timeout(function(){
                        $scope.finishStep();
                   });
                }

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
        $scope.maxHeight = null;
        $scope.maxWidth = null;
        $scope.maxDepth = null;
        $scope.requiresFiber = false;
        $scope.requiresCO2 = false;

        for (var key in $scope.dataInput.materials) {

            if ($scope.dataInput.materials[key].type != 'other')  {
                  var newData = listMarterial[key];
                  var oldData = $scope.listMarterialOldValue[newData.content.id];

                  caculator(oldData, newData);

                  $scope.dataInput.materials[key]['content']['suggested_power'] = angular.copy($scope.suggestedPower);

                  if (newData.content.laser_type == 'CO2') {
                      $scope.requiresCO2 = true;
                  }

                  if (newData.content.laser_type == 'Fiber') {
                      $scope.requiresFiber = true;
                  }

                  if(angular.isDefined(newData.content.width) && angular.isDefined(newData.content.depth) && (newData.content.depth > newData.content.width)){
                      var tmp = newData.content.depth;
                      newData.content.depth = newData.content.width;
                      newData.content.width = tmp;
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
    function caculator(oldData, newData) {

        $scope.P2Min = 0;
        $scope.P2Max = 0;

        var T1 = parseFloat(oldData.default_min_thickness);
        var T3 = parseFloat(oldData.default_max_thickness);
        var P1 = parseFloat(oldData.power_at_min_thickness);
        var P3 = parseFloat(oldData.power_at_max_thickness);
        
        var minT2 = 0;
        var maxT2 = 0;
      
      

        if (newData.content.cut == true && angular.isDefined(newData.content.min_thickness)
            && newData.content.min_thickness != null && angular.isDefined(newData.content.max_thickness)
            && newData.content.max_thickness != null) {
            minT2 =  parseFloat(newData.content.min_thickness);
            maxT2 =  parseFloat(newData.content.max_thickness);
        }
      
      $scope.listMaxT2.push(maxT2);

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

        fomatP2MaxWithAlp($scope.P2Max);
    }

    var fomatP2MaxWithAlp = function(P2Max, fn) {

        $scope.suggestedPower = P2Max;
        
        for(var i in window.listALP) {

            if(window.listALP[i] > P2Max) {

                P2Max = listALP[i];
                $scope.suggestedPower = P2Max;

                break;
            }
        }

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

        return $scope.minMPRC;
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
      
      //P2GMinC = getNearestALPWithMaxP2GMaxC(P2GMinC);
      //P2GMaxC = getNearestALPWithMaxP2GMaxC(P2GMaxC);

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
      console.log(maxValue, 'maxValue');
      console.log(parseFloat(value), 'dfdff');

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
      console.log($scope.ALP);
    }

    $scope.removeMaterial = function(id, name) {
        var conf = false;

        var teamplate = '/app/components/database/views/modal/confirm-modal.html?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: true,
            templateUrl:teamplate,
            controller: 'ConfirmModalController',
            windowClass: 'fix-modal',
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
                        var tree = $('#tree').fancytree('getTree');
                        var node = tree.getNodeByKey(String(id));
                        node.setSelected(false);
                        node.setActive(false);
                    }
                });  

                angular.forEach($scope.tmpMarterials, function (value, key) {
                    if (value.id == id) {
                        $scope.tmpMarterials.splice(key, 1);
                    }
                });
            }

            if($scope.tmpMarterials.length == 0) {
                button = $('#guide-container').find('ul>li>a[href="#next"]');
                button.attr("href", '#next-disabled');
                button.parent().addClass("disabled");

                $('.first').next().addClass('disabled');
                $('.first').next().removeClass('done');

                if($('.last').hasClass('done')) {
                    $('.last').addClass('disabled');
                    $('.last').removeClass('done');                    
                }          
            }
        }, function () {
        });        
    }

    var descriptionExits = [];


    var tmpNameSelected = [];
    $scope.addAccessories = function(key,value) {
        


        if (angular.isUndefined($scope.dataInput.selectedAccessories)) {
            $scope.dataInput.selectedAccessories = [];
        }

        if ($scope.dataInput.selectedAccessories.indexOf(value) !== -1) return;
        if (tmpNameSelected.indexOf(value.name) !== -1) return;



        value.type = 'accessory';

        $scope.dataInput.selectedAccessories.push(value);

        // console.log(tmpNameSelected, 'tmpNameSelected123');

        if(value.dependencies == 'AIR ASSIST' && tmpNameSelected.indexOf(value.dependencies) === -1) {
            $scope.dataInput.selectedAccessories.push({'category_id' : value.category_id, 'name' : value.dependencies , 'dependencies': value.dependencies, 'type':'dependency'});
        }
        
        for(var i in $scope.currentPlatForm.accessories[key]) {

            if($scope.currentPlatForm.accessories[key][i]['id'] == value['id']) {
                $scope.currentPlatForm.accessories[key][i]['selected'] = true;
            }
        }

        for(var key in $scope.dataInput.selectedAccessories) {
            tmpNameSelected.push($scope.dataInput.selectedAccessories[key].name);
        }
       
        // console.log(tmpNameSelected, 'tmpNameSelected');


        
    }
  


   $scope.deleteAccessories = function(value) {

        if (value.type === 'dependency') return $scope.deleteDepency(value);
        

        var key = value.category_id;
        var id = value.id;
        console.log(value.type,'value.type', key, id);
        for(var i in $scope.currentPlatForm.accessories[key]) {

            if($scope.currentPlatForm.accessories[key][i]['id'] == id) {

                $scope.currentPlatForm.accessories[key][i]['selected'] = false;
            }
        }    
        for (var i in $scope.dataInput.selectedAccessories) {
            if ($scope.dataInput.selectedAccessories[i].id == id) {
                $scope.dataInput.selectedAccessories.splice(i, 1);
                break;
            }
        } 
        tmpNameSelected = [];
        
        for(var key in $scope.dataInput.selectedAccessories) {
            tmpNameSelected.push($scope.dataInput.selectedAccessories[key].name);
        }

 
    }

    $scope.deleteDepency = function(value) {

        var key = value.category_id;
        var dependencies = value.dependencies;

        for(var i in $scope.currentPlatForm.accessories[key]) {

            if($scope.currentPlatForm.accessories[key][i]['dependencies'] == dependencies) {
                $scope.currentPlatForm.accessories[key][i]['selected'] = false;
            }
        } 
        for (var i = $scope.dataInput.selectedAccessories.length - 1; i >= 0; i--) {

            if($scope.dataInput.selectedAccessories[i].dependencies == dependencies) {

                $scope.dataInput.selectedAccessories.splice(i, 1);

            }
        }
        tmpNameSelected = [];
        for(var key in $scope.dataInput.selectedAccessories) {
            tmpNameSelected.push($scope.dataInput.selectedAccessories[key].name);
        }
    }

    $scope.addDataInputForEachStep = function(callback)
    {
        ConfiguratorService.create($scope.dataInput).then(function(data){

            if(data.status) {

                if (angular.isDefined(data.item)) {
                    $scope.dataInput._id = data.item;

                    callback.call();

                }
            }

        });
    }

    $scope.closeSelectedAccessory = function()
    {
        $('.mfp-close').trigger('click');
    }

    $scope.finishStep = function() {
        $scope.dataInput['reported'] = true;
        $scope.changeStep('click');
        $scope.saveDataStep($scope.dataInput, true);
        $scope.report = true;
    }

    $scope.emailReportToMe = function() {
        console.log($scope.dataInput,'dataInput');
        if(angular.isDefined($scope.dataInput.email) && $scope.dataInput.email !='' && angular.isDefined($scope.dataInput.url) && $scope.dataInput.url != '') {
            GuideConfiguratorService.emailReportToMe($scope.dataInput).then(function(result) {
              console.log(result,'result');
                if(result['status']){
                    alert('Send Email Success!');
                } else {
                    alert('Do not have email to send!');
                }
            });
        } else {
            alert('Do not have email to send!');
        }
    }

    // $('#guide-container').find('ul>li>a[href="#finish"]').click(function() {

    //     $scope.finishStep();
    // });

}]);
guideConfigurator.controller('ModalConfigMaterial', ['$scope', '$modalInstance', 'material', 'type', function ($scope, $modalInstance, material, type) {

    $scope.config = angular.copy(material);
    $scope.type = type;
    console.log($scope.type,'$scope.type');
    
    $scope.scrollToError = function(){
        $('.modal').animate({
                scrollTop: 0
        }, 500);
    }
    
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
  
    $scope.submit = function (validate) {
        
        $scope.submitted = true;
        $scope.laserProcessesRequired = false;
        $scope.minMaxThicknessInvalid = false;
        $scope.maxThickInvalid = false;

        if((angular.isUndefined($scope.config.content.otherSelect) || $scope.config.content.otherSelect == false) 
            && (angular.isUndefined($scope.config.content.cut) || $scope.config.content.cut == false)
            && (angular.isUndefined($scope.config.content.engraving) || $scope.config.content.engraving == false) 
            && (angular.isUndefined($scope.config.content.marking) || $scope.config.content.marking == false)) {

            $scope.laserProcessesRequired = true;
        }

        var minThick = $scope.config.content.min_thickness;
        var maxThick = $scope.config.content.max_thickness;
        var defaultMin = 0;
        var defaultMax = $scope.config.content.default_max_thickness;

        if($scope.config.content.cut && (minThick < defaultMin || maxThick > defaultMax || minThick > maxThick || angular.isUndefined(minThick) || angular.isUndefined(maxThick))) {
            $scope.minMaxThicknessInvalid = true;
        }
        
        if(maxThick != null && maxThick < $scope.config.content.default_min_thickness) {
            $scope.maxThickInvalid = true;
        }

        if((angular.isDefined($scope.formData.minThick) && $scope.formData.minThick.$error.required) 
            || (angular.isDefined($scope.formData.maxThick) && ($scope.formData.maxThick.$error.required || $scope.formData.maxThick.$error.min))
            || (angular.isDefined($scope.formData.other) && $scope.formData.other.$error.required)
            || $scope.laserProcessesRequired
            || $scope.minMaxThicknessInvalid
            || $scope.maxThickInvalid) {
            
            $scope.scrollToError();
            return;
        }

        if(validate){
            return;
        }

        $modalInstance.close($scope.config);

    };


    var validateForm = function (fn) {

        if($scope.config.content.otherSelect) {

            if(!$scope.config.content.other) {

                $scope.requiredOther = true;
               $scope.scrollToError();
            }
        } else {
            $scope.requiredOther = false;
        }

        if($scope.config.content.otherSelect || $scope.config.content.engraving || $scope.config.content.marking) {

            if(!$scope.config.content.width) {

                $scope.requiredW = true;
            }
            if(!$scope.config.content.height) {

                $scope.requiredH = true;
            }
            if(!$scope.config.content.depth) {
                $scope.requiredD = true;
            }

        } else {

            $scope.requiredW = false;
            $scope.requiredH = false;
            $scope.requiredD = false;
        }
        fn.call();
    }

    $scope.convertUnit = function() {
        //1 inch = 25.4 millimeters
        console.log($scope.config.content.default_min_thickness,'$scope.config.content.default_min_thickness');

        if($scope.config.content.unit == 'inches') {
            //convert value validate from milimeters to inches
            $scope.config.content.default_min_thickness = parseFloat(($scope.config.content.default_min_thickness / 25.4).toFixed(3));
            $scope.config.content.default_max_thickness = parseFloat(($scope.config.content.default_max_thickness / 25.4).toFixed(3));
            // $scope.config.min_height = $scope.config.min_height / 25.4;
            // $scope.config.min_width = $scope.config.min_width / 25.4;
            // $scope.config.min_depth = $scope.config.min_depth / 25.4;
            
        } else {
            //convert value validate from inches to milimeters
            $scope.config.content.default_min_thickness = parseFloat(($scope.config.content.default_min_thickness * 25.4).toFixed(3));
            $scope.config.content.default_max_thickness = parseFloat(($scope.config.content.default_max_thickness * 25.4).toFixed(3));
            // $scope.config.min_height = $scope.config.min_height * 25.4;
            // $scope.config.min_width = $scope.config.min_width * 25.4;
            // $scope.config.min_depth = $scope.config.min_depth * 25.4;
            // console.log(parseFloat($scope.config.content.default_min_thickness.toFixed(3)),'llll');
        }
    }

    $scope.changeNameMaterial = function(data) {
        if(data == '') {
            return "Name field is a required!";
        }
        $scope.config.name = data;
    }
}]);
guideConfigurator.controller('ModalConfigMaterialOther', ['$scope', '$modalInstance', 'material', function ($scope, $modalInstance, material) {

    $scope.config = angular.copy(material);

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
  
  
    $scope.scrollToError = function(){
        $('.modal').animate({
            scrollTop: 0
        }, 500);
    }

    $scope.submit = function (validate) {
        $scope.submitted = true;
        $scope.laserProcessesRequired = false;
        $scope.minMaxThicknessInvalid = false;

        if((angular.isUndefined($scope.config.content.otherSelect) || $scope.config.content.otherSelect == false) 
            && (angular.isUndefined($scope.config.content.cut) || $scope.config.content.cut == false)
            && (angular.isUndefined($scope.config.content.engraving) || $scope.config.content.engraving == false) 
            && (angular.isUndefined($scope.config.content.marking) || $scope.config.content.marking == false)) {

            $scope.laserProcessesRequired = true;
            // $scope.scrollToError();
        }

        if($scope.config.content.min_thickness > $scope.config.content.max_thickness) {
            $scope.minMaxThicknessInvalid = true;
        }

        if((angular.isDefined($scope.formData.name) && $scope.formData.name.$error.required) 
            || (angular.isDefined($scope.formData.minThick) && $scope.formData.minThick.$error.required) 
            || (angular.isDefined($scope.formData.maxThick) && $scope.formData.maxThick.$error.required)
            || (angular.isDefined($scope.formData.other) && $scope.formData.other.$error.required)
            || $scope.laserProcessesRequired || $scope.minMaxThicknessInvalid) {
            
            $scope.scrollToError();
        }

        if(validate || $scope.laserProcessesRequired || $scope.minMaxThicknessInvalid) {
            return;
        }

        $modalInstance.close($scope.config);
    };

    $scope.changeNameMaterial = function(data) {
        if(data == '') {
            return "Name field is a required!";
        }
        $scope.config.name = data;
    }
}]);
guideConfigurator.controller('ModalMessage', ['$scope', '$modalInstance', 'materials', function($scope, $modalInstance, materials) {
    
    $scope.materials = materials;

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
}]);
guideConfigurator.filter('htmlize', ['$sce', function($sce){
    return function(val) {
        return $sce.trustAsHtml(val);
    };
}]);

guideConfigurator.filter('clientDate', ['$filter',function($filter) {
    return function(input, typeFormat) {
        if (input == null) {
            return "";
        }
        if(input == '0000-00-00 00:00:00') {
            return '';
        }
        if (new Date(input) == 'Invalid Date') {
            while (String(input).indexOf('-') != -1) {
              input = input.replace('-','/');
            }
        }
        if (new Date(input) == 'Invalid Date') {
            return "";
        }

        input = new Date(input);
      
        input = new Date((parseInt(new Date(input).getTime())) - (parseInt(new Date().getTimezoneOffset())*60*1000));

        var _date = $filter('date')(new Date(String(input)), (angular.isUndefined(typeFormat))?'MM-dd-yyyy':typeFormat);
        return String(_date);
    };
}]);

guideConfigurator.controller('ConfirmModalController', ['$scope', 'name', '$modalInstance', function ($scope, name, $modalInstance) {

    $scope.name = name;

    $scope.confirm = function() {
        $modalInstance.close(true);
    }

    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
    }
    
}]);
guideConfigurator.controller('LaterConfiguratorController', ['$scope', '$modal', 'GuideConfiguratorService', 'ConfiguratorService', '$timeout', '$filter', 
    function ($scope, $modal, GuideConfiguratorService, ConfiguratorService, $timeout, $filter) {
    $scope.listPlatform = window.listPlatform;
    $scope.dataInput =[];
    $scope.currentPlatForm =[];
    $scope.isNext = false;
    $scope.platformSlect =[];
    $scope.laserAdd =[];
    $scope.laserSelect =[];
    $scope.isSelectYourPlatform = true;
     $('#guide-container').removeClass('hidden');
     $scope.changeSelectPlatform = function(id){
      angular.forEach( $scope.platformSlect, function(value, key) {
                if(key != id){
                  $scope.platformSlect[key] = false;
                } else {
                    if(value == true){
                        $scope.isNext =true;
                    }
                }
      });
    };
    $scope.nextStep3 = function(){
       var platformSelected;
        angular.forEach( $scope.platformSlect, function(value, key) {
            if(value == true){
                platformSelected = key;
            }
        });
      GuideConfiguratorService.getLaserOfPlatformLater(platformSelected).then(function(result) {
            $scope.platform    =  result. platform;
             console.log( $scope.platform,'sss');
           $scope.listNamesmMap    =  result. listNamesmMap;
            $scope.isSelectYourPlatform = false;
            $scope.isStep3 =true;
            $scope.currentPlatForm.accessories = result.accessories;
            $scope.currentPlatForm.categories = result.categories;
            $scope.currentPlatForm.categories = result.categories;
            selectedAccessoriesStateIsS();
      }); 
    };
    $scope.changeSelectLaser = function(id){
        var listlaserAdd = [];
        angular.forEach( $scope.laserAdd, function(value, key) {
            if(value.id != id){
                 listlaserAdd.push(value);
            }
        });
        $scope.laserAdd =listlaserAdd;
    };
    $scope.deleteLaser = function(id){
        var listlaserAdd = [];
        angular.forEach( $scope.laserAdd, function(value, key) {
            if(value.id != id ){
                  listlaserAdd.push(value);
            } else {
               $scope.laserSelect[id] = false;
            }
        });
        $scope.laserAdd =listlaserAdd;
    };
    $scope.addLaserFormAccessories = function(){
       $scope.laserAdd =[];
        var listlaserMap = [];
         angular.forEach( $scope.platform.listLaser, function(value, key) {
              angular.forEach( value, function(platform, key1) {
                    listlaserMap[platform.id] = platform
             });
       });
       angular.forEach( $scope.laserSelect, function(value, key) {
            if(value){
                 $scope.laserAdd.push(listlaserMap[key]);
            }
       });
    }
    $scope.clickDetailPlatform = function(platform){
        var teamplate = '/app/components/database/views/modal/detail-flatform.html?v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl:  teamplate,
            controller: 'ModalDetailPlatform',
            windowClass: 'fix-modal',
            size: 'lg',
            resolve: {
                platform: function() {

                    return platform;
                },
            }
        });
    }
    var tmpNameSelected = [];
    $scope.addAccessories = function(key,value) {
        


        if (angular.isUndefined($scope.dataInput.selectedAccessories)) {
            $scope.dataInput.selectedAccessories = [];
        }

        if ($scope.dataInput.selectedAccessories.indexOf(value) !== -1) return;
        if (tmpNameSelected.indexOf(value.name) !== -1) return;



        value.type = 'accessory';

        $scope.dataInput.selectedAccessories.push(value);

        // console.log(tmpNameSelected, 'tmpNameSelected123');

        if(value.dependencies == 'AIR ASSIST' && tmpNameSelected.indexOf(value.dependencies) === -1) {
            $scope.dataInput.selectedAccessories.push({'category_id' : value.category_id, 'name' : value.dependencies , 'dependencies': value.dependencies, 'type':'dependency'});
        }
        
        for(var i in $scope.currentPlatForm.accessories[key]) {

            if($scope.currentPlatForm.accessories[key][i]['id'] == value['id']) {
                $scope.currentPlatForm.accessories[key][i]['selected'] = true;
            }
        }

        for(var key in $scope.dataInput.selectedAccessories) {
            tmpNameSelected.push($scope.dataInput.selectedAccessories[key].name);
        }
       
        // console.log(tmpNameSelected, 'tmpNameSelected');


        
    }
    $scope.deleteAccessories = function(value) {

        if (value.type === 'dependency') return $scope.deleteDepency(value);
        

        var key = value.category_id;
        var id = value.id;
        console.log(value.type,'value.type', key, id);
        for(var i in $scope.currentPlatForm.accessories[key]) {

            if($scope.currentPlatForm.accessories[key][i]['id'] == id) {

                $scope.currentPlatForm.accessories[key][i]['selected'] = false;
            }
        }    
        for (var i in $scope.dataInput.selectedAccessories) {
            if ($scope.dataInput.selectedAccessories[i].id == id) {
                $scope.dataInput.selectedAccessories.splice(i, 1);
                break;
            }
        } 
        tmpNameSelected = [];
        
        for(var key in $scope.dataInput.selectedAccessories) {
            tmpNameSelected.push($scope.dataInput.selectedAccessories[key].name);
        }

 
    }
    $scope.deleteDepency = function(value) {

        var key = value.category_id;
        var dependencies = value.dependencies;

        for(var i in $scope.currentPlatForm.accessories[key]) {

            if($scope.currentPlatForm.accessories[key][i]['dependencies'] == dependencies) {
                $scope.currentPlatForm.accessories[key][i]['selected'] = false;
            }
        } 
        for (var i = $scope.dataInput.selectedAccessories.length - 1; i >= 0; i--) {

            if($scope.dataInput.selectedAccessories[i].dependencies == dependencies) {

                $scope.dataInput.selectedAccessories.splice(i, 1);

            }
        }
        tmpNameSelected = [];
        for(var key in $scope.dataInput.selectedAccessories) {
            tmpNameSelected.push($scope.dataInput.selectedAccessories[key].name);
        }
    }
    var selectedAccessoriesStateIsS = function () {

        // angular.forEach($scope.currentPlatForm.accessories, function(value, key) {
        //     angular.forEach(value, function(accessory, keyAcessory) {
        //         $scope.addAccessories(accessory.category_id, accessory);
        //     });
        // });

        for(var key in $scope.currentPlatForm.categories) {

            for(var i in $scope.currentPlatForm.accessories[key]) {

                if($scope.currentPlatForm.accessories[key][i]['pivot']['state'] == 'S') {

                    $scope.currentPlatForm.accessories[key][i]['selected'] = true;
                    $scope.addAccessories(key, $scope.currentPlatForm.accessories[key][i]);
                }
            }            
        }

    }


}]);
guideConfigurator.controller('ModalDetailPlatform', ['$scope', 'platform', '$modalInstance', function ($scope, platform, $modalInstance) {

    $scope.platform = platform;
    $scope.cancel = function(){
        $modalInstance.dismiss('close');
    }
    
}]);
guideConfigurator.controller('ModalInputEmail', ['$scope', '$modalInstance', 'ConfiguratorService', 'dataInput', 
    function($scope, $modalInstance, ConfiguratorService, dataInput) {

    $scope.dataInput = dataInput;
    $scope.validate = false;

    var checkEmail = function(email) {

        var regex_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i;

        if(regex_email.test(email) == false && angular.isDefined(email) && email !== '') {
    
            $scope.validate = true;
        }
        $scope.validate = false;
    }

    $scope.submit = function() {

        $scope.validate = false;

        checkEmail($scope.email);

        if($scope.validate) {
            return;
        }
        $scope.dataInput.email = $scope.email;
        ConfiguratorService.create($scope.dataInput).then(function(data) {

        }); 
    }

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
}]);