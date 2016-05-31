var dataOption = angular.module('filedType');

dataOption.controller('filedTypeController', ['$scope', 'filedTypeService', '$filter', 'ngTableParams', '$controller',
    function($scope, filedTypeService, $filter, ngTableParams, $controller) {

    $controller('BaseController', { $scope: $scope });
    angular.element('.wrap-branch').removeClass('hidden');
    $scope.callbackLoadUserFinish = function(){

    };
    $scope.getAllFieldType = function() {
        filedTypeService.query().then(function(data) {
            $scope.items = angular.copy(filedTypeService.setFieldTypes(data));
            $scope.tableParams = new ngTableParams({
                page: 1, // show first page
                count: 10 // count per page
            }, {
                total: $scope.items.length,
                getData: function($defer, params) {
                    var orderedData = params.sorting() ?
                        $filter('orderBy')($scope.items, $scope.tableParams.orderBy()) : $scope.items;

                    $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                }
            });
        })
    }

    /**
     * Delete Field Type
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {String} id Id field Type
     *
     * @return {Void}
     */
    $scope.deleteFieldType = function(id){
        if (!confirm('All changes will be lost if this is changed. Do you want to proceed?')) return;
        filedTypeService.remove(id).then(function (){
            $scope.items = filedTypeService.getFieldTypes();
            $scope.tableParams.reload();
        });
    };

}])
.controller('createFiledTypeController', ['$scope', '$compile', '$timeout', 'filedTypeService', function($scope, $compile, $timeout, filedTypeService) {

    $scope.attributeDataOptions = window.attributeDataOptions;
    $scope.types = window.types;
    $scope.attribute = window.attribute;

    $scope.dataOption = [];

    var index = window.indexAttribute;
    $scope.changeCategory =function(category){
        filedTypeService.changeCategory(category).then(function(data) {
            $scope.types=data;
            $scope.fieldType.output_type='';
            $timeout(function() {
                $(".select-output-type").select2();
                $(".select-term").select2();
            });
        })
    }
    $scope.changeOutputType =function(outputType){
        filedTypeService.changeOutputType(outputType).then(function(data) {
            if(outputType=='term'){
              $scope.fieldType.category='term';
            }
            else{
                $scope.fieldType.category='form_element';
            }
            $scope.types=data;
            $scope.fieldType.output_type=outputType;
            $timeout(function() {
                $(".select-term").select2();
                $(".select-category").select2();
                $(".select-output-type").select2();
            });
        })
      }

    var select2 = function()
    {
         $timeout(function() {
            $(".select-category").select2();
            $(".select-output-type").select2();
        });
    }

    select2();
    $timeout(function() {

        for (var i = 0; i < 20; i++) {

            if (typeof $scope.fieldType.attribute != 'undefined' && typeof $scope.fieldType.attribute[i] != 'undefined') {

                if ($scope.fieldType.attribute[i].data_option) {

                    $scope.dataOption[i] = true;

                } else {

                    $scope.dataOption[i] = false;

                }
            } else {

                $scope.dataOption[i] = false;
            }
        }

        if(typeof $scope.fieldType._id == 'undefined') {
            $scope.fieldType.attribute = [];
            $scope.fieldType.attribute.push({'key':'','value':''});
        }

    }, 300);

    $scope.addAttribute = function() {
        $scope.fieldType.attribute.push({'key':'','value':''});
    }

    $scope.removeAttribute = function(index) {

        if (typeof $scope.fieldType.attribute != 'undefined') {

            var curAttribute = $scope.fieldType.attribute;
            var temAttribute = [];
            for (i in curAttribute) {
                if (i != index) {
                    temAttribute.push(curAttribute[i]);
                }
            }
            $scope.fieldType.attribute = temAttribute;
        }
    }

    $scope.dataOption = function(index) {
        if (typeof $scope.fieldType.attribute[index] != 'undefined') {

            $scope.fieldType.attribute[index].data_option = $scope.dataOption[index];
        }

    }
    $scope.changName = function() {
        $scope.nameExists=null;
    }
    $scope.createFieldType = function(validate,checkSave) {

        $scope.submitted = true;
        if (validate) {
            return;
        }

        angular.element("#bt-submit").attr("disabled", "true");
        angular.element("#bt-submit-new").attr("disabled", "true");
        // $scope.fieldType.dataOption = $scope.dataOption;

        if($scope.fieldType.output_type == 'term') {
             if (typeof $scope.fieldType.pre_addon != 'undefined') {
                delete $scope.fieldType.pre_addon;
            }

            if (typeof $scope.fieldType.post_addon != 'undefined') {
                delete $scope.fieldType.post_addon;
            }

            if (typeof $scope.fieldType.output_content != 'undefined') {
                delete $scope.fieldType.output_content;
            }

            if (typeof $scope.fieldType.attribute != 'undefined') {
                delete $scope.fieldType.attribute;
            }
        } else {
            if (typeof $scope.fieldType.termId != 'undefined') {
                delete $scope.fieldType.termId;
            }

            if (typeof $scope.fieldType.isMulti != 'undefined') {
                delete $scope.fieldType.isMulti;
            }
        }
        for(i in $scope.fieldType.attribute) {
            if($scope.fieldType.attribute[i]['key'] == '') {
                $scope.fieldType.attribute.splice(i,1);
            }
        }
        $scope.checkID=$scope.fieldType._id;
        filedTypeService.create($scope.fieldType).then(function(data) {
            $scope.errorMessage=false;
            if (data.status == 0) {
                $scope.nameExists =data.error;
                angular.element('#bt-submit').removeAttr('disabled');
                angular.element('#bt-submit-new').removeAttr('disabled');
            } else {
                if(!checkSave){
                    window.location = window.baseUrl + '/admin/field-type';
                } else{
                    angular.element('#bt-submit').removeAttr('disabled');
                    angular.element('#bt-submit-new').removeAttr('disabled');
                    $scope.fieldType = {};
                    select2();
                    $scope.submitted = false;
                    $scope.errorMessage = true;
                    $scope.fieldType.attribute = [];
                    $scope.fieldType.attribute.push({'key':'','value':''});
                    $timeout(function() {
                         $scope.errorMessage=false;
                    }, 5000);
                }
            }
        });

    }
}]);
