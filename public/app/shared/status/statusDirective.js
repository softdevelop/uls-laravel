
var module = angular.module('uls');
  module.directive('status',['TicketService', function(TicketService) {
    return {
      restrict: 'EA',
      require: '?ngModel',
      scope: {
        item: '=',
      },
      templateUrl : baseUrl+'/app/shared/status/views/status.html',

      link: function($scope, element, attrs, ngModel) {
      		TicketService.getConfig().then(function(data){
      			console.log(data);
				    $scope.states = data['states'];
			   });
       }
    };
  }]);