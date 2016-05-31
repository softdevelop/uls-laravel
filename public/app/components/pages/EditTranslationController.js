var pageApp = angular.module('pageApp');

pageApp.controller('EditTranslationController', ['$scope', '$modal', '$filter', '$http','$window', '$timeout', '$compile', 'Upload','$controller','TranslationEditorService','BlockNestedService', 'RemoveCacheService',
    function ($scope, $modal, $filter, $http, $window, $timeout, $compile, Upload, $controller,TranslationEditorService, BlockNestedService, RemoveCacheService) {

    angular.element('#page-loading').css('display', 'block');
    angular.element('.wrap-content-management').removeClass('hidden');
    $scope.variableMapNameFieldsMulti = window.variableMapNameFieldsMulti;
	//old contetn of page
    $scope.pageOld = angular.copy(window.content);
    $scope.pageOld.data = angular.copy(window.dataContentpage);
    // console.log('$scope.pageOld', $scope.pageOld);
    $scope.pageOld.blockContent = window.blockTranslations;
    $scope.nested_block = window.dataNesteds;
    $scope.dataNestedOlds = window.dataNestedOlds;
    $scope.pageOld.nested_block = window.dataNestedOlds;
    //get template id of current page
    if(typeof $scope.pageOld.template_id != 'undefined') {
        $scope.currentChosseTemplate  = $scope.pageOld.template_id;
    }

    $scope.isShowPage = true; // show page
    $scope.isShowBlocks = false; // show blocks
	$scope.listLanguageName = window.listLanguageName;

	$scope.page = angular.copy(window.page);
    
	$scope.page.fields = {};
    $scope.page.sections = {};
    $scope.cacheNestedContend = {};
    $scope.curFields = {};
	$scope.template = window.template;
    $scope.listTemplate = window.listTemplate;

    $scope.listBlockMapData = angular.copy(window.blockMapFileld);
	$scope.multiFieldFollowVariable = [];
    $scope.blockTranslations = window.blockTranslations;
    $scope.initBlocks = false;
    $scope.page.blockContent = {};
    $scope.page.language = $scope.pageOld.language;
    $scope.page.region = $scope.pageOld.region;
    $scope.contentPage = window.contentPage;
    $scope.sections = {};
    $scope.allSections = [];
    $scope.isDisable = window.isDisable;

    for(var key in $scope.listTemplate) {
        // check is defined
        if(angular.isDefined($scope.listTemplate[key]['sections'])) {
            for(var i in $scope.listTemplate[key]['sections']) { // brower sections 
                var tmpSection = $scope.listTemplate[key]['sections'][i]; // tmp sections
                $scope.allSections[tmpSection['variable']] = key; // get map all section template
            }
        }
    }

    for(var key in $scope.contentPage) {

        $scope.contentPage[key].data = {};
        $scope.contentPage[key].data.fields = {};
        $scope.contentPage[key].data.sections = {};
    }
    //init codemirror
    $scope.initCodeMirror = function (key, content) {
        $scope.codeMirrorInited = true;

            $timeout(function () {
            $scope['editableCodeMirror_'+ key ] = CodeMirror.fromTextArea(document.getElementById('editor_'+key), {
                mode:  "htmlmixed",
                theme: "night",
                styleActiveLine: true,
                lineNumbers: true
            });
            //when change code in codemirror then validate
            $scope['editableCodeMirror_'+ key ].on("change", function() {
                    $timeout(function(){
                        $scope.$apply(function(){
                            var content = $scope['editableCodeMirror_'+ key ].getValue();
                            $scope['requiredEditorContent_'+ key ] = false;
                            //check validate
                            if (content == '') {
                                 $scope['requiredEditorContent_'+ key ] = true;
                            }
                            $scope.validateCurrentForm( $scope['requiredEditorContent'+ key ]);

                            $scope.sections[key] = content;
                        });
                    });
                });
            });
    }

    $scope.initCodeMirrorBlock = function (key, content) {

        $scope.codeMirrorInited = true;
            // for(key in $scope.pageOld.data.sections){
            $timeout(function () {
            $scope['editableCodeMirror_'+ key ] = CodeMirror.fromTextArea(document.getElementById('editor_'+key), {
                mode:  "htmlmixed",
                theme: "night",
                styleActiveLine: true,
                lineNumbers: true
            });

            if(angular.isDefined(content) && content != null){

                $scope['editableCodeMirror_'+ key ].setValue(content);
            }
            //when change code in codemirror then validate
            $scope['editableCodeMirror_'+ key ].on("change", function() {
                    $timeout(function(){
                        $scope.$apply(function(){
 
                            var content = $scope['editableCodeMirror_'+ key ].getValue();
                            $scope['requiredEditorContent_'+ key ] = false;
                            //check validate
                            if (content == '') {
                                 $scope['requiredEditorContent_'+ key ] = true;
                            }
                            $scope.validateCurrentForm( $scope['requiredEditorContent'+ key ]);

                            $scope.blockTranslations[key]['content'] = content;
                        });
                    });
                });
            });
    }
    if (typeof $scope.pageOld != 'undefined' && $scope.pageOld.data != null) {
        for(var key in $scope.pageOld.data.sections) {
            $scope.initCodeMirror(key);
            $scope['requiredEditorContent_'+ key ] = true;
        }
    }
    

    /*count field added of multiple fields*/
    $scope.countFieldsOfMultiField = [];

    $scope.curLanguage = angular.copy(window.content.language);

    $scope.region = angular.copy(window.content.region);

	$scope.baseUrl = window.baseUrl;

	$scope.listOutTypeMap = angular.copy(window.listOutTypeMap);
	$scope.listCheckBoxMap = angular.copy(window.listCheckBoxMap);

	$scope.countUpdate =0;
	$scope.curIdTemplate = 0;
	$scope.file_fields = [];

    $scope.exitsFieldBlock = [];

	$scope.listFileFollowId = window.listFileFollowId;

    if (angular.isDefined($scope.page.template)) {
        $scope.curIdTemplate = $scope.page.template;
        $scope.currentChosseTemplate = angular.copy($scope.page.template);
        contructDefaultVal($scope.listTemplate[$scope.page.template], function(){
            angular.element('#page-loading').css('display', 'none');
        });
    }
   /**
     * [synchFields description]
     * get list fields is multitple and count field to show in view agian
     * and check fields of current template is required?
     *
     * @author [bang@httsolution.com]
     * 
     * @param  {[type]} oldFields [field's value of template(s) in page]
     * 
     * @param  {[type]} id        [description]
     * @param  {[type]} listField  [list field]
     * @param  {[type]} _listFieldRequired  [contain field is requred]
     * @return {[type]}           [description]
     */
    function synchFields(oldFields, id, listField) {

        for (var i in listField) {
            var oldValueField = oldFields['_' + id + '_' + listField[i].variable]; //get value of current field
            if (angular.isDefined(oldValueField) && (angular.isArray(oldValueField) || angular.isObject(oldValueField)) && listField[i].multiple) {

                for (var f in oldValueField) {
                    if (angular.isUndefined($scope.multiFieldFollowVariable['_' + id + '_' + listField[i].variable])) {

                        $scope.multiFieldFollowVariable['_' + id + '_' + listField[i].variable] = [{'id':listField[i].variable+f, 'key_field':f}];

                        updateFieldsOfMuitiField('add','_' + id + '_' + listField[i].variable);

                    } else {

                        $scope.multiFieldFollowVariable['_' + id + '_' + listField[i].variable].push({'id':listField[i].variable+f, 'key_field':f});

                        updateFieldsOfMuitiField('add','_' + id + '_' + listField[i].variable);
                    }

                    if (listField[i]['type'] == 'asset') { // map url asset
                        $scope.getUrlImageAsset(oldValueField[f]);// get url asset item field
                    }
                }
            }

        }
    }
    /**
     * load default data in page translation
     * @param  {[type]} template [description]
     * @return {[type]}          [description]
     */
    function contructDefaultVal(template, callback) {

        if (angular.isUndefined($scope.page)) {
            $scope.page = {};
        }
        $scope.page.fields = {}; // defalt fields in page

        $scope.multiFieldFollowVariable = {}; // default fields multi follow  variable
        var oldFields = $scope.pageOld.data.fields;
        if(angular.isDefined(template)) {
            if(angular.isDefined(template['extends'])){ // if template exits extends
                // brower template extends
                for(var key in template['extends']){
                    if(angular.isDefined(template['extends'][key]['fields'])){
                        // set fields current extends template
                        // setMultiFieldFollowVariable(template['extends'][key]['fields'], key);
                        synchFields(oldFields, key, template['extends'][key]['fields']);
                    }

                }
            }
            if(angular.isDefined(template['injects'])){
                // brower template extends
                for(var key in template['injects']){
                    if(angular.isDefined(template['injects'][key]['fields'])){
                        $scope.curSecIndex = key;
                        // set fields current extends template
                        if(template['injects'][key]['fields'].length > 0){
                            $scope.exitsFieldBlock[key] = true;
                        }
                        synchFields(oldFields, key, template['injects'][key]['fields']);
                    }

                }
            }
            if (angular.isDefined(template['fields'])) {
                // set fields current template
                synchFields(oldFields, $scope.curIdTemplate, template['fields']);

            }
        }
        if (angular.isDefined(callback)) {
            var callbackData = callback.call();
        }
        console.log('z');
    }
    
    $scope.showPage = function()
    {
        $scope.isShowBlocks = false;
        $scope.isShowPage = true;
    }

    $scope.showBlocks = function()
    {
        if(!$scope.initBlocks){

            for(var key in $scope.blockTranslations) {
                $scope.initCodeMirrorBlock(key, $scope.blockTranslations[key]['content']);
            }
            $scope.initBlocks = true;
        }
        $scope.isShowPage = false;
        $scope.isShowBlocks = true;
    }
    /*
     *set default value field, apply when change template or create new page
     *
     * @author [minh than, Nguyen Kim Bang] <than@httsolution.com, bang@httsolution.com>
     *
     * @param _id     [id template]
     *
     * @return void
     */
    function setMultiFieldFollowVariable(listFiled, id) {
        for (var i in listFiled) {
            $scope.page.fields['_'+ id + '_' + listFiled[i].variable] = null;

            if (listFiled[i].multiple) {

                updateFieldsOfMuitiField('add', listFiled[i].variable);

                $scope.page.fields['_'+ id + '_' + listFiled[i].variable] = {};
                $scope.page.fields['_'+ id + '_' + listFiled[i].variable][0] = null;
                /**
                *  reset value of fields in template.
                *  id is id of block or template fill current variable
                */
                if (angular.isUndefined($scope.multiFieldFollowVariable['_'+ id + '_' + listFiled[i].variable])) {
                    $scope.multiFieldFollowVariable['_'+ id + '_' + listFiled[i].variable] = [{'id':listFiled[i].variable+0, 'key_field':0}];
                }
            }
        }
    }

    $scope.checkIsArray = function(value)
    {
        if(angular.isArray(value)) return true;
        return false;
    }

    $scope.listsAsset = angular.copy(window.listsAsset);
    $scope.dataOptionMap = angular.copy(window.dataOptionMap);
    $scope.listFileMapTranslate = angular.copy(window.listFileMapTranslate);
    $scope.listMapContentIdWithUrl = angular.copy(window.listMapContentIdWithUrl);

    $scope.validateCurrentForm = function(validate) {
        if($scope.curExtIndex == -1) {
            if(validate) {
                $("#details").find('.status').first().switchClass('fa fa-check-circle','ti-alert');
            } else {
                $("#details").find('.status').first().switchClass('ti-alert','fa fa-check-circle');
            }
        }

        if($scope.curSecIndex == -1) {
            if(validate || $scope.checkMinimunCurFields($scope.currentFields)) {
                $("#fields").find('.status').first().switchClass('fa fa-check-circle','ti-alert');
                $("#ext-"+$scope.extend).find('.status').first().switchClass('fa fa-check-circle','ti-alert');
            } else {
                if($scope.template.fields.length > 0) {

                    $("#fields").find('.status').first().switchClass('ti-alert','fa fa-check-circle');

                    $timeout(function(){
                        $scope.changeStatusOfExtentTemplateBaseChildStatus();

                    },500);
                } else {
                    $("#ext-"+$scope.extend).find('.status').first().switchClass('ti-alert', 'fa fa-check-circle');
                }

            }
        } else {
            if(validate || $scope.checkMinimunCurFields($scope.currentFields)) {
                $("#fields-"+$scope.curSecIndex).find('.status').first().switchClass('fa fa-check-circle','ti-alert');
                $("#ext-"+$scope.extend).find('.status').first().switchClass('fa fa-check-circle','ti-alert');
            } else {
                $("#fields-"+$scope.curSecIndex).find('.status').first().switchClass('ti-alert','fa fa-check-circle');
                $timeout(function(){
                    $scope.changeStatusOfExtentTemplateBaseChildStatus();
                    // var searchElementError = $("#field-section").find('.ti-alert');
                    // if(searchElementError.length > 0) {
                    //     $("#ext-"+$scope.extend).find('.status').first().switchClass('fa fa-check-circle','ti-alert');
                    // }else {
                    //     $("#ext-"+$scope.extend).find('.status').first().switchClass('ti-alert', 'fa fa-check-circle');
                    // }
                },500);
            }
        }
    }

    $scope.changeStatusOfExtentTemplateBaseChildStatus = function () {
        //find child warning
        var searchElementError = $("#field-section").find('.ti-alert');
        //if have warning
        if(searchElementError.length > 0) {
            //set warning for extend template
            $("#ext-"+$scope.extend).find('.status').first().switchClass('fa fa-check-circle','ti-alert');
        } else {
            //set complete status for extend template
            $("#ext-"+$scope.extend).find('.status').first().switchClass('ti-alert','fa fa-check-circle');
        }
    }

    $scope.formatDate = function (data) {
        // Each field
        angular.forEach(data, function(value, key) {
            // If field is date time format then format date time to 'yyyy-MM-dd'
            if ((value instanceof Date) == true) {
                data[key] = $filter('date')(value, 'yyyy-MM-dd');
            } else if (typeof value == 'object') { // Call function to format date time
                $scope.formatDate(value);
            }
        });
    }

    $scope.checkMinimunCurFields = function (fields) {
        if(typeof $scope.currentFields != 'undefined' && $scope.currentFields.length > 0) {
            return checkMinimumField(fields);
        } else {
            return false;
        }
    }


     $scope.formatDate($scope.page.fields);

     var opened = false;
    $scope.callModalInsert = function (sectionKey,typeInsert, language, region, page) {
        $scope.sectionKey = angular.copy(sectionKey);
        /* Call Modal Popup To Insert With Input Type */
        if (opened) return;
        var teamplate = '/cms/block-manager/insert' + '?language=' + language + '&&region=' + region + '&&type=' + typeInsert + '&&site=' + page +'&&id=';
        var modalInstance = $modal.open({
                templateUrl: window.baseUrl + teamplate,
                controller: 'ModalInsertCms',
                size: undefined,
                resolve: {
                    language: function() {
                        return 'en';
                    },
                    region: function() {
                        return null;
                    },
                }
            });
        opened = true;
        modalInstance.result.then(function (data) {
            opened = false;
            $timeout(function(){
                $scope['editableCodeMirror_'+$scope.sectionKey].replaceSelection(data);
            });
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }

    /**
     * [formatFieldIsDate description]
     * convent data from string to object date
     *
     * @author [Nguyen Kim Bang] <bang@httsolution.com>, @tuan@httsolution.com
     *
     * @param  {[type]} data        [list field of current page]
     * @param  {[type]} curTemplate [list field of current template, page's template]
     * @return {[type]}             [description]
     */
    function formatFieldIsDate(data, curTemplate) {
    	var listCurDate = [];
    	for (var i in curTemplate) {
    		//check current field is array? and check current field type is date?
    		if (angular.isArray(data[curTemplate[i].variable]) && curTemplate[i].type == 'date') {
    			for (var j in data[curTemplate[i].variable]) {
    				if (!angular.isArray(data[curTemplate[i].variable][j])) {
    					var tmpDate = data[curTemplate[i].variable][j];
    					if (tmpDate != null) {
    						//check current date is invalid?
	    					if (new Date(tmpDate) == 'Invalid Date') {
	    						//replace characters '-' to '/'
	    						tmpDate = String(tmpDate).replace(/-/gi, "/");
	    					}

	    					if (new Date(tmpDate) != 'Invalid Date' && !window.listMapType[curTemplate[i].field_type]) {
	    						data[curTemplate[i].variable][j] = new Date(tmpDate);
	    					}
    					}
    				}
    			}
    		} else if (!angular.isArray(data[curTemplate[i].variable]) && curTemplate[i].type == 'date') {
				var tmpDate = data[curTemplate[i].variable];
				if (tmpDate != null) {
					if (new Date(tmpDate) == 'Invalid Date') {
						tmpDate = String(tmpDate).replace(/-/gi, "/");
					}
					if (new Date(tmpDate) != 'Invalid Date' && !window.listMapType[curTemplate[i].field_type]) {
						data[curTemplate[i].variable] = new Date(tmpDate);
					}
				}
			}
    	}

		return data;
    }

	/*remove same values*/
	function customFieldData(data) {
		var listFields = angular.copy(data);
		if (angular.isDefined(listFields)) {
			var curF = listFields;
			for ( var i in curF) {
				// if curF[i] is array or object
				if (angular.isArray(curF[i]) || angular.isObject(curF[i])){
					for (var key in curF[i]){
						// if curF[i][key] is array or object
						if (angular.isArray(curF[i][key])||angular.isObject(curF[i][key]) && Object.keys(curF[i][key]).length) {
							curF[i][key] = (angular.isUndefined(curF[i][key]))?null:curF[i][key];

						} else {
							curF[i][key] = (angular.isUndefined(curF[i][key]))?null:curF[i][key];
						}
					}
				}
				listFields[i] = (angular.isUndefined(curF[i]))?null:curF[i];
			}
		}
		return listFields;
	}

	/*
	 * check minimum field of field multiple
	 *
	 * @author [Nguyen Kim Bang] <bang@httsolution.com>
	 *
	 */
	function checkMinimumField(fields) {

		$scope.listErrorListFile = [];

		var max = 0;

		/*get lists field of current template*/
		var curTemp = fields;

		/*get list field of page when submit*/
		// if (angular.isDefined($scope.page)) {
		// 	var curFileds = $scope.page.fields;
		// }

        // if (angular.isDefined(curTemp) && angular.isDefined(curFileds)) {
		if (angular.isDefined(curTemp)) {

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

	/**
	 * remove current thumb nail assert
	 * @param  {[type]} id       [description]
	 * @param  {[type]} variable [description]
	 * @param  {[type]} index    [description]
	 * @return {[type]}          [description]
	 */
	$scope.removeThumbnailAssert = function(id, variable, index) {

		$scope.url[id] = '';

		if(typeof index != 'undefined'){

			$scope.page.fields[variable][index] = null; // remove thumbnail multi

		}else{

			$scope.page.fields[variable] = null;// remove thumbnail not multi
		}

	}

    /*
     * add new field, apply for fields are multiple
     *
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     */
    $scope.addNewField = function(curField, blockId) {
        var id = $scope.curIdTemplate;
        if(typeof blockId != 'undefined'){
            id = blockId;
        }
        $scope.listErrorListFile = [];

        var maxIndex = 0;
        var checkMaxField = 0;

        /**/
        if (angular.isDefined($scope.multiFieldFollowVariable['_' + id + '_' + curField.variable]) && $scope.multiFieldFollowVariable['_' + id + '_' + curField.variable].length) {

            for (var i in $scope.multiFieldFollowVariable['_' + id + '_' + curField.variable]) {

                if ($scope.multiFieldFollowVariable['_' + id + '_' + curField.variable][i].id == curField.variable+$scope.multiFieldFollowVariable['_' + id + '_' + curField.variable][i].key_field) {

                   checkMaxField +=1;

                   if ($scope.multiFieldFollowVariable['_' + id + '_' + curField.variable][i].key_field > maxIndex) {

                        maxIndex =  $scope.multiFieldFollowVariable['_' + id + '_' + curField.variable][i].key_field;
                   }
                }
            }
        }
        /*check maximum fields number, apply for fields multiple*/
        if (checkMaxField >= curField.max_field && curField.max_field) {
            alert('Maximum '+curField.name+' field is '+curField.max_field);
            return
        }

        maxIndex = parseInt(maxIndex)+1;

        $scope.page.fields['_' + id + '_' + curField.variable][maxIndex] = null;

        if (angular.isUndefined($scope.multiFieldFollowVariable['_' + id + '_' + curField.variable])) {
            $scope.multiFieldFollowVariable['_' + id + '_' + curField.variable] = [{'id':curField.variable+maxIndex, 'key_field':maxIndex}];

            updateFieldsOfMuitiField('add', curField.variable);
        } else {
            $scope.multiFieldFollowVariable['_' + id + '_' + curField.variable].push({'id':curField.variable+maxIndex, 'key_field':maxIndex});
            updateFieldsOfMuitiField('add', curField.variable);
        }

    }

    /**
     * [removeCurrentField description]
     *
     * apply for fields are multiple
     *
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     * @param  {[type]} curField [current field]
     * @param  {[type]} index    [location of field]
     *
     * @return {[type]} void         [description]
     */
    $scope.removeCurrentField = function(curField, index, blockId) {
        var id = $scope.curIdTemplate;
        
        if(typeof blockId != 'undefined'){
            id = blockId;
        }
        $scope.listErrorListFile = [];

        var curVal = $scope.multiFieldFollowVariable['_' + id + '_' + curField.variable];

        if (angular.isDefined(curVal) && curVal.length) {

            for (var i in curVal) {

                //check exist current field?
                if (curVal[i].key_field == index && curVal[i].id == curField.variable + curVal[i].key_field) {

                    //remove current field and update list field multiple
                    if (angular.isDefined($scope.page.fields) && angular.isDefined($scope.page.fields['_' + id + '_' + curField.variable])) {

                        $scope.page.fields['_' + id + '_' + curField.variable] = angular.extend({}, $scope.page.fields['_' + id + '_' + curField.variable]);

                        if (angular.isArray($scope.page.fields['_' + id + '_' + curField.variable])) {

                            $scope.page.fields = angular.extend({}, $scope.page.fields);

                        }

                        delete $scope.page.fields['_' + id + '_' + curField.variable][curVal[i].key_field];
                        updateFieldsOfMuitiField('remove', curField.variable);

                    }

                    $scope.multiFieldFollowVariable['_' + id + '_' + curField.variable].splice(i, 1);

                    break;
                }
            }
        }

    }// 

	/**
	 * apply for fields type is upload in current template
	 *
	 * @author [Nguyen Kim Bang] <bang@httsolution.com>
	 *
	 * @param  {[type]} files      [description]
	 * @param  {[type]} variable_f [variable of field]
	 * @param  {[type]} index      [location of current field]
	 * @return {[type]} void           [description]
	 */
	$scope.uploadFileCurTemp = function(files, variable_f, index) {
		if (!files.length) {
			return;
		}

		/**
		* check maximum file size
		*/
		if (files[0]['size'] > maxUpload['size']) {
			if (angular.isUndefined(index)) {
	            $scope.page.fields[variable_f] = null;
			} else {
				$scope.page.fields[variable_f][index] = null;
			}
	        alert('Max file size is ' + maxUpload['name']);
	        return;
	    }

		Upload.upload({
            url: baseUrl + '/admin/file',
            file: files,
        }).progress(function(evt) {

        }).success(function(data, status, headers, config) {
        	if (angular.isDefined($scope.page.fields) && angular.isDefined(index)) {

                /*delare an object that is undefine*/
                if (angular.isUndefined($scope.page.fields[variable_f])) {
                    $scope.page.fields[variable_f] = {};
                }

                if (angular.isUndefined($scope.file_fields[variable_f])) {
                    $scope.file_fields[variable_f] = {};
                }
                // $scope.page.fields[variable_f][index] = 'file_'+data.item.id;
                $scope.page.fields[variable_f][index] = data.item.id;
                $scope.file_fields[variable_f][index] = data.item.file_name;
                if($scope.ngModalFile.indexOf(variable_f) == -1 ){

                    $scope.ngModalFile.push(variable_f);

                }

            } else if (angular.isDefined($scope.page.fields)) {

                if($scope.ngModalFile.indexOf(variable_f) == -1 ){

                    $scope.ngModalFile.push(variable_f);

                }
                $scope.file_fields[variable_f] =  data.item.file_name;
                $scope.page.fields[variable_f] = data.item.id;

            }

	    }).error(function(data) {
	    });
	}

	/*
	 * update (add or remove) field number for multiple fields
	 *
	 * @author [Nguyen Kim Bang] <bang@httsolution.com>
	 *
	 * @action add or remove
	 * @variable variable of fields
	 */
	function updateFieldsOfMuitiField(action, variable) {
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

    //set sections to templates follow template id
    function getSectionOfTemplateWithIdTemplate() {
        for (var key in $scope.sections) {
            if (angular.isDefined($scope.allSections[key])) {

                if (angular.isUndefined($scope.contentPage['_' + $scope.allSections[key]]['data']['sections'])) {

                    $scope.contentPage['_' + $scope.allSections[key]]['data']['sections'] = {};
                }
                $scope.contentPage['_' + $scope.allSections[key]]['data']['sections'][key] = $scope.sections[key];
            }
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

    // function checkFormInvalid() {
    //     if (angular.isDefined($('form[name="formData"]').find(".ng-invalid:eq(0)"))
    //         && $('form[name="formData"]').find(".ng-invalid:eq(0)").length) {

    //         //scroll to emlemt is div, span,... that's value is invalid
    //         if ($('form[name="formData"]').find(".ng-invalid:eq(0)").is('div')) {

    //             $offsetTopOfCurrentDiv = $('form[name="formData"]').find(".ng-invalid:eq(0)").offset().top; // get location of current element to top
    //             $('body').scrollTop($offsetTopOfCurrentDiv - 150); // scroll to element error (150 is height of navibar)
    //         } else if ($('form[name="formData"]').find(".ng-invalid:eq(0)").is('textarea')) {//scroll to element texarea use plugin redactor is invalid.

    //             var parentDiv = $('form[name="formData"]').find(".ng-invalid:eq(0)").parent();//get parent element contain current textarea
    //             var isRedactor = parentDiv.find('div.redactor-editor').length; //check exist div that be created by redactor plugin?

    //             if (isRedactor) {
    //                 $offsetTopOfCurrentDiv = parentDiv.offset().top;
    //                 $('body').scrollTop($offsetTopOfCurrentDiv - 150);
    //             }
    //         } else if ($('form[name="formData"]').find(".ng-invalid:eq(0)")) {
    //             $offsetTopOfCurrentDiv = $('form[name="formData"]').find(".ng-invalid:eq(0)").offset().top; // get location of current element to top
    //             $('body').scrollTop($offsetTopOfCurrentDiv - 150); // scroll to element error (150 is height of navibar)
    //         }

    //         $('form[name="formData"]').find(".ng-invalid:eq(0)").focus(); //focus to first element is invalid
    //     }
    // }
	/**
     * save page's content
     *
     * @auther linh@httsolution.com, bang@httsolution.com
     *
     * @author edit: Quang <quang@httsolution.com>
     *
     * @param  {validate} validate form validate
     *
     */
    $scope.submit = function (validate)
    {
        $scope.submitted  = true;
        $scope.requiredEditorContent = false;
        $scope.requiredEditorContentBlock = false;

        var data = [];
        //get value of code mirror to set for current position
        var sections ={};

        for(var key in $scope.blockTranslations) {

            if($scope['requiredEditorContent_' + $scope.blockTranslations[key]['base_id']]) {
                $scope.requiredEditorContentBlock = true;
                break;
            }
        }
        console.log('validate', validate);
        /* if the user has not entered enough information then return */
        if (validate) {
            expandBlockElementError();
            $scope.isShowPage = true;
            $scope.isShowBlocks = false;
            $('#mytab a[href="#page"]').tab('show');
            $(".ng-invalid:eq(1)").focus();
            return;
        }
        if($scope.requiredEditorContentBlock){
            $scope.isShowBlocks = true;
            $scope.isShowPage = false;
            $('#mytab a[href="#block"]').tab('show');
            $(".ng-invalid:eq(1)").focus();
            return;            
        }

        $('#btnSubmit').attr('disabled', 'true');
        $scope.page._id = $scope.pageOld._id;
        getSectionOfTemplateWithIdTemplate(); // set sections
        $scope.nested_block = (function formatData(nestedData) {//convent array data to object
            for (var _key in nestedData) {
                if (angular.isUndefined(nestedData[_key]['data'])) {
                    formatData(nestedData[_key]);
                } else {
                    nestedData[_key]['data'] = angular.extend({}, nestedData[_key]['data']);
                }
            }
            return nestedData;
        })($scope.nested_block);

        $scope.page.nestedContent = $scope.nested_block;
        $scope.page.blockContent = $scope.blockTranslations;
        $scope.page.contentPage = $scope.contentPage;

        // console.log('$scope.page.contentPage', $scope.page.contentPage);
        TranslationEditorService.saveTranlationEdit($scope.page).then( function (data){
            if (data.status == 0){
                $('btnSubmit').removeAttr('disabled');
            } else {
                window.location = $scope.baseUrl + '/cms/pages/set-page-selected/'+$scope.page.parent_id;
                // RemoveCacheService.removeCache($scope.page.content_id).then(function(){
                // });
            }
        })

    };

    /**
     * [formatDateValueNestedContent description]
     * format date for field is object date in content nested block
     *
     * @author [bang@httsolution.com]
     * @param  {[type]} nestedData [description]
     * @return {[type]}            [description]
     */
    function formatDateValueNestedContent(nestedData) {
        (function formatData(data) {
            for (var _key in data) {
                if (angular.isUndefined(data[_key]['data'])) {
                    formatData(data[_key]);
                } else {
                    formatDataFileDate(data[_key]['data']);
                }
            }
        })(nestedData)
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
     * export excel
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    $scope.export = function (data) {
        if(data.data == null) {
            alert('Data export is empty.');
            return;
        }
        angular.element('#page-loading').css('display', 'block');
        TranslationEditorService.export(data).then(function (data) {
            if(data['status']) {

                $window.location.href = window.baseUrl + '/api/pages/download-export/' + data['fileName'];
                angular.element('#page-loading').css('display', 'none');
            }
        });
    }

    $scope.import = function (files) {

        if (files && files.length) {
            var file = files[0];

            Upload.upload({
                url: window.baseUrl + '/api/pages/import',
                fields: {
                },
                file: file
            }).progress(function (evt) {

                angular.element('#page-loading').css('display','block'); // loading

            }).success(function (data, status, headers, config) {

                if(data['status']) { 

                    if(angular.isDefined(data['pageImport']['data'])) {

                        // get fields content page
                        var contentPage = data['pageImport']['data']['fields'];
                        // brower content page to get data
                        for(var key in contentPage) {
                            // is defined
                            if(angular.isDefined($scope.contentPage[key]) && angular.isDefined(contentPage[key]['data'])) {
                                $scope.contentPage[key]['data'] = {};
                                $scope.contentPage[key]['data'] = angular.copy(contentPage[key]['data']);
                            }
                        }
                        // get section content page
                        $scope.sections = data['pageImport']['data']['sections'];
                        // get content block
                        if(angular.isDefined(data['pageImport']['blockContent'])) {
                           
                           for(key in data['pageImport']['blockContent']) {
                                if(typeof $scope['editableCodeMirror_'+ key] != 'undefined') {
                                    content = data['pageImport']['blockContent'][key]['content']; // content block content
                                    if(angular.isDefined(content) && content != null) {
                                        $scope['editableCodeMirror_'+ key ].setValue(content);
                                        $scope.blockTranslations[key]['content'] = angular.copy(content); // set content block in key
                                    }
                                }
                            }
                        }
                        // nested block
                        if(angular.isDefined(data['pageImport']['nested_block'])){
                            $scope.nested_block = {};
                            $scope.nested_block = angular.copy(data['pageImport']['nested_block']);
                        }

                        //set content for section
                        for(i in $scope.sections) {
                            var content = $scope['editableCodeMirror_'+ i];
                            if(angular.isDefined(content) && content != null) {
                                $scope['editableCodeMirror_'+ i ].setValue($scope.sections[i]);                                
                            }
                        }
                    }                   
                    var elementUpload = $('.file-upload-rowboat');
                    $compile(elementUpload)($scope);      
                }
                
                // $timeout(function() {
                // }, 4000)
            }).then(function(){
                angular.element('#page-loading').css('display','none');
            });
            
        } else {
            $scope.error = "Error";
            angular.element('#page-loading').css('display','none');
        }

        
    };

    $scope.changeLanguage = function(data){
    	$scope.page.language = data;
    }
}])
.controller('addSubBlockNestedCtrl', ['$scope', '$modalInstance','parent_id','content_id','tab_id','index','variable',
 function ($scope, $modalInstance,parent_id,content_id,tab_id,index,variable) {

    $scope.submit= function (block_id) {
        $scope.submitted = true ;
        if(!block_id){
            return;
        }
        var data = [];
        data.sub_block_id = block_id;
        data.parent_id = parent_id;
        data.content_id = content_id;
        data.tab_id = tab_id;
        data.index = index;
        data.variable = variable;
        $modalInstance.close(data);

    }
}])
.filter('fomatField', ['$filter',function($filter) {
    return function(input) {
        var search = input.search("field");
        text = input.substring(search);
        return String(text);
    };
}])