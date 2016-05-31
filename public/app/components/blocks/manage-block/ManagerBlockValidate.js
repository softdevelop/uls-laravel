var blockApp =  angular.module('BlockApp');

blockApp.controller('ManagerBlockValidate', ['$scope', '$controller', '$timeout', '$filter', function ($scope, $controller, $timeout, $filter) {
	$scope.listFieldValidate = [];

    /**
     * [updateStatusFieldRequired description]
     * update status fields required of block when change data of field
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _listFieldRequired           [description]
     * @param  {[type]} _listFieldDataOfContentBlock [description]
     * @param  {[type]} _id                          [description]
     * @return {[type]}                              [description]
     */
	$scope.updateStatusFieldRequired = function(_listFieldRequired, _listFieldDataOfContentBlock, _id) {

        if (angular.isDefined(_listFieldDataOfContentBlock) && _listFieldDataOfContentBlock) {

            for (var key in _listFieldRequired) {
                //check current value is array?
                if (Object.keys(angular.extend({}, _listFieldRequired[key])).length && key.indexOf('_' + _id) != -1
                    && angular.isDefined(_listFieldDataOfContentBlock[key])) {
                    for (var keyField in _listFieldRequired[key]) {//passing each item in array and call back updateStatusFieldRequired function
                        $scope.updateStatusFieldRequired(_listFieldRequired[key][keyField], _listFieldDataOfContentBlock[key][keyField], _id);
                    }
                } else {
                    
                    //format date
                    if (angular.isDate(_listFieldDataOfContentBlock[key])) {
                        _listFieldDataOfContentBlock[key]= $filter('date')(_listFieldDataOfContentBlock[key], 'yyyy-MM-dd');
                    }
                    if ((typeof  _listFieldRequired[key] != 'object' && typeof _listFieldRequired[key] != 'array')
                    	|| angular.isDate(_listFieldRequired[key])) {

                        //check exit data current fild in content page
                        if (angular.isDefined(_listFieldDataOfContentBlock[key]) && (_listFieldDataOfContentBlock[key]
                        	|| _listFieldDataOfContentBlock[key] == 0)) {
                            _listFieldRequired[key] = false;
                        } else {
                            // check field valide of template or block belong to current template
                            // if current field data not in content page, check current field is required?
                            if (angular.isDefined($scope.term) && angular.isDefined($scope.term[_id]) && $scope.term[_id][key]) {

                                _listFieldRequired[key] = true;
                            }
                        }
                    }
                }
            }
        }
        return _listFieldRequired;
    }

    /**
     * [activeTabError description]
     * active tab error
     *
     * @author [Kim Bang] [bang@httsolutiom.com]
     * @param  {[type]} _status [description]
     * @return {[type]}         [description]
     */
    $scope.activeTabError = function(_status) {
    	for (var key in $scope.listValueFieldRequired) {
            //check exist field required that data of it is invalid
    		if (checkFieldRequired($scope.listValueFieldRequired[key], key, _status)) {
    			return true;
    		}
    	}

    	return false;
    }

    /**
     * [checkFieldRequired description]
     * get field error
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _currentListField [description]
     * @param  {[type]} _key              [description]
     * @param  {[type]} _status           [description]
     * @return {[type]}                   [description]
     */
    function checkFieldRequired(_currentListField, _key, _status) {
    	var hasFieldInvalid = false;
        (function callBack(_currentListField) {
            for (var _keyField in _currentListField) {

                //check current field is array?
                //and exist current field of template or block in _currentListField
                if (Object.keys(angular.extend({}, _currentListField[_keyField])).length && _keyField.indexOf(_key) != -1) {
                    // console.log(_keyField, '_keyFieldf');
                    for (var key in _currentListField[_keyField]) {
                        // console.log(key, 'key');
                        callBack(_currentListField[_keyField][key]);
                    }
                } else {

                    //check current field data in content page is valid and update status form and tab?
                    if (_currentListField[_keyField] == true) {

                        hasFieldInvalid = true;
                        if (_status) {//if click button submit or preview, focus to field invalid (field of template)
                            $timeout(function() {
                                //auto click tab contant field error
                                if (angular.isDefined($('#inject_'+_key)) && $('#inject_'+_key).length){
                                    $('#inject_'+_key).trigger('click');
                                } else {
                                    $('#popular_' + _key).trigger('click');
                                }
                            })
                            return true;
                        }
                    }
                }
            }
        })(_currentListField)

        return hasFieldInvalid;
    }

    /**
     * [checkMinimunCurFields description]
     * check minimum field of current template
     * apply for templates contant field foreach
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _listFields [description]
     * @param  {[type]} _id         [description]
     * @param  {[type]} _status     [description]
     * @param  {[type]} _idTemplate [description]
     * @return {[type]}             [description]
     */
    function checkMinimunCurFields(_listFields, _id) {
        if (typeof _listFields != 'undefined' && _listFields.length > 0) {

            var _tmpId = $scope.currentBlockInject;//id template or block belong to template

            if (typeof _id != 'undefined') {
                _tmpId = _id;
            }

            $scope.listErrorListFile = [];

            if (angular.isDefined(_listFields)) {
                for (var key in _listFields) {
                    var _variable = '_' + _tmpId + '_' + _listFields[key].variable;

                    //check current field is muulple?
                    if (_listFields[key].multiple) {

                        //check current field of template is multiple
                        if ((angular.isUndefined($scope.countFieldsOfMultiField[_variable]) || $scope.countFieldsOfMultiField[_variable] < _listFields[key].min_field)
                           && _listFields[key].min_field > 0) {

                            if (angular.isUndefined($scope.countFieldsOfMultiField[_variable])) {
                                var fieldMultiple = $scope.listValueFieldRequired[_tmpId][_variable];
                                if (Object.keys(angular.extend({}, fieldMultiple)).length
                                    && Object.keys(angular.extend({}, fieldMultiple)).length >= _listFields[key].min_field) {

                                    return false;
                                }
                            }

                            $scope.listErrorListFile.push('Please, add minimum '+ _listFields[key].min_field + ' field '+ _listFields[key].name);

                            $timeout(function() {
                                if (angular.isDefined($('#inject_'+_tmpId)) && $('#inject_'+_tmpId).length){
                                    $('#inject_'+_tmpId).trigger('click');
                                } else {
                                    $('#popular_' + _tmpId).trigger('click');
                                }
                            })

                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * [checkMinimumFieldOfTemplate description]
     * passing each all template of page and check minimum field of template contant field multiple
     *
     * @author [Kim bang] [bang@httsolution.com]
     * @param  {[type]} _status [description]
     * @return {[type]}         [description]
     */
    $scope.checkMinimumFieldOfBlock = function() {
        var status = false;
        var _listInject = $scope.fieldsBlocks;

        var _blockId = (angular.isDefined($scope.block.base_id)) ? $scope.block.base_id : 'current_block';

        status = checkMinimunCurFields($scope.fieldsConfig, _blockId);
        if (!status && typeof _listInject != 'undefined') {
            for (var keyInject in _listInject) {
               status = checkMinimunCurFields(_listInject[keyInject].fields, _listInject[keyInject]._id);

               if (status) {
                    return status;
               }
            }
        } else if(status) {
            return status;
        }

        return status;
    }
}]);