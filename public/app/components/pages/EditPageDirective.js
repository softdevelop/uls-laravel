editPageApp.directive('multiSelect', ['$timeout', function ($timeout){
	return {
		restrict: 'EA',
		scope: {
			items : '=',
			itemsAssigned : '=',
			requiredItem: '=',
			placeholder:'@',
		},
		templateUrl: '/app/components/pages/views/view.html?v=2',
		link: function($scope, $elem, $attr){
			
			/* When user click assign button */
			$scope.assignItem = function(){
				$scope.test = {};

				/* If user selected items */
				if($scope.selectedItemFrom != 'undefined'){
					/* Each items are selected */
					for(var key in $scope.selectedItemFrom){
						/* Id of item selected */
						var value = $scope.selectedItemFrom[key];
						/* Set item for item assign */
						$scope.itemsAssigned[value] = $scope.items[value];
						/* Delete item */
						delete $scope.items[value];
					}

					/* Validate required for itemAssigned */
					if($scope.requiredItem == true || angular.isUndefined($scope.requiredItem)){
						if(!angular.equals($scope.itemsAssigned, $scope.test)){
							$scope.requiredItem = false;
						}
					}
					/* Set null array for $scope.selectedItemFrom */
					$scope.selectedItemFrom = [];
				}
			}

			/* When user click undo button */
			$scope.undoItem = function(){
				/* Conver to Object if items is array */
				if(angular.isArray($scope.items)){
					$scope.items = {};
				}

				$scope.test = {};

				/* If $scope.selectedItemTo is defined */
				if(angular.isDefined($scope.selectedItemTo)){
					/* If not item selected then stop function */
					if($scope.selectedItemTo.length == 0) return;
					/* Each items selected */
					for(var key in $scope.selectedItemTo){
						/* Id of item selected */
						var value = $scope.selectedItemTo[key];
						/* Set itemsAssigned for item */
						$scope.items[value] = $scope.itemsAssigned[value];
						/* Delete item assigned */
						delete $scope.itemsAssigned[value];
					}

					/* Validate required for itemAssigned */
					if($scope.requiredItem == false || angular.isUndefined($scope.requiredItem)){
						if(angular.equals($scope.itemsAssigned, $scope.test)){
							$scope.requiredItem = true;
						}
					}
					
					/* Set null array for $scope.selectedItemFrom */
					$scope.selectedItemTo = [];
				}
			}
		}
	};

}]);

editPageApp.directive('ensureUrl', ['$http', function ($http) {
	return {
		require: 'ngModel',
		link: function (scope, elem, attrs, c) {
			elem.on('blur', function (evt) {
				if(elem.val() != ''){
					scope.$apply(function () {
						var value = elem.val();
						// var URL_REGEXP = /^\/([a-zA-Z0-9\-]+\/)+/;
						var URL_REGEXP = /^\/([a-zA-Z0-9\-])+/;
						console.log(value.indexOf(' '), 'tuanit');
						/* If is undefined value */
						if(typeof value == 'undefined'){
							c.$setValidity('url', true);
						}else{
							/* If url if url malformed or exists white space in value then validate is true */
		        			if(!URL_REGEXP.test(value) && !URL_REGEXP.test('http://' + value) || (value.indexOf(' ') >= 0)){
								c.$setValidity('url', false);
							}else{/* Else set validate url is false */
								c.$setValidity('url', true);
							}
						}
					});
				}else{
					c.$setValidity('url', true);
				}
			});
		}
	}
}]);