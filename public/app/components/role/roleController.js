var roleModule = angular.module('role');

roleModule.controller('RoleController', ['$scope', '$parse', 'RoleService', '$modal','$filter','$log', function($scope, $parse, RoleService, $modal, $filter, $log) {
	$scope.baseUrl = window.baseUrl;
  $scope.currentRoleIdActive = 0;
  $scope.role = {};
	$scope.items_s = RoleService.setData(angular.copy(window.dataRoles));

   angular.element('.bs-example-modal-lg').on('shown.bs.modal', function (e) {
       window.location.href = window.baseUrl + '/admin/user/roles#container-roles';
       $('#fix-modal-top').scrollTop(0);
  });

  $scope.goToAnchorWithId = function(value){
    window.location.href = window.baseUrl + '/admin/user/roles#'+value;
    $('#fix-modal-top').scrollTop(0);
  }


  //set data to role service
  $scope.setData = function(permissionsAvailbale, permissionsAssigned) {

    //set data of permision available and permission of assigned
    RoleService.setPermissionsAvailbale(permissionsAvailbale);
    RoleService.setPermissionsAssigned(permissionsAssigned);

    //get data of permission available and permission of assigned
    $scope.permissionsAvailbale = RoleService.getPermissionsAvailbale();
    $scope.permissionsAssigned = RoleService.getPermissionsAssigned();
  }



    $scope.delete = function(id) {
        if (!confirm('Do you want delete this role?')) return;
        RoleService.remove(id).then(function(data) {
          $scope.items_s = RoleService.getData();
          $scope.featureTemplate = window.baseUrl+'/admin/user/roles/template/get-roles';
        });
    }

    $scope.getModalCreateRole = function(id) {
        var templateUrl = '/admin/user/roles/create';
        if (typeof id != 'undefined') {
            templateUrl = '/admin/user/roles/' + id + '/edit' + '?' + new Date().getTime();
        }
        var modalInstance = $modal.open({
            templateUrl: templateUrl,
            controller: 'ModalCreateRole',
            size: undefined,
            resolve: {}
        });
        modalInstance.result.then(function(selectedItem) {
          $scope.items_s = RoleService.getData();
          $log.debug($scope.items_s,'huy123');
          $scope.featureTemplate = window.baseUrl+'/admin/user/roles/template/get-roles';
        }, function() {});
    };


    $scope.attachPermission = function(permissionId) {
      $scope.error = false;
      $('#page-loading').css('display', 'block');
      RoleService.updatePermissions($scope.roleData.id, permissionId).then(function(data){
        if(data.status) {
          $scope.permissionsAvailbale = RoleService.getPermissionsAvailbale();
          $scope.permissionsAssigned = RoleService.getPermissionsAssigned();
        } else {
          $scope.error = true;
          $scope.message = data.message;
        }
        $('#page-loading').css('display', 'none');
      });
    }

    $scope.detachPermission = function(permissionId) {
      $scope.error = false;
      $('#page-loading').css('display', 'block');
      RoleService.deletePermission($scope.roleData.id, permissionId).then(function(data){
        if(data.status) {
          $scope.permissionsAvailbale = RoleService.getPermissionsAvailbale();
          $scope.permissionsAssigned = RoleService.getPermissionsAssigned();          
        } else {
          $scope.error = true;
          $scope.message = data.message;
        }
        $('#page-loading').css('display', 'none');
      });

    }


    $scope.showPermisionOfRoleId = function(id) {
        var modalInstance = $modal.open({
          animation: $scope.animationsEnabled,
          templateUrl: window.baseUrl+'/admin/user/roles/permissions/'+id+ '?' + new Date().getTime(),
          controller: 'ShowRolePermissionCtrl',
          // size: size,
          resolve: {
            // items: function () {
            //   return $scope.items;
            // }
          }
        });

        modalInstance.result.then(function (selectedItem) {
          // $scope.selected = selectedItem;
        }, function () {
          // $log.info('Modal dismissed at: ' + new Date());
        });
    }

    $scope.featureTemplate = window.baseUrl+'/admin/user/roles/template/get-roles';

    $scope.selectFeature = function(feature, role) {
      $scope.roleData = role;
      var v = new Date().getTime();

      switch(feature) {
        case 'permission':
          $scope.featureTemplate = window.baseUrl+'/admin/user/roles/get-permissions-of-role/'+$scope.roleData.id + '?v=' + v;
        break;

        case 'edit':
          $scope.featureTemplate = window.baseUrl+'/admin/user/roles/'+$scope.roleData.id+'/edit' + '?v=' + v;
        break;

        case 'user':
          $scope.featureTemplate = window.baseUrl+'/admin/user/roles/users-in-group/'+$scope.roleData.id + '?v=' + v;
        break;
      }
    }
}]);

roleModule.controller('ShowRolePermissionCtrl', ['$scope', '$modalInstance',  function ($scope, $modalInstance) {

  // $scope.items = items;
  // $scope.selected = {
  //   item: $scope.items[0]
  // };

  // $scope.ok = function () {
  //   $modalInstance.close($scope.selected.item);
  // };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);

roleModule.controller('ModalCreateRole', ['$scope', '$timeout', '$modalInstance', 'RoleService',function($scope, $timeout, $modalInstance, RoleService) {
        $timeout(function() {
            // angular.element("#permission-select").select2();

            // if (typeof $scope.role != 'undefined') angular.element("#permission-select").select2('val', $scope.role.permissions);
        }, 100)

        $scope.createRole = function() {
            angular.element("#bt-submit").attr("disabled", "true");

            $scope.role.name = $scope.role.name.replace(/\s+/g,' ').toLowerCase();
            $scope.role.slug = $scope.role.name.replace(/\s/g,"_");
            $scope.role.name = ($scope.role.name.replace(/(\s[a-z]{1})|^[a-z]/g, function(m){ return m.toUpperCase()})).trim();

            RoleService.create($scope.role).then(function(data) {
                if (data.status == 0) {
                    angular.element("#bt-submit").removeAttr("disabled");
                    $scope.error = '';
                    for (var key in data.error) {
                        $scope.error = data.error[key][0];
                    }
                } else {
                    $modalInstance.close(data.item);
                }

                // $modalInstance.close($scope.selected.item);
            });
        };
        $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
        };
    }
]);
