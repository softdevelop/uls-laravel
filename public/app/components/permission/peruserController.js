var permissionModule = angular.module('permission');

permissionModule.controller('PermissionUserController', ['$scope','UserService', 'PerUserService', '$modal','$filter', '$controller', '$timeout', function($scope, UserService, PerUserService, $modal, $filter, $controller, $timeout) {
    $controller('BaseController', { $scope: $scope });
    $scope.permissionId = 0;

    $scope.isSelectGroup = true;

    //load user map
    $scope.callbackLoadUserFinish = function(){
    };

    //set data
    $scope.setDataUsersAndGroups = function(data, permissionId, groupAvailable , userIdsNotShow)
    {
      PerUserService.setUsersAvailable(window.usersMap, userIdsNotShow);
      PerUserService.setGroupsAvailable(groupAvailable);
      PerUserService.setData(data);
      $scope.usersAndGroupsAvailable = PerUserService.getUsersAvailable();
      $scope.usersAndGroups = PerUserService.getData();
      $scope.permissionId = permissionId;
    }

    $scope.switchAssign = function() {
      $scope.isSelectGroup = !$scope.isSelectGroup;
      if ($scope.isSelectGroup) {
        $scope.usersAndGroupsAvailable = PerUserService.getUsersAvailable();

      } else {
        $scope.usersAndGroupsAvailable = PerUserService.getGroupsAvailable();
      }
    }


    //attach user or group selected
    $scope.attachUserOrGroup = function(groupAndUserId, email) {
        $scope.error = false;
        $('#page-loading').css('display', 'block');
        var type = 'group';
        if (angular.isDefined(email)) {
            type = 'user';
        }
        PerUserService.create({permissionId: $scope.permissionId,groupAndUserId:groupAndUserId, type:type},'add-user-permission').then(function(data){
            if(data.status) {
                $scope.usersAndGroups = PerUserService.getData();
                if (type == 'group') {
                    $scope.usersAndGroupsAvailable = PerUserService.getGroupsAvailable();
                } else {
                    $scope.usersAndGroupsAvailable = PerUserService.getUsersAvailable();
                }                
            } else {
                $scope.error = true;
                $scope.message = data.message;
            }
            $('#page-loading').css('display', 'none');
        });
    }   

    //detach user or group
    $scope.detachAssignedUserAndGroup = function(groupAndUserId, email){
        $scope.error = false;

        $('#page-loading').css('display', 'block');
        var type = 'group';
        if (angular.isDefined(email)) {
            type = 'user';
        }
        PerUserService.remove({permissionId: $scope.permissionId, groupAndUserId:groupAndUserId, type:type},'delete-user-permission').then(function(data){
            if(data.status) {
                $scope.usersAndGroups = PerUserService.getData();
                $scope.usersAndGroups = PerUserService.getData();

                if (type == 'group' && !$scope.isSelectGroup) {
                    $scope.usersAndGroupsAvailable = PerUserService.getGroupsAvailable();
                } else if (type == 'user' && $scope.isSelectGroup) {
                    $scope.usersAndGroupsAvailable = PerUserService.getUsersAvailable();
                }                
            } else {
                $scope.error = true;
                $scope.message = data.message;
            }
            $('#page-loading').css('display', 'none');
        });
    };

}]);
