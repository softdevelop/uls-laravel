angular.module('nlc').controller('NotificationController', ['$scope', '$filter', 'UserService', 'NotificationService', '$controller', function($scope, $filter, UserService, NotificationService, $controller){
	 	$controller('BaseController', { $scope: $scope });
	 	$scope.callbackLoadUserFinish = function(){
	 		console.log('calllback good');
	 	}
	 	angular.element('#notification-top').removeClass('hidden');
	 	$scope.baseUrl = baseUrl;
	 	
	    var channel = $scope.pusher.subscribe('ticket');
	    $scope.notifications = [];
	    // amount notifications that user not read
	    $scope.amount = 0; 
	    var events = ['create_ticket', 'assign_ticket', 'invite_ticket', 
	    'close_ticket', 'open_ticket', 'deny_ticket',
	    'response_ticket', 'remove_assign_ticket', 'add_private_comment_ticket'
	    ];
	    for(var key in events){
	    	channel.bind(events[key], function(data) {
		      $scope.$apply(function(){
		      	console.log('user_id',data.user_id.indexOf(window.userId));
		      	if(typeof data.user_id != 'undefined' && data.user_id.indexOf(window.userId) != -1){
		      		// $scope.notifications.push(data);
		      		$scope.amount++; 
		      	}
		      })
		    });
	    }
	    
	    $scope.getNotifications = function(){
	    	NotificationService.query().then(function(items){
				$scope.notifications = items;
				$scope.amount = 0;
			})

	    }
		NotificationService.getAmountNotificationsNotRead().then(function(data){
			$scope.amount = data.result;
		});
		


}]);