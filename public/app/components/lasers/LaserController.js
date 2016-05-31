var materialApp = angular.module('MaterialApp');

materialApp.controller('LaserController', ['$scope', '$modal','LaserService', function ($scope, $modal, LaserService){

    $scope.platforms = window.platforms;
 
    $scope.laser = window.laser;
    $scope.choosePlatform =false;
    if(typeof $scope.laser.data !== 'undefined' && $scope.laser.data.length > 0 ){
        $scope.multiPlatforms = [];
        for(key in $scope.laser.data){
            $scope.multiPlatforms.push(key);
        }

        $scope.multiCompatibility = {};
        for(key in $scope.multiPlatforms){
            $scope.multiCompatibility[key] = $scope.laser.data[key].compatibilitys;
            $scope.laser.data[key].platform_id = $scope.laser.data[key].platform_id.toString();
        }
        var totalAddPlatform = $scope.laser.data.length - 1;

    } else {
        $scope.multiPlatforms = [0];
        $scope.multiCompatibility = {};
        var totalAddPlatform = 0;
    }

    
    // if(angular.isDefined($scope.laser)){
    //     $scope.multiPlatforms = $scope.laser.data;
    //     $scope.multiCompatibility = [];
    //     for(key in $scope.multiPlatforms){
    //         $scope.multiCompatibility.push($scope.multiPlatforms[key].compatibilitys);
    //     }
    //     var totalAddPlatform = $scope.laser.data.length - 1;
    // }  else {
        // $scope.multiCompatibility = {};

        // var totalAddPlatform = $scope.multiPlatforms.length - 1;
    // }
    
  
    $scope.submit = function(validate) {
        $scope.submitted = true;
        $scope.error = '';

        if(validate) {
            return true;
        }
        if(!angular.isDefined($scope.laser.data)){
                $scope.choosePlatform =true;
                return true;
        }
        $scope.chooseCompatibility =false;
        angular.forEach($scope.laser.data, function(value, key) {
                if(!angular.isDefined(value.compatibilitys)){
                    $scope.chooseCompatibility =true;
                } else {
                    var  check =0;
                    var length = 0;
                    angular.forEach(value.compatibilitys, function(value1, key1) {
                        length ++;
                        if(!angular.isDefined(value1)){
                            check++;
                        }
                    });
                    if(check ==length ){
                        $scope.chooseCompatibility =true;
                    }
                }
        });
        if(angular.isDefined($scope.chooseCompatibility) && $scope.chooseCompatibility !=false){
            return true;
        }
        LaserService.create($scope.laser).then(function(data) {

            $scope.saving = false;

            if(data.status) {
                window.location = window.baseUrl + '/cms/database-manager/set-database-selected/root_lasers';

            } else {
                $scope.error = data['error'];
            }
        });
    }
        console.log($scope.multiPlatforms);

    /**
     * add platform index 
     *
     * @author minh than
     */
    $scope.addPlatform = function() {
        $scope.chooseCompatibility =false;
        $scope.choosePlatform =false;
        totalAddPlatform++;
        $scope.multiPlatforms.push(totalAddPlatform); // add index platforms

    }

    /**
     * selected platform 
     *
     * @author minh than
     * @param  {[type]} key [description]
     * @return {[type]}     [description]
     */
    $scope.selectedPlatform = function(key) {
        if(angular.isUndefined($scope.multiCompatibility[key])) {

            $scope.multiCompatibility[key] = [0]; // show first multi compatibility 
        }
        
    }

    $scope.addCompatibilityLaser = function(key) {
        $scope.chooseCompatibility =false;
        if(typeof $scope.laser.data !== 'undefined' && $scope.laser.data.length > 0){
            $scope.multiCompatibility[key].push({});
        } else {
            $scope.multiCompatibility[key].push($scope.multiCompatibility[key].length);
        }
    }

    $scope.removePlatform = function(key) {
        $scope.chooseCompatibility =false;
        totalAddPlatform--;
        console.log(totalAddPlatform,'s');
        if(totalAddPlatform<0){
            $scope.choosePlatform =true;
        }
        // call function remove data content laser then remove data
        removeDataContentLaser(key, function() {

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
     * remove compatibility laser
     *
     * @author Minh than
     * 
     * @param  {[type]} key   [description]
     * @param  {[type]} index [description]
     * @return {[type]}       [description]
     */
    $scope.removeCompatibilityLaser = function(key, index) {
        $scope.chooseCompatibility =false;
        removeDataCompatibityLaser(key, index, function() {

            $scope.multiCompatibility[key].splice(index, 1);
        });

        var count = 0;
        var tmpCurrentMultiCompatibility = [];
        for(var i = 0, len = $scope.multiCompatibility[key].length; i < len; i++) {

            tmpCurrentMultiCompatibility.push(count);
            count++;
        }
        $scope.multiCompatibility[key] = tmpCurrentMultiCompatibility;
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
    var removeDataContentLaser = function(key , fn) {
        var tmpLaserData = angular.copy($scope.laser['data']);

        for (var i in tmpLaserData) {

            if (parseInt(i) > parseInt(key) && angular.isDefined(tmpLaserData[i])) {
                tmpLaserData[i - 1] = angular.copy(tmpLaserData[i]); // get data if index key > i in object
                delete tmpLaserData[i]; // delete data as key
            } else {
                delete tmpLaserData[key]; // delete data as key
            }
        }

        $scope.laser['data'] = tmpLaserData; // assignee tmpLaserData to scope laser data
        fn.call(); // call function callback
    }

    /**
     * remove data compatibity laser
     *
     * @author Minh than
     * @param  {[type]}   key   [description]
     * @param  {[type]}   index [description]
     * @param  {Function} fn    [description]
     * @return {[type]}         [description]
     */
    var removeDataCompatibityLaser = function(key, index, fn) {
        $scope.chooseCompatibility =false;
        if(angular.isDefined($scope.laser['data'][key])) {

            var tmpLaserData = angular.copy($scope.laser['data'][key]['compatibilitys']);

            for (var i in tmpLaserData) {

                if (parseInt(i) > parseInt(index) && angular.isDefined(tmpLaserData[i])) {
                    tmpLaserData[i - 1] = angular.copy(tmpLaserData[i]); // get data if index key > i in object
                    delete tmpLaserData[i]; // delete data as key
                } else {
                    delete tmpLaserData[index]; // delete data as key
                }
            }

            $scope.laser['data'][key]['compatibilitys'] = tmpLaserData; // assignee tmpLaserData to scope laser data
            fn.call(); // call function callback

        }

    }


}])