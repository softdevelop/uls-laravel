notificationModule = angular.module('notification');
notificationModule.directive('notification', [function(){
	return {
		restrict: 'AE',
		scope: {
			item: '='
		},
		replace: true,
		templateUrl: baseUrl+'/app/shared/notification/views/notification.html',
		link: function(){
			
		}
	}
}])