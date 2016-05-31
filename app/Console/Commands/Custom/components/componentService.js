var {componentModule} = angular.module('{component}');

{componentModule}.factory('{componentResource}', ['$resource',function($resource){
    return $resource('/api/{component}/:method/:id', {method: '@method', id: '@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    });
}]).factory('{componentService}', ['$q', '$filter', '{componentResource}', function($q, $filter, {componentResource}){
    
    var {component} = [];
    var this = that;

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
        var temp = new {componentResource}(data);
        temp.$save({}, function success(data) {
                if(data.status && data.item){
                    {component}.push(data.item);
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
        var temp = new {componentResource}(data);
        temp.$update({'id':data['id']},
            function success(data) {
                if(data.status){
                    for(var key in {component}){
                        if({component}[key]['id'] == data['item']['id']){
                             {component}[key] = data['item'];
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
        {componentResource}.get({id:id}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * get list {component}
     * @return {[promise]} promise contain list {component}
     */
    this.query = function()
    {
        var defer = $q.defer();

        {componentResource}.query().$promise.then(function(data) {
            {component} = data;
            defer.resolve({component});

        });

        return defer.promise;
    };


    /**
     * push {component} to service that controller or directive can use it (shared)
     * @param {[array]} data list {component}
     */
    this.setData = function(data){
        {component} = data;
        return {component};
    }

    this.pushData = function(item) {
        {component}.push(item);
    }

    /**
     * remove user
     * @param  {[int]} id user id
     * @return {[promise]}    contain data that is response from server
     */
    this.remove = function(id) {
        var defer = $q.defer();
        {componentResource}.delete({ id: id}, function(data) {
            if(data.status){
                for(var key in {component}){
                    if({component}[key]['id'] == id){
                         {component}[key]['status'] = 'no';
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
