var databasemanagerApp = angular.module('databaseManager', ['ngResource', 'ui.bootstrap', 'ngSanitize', 'ngTable'])
databasemanagerApp.factory('DatabaseManagerResource',['$resource', function ($resource){
    return $resource('/api/database-manager/:method/:id/:title', {'method':'@method','id':'@id', 'title':'@title'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'},
        show : {method: 'get'},
        editNameFolder: {method: 'edit-name-folder'},
    });
}])
.service('DatabaseManagerService', ['DatabaseManagerResource', '$q', function (DatabaseManagerResource, $q) {
    var that = this;
    var databaseManagers = [];
    
    this.createFolderProvider = function(data){
        var defer = $q.defer();
        var temp  = new DatabaseManagerResource(data);
        temp.$save({method: 'create-folder'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    this.createCategory = function(data){
        if (typeof data['id'] != 'undefined') {
            return that.editCategory(data);
        }
        var defer = $q.defer();
        var temp  = new DatabaseManagerResource(data);
        temp.$save({method: 'create-category'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    this.editCategory = function(data) {
        var defer = $q.defer(); 
        var temp  = new DatabaseManagerResource(data);

        temp.$save({'id':data['id'], method:'edit-category'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });

        return defer.promise;
    }

    this.requestTranslation = function(data) {
        var defer = $q.defer(); 
        var temp  = new DatabaseManagerResource(data);
        temp.$save({method:'request-translation-material'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.requestRegion = function(data) {
        var defer = $q.defer(); 
        var temp  = new DatabaseManagerResource(data);
        temp.$save({method:'request-region-material'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }
    /**
     * Edit name category
     * @author Thanh Tuan <tuan@httsolution.com>
     * @param  {Object} data Category
     * @return {Void}      
     */
    this.editNameCategory = function(data){
        var defer = $q.defer();
        var temp  = new DatabaseManagerResource(data);
        temp.$save({id: data['id'], method: 'edit-name-category'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    /**
     * Delete Database
     * @author Thanh Tuan <tuan@httsolution.com>
     * @param  {String} id Block id
     * @return {Void}
     */
    this.deleteCategoryAndMaterial = function (data) {
        var defer = $q.defer();
        var temp  = new DatabaseManagerResource();
        temp.$delete({id: data['id'], type: data['type']}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }
     /**
     * Delete Database
     * @author Van linh <vanlinh@httsolution.com>
     * @param  {String} id Block id
     * @return {Void}
     */
    this.deleteMaterial = function (id, type) {
        var defer = $q.defer();
        var temp  = new DatabaseManagerResource();
        temp.$delete({id: id, type:type}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }
}])
