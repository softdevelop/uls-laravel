var languageApp = angular.module('AppLanguage', ['ui.bootstrap', 'ngResource', 'ngTable']);
languageApp.factory('LanguageResource',['$resource', function ($resource){
    return $resource('/api/languages/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}])
.service('LanguageService', ['LanguageResource', '$q', function (LanguageResource, $q) {
    var that = this;
    var languages = [];
	this.createLanguageProvider = function(data){
        if(typeof data['id'] != 'undefined') {
            return that.editLanguageProvider(data);
        }
		var defer = $q.defer(); 
        var temp  = new LanguageResource(data);
        temp.$save({}, function success(data) {
            defer.resolve(data);
            if(data.status != 0) {
                languages.push(data.language);
            }
        },
        function error(reponse) {
        	defer.resolve(reponse.data);
        });
        return defer.promise;  
	};

    this.editLanguageProvider = function(data){
        var defer = $q.defer(); 
        var temp  = new LanguageResource(data);
        temp.$update({id: data['id']}, function success(data) {
            if(data.status != 0){
                for (var key in languages) {
                    if (languages[key].id == data.language.id){
                        languages[key] = data.language;
                        break;
                    }
                }
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    };

    this.deleteLanguage = function (id) {
        var defer = $q.defer(); 
        var temp  = new LanguageResource();
        temp.$delete({id: id}, function success(data) {
            for (var key in languages) {
                if (languages[key].id == id){
                    languages.splice(key, 1);
                    break;
                }
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    this.setLanguages = function(data) {
        languages = data;
        return languages;
    }
    
    this.getLanguages = function() {
        return languages;
    }

}]);
