var roleModule = angular.module('role');

roleModule.controller('RoleEditorController', ['$scope', '$parse', 'RoleService', '$modal','$filter','$q','$http', function($scope, $parse, RoleService, $modal, $filter,$q,$http) {
      console.log(window.dataRoles);
      $scope.baseUrl = window.baseUrl;

	$scope.updateRole = function(role) {
		$scope.errorRole = false;
		RoleService.update(role).then(function(data){
	  		if(data.status == -1) {
	  			return $scope.errorRole = true;
	  		} else {	  			
	  			angular.forEach($scope.items_s.items, function(value,key){
	  				if(data.item.id == value.id) {
	  					value.name = data.item.name
	  				}
	  			});
	  		}
	  	});
	};

	$scope.checkDescriptionRole = function (data,role) {
		if(data == '') {
			return 'The Description is a required field';
		} else {
			if(angular.isUndefined($scope.role) || $scope.role == null){
				return 'The Role do not exist!.';
			}
			$scope.role.description = data;
			return $scope.updateRole(role);
		}
	}

	$scope.checkNameRole = function (data,id) {
		// console.log(id,'id');
		if(data == '') {
			return "The Role name is a required field";
		} else {
			var d = $q.defer();
		    $http.post('/admin/user/api/roles/check-name', {id:id, roleName:data}).success(function(res) {
		        res = res || {};
		        if(res.status == -1) {
					d.resolve('The Role do not exist!.');
		        } else if(res.status == 1) {
		            $scope.role.name = data;
		            $scope.updateRole($scope.role);
		            d.resolve();
		        } else {
		            d.resolve('The Role name has already been taken.');
		        }
		    }).error(function(e){
		        d.reject('Server error!');
		    });
		    return d.promise;
		}
	  }

}]);

