
var assign = angular.module('uls');
  assign.directive('choosePeople',['TicketService','$timeout', function(TicketService,$timeout) {
    return {
      restrict: 'EA',
      require: '?ngModel',
      scope: {
        checkAssign: '=',
        ticketId: '=',
        userSelect: '='
      },
      replace: true,
      templateUrl : baseUrl+'/app/shared/assign/views/choose-people.html',

      link: function($scope, element, attrs, ngModel) {
        console.log('ticketId',$scope.ticketId);
        var selection = [];
        var id;
        if(!ngModel) return;
        ngModel.$render = function() {
            $scope.userId = ngModel.$modelValue;
        };
        /*
        * get All users roles = corporate_employee 
        * and brachId = branchId user create ticket if  checkAssign = true
         */
          $scope.users = $scope.userSelect;
        // get userId if checkAssign = true and check radio button
        $scope.getUserId = function(event){
          id = event.target.value;
          ngModel.$setViewValue(id);

        }

        // get usersId if checkAssign = true and check checkbox
        $scope.togglepUserids = function(id) {
           var idx = selection.indexOf(id);
           if (idx > -1) {
             selection.splice(idx, 1);
           }
           else {
             selection.push(id);
           }
           ngModel.$setViewValue(selection);
       }        
      }
    };
  }]);