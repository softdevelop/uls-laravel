angular.module('uls').controller('NotificationController', ['$scope', '$filter', 'NotificationService', '$controller','$timeout', function($scope, $filter, NotificationService, $controller,$timeout){
	 	$controller('BaseController', { $scope: $scope });
	 	$scope.callbackLoadUserFinish = function(){
	 	}

	 	angular.element('#notification-top').removeClass('hidden');
	 	$scope.baseUrl = window.baseUrl;
	 	var limit = 10;
	 	$scope.limitTo = limit;
	 	var status = 1;
	    $scope.notifications = [];
	    var queueNotification = [];
	    var isShowing = false;
	    // amount notifications that user not read
	    $scope.amount = 0; 


	    $(".scroll-noti1").scroll(function(){
		    if($(this)[0].scrollHeight - $(this).scrollTop() === $(this).outerHeight()) {
		    	$scope.$apply(function(){
					$scope.limitTo = $scope.limitTo + limit;
				});
		    };
		});

	    var channel = RowboatPusher.subscribe('notification_ticket');
        channel.bind('Rowboat\\Notification\\Events\\Notifications\\Broadcast\\NotificationTicket', function(data){
		      $scope.$apply(function(){
		      	if(typeof data.data.user_id != 'undefined' && data.data.user_id.indexOf(window.userId) != -1){
		      		doNotification(data);
		      		status = 1;
		      		$scope.amount++; 
		      	}
		      })
	    }); 
	    $scope.getNotifications = function(){
	    	NotificationService.query(status).then(function(items){
                if(status) {
                    $scope.setUserReadThisNotification();                    
                }

                $scope.notifications = items;
                $scope.hightlight = angular.copy($scope.amount);
                $scope.amount = 0;
                status = 0;
			})
	    }

        $scope.setUserReadThisNotification = function() {
            NotificationService.setRead().then(function(){

            });
        }

		NotificationService.getAmountNotificationsNotRead().then(function(data){
			$scope.amount = data.result;
		});
		
		//Desktop alert for notification
		function onShowNotification () {
        }

        function onCloseNotification () {
            isShowing = false;
            // if queueNotification's data still,  show alert desktop
            if(queueNotification.length > 0){
            	var data = queueNotification.shift();
            	doNotification(data);
            }
        }

        function onClickNotification () {
        }

        function onErrorNotification () {
            console.error('Error showing notification. You may need to request permission.');
        }

        function onPermissionGranted () {
            doNotification();
        }

        function onPermissionDenied () {
            console.warn('Permission has been denied by the user');
        }

        function doNotification (data) {
            if(isShowing) {
            	queueNotification.push(data);
            	return;
            }
            isShowing = true;
            if(data.data.sender_id == -1) {
                var avatar = $scope.baseUrl + '/160x160_avatar_default.png?t=1';
            } else {
        	   var avatar = $scope.users_map[data.data.sender_id].avatar;                
            }
        	var myNotification = new Notify('Notification', {
            	icon : avatar,
                body: data.data.message,
                tag: data.data.sender_id,
                notifyShow: onShowNotification,
                notifyClose: onCloseNotification,
                notifyClick: function(){
                				window.location.href = '/' + data.data.href;
					          },
                notifyError: onErrorNotification,
                timeout: 5
            });

            myNotification.show();
        }
}]);