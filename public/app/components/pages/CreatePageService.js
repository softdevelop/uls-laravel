var createPageApp = angular.module('CreatePageApp');
createPageApp.factory('CreatePageResource',['$resource', function ($resource){
    return $resource('/api/pages/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'},
        check: {method: 'post'}
    });
}])
.service('CreatePageService', ['CreatePageResource', '$q', function (CreatePageResource, $q) {
    var that = this;
    var pages = [];
    /* create new page */
    this.createPageProvider = function(data){
        if(typeof data['_id'] != 'undefined' && data['modal'] == 'request_translation') {
            return that.requestTranslation(data);
        }

        if(typeof data['_id'] != 'undefined' && data['modal'] == 'request_region') {
            return that.requestRegion(data);
        }

        if(typeof data['_id'] != 'undefined' && data['modal'] == 'request_revision') {
            return that.requestRevision(data);
        }

        var defer = $q.defer(); 
        var temp  = new CreatePageResource(data);
        temp.$save({}, function success(data) {
            /* Create page success */
            if(data.status != 0) {
                /* Push new page to array pages */
                pages.push(data.page);
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

    this.requestTranslation = function(data) {
        var defer = $q.defer(); 
        var temp  = new CreatePageResource(data);
        temp.$save({method:'request-translation'}, function success(data) {
            /* Create page success */
            if(data.status != 0) {
                /* Push new page to array pages */
                pages.push(data.page);
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.requestRegion = function(data) {
        var defer = $q.defer(); 
        var temp  = new CreatePageResource(data);
        temp.$save({method:'request-region'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.requestRevision = function(data) {
        var defer = $q.defer(); 
        var temp  = new CreatePageResource(data);
        temp.$save({method:'request-revision'}, function success(data) {
            if(data.status != 0) {
                defer.resolve(data);
            }
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    /* Edit page */
    this.editPageProvider = function(id, data){
        var defer = $q.defer(); 
        var temp  = new CreatePageResource(data);
        temp.$update({id: id}, function success(data) {
            /* Foreach array pages */
            for (var key in pages){
                /* If page in array = page edit then assign page edit for page */
                if (pages[key]['key'] == data.page.key){
                    pages[key] = data.page;
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

    /* Check url page is exists */
    this.checkUrlExists = function(id, data){
        var defer = $q.defer(); 
        var temp  = new CreatePageResource(data);
        temp.$check({id: id, method: 'check-url'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

    /* Get position of template */
    this.getTemplatePosition = function (templateId){
        var defer = $q.defer(); 
        CreatePageResource.get({method: 'get-position', id:templateId}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    this.formatContentWithTemplatePosition = function(data){
        //init content
        var content = {};

        for (var key in data) {
            if(angular.isUndefined(content[data[key].template_id])) {
                content[data[key].template_id] = {};
            }
            content[data[key].template_id][data[key].position_id] = data[key].content;
        }

        return content;

    }

}])