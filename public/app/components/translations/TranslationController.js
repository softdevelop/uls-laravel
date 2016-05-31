
translateApp.controller('TranslateCtrl', ['$scope', '$modal', '$filter', 'ngTableParams', function ($scope, $modal, $filter, ngTableParams) {
	$scope.data = window.translations;
	$scope.getProgress = function(status){
		if(status == 1){
			return "in progress";
		}else{
			return "awaiting approval";
		}
	}

	for(var key in $scope.data){			
		if($scope.data[key].status != 0){
			$scope.data[key].status = "in progress";
		}else{
			$scope.data[key].status = "awaiting approval";
		}
	}
	$scope.tableParams = new ngTableParams({

        page: 1,
        count: 10,
        sorting: {
            parent_name: 'asc'
        },
        filter: {
            parent_name: ''
        }

    }, {

        total: $scope.data.length,

        getData: function ($defer, params) {
        	var filteredData = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
            var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
            params.total(filteredData.length);
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });

    $scope.editTranslation = function(id, pageid){
		window.id = id;
		var modalInstance = $modal.open({
		    animation: $scope.animationsEnabled,
		    templateUrl: window.baseUrl+'/translation-queue/' + id + '/edit' + '?' + new Date().getTime(),
		    controller: 'ModalEditTranslationCtrl',
		    size: null,
		    resolve: {
		    	id: function(){
		    		return id;
		    	},
		    	tableParams: function(){
		    		return $scope.tableParams;
		    	}
		    }
		    
		});

		modalInstance.result.then(function (data) {
			for(var key in $scope.data){
				if($scope.data[key]._id == data._id){
					$scope.data[key].status = $scope.getProgress(data.status);
					$scope.data[key].last_updated = data.last_updated.days;
					$scope.tableParams.reload();
					break;
				}
			}
			
		}, function () {

		   });
	};
}]);

translateApp.controller('ModalEditTranslationCtrl', ['$scope', '$modal', 'tableParams', '$modalInstance', 'id', 'TranslateService', '$timeout','Upload','$http', function ($scope, $modal, tableParams, $modalInstance, id, TranslateService,$timeout,Upload,$http) {
	$scope.submitted = false;

	$scope.submit = function (validate) {
		$scope.submitted = true;

		if(validate){
			return;
		} else {
			$scope.translation.status = 1;
			TranslateService.editTranslateProvider(id, $scope.translation).then(function (data) {
				if(data.status == 0) {
					return;
				} else {
					$modalInstance.close(data.translation_editor);
				}
			})
		}

		
	};
	
	$scope.cancel = function () {
	    $modalInstance.dismiss('cancel');
	};

    $scope.upload = function (files) {
        if (files && files.length) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                Upload.upload({
                    url: window.baseUrl + '/api/translation-queue/file-upload',
                    fields: {
                    },
                    file: file
                }).progress(function (evt) {
                }).success(function (data, status, headers, config) {
                	data.translation.page = $scope.translation.page;
                	data.translation.language = $scope.translation.language;
                	$scope.translation = data.translation;
                });
            }
        } else {
            $scope.error = "Error";
        }
    };

}])