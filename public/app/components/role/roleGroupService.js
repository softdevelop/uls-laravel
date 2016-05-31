var roleModule = angular.module('roleGroup1');
roleModule.factory('UserGroupResource', ['$resource',function($resource){
    return $resource('/api/roles/:method/:id', {method:'@method', id: '@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    })
}])

.service('UserGroupService', ['$q', '$filter', 'UserGroupResource',  function($q, $filter, UserGroupResource){
    this.create = function(data) {
        var defer = $q.defer();

        var temp = new UserGroupResource(data);

        temp.$save({},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }
    this.update = function(data) {
        var defer = $q.defer();

        var temp = new UserGroupResource(data);

        temp.$update({id:data.id},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }

    this.updatePermissions = function(id, permissionIds){
        var defer = $q.defer(); 
        
        UserGroupResource.save({id:id,permissionIds: permissionIds, method:'update-permission'},
            function success(data) {
                
               defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }

      this.updateRoles = function(id, roleIds){
        var defer = $q.defer(); 
        
        UserGroupResource.save({id:id,roleIds: roleIds, method:'update-role'},
            function success(data) {
                
               defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }
    
    
    this.addUserToGroup = function(data) {
        var defer = $q.defer();

        var temp = new UserGroupResource(data);

        temp.$save({id : data.userGroupId, method:'add-user-to-group'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }
    this.removeUser = function(data) {
        var defer = $q.defer();

        var temp = new UserGroupResource(data);

        temp.$save({id:data.userGroupId,method:'remove-user-from-user-group'},
            function success(data)
            {
                defer.resolve(data);
            },
            function error(reponse)
            {
                defer.resolve(reponse);
            }
        );

        return defer.promise;
    }

    this.removeGroup = function(id) {
        var defer = $q.defer();
        var temp = new UserGroupResource();
        temp.$delete({ id: id}, function(data) {
            defer.resolve(data);
        });
         return defer.promise;
    }
}])
