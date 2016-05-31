var roleModule = angular.module('permission');
// The Users directive show list users
roleModule.directive('permissions', ["PermissionService", "$modal", "ngTableParams", "$filter", function(PermissionService, $modal, ngTableParams, $filter){
	return {
		restrict: 'EA',
		// replace: true,
		scope: {items:'='},
		templateUrl: baseUrl+'/app/components/permission/views/index.html',
		link: function($scope,element,attr){
      $scope.baseUrl = window.baseUrl;
			$scope.items_s = PermissionService.setData(angular.copy($scope.items));
			$scope.tableParams = new ngTableParams({
                page: 1, // show first page
                count: 50, // count per page
                sorting: {
                    'name': 'asc' // initial sorting
                }
            }, {
                total: $scope.items_s.length, // length of data
                getData: function($defer, params) {
                    var orderedData = params.sorting() ? $filter('orderBy')($scope.items_s, params.orderBy()) : $scope.items_s;
                    orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
                    params.total(orderedData.length);
                    $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                }
            });
			$scope.getModalCreateDescription = function(id) {
				if (angular.isUndefined(id)) {
					title_text = 'Create Permission';
					url_temp = 'admin/user/permissions/create';
				} else {
					title_text = 'Edit Permission';
					url_temp = 'admin/user/permissions/'+id+'/edit';
				}

				var modalInstance = $modal.open({
					templateUrl: url_temp,
					controller: 'ModalCreatePermission',
					size: null,
					resolve: {
						title_permission:function(){
                            return title_text;
						}
						
					}
				});

				modalInstance.result.then(function(selectedItem) {
					if (id == null) {
						$scope.selected = selectedItem;
					} else {

					}
					$scope.tableParams.reload();
				}, function() {
				});
			};

      $scope.editPermission = function(id) {
        window.location.href = window.baseUrl+"/admin/user/permissions/"+id+"/edit";
      }

			$scope.delete = function(id){
				if (!confirm('Do you want delete this role')) return;
				PermissionService.remove(id).then(function(data){
					$scope.tableParams.reload();
				});
			};

      $scope.showGroup = function($event){
        var w = $(window).outerWidth();
        $($event.target).parent().toggleClass("ac-up");
        $('.group-btn-ac').css({
           top: $event.pageY - 60  + 'px',
           right: w - $event.pageX - 30 + 'px',
        });
        $(document).on('click', function closeMenu (e){
          $(e.target).closest('tr').siblings().find('.wrap-ac-group').removeClass('ac-up');
          if($('.wrap-ac-group').has(e.target).length === 0){
              $('.wrap-ac-group').removeClass('ac-up');
          } else {
              $(document).one('click', closeMenu);
          }
        });
        angular.element('.table-responsive').addClass('fix-height');
      };
		}
	}
}])
.controller('ModalCreatePermission', ['$scope', '$modalInstance', 'PermissionService', 'title_permission', function ($scope, $modalInstance, PermissionService, title_permission) {

  $scope.title_permission = title_permission;
  $scope.createPermission = function () {
  	console.log($scope.permission,'$scope.permission');
  	angular.element("#bt-submit").attr("disabled", "true");
  	$scope.permission.name = angular.lowercase($scope.permission.name).replace(' ','_');
  	PermissionService.create($scope.permission).then(function(data) {
  			if(data.status == 0){
  				angular.element("#bt-submit").removeAttr("disabled");
  				$scope.error = '';
  				for(var key in data.error){
  					$scope.error = data.error[key][0];
  				}
  			}else{
  				$modalInstance.close(data.item);
  			}
			console.log('create', data);
			// $modalInstance.close($scope.selected.item);
	});

  };

	$scope.editPermission = function (id) {
        $scope.permission._id = id;
		PermissionService.update($scope.permission).then(function(data) {
            if(data.status == 0){
  				angular.element("#bt-submit").removeAttr("disabled");
  				$scope.error = '';
  				for(var key in data.error){
  					$scope.error = data.error[key][0];
  				}
  			}else{
  				$modalInstance.close(data.item);
  			}
		});
		console.log(id);
	}

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);