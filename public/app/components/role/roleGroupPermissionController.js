
var userModule = angular.module('roleGroup1');

userModule.controller('RoleGroupController', ['$scope', '$parse', 'UserGroupService', '$modal', function($scope, $parse, UserGroupService, $modal) {
	$scope.user = {};
    $scope.baseUrl = window.baseUrl;
    if(typeof window.dataController != 'undefined'){
        for(var key in window.dataController){
            var model = $parse(key);
            model.assign($scope, window.dataController[key]);
            /* console.log('info', window.info[key]);*/
        }
    }

    
    $scope.updatePermission = function()
    {
        $scope.error = false;
        $scope.message = {};
        $scope.message.per = '';
        if(angular.isUndefined($scope.message.role)) {
            $scope.message.role = '';
        }

        UserGroupService.updatePermissions($scope.id, Object.keys($scope.groupPermissions)).then(function(data) {
            if(!data.status) {
                $scope.error = true;
                $scope.message.per = data.message;
            }
        });
    }

    $scope.updateRole = function()
    {
        $scope.error = false;
        $scope.message = {};
        $scope.message.role = '';
        if(angular.isUndefined($scope.message.per)) {
            $scope.message.per = '';
        }

        UserGroupService.updateRoles($scope.id, Object.keys($scope.groupRoles)).then(function(data){
            if(!data.status) {
                $scope.error = true;
                $scope.message.role = data.message;
            }
        });
    }


}])

