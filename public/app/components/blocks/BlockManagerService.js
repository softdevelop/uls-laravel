var blockApp = angular.module('BlockApp');

blockApp.factory('BlockManagerResource',['$resource', function ($resource){
    return $resource('/api/block-manager/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'},
        editNameFolder: {method: 'edit-name-folder'}
    });
}])
.service('BlockManagerService', ['BlockManagerResource', '$q', function (BlockManagerResource, $q) {
    var that = this;
    var blockManagers = [];

    this.createFolderProvider = function(data){
        var defer = $q.defer();
        var temp  = new BlockManagerResource(data);
        temp.$save({ method:'create-folder'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };
    /**
     * add new 
     *
     * @author minh than <than@httsolution.com>
     * @param {[type]} data [description]
     */
    this.addNew = function(data){
        // of exits id block then transfer to function update block
        if(angular.isDefined(data['_id'])){
            return that.editBlock(data); // edit block
        }
		var defer = $q.defer();
        var temp  = new BlockManagerResource(data);
        // call method add new block
        temp.$save({ method:'add-new'}, function success(data) {
            defer.resolve(data); // resolve when success add new block
        },
        function error(reponse) {
        	defer.resolve(reponse.data);// resolve when error add new block
        });
        return defer.promise; // return promise data when add new block
	};
    /**
     * review content block
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    this.reviewContentBlock = function(data) {

        var defer = $q.defer();
        var temp = new BlockManagerResource(data);

        temp.$save({method:'review-content-block'}, function success(result) {
            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });

        return defer.promise;
    }
    /**
     * edit block
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    this.editBlock = function(data) {

        var defer = $q.defer();
        var temp  = new BlockManagerResource(data);
        temp.$update({id:data['_id'], method:'edit-block'}, function success(data) {

            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };
    /**
     * [parseContentBlock description]
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    this.parseContentBlock = function(data) {
        var defer = $q.defer ();
        var temp = new BlockManagerResource (data);
        temp.$save ({method:'parse-content-config'}, function success (data){
            defer.resolve(data);
        },
        function error (respone){
            defer.resolve(respone.data);
        });
        return defer.promise;
    };

    this.getHtmlFieldsCms = function(data) {
        var defer = $q.defer ();
        var temp = new BlockManagerResource (data);
        temp.$save ({method:'get-htm-fields-cms'}, function success (data){
            defer.resolve(data);
        },
        function error (respone){
            defer.resolve(respone.data);
        });
        return defer.promise;
    }

    /**
     * Add tag for page
     * @param string id   id of page
     * @param Objedt data data input
     */
    this.addTagsForPage = function(id, data) {
        var defer = $q.defer();
        var temp = new BlockManagerResource(data);
        temp.$save({
                id: id,
                method: 'add-tags'
            }, function success(data) {
                // If add tags successfull
                if (data.status != 0) {

                }
                defer.resolve(data);
            },
            function error(reponse) {
                defer.resolve(reponse.data);
            });
        return defer.promise;
    }

    this.parseContentConfigBlock = function(data) {

        var defer = $q.defer ();
        var temp = new BlockManagerResource(data);
        temp.$save ({method:'parse-content-config'}, function success (data){
            defer.resolve(data);
        },
        function error (respone){
            defer.resolve(respone.data);
        });
        return defer.promise;
    };

    this.getContentForIframe = function () {
        var defer = $q.defer();
        var temp  = new BlockManagerResource(data);

        temp.$save({method:'get-content-iframe'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    /**
     * Delete block
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {String} id Block id
     *
     * @return {Void}
     */
    this.deleteFolderAndBlock = function (id) {
        var defer = $q.defer();
        var temp  = new BlockManagerResource();
        temp.$delete({id: id}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    /**
     * Delete file of block
     *
     * @author Thanh Tuan <tuan@httsolution.com
     *
     * @param  {String} id Id of file
     *
     * @return {Void}
     */
    this.deleteBlockFile = function (id) {
        var defer = $q.defer();
        var temp  = new BlockManagerResource();
        temp.$get({id: id, method: 'delete-file'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    /**
     * Edit name of folder page
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  Object data Folder
     *
     * @return Void
     */
    this.editNameFolder = function(data) {
        var defer = $q.defer();
        var temp  = new BlockManagerResource(data);
        temp.$save({id: data['id'], method: 'edit-name-folder'}, function success(data) {
            if(data.status != 0){
                defer.resolve(data);
            }
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.getDataBlock = function(data) {

        var defer = $q.defer(); 
        var temp  = new BlockManagerResource(data);

        temp.$save({method:'get-data-block'}, function success(result) {
            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;

    }

}])
