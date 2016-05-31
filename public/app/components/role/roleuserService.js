var roleModule = angular.module('role');
roleModule.factory('RoleUserResource', ['$resource',function($resource){
	return $resource('/admin/user/roles/:method/:id', {method:'@method', id: '@id'}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'}
	})
}])

.service('RoleUserService', ['$q', '$filter', 'RoleUserResource',  function($q, $filter, RoleUserResource){
     var usersAndGroups = [];
    var usersAvailable = [];
    var groupsAvailable = [];

    this.setUsersAvailable = function(data, usersIdNotShow) {
        usersAvailable = [];
        for (var key in data) {
            if ((usersIdNotShow.indexOf(data[key].id) !== -1 && angular.isDefined(data[key].email)) || data[key].deleted_at != null ) {
                continue;
            }
            usersAvailable.push(data[key]);
        }
    }

    this.setGroupsAvailable = function(data) {
       groupsAvailable = data;
    }

    this.getUsersAvailable = function() {
        return usersAvailable;
    }

    this.getGroupsAvailable = function() {
        return groupsAvailable;
    }
    /**
     * Call server to create role
     * @param  {[object]} data role info
     * @return {[promise]}      promise
     */
  this.create = function(data, method) {
        var defer = $q.defer(); 
        
        var temp = new RoleUserResource(data);
        temp.$save({method: method}, function success(result) {
            if(result.status) {
                usersAndGroups = result.usersAndGroups;
                if (result.type == 'user') {
                    for(var key in usersAvailable) {
                        if (data['groupAndUserId'] == usersAvailable[key].id) {
                            usersAvailable.splice(key, 1);
                            break;
                        }
                    }
                } else {
                    for(var key in groupsAvailable) {
                        if (data['groupAndUserId'] == groupsAvailable[key].id) {
                            groupsAvailable.splice(key, 1);
                            break;
                        }
                    }
                }
            }
            defer.resolve(result);
            
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
        
        var temp = new RoleUserResource(data);
        temp.$update({id:data['id']},
            function success(data) {
               
               defer.resolve(data);
                
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * remove role
     * @param  {[int]} id role id
     * @return {[promise]}    contain data that is response from server
     */
    this.remove = function(data, method) {
        var defer = $q.defer(); 
        
        var temp = new RoleUserResource(data);
        temp.$save({method:method ,id: data.role_id},
            function success(result) {
                if(result.status) {
                    usersAndGroups = result.usersAndGroups;
                    var exists = false;
                    if (result.type == 'user') {
                         for(var key in usersAvailable){
                            if(usersAvailable[key].id == result.item.id){
                                exists = true;
                                break;
                            }
                         }
                         if(exists != true){
                            usersAvailable.push(result.item);
                         }
                    } else {
                        for(var key in groupsAvailable){
                            if(groupsAvailable[key].id == result.item.id){
                                exists = true;
                                break;
                            }
                         }
                        if(exists != true){
                            groupsAvailable.push(result.item);
                        }
                    }
                }
                defer.resolve(result);
            },
            
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
        
    };

    this.setData = function(data)
    {
        usersAndGroups = data;
    }

    this.getData = function()
    {
        return usersAndGroups;
    }
}]);
