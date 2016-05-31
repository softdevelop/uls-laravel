var roleModule = angular.module('role');

roleModule.controller('RoleUserController', ['$scope','UserService', 'RoleService', 'RoleUserService', '$modal','$filter', '$controller','$timeout', function($scope, UserService, RoleService, RoleUserService, $modal, $filter, $controller, $timeout) {
  $controller('BaseController', { $scope: $scope });
  $scope.roleId = 0;

   $scope.isSelectGroup = true;
  //load user map
  $scope.callbackLoadUserFinish = function(){
  };

  //set data
  $scope.setDataUsersAndGroups = function(data, roleId, groupAvailable , userIdsNotShow)
  {
    RoleUserService.setUsersAvailable(window.usersMap, userIdsNotShow);
    RoleUserService.setGroupsAvailable(groupAvailable);
    RoleUserService.setData(data);
    $scope.usersAndGroupsAvailable = RoleUserService.getUsersAvailable();
    $scope.usersAndGroups = RoleUserService.getData();
    $scope.roleId = roleId;
  }
  $scope.switchAssign = function() {
      $scope.isSelectGroup = !$scope.isSelectGroup;
      if ($scope.isSelectGroup) {
        $scope.usersAndGroupsAvailable = RoleUserService.getUsersAvailable();

      } else {
        $scope.usersAndGroupsAvailable = RoleUserService.getGroupsAvailable();
      }
    }

    //attach user or group selected
    $scope.attachUserOrGroup = function(groupAndUserId, email)
    {
        $scope.error = false;        
        $('#page-loading').css('display', 'block');
        var type = 'group';
        if (angular.isDefined(email)) {
            type = 'user';
        }
        var dataForm = {role_id:$scope.roleId,groupAndUserId:groupAndUserId, type:type};
        RoleUserService.create(dataForm,'add-user-role').then(function(data){
            if(data.status) {
                $scope.usersAndGroups = RoleUserService.getData();
                if (type == 'group') {
                    $scope.usersAndGroupsAvailable = RoleUserService.getGroupsAvailable();
                } else {
                    $scope.usersAndGroupsAvailable = RoleUserService.getUsersAvailable();
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
        RoleUserService.remove({role_id:$scope.roleId, groupAndUserId:groupAndUserId, type:type},'delete-user-role').then(function(data){
            if(data.status) {
                $scope.usersAndGroups = RoleUserService.getData();
                if (type == 'group' && !$scope.isSelectGroup) {
                    $scope.usersAndGroupsAvailable = RoleUserService.getGroupsAvailable();
                } else if (type == 'user' && $scope.isSelectGroup) {
                    $scope.usersAndGroupsAvailable = RoleUserService.getUsersAvailable();
                }
            } else {
                $scope.error = true;
                $scope.message = data.message;
            }
            $('#page-loading').css('display', 'none');
        });

    };

}]);
