var typeModule = angular.module('filedType');
typeModule.factory('filedTypeResource', ['$resource',function($resource){
    return $resource('/api/field-type/:method/:id', {method: '@method', id: '@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    })
}])
.service('filedTypeService', ['$q', '$filter', 'filedTypeResource', function($q, $filter, filedTypeResource){
    var that = this;
    var fieldTypes = [];
    this.query = function() {
        var defer = $q.defer();
        filedTypeResource.query(function(data){
            defer.resolve(data);
        });
        return defer.promise;
    };
    this.create = function(data){
        if (typeof data['_id'] != 'undefined')
            return that.update(data);
        var defer = $q.defer();
        var temp = new filedTypeResource(data);
         temp.$save({},
            function success(data) {
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
        var temp = new filedTypeResource(data);
        temp.$update({'id':data['_id']},
            function success(data) {
               defer.resolve(data);

            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });
        return defer.promise;
    };
    this.changeCategory =function(data){
       var defer = $q.defer();
        filedTypeResource.get({id:data,method:'get-category'}, function(data){
            console.log(data);
            defer.resolve(data);
        });

        return defer.promise;
    }
    this.changeOutputType =function(data){
       var defer = $q.defer();
        filedTypeResource.get({id:data,method:'get-output-type'}, function(data){
            defer.resolve(data);
        });

        return defer.promise;
    }
    /**
     * remove user
     * @param  {[int]} id user id
     * @return {[promise]}    contain data that is response from server
     */
    this.remove = function(id) {
        var defer = $q.defer();
        filedTypeResource.delete({ id: id}, function(data) {
            defer.resolve(data);
        });
         return defer.promise;
    }

    this.getFieldAttributes = function(id)
    {
        var defer = $q.defer();

        filedTypeResource.get({id:id,method:'get-field-attributes'}, function(data){
            defer.resolve(data);
        });

        return defer.promise;
    }

    /**
     * Delete field type
     *
     * @author Thanh Tuan <tuan@httsolution>
     *
     * @param  {String} id Field Type id
     *
     * @return {Void}
     */
    this.remove = function (id) {
        var defer = $q.defer();
        var temp  = new filedTypeResource();
        temp.$delete({id: id}, function success(data) {
            if (data.status != 0) {
                for (var key in fieldTypes) {
                    if (fieldTypes[key]._id == id){
                        fieldTypes.splice(key, 1);
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

    this.setFieldTypes = function (data) {
        fieldTypes = data;
        return fieldTypes;
    }

    this.getFieldTypes = function (data) {
        return fieldTypes;
    }
}]);

