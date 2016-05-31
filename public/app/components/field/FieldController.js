
var dataOption = angular.module('filed');

dataOption.controller('filedController', ['$scope', '$compile', 'filedService', 'filedTypeService', '$filter', 'ngTableParams', '$filter', '$timeout', '$controller',
 function($scope, $compile, filedService, filedTypeService, $filter, ngTableParams, $filter, $timeout, $controller) {
    $controller('BaseController', { $scope: $scope });
    angular.element('.wrap-branch').removeClass('hidden');
    $scope.callbackLoadUserFinish = function(){

    };
    $scope.dataOption = 0;
    $scope.fields = angular.copy(filedService.setFields(window.fields));
    $scope.listRequiredFieldType_Map = window.listRequiredFieldType_Map;

    $scope.getAllField = function()
    {

         $scope.tableParams = new ngTableParams({
              page: 1,            // show first page
              count: 10          // count per page
          }, {
              total: $scope.fields.length,
              getData: function($defer, params) {
                  var orderedData = params.sorting() ?
                          $filter('orderBy')($scope.fields, $scope.tableParams.orderBy()) : $scope.fields;

                  $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
              }
          });
    }

    /**
     * Delete Field
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {String} id Id field
     *
     * @return {Void}
     */
    $scope.deleteField = function(id){
        if (!confirm('All changes will be lost if this is changed. Do you want to proceed?')) return;
        filedService.remove(id).then(function (){
            $scope.fields = filedService.getFields();
            $scope.tableParams.reload();
        });
    };

}])
.controller('createFiledController', ['$scope', '$timeout', '$filter', 'filedService', 'filedTypeService', function($scope, $timeout, $filter, filedService, filedTypeService) {

    $scope.field = window.field;

    $scope.openedLimitDate=false;

    $scope.listType = window.listType;

    if(window.formatDate){

        if(window.formatDate==true){

            $scope.formatDate='yyyy-MM-dd';

        } else{

            $scope.formatDate=window.formatDate;

        }
    }
    $scope.lengthAttribute=function(){
        var valueMinLength='';

        var valueMaxLength='';

        $scope.validateLength=false;

        for(i in $scope.field.html_attributes) {

            if($scope.field.html_attributes[i]['key']=='minlength'&& $scope.field.html_attributes[i]['value']){

                valueMinLength=$scope.field.html_attributes[i]['value'];

            }

            if($scope.field.html_attributes[i]['key']=='maxlength'&& $scope.field.html_attributes[i]['value']){

                valueMaxLength=$scope.field.html_attributes[i]['value'];

            }
        }
        if(valueMinLength&&valueMaxLength){

            if(valueMinLength>valueMaxLength){

                $scope.validateLength=true;

            }
        }

    }
    $scope.changeDate=function(){
        var valueMinDate='';
        var valueMaxDate='';
        $scope.checkDate=false;
        for(i in $scope.field.html_attributes) {
            if(($scope.field.html_attributes[i]['key']=='min-date'||$scope.field.html_attributes[i]['key']=='min')&& $scope.field.html_attributes[i]['value']){
                valueMinDate=$scope.field.html_attributes[i]['value'];
            }
            if(($scope.field.html_attributes[i]['key']=='max-date'|| $scope.field.html_attributes[i]['key']=='max')&& $scope.field.html_attributes[i]['value']){
                valueMaxDate=$scope.field.html_attributes[i]['value'];
            }
        }
        if(valueMaxDate&&valueMinDate){
            var minDate = new Date(valueMinDate);
            var maxDate = new Date(valueMaxDate);
            if(minDate>maxDate){
                $scope.checkDate=true;
            }
        }
    }
    $scope.createField = function(validate,checkSave)
    {
        $scope.submitted = true;
        if($scope.checkDate){
            return;
        }
        if($scope.validateLength){
            return;
        }
        if(validate) {
            return;
        }
        angular.element("#bt-submit").attr("disabled", "true");
        angular.element("#bt-submit-new").attr("disabled", "true");
        for(i in $scope.field.html_attributes) {
            if($scope.field.html_attributes[i]['key'] == 'min-date' || $scope.field.html_attributes[i]['key'] == 'max-date') {
                $scope.field.html_attributes[i]['value'] = $filter('date')($scope.field.html_attributes[i]['value'], 'yyyy-MM-dd');
            }
            if($scope.field.html_attributes[i]['value'] == "") {
                delete $scope.field.html_attributes[i];
            }
        }

        filedService.create($scope.field).then(function(data) {

            if (data.status == 0) {
                $scope.error = 'Name is Exist';
                angular.element("#bt-submit").removeAttr("disabled");
                angular.element("#bt-submit-new").removeAttr("disabled");
            }else{
                if($scope.field._id) { //when edit then redirect to field manager
                    window.location = window.baseUrl + "/admin/field";
                } else {
                    if(checkSave) {
                        $scope.field = {};
                        $scope.filedTypeAttributes = {};
                        $scope.submitted = false;
                        $scope.errorMessage = true;
                        angular.element("#bt-submit").removeAttr("disabled");
                        angular.element("#bt-submit-new").removeAttr("disabled");
                       $timeout(function() {
                           $(".select-field-type").select2("val", "");
                        });

                        $timeout(function() {
                            $scope.errorMessage=false;
                        }, 5000);
                    } else {
                        window.location = window.baseUrl + "/admin/field";
                    }

                }
            }
        });

    }

    $timeout(function() {
        $('.select-field-type').select2();
    });

    $scope.getFieldAttributes = function()
    {
        if(!angular.isDefined($scope.field)) {
            $scope.field = {};
        }

        $scope.field.html_attributes = {};
        // $scope.filedTypeAttributes = [];

        if (typeof $scope.field.field_type_id != 'undefined') {
            filedTypeService.getFieldAttributes($scope.field.field_type_id).then(function(data) {
                $scope.formatDate='';
                if(data.formatDate){
                    if(data.formatDate==true){
                     $scope.formatDate='yyyy-MM-dd';
                    } else{
                        $scope.formatDate=data.formatDate;
                    }
                }
                for(var key in data.filedTypeAttributes){
                    $scope.field.html_attributes[key] = {};

                    if(data.filedTypeAttributes[key]['value'] == true) continue;

                    if(data.filedTypeAttributes[key]['value'].indexOf('&') == 0){
                        data.filedTypeAttributes[key]['attr'] = '&';
                        $scope.field.html_attributes[key]['orveride'] = '&';
                        data.filedTypeAttributes[key]['value'] = data.filedTypeAttributes[key]['value'].replace('&', '');

                    } else if(data.filedTypeAttributes[key]['value'].indexOf('*') == 0){
                        data.filedTypeAttributes[key]['attr'] = '*';
                        $scope.field.html_attributes[key]['orveride'] = '*';
                        data.filedTypeAttributes[key]['value'] = data.filedTypeAttributes[key]['value'].replace('*', '');
                    }

                    $scope.field.html_attributes[key]['key'] = data.filedTypeAttributes[key]['key'];
                    $scope.field.html_attributes[key]['value'] = data.filedTypeAttributes[key]['value'];
                }
                $scope.field.html_attributes = data.filedTypeAttributes;
                $scope.field.term = data.term;
            }).then(function(){
                console.log( $scope.field,' $scope.field');
            })
        }
    }
}])
