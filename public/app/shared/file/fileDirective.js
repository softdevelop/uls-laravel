var fileUpload = angular.module('uls');
fileUpload.directive("fileManager", ['FileService', '$upload',
    function(FileService, $upload) {
        return {
            restrict: 'EA',
            scope: {
            },
            replace: true,
            transclude: true,
            templateUrl: baseUrl + '/app/shared/file/views/file.html',
            require: '?ngModel',
            link: function(scope, element, attrs, ngModel) {
                if(!ngModel) return;
               
                ngModel.$render = function() {
                    scope.fileIds = ngModel.$modelValue;
                };
                var fileIds = [];
                scope.baseUrl = baseUrl;
                var isUploading = false;
                scope.items_s = {};
                scope.upload = function(files, type) {
                    if (files && files.length) {
                        for (var i = 0; i < files.length; i++) {

                        	(function(i){
                                var file = files[i];
                                file['id'] = getId();
                                file['proccess'] = 0;
                                scope.items_s[file['id']] = file;

                                $upload.upload({
                                    url: baseUrl + '/admin/file',
                                    file: file
                                }).progress(function(evt) {
                                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                                    scope.items_s[file['id']]['proccess'] = progressPercentage + '%';
                                }).success(function(data, status, headers, config) {
                                    fileIds.push(data['item']['id']);
                                    FileService.pushFile(data['item']);
                                    scope.items = FileService.getData();
                                    delete scope.items_s[file['id']];

                                    angular.element("#" + file['id']).remove();
                                    return;
                                }).error(function(data) {
                                    angular.element("#" + file['id']).addClass('dz-error');
                                    scope.error = data.message;
                                });

                            })(i);
                        }
                    }
                }
                ngModel.$setViewValue(fileIds);
                scope.deleteFile = function(id){
                    FileService.remove(id).then(function(data){
                        scope.items = FileService.getData();
                    });
                }
                // generate element id to manipulate html
                function getId() {
                    return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
                }

                scope.showBoxDropFile = function(ob){
                    // return Object.keys(scope.items_s).length > 0 || scope.items.length > 0; // 0
                }
            }
        }
    }
]).filter('bytes', function() {
    return function(bytes, precision) {
        if (isNaN(parseFloat(bytes)) || !isFinite(bytes)) return '-';
        if (typeof precision === 'undefined') precision = 1;
        var units = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'],
            number = Math.floor(Math.log(bytes) / Math.log(1024));
        return (bytes / Math.pow(1024, Math.floor(number))).toFixed(precision) + ' ' + units[number];
    }
});