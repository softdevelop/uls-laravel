var permissionModule = angular.module('permission');
permissionModule.factory('PermissionResource', ['$resource',function($resource){
	return $resource('/admin/user/api/permissions/:method/:id', {}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'}
	})
}]).service('PermissionService', ['$q', '$filter', 'PermissionResource',  function($q, $filter, PermissionResource){
    var permissions = [];
    /**
     * Call server to create permission
     * @param  {[object]} data role info
     * @return {[promise]}      promise
     */
	this.create = function(data) {
        var defer = $q.defer(); 
        // data['method'] = 'store';
        // console.log('data test', data);
        var temp = new PermissionResource(data);
        temp.$save({},
            function success(data) {
                if(data.status && data.item){
                    permissions.push(data.item);
                }
                defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * Call server to update service
     * @param  {[object]} data service info
     * @return {[promise]}      promise
     */
    this.update = function(data) {
        var defer = $q.defer(); 
        // data['method'] = 'store';
        // console.log('data test', data);
        var temp = new PermissionResource(data);
        temp.$update({id:data['id']},
            function success(data) {
                if(data.status && data.item){
                    for (i in permissions) {
                        if (permissions[i]['id'] ==  data.item['id']) {
                            permissions[i] = data.item;
                            break;
                        }
                    }
                }
                defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * [get description]
     * @param  {[int]} id permission id
     * @return {[promise]}    promise
     */
     this.get = function(id) {
        var defer = $q.defer();

        
        PermissionResource.get({id:id}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * get list permissions
     * @return {[promise]} promise contain list roles
     */
    this.query = function() {
        var defer = $q.defer();

        if(permissions && permissions.length) {
            defer.resolve(permissions);
        } else {
            PermissionResource.query().$promise
                .then(function(data) {
                    permissions = data;
                    defer.resolve(permissions);
                }
            );
        }

        return defer.promise;
    };

    /**
     * push roles to service that controller or directive can use it (shared)
     * @param {[array]} data list permissions
     */
    
    this.setData = function(data){
        permissions = data;
    }

    this.getData = function(data)
    {
        return permissions;
    }

    /**
     * add more role to list roles of service
     * @param  {Permission} permission permission info
     */
    this.pushPermission = function(item){
        permissions.push(item);
    }

    /**
     * remove permission
     * @param  {[int]} id ropermissionle id
     * @return {[promise]}    contain data that is response from server
     */
    this.remove = function(id) {
        var defer = $q.defer();
        PermissionResource.delete({ id: id}, function(data) {
            if(data.status){
                for(var key in permissions){
                    if(permissions[key]['id'] == id){
                         permissions.splice(key, 1);
                         break;
                    }
                   
                }
            }
            defer.resolve(data);
        });

        return defer.promise;
    };

}])
