var PermissionModule = angular.module('permission');

PermissionModule.controller('PermissionController', ["$scope", "PermissionService", "$modal", "ngTableParams", "$filter",'$q','$http', function ($scope, PermissionService, $modal, ngTableParams, $filter,$q,$http) {
	$scope.isSearch = false;
  PermissionService.setData(angular.copy(window.permissions));
  $scope.items_s = PermissionService.getData();
	
  angular.element('.bs-example-modal-lg').on('shown.bs.modal', function (e) {
       window.location.href = window.baseUrl + '/admin/user/permissions#container-permission';
       $('#fix-modal-top').scrollTop(0);
  });

  $scope.goToAnchorWithId = function(value){
    window.location.href = window.baseUrl + '/admin/user/permissions#'+value;
    $('#fix-modal-top').scrollTop(0);
  }

  $scope.getModalCreatePermission = function(size) {

		var modalInstance = $modal.open({
			templateUrl: window.baseUrl+'/admin/user/permissions/create',
			controller: 'ModalCreatePermission',
			size: size,
			resolve: {
				
			}
		});

		modalInstance.result.then(function(selectedItem) {
			$scope.items_s = PermissionService.getData();
		}, function() {
		});
	};
	$scope.delete = function(id){
		if (!confirm('Do you want delete this permission?')) return;
    $('#page-loading').css('display','block');
		PermissionService.remove(id).then(function(data){
			$scope.items_s = PermissionService.getData();
      $scope.featureTemplate = window.baseUrl+'/admin/user/permissions/template/get-permission';
      $('#page-loading').css('display','none');
		});
	};

  $scope.featureTemplate = window.baseUrl+'/admin/user/permissions/template/get-permission';

    $scope.selectFeature = function(feature, permission) {
      $scope.permission = permission;
      var v = new Date().getTime();

      switch(feature) {

        case 'edit':
          $scope.featureTemplate = window.baseUrl+'/admin/user/permissions/'+ $scope.permission.id +'/edit' + '?v=' + v;
        break;

        case 'user':
          $scope.featureTemplate = window.baseUrl+'/admin/user/permissions/users-in-group/'+ $scope.permission.id  + '?v=' + v;
        break;
      }
    }

}])
.controller('ModalCreatePermission', ['$scope', '$modalInstance', 'PermissionService', function ($scope, $modalInstance, PermissionService) {

  	$scope.createPermission = function () {

      $scope.permission.name = $scope.permission.name.replace(/\s+/g,' ').toLowerCase();      
      $scope.permission.slug = $scope.permission.name.replace(/\s/g,"_");
      $scope.permission.name = ($scope.permission.name.replace(/(\s[a-z]{1})|^[a-z]/g, function(m){ return m.toUpperCase()})).trim();
      angular.element("#bt-submit").attr("disabled", "true");
	  	PermissionService.create($scope.permission).then(function(data) {
  			if (data.status == 0) {
                angular.element("#bt-submit").removeAttr("disabled");
                $scope.error = 'The name has already been taken.';
            } else {
                $modalInstance.close(data.item);
            }
		});
  	};

  	$scope.cancel = function () {
    	$modalInstance.dismiss('cancel');
  	};
}]);