var pageApp = angular.module('pageApp');

pageApp.controller('TranslationEditorController', ['$scope', '$modal', '$filter','TranslationEditorService','$window', function ($scope, $modal, $filter,TranslationEditorService, $window){
    
    $scope.export = function (data) {
        // var data = {};
        TranslationEditorService.export(data).then(function (data) {
            console.log(data,'data');
            if(data['status']) {
                $window.location.href = window.baseUrl + '/api/pages/download-export/' + data['fileName'];
            }
        });
    }

}])
