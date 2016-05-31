var roleModule = angular.module('role');
roleModule.factory('RoleResource', ['$resource',function($resource){
	return $resource('/admin/user/roles/:method/:id', {method:'@method', id: '@id'}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'}
	})
}])

.service('RoleService', ['$q', '$filter', 'RoleResource', '$log',  function($q, $filter, RoleResource, $log){
    var roles = [];
    var that = this;
    var permissionsAvailbale = [];
    var permissionsAssigned = [];

    this.setPermissionsAvailbale = function(data) {
        permissionsAvailbale = data;
    }

    this.getPermissionsAvailbale = function() {
        return permissionsAvailbale;
    }

    this.setPermissionsAssigned = function(data) {
        permissionsAssigned = data;
    }

    this.getPermissionsAssigned = function() {
        return permissionsAssigned;
    }
    /**
     * Call server to create role
     * @param  {[object]} data role info
     * @return {[promise]}      promise
     */
	this.create = function(data) {
        if(typeof data['id'] != 'undefined'){
            return that.update(data);
        }
        var defer = $q.defer(); 
        // data['method'] = 'store';
        // console.log('data test', data);
        var temp = new RoleResource(data);
        temp.$save({},
            function success(data) {
                $log.debug(data,'huy1234');
                if(data.status && data.item){
                    roles.items.push(data.item);
                }
                defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * Call server to update role
     * @param  {[object]} data role info
     * @return {[promise]}      promise
     */
    this.update = function(data) {
        var defer = $q.defer();
        var temp = new RoleResource(data);
        temp.$update({id:data['id']},
            function success(data) {
                // if(data.status && data.item){
                //     for (i in roles) {
                //         if (roles[i]['id'] ==  data.item['id']) {
                //             roles[i] = data.item;
                //             break;
                //         }
                //     }
                // }
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * [get description]
     * @param  {[int]} id role id
     * @return {[promise]}    promise
     */
     this.get = function(id) {
        var defer = $q.defer();

        
        RoleResource.get({id:id}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };
    /**
     * get list roles
     * @return {[promise]} promise contain list roles
     */
    this.query = function() {
        var defer = $q.defer();

        if(roles && roles.length) {
            defer.resolve(roles);
        } else {
            RoleResource.query().$promise
                .then(function(data) {
                    roles = data;
                    defer.resolve(roles);
                }
            );
        }

        return defer.promise;
    };
    /**
     * push roles to service that controller or directive can use it (shared)
     * @param {[array]} data list roles
     */
    this.setData = function(data){
        roles = data;
        return roles;
    }

    /**
     * [getData description]
     * @return {[type]} [description]
     */
    this.getData = function() {
        return roles;
    }
    /**
     * add more role to list roles of service
     * @param  {Role} role role info
     */
    this.pushRole = function(role){
        roles.push(role);
    }
    /**
     * remove role
     * @param  {[int]} id role id
     * @return {[promise]}    contain data that is response from server
     */
    this.remove = function(id) {
        var defer = $q.defer();
        RoleResource.delete({ id: id}, function(data) {
            if(data.status){
                for(var key in roles.items){
                    console.log(roles.items[key]['id']);
                    if(roles.items[key]['id'] == id){
                         roles.items.splice(key, 1);
                         break;
                    }
                   
                }
            }
            defer.resolve(data);
        });

        return defer.promise;
    };

    this.updatePermissions = function(id, permissionId){
        var defer = $q.defer(); 
        // data['method'] = 'store';
        console.log('data test', id, permissionId);
        RoleResource.save({id:id,permissionId: permissionId, method:'update-permission'},
            function success(data) {
                if(data.status) {
                    for(var key in permissionsAvailbale) {
                        if (permissionId ==  permissionsAvailbale[key].id) {
                            permissionsAvailbale.splice(key, 1);
                            permissionsAssigned.push(data.item);
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
    }

    this.deletePermission = function(id, permissionId){
        var defer = $q.defer(); 
        RoleResource.save({id:id,permissionId: permissionId, method:'delete-permission'},
            function success(data) {
                if(data.status) {
                    for(var key in permissionsAssigned) {
                        if (permissionId ==  permissionsAssigned[key].id) {
                            permissionsAssigned.splice(key, 1);
                            permissionsAvailbale.push(data.item);
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
    }

    /**
     * permission map
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    this.getPermissionMap = function() {
        var permissionMap = [];
        for (var key in roles.permissionList) {
            permissionMap[roles.permissionList[key].id] = roles.permissionList[key];
        }
        return permissionMap;
    }

}])
