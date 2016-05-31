var TemplateContentManagerModule = angular.module('TemplateContentManager');
TemplateContentManagerModule.factory('TemplateContentManagerResource', ['$resource',function($resource){
	return $resource('/api/template-content-manager/:method/:id', {}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'},
        editNameFolder: {method: 'edit-name-folder'}
	})
}]).service('TemplateContentManagerService', ['$q', '$filter', 'TemplateContentManagerResource', function($q, $filter, TemplateContentManagerResource){

    var templates = [];
    var templateManagers = [];
    var fields = [];
    var sections = [];
    var that = this;

    this.createFolderProvider = function(data){
        var defer = $q.defer();
        var temp  = new TemplateContentManagerResource(data);
        temp.$save({ method:'create-folder'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    this.setData = function(data){

        templates = data;
    }

    this.getData = function()
    {
        return templates;
    }

    this.setTemplateManagers = function(data)
    {
        templateManagers = data

        return templateManagers;

    }

    this.setFiles = function(data)
    {

        for(var key in data) {

            files[data[key].id] = data[key];
        }
    }

    /**
     * Add tag for page
     * @param string id   id of page
     * @param Objedt data data input
     */
    this.addTagsForPage = function(id, data) {
        var defer = $q.defer();
        var temp = new TemplateContentManagerResource(data);
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

	this.create = function(data) {

        if(typeof data['_id'] != 'undefined'){

            return that.update(data);
        }
        var defer = $q.defer();

        var temp = new TemplateContentManagerResource(data);

        temp.$save({ method:'upload-new-template'},function success(data) {

        		if(data['status']){

        			templates.push(data.template);
        		}
                defer.resolve(data);
            },
            function error(reponse) {

               defer.resolve(reponse.data);
        });

        return defer.promise;
    };
    /**
     * @param  {data}
     * @return {[defer.promise]}
     */
    this.update = function(data) {
        var defer = $q.defer();
        var temp = new TemplateContentManagerResource(data);
        temp.$update({'id':data['_id']},function success(data) {
               defer.resolve(data);

            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });
        return defer.promise;
    };

    this.requestProposeNewTemplate = function(data) {

        var defer = $q.defer();
        var temp  = new TemplateContentManagerResource(data);
        temp.$save({}, function success(data) {

            if(data.status) {
                templates.push(data.template);
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;

    }
    this.requestTemplate = function(data){
        if(typeof data['_id'] != 'undefined' && data['modal'] == 'request_translation') {
            return that.requestTranslation(data);
        }

        if(typeof data['_id'] != 'undefined' && data['modal'] == 'request_region') {
            return that.requestRegion(data);
        }
    };

    this.requestTranslation = function(data) {
        var defer = $q.defer();
        var temp  = new TemplateContentManagerResource(data);
        temp.$save({method:'request-translation'}, function success(data) {
            /* Create page success */
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.requestRegion = function(data) {
        var defer = $q.defer();
        var temp  = new TemplateContentManagerResource(data);
        temp.$save({method:'request-region'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.requestTranslation = function(data) {
        var defer = $q.defer();
        var temp  = new TemplateContentManagerResource(data);
        temp.$save({method:'request-translation'}, function success(data) {
            /* Create page success */
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }
    /**
     * parse content config template
     * @param  {[obj]} data [data config]
     * @return {[type]}      [description]
     */
    this.parseContentConfigTemplate = function(data) {

        var defer = $q.defer ();
        var temp = new TemplateContentManagerResource(data);
        temp.$save ({method:'parse-content-config'}, function success (data){
            defer.resolve(data);
        },
        function error (respone){
            defer.resolve(respone.data);
        });
        return defer.promise;
    };

    /**
     * Delete Template
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {String} id Template id
     *
     * @return {Void}
     */
    this.deleteFolderAndTemplate = function (id) {
        var defer = $q.defer();
        var temp  = new TemplateContentManagerResource();
        temp.$delete({id: id}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    /**
     * Delete template's file
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {String} id File id
     *
     * @return {Void}
     */
    this.deleteTemplateFile = function (id) {
        var defer = $q.defer();
        var temp  = new TemplateContentManagerResource();
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
        var temp  = new TemplateContentManagerResource(data);
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


}])
