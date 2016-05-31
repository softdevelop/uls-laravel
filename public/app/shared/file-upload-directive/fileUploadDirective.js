var fileUpload = angular.module('uls');
fileUpload.directive("fileUploadDirective", ['FileService', 'Upload', '$timeout',
    function(FileService, Upload, $timeout) {
        return {
            restrict: 'EA',
            require : '^ngModel',
            scope: {
                files:'=',
                fileIds:'=',
                openPicture:'&',
                fileType:'=',
                isMulti:'=',
                disabled: '=',
                control: '='
            },
            replace: true,
            transclude: true,
            templateUrl: baseUrl + '/app/shared/file-upload-directive/views/file-upload.html?v=1',
            link: function(scope, element, attrs, ngModel) {
                scope.uploadFinish = true;
                ngModel.$setViewValue({finished: scope.uploadFinish});

                function getId() {
                    return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
                }

                if(angular.isDefined(scope.files)) {
                    scope.fileUpload = {};
                    scope.fileUploadIds = [];
                    
                    scope.fileUploaded = scope.files;
                    ngModel.$setViewValue({files: scope.fileUploaded, finished: true});

                    for(i in scope.files) {
                        scope.files[i]['uniId'] = getId();
                        
                        scope.files[i]['proccess'] = 100;
                        scope.files[i]['error'] = 0;
                        scope.checkCurrent = false;
                        scope.files[i]['name'] = scope.files[i]['file_name'];

                        scope.fileUpload[scope.files[i]['uniId']] = scope.files[i];
                        scope.fileUploadIds.push(scope.files[i]['id']);
                    }
                } else {
                    scope.fileUpload = [];
                    scope.fileUploadIds = [];
                    scope.fileUploaded = [];
                    scope.fileUploadIds = [];
                }

                var countUpload = 0;
                scope.baseUrl = baseUrl;
                scope.fileError = {};
                
                scope.numberFileUpload = [];
               
                scope.upload = function(files) {
                    if (files && files.length) {
                        countUpload++;
                       if( angular.isUndefined(scope.numberFileUpload[countUpload]) ) {
                            scope.numberFileUpload[countUpload] = [];
                        }
                        for (var i = 0; i < files.length; i++) {
                            ngModel.$setViewValue({finished: false});
                            (function(i){
                                ngModel.$setViewValue({finished: false});

                                var file = files[i];
                                if (angular.isDefined(window.maxUpload)) {
                                    if(file['size'] > window.maxUpload['size']){
                                        file['uniId'] = getId();
                                        file['proccess'] = 100;
                                        file['error'] = 1;
                                        file['status'] = 0;
                                        scope.fileUpload[file['uniId']] = file;
                                        scope.fileUpload[file['uniId']]['error'] = 'Max file size is '+window.maxUpload['name'];
                                        scope.fileError[file['uniId']] =file;
                                        ngModel.$setViewValue({finished: true});
                                        return;
                                    } 
                                }
                                file['uniId'] = getId();
                                file['proccess'] = 0;
                                file['error'] = '';
                                if(scope.isMulti) {
                                    scope.fileUpload[file['uniId']] = file;                                    
                                } else {
                                    scope.fileUpload = {};
                                    scope.fileUpload[file['uniId']] = file;                                    
                                }
                                Upload.upload({
                                    url: baseUrl + '/admin/file',
                                    file: file
                                }).progress(function(evt) {
                                    ngModel.$setViewValue({finished: false});
                                    if(angular.isDefined(scope.fileUpload[file['uniId']])) {
                                        var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                                    } else {
                                        var progressPercentage =100;
                                        scope.uploadFinished = true;
                                        ngModel.$setViewValue({finished: scope.uploadFinished});
                                    }
                                    if(angular.isDefined(scope.fileUpload[file['uniId']])) {
                                        scope.fileUpload[file['uniId']]['proccess'] = progressPercentage;
                                        scope.uploadFinished = false;
                                        ngModel.$setViewValue({finished: scope.uploadFinished});
                                    }
                                    
                                    
                                }).error(function(data, status, headers, config) {
                                    // console.log(data,'sdfdsfdsf');
                                    files.splice(1, i);
                                    if(angular.isDefined(scope.fileUpload[file['uniId']])) {
                                    if (angular.isDefined(data.message)) {
                                        scope.fileUpload[file['uniId']]['error'] = data.message;
                                    }
                                      scope.fileError[config.file['uniId']] = data;
                                    }
                                   

                                }).success(function(data, status, headers, config) {
                                    scope.uploadFinished = true;
                                    ngModel.$setViewValue({finished: scope.uploadFinished});
                                    if(angular.isDefined(scope.fileUpload[config.file.uniId])){
                                        data.item['uniId'] = config.file.uniId;
                                        if(scope.isMulti) {
                                            scope.fileUploaded.push(data.item);
                                            scope.fileUploadIds.push(data.item.id);
                                        } else {
                                            scope.fileUploaded = [];
                                            scope.fileUploadIds = [];
                                            scope.fileUploaded.push(data.item);
                                            scope.fileUploadIds.push(data.item.id);
                                        }

                                    }
                                  
                                }).finally(function(){
                                     scope.uploadFinished = true;
                                     $timeout(function(){
                                        ngModel.$setViewValue({ids: scope.fileUploadIds, files: scope.fileUploaded, finished: scope.uploadFinished});
                                     })
                                    
                                });


                            })(i);
                        }
                    }
                }

                ngModel.$render = function(){
                    $timeout(function(){
                        scope.filesUpload = ngModel.$viewValue; 
                    })   
                }

              
                 /**
                  * [checkFile description]
                  * @param  {[type]} type [description]
                  * @return {[type]}      [description]
                  */
                scope.checkFile = function(type){
                    return FileService.checkFile(type);
                }


                function getId() {
                    return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
                }

                /**
                 * Delete all file user uploaded
                 *
                 * When user click cancel in modal create child ticket then delete all file uploaded before
                 *
                 * @author Thanh Tuan  <tuan@httsolution.com>
                 */
                scope.internalControl = scope.control || {};
                scope.internalControl.deleteAllFileUploaded = function() {
                    // Delete all file uploaded scope
                    delete scope.fileUpload;
                    // Set new scope fileUpload
                    scope.fileUpload = {}
                    scope.uploadFinished = true;
                    // Set view
                    ngModel.$setViewValue({ids: scope.fileUploadIds, files: scope.fileUploaded, finished: scope.uploadFinished });
                }

                scope.deleteFile = function(uniId){
                    console.log(uniId,'uniId');
                    console.log(scope.fileUpload,'scope.fileUpload');

                    delete scope.fileUpload[uniId];

                    for(var key in scope.fileUploaded){
                        if(uniId == scope.fileUploaded[key]['uniId']){
                           var index = scope.fileUploadIds.indexOf(scope.fileUploaded[key]['id']);
                            // delete scope.fileUploaded[key];
                            scope.fileUploaded.splice(key,1);
                            scope.fileUploadIds.splice(index, 1);
                        }
                    }

                    scope.uploadFinished = true;
                    $timeout(function(){
                        ngModel.$setViewValue({ids: scope.fileUploadIds, files: scope.fileUploaded, finished: scope.uploadFinished });
                    })

                }
                scope.$on("emptyFiles", function (event, args) {
                    scope.fileUpload = {};
                    scope.fileUploaded = [];
                    scope.fileUploadIds = [];
                });
                
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