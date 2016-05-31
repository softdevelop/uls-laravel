
var blockApp =  angular.module('BlockApp');

blockApp.controller('ModalInsertCms', ['$scope', '$modalInstance', '$timeout', '$controller', 'CmsContentInsertService', 'AssetManagerService', '$compile', '$filter', 'EditDraftService', 'language', 'region', 'Upload',
		function ($scope, $modalInstance, $timeout, $controller, CmsContentInsertService, AssetManagerService, $compile, $filter, EditDraftService, language, region, Upload) {
	$controller('BaseController', { $scope: $scope });
	//object   group data of block
	$scope.item = {};

	//fill content config fields
	$scope.curFields = {};

	//fill list file name
	$scope.file_fields = [];

	//quantity of fields is multiple
	$scope.countFieldsOfMultiField = [];

	$scope.multiFieldFollowVariable = [];

	/*id of block or asset or link*/
	$scope.currentId = '';

	//list field of block with type blade
	$scope.listField = [];

	$scope.curType = '';
	// $scope.injectAutoIncrement = window.injectAutoIncrement;
    /*
     * @author [Nguyen Kim Bang] <bang@httsolution.com> update by minh than 
     *
     * insert block or asset or link
     *
     * @param type    [block, asset, link]
     *
     * @return string
     */
    $scope.submit = function (type) {
    	console.log('type', type);
        $scope.requireId = false;
        $scope.currentId =  $scope.item.curValue;

        if(typeof $scope.currentId == 'undefined') {
            $scope.requireId = true;
            return;
        }
        // convert lowercase type
    	$scope.curType =  $filter('lowercase')(type);
    	// type block
    	if (angular.isDefined(type) && type == 'Block') {
    		console.log('notShowFieldBlock', $scope.notShowFieldBlock);
    		if($scope.template || $scope.notShowFieldBlock){
    				// string set comment begin block inject
    				var stringStarBlock = "{{-- Begin "+ window.blockCommentMap[$scope.item.curValue] +" Block --}}{{inject('block'," + "'";
    				// string set comment end block inject
    				var stringEndBlock = ")}}{{-- End "+ window.blockCommentMap[$scope.item.curValue] +" Block --}}";
					// get content insert service update inject auto increment
        			CmsContentInsertService.getBlockAndUpdateInjectAutoIncrement($scope.item.curValue).then(function(data){
        				// set str
	                    $str = stringStarBlock + $scope.item.curValue + "_" + data['autoIncrement'] + "'"  + stringEndBlock;
	                    $modalInstance.close($str);// close modal
	                });
      		}else{
      			// get content block
       			getBlockContent($scope.currentId);
      		}
    	}
    	// type asset
    	if(type == 'Asset') {
    		if(typeof $scope.item.curValue != 'undefined' && $scope.item.curValue != null) {
    			CmsContentInsertService.getDetailCommentAsset($scope.item.curValue).then(function(data){
    				if(angular.isDefined($scope.item.thumbNail)){

                    	$str = "{{-- Begin "+ data.asset['filename'] +" Asset --}}{{inject('asset'," + "'" + $scope.item.curValue + "'"+ ", '" + $scope.item.thumbNail + "'" +")}}{{-- End "+ data.asset['filename'] +" Asset --}}";
    				}else{

                   		$str = "{{-- Begin "+ data.asset['filename'] +" Asset --}}{{inject('asset'," + "'" + $scope.item.curValue + "'" + ")}}{{-- End "+ data.asset['filename'] +" Asset --}}";
    				}
    				if ($('#checkbox-insert-object').is(':checked')) {
    					$str = "{{-- Begin "+ data.asset['filename'] +" Asset --}}@outject('image','asset'," + "'" + $scope.item.curValue + "'" + "){{-- End "+ data.asset['filename'] +" Asset --}}";
    				} 
                    $modalInstance.close($str);
                });
                
    		}
    	}
    	// type link
    	if(type == 'Link') {
    		if(typeof $scope.item.curValue != 'undefined' && $scope.item.curValue != null) {
                CmsContentInsertService.getDetailCommentLink($scope.item.curValue).then(function(data){
                    $str = "{{-- Begin "+ data.link['name'] +" Link --}}{{inject('link'," + "'" + $scope.item.curValue + "'" + ")}}{{-- End "+ data.link['name'] +" Link --}}";
                    $modalInstance.close($str);
                });
    		}
    	}

    	// if(type == 'Database') {
    	// 	if(typeof $scope.item.curValue != 'undefined' && $scope.item.curValue != null) {
     //            $str = "{!! $database_table_" + $scope.item.curValue.parent + "_field_" + $scope.item.curValue.name + " !!}";
     //            $modalInstance.close($str);
    	// 	}
    	// }
    };

    /*
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     * get content block follow blockId        [description]
     * getBlockContent                         [function]
     *
     * show list field with types [input, select, file,..] in pop up(modal)
     *
     * @param $blockId, $language, $region
     *
     * return string
     */
    function getBlockContent(blockId) {
    	CmsContentInsertService.getContentBlock({language:language, region:region}, blockId).then(function(data){
    		console.log('data', data);
			if (data.status && data.content.type !== 'managed_block' && data.content.fields && data.content.fields.length) {
				/*show form to update information for field*/
                $scope.existField = true;
                $scope.listField = data.content.fields;
                /*render html list field follow type[input, select,...]*/
                customFieldsMutiple($scope.listField);
			} else {
				$modalInstance.close(CmsContentInsertService.customCurrentData($filter('lowercase')($scope.curType), $scope.currentId));
			}
		});
    }

	$scope.url = [];
	/**
	 * GET URL SHOW IMAGE
	 * @param  {[type]} id [description]
	 * @return {[type]}    [description]
	 */
	$scope.getUrlImageAsset = function(id) {

		AssetManagerService.getUrlImageAsset(id).then(function (data){

			$scope.url[id] = data['url']; // return url image not multi
			console.log('url', $scope.url);
		})

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
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     * get data from form and convent to format {{inject(type, id, values)}}       [description]
     * saveContentBlock                                                            [function]
     * @param    [curType]      types:block, link,....
     * @param    [currentId]    blockId
     * @param    [curFields]    list fields value which got from modal
     * @param    [listField]    list fields which got from database follow blockId, language and region
     *
     */
    $scope.saveContentBlock = function(validate) {

		$scope.submitted = false;

    	if (validate) {

    		$('#form-edit-field').find(".ng-invalid:eq(0)").focus();

    		$scope.submitted = true;

    		return;
    	}

    	/*check minimum field, apply for fields is multiple*/
		if (checkMinimumField()) {
			return;
		}
		console.log('$scope.curFields', $scope.curFields);
        var data = angular.copy($scope.curFields);
		data.fields = customFieldData(data.fields);
		console.log('data.fields', data.fields);

        /*convent result to string*/
        var result = CmsContentInsertService.customCurrentData($scope.curType, $scope.currentId, data, $scope.listField);

    	$modalInstance.close(result);
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


    /**
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     * show fields(type is mutiple) default when show modal      [description]
     * customFieldsMutiple                                       [function]
     *
     * set default value is null for fields (apply when add new field)
     */
    function customFieldsMutiple(fields) {
    	for (var i in fields) {

   			if (fields[i].multiple) {

   				if (angular.isUndefined($scope.curFields)) {
   					$scope.curFields = {};
   				}

	   			$scope.curFields[fields[i].variable] = null;

   				//count field to check minimum filed
   				updateFieldsOfMuitiField('add', fields[i].variable);

	   			$scope.curFields[fields[i].variable] = {};
	   			$scope.curFields[fields[i].variable][0] = null;

	   			/**
	   			 *  show a field default follow type(select, input, textarea,...) when change template
	   			 */
	   			if (angular.isUndefined($scope.multiFieldFollowVariable[fields[i].variable])) {

					$scope.multiFieldFollowVariable[fields[i].variable] = [{'id':fields[i].variable+0, 'key_field':0}];

				}
	   		}
   		}
    }

    /*
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
	 * update (add or remove) field number for multiple fields
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

	/*
	 * @author [Nguyen Kim Bang] <bang@httsolution.com>
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
	$scope.addNewField = function(curField) {
		$scope.listErrorListFile = [];

		var maxIndex = 0;
		var checkMaxField = 0;

		/*check maximum field*/
		if (angular.isDefined($scope.multiFieldFollowVariable[curField.variable]) && $scope.multiFieldFollowVariable[curField.variable].length) {

			for (var i in $scope.multiFieldFollowVariable[curField.variable]) {

				if ($scope.multiFieldFollowVariable[curField.variable][i].id == curField.variable+$scope.multiFieldFollowVariable[curField.variable][i].key_field) {

                   checkMaxField +=1;

                   /*get maximum key*/
                   if ($scope.multiFieldFollowVariable[curField.variable][i].key_field > maxIndex) {

	                   	maxIndex =  $scope.multiFieldFollowVariable[curField.variable][i].key_field;

                   }
				}
			}
		}

		/*check maximum fields number, apply for fields multiple*/
		if (checkMaxField >= curField.max_field) {
			alert('Maximum '+curField.name+' field is '+curField.max_field);
			return
		}

        maxIndex = parseInt(maxIndex)+1;

        $scope.curFields[curField.variable][maxIndex] = null;

        if (angular.isUndefined($scope.multiFieldFollowVariable[curField.variable])) {
			$scope.multiFieldFollowVariable[curField.variable] = [{'id':curField.variable+maxIndex, 'key_field':maxIndex}];
			updateFieldsOfMuitiField('add', curField.variable);
		} else {
			$scope.multiFieldFollowVariable[curField.variable].push({'id':curField.variable+maxIndex, 'key_field':maxIndex});
			updateFieldsOfMuitiField('add', curField.variable);
		}

	}

	/**
	 * @author [Nguyen Kim Bang] <bang@httsolution.com>
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
	$scope.removeCurrentField = function(curField, index) {
		$scope.listErrorListFile = [];

		var curVal = $scope.multiFieldFollowVariable[curField.variable];

		if (angular.isDefined(curVal) && curVal.length) {

			for (var i in curVal) {

				if (curVal[i].key_field == index && curVal[i].id == curField.variable + curVal[i].key_field) {

					if (angular.isDefined($scope.curFields) && angular.isDefined($scope.curFields[curField.variable])) {

						$scope.curFields[curField.variable] = angular.extend({}, $scope.curFields[curField.variable]);

						if (angular.isArray($scope.curFields[curField.variable])) {

							$scope.curFields = angular.extend({}, $scope.curFields);

						}

						delete $scope.curFields[curField.variable][curVal[i].key_field];
						updateFieldsOfMuitiField('remove', curField.variable);

					}

					$scope.multiFieldFollowVariable[curField.variable].splice(i, 1);

					break;
				}
			}
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

	/**
	 * @author [Nguyen Kim Bang] <bang@httsolution.com>
	 * upload file
	 *
	 * @param [$files], [variable_f], [index]
	 * @param variable_f (variable of field)
	 * @param index (current position of field [1, 2, 3,....])
	 * @param index exist, when a field is multiple
	 *
	 * @return [file_name], [file_id]
	 */
	$scope.uploadFileCurTemp = function(files, variable_f, index) {
		if (!files.length) {
			return;
		}

		var maxUpload = window.maxUpload;

		/**
		* check maximum file size
		*/
		if (files[0]['size'] > maxUpload['size']) {
			if (angular.isUndefined(index)) {
	            $scope.curFields[variable_f] = null;
			} else {
				$scope.curFields[variable_f][index] = null;
			}
	        alert('Max file size is ' + maxUpload['name']);
	        return;
	    }

		Upload.upload({
            url: baseUrl + '/admin/file',
            file: files,
        }).progress(function(evt) {

        }).success(function(data, status, headers, config) {
        	if (angular.isDefined($scope.curFields) && angular.isDefined(index)) {

        		/*delare an object*/
        		if (angular.isUndefined($scope.curFields[variable_f])) {
	        		$scope.curFields[variable_f] = {};
        		}

        		if (angular.isUndefined($scope.file_fields[variable_f])) {
	        		$scope.file_fields[variable_f] = {};
        		}

	        		$scope.file_fields[variable_f][index] = {};
        		// $scope.curFields[variable_f][index] = 'file_'+data.item.id;
        		$scope.curFields[variable_f][index] = data.item.id;
        		console.log('variable_f',variable_f);
        		console.log('index',index);
        		console.log($scope.curFields[variable_f][index],'xx');
        		$scope.file_fields[variable_f][index]['avatar'] = data.item.file_name;
        		console.log($scope.file_fields[variable_f][index]['avatar'],'xx1');

        	} else if (angular.isDefined($scope.curFields)) {

	        	$scope.file_fields[variable_f] =  data.item.file_name;

        		$scope.curFields[variable_f] = data.item.id;


        	}
	    }).error(function(data) {
	    });
	}

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
}])
