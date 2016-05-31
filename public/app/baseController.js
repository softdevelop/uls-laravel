angular.module('uls')
.controller('BaseController', ['$scope', '$parse', '$timeout', '$modal', 'UserService', 'AssetManagerService', 
	function($scope, $parse, $timeout, $modal, UserService, AssetManagerService){
	angular.element('.wrapper').removeClass('hidden');
	UserService.setData(window.usersMap);
	$timeout(function(){
		if(typeof $scope.callbackLoadUserFinish != 'undefined'){
			$scope.callbackLoadUserFinish();
			$scope.users_map = UserService.getUsersMap();
		}
	});
	
	$scope.testFuture = window.testFuture;
	if($scope.testFuture == true) {
		angular.element('.test').removeClass('hidden');
	}
	
	// $scope.pusher = window.pusher;
	// var channel = $scope.pusher.subscribe('user');
	// channel.bind('online', function(data) {
 //     	if(typeof $scope.callbackOnline != 'undefined'){
 //     		$scope.callbackOnline.call(null, data['id'], data['is_online']);
 //     	}

 //    });
    $scope.windowType = window.info;
	if(typeof window.info != 'undefined'){
		for(var key in window.info){
			var model = $parse(key);
			model.assign($scope, window.info[key]);
		}
	}

	$scope.initDate = function(){
		angular.element('.date').bdatepicker({ 
	       format: "yyyy-mm-dd"
	      });
	}
	$scope.viewModalImage = function(id)
	{	console.log(id);
	    var modalInstance = $modal.open({
	        templateUrl: baseUrl+'/app/components/termTemplateManager/views/modal/viewImage.html',
	        controller: 'ModalViewPictureCtrl',
	        size: undefined,
	        windowClass: 'show-img',
	        resolve: {
	          fileId: function () {
	            return id;
	          }
	        }
	    });
	    modalInstance.result.then(function (selectedItem) {
	    }, function () {
	    });
	};
	$scope.urlForm = [];
	/**
	 * GET URL SHOW IMAGE
	 * @param  {[type]} id [description]
	 * @return {[type]}    [description]
	 */

	$scope.getUrlImageAssetForm = function(id, index) {
		if(typeof $scope.urlForm[id] == 'undefined'){
			$scope.urlForm[id] = [];
		}
		AssetManagerService.getUrlImageAsset(id).then(function (data){
				$scope.urlForm[id][index] = data['url']; // return url image not multi
				console.log('$scope.url[id]', $scope.urlForm[id]);
			
		})
	}

	$scope.removeThumbnailAssertForm = function(id, index) {
		console.log('id', id);
		console.log('index', index);
		$scope.urlForm[id][index] = '';
	}

	$scope.initTooltip = function (element) {
		$('[data-toggle="tooltip"]').tooltip();
	}

}])
.controller('ModalViewPictureCtrl', ['$scope', '$modalInstance','fileId', function ($scope, $modalInstance, fileId) {
    $scope.fileId = fileId;
    $scope.baseUrl = baseUrl;
    $scope.cancel = function(){
      $modalInstance.dismiss('cancel');
    };
}])