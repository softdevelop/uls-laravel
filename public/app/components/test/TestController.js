var app = angular.module('test', []);
app.controller('testCtrl',[ '$scope','TestService', function($scope,TestService) {
	$scope.id = [];
	$scope.getTags = function(id){
		TestService.getTags(id).then(function(data) {

		});
	}
}]);
