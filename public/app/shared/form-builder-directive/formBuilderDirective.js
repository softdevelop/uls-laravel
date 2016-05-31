'use strict';
(function($) {
    angular.module('formBuilderDirectiveApp', [])
    .directive('switchBootstrap', ['$parse','$timeout', function($parse, $timeout) {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function($scope, element, attrs, ngModelCtrl) {
                $scope.isDisable = false;
                if(angular.isDefined(window.isDisable)) {
                    $scope.isDisable = window.isDisable
                }
                /* Declare function */
                element.bootstrapSwitch({
                    // disabled:window.isDisable
                });
                if(!window.isDisable) {

                    element.on('switchChange.bootstrapSwitch', function(event, state) {
                        /* When user click to switch buttton then set new state for button switch */
                            // console.log(ngModelCtrl, 'state');
                        if (ngModelCtrl) {
                            $scope.$apply(function() {
                                ngModelCtrl.$setViewValue(state);
                            });
                        }
                    });
                }

                /* Set state for button with ng-model value */
                $scope.$watch(attrs.ngModel, function(newValue, oldValue) {


                    if (newValue) {
                        ngModelCtrl.$setViewValue(true);
                        element.bootstrapSwitch('state', true, true);
                    } else {
                        ngModelCtrl.$setViewValue(false);
                        element.bootstrapSwitch('state', false, true);
                    }
                    element.bootstrapSwitch('disabled',$scope.isDisable,$scope.isDisable);
                });
            }
        }
    }])

    .directive("limitTo", [function () {
        return {
            restrict: "A",
            link: function (scope, elem, attrs) {
                var limit = 999999999999999;
                if(attrs.type == 'number'){
                    limit = 7;
                }
                if(attrs.type == 'text'){
                    limit = 255;
                }
                elem.bind('keypress', function (e) {
                    if (elem[0].value.length >= limit) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
        }
    }])

    .directive('select2', ['$timeout', function ($timeout) { // directive select 2
        return {
            restrict: 'A',
            require: '?ngModel',
            replace: true,
            link: function($scope, element, attrs, ngModelCtrl) {

                // $scope.valueActived = 0;
                $scope.$watch(attrs.ngModel, function(newVal, oldVal){

                    if(angular.isDefined(ngModelCtrl.$modelValue) && ngModelCtrl.$modelValue == ngModelCtrl.$modelValue) {
                        $scope.valueActived = ngModelCtrl.$modelValue;
                        $timeout(function(){
                            $(element).select2().val($scope.valueActived).change();
                        });
                    } else {
                        $timeout(function(){
                            $(element).select2().val('').change();
                        });                        
                    }
                });

                function formatState (state)
                {
                    $(element).find('[value="? undefined:undefined ?"]').remove();

                    return $('<span>' + state.text + '</span>');
                };
                $timeout(function(){
                    $(element).select2({
                        templateResult: formatState
                    });

                    $(element).removeClass('form-control');
                    
                }, 500);
            }
        }
    }])

    .directive('multiSelect', ['$parse','$timeout',function($parse, $timeout) { // directive multi select 
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function($scope, element, attrs, ngModelCtrl) {
                var valueSelect = [];
                $scope.isDisable = false;
                if(angular.isDefined(window.isDisable)) {
                    $scope.isDisable = window.isDisable
                }
                $scope.$watch(attrs.ngModel, function(newValue, oldValue) {

                    // if(angular.isUndefined(valueSelect) || valueSelect == null || valueSelect.length == 0) { // value select empty or underfinde
                        // valueSelect = [];
                        // if (angular.isDefined(newValue)) { // check exits value in  model directive select

                        //     if(angular.isArray(newValue)) { // check value ng model is array

                        //         valueSelect = newValue;
                        //     }else {
                        //         valueSelect.push(newValue); // push value model to select value
                        //     }
                        // }
                    
                        $timeout(function() {
                            // if (angular.isArray(valueSelect)) {
                                // valueSelect =  _.uniq(valueSelect);
                                if (angular.isDefined(newValue) && (angular.isUndefined(oldValue) || valueSelect.length == 0)) {
                                    valueSelect = newValue;
                                    $(element).multiSelect('select', newValue); // select value in multi select
                                }
                                if($scope.isDisable) {

                                    $(element).multiSelect({disabledClass : 'disabled'});
                                }

                            // }
                        });
                    // }
                })
                // $(element)[0].selectedIndex = -1;
                if(!$scope.isDisable) {
                    $(element).multiSelect({});
                }
                
                    // afterInit: function(ms) {
                    // },
                    // afterSelect: function(values) { // callback function selected value multi
                    //     // check value select multi is undefined or empty 
                    //     if (angular.isUndefined(valueSelect) || valueSelect == null) {
                    //         valueSelect = []; // set default value select
                    //         valueSelect.push(values); // push values in directive select
                    //     } else {
                    //         valueSelect.push(values[0]); // push values first in directive select
                    //     }

                    //     $scope.$apply(function() {
                    //         valueSelect = _.uniq(valueSelect);
                    //         ngModelCtrl.$setViewValue(valueSelect); // set ng-model in directive select multi when chosse value
                    //     });
                    // },
                    // afterDeselect: function(values) { // callback function deselect value multi
                    //     valueSelect=_.uniq(valueSelect); // set Unique values in an array selected
                    //     for(var i in valueSelect) {
                    //         if (valueSelect[i] == values[0]) {
                    //             valueSelect.splice(i,1); // splice value user chosse
                    //         }
                    //     }
                    //     $scope.$apply(function() {

                    //         if (valueSelect.length == 0) {
                    //             valueSelect = null; // set defalt valueSelect
                    //         }

                    //         ngModelCtrl.$setViewValue(valueSelect); // set ng-model in directive when deselect value 
                    //     });
                    // }

                // });
            }
        }
    }])

    .directive('colorPicker', ['$parse','$compile', '$timeout', function($parse,$compile, $timeout) {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function($scope, element, attrs, ngModelCtrl) {

                $scope.isDisable = false;
                if(angular.isDefined(window.isDisable) &&  window.isDisable) {
                    $scope.isDisable = true;
                }                
                var modelGetter = $parse(attrs['ngModel']);
                modelGetter = modelGetter($scope);

                //check current value is valid (not none available and isDefined and not null)
                if(modelGetter == modelGetter && angular.isDefined(modelGetter) && modelGetter) {
                    setAndRender(ngModelCtrl, modelGetter);
                } else {
                    setAndRender(ngModelCtrl, '#f00');
                }

                $scope.$watch(attrs.ngModel, function(newValue, oldValue) {
                    if(angular.isDefined(ngModelCtrl.$modelValue)) {

                        setAndRender(ngModelCtrl, ngModelCtrl.$modelValue);
                    }
                })

                function setAndRender(ctr, curColor) {
                    ctr.$setViewValue(curColor);
                    ctr.$render();
                    renderColor(curColor);
                }

                function logic(inputValue, modelCtrl) {
                    var returnValue;
                    if (inputValue.length > 5) {
                        if (ngModelCtrl.$viewValue.indexOf('#') != -1) {
                            returnValue = String(inputValue).substring(1, 7);
                        } else {
                            returnValue = String(inputValue).substring(1, 6);
                        }
                    } else {
                        returnValue = inputValue;
                    }
                    return returnValue;
                }

                //apply plugin color picker
                function renderColor(color) {
                    // console.log('$scope.isDisable', $scope.isDisable);
                    $(element).spectrum({
                        color: color,
                        preferredFormat: "hex",
                        allowEmpty:true,
                        showInitial: true,
                        showInput: true,
                        disabled : $scope.isDisable,
                        change: function(color) {
                            setAndRender(ngModelCtrl, color.toHexString());
                            ngModelCtrl.$parsers.push(function(inputValue) {
                                ngModelCtrl.$viewValue = logic(inputValue, ngModelCtrl);
                                ngModelCtrl.$render();

                                if (ngModelCtrl.$viewValue.indexOf('#') == -1) {
                                    ngModelCtrl.$viewValue = '#'+ngModelCtrl.$viewValue;
                                }
                                return ngModelCtrl.$viewValue;
                            });
                        }
                    });
                }

            }
        }
    }])

    .directive('datepickerRowboat', ['$compile', function($compile) {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function($scope, element, attrs, ngModelCtrl) {
                // element.attr('datepicker-popup','');
                // $compile(element)($scope);
                element.bind('click', function() {
                    var param = attrs.isOpen;
                    $scope.$apply(function() {
                        if (angular.isUndefined($scope[param])) {
                            $scope[param] = true;
                        } else {
                            $scope[param] = !$scope[param];
                        }
                    });
                });
            }
        }
    }])

    .directive('uimaskRowboat', ['$compile', function($compile) {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function($scope, element, attrs, ngModelCtrl) {
                var mask = element.attr('ui-mask');
                element.mask(mask);
            }
        }
    }])
    .directive('redactor', ['$compile', '$timeout','$parse', function($compile, $timeout, $parse) {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function($scope, element, attrs, ngModel) {
                var hasChanged = false;
                if(angular.isDefined(window.isDisable) && window.isDisable) {
                    $timeout(function(){
                     $(element).redactor('button.disableAll');
                    
                    });
                }
                $scope.$watch(attrs.ngModel, function(newVal, oldVal){

                    if (hasChanged) {
                        hasChanged = false;
                        return;
                    }

                    if(angular.isDefined(ngModel.$modelValue) && ngModel.$modelValue == ngModel.$modelValue) {

                        // var currentValue = $(element).redactor('code.get');
                        //check current value of radactor is valid?
                        // if (angular.isUndefined(currentValue) || currentValue != currentValue || currentValue == null) {
                        $(element).redactor('code.set', ngModel.$modelValue);
                        // }
                        // else {
                            // $(element).redactor('code.set', currentValue);
                        // }

                        if (ngModel.$modelValue == '<div></div>' || ngModel.$modelValue == '' || ngModel.$modelValue == '<br>') {
                            $scope.checkRequired = true;
                        }
                    }
                });

                $scope.inited = 0;                    

                if(window.redactorInited) {
                    if (hasChanged) {
                        hasChanged = false;
                        return;
                    }
                    
                    var modelGetter = $parse(attrs['ngModel']);

                    if (angular.isDefined(modelGetter($scope)) && modelGetter($scope) == modelGetter($scope)) {
                        $(element).redactor('code.set',modelGetter($scope));
                    }

                    return;
                }

                $(element).redactor({
                    imageUpload: '/content/upload',
                    plugins: ['table'],
                    callbacks:{
                        blur: function(e)
                        {
                            var content = this.code.get();
                            if (content == '<div></div>' || content == '' || content == '<br>') {
                                $scope.checkRequired = true;
                            }
                            ngModel.$setViewValue(content);

                            hasChanged = true;

                        },
                        change: function(val)
                        {
                            // console.log('disabled',attrs.disabled);
                            if(attrs.disabled) return;
                            // console.log('change');
                            var content = this.code.get();
                            if (content == '<div></div>' || content == '' || content == '<br>') {
                                $scope.checkRequired = true;
                            }
                            // console.log('content', content);
                            ngModel.$setViewValue(content);

                            hasChanged = true;

                        },

                        insertedTable: function(table)
                        {
                            var content = this.code.get();
                            ngModel.$setViewValue(content);
                            hasChanged = true;
                        },

                        init:function()
                        {
                            $scope.inited = 1;
                            $timeout(function() {
                                $(element).each(function(key, curElement){
                                    if (ngModel.$modelValue && angular.isDefined(ngModel.$modelValue)
                                        && angular.isDefined($.data(curElement, 'redactor'))) {

                                       $(element).redactor('code.set', ngModel.$modelValue);
                                    }
                                })
                            })

                        },
                        // setValue: function() {
                        //     alert(1111);
                        // }
                    },
                    focus: false,
                    minHeight: 300// pixels
                });
            }
        }
    }])

    .directive("uploadFile", ['$http','$parse','$timeout','Upload',
        function($http,$parse,$timeout,Upload) {
            return {
                restrict: 'EA',
                require : '?ngModel',
                scope: {
                    files:'=',
                    fileIds:'=',
                    openPicture:'&',
                    disabled: '=',
                    isUploading: '&',
                    // ngModel: '='
                },
                priority: 1,
                replace: true,
                transclude: true,
                templateUrl: baseUrl + '/app/shared/form-builder-directive/views/file-upload.html?v='+new Date().getTime(),
                link: function(scope, element, attrs, ngModel) {
                    scope.disabled = window.isDisable;
                    var countUpload = 0;

                    scope.baseUrl = baseUrl;
                    scope.fileUpload = {};
                    scope.fileUploaded = [];
                    scope.fileUploadIds = [];
                    scope.fileError = {};
                    scope.accept=attrs.accept;
                    scope.uploadFinish = true;

                    scope.listFilesFormBuilder  = window.listFilesFormBuilder;

                    scope.isLoadField = {};

                    scope.numberFileUpload = [];

                    // model to view
                    // ngModel.$formatters.push(function(value) {
                    //     getFile();
                    //     return value;
                    // });
                    // // view to model
                    // ngModel.$parsers.push(function(value) {
                    //     return value;
                    // });

                    var unregister = scope.$watch(function() {
                        getFile();
                    }, initialize);

                    function getFile() {
                        if (!attrs.ngMultiple) {
                            attrs.ngMultiple="true";
                        }

                        var ngMultiple=  (attrs.ngMultiple === "true");
                        if (attrs.ngMultiple!="true") {
                            scope.ngMultiple= false;
                            if (attrs.ngMultiple=="false")
                            {
                                scope.uploadMultiple=  ngMultiple;
                            } else {
                                scope.uploadMultiple='one';
                            }
                        } else {
                            scope.ngMultiple= ngMultiple;
                            scope.uploadMultiple=  ngMultiple;
                        }

                        if (typeof ngModel.$modelValue != 'undefined' && ngModel.$modelValue!=null) {
                            if (scope.uploadMultiple=='one') {//file single
                                scope.hideIconLoading = true;

                                var _currentFileId = scope.listFilesFormBuilder[ngModel.$modelValue];
                                
                                // $http({
                                //       method: 'GET',
                                //       url:baseUrl + '/upload-form-builder/file/'+ngModel.$modelValue + '?' + new Date().getTime(),
                                // }).then(function successCallback(response) {
                                var fileEdit = [];
                                fileEdit['uniId'] = getId();
                                fileEdit['proccess'] = 100;
                                fileEdit['error'] = 0;

                                //get file's information
                                if (angular.isDefined(_currentFileId)) {
                                    fileEdit['name'] = _currentFileId['file_name'];
                                    fileEdit['file_name'] = _currentFileId['file_name'];
                                    fileEdit['id'] = _currentFileId['id'];
                                    fileEdit['size'] = _currentFileId['size'];
                                    fileEdit['type'] = _currentFileId['type'];
                                }

                                scope.fileUploadIds = ngModel.$modelValue;

                                scope.fileUpload[fileEdit['uniId']]= fileEdit;

                                
                                ngModel.$setViewValue( scope.fileUploadIds);

                                scope.hideIconLoading = false;

                                setDefaultValue(scope.fileUpload);

                                // })
                            } else {//file multiple
                                scope.fileUploadIds = [];
                                if(angular.isArray(ngModel.$modelValue)) {

                                    for (var i = 0; i < ngModel.$modelValue.length; i++) {
                                        // console.log(ngModel.$modelValue[i]);
                                        var maxLengthArrayValue = ngModel.$modelValue.length;
                                        scope.hideIconLoading = true;
                                        
                                        var _currentFileId = scope.listFilesFormBuilder[ngModel.$modelValue[i]];
            
                                        var fileEdit=[];
                                        fileEdit['uniId']=getId();
                                        fileEdit['proccess']=100;
                                        fileEdit['error']=0;

                                        //get information of current file with current file's id
                                        if (angular.isDefined(_currentFileId)) {
                                            fileEdit['name']=_currentFileId['file_name'];
                                            fileEdit['file_name']=_currentFileId['file_name'];
                                            fileEdit['id']=_currentFileId['id'];
                                            fileEdit['size']=_currentFileId['size'];
                                            fileEdit['type']=_currentFileId['type'];
                                        }
                                        //get list old field id
                                        scope.fileUploadIds.push(ngModel.$modelValue[i]);                                        

                                        //fileUpload contain file's infomation with alias id
                                        scope.fileUpload[fileEdit['uniId']]= fileEdit;


                                        if (maxLengthArrayValue == scope.fileUploadIds.length) {
                                            scope.hideIconLoading = false;
                                        }
                                    }

                                    //set value for model
                                    ngModel.$setViewValue(scope.fileUploadIds);
                                    // $scope.ngModel = scope.fileUploadIds;
                
                                    if ( angular.isDefined(ngModel.$modelValue) && i == ngModel.$modelValue.length) {
                                        setDefaultValue(scope.fileUpload);
                                    }
                                }
                            }
                        }else{
                            scope.fileUpload = {};
                        }
                    }

                    function initialize(value) {
                        // ngModel.$setViewValue(value);
                        unregister();
                    }
                    scope.upload = function(files) {
                        scope.fileUploaded = [];
                        if (files && files.length) {
                            
                            countUpload++;
                           if ( angular.isUndefined(scope.numberFileUpload[countUpload]) ) {
                                scope.numberFileUpload[countUpload] = [];
                            }
                            for (var i = 0; i < files.length; i++) {
                                 if (attrs.accept=='image'&& attrs.accept!=checkFile(files[i].type)) {
                                    continue;
                                 }


                                scope.isUploading({'status':true});

                                // ngModel.$setViewValue({finished: false});
                                (function(i) {
                                    // ngModel.$setViewValue({finished: false});
                                    if (scope.uploadMultiple=='one') {
                                        scope.fileUpload={};
                                    }
                                    var file = files[i];
                                    file['uniId'] = getId();
                                    file['proccess'] = 0;
                                    file['error'] = '';
                                    scope.isUploadServe=attrs.isUploadServe;
                                    scope.fileUpload[file['uniId']] = file;
                                    //check max file size upload
                                    if (angular.isDefined(window.maxUpload['size']) && file['size'] >  window.maxUpload['size']) {
                                        if (angular.isUndefined(scope.fileError[file['uniId']])) {
                                            scope.fileError[file['uniId']] = {};
                                        }

                                        scope.fileError[file['uniId']]['status'] = 0;
                                        scope.fileError[file['uniId']]['error'] = 'Max file size is '+window.maxUpload['name'];
                                        scope.fileUpload[file['uniId']]['error'] = 'Max file size is '+window.maxUpload['name'];

                                        scope.uploadFinished = true;

                                        ngModel.$setViewValue(scope.fileUploadIds);
                                    } else {
                                        Upload.upload({
                                            method:'POST',
                                            url: baseUrl + '/upload-form-builder/file',
                                            file: file,
                                            data:attrs.isUploadServe
                                        }).progress(function(evt) {
                                            // ngModel.$setViewValue({finished: false});
                                            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                                            scope.fileIsUploading = true;
                                            if (angular.isDefined(scope.fileUpload[file['uniId']])) {

                                                    scope.fileUpload[file['uniId']]['proccess'] = progressPercentage;

                                                    var _maxLength = Object.keys(angular.extend({}, scope.fileUpload)).length;
                                                    var _listKey = Object.keys(angular.extend({}, scope.fileUpload));

                                                    for (var key in scope.fileUpload) {
                                                        if (key == _listKey[_maxLength - 1] && scope.fileUpload[key]['proccess'] == 100) {
                                                            scope.isUploading({'status':false});
                                                        } else if(scope.fileUpload[key]['proccess'] < 100){
                                                            break;
                                                        }
                                                    }
                                                // scope.uploadFinished = false;
                                                // ngModel.$setViewValue({finished: scope.uploadFinished});
                                            }


                                        }).error(function(data, status, headers, config) {
                                            files.splice(1, i);
                                            if (angular.isDefined(scope.fileUpload[file['uniId']])) {
                                                if (data && angular.isDefined(data.message)) {
                                                    scope.fileUpload[file['uniId']]['error'] = data.message;
                                                }
                                                scope.fileError[config.file['uniId']] =config.file;
                                                scope.fileError[config.file['uniId']]['status'] = data.status;
                                            }

                                        }).success(function(data, status, headers, config) {
                                            if (angular.isDefined(scope.fileUpload[config.file.uniId])) {
                                                if (scope.isUploadServe) {
                                                    data.item['uniId'] = config.file.uniId;
                                                    if (scope.uploadMultiple == 'one') {
                                                        scope.fileUploaded = data.item;
                                                        scope.fileUploadIds = data.item.id;
                                                    } else {
                                                        scope.fileUploaded.push(data.item);
                                                        scope.fileUploadIds.push(data.item.id);
                                                    }
                                                    scope.listFilesFormBuilder[data.item.id] = data.item;
                                                    // console.log(scope.listFilesFormBuilder, 'scope.listFilesFormBuilder');
                                                }else {
                                                    if (scope.uploadMultiple == 'one') {
                                                        scope.fileUploaded = config.file.uniId;
                                                        scope.fileUploadIds = config.file;
                                                    } else {
                                                        scope.fileUploaded.push(config.file.uniId);
                                                        scope.fileUploadIds.push(config.file);
                                                    }
                                                }
                                            }
                                        }).finally(function() {
                                            scope.uploadFinished = true;
                                            $timeout(function() {
                                                ngModel.$setViewValue(scope.fileUploadIds);
                                            })

                                        });
                                    }


                                })(i);
                            }
                        }
                    }
                    ngModel.$render = function() {

                        // scope.$apply(function() {
                        scope.filesUpload = ngModel.$viewValue;
                        // })

                    }


                     /**
                      * [checkFile description]
                      * @param  {[type]} type [description]
                      * @return {[type]}      [description]
                      */
                    scope.checkFile = function(type) {

                        return  checkFile (type);
                    }
                    function checkFile (type) {
                        var images = ['png','gif','jpg', 'jpeg'];
                          if (typeof type !== 'undefined') {
                            if (images.indexOf(type.split('/')[1]) != -1 ) {
                                 return 'image';
                            }else {
                            switch(type.split('/')[1]) {
                                case 'zip':
                                    return 'zip';
                                    break;
                                case 'pdf':
                                    return 'pdf';
                                    break;
                                case 'msword':
                                    return 'msword';
                                    break;
                                default:
                                    return 'other';
                                    break;
                            }
                            }

                          }

                    }

                    function getId() {
                        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
                    }



                    scope.deleteFile = function(uniId) {
                        delete scope.fileUpload[uniId];
                        if (scope.uploadMultiple == 'one') {
                                    scope.fileUploadIds =[];
                                    scope.uploadFinished = true;
                                    ngModel.$setViewValue(null);
                        } else {
                            for(var key in scope.fileUploaded) {
                                if (uniId == scope.fileUploaded[key]['uniId']) {
                                        var index = scope.fileUploadIds.indexOf(scope.fileUploaded[key]['id']);
                                        scope.fileUploadIds.splice(index, 1);
                                        scope.uploadFinished = true;
                                        if (scope.fileUploadIds.length) {
                                            ngModel.$setViewValue(scope.fileUploadIds);
                                        } else {
                                            ngModel.$setViewValue(null);
                                        }
                                    // ngModel.$setViewValue({ids: scope.fileUploadIds, files: scope.fileUploaded, finished: scope.uploadFinished });
                                }
                            }
                        }

                    }

                    /*push files to fileUploaded array, when edit item*/
                    function setDefaultValue(curVal) {
                        if (angular.isDefined(scope.fileUploaded) && !scope.fileUploaded.length) {
                            for (var i in curVal) {
                                scope.fileUploaded.push(curVal[i]);
                            }
                        }
                    }
                    scope.$on("emptyFiles", function (event, args) {
                        scope.fileUpload = {};
                        scope.fileUploaded = [];
                        scope.fileUploadIds = [];
                    });

                }
            }
        }
    ])
    .directive('refreshCheckbox', ['$compile', function($compile) {
        return {
            restrict: 'A',
            require: '?ngModel',
            link: function($scope, element, attrs, ngModelCtrl) {

                $scope.$watch(attrs.ngModel, function(newValue, oldValue) {

                    if(angular.isDefined(ngModelCtrl.$modelValue)) {

                        if(ngModelCtrl.$modelValue == 1) {
                            ngModelCtrl.$setViewValue(true);
                        }
                        element.attr('checked', ngModelCtrl.$modelValue);

                    }
                })                
            }
        }     
    }])

    .filter('bytes', function() {
        return function(bytes, precision) {
            if (isNaN(parseFloat(bytes)) || !isFinite(bytes)) return '-';
            if (typeof precision === 'undefined') precision = 1;
            var units = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'],
                number = Math.floor(Math.log(bytes) / Math.log(1024));
            return (bytes / Math.pow(1024, Math.floor(number))).toFixed(precision) + ' ' + units[number];
        }
    });
})(jQuery);
