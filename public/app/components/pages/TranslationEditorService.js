var pageApp = angular.module('pageApp');

pageApp.factory('TranslationEditorResource', ['$resource', function($resource) {
    return $resource('/api/pages/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'},
        export : {method: 'get'}
    });
}])
.service('TranslationEditorService', ['TranslationEditorResource', '$q', function(TranslationEditorResource, $q) {
    this.export = function (data) {
        var defer = $q.defer();
        var temp  = new TranslationEditorResource(data);
        temp.$save({method:'export-translation'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }
    this.saveTranlationEdit = function (data) {
        var defer = $q.defer();
        var temp  = new TranslationEditorResource(data);
        temp.$save({method:'save-translation'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.importFileCSV = function (data) {
        var defer = $q.defer();
        var temp  = new TranslationEditorResource({file:data});
        temp.$save({method:'import'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }
}])
