var module = angular.module('multiSelect', []);
module.directive('multiSelect', [function(){
	return {
		restrict: 'EA',
		scope: {
			items : '=',
			itemsAssigned : '=',
			message : '=',
			error : '=',
			placeholder:'@',
			onChange: '&'
		},
		replace: true,
		templateUrl:  baseUrl + '/app/shared/multi-select/view.html?v=2',
		link: function($scope, $elem, $attr){
			$scope.assignPermissions = function(){
				console.log('123');
				if(typeof $scope.selectedItemFrom == 'undefined') return;
				if($scope.selectedItemFrom.length == 0) return;
				for(var key in $scope.selectedItemFrom){
					var value = $scope.selectedItemFrom[key];
					$scope.itemsAssigned[value] = $scope.items[value];
					delete $scope.items[value];
				}
				$scope.selectedItemFrom = [];
				$scope.onChange();
			}

			$scope.undoPermissions = function(){
				console.log('123');
				if(angular.isArray($scope.items)){
					$scope.items = {};
				}
				if(typeof $scope.selectedItemTo == 'undefined') return;
				if($scope.selectedItemTo.length == 0) return;
				console.log('to', $scope.selectedItemTo);

				for(var key in $scope.selectedItemTo){
					var value = $scope.selectedItemTo[key];
					$scope.items[value] = $scope.itemsAssigned[value];
					delete $scope.itemsAssigned[value];
				}
				$scope.selectedItemTo = [];
				$scope.onChange();
			}
		}
	};
}])
.filter("toArray", function(){
	return function(obj) {
		var result = [];
		angular.forEach(obj, function(val, key) {
			result.push(val);
		});
		return result;
	};
})