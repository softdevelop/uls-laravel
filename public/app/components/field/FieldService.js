var typeModule = angular.module('filed');
typeModule.factory('filedResource', ['$resource',function($resource){
    return $resource('/api/field/:method/:id', {method: '@method', id: '@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    })
}])
.service('filedService', ['$q', '$filter', 'filedResource', function($q, $filter, filedResource){
    var that = this;

    var fields = [];

    this.create = function(data){
        if (typeof data['_id'] != 'undefined')
            return that.update(data);
        var defer = $q.defer();
        var temp = new filedResource(data);
         temp.$save({},
            function success(data) {

                defer.resolve(data);

            },
            function error(reponse) {

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
        var temp = new filedResource(data);
        temp.$update({'id':data['_id']},
            function success(data) {
               defer.resolve(data);

            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });
        return defer.promise;
    };

    this.remove = function(id)
    {
        var defer = $q.defer();
        filedResource.delete({ id: id}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    }

    /**
     * Delete field
     *
     * @author Thanh Tuan <tuan@httsolution>
     *
     * @param  {String} id Field id
     *
     * @return {Void}
     */
    this.remove = function (id) {
        var defer = $q.defer();
        var temp  = new filedResource();
        temp.$delete({id: id}, function success(data) {
            if (data.status != 0) {
                for (var key in fields) {
                    if (fields[key]._id == id){
                        fields.splice(key, 1);
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

    this.setFields = function (data) {
        fields = data;
        return fields;
    }

    this.getFields = function (data) {
        return fields;
    }

}]);

