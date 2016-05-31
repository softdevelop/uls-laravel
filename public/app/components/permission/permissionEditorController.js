var PermissionModule = angular.module('permission');

PermissionModule.controller('PermissionEditorController', ["$scope", "PermissionService",'$q','$http', function ($scope, PermissionService,$q,$http) {

  $scope.checkNamePerm = function (data,id) {
  
    $status = 1;
    if(data == '') {
        return "The Permission name is a required field";
    } else {
        var d = $q.defer();
        $http.post('/admin/user/api/permissions/check-name', {id:id, permName:data}).success(function(res) {
            res = res || {};
            if(res.status == -1) {
              d.resolve('The Permission do not exist!');
            } else if(res.status == 1) {
                $scope.perm.name = data;
                $scope.updatePerm($scope.perm);
                d.resolve();
            } else {
                d.resolve('The Permission name has already been taken.');
            }
        }).error(function(e){
            d.reject('Server error!');
        });
        return d.promise;
    }
  }

  $scope.checkDescription = function (data) {
    if(data=='') {
      return 'The Description is a required field';
    } else {
      if(angular.isUndefined($scope.perm) || $scope.perm == null) {
        return 'The Permission do not exist!';
      }
      $scope.perm.description = data;
      $scope.updatePerm($scope.perm);
    }
  }

  $scope.updatePerm = function (perm) {
    $scope.errorPer = false;
    PermissionService.update($scope.perm).then(function(data){
      if(data.status == -1) {
        $scope.errorPer = true;
      } else if(data.status) {
          angular.forEach($scope.items_s, function(value,key){
            if(perm.id == value.id) {
              value.name = perm.name
            }
          });
      }
    });
  }
}])
