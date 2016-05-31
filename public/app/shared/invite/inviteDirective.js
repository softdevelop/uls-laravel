
var assign = angular.module('uls');
  assign.directive('invite',['TicketService','UserService', function(TicketService,UserService) {
    return {
      restrict: 'EA',
      require: '?ngModel',
      scope: {
        item: '=',
      },
      replace: true,
      transclude: true,
      templateUrl : baseUrl+'/app/shared/invite/views/invite.html',

      link: function($scope, element, attrs, ngModel) {
          // get all user ticket  
          UserService.query().then(function(){
             $scope.users_map = UserService.getUsersMap();
          });
          $scope.convetUnixTime = function(strToTime,unixTimestamp){
              var unixTimestampFormat = '';
              if(typeof strToTime !== 'undefined'){
                  unixTimestampFormat = strToTime;
              }else{
                  unixTimestampFormat = unixTimestamp;
              }
              var date = new Date(unixTimestampFormat*1000);
              return date;
         }
        }
    };
  }]);