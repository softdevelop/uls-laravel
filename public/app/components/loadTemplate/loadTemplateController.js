var templateApp = angular.module('uls');
templateApp.controller('loadTemplateController', ['$scope','$compile', function ($scope,$compile) {
	$scope.getBlock = function(pageDescription, positions){
		var contentElement = angular.element('<span>' + pageDescription + '</span>');
		$compile(contentElement)($scope);
		angular.element('#content').append(contentElement);

		for(i in positions) {
			if(positions[i].blocks.length != 0) {
				$position_name = (positions[i].name).toLowerCase();
				for(j in positions[i].blocks) {
					var newElement = angular.element('<span>' + positions[i].blocks[j].body + '</span>');
			        $compile(newElement)($scope);
			        angular.element('#' + $position_name).append(newElement);
				}
			}
		}
	}
}]);