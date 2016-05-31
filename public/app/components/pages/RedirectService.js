var redirectApp = angular.module('pageApp', []);

redirectApp.factory('RedirectResource',['$resource', function ($resource){
    return $resource('/api/pages/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}]);

redirectApp.service('RedirectService', ['RedirectResource', '$q', function (RedirectResource, $q) {

    var redirects = [];

    this.setDataRedirects = function(data) {
        redirects = data;
        return redirects;
    }

    this.getDataRedirects = function() {
        return redirects;
    }

    this.addRedirect = function(data) {
        var defer = $q.defer(); 
        var temp  = new RedirectResource(data);

        temp.$save({method:'add-redirect'}, function success(result) {
            if(result.status) {
                redirects.push(result.redirect);
            }
            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.removeRedirect = function(id) {
        var defer = $q.defer();
        data = {redirectId:id};
        var temp  = new RedirectResource(data);

        temp.$save({method:'remove-redirect'}, function success(result) {
            for(i in redirects) {
                if(redirects[i]._id == id){
                    redirects.splice(i,1);
                    break;
                }
            }
            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }
}])