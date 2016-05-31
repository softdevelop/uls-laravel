angular.module('uls').directive('scenarioRequest', ['TicketService','$controller', function(TicketService,$controller){
		
		return {
			restrict: 'EA',
			scope: {
				item:'=',
			},
			templateUrl: baseUrl + '/app/components/scenario-request/views/index.html',
			link: function($scope, element, attr){
				$controller('BaseController', { $scope: $scope });
				console.log('items',$scope.item);

				$scope.toogleInternalOnly = function(event){
					if(angular.element('#collapse-11').hasClass('in')){
						angular.element(event.target).text('+');
					}else{	
						angular.element(event.target).text('-');
					}
				}
			 }
		}
}]);