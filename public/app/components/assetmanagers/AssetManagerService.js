var assetmanagerApp = angular.module('assetManager', ['ngResource', 'ui.bootstrap', 'ngSanitize', 'ngTable'])
assetmanagerApp.factory('AssetManagerResource',['$resource', function ($resource){
    return $resource('/api/asset-manager/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'},
        editNameFolder: {method: 'edit-name-folder'}
    });
}])
.service('AssetManagerService', ['AssetManagerResource', '$q', function (AssetManagerResource, $q) {
    var that = this;
    var assetManagers = [];
    
    this.createFolderProvider = function(data){
        if(typeof data['id'] != 'undefined') {
            return that.editFolderAndFile(data);
        }
		var defer = $q.defer();
        var temp  = new AssetManagerResource(data);
        temp.$save({ method:'create-folder'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
        	defer.resolve(reponse.data);
        });
        return defer.promise;
	};
    this.uploadNewAsset = function(data){
        var defer = $q.defer();
        var temp  = new AssetManagerResource(data);
        temp.$save({ method:'upload-new-asset'}, function success(data) {
            if(data.status != 0) {
                assetManagers.push(data.item);
            }
            defer.resolve(data.item);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };
    this.createNewAsset = function(data){
        var defer = $q.defer();
        var temp  = new AssetManagerResource(data);
        temp.$save({ method:'create-new-asset'}, function success(data) {
            if(data.status != 0) {
                assetManagers.push(data.item);
            }
            defer.resolve(data.item);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };
    this.saveFieldFile = function(data){
        var defer = $q.defer();
        var temp  = new AssetManagerResource(data);
        temp.$save({ method:'save-file-asset'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    this.editFile = function(data){
        var defer = $q.defer();
        var temp  = new AssetManagerResource(data);
        temp.$save({ method:'edit-file'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    this.crop = function(data){
        var defer = $q.defer();
        var temp  = new AssetManagerResource(data);
        temp.$save({ method:'crop'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };


    /**
     * Add tag for page
     * @param string id   id of page
     * @param Objedt data data input
     */
    this.addTagsForPage = function(id, data) {
        var defer = $q.defer();
        var temp = new AssetManagerResource(data);
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

	this.getAssetManagerById = function(key){
		var defer = $q.defer();
        var temp  = new AssetManagerResource();
        temp.$get({id: key}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
        	defer.resolve(reponse.data);
        });
        return defer.promise;
	};
    this.setAssetManagers = function(data) {
        assetManagers = data;
        return assetManagers;
    };

    this.getAssetManagers = function() {
        return assetManagers;
    }
    /**
     * get url show Imafe asset
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    this.getUrlImageAsset = function(id) {

        var defer = $q.defer();

        AssetManagerResource.get({id:id,method:'get-url-image-asset'}, function(data){
            // console.log(data);
            defer.resolve(data);
        });

        return defer.promise;
    }

    /**
     * Delete Asset
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {String} id Asset id
     *
     * @return {Void}
     */
    this.deleteFolderAndAsset = function (id) {
        var defer = $q.defer();
        var temp  = new AssetManagerResource();
        temp.$delete({id: id}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    /**
     * Delete asset file
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {String} id Id of file
     *
     * @return {Void}
     */
    this.deleteAssetFile = function (id) {
        var defer = $q.defer();
        var temp  = new AssetManagerResource();
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
    this.editNameFolder = function(data){
        var defer = $q.defer();
        var temp  = new AssetManagerResource(data);
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

    /**
     * [updateContentFile description]
     * update content file
     *
     * @author [bang@httsolution.com]
     *
     * @param  {[type]} data [information of current file]
     * @return {[type]}      [description]
     */
    this.updateContentFile = function(fileId, data) {
        console.log(data);

        var defer = $q.defer();

        var temp  = new AssetManagerResource(data);

        temp.$save({id: fileId, method: 'update-content-file'}, function success(result) {
            // if(data.status != 0){
                defer.resolve(result);
            // }
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }
}])
