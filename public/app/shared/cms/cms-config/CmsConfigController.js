var cmsConfigApp = angular.module('CmsApp');

cmsConfigApp.controller('ConfigController', ['$scope','$modal','$filter', function($scope, $modal, $filter) {

    /**
     * [configSection description]
     * 
     * @author minh than
     * @param  {Function} callback [description]
     * @param  {[type]}   data     [description]
     * @return {[type]}            [description]
     */
    $scope.configSection = function(callback, data) {
        //get template config section
        var templateUrl = window.baseUrl + '/app/shared/cms/cms-config/modal/view-config-section.html?' + new Date().getTime();

        var modalInstance = $modal.open({
            templateUrl: templateUrl,
            controller: 'ModalConfigSection',
            size: undefined,
            resolve: {
                sections:function() {
                    return data;
                }
            }
        });
        modalInstance.result.then(function(data) {
            var valueResult = callback.call(valueResult, data);
        }, function() {
            var valueResult = callback.call(valueResult);
        });
    }

    $scope.listFields = [];

    $scope.setData = function() {

        if (angular.isDefined(data.fields)) {
            $scope.listFields = angular.copy(data.fields);
        }
    }    

    /**
    * @auth   bang@httsolution.com
    * @param  [data]    list fields
    * @param  [callback]  call back function
    *
    * config fields which got when parse content
    * configFields       [function]
    *
    * show modal config fields
    *
    * call back function with data (fields configed)
    */
    $scope.configFields = function(callback, data) {

        var templateUrl = window.baseUrl + '/app/shared/cms/cms-config/modal/view-config-field.html?' + new Date().getTime();

        var modalInstance = $modal.open({
            templateUrl: templateUrl,
            controller: 'ModelConfigField',
            size: undefined,
            resolve: {
                item:function() {
                    return data;
                }
            }
        });

        modalInstance.result.then(function(data) {
            var valueResult = callback.call(valueResult, data);
        }, function() {
            var valueResult = callback.call(valueResult);
        });

    }

    $scope.getModalShowListConfigFields = function(callback, fields) {

        if (fields.length < 0 || angular.isUndefined(fields.length) && Object.keys(fields) .length < 0) {
            callback.call(true, data);
            return;
        }

        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + '/app/shared/cms/cms-config/modal/list-field-config.html?v=' + new Date().getTime(),
            controller: 'ModalShowListConfigFields',
            size: undefined,
            windowClass: 'update-template',
            resolve: {
                fields: function() {
                    return fields;
                }
            }
        });
        modalInstance.result.then(function (data) {

            var valueResult = callback.call(valueResult, data);

        }, function () {

            var valueResult = callback.call(valueResult);
        });

    }

}]).controller('ModalConfigSection', ['$scope', '$modalInstance', 'Upload','sections', function ($scope, $modalInstance, Upload, sections) {

    $scope.stepSection = 0;

    $scope.sectionsConfig = sections;

    $scope.sections = [];

    $scope.sectionLenght = sections.length;

    $scope.loadingFile = [];

    $scope.errorThumbnailSection = [];

    $scope.submittedSection = [];

    // function upload thumbnail step section
    $scope.uploadThumbnailSection = function(files, step) {

        if (files && files.length) {

            // if (files[0]['size'] > maxUpload['size']) {

            //     $scope.errorThumbnailSection[step] = 'Max file size is ' + maxUpload['name'];

            //     return;
            // }
            $scope.loadingFile[step] = 'uploading file';

            Upload.upload({
                url: baseUrl + '/admin/file',
                method: 'POST',
                file: files,
                fields: {
                    'store': 'template-content-manager'
                }
            }).progress(function(evt) {

                $scope.isErrorUploadFile = true;

            }).success(function(data, status, headers, config) {

                $scope.isErrorUploadFile = false;

                $scope.sections[step].thumbnail = data.item.id;

                $scope.loadingFile[step] = files[0]['name'];

                $scope.errorThumbnailSection[step] = '';

            }).error(function(data) {

                $scope.loadingFile[step] = '';

                $scope.errorThumbnailSection[step] = data.message;

            });
        }
    }

    $scope.eventNextStepSection = function(validate) {

        $scope.submittedSection[$scope.stepSection] = true;

        if (validate || !$scope.sections[$scope.stepSection].thumbnail) {
            return;
        }

        if ($scope.stepSection < ($scope.sectionLenght - 1)) {

            $scope.stepSection++;

        }else{

            $modalInstance.close($scope.sections);
        }
    }

    $scope.prevStepSection = function() {

        if ($scope.stepSection > 0) {

            $scope.stepSection--;

        }
    }   

    $scope.cancel = function() {

        $modalInstance.dismiss('cancel');
    }


}]).controller('ModelConfigField', ['$scope', 'item', '$modalInstance', function ($scope, item, $modalInstance) {

    $scope.listFields = [];

    /**
    * 
    * list type of fields (text, checkbox,...)
    * 
    */
    $scope.listFieldType = window.listFieldType;

    /**
    * 
    * list data option, apply for selectbox, multichoise,...
    * 
    */
    $scope.attributeDataOption = window.listAttributeDataOption;

    /**
    * 
    * list type(custom) follow id (type select), use to validate
    * 
    */
    $scope.listIdCheck = angular.copy(window.listIdCheck);

    /**
    * 
    * list type(custom) follow id (type select, chekcbox, ...)
    * 
    */
    $scope.listMapType = window.listMapType;

    /**
    * 
    * list name of field follow id, use to show title field
    * 
    */
    $scope.listFieldNameMap = window.listFieldNameMap;

    $scope.listMapTypeTextSpecial = window.listMapTypeTextSpecial;

    $scope.listBlocks = window.listBlocks;

    $scope.curStepField = 0;
    $scope.stepThird = true;

    if (angular.isDefined(item)) {
        $scope.listFields = angular.copy(item);
    }

    /**
    * @auth   bang@httsolution.com
    * 
    * convent fields to config      [description]
    * nextStepFileld                [function]
    * @param  [curStep]  information of current field(field config)
    *
    * pass each step to config fields
    *
    * each step:
    * check validate field
    * check min, max of field(if that field is multiple)
    * 
    * @return void
    */
    $scope.nextStepFileld = function(curStep, validate) {
        /*forcus to element first invalid*/
        $('.ng-invalid:eq(0)').focus();

        $scope.submitted =  true;

        $scope.errorMax = '';

        if (validate) {
            /*forcus to element first invalid*/
            $('.ng-invalid:eq(1)').focus();
            return;
        }

        /*set default value for field title*/
        if ($scope.listFields[curStep].variable == "field_title") {
            $scope.listFields[curStep].field_type = 'text';
            $scope.listFields[curStep].type = 'text';
        }

        /*apply for fields multiple*/
        if ($scope.listFields[curStep].multiple) {

            var minF = $scope.listFields[curStep].min_field;
            var maxF = $scope.listFields[curStep].max_field;

            /*check max field > min field?*/
            if (angular.isDefined(minF) && angular.isDefined(maxF)) {
                if (maxF && minF && maxF < minF) {
                    $scope.errorMax = "Max is invalid";
                    angular.element('#max-field-in').focus();
                    return;
                }
            }
        }

        $scope.submitted =  false;

        /**
        * check type of current field, type is cutom?
        * @type input, select,...
        */
        if (!angular.isDefined(window.listMapType[$scope.listFields[curStep].field_type])) {
            // get type current filed
            $scope.listFields[curStep].type = angular.copy($scope.listFields[curStep].field_type);

        }else{
            // get type current filed
            $scope.listFields[curStep].type = angular.copy(window.listMapType[$scope.listFields[curStep].field_type]);
        }

        if ($scope.curStepField == $scope.listFields.length -1) {

            $modalInstance.close($scope.listFields)
            return;

        }

        $scope.curStepField = curStep+1;

    }

    $scope.hiddenE = function() {
        $scope.errorMax = '';
    }

    /*prev step*/
    $scope.prevStepFileld = function(curStep) {
        $scope.curStepField = curStep-1;
    }

    /*move to form update section infomation*/
    $scope.eventPrevStepSecond = function() {

        if ($scope.result.sections.length == 0) {

            $scope.stepFirst = true;

            $scope.stepThird = false;

        } else {

            $scope.stepSecond = true;

            $scope.stepThird = false;

        }
    }

    $scope.cancel = function() {
        angular.element('#model-template-content').show();
        $modalInstance.dismiss('cancel');
    }


}])
.controller('ModalShowListConfigFields', ['$scope', '$modalInstance', '$timeout', 'fields', '$filter', 
function($scope, $modalInstance, $timeout, fields, $filter) {
    // get list field type 
    $scope.listFieldType = window.listFieldType;
    // get list map type in fields
    $scope.listMapType = window.listMapType;

    // $scope.listMapTypeTextSpecial = window.listMapTypeTextSpecial;
    // console.log($scope.listMapTypeTextSpecial);
    // default map list type
    $scope.mapListType = [];

    for(var key in $scope.listFieldType) {

        $scope.mapListType[$scope.listFieldType[key]['_id']] = $scope.listFieldType[key]['name'];
    }
    // get attribute data option
    $scope.attributeDataOption = window.listAttributeDataOption;
    // get list id to check
    $scope.listIdCheck = angular.copy(window.listIdCheck);
    // get list fields
    $scope.fields = fields;
    // get list fileds to rollback field
    $scope.fieldsRollback = angular.copy($scope.fields);
    // default edit empty
    $scope.edit = [];
    // defalt validate emptye
    $scope.validate = [];

    $scope.listBlocks = window.listBlocks;

    $scope.blockMapFields = [];
    for(var key in $scope.listBlocks) {

        $scope.blockMapFields[key] = [];

        for(var index in $scope.listBlocks[key]['fields']) {
            var variable = $scope.listBlocks[key]['fields'][index]['variable'];
            $scope.blockMapFields[key][variable] = $scope.listBlocks[key]['fields'][index]['name'];
        }

    }

    $scope.mapSort = {'' : 'None', 'asc' : 'Asc', 'desc' : 'Desc'};

    $scope.orderBySort = function(keySort, index) {

        if(!keySort) {
            $scope.fields[index].order_by = 'asc';
        }
    }
    
    // show index field to edit
    $scope.showEditField = function(index) {

        $scope.edit[index] = true;
    }

    // edit index filed
    $scope.editField = function(index, currentField) {
        // validate when edit field
        isValidate = $scope.validateFields(index, currentField);

        // has error
        if (isValidate) {
            return;
        }
        /**
        *get type of current field
        * @type input, select,...
        */
        if (!angular.isDefined(window.listMapType[$scope.fields[index].field_type])) {
            // get type current filed
            $scope.fields[index].type = angular.copy($scope.fields[index].field_type);

        } else {
            // get type current filed
            $scope.fields[index].type = angular.copy(window.listMapType[$scope.fields[index].field_type]);
        }
        // max field is null then set max field is 1
        // if (currentField.multiple && currentField.max_field == null) {

        //   $scope.fields[index].max_field = 1000;
        // }
        // min field is null then set min field is 1
        if (currentField.multiple && currentField.min_field == null) {

            $scope.fields[index].min_field = 1;
        }

        $scope.edit[index] = false;
        // set field rollback to roll back data fields when user clock button rollback
        $scope.fieldsRollback = angular.copy($scope.fields);

    }

    /**
    * rollback item field
    * @param  {[type]} index    [description]
    * @param  {[type]} variable [description]
    * @return {[type]}          [description]
    */
    $scope.rollbackItemField = function(index, variable) {

        $scope.validate[index] = [];
        // brower fields rollback to set item fields
        for(var key in $scope.fieldsRollback) {
            // field is rollback
            if ($scope.fieldsRollback[key]['variable'] === variable) {
                // set fields current index when rollback
                $scope.fields[index] = angular.copy($scope.fieldsRollback[key]); 

                break;
            }
        }
        // set edit current index is false
        $scope.edit[index] = false;
    }
    
    /**
    * validate fields
    * @return {[type]} [description]
    */
    $scope.checkValidateFields = function() {
        // brower fields to validate fields
        for(var key in $scope.fields) {
            // call function validate item fields
            isValidate = $scope.validateFields(key, $scope.fields[key]);

            if (isValidate) return; // is has error t hen return

            if (!angular.isDefined(window.listMapType[$scope.fields[key].field_type])) {
                // get type current filed
                $scope.fields[key].type = angular.copy($scope.fields[key].field_type);

            }else{
                // get type current filed
                $scope.fields[key].type = angular.copy(window.listMapType[$scope.fields[key].field_type]);
            }
            // max field is null then set max field is 1
            // if ($scope.fields[key].multiple && $scope.fields[key].max_field == null) {

            //   $scope.fields[key].max_field = 1000;
            // }
            // min field is null then set min field is 1
            if ($scope.fields[key].multiple && $scope.fields[key].min_field == null) {

                $scope.fields[key].min_field = 1;
            }            
        }
        // trigger click button submit
        $timeout(function() {

            angular.element('#submit-field').trigger('click');

        }, 10);

    }
    
    /**
    * hide validate
    *
    * @author minh than
    * @param  {[int]} index [index fields]
    * @param  {[string]} type  [type fields]
    * @return {[type]}       [description]
    */
    $scope.hideValidate = function(index, type) {
        // check is exits validte type 
        if (typeof $scope.validate[index] != 'undefined' && typeof $scope.validate[index][type] != 'undefined') {

            $scope.validate[index][type] = ''; // hide validate in current type
        }


    }
    /**
    * [update tittle in checkbox and radio]
    *
    * @author minh than
    * @param  {int} index [index fieds]
    * @return {[type]}       [description]
    */
    $scope.updateTitleCheck = function(index) {
        // if is fields current index is checkbox or radio
        if ($scope.fields[index]['field_type'] != 'checkbox' && $scope.fields[index]['field_type'] != 'radio' 
        || window.listMapType[$scope.fields[index]['field_type']] != 'checkbox' || window.listMapType[$scope.fields[index]['field_type']] != 'radio') {

            if (typeof $scope.fields[index].ra_check_title != 'undefined')

            $scope.fields[index].ra_check_title = ''; // set is title

        }

    }
    /**
    * update content fields
    * @return {[type]} [description]
    */
    $scope.updateContentField = function() {

        $modalInstance.close($scope.fields);// close modal and return data fields
    }

    $scope.cancel = function () {

        $modalInstance.dismiss('cancel'); // hide modal and not return data fields

    };
/**
* validate index fields 
* @param  {index} index        [index fields]
* @param  {obj} currentField [obj current fields]
* @return {[type]}              [description]
*/
$scope.validateFields = function(index, currentField) {

    var isValidate = false;

    $scope.validate[index] = [];
    // check name is empty
    if (currentField.name.length == 0) {
        // set validate name fieds index
        $scope.validate[index]['name'] = $filter('trans')('name', 'directive-cms-config') + ' ' + $filter('trans')('required', 'validate');

        isValidate = true;

    }
    // check max fields is negative
    if (currentField.max_field < 0) {
        // set validate maxfield
        $scope.validate[index]['max_field'] = $filter('trans')('max', 'golbal') + ' ' + $filter('trans')('invalid', 'validate');

        isValidate = true;          

    } else {
        // check max fields elder min field
        if (currentField.max_field && currentField.max_field < currentField.min_field && currentField.min_field > 0) {

        $scope.validate[index]['max_field'] = $filter('trans')('max', 'golbal') + ' ' + $filter('trans')('invalid', 'validate');

        isValidate = true;

        }          
    }
    
    // check min fields is negative
    if (currentField.min_field < 0) {

        $scope.validate[index]['min_field'] = $filter('trans')('min', 'golbal') + $filter('trans')('invalid', 'validate');

        isValidate = true;          

    }else{
        // check min field lesser max fiedl
        if (currentField.min_field > currentField.max_field && currentField.max_field > 0) {

            $scope.validate[index]['min_field'] = $filter('trans')('min', 'golbal') + ' ' + $filter('trans')('invalid', 'validate');;

            isValidate = true;

        }          
    }
    // check current fieldsis checkbox or radio
    if (currentField.field_type == 'checkbox' || currentField.field_type == 'radio' || 
        window.listMapType[currentField.field_type] == 'checkbox' || window.listMapType[currentField.field_type] == 'radio') {
        // check title is null
        if (typeof currentField.ra_check_title == 'undefined' || currentField.ra_check_title.length == 0) {

            $scope.validate[index]['ra_check_title'] = $filter('trans')('title', 'golbal') + ' ' + $filter('trans')('required', 'validate');

            isValidate = true; 

        }

    } 

    if (currentField.field_type == 'select' || window.listMapType[currentField.field_type] == 'select') {

        if (typeof currentField.option_id == 'undefined' || !currentField.option_id) {

            $scope.validate[index]['data-option'] = $filter('trans')('option', 'golbal') + ' ' + $filter('trans')('required', 'validate');

            isValidate = true; 

        }

    }
    // return type bool is validate
    return isValidate;
}

}])
.directive('formatNumber',['$filter', '$timeout',function($filter, $timeout) {
    return {
        restrict: 'A',
        require: '?ngModel',
        scope: {
            listTypes: "=",
        },

        link: function(scope, el, attr, ctr) {
            ctr.$viewChangeListeners.push(function() {
                var val = el.val();
                // if (!val || isNaN(val) || parseFloat(val) <= 0) {
                if (!val || isNaN(val)) {
                    ctr.$setViewValue(null);
                    ctr.$render();
                } else if (String(val).length >= 9 && !isNaN(val)) {
                    val = val.substr(0, 9);
                    ctr.$setViewValue(val);
                    ctr.$render();
                    event.preventDefault();
                }          
            })
        }
    }
}]);
