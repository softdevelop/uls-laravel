requestBlock.directive('multiSelectBlock', ['$timeout', function ($timeout){
	return {
		restrict: 'EA',
		scope: {
			items : '=',
			itemsAssigned : '=',
			requiredItem: '=',
			placeholder:'@',
		},
		templateUrl: '/app/components/blocks/views/view.html?v=2',
		link: function($scope, $elem, $attr){

			/* When user click assign button */
			$scope.assignItem = function(){
				
				$scope.test = {};

				/* If user selected items */
				if($scope.selectedItemFrom != 'undefined'){

					for(var key in $scope.selectedItemFrom){

						var value = $scope.selectedItemFrom[key];

						$scope.itemsAssigned[value] = $scope.items[value];
						/* Delete item */
						delete $scope.items[value];
					}
					if($scope.requiredItem == true || angular.isUndefined($scope.requiredItem)){
						if(!angular.equals($scope.itemsAssigned, $scope.test)){
							$scope.requiredItem = false;
						}
					}
					/* Set null array for $scope.selectedItemFrom */
					$scope.selectedItemFrom = [];
				}
			};
			
			/* When user click undo button */
			$scope.undoItem = function(){
				/* Conver to Object if items is array */
				if(angular.isArray($scope.items)){
					$scope.items = {};
				}
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