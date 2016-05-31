var platformApp = angular.module('PlatformsApp');

platformApp.controller('PlatformsController', ['$scope', '$modal', 'ngTableParams','$timeout','PlatformsService', '$filter', function ($scope, $modal, ngTableParams, $timeout, PlatformsService, $filter){
    $scope.platform = window.platform;
    console.log($scope.platform,'platform');

    $scope.initCodeMirror = function(){
        $scope.editableCodeMirror = CodeMirror.fromTextArea(document.getElementById('description'), {
            mode:  "htmlmixed",
            theme: "night",
            styleActiveLine: true,
            lineNumbers: true,
            onChange: function(){
            },
        });
        $scope.editableCodeMirror.setSize('auto', 300);
        $scope.editableCodeMirror.on("change", function() {
            var curContent = $scope.editableCodeMirror.getValue();
            if(curContent == ''){
                $scope.$apply(function(){
                    $scope.desRequired = true;
                });
            } else {
                $scope.$apply(function(){
                    $scope.desRequired = false;
                });
            }
        });

        $timeout(function(){
            if(angular.isDefined($scope.platform.description)) {
                $scope.editableCodeMirror.setValue($scope.platform.description);
                $scope.desRequired = false;
            }
        });

    }

    $scope.initCodeMirrorMetaDes = function(){
        $scope.mirrorMetaDescription = CodeMirror.fromTextArea(document.getElementById('meta-description'), {
            mode:  "htmlmixed",
            theme: "night",
            styleActiveLine: true,
            lineNumbers: true,
            onChange: function(){
            },
        });

        $scope.mirrorMetaDescription.setSize('auto', 300);

        $scope.mirrorMetaDescription.on("change", function() {
            var curContent = $scope.mirrorMetaDescription.getValue();
            if(curContent == ''){
                $scope.$apply(function(){
                    $scope.metaDesRequired = true;
                });
            } else {
                $scope.$apply(function(){
                    $scope.metaDesRequired = false;
                });
            }
        });

        $timeout(function(){
            if(angular.isDefined($scope.platform.meta_description)) {
                $scope.mirrorMetaDescription.setValue($scope.platform.meta_description);
                $scope.metaDesRequired = false;
            }
        });

    }

    $scope.createPlatform = function(validate) {
        $scope.submitted = true;
        $scope.saving = false;
        $scope.desRequired = false;
        $scope.metaDesRequired = false;

        var description = $scope.editableCodeMirror.getValue();
        var metaDescription = $scope.mirrorMetaDescription.getValue();
        
        if(description == '') {
            $scope.desRequired = true;
        }

        if(metaDescription == '') {
            $scope.metaDesRequired = true;
        }

        if(validate || $scope.desRequired || $scope.metaDesRequired) {
            return;
        }

        $scope.saving = true;
        $scope.platform.description = description;
        $scope.platform.meta_description = metaDescription;

        if(angular.isDefined($scope.filesUpload.files)) {
            $scope.platform.image = $scope.filesUpload.files;
        } else {
            $scope.platform.image = [];
        }

        PlatformsService.createPlatform($scope.platform).then(function (data) {
            $scope.saving = false;
            if (!data.status) {
                $scope.errors = data.errors;

                $('html, body').animate({
                    scrollTop: $('#pagehome').offset().top
                }, 500);

            } else {
                window.location = window.baseUrl + '/cms/database-manager/set-database-selected/root_platform';
            }
            
        });
    }
}]);

platformApp.directive('integerInput', function () {
    return{
        restrict: 'A',
        require: '?ngModel',
        link:function (scope, element, attrs, ctr) {
            element.bind("keypress", function (event) {
                if((event.which < 48 || event.which > 57) && event.which != 8 && event.which !=0 ) {
                    ctr.$setViewValue(element.val());
                    ctr.$render();
                    event.preventDefault();
                }
            });
        }
    }
});