var userModule = angular.module('ticket');

userModule.controller('TicketController', ['$scope','TicketService', function($scope, TicketService) {
  angular.element('.st-container').removeClass('hidden');
  $scope.baseUrl = baseUrl;
  TicketService.getNumberOfTickets().then(function(dataNumber){
      $scope.numberOfTickets = dataNumber;
    }) 
   $scope.$watch(function(){
     return window.innerWidth;
      }, function(value) {
      if(value > 1200){
          TicketService.query().then(function(data){
                  $scope.tickets = data;
          })
      }
    });
  $scope.callbackLoadUserFinish = function(){
  };
}])    