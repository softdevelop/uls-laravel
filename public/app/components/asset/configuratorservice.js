var configuratorModule = angular.module('databaseManager');

configuratorModule.factory('ConfiguratorResource', ['$resource',function($resource){
    return $resource('/api/configurator/:method/:id', {method: '@method', id: '@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    });
}]).factory('ConfiguratorService', ['$q', '$filter', 'ConfiguratorResource', function($q, $filter, ConfiguratorResource){
    
    var configurator = [];
    var that = this;

    /**
     * Call server to create user
     * @param  {[object]} data user info
     * @return {[promise]}      promise
     */
    this.create = function(data) {
        if(typeof data['_id'] != 'undefined'){
            return that.update(data);

        }
        var defer = $q.defer();
        var temp = new ConfiguratorResource(data);
        temp.$save({}, function success(data) {
                if(data.status && data.item){
                    configurator.push(data.item);
                }
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
        var temp = new ConfiguratorResource(data);
        temp.$update({'id':data['_id']},
            function success(data) {
                if(data.status){
                    for(var key in configurator){
                        if(configurator[key]['id'] == data['item']['id']){
                             configurator[key] = data['item'];
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
    this.getLaserOfPlatformLater = function(id) {
        var defer = $q.defer();
        GuideConfiguratorResource.get({id:id,method:'get-laser-of-platform-later'}, function(data) {
            defer.resolve(data);
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
        ConfiguratorResource.get({id:id}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * get list configurator
     * @return {[promise]} promise contain list configurator
     */
    this.query = function()
    {
        var defer = $q.defer();

        ConfiguratorResource.query().$promise.then(function(data) {
            configurator = data;
            defer.resolve(configurator);

        });

        return defer.promise;
    };


    /**
     * push configurator to service that controller or directive can use it (shared)
     * @param {[array]} data list configurator
     */
    this.setData = function(data){
        configurator = data;
        return configurator;
    }

    this.pushData = function(item) {
        configurator.push(item);
    }

    /**
     * remove user
     * @param  {[int]} id user id
     * @return {[promise]}    contain data that is response from server
     */
    this.remove = function(id) {
        var defer = $q.defer();
        ConfiguratorResource.delete({ id: id}, function(data) {
            if(data.status){
                for(var key in configurator){
                    if(configurator[key]['id'] == id){
                         configurator[key]['status'] = 'no';
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
