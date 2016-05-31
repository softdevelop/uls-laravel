var blockApp =  angular.module('BlockApp');

blockApp.controller('ManageBlockCreateController', ['$scope', '$modal', '$timeout', 'Upload', '$filter', 'BlockManagerService', '$controller','ngTableParams',
    function ($scope, $modal, $timeout, Upload, $filter, BlockManagerService, $controller,ngTableParams) {
    // call controller config field
    $controller('ConfigController', { $scope: $scope });
    //
    $controller('ManagerBlockValidate', { $scope: $scope });

    /* Code Mirror editor */
    $scope.block = window.block;
    $scope.usages = window.usages;
    if (angular.isUndefined($scope.usages)) {
      $scope.usages = [];
    }
    $scope.loadDataUsage = function() {
        $scope.tableParams = new ngTableParams({
            page: 1,
            count: 50,
            sorting: {
                'name': 'desc'
            },
        }, {
            total: $scope.usages.length,
            getData: function($defer, params) {
                var orderedData = params.sorting() ? $filter('orderBy')($scope.usages, params.orderBy()) : $scope.usages;
                orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
                params.total(orderedData.length);
                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            }
        });
    }

    $scope.loadDataUsage();
    $scope.clickable = function($event, contentId, type, block_type) {
        switch(type) {
            case 'template':
                window.open(baseUrl + "/cms/template-content-manager/update-template/" + contentId,'_blank');
                window.location = baseUrl + "/cms/template-content-manager/update-template/" + contentId;
                break;
            case 'page':
                window.open(baseUrl + "/cms/pages/edit-page/" + contentId,'_blank');
                break;
            case 'block':
                window.open(baseUrl + "/cms/block-manager/edit-block/" + contentId,'_blank');
            default:
        }
    }
    $scope.successForm = [];
    $scope.fieldsHaveConfigured = [];// array fields have Configured
    $scope.exitsInject = [];
    if (angular.isUndefined($scope.block)) {
        $scope.block = {};
        $scope.successForm[0] = true;
        $scope.successForm[1] = false;
        $scope.requiredEditorContent  = true;
        $scope.curFields = {};
        $scope.block.injects = {}; // inject block
        $scope.fields = {};
    }else{
        if (angular.isDefined($scope.block.data)) {
            $scope.successForm[0] = true;
            $scope.successForm[1] = true;
            $scope.requiredEditorContent  = false;
            
            $scope.curFields = angular.extend({}, angular.copy($scope.block.data.fields));
        }
        if (angular.isDefined($scope.block.injects)) {

            for(var key in $scope.block.injects) {
                $scope.exitsInject[$scope.block.injects[key]] = $scope.block.injects[key];
            }
        }
        if (angular.isDefined($scope.block.fields)) {
            $scope.fields = $scope.block.fields;
            for(var key in $scope.block.fields) {
                $scope.fieldsHaveConfigured[$scope.block.fields[key]['variable']] = $scope.block.fields[key];
            }
        }
    }

    $scope.uploading = false;

    $scope.isChangeDataMirror = false;

    $scope.parsedContent = false;

    /**
     * [isUploading description]
     * call back when upload file
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]}  value [description]
     * @return {Boolean}       [description]
     */
    $scope.isUploading = function(value){
        $scope.uploading = value;
    }

    $scope.successFieldsCurrentBlock = true;
    $scope.successInjectBlock = [];
    $scope.isShowManageBlock = false;// is not show manage field block
    $scope.isShowFieldBlockInject = false;
    $scope.isShowFieldCurrentBlock = false;
    $scope.contentBlock = {};
    
    $scope.finishConfigFields = false;
    $scope.successInject = [];
    $scope.listOutTypeMap = angular.copy(window.listOutTypeMap);
    $scope.listCheckBoxMap = angular.copy(window.listCheckBoxMap);
    
    $scope.isDetail = true; // active detail

    $scope.multiFieldFollowVariable = {};
    //fill list file name
    $scope.file_fields = [];
    $scope.listField = [];
    $scope.countFieldsOfMultiField = [];
    $scope.fieldsBlocks = [];
    $scope.cacheDataBlock = {};
    $scope.fieldsBlocksMap = {};
    /**
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     * show fields(type is mutiple) default when show modal      [description]
     * customFieldsMutiple                                       [function]
     *
     * set default value is null for fields (apply when add new field)
     */
    // $scope.customFieldsMutiple = function( fields) {
    //     for (var i in fields) {
    //         if (fields[i].multiple) {
    //             //count field to check minimum filed
    //             updateFieldsOfMuitiField('add', fields[i].variable);
 
    //             //  show a field default follow type(select, input, textarea,...) when change template
                
    //             if (angular.isUndefined($scope.multiFieldFollowVariable[fields[i].variable])) {
    //                 $scope.multiFieldFollowVariable[fields[i].variable] = [{'id':fields[i].variable+0, 'key_field':0}];
    //             }
    //         }
    //     }
    // }
  /*
    * @author [Nguyen Kim Bang] <bang@httsolution.com> update by minh than
    *
   * update (add or remove) field number for multiple fields
   *
   * @action add or remove
   * @variable variable of fields
   */
  var updateFieldsOfMuitiField = function(action, variable) {

        if (angular.isDefined($scope.countFieldsOfMultiField[variable])) {
            switch(action) {
                case 'add':
                    $scope.countFieldsOfMultiField[variable] += 1;
                break;
                case 'remove':
                    $scope.countFieldsOfMultiField[variable] -= 1;
                break;
            }
        } else {
            $scope.countFieldsOfMultiField[variable] = 1;
        }
  } 
    /*
    * @author [Nguyen Kim Bang] <bang@httsolution.com> update by minh than
    *
    * add new field, apply for fields are multiple       [description]
    * addNewField                                        [function]
    *
    * get max index from [multiFieldFollowVariable]
    *
    * if quantity field added greater than max of current field, show alert and return
    *
    * increase quantity field of current field, if quantity field added least max of current field
    */
    $scope.addNewField = function(curField, type) {

        $('#page-loading').css('display', 'block');

        var maxIndex = 0;
        var checkMaxField = 0;
        var id = $scope.currentBlockInject;
        if(type == 'current') {
            var _variable = '_' + id + '_' + curField.variable;
        }else {
            var _variable = curField.variable;
        }

        $scope.listErrorListFile = [];

        /**/
        if (angular.isDefined($scope.multiFieldFollowVariable[_variable]) && $scope.multiFieldFollowVariable[_variable].length) {

            for (var i in $scope.multiFieldFollowVariable[_variable]) {

                if ($scope.multiFieldFollowVariable[_variable][i].id == curField.variable + '___' + $scope.multiFieldFollowVariable[_variable][i].key_field) {

                   checkMaxField +=1;

                   if ($scope.multiFieldFollowVariable[_variable][i].key_field > maxIndex) {

                        maxIndex =  $scope.multiFieldFollowVariable[_variable][i].key_field;
                   }
                }
            }
        }

        /*check maximum fields number, apply for fields multiple*/
        if (checkMaxField >= curField.max_field && curField.max_field) {
            alert('Maximum '+curField.name+' field is '+curField.max_field);
            $('#page-loading').css('display', 'none');
            return
        }

        maxIndex = (checkMaxField > 0)?parseInt(maxIndex) + 1:0;

         //function
        updateListMultipleFieldWithId(curField, id, _variable, maxIndex);

        if(!angular.element('#parentBlock_' + curField.variable).hasClass('in')) {
            angular.element('#action-' + curField.variable).trigger('click');
        }

        $('#page-loading').css('display', 'none');
    }

    /**
     * [updateListMultipleFieldWithId description]
     * update list content for field foreach
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} curField  [description]
     * @param  {[type]} id        [description]
     * @param  {[type]} _variable [description]
     * @param  {[type]} maxIndex  [description]
     * @return {[type]}           [description]
     */
    function updateListMultipleFieldWithId(curField, id, _variable, maxIndex) {
        if (angular.isUndefined($scope.multiFieldFollowVariable[_variable])) {
            if (typeof $scope.listValueFieldRequired[$scope.currentBlockInject] == 'undefined') {
                $scope.listValueFieldRequired[$scope.currentBlockInject] = {};
            }

            if (typeof $scope.listValueFieldRequired[$scope.currentBlockInject][_variable]) {
                $scope.listValueFieldRequired[$scope.currentBlockInject][_variable] = {};
            }
            $scope.multiFieldFollowVariable[_variable] = [{'id':curField.variable + '___' + maxIndex, 'key_field':maxIndex}];
            $scope.listValueFieldRequired[$scope.currentBlockInject][_variable][maxIndex] = getListFieldRequired(curField['option_id'], $scope.currentBlockInject);

            updateFieldsOfMuitiField('add', _variable);
        } else {

            $scope.multiFieldFollowVariable[_variable].push({'id':curField.variable + '___' + maxIndex, 'key_field':maxIndex});

            $scope.listValueFieldRequired[$scope.currentBlockInject][_variable][maxIndex] = getListFieldRequired(curField['option_id'], $scope.currentBlockInject);

            updateFieldsOfMuitiField('add', _variable);
        }
    }

    /**
     * [getListFieldRequired description]
     * get list field and required value field of block belong to current field with option_id
     *
     * @author [bang@httsolution.com]
     * @param  {[type]} _optionId [description]
     * @return {[type]}           [description]
     */
    function getListFieldRequired(_optionId, _id) {

        var _term = (angular.isDefined($scope.term[_id]))?$scope.term[_id]:[];

        var arrayField = [];

        for (var key in _term) {
            //check and get fields of block belong to current field with option id
            if (key.indexOf(_optionId) != -1) {
                arrayField[key] = _term[key];
            }
        }

        return angular.extend({},arrayField);//convent to object
    }

    /**
     * synch fields
     *
     * @author Minh than
     * @param  {[type]} curFields [description]
     * @return {[type]}           [description]
     */
    function synchFields(oldFields, id, listField, type) {

        _id = '_' + id + '_';
        for (var i in listField) {
            if(type == 'current') {
                _variable = _id + listField[i].variable;
                var oldValueField = oldFields[_variable]; //get value of current block
            }else{
                _variable = listField[i].variable;
                var oldValueField = oldFields[listField[i].variable];//get value of block inject
            }

            if (angular.isDefined(oldValueField) && (angular.isArray(oldValueField) || angular.isObject(oldValueField)) && listField[i].multiple) {

                for (var key in oldValueField) {
                    if (angular.isUndefined($scope.multiFieldFollowVariable[_variable])) {
                        $scope.multiFieldFollowVariable[_variable] = [ {'id':listField[i].variable + '___' + key, 'key_field':key} ];
                        updateFieldsOfMuitiField('add', _variable);

                    } else {
                        $scope.multiFieldFollowVariable[_variable].push( {'id':listField[i].variable + '___' + key, 'key_field':key });
                        updateFieldsOfMuitiField('add', _variable);
                    }
                }
            }
        }
    }

    /**
    * @author [Nguyen Kim Bang] <bang@httsolution.com> update by minh than
    *
    * apply for fields are multiple
    * remove current field value
    * remove current field in the view
    *
    * @param field    [description]
    * @param index    [position field]
    *
    * return void
    */
    $scope.removeCurrentField = function(curField, index, type) {

        var id = $scope.currentBlockInject;

        if(type == 'current') {
            // set variable
            var _variable = '_' + id + '_' + curField.variable;
        }else{
            _variable = curField.variable;
        }

        $scope.listErrorListFile = [];

        var curVal = angular.copy($scope.multiFieldFollowVariable[_variable]);
        //check exist item in array value of current field content foreach
        if (angular.isDefined(curVal) && curVal.length) {

            for (var i in curVal) {

                //check exist current field?
                if (curVal[i].key_field == index && curVal[i].id == curField.variable + '___' + curVal[i].key_field) {

                    //check exist item and remove item of current field and update list field multiple
                    //function
                    removeDataContentBlockWithIndex(id, curVal[i].key_field, _variable, function() {
                        updateFieldsOfMuitiField('remove', _variable);

                        $scope.multiFieldFollowVariable[_variable].splice(curVal[i].key_field, 1);

                        for (var curKey in $scope.multiFieldFollowVariable[_variable]) {
                            //update index current array value
                            if ($scope.multiFieldFollowVariable[_variable][curKey]['key_field'] > curVal[i].key_field) {
                                $scope.multiFieldFollowVariable[_variable][curKey] = {'id':curField.variable + '___' + curKey, 'key_field':curKey};
                            }
                        }

                        removeItemInListFieldRequiredWithIdex(id, curVal[i].key_field, _variable);// function
                    });

                    break;
                }
            }
        }
    }

    /**
     * [removeDataContentBlockWithIndex description]
     * remove current data content page with index (current localtion of field when delete)
     *
     * @author [bang@httsolution.com]
     * @param  {[type]}   _currentId [description]
     * @param  {[type]}   _index     [description]
     * @param  {Function} callback   [description]
     * @return {[type]}              [description]
     */
    function removeDataContentBlockWithIndex(_currentId, _index, _variable, callback) {
        //check exist item and remove item of current field and update list field multiple
        if (angular.isDefined($scope.contentBlock['_' + _currentId]) && angular.isDefined($scope.contentBlock['_' + _currentId]['data'])
            && angular.isDefined($scope.contentBlock['_' + _currentId]['data']['fields'])
            && angular.isDefined($scope.contentBlock['_' + _currentId]['data']['fields'][_variable])
            && angular.isDefined($scope.contentBlock['_' + _currentId]['data']['fields'][_variable][_index])) {

            var listValueField = angular.copy($scope.contentBlock['_' + _currentId]['data']['fields'][_variable]);

            listValueField = angular.extend({}, listValueField);

            var listKeyObject = Object.keys(listValueField);
            
            if (listKeyObject.length == 1 || listKeyObject[listKeyObject.length - 1] == _index) {
                delete listValueField[_index];
            } else {
                for (var keyItem in listValueField) {
                    if (parseInt(keyItem) > parseInt(_index) && angular.isDefined(listValueField[keyItem])) {
                        listValueField[keyItem - 1] = angular.copy(listValueField[keyItem]);
                        delete listValueField[keyItem];
                    }
                }
            }

            $scope.contentBlock['_' + _currentId]['data']['fields'][_variable] = listValueField;
        }

        callback.call();
    }

    /**
     * [removeItemInListFieldRequiredWithIdex description]
     * remove list array value of current field required of template with index (current localtion of field when delete)
     *
     * @author [bang@httsolution.com]
     * @param  {[type]} _currentId [description]
     * @param  {[type]} _index     [description]
     * @param  {[type]} _variable  [description]
     * @param  {[type]} _blockId   [description]
     * @return {[type]}            [description]
     */
    function removeItemInListFieldRequiredWithIdex(_currentId, _index, _variable) {

        //contant list array value field of current tempalte
        var _currentItem = $scope.listValueFieldRequired[_currentId];

        //check and remove a child array belong to current field
        if (angular.isDefined(_currentItem)
            && (angular.isDefined(_currentItem[_variable]))) {

            var chilArrayValueFieldRequired = angular.extend({}, _currentItem[_variable]);


            var listKeyObject = Object.keys(chilArrayValueFieldRequired);

            if (listKeyObject.length == 1 || listKeyObject[listKeyObject.length - 1] == _index) {
                delete chilArrayValueFieldRequired[_index];
            } else {
                for (var _key in chilArrayValueFieldRequired) {
                    if (parseInt(_key) > parseInt(_index) && angular.isDefined(chilArrayValueFieldRequired[_key])) {
                        chilArrayValueFieldRequired[_key - 1] = angular.copy(chilArrayValueFieldRequired[_key]);
                        delete chilArrayValueFieldRequired[_key];
                    }
                }
            }

            //check current item was deleted belong to template or block?
            _currentItem[_variable] = chilArrayValueFieldRequired;

            // getTemplateInvalid($scope.listTemPlate, false);
        }
    }

    /*
    * @author [Nguyen Kim Bang] <bang@httsolution.com>
    *
    * check minimum field of field multiple
    *
    * show validate when quantity field added least min of current field
    */
    function checkMinimumField() {

        $scope.listErrorListFile = [];

        var max = 0;

        /*get lists field of current template*/
        var curTemp = $scope.listField;

        /*get list field of page when submit*/
        if (angular.isDefined($scope.curFields)) {
            var curFileds = $scope.curFields;
        }

        if (angular.isDefined(curTemp) && angular.isDefined(curFileds)) {

            for (var i in curTemp) {

                if (curTemp[i].multiple && angular.isDefined($scope.countFieldsOfMultiField[curTemp[i].variable])) {
                    if ($scope.countFieldsOfMultiField[curTemp[i].variable] < curTemp[i].min_field && curTemp[i].min_field > 1) {
                        $scope.listErrorListFile.push('Please, add minimum '+ curTemp[i].min_field + ' field '+ curTemp[i].name);
                        break;
                    }
                }
            }
        }

        if ($scope.listErrorListFile.length) {
            return true;
        }

        return false;
    }

    $timeout(function () {
        $scope.mixedMode = {
            name: "htmlmixed",
            scriptTypes: [
                {
                    matches: /\/x-handlebars-template|\/x-mustache/i,
                    mode: null
                },
                {
                    matches: /(text|application)\/(x-)?vb(a|script)/i,
                    mode: "vbscript"
                }
            ]
        };
        $scope.breadCrumbNewBlock =function() {
             window.location.href = window.baseUrl + '/cms/block-manager';
        }
        $scope.editableCodeMirror = CodeMirror.fromTextArea(document.getElementById('editor'), {
            lineNumbers: true,
            mode: "application/x-httpd-php",
            keyMap: "sublime",
            autoCloseBrackets: true,
            matchBrackets: true,
            showCursorWhenSelecting: true,
            lineWrapping:true,
            theme: "monokai",
            tabSize: 2,
            indentUnit: 4,
            indentWithTabs: true,
            onBlur: function() {
            },
            onChange: function() {

            }
        });
        if (angular.isUndefined($scope.block.content) || $scope.block.content == null) {
            $scope.block.content = '';
            hideLoading();
        }else{
            parseContentBlock($scope.block.content, false, function(result) {});
            setFields();
            $('#mytab a[href="#detail"]').tab('show');
            hideLoading();
            $scope.isChangeDataMirror = true;

            
        }
        $scope.editableCodeMirror.setValue($scope.block.content);
        
        $scope.editableCodeMirror.on("blur", function() {
            var curContent = $scope.editableCodeMirror.getValue();
            $scope.warningError = false;

            //if content's block was changed, parse content again
            if (angular.isDefined($scope.isChangeDataMirror) && $scope.isChangeDataMirror) {
                //call to function parse content block
                parseContentBlock(curContent, false, function(result) {

                    $scope.parsedContent = true;
                    $scope.isChangeDataMirror = false;

                    if (result.blocks.length == 0 && result.fields.length == 0) {

                        $scope.isShowManageBlock = false;
                        $('#mytab a[href="#content"]').tab('show');
                    }
                });
            }

        });
        //catch event change data content block
        $scope.editableCodeMirror.on("change", function() {
            $scope.parsedContent = false;

            var curContent = $scope.editableCodeMirror.getValue();

            if (curContent == '<div></div>' || curContent == '' || curContent == '<br>' || curContent == '<div><strong></strong></div>'||
                curContent == '<div><em></em><strong></strong></div>'|| curContent == '<div><em><del></del></em></div>') {
                $scope.$apply(function() {
                    $scope.requiredEditorContent = true;
                });
            } else {
                $scope.$apply(function() {
                    $scope.requiredEditorContent = false;
                });
            }

            $scope.isChangeDataMirror = true;
        });

    }, 700);
     /**
     * set height Editor full screen
     *
     * @author Cong Hoan <hoan@httsolution.com>
     *
     * @return Void
    */
    $timeout(function() {
        $(document).ready(function () {
            $scope.setDIVHeight();
        });

        $(window).resize(function () {
            $scope.setDIVHeight();
        });

    })

    $scope.setDIVHeight = function() {
        var theDivCode =  $('.assets .fix-tab #code');
        var theDivReview =  $('.assets .fix-tab #review');

        var Divtop = $('.assets .fix-tab').offset();

        var divTop = Divtop.top;

        // var winHeight = $(window).height();

        var winHeight = screen.height;

        var divHeight = winHeight - divTop - 315;

        theDivCode.attr('style', 'height: ' + divHeight + 'px!important;overflow:auto'  );
        theDivReview.attr('style', 'height: ' + divHeight + 'px!important;overflow:auto'  );
    }

    /**
     * [setFields description]
     */
    var setFields = function() {
        $scope.fieldsConfig = []; // set default fields config
        for(var key in $scope.fields) {
            variable = angular.copy($scope.fields[key]['variable']);
            if (angular.isDefined($scope.fieldsHaveConfigured[variable])) {
                $scope.fieldsConfig.push($scope.fieldsHaveConfigured[variable]); // set fiedls config
            }
        }
    }
    var showLoading = function() {
        angular.element('#page-loading').css('display','block');
    }
    var hideLoading = function() {
        angular.element('#page-loading').css('display','none');
    }
    showLoading();
    /**
     * active manage block
     * @return {[type]} [description]
     */
    $scope.activeManageBlock = function(validate)
    {
        if (Object.keys(angular.extend({}, $scope.curFields)).length) {
            formatDataFileDate($scope.curFields);
        }
        
        if ($scope.isDetail && !validate) {
            $scope.successForm[1] = true;
        }

        $scope.submitted = false; // default submitted
        showLoading();
        if ($scope.isChangeDataMirror && !$scope.parsedContent) {
            parseContentBlock($scope.editableCodeMirror.getValue()  , false, function(result) {
                delete $scope.isChangeDataMirror;
                if (result.blocks.length == 0 && result.fields.length == 0) {

                    $scope.isShowManageBlock = false;
                    $('#mytab a[href="#content"]').tab('show');
                    hideLoading();
                } else {
                    showForm();
                }
            });
        } else {

            showForm();
        }
       
    }

    /**
     * [formatDataFileDate description]
     * convent field data is date to format yyyy-mm-dd
     *
     * @author [bang@httsolution.com]
     * 
     * @param  {[type]} fields [field data of page]
     * @return {[type]}        [description]
     */
    function formatDataFileDate(fields) {
        
        (function(fields) {
            for (var key in fields) {
                if ((angular.isArray(fields[key]) && fields[key].length || angular.isObject(fields[key]) && Object.keys(fields[key]).length)) {
                    formatDataFileDate(fields[key]);
                } else if (angular.isDate(fields[key])) {
                    fields[key] = $filter('date')(fields[key], 'yyyy-MM-dd');
                }
            }
        })(fields)

    }
    /**
     * [showForm description]
     * @author  than@httsolution
     * @return {[type]} [description]
     */
    var showForm = function(submit) {
        if ($scope.fields.length > 0) {
            fieldConfig = getFieldsToConfig(); // get fieldconfig
            if (fieldConfig.length > 0) {  // exits field config
                hideLoading();
                //function
                configField(fieldConfig, submit);
            }else{ 
                hideLoading();
                
                $scope.getModalShowListConfigFields(function(fields) {
                    if(angular.isDefined(fields) || angular.isDefined($scope.block.fields)) {

                        if (angular.isUndefined(fields)) {
                            fields = angular.copy($scope.block.fields);
                        }

                        //function
                        callFunctionHtmlFieldCms(fields, submit);
                    }

                }, $scope.block.fields);
            }
        }else{
            // // $scope.fieldConfig = [];
            // $scope.fieldsConfig = []; // set empty fieldsConfig when content is not fields
            // getHtmlFieldsCms(submit, function(result){
            //     if (angular.isUndefined(submit) || !submit) {
            //         hideLoading();
            //     }
            // });// call function get html fields

            //function
            callFunctionHtmlFieldCms(false, submit);
            $scope.fieldsHaveConfigured = [];// set empty fieldsHaveConfigured when content is not fields

        }
        // hideLoading();
    }

    /**
     * [configField description]
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @return {[type]} [description]
     */
    function configField(fieldConfig, submit) {
        $scope.configFields(function(valueResult) {
            // call function edit field config
            if (angular.isDefined(valueResult)) {

                for(var key in valueResult) {
                    $scope.fieldsHaveConfigured[valueResult[key]['variable']] = valueResult[key];
                }
                
                $scope.getModalShowListConfigFields(function(fields) {

                    if (angular.isUndefined(fields)) {
                        fields = angular.copy(valueResult);
                    }

                    if(angular.isDefined(fields) || angular.isDefined($scope.block.fields)) {
                        //function
                        callFunctionHtmlFieldCms(fields, submit);
                    }

                }, valueResult);
            } else {
                if (angular.isUndefined(submit) || !submit) {
                    hideLoading();
                }
            }


        }, fieldConfig);
    }

    /**
     * [callFunctionHtmlFieldCms description]
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _fields [description]
     * @param  {[type]} _submit [description]
     * @return {[type]}         [description]
     */
    function callFunctionHtmlFieldCms(_fields, _submit) {
        if (angular.isDefined(_fields) && _fields) {
            $scope.fieldsConfig = _fields;
            showLoading(); // show loading page
        } else {
            $scope.fieldsConfig = [];
        }

        getHtmlFieldsCms(_submit, function(result){
            if (angular.isUndefined(_submit) || !_submit) {
                hideLoading();
            }
            setFields();
        });// call function get html fields
    }
    /**
     * set actions when in manage
     * @return {[type]} [description]
     */
    var actionsInMangeFields = function() {
        $scope.finishConfigFields = true;
        hideLoading(); // hide loading

        if (angular.isUndefined($scope.block._id)) {
            $scope.isManage = true; // show isManage fields
        }

        $scope.isDetail = false;// hide detail 
        $scope.isContent = false;// hide content
        angular.element('#event-manage').trigger('click');        
    }
    /**
     * show detail
     * @param  {[type]} validate [description]
     * @return {[type]}          [description]
     */
    $scope.showDetail = function (validate) {        
        showLoading();
        if ($scope.isDetail && !validate) {
            $scope.successForm[1] = true;
        }
        if ($scope.isManage && !validate) {
            $scope.successForm[0] = true;
        }
        $scope.submitted = false;
        $scope.isDetail = true;
        $scope.isContent = false;
        $scope.isManage = false;
        $scope.isDetail = true;
        hideLoading();

    };
    /**
     * get fields to config
     * @return {[type]} [description]
     */
    var getFieldsToConfig = function()
    {
        var fieldConfig = [];
        for(var key in $scope.fields) {
            if (angular.isDefined($scope.fieldsHaveConfigured[$scope.fields[key]['variable']])) {

            }else{
                fieldConfig.push($scope.fields[key]); // set field        
            }
        }
        return fieldConfig;
    }
    /**
     * get html fields blocks inject and fields current block
     *
     * @author  Minh than
     * @return {[type]} [description]
     */
    var getHtmlFieldsCms = function(submit, callback) {

        $scope.baseId = 'current_block';
        if(angular.isDefined($scope.block.base_id)) {
            
            $scope.baseId = $scope.block.base_id;
        }
        console.log('$scope.fieldsConfig', $scope.fieldsConfig);
        var content_id = null;
        if (angular.isDefined($scope.block._id)) {
            content_id = $scope.block._id;
        }
        BlockManagerService.getHtmlFieldsCms({'blockIds':$scope.block.injects, 'fields':$scope.fieldsConfig, 'base_id' : $scope.baseId, 'content_id':content_id}).then(function(data) {

            $scope.listValueFieldRequired = data['dataFieldValidate']['listFieldRequired']['fieldRequiredIsValid'];
            $scope.term = data['dataFieldValidate']['term'];

            $scope.fieldsBlockInjects = [];
            
            // if exits fields current block then prioritize show fields current block 
            if (data.fields.length > 0) {
                $scope.isShowFieldCurrentBlock = true;// show fields current block
                $scope.isShowFieldBlockInject = false;// hide fields block injec
                if (angular.isUndefined(submit) || !submit) {
                    $scope.chooseFieldsCurrentBlock(); // choose current block
                }
            } else {
                // if exits fields block inject 
                if (data.fieldsBlocks.length > 0) {
                    $scope.isShowFieldBlockInject = true; // show fields block inject
                    if (angular.isUndefined(submit) || !submit) {
                        $scope.chooseBlockInject(0, data.fieldsBlocks[0]['_id']); // set default active block inject
                    }
                }
            }
            $scope.block.fields = data.fields; // set fields current block
            $scope.fieldsBlocks = data.fieldsBlocks; // set fields block inject
            // brower fields block inject then set default form success inject block
            for(var key in data.fieldsBlocks) {
                $scope.fieldsBlocksMap[data.fieldsBlocks[key]['_id']] = data.fieldsBlocks[key]['fields'];
                for(var i in data.fieldsBlocks[key]['fields']) {
                    $scope.fieldsBlockInjects.push(data.fieldsBlocks[key]['fields'][i]);
                }
                if (angular.isUndefined($scope.successInjectBlock[data.fieldsBlocks[key]['_id']])) {
                    $scope.successInjectBlock[data.fieldsBlocks[key]['_id']] = false; // defalut successInjectBlock to validate
                }
            }

            


            if (angular.isDefined(callback)) {
                callback.call(true, true);
            }


        }).then(function() {
            if (angular.isDefined(submit) && submit) { // submit
              $scope.addNewBlockManage();
            }else{
              $timeout(function() {
                  actionsInMangeFields(); // actions in manage fields
                
              });
            }
            if ($scope.isLoadingEdit) {
                $scope.isLoadingEdit = false;
                if (angular.isUndefined($scope.block._id)) {
                    $scope.isManage = true; // show isManage fields
                }
            }

            if (angular.isDefined(callback)) {
                callback.call(true, true);
            }
        })   
    }

    /**
     * callModalInsert      [function]
     * show model           [description]
     *
     * @auth   tuan@httsolution.com, bang@httsolution.com
     * @param  [typeInsert]    [type: block, asset, link,..]
     * @param  [language]
     * @param  [region]
     *
     * add data to content of block when insert completed
     */
    $scope.callModalInsert = function (typeInsert, language, region, notShowFieldBlock,id) {
        /* Call Modal Popup To Insert With Input Type */
        var teamplate = '/cms/block-manager/insert' + '?language=' + language + '&&region=' + region + '&&type=' + typeInsert + '&&notShowFieldBlock=' + notShowFieldBlock +'&&id='+id;
        var modalInstance = $modal.open({
                templateUrl: window.baseUrl + teamplate,
                controller: 'ModalInsertCms',
                size: undefined,
                resolve: {
                    blockId: function() {
                    },
                    language: function() {
                        return null;
                    },
                    region: function() {
                        return null;
                    },
                    listField: function() {
                    }
                }
            });
        modalInstance.result.then(function (data) {

            $timeout(function() {
                $scope.editableCodeMirror.replaceSelection(data);
                parseContentBlock($scope.editableCodeMirror.getValue(), false, function(result){
                    hideLoading();
                });
            });
        });
    }

    function parseContentBlock(curContent, submit, callback) {
        // call server parse content block
        BlockManagerService.parseContentBlock({content: curContent, type:'block'}).then(function(result) {

            $scope.fields = []; // set default fields
            $scope.block.injects = [];// set default injects
            if (!angular.isUndefined(result.assets)) {
              $scope.block.assets = result.assets;
            }
            if (result.blocks.length > 0) { // check exits blocks inject
                $scope.block.injects = result.blocks; // set inject block
                $scope.isShowManageBlock = true; // show inject manage
                for(var key in result.blocks) {
                    if (angular.isUndefined($scope.exitsInject[result.blocks[key]])) {
                        $scope.successForm[0] = false;// set default success Form of manage fields is false
                    }
                }
            }
            if (result.fields.length > 0) {// check fields in current blocks

                $scope.fields = result.fields; // set fields current block
                $scope.isShowManageBlock = true; // show manage block
                for(var key in result.fields) {
                    if (angular.isUndefined($scope.fieldsHaveConfigured[result.fields[key]['variable']])) {
                        $scope.successForm[0] = false; // set default success Form of manage fields is false
                        $scope.successFieldsCurrentBlock = false;
                        break;
                    }
                }
            } else {
                $scope.fields = [];
                $scope.block.fields = {};
            }

            if (angular.isDefined(callback)) {
                callback.call(true, result);
            }
        });
    }
    /**
     * [chooseFieldsCurrentBlock description]
     *
     * @author Minh than
     * @return {[type]} [description]
     */
    $scope.chooseFieldsCurrentBlock = function() {
        $scope.activeBlockTab = [];

        if (Object.keys(angular.extend({}, $scope.curFields)).length) {
            formatDataFileDate($scope.curFields);
        }

        if(angular.isDefined($scope.block.base_id)) {

            $scope.currentBlockInject = $scope.block.base_id
        } else {

            $scope.currentBlockInject = 'current_block';
        }

        showLoading();

        getDataBlock($scope.currentBlockInject, 'current', function(result) {
            $scope.warningError = false;
            // $scope.submitted = false;
            $scope.isManage = true;
            $scope.isShowFieldCurrentBlock = true; // is show fields current block
            $scope.isShowFieldBlockInject = false; // is hide fields block inject

            $timeout(function() {
                expandBlockElementError();                
            })

            hideLoading();

        });
    }
    /**
     * choose block inject
     * @param  {[type]} item  [description]
     * @return {[type]}       [description]
    */
    $scope.chooseBlockInject = function(index, id) {
        if (Object.keys(angular.extend({}, $scope.curFields)).length) {
            formatDataFileDate($scope.curFields);
        }

        showLoading();
        
        getDataBlock(id, 'inject', function(result) {
            $scope.activeBlockTab = [];
            $scope.activeBlockTab[index] = true;
            $scope.warningError = false;
            $scope.currentIndexBlockInject = index; // index curent block inject
            // $scope.submitted = false;
            $scope.currentBlockInject = id; // set current block choose
            $scope.isShowFieldBlockInject = true; // is show fields block inject
            $scope.isShowFieldCurrentBlock = false; // is hide current field 
            $scope.isManage = true;

            $timeout(function() {
                expandBlockElementError();                
            })

            hideLoading();
        });

    }
    /**
     * [validateCurrentForm description]
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} validate [description]
     * @return {[type]}          [description]
     */
    $scope.validateCurrentForm = function(validate) {
        $scope.warningError = false;
        var success = false; // default success 
        if (!validate) {// check current form success
            success = true;
        }
        if ($scope.isShowFieldCurrentBlock) {
            $scope.successFieldsCurrentBlock = success;// set form fields current block success
        }else{
            if (angular.isDefined($scope.currentBlockInject)) {
                $scope.successInjectBlock[$scope.currentBlockInject] = success;// set form current inject block success
            }
        }

        var _contentBlock = $scope.contentBlock['_' + $scope.currentBlockInject];
        var _currentListFieldRequired = $scope.listValueFieldRequired[$scope.currentBlockInject];

        if (angular.isDefined(_contentBlock) && angular.isDefined(_contentBlock['data']) && angular.isDefined(_contentBlock['data']['fields'])) {

            $scope.updateStatusFieldRequired(_currentListFieldRequired, _contentBlock['data']['fields'], $scope.currentBlockInject);
        }
    }
    /**
     * Show value content in description
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void [description]
     */
    $scope.showValueContent = function (validate) {
        if ($scope.isDetail && !validate) {
            $scope.successForm[1] = true;
        }
        showLoading();
        $scope.warningError = false;
        $scope.submitted = false;
        $scope.isContent = true; // is show content mirror
        $scope.isDetail = false;// is hide detail block
        $scope.isManage = false;// is hide manage fields
        $timeout(function() {
            $scope.editableCodeMirror.refresh();
            hideLoading();
        }, 700);
    }

    // setup variable for date picker
    $scope.format = 'MM-dd-yyyy'; //set date fomat 
    $scope.minDate = new Date();
    $scope.submitted  = false;
    $scope.showField  = false;
    $scope.showLoad  = false;

    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches

    /* Open calendar when create page*/
    $scope.open = function($event, type) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = {};
        $scope.opened[type] = true;
    };

    CodeMirror.markClean = function() {
        alert("Content Changed");
    };

    $scope.contentBlock = {};

    $scope.currentReviewBlockUrl = '';

    // when load page create block then show default code
    $scope.isShowCode = true;
    /**
     * show code in content
     * @return {[type]} [description]
     */
    $scope.showCodeBlock = function()
    {
        $scope.isShowCode = true;

        $scope.isShowReView = false;
    }
    /* When user click delete thumbnail */
    $scope.removeThumbnail = function() {

        if (!confirm('Do you want delete this image?')) return;

        delete $scope.block.thumbnail;
    }

    $scope.submit = function(validate)
    {
        $scope.submitted = true;

        $scope.warningErrorMissDataField = false;


        if (validate) {

            var _idParentElement = $('form[name="formData"]').find('.ng-invalid:eq(0)').closest('div.tab-pane').attr('id');

            if (!$scope.activeTabError(true) && angular.isDefined(_idParentElement) && _idParentElement == 'detail') {

                // if (typeof $('#mytab a[href="#' + _idParentElement + '"]') != 'undefined'
                    // && $('#mytab a[href="#' + _idParentElement + '"]').length){

                    $('#mytab a[href="#detail"]').tab('show');
                    $scope.isDetail = true;
                // }
            }

            //function
            expandBlockElementError();

            $(".ng-invalid:eq(1)").focus();

            showHideWarning('#show-warning')
            return;
        }
        if ($scope.requiredEditorContent) {

            $('#mytab a[href="#content"]').tab('show');

            $scope.requiredEditorContent = true;
            $scope.isContent = true;
            $scope.saving = false;

            showHideWarning('#show-warning');

            return;
        }

        if ($scope.isShowManageBlock && $scope.isManage) {
            if ($scope.activeTabError(true)) {
                $scope.listErrorListFile = [];
                showHideWarning('#show-warning')
                return;
            }
            if ($scope.checkMinimumFieldOfBlock()) {
                $('#show-warning').addClass('hidden');
                return;

            }
        }

        if (!$scope.isChangeDataMirror || $scope.parsedContent) {

            var hasFieldConfig = getFieldsToConfig();

            if (hasFieldConfig.length)  {
                showForm(true);
            } else {
                $scope.addNewBlockManage();
            }
        } else {
            showLoading();
            parseContentBlock($scope.editableCodeMirror.getValue(), true, function(result){

                $scope.parsedContent = true;

                // hideLoading();
                if (result.fields.length != 0) {
                    showForm(true);
                } else {
                    $scope.addNewBlockManage();
                }

                $scope.isChangeDataMirror = false;
            });
        }
    }

    /**
     * [showHideWarning description]
     * show hide warning when submit data
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _keyElement [id or class of element]
     * @return {[type]}             [description]
     */
    function showHideWarning(_keyElement) {

        if (angular.isDefined($(_keyElement)) && $(_keyElement).length) {

            $(_keyElement).stop( true, true ).fadeOut();

            $(_keyElement).fadeIn(function() {
                
               $(_keyElement).fadeOut(5000);
            })            
        }
    }

    /**
     * [getElementAndActiveTogle description]
     * get parent element contant element error and expand that emlement
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} currentEl [parent element contant element error]
     * @return {[type]}           [description]
     */
    function getElementAndActiveTogle(currentEl) {

        var _parentEl = currentEl.parent().find('[data-toggle="collapse"]');

        //passing each element contant attribute [data-toggle="collapse"]
        //get value of attribute "data-target";
        _parentEl.each(function() {
            var _attrValue = $(this).attr('data-target');

            //declare regex
            var re = new RegExp('(\.|#)');

            //replace character "." or "#" to empty
            _attrValue = _attrValue.replace(re, '');

            //check currentEl exist class or id that same value of attribute "data-target" of current element?
            if (currentEl.hasClass(_attrValue) || currentEl.attr('id') == _attrValue) {
                //click current element
                $(this).trigger('click');
                return true;
            }
        });

        return false;
    }

    /**
     * [expandBlockElementEror description]
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} currentElement [description]
     * @return {[type]}                [description]
     */
    function expandBlockElementError() {

        var _currentElement = $('form[name="formData"]').find('.ng-invalid:eq(0)');

        if (_currentElement.length) {
            //recursive function
            (function callBack(currentElement){
                //check parent of current element is form?
                if (!currentElement.parent().is('form')) {

                    currentElement = currentElement.parents('.collapse:not(.in)');

                    //check exist block element contant class .collpse and not exist class .in?
                    if (currentElement.length){
                        //call function getElementAndActiveTogle to expand current element
                        if (getElementAndActiveTogle(currentElement)) {                        
                            return;
                        } else {
                            //call recursive function again
                            callBack(currentElement);
                        }
                    }
                }
            })(_currentElement)

            focusFieldError();
        }

        return;
    }

    /**
     * [focusFieldError description]
     * focus to element error
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _elementError [description]
     * @return {[type]}               [description]
     */
    function focusFieldError() {

        var _elementError = $('form[name="formData"]').find(".ng-invalid:eq(0)");

        //scroll to emlemt is div, span,... that's value is invalid
        if (_elementError.is('div')) {

            $offsetTopOfCurrentDiv = _elementError.offset().top; // get location of current element to top
            $('body').scrollTop($offsetTopOfCurrentDiv - 150); // scroll to element error (150 is height of navibar)
        } else if (_elementError.is('textarea')) {//scroll to element texarea use plugin redactor is invalid.

            var parentDiv = _elementError.parent();//get parent element contain current textarea
            var isRedactor = parentDiv.find('div.redactor-editor').length; //check exist div that be created by redactor plugin?

            if (isRedactor) {
                $offsetTopOfCurrentDiv = parentDiv.offset().top;
                $('body').scrollTop($offsetTopOfCurrentDiv - 150);
            }
        } else if (_elementError) {
            $offsetTopOfCurrentDiv = _elementError.offset().top; // get location of current element to top
            $('body').scrollTop($offsetTopOfCurrentDiv - 150); // scroll to element error (150 is height of navibar)
        }

        _elementError.focus(); //focus to first element is invalid
    }

    /**
     * Create new block manager
     * 
     * @author ? update by Thanh Tuan <tuan@httsolution.com>
     */
    $scope.addNewBlockManage = function() {

        $scope.saving = true;
        showLoading();
        $scope.block.content = $scope.editableCodeMirror.getValue(); // set content block

        $scope.block.type = 'managed_block';

        //function
        formatDateValueContentPage($scope.contentBlock)

        $scope.block.contentBlock = $scope.contentBlock;
        // call server to save content block
        BlockManagerService.addNew($scope.block).then(function(data) {
            if (data['status']) {
                window.location.href = window.baseUrl + '/cms/block-manager/set-block-selected/' + data.block.folder_id;
            } else {
                $scope.saving = false;
            }
        });
    }

    /**
     * [formatDateValueContentPage description]
     * format date for field is object date in content page
     *
     * @author [bang@httsolution.com]
     * @param  {[type]} nestedData [description]
     * @return {[type]}            [description]
     */
    function formatDateValueContentPage(contentBlock) {
        for (var key in contentBlock) {
            //check exit fields in current content page
            if (angular.isDefined($scope.contentBlock[key])
                && angular.isDefined($scope.contentBlock[key]['data'])
                && angular.isDefined($scope.contentBlock[key]['data']['fields'])) {

                formatDataFileDate($scope.contentBlock[key]['data']['fields']);
            }
        }
    }

    $scope.cancel = function () {

        // window.location.href = window.baseUrl + '/cms/block-manager';

    };

    /**
     * get data block
     *
     * @author Minh than
     * @param  {[type]}   indexBaseId [index base current id]
     * @param  {[type]}   type        [type inject pr current block]
     * @param  {Function} callback    [callback function]
     * @return {[type]}               [description]
     */
    function getDataBlock(indexBaseId, type, callback) {

        var _indexBaseId = '_' + indexBaseId;
        if(angular.isUndefined($scope.cacheDataBlock[_indexBaseId])) {
            var content_id = null;
            if(angular.isDefined($scope.block._id)) {
                content_id = $scope.block._id; // content id if page edit
            }
            // set data to get data block
            var data = {'index_base_id': indexBaseId,'content_id' : content_id,'type' : type};
            
            BlockManagerService.getDataBlock(data).then(function(data) {
                // convert data in content block form array to object
                data.result[_indexBaseId]['data']  = angular.extend({}, data.result[_indexBaseId]['data']);
                // convert data fields in content block form array to object
                data.result[_indexBaseId]['data']['fields'] = angular.extend({}, data.result[_indexBaseId]['data']['fields']);
                // assigne data.result to content block
                $scope.contentBlock[_indexBaseId] = data.result[_indexBaseId];
                $scope.cacheDataBlock[_indexBaseId] = $scope.contentBlock[_indexBaseId];
                if(type == 'current') {

                    synchFields(data.result[_indexBaseId]['data']['fields'], indexBaseId, $scope.block.fields, type);

                } else {
                    synchFields(data.result[_indexBaseId]['data']['fields'], indexBaseId,  $scope.fieldsBlocksMap[indexBaseId], type);
                }

                if(angular.isDefined(callback)) {
                    callback.call();
                }
            }).then(function(data) {
                if(angular.isDefined(callback)) {
                    callback.call();
                }
            });
        } else {
            if(angular.isDefined(callback)) {
                callback.call();
            }
        }


    }

    $scope.closeAlert = function() {
        $scope.warningErrorMissDataField = false;
    }
}])
