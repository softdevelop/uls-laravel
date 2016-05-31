var userModule = angular.module('user');
userModule.factory('UserResource', ['$resource',function($resource){
	return $resource('/api/user/:method/:id', {method: '@method', id: '@id'}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'}
	})
}]).factory('UserService', ['$q', '$filter', 'UserResource', function($q, $filter, UserResource){
    var users = [];
    var listRolesMap = [];
    var listDepartmentMap = [];
    var that = this;
    var _hashData = {};
    var itemsByKey = {};
    this.setHashData = function(hashData){
        _hashData = hashData;
    }
   /**
     * Call server to create user
     * @param  {[object]} data user info
     * @return {[promise]}      promise
     */
	this.create = function(data)
    {
        if(typeof data['id'] != 'undefined'){
            return that.update(data);

        }
        var defer = $q.defer(); 
        var temp = new UserResource(data);
        temp.$save({},
            function success(data) {
                if(data.status && data.item){
                    users.push(data.item);
                    if(typeof data.item.last_login == 'undefined') {
                        data.item.last_login = '0000-00-00 00:00:00';       
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
     * Call server to create user
     * @param  {[object]} data user info
     * @return {[promise]}      promise
     */
    this.changePassword = function(data)
    {
      
        var defer = $q.defer(); 
        var temp = new UserResource(data);
        temp.$save({method:'change-password', id: data['id']},
            function success(data) {
                if(data.status){
                   defer.resolve(data);
                }else{
                    defer.reject(data);
                }
                
                
            },
            function error(reponse) {
               defer.reject(reponse.data);
            });

        return defer.promise;
    };
    /**
     * Call server to create user
     * @param  {[object]} data user info
     * @return {[promise]}      promise
     */
    this.changeRoles = function(data)
    {
        var defer = $q.defer(); 
        var temp = new UserResource(data);
        temp.$save({method:'change-roles'},
            function success(data) {
                if(data){
                   defer.resolve(data);
                }else{
                    defer.reject(data);
                }
                
            },
            function error(reponse) {
               defer.reject(reponse.data);
            });

        return defer.promise;
    };
    /**
     * Call server to update user
     * @param  {[object]} data user info
     * @return {[promise]}      promise
     */
    this.update = function(data)
    {
        var defer = $q.defer();
        var temp = new UserResource(data);
        temp.$update({'id':data['id']},
            function success(data) {
                if(data.status){
                    for(var key in users){
                        if(users[key]['id'] == data['item']['id']){
                             users[key] = data['item'];
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
     * @param  {[int]} id user id
     * @return {[promise]}    promise
     */
    this.get = function(id)
    {
        var defer = $q.defer();

        
        UserResource.get({id:id}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * get list users
     * @return {[promise]} promise contain list users
     */
    this.query = function()
    {
        var defer = $q.defer();
        UserResource.query(function(data){
            users = data;
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * get list users
     * @return {[promise]} promise contain list users
     */
    this.queryUsersManager = function()
    {
        var defer = $q.defer();
        UserResource.query({method:'get-all-user-manager'},function(data){
            users = data;
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * remove user
     * @param  {[int]} id user id
     * @return {[promise]}    contain data that is response from server
     */
    this.remove = function(id)
    {
        var defer = $q.defer();
        UserResource.delete({ id: id}, function(data) {
            if(data.status){
                for(var key in users){
                    if(users[key]['id'] == id){
                         users[key]['status'] = 'no';
                         break;
                    }
                   
                }
            }
            defer.resolve(data);
        });
         return defer.promise;
    };

    this.pushUser = function(user)
    {
        users.push(user);

    };
    /**
     * update user
     * @param  {object} user 
     * @return {promise}      [description]
     */
    this.updateUser = function(user)
    {
        for(var key in users){
            if(users[key]['id'] == user.id){
                user.status = 'yes';
                 users[key] = user;
                 break;
            }
           
        }

    };
    /**
     * [changeAvatar description]
     * @param  {id} id     [description]
     * @param  {string} avatar content is base64
     * @return {promise}        [description]
     */
    this.changeAvatar = function(id,avatar)
    {
        var defer = $q.defer();
        UserResource.save({method: 'change-avatar', file: avatar, id: id},
            function success(data) {
              
                defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    this.resetPassword = function(email)
    {
        var defer = $q.defer();
        UserResource.save({method: 'email', entity: 'password', 'email':email},
            function success(data) {
                defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };
    this.getUsers = function()
    {
        return users;
    };

    this.getUserById = function(id)
    {
        return itemsByKey[id];
    };

    this.getUsersMap = function()
    {
        return itemsByKey;
    };
    /**
     * [listMap] Roles and department
     * @param  {[type]} datas [description]
     * @param  {[type]} type  [description]
     * @return {[type]}       [description]
     */
    this.listMap = function(datas,type)
    {
        if(type == 'role'){
            for(var key in datas){
                listRolesMap[datas[key]['id']] = datas[key];
            }
        }else{
            for(var key in datas){
                listDepartmentMap[datas[key]['id']] = datas[key];
            }
        }
        
    };
    /**
     * [userBranchManager] get result map roles and department
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    this.getMap = function(type)
    {
        if(type == 'role'){
            return listRolesMap;
        }
        return listDepartmentMap;
    };

    this.userBranchManager = function(id)
    {
        var defer = $q.defer();
        UserResource.query({id:id,method:'get-users-branch-manager'}, function(data){
            defer.resolve(data);
        });
        return defer.promise;
    };

    this.updatePermissions = function(id, permissionIds)
    {
        var defer = $q.defer();
        console.log('data test', id, permissionIds);
        UserResource.save({id:id,permissionIds: permissionIds, method:'update-permission'},
            function success(data) {
                
               defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    this.updateGroup = function(id, groupIds)
    {
        var defer = $q.defer(); 
        
        UserResource.save({id:id,groupIds: groupIds, method:'update-group'},
            function success(data) {
                
               defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }

    this.updateRoles = function(id, roleIds)
    {
        var defer = $q.defer();
        console.log('data test', id, roleIds);
        UserResource.save({id:id,roleIds: roleIds, method:'update-role'},
            function success(data) {
                
               defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };
     /**
     * remove user
     * @param  {[int]} id user id
     * @return {[promise]}    contain data that is response from server
     */
    this.changeStatus = function(id)
    {
        var defer = $q.defer();
        UserResource.delete({ id: id, method:'change-status'}, function(data) {
            if(data.status){
                for(var key in users){
                    if(users[key]['id'] == id){
                         users[key]['status'] = 'yes';
                         break;
                    }
                   
                }
            }
            defer.resolve(data);
        });
         return defer.promise;
    };

    /**
     * push users to service that controller or directive can use it (shared)
     * @param {[array]} data list users
     */
    this.setData = function(data)
    {
        users = data;
        for(var key in data){
            // if(data[key].deleted_at != null)
                    // continue;
            itemsByKey[data[key].id] = data[key];
        }
        // localStorage.setItem('users', JSON.stringify(users));
        // localStorage.setItem('users_by_key', JSON.stringify(itemsByKey));
        return users;
    };

    this.updateShowDueDateUser = function(data)
    {
        var defer = $q.defer(); 

        var temp = new UserResource(data);
        
        temp.$save({method: 'update-show-due-date-user'}, function success(data) {
            defer.resolve(data);                
        },
        function error(reponse) {
           defer.resolve(reponse.data);
        });

        return defer.promise;
    }

    return this;
}])
