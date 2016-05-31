var materialApp = angular.module('MaterialApp');

materialApp.controller('MaterialsController', ['$scope', '$modal', 'ngTableParams','$timeout','MaterialsService', '$filter', function ($scope, $modal, ngTableParams, $timeout, MaterialsService, $filter){

    $scope.material = angular.copy(window.material);
    $scope.choosePlatform =true;
    $scope.isExistPlatform = false;
    $timeout(function(){
        $('#platform_select').select2();
        $('#state').select2();
    });
    $scope.listPlatformAndStale = [];
    if(angular.isDefined($scope.material)){
         $scope.listPlatformAndStale['data'] = $scope.material.data;
    }
    if(typeof $scope.listPlatformAndStale.data !== 'undefined' && $scope.listPlatformAndStale.data.length > 0 ){
        $scope.multiPlatforms = [];
        for(key in $scope.listPlatformAndStale.data){
            $scope.multiPlatforms.push(key);
        }
        var totalAddPlatform = $scope.listPlatformAndStale.data.length - 1;

    } else {
        var totalAddPlatform  =0;
        $scope.multiPlatforms = [];
    }
    $scope.createMaterial = function(validate) {
        $scope.submitted = true;
        $scope.isExistPlatform = false;
        $scope.saving = true;

        if(validate || $scope.material.category_id == null) {
            $scope.saving = false;
            return true;
        }
        $scope.choosePlatform =false;
        if($scope.material.type === 'accessories'){
            if(!angular.isDefined($scope.listPlatformAndStale)|| angular.isUndefined($scope.listPlatformAndStale.data)){
                $scope.choosePlatform =true;
                $scope.saving = false;
                return true;
            }
            var listPlatform = [];
            angular.forEach($scope.listPlatformAndStale.data, function(value, key) {
                if( listPlatform.indexOf(value.platform_id)!=-1){
                    $scope.isExistPlatform = true;
                    $scope.saving = false;
                    return true;
                } else {
                    listPlatform.push(value.platform_id);
                }
               
            });
            $scope.material.data =$scope.listPlatformAndStale.data;
        }
        $scope.choosePlatform =false;
        if(angular.isDefined($scope.filesUpload)){

            $scope.material.image = $scope.filesUpload.ids;
        }
        MaterialsService.createMaterial($scope.material).then(function(data){
            $scope.saving = false;
            if(data.status) {
                var setActiveRoot = 'root_material';
                if ($scope.material.type === 'accessories') {
                    setActiveRoot = 'root_accessories';
                }
                window.location = window.baseUrl + '/cms/database-manager/set-database-selected/'+setActiveRoot;
            } else {
                $scope.nameError = true;
            }
        });
    }
    $scope.changePlatform = function(){
        $scope.isExistPlatform = false;
    }
    $scope.updateMaterial = function(validate) {
        $scope.isExistPlatform = false;
        $scope.submitted = true;
        $scope.saving = true;

        if(validate || $scope.material.category_id == null) {
            $scope.saving = false;
            return;
        }
        $scope.choosePlatform =false;
        if($scope.material.type === 'accessories') {
            if(!angular.isDefined($scope.listPlatformAndStale)|| angular.isUndefined($scope.listPlatformAndStale.data)){
                $scope.choosePlatform =true;
                $scope.saving = false;
                return true;
            }
            var listPlatform = [];
            angular.forEach($scope.listPlatformAndStale.data, function(value, key) {
                if( listPlatform.indexOf(value.platform_id)!=-1){
                    $scope.isExistPlatform = true;
                    $scope.saving = false;
                    return true;
                } else {
                    listPlatform.push(value.platform_id);
                }
               
            });
            if(angular.isDefined($scope.filesUpload.files)) {
                $scope.material.image = $scope.filesUpload.files;
            } else {
                $scope.material.image = [];
            }

            $scope.material.data =$scope.listPlatformAndStale.data;
        }
        MaterialsService.updateMaterial($scope.material).then(function(data){
            $scope.saving = false;

            if(data.status) {
                var setActiveRoot = 'root_material';
                if ($scope.material.type === 'accessories') {
                    setActiveRoot = 'root_accessories';
                }
                window.location = window.baseUrl + '/cms/database-manager/set-database-selected/'+setActiveRoot;
            } else {
                $scope.nameError = true;
            }
        });
    }
    /**
     * add platform index 
     *
     * @author minh than
     */
    $scope.addPlatform = function() {
        $scope.choosePlatform =false;
        totalAddPlatform++;
        $scope.multiPlatforms.push(totalAddPlatform); // add index platforms

    }
    $scope.removePlatform = function(key) {
        $scope.isExistPlatform = false;
        totalAddPlatform--;
        if(totalAddPlatform==0){
            $scope.choosePlatform =true;
        }
        // call function remove data content laser then remove data
        removeDataListPlatformAndStale(key, function() {

            $scope.multiPlatforms.splice(key, 1);
            
        });

        var count = 0;
        var tmpMultiPlatforms = [];
        // reindex when splice array
        for(var i = 0, len = $scope.multiPlatforms.length; i < len; i++) {

            tmpMultiPlatforms.push(count);
            count++;
        }
        $scope.multiPlatforms = tmpMultiPlatforms;
    }
    /**
     * remove data content laser
     *
     * @author Minh than
     * 
     * @param  {int}   key key index data
     * @param  {Function} fn  function call back when method performing finish
     * @return void
     */
    var removeDataListPlatformAndStale = function(key , fn) {

        var tmpListPlatformAndStale = angular.copy($scope.listPlatformAndStale['data']);

        for (var i in tmpListPlatformAndStale) {

            if (parseInt(i) > parseInt(key) && angular.isDefined(tmpListPlatformAndStale[i])) {
                tmpListPlatformAndStale[i - 1] = angular.copy(tmpListPlatformAndStale[i]); // get data if index key > i in object
                delete tmpListPlatformAndStale[i]; // delete data as key
            } else {
                delete tmpListPlatformAndStale[key]; // delete data as key
            }
        }

        $scope.listPlatformAndStale['data'] = tmpListPlatformAndStale; // assignee tmpListPlatformAndStale to scope laser data
        fn.call(); // call function callback
    }

}])