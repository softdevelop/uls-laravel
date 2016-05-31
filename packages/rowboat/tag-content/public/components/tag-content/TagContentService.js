var tagContentApp = angular.module('tagContentApp');

tagContentApp.factory('TagContentResource',['$resource', function ($resource){
    return $resource('/api/tag-content/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'},
        check: {method: 'post'}
    });
}])
.service('TagContentService', ['TagContentResource', '$q', function (TagContentResource, $q) {
    var that = this;
    var tagsContent = [];
    /* create new tag content */
    this.createTagContent = function(data){
        var defer = $q.defer();
        var temp  = new TagContentResource(data);
        temp.$save({}, function success(data) {
            /* Create tag content success */
            if(data.status != 0) {
                /* Push new tag content to array tag contents */
                tagsContent.push(data.tagContent);
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    /* Edit tag content */
    this.editTagContent = function(id, data){
        var defer = $q.defer();
        var temp  = new TagContentResource(data);
        temp.$update({id: id}, function success(data) {
            /* Foreach array tag contents */
            for (var key in tagsContent){
                /* If tag content in array = tag content edit then assign tag content edit for tag content */
                if (tagsContent[key]['key'] == data.tagContent._id){
                    tagsContent[key] = data.tagContent;
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

    this.deleteTag = function (id) {
        console.log(id,'lol');
        // var defer = $q.defer();
        // var temp  = new TagContentResource();
        // temp.$delete({id: id}, function success(data) {
        //     defer.resolve(data);
        // },
        // function error(reponse) {
        //     defer.resolve(reponse.data);
        // });
        // return defer.promise;
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
