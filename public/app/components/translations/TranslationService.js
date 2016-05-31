var translateApp = angular.module('transApp', ['ui.bootstrap', 'ngResource', 'ngTable', 'ngSanitize','ngFileUpload']);

translateApp.factory('TranslationResource',['$resource', function ($resource){
    return $resource('api/translation-queue/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}]);

translateApp.service('TranslateService', ['TranslationResource', '$q', function (TranslationResource, $q) {
    this.editTranslateProvider = function(id, data){
        var defer = $q.defer(); 
        var temp  = new TranslationResource(data);
        temp.$update({id: id}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

}])