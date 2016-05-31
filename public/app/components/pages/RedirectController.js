var redirectApp = angular.module('pageApp');
redirectApp.controller('RedirectController', ['$scope', '$modal', '$filter', 'ngTableParams', '$http', '$window', '$timeout', '$filter','$controller','RedirectService', 
    function ($scope, $modal, $filter, ngTableParams, $http, $window, $timeout, $filter,$controller,RedirectService){
        $controller('BaseController', { $scope: $scope });
        $scope.callbackLoadUserFinish = function(){
    
        };
        $scope.isSearch = false;

        $scope.redirect = {};
        $scope.redirect.header = "301";
        $scope.redirects = RedirectService.setDataRedirects(window.redirects);

        $scope.page = window.page;
        $scope.baseUrl = window.baseUrl;

        $scope.tableRedirectParams = new ngTableParams({
            page: 1,
            count: 10,
            sorting: {
                url: 'asc'
            },
            filter: {
                url:''
            }
        }, {
            total: $scope.redirects.length,
            getData: function ($defer, params) {
                var filteredData = params.filter() ? $filter('filter')($scope.redirects, params.filter()) : $scope.redirects;
                var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
                
                params.total(orderedData.length);
                if (params.total() <= params.count()) {
                params.page(1);
                } else {
                    if (params.total() % params.count() == 0  && params.total() / params.count() < params.page() && params.page() != 1) {
                        params.page(params.page()-1);
                    }
                };

                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            }
        });
        
        $scope.addRedirect = function(validate) {
            $scope.submitted = true;
            if(validate) {
                return;
            }
            $('#page-loading').css('display', 'block');

            $scope.redirect.content_id = $scope.page.content_id;

            RedirectService.addRedirect($scope.redirect).then(function (data) {
                $('#page-loading').css('display', 'none');

                if(data.status) {
                    $scope.redirects = RedirectService.getDataRedirects();
                    
                    // $scope.redirect.header = "301";
                    $scope.redirect.url = '';
                    $scope.submitted = false;                
                    $scope.tableRedirectParams.reload();

                    $scope.messUniqueUrl = '';
                    $scope.uniqueUrl = false;
                } else {
                    $scope.uniqueUrl = true;
                    $scope.messageUniqueUrl = data.messageError;
                }
            });
        }

        $scope.removeRedirect = function(id) {
            var conf = confirm('Would you want to delete this redirect?');
            if(!conf) {
                return;
            }
            $('#page-loading').css('display', 'block');
            RedirectService.removeRedirect(id).then(function (data) {
                $('#page-loading').css('display', 'none');
                if(data.status) {
                    $scope.messUniqueUrl = '';
                    $scope.uniqueUrl = false;
                    
                    $scope.redirects = RedirectService.getDataRedirects();
                    $scope.tableRedirectParams.reload();
                }
            });
        }

        $scope.headerFilter = function(column) {
            var _headerFilter = [];
            var arrHeader = [301,302];
            angular.forEach(arrHeader, function(value, key) {
                _headerFilter.push({
                    'id': value,
                    'title': value
                });
            });
            _headerFilter.unshift({'id':'', 'title' : 'All'});
            return _headerFilter;
        }

}])