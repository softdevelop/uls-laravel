var fileUpload = angular.module('uls');
fileUpload.directive("fileManager", ['FileService', 'Upload',
    function(FileService, Upload) {
        return {
            restrict: 'EA',
            scope: {
                folderId:'=',
                openPicture:'&',
                addFile: '&',
                store:'@'
            },
            replace: true,
            transclude: true,
            templateUrl: baseUrl + '/app/shared/file-manager/views/file-manager.html',
            link: function(scope, element, attrs, ngModel) {
                scope.baseUrl = baseUrl;
                var isUploading = false;
               // scope.items = [];
                scope.items_s = {};
                scope.upload = function(files, type) {
                    if (files && files.length) {
                        for (var i = 0; i < files.length; i++) {

                        	(function(i){
                                var file = files[i];
                                file['uniId'] = getId();
                                file['proccess'] = 0;
                                if(angular.isDefined(file['name'])){

                                    file['file_name'] = file['name'];
                                }
                                if (angular.isDefined(window.maxUpload)) {
                                    if(file['size'] > window.maxUpload['size']){
                                        file['uniId'] = getId();
                                        file['proccess'] = 100;
                                        file['error'] = 1;
                                        file['status'] = 0;
                                        scope.items_s[file['uniId']] = file;
                                        scope.items_s[file['uniId']]['error'] = 'Max file size is '+window.maxUpload['name'];
                                        return;
                                    } 
                                }
                                scope.items_s[file['uniId']] = file;

                                Upload.upload({
                                    url: baseUrl + '/admin/file',
                                    fields: {'folderId': scope.folderId, 'store': scope.store},
                                    file: file
                                }).progress(function(evt) {
                                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                                    if(angular.isUndefined(scope.items_s[file['uniId']])) {
                                        return;
                                    }
                                    scope.items_s[file['uniId']]['proccess'] = progressPercentage + '%';
                                }).success(function(data, status, headers, config) {
                                    if(!data.status){ 
                                        if(data.error){
                                            alert(data.error + ' Refresh this page.');
                                            window.location.href = window.baseUrl +'/document-manager' ; 
                                        }
                                        return;
                                    }
                                    // scope.items.push(data['item']);
                                    scope.addFile()(data['item']);
                                        FileService.pushFile(data['item']);
                                        FileService.formatFilesWitFolderId();
                                        scope.itemsUpload = {};
                                    delete scope.items_s[file['uniId']];

                                    angular.element("#" + file['uniId']).remove();
                                    return;
                                }).error(function(data, status) {
                                    if(!data.status){ 
                                        if(data.error){
                                            alert(data.error + ' Refresh this page.');
                                            window.location.href = window.baseUrl +'/document-manager' ; 
                                        }
                                    }
                                    angular.element("#" + file['uniId']).addClass('dz-error');

                                    if(status == 413) {
                                        scope.error = 'Max file size is '+window.maxUpload.name;
                                    } else {
                                        // console.log(data,'data');
                                        if(data == null || angular.isUndefined(data) || angular.isUndefined(data.message)) {
                                            scope.error = 'Max file size is '+window.maxUpload.name;
                                        } else {
                                             scope.error = data.message;
                                        }

                                    }



                                });

                            })(i);
                        }
                    }
                }

                // generate element id to manipulate html
                function getId() {
                    return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
                }
                scope.deleteFileError = function(id, $event){
                    $event.stopPropagation();
                    delete scope.items_s[id];

                }
                // scope.showBoxDropFile = function(ob){
                //     // console.log(Object.keys(scope.items_s).length, scope.items, Object.keys(scope.items_s).length == 0 || scope.items.length == 0);
                //     return Object.keys(scope.items_s).length > 0 || scope.items.length > 0; // 0
                // }

                scope.checkFile = function(type){
                    return FileService.checkFile(type);
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
