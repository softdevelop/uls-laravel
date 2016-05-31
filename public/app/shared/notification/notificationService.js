var permissionModule = angular.module('notification');
permissionModule.factory('NotificationResource', ['$resource',function($resource){
	return $resource('/api/notification/:method/:id', {}, {
		add: {method: 'post'},
		save: {method: 'post'}
	})
}]).service('NotificationService', ['$q', '$filter', 'NotificationResource',  function($q, $filter, NotificationResource){
    var notifications = [];
   

    /**
     * [get description]
     * @param  {[int]} id permission id
     * @return {[promise]}    promise
     */
     this.getAmountNotificationsNotRead = function(id) {
        var defer = $q.defer();

        
        NotificationResource.get({method: 'amount-notifications-not-read'}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * get list permissions
     * @return {[promise]} promise contain list roles
     */
    this.query = function(status) {
        var defer = $q.defer();
        if(!status) {
            defer.resolve(notifications);
        } else {
            NotificationResource.query().$promise
                .then(function(data) {
                    notifications = data;
                    defer.resolve(notifications);
                }
            );
        }

        return defer.promise;
    };

    /**
     * Call server to create branch
     * @param  {[object]} data branch info
     * @return {[promise]}      promise
     */
    this.notificationInvite = function(data) {
        console.log('data', data);
        var defer = $q.defer(); 
        var temp = new NotificationResource(data);
        temp.$save({data:data, method:'invite'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };
    
    this.setRead = function(){
        var defer = $q.defer();
        var temp = new NotificationResource();
        temp.$save({method:'set-read'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }

}])
