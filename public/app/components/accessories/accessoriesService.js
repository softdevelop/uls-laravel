var accessoriesModule = angular.module('accessories');

accessoriesModule.factory('AccessoriesResource', ['$resource',function($resource){
    return $resource('/api/accessories/:method/:id', {method: '@method', id: '@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    });
}]).factory('AccessoriesService', ['$q', '$filter', 'AccessoriesResource', function($q, $filter, AccessoriesResource){
    
    var accessories = [];
    var that = this;

    /**
     * Call server to create user
     * @param  {[object]} data user info
     * @return {[promise]}      promise
     */
    this.create = function(data) {
        if(typeof data['id'] != 'undefined'){
            return that.update(data);

        }
        var defer = $q.defer();
        var temp = new AccessoriesResource(data);
        temp.$save({}, function success(data) {
                if(data.status && data.item){
                    accessories.push(data.item);
                }
                defer.resolve(data);

            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    this.createFolderProvider = function(data){
        var defer = $q.defer();
        var temp  = new AccessoriesResource(data);
        temp.$save({ method:'create-folder'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };
    /**
     * Call server to update user
     * @param  {[object]} data user info
     * @return {[promise]}      promise
     */
    this.update = function(data) {
        var defer = $q.defer();
        var temp = new AccessoriesResource(data);
        temp.$update({'id':data['id']},
            function success(data) {
                if(data.status){
                    for(var key in accessories){
                        if(accessories[key]['id'] == data['item']['id']){
                             accessories[key] = data['item'];
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
     this.get = function(id) {
        var defer = $q.defer();
        AccessoriesResource.get({id:id}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * get list accessories
     * @return {[promise]} promise contain list accessories
     */
    this.query = function()
    {
        var defer = $q.defer();

        AccessoriesResource.query().$promise.then(function(data) {
            accessories = data;
            defer.resolve(accessories);

        });

        return defer.promise;
    };


    /**
     * push accessories to service that controller or directive can use it (shared)
     * @param {[array]} data list accessories
     */
    this.setData = function(data){
        accessories = data;
        return accessories;
    }

    this.pushData = function(item) {
        accessories.push(item);
    }

    /**
     * remove user
     * @param  {[int]} id user id
     * @return {[promise]}    contain data that is response from server
     */
    this.remove = function(id) {
        var defer = $q.defer();
        AccessoriesResource.delete({ id: id}, function(data) {
            if(data.status){
                for(var key in accessories){
                    if(accessories[key]['id'] == id){
                         accessories[key]['status'] = 'no';
                         break;
                    }

                }
            }
            defer.resolve(data);
        });
         return defer.promise;
    }
    return this;
}])
