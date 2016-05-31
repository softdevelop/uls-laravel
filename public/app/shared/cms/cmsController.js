var module = angular.module('CmsApp');

module.controller('CmsController', ['$scope','$modal','$filter', function($scope, $modal, $filter) {

  
    $scope.multiFieldFollowVariable = {};
    //fill list file name
    $scope.file_fields = [];
    $scope.listField = [];
    $scope.countFieldsOfMultiField = [];
    /**
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     * show fields(type is mutiple) default when show modal      [description]
     * customFieldsMutiple                                       [function]
     *
     * set default value is null for fields (apply when add new field)
     */
    $scope.customFieldsMutiple = function( fields) {
        for (var i in fields) {
            if (fields[i].multiple) {
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
            if ($scope.multiFieldFollowVariable[curField.variable][i].id == curField.variable + $scope.multiFieldFollowVariable[curField.variable][i].key_field) {
                checkMaxField +=1;
                /*get maximum key*/
                if ($scope.multiFieldFollowVariable[curField.variable][i].key_field > maxIndex) {
                    maxIndex =  $scope.multiFieldFollowVariable[curField.variable][i].key_field;
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
    $scope.curFields[curField.variable][maxIndex] = null;

    if (angular.isUndefined($scope.multiFieldFollowVariable[curField.variable])) {
        $scope.multiFieldFollowVariable[curField.variable] = [{'id':curField.variable+maxIndex, 'key_field':maxIndex}];
        updateFieldsOfMuitiField('add', curField.variable);
    } else {
        $scope.multiFieldFollowVariable[curField.variable].push({'id':curField.variable+maxIndex, 'key_field':maxIndex});
        updateFieldsOfMuitiField('add', curField.variable);
    }
  }

    var loadCurrentData = function(fields) {

        for(var key in $scope.block.fields){
            synchFields($scope.fields[key],true);
        }
    }
    /**
     * synch fields
     * @param  {[type]} curFields [description]
     * @return {[type]}           [description]
     */
    var synchFields = function(curField, isCurBlock) {
        var fisrt = 0;
        if(isCurBlock){
            variable = '__' + curField['variable'];
        }else{
            variable = curField['variable'];
        }
        for(var key in $scope.block.data.fields[variable]){
            if(fisrt == 0) {
                fisrt++;
                continue;
            }
            
            $scope.addNewField(curField);
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
                $scope.file_fields[variable_f][index]['avatar'] = data.item.file_name;

              } else if (angular.isDefined($scope.curFields)) {

                $scope.file_fields[variable_f] =  data.item.file_name;

                $scope.curFields[variable_f] = data.item.id;


              }
          }).error(function(data) {
          });
   
  }

}])