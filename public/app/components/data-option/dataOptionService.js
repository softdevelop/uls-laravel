var typeModule = angular.module('dataOption'); 
typeModule.factory('DataOptionResource', ['$resource',function($resource){
    return $resource('/api/data-option/:method/:id', {method: '@method', id: '@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    })
}])
.service('DataOptionService', ['$q', '$filter', 'DataOptionResource', function($q, $filter, DataOptionResource){
    var that = this;
    var dataOption = {};
    this.create = function(data){
        var defer = $q.defer();
        var temp = new DataOptionResource(data);
         temp.$save({},
            function success(data) {
                dataOption.push(data.item);
                defer.resolve(data);
            },
            function error(reponse) {
                console.log(reponse);
               defer.resolve(reponse);
            });
        return defer.promise;
    }
        /**
     * Call server to update user
     * @param  {[object]} data user info
     * @return {[promise]}      promise
     */
    this.update = function(data) {
        var defer = $q.defer(); 
        var temp = new DataOptionResource(data);
        temp.$update({'id':data['_id']}, function success(data) {
            for(var key in dataOption){
                if(dataOption[key]['_id'] == data.item['_id']){
                    dataOption[key] = data.item;
                    break;
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
     * remove user
     * @param  {[int]} id user id
     * @return {[promise]}    contain data that is response from server
     */
    this.remove = function(id) {
        var defer = $q.defer();
        DataOptionResource.delete({ id: id}, function(data) {
            for(var key in dataOption){
                if(dataOption[key]._id == id){
                    dataOption.splice(key, 1);
                }
            }
            defer.resolve(data);
        });
         return defer.promise;
    }
    this.setDataOption = function(data){
        dataOption = data;
        return dataOption;
    }
    this.getDataOption = function(){
        return dataOption;
    }
}]);
 