var nestedBlockApp = angular.module('BlockNestedApp');

nestedBlockApp.factory('BlockNestedResource',['$resource', function ($resource){
    return $resource('/api/block-manager/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'},
    });
}])
.service('BlockNestedService', ['BlockNestedResource', '$q', function (BlockNestedResource, $q) {

    /**
     * Update nested block
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @param  {Object} data Nested block data
     * 
     * @return {Void}    
     */
    that = this;
    this.updateNestedBlock = function (data) {
        var defer = $q.defer(); 
        var temp = new BlockNestedResource(data);
        temp.$save({method: 'update-nested-block'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise; 
    }
    
	/**
     * Delete nested block
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @param  {String} id Nested block id
     * 
     * @return {Void}    
     */
    this.deleteContentNestedBlock = function (id) {
        var defer = $q.defer(); 
        var temp  = new BlockNestedResource();
        temp.$get({id: id, method: 'delete-nested-block'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }
    /**
     * get data nested block
     *
     * @author Minh than <than@httsolution.com>
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    this.getDataNestedBlock = function(data) {
        var defer = $q.defer(); 
        var temp = new BlockNestedResource(data);
        temp.$save({method: 'get-data-nested-block'}, function success(data) {

           for(var key in data.results) {
            
                if(angular.isObject(data.results[key])) {
                    data.results[key] = that.convertObjectToArray(data.results[key]);
                }
                for(var key1 in data.results[key]) {
                    if(angular.isObject(data.results[key][key1])) {

                        data.results[key][key1] = that.convertObjectToArray(data.results[key][key1]);
                    }
                    for(var key2 in data.results[key][key1]) {
                        data.results[key][key1][key2]['data'] = angular.extend({}, data.results[key][key1][key2]['data']); 
                    }
                }
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.result);
        });
        return defer.promise;         
    }
    /**
     * convert object to array
     * @param  {[type]} objets [description]
     * @return {[type]}        [description]
     */
    this.convertObjectToArray = function(objets) {
        array = [];
        for( var i in objets) {
          if (objets.hasOwnProperty(i)){
             array.push(objets[i]);
          }
        }
        return array;      
    }
    /**
     * re index
     * @author Minh than <than@httsolution.com>
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    this.reIndex = function(data) {

        var defer = $q.defer(); 
        var temp = new BlockNestedResource(data);
        temp.$save({method: 're-index-nested-block'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise; 
    }
    this.saveNestedBlock = function(data) {
        tmpData = data;
        var defer = $q.defer(); 
        var temp = new BlockNestedResource(data);
        temp.$save({method: 'save-data-nested-block'}, function success(result) {

            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;         
    }

    this.updateIndexNestedWhenSortField = function(data) {

        tmpData = data;
        var defer = $q.defer(); 
        var temp = new BlockNestedResource(data);
        temp.$save({method: 'update-index-nested-block-sort-field'}, function success(result) {

            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;         
    }
}])
