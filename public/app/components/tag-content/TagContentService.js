var tagContentApp = angular.module('tagContentApp');

tagContentApp.factory('TagContentResource',['$resource', function ($resource){
    return $resource('/site-configuration/api/tag-content/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'},
        check: {method: 'post'}
    });
}])
.service('TagContentService', ['TagContentResource', '$q', function (TagContentResource, $q) {
    // Contain tag format parent and child
    var tagsContent = [];
    var that = this;
    
    /* create new tag content */
    this.createTagContent = function(data, type){
        if (type == 'edit') {
            return that.editTagContent(data);
        }
        var defer = $q.defer();
        var temp  = new TagContentResource(data);
        temp.$save({}, function success(data) {
            /* Create tag content success */
            if(data.status != 0) {
                tagsContent = data.tagsContent;
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    /* Edit tag content */
    this.editTagContent = function(data){
        var defer = $q.defer();
        var temp  = new TagContentResource(data);
        temp.$update({id: data['_id']}, function success(data) {
            if (data.status != 0) {
                tagsContent = data.tagsContent;
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    /* Delete tag */
    this.deleteTag = function (id) {

        // Call to server to delete tag
        var defer = $q.defer();
        var temp  = new TagContentResource();
        temp.$delete({id: id}, function success(data) {
            // Delete successfull
            if (data.status != 0) {
                tagsContent = data.tagsContent;
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    /* Set data tags content */
    this.setTagContent = function(data) {
        tagsContent = data;
        return tagsContent;
    }

    /* Get array tags content */
    this.getTagContent = function() {
        return tagsContent;
    }

}])
