var translation = angular.module('translation', []);
translation.filter('trans', ['$filter',function($filter) {
    return function(key, module) {
        if (key == null) {
            return "";
        }
        return window.translations[module][key];
    };
}])