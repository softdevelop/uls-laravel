assetmanagerApp.directive("uploadFileAsset", ['$timeout','Upload',
        function($timeout,Upload) {
            return {
                restrict: 'EA',
                require : '^ngModel',
                scope: {
                    files:'=',
                    fileIds:'=',
                    openPicture:'&',
                    disabled: '=',
                    accept: '=',
                    folder: '=',
                    assetEdit:'='
                },
                replace: true,
                transclude: true,
                templateUrl: baseUrl + '/app/components/assetmanagers/views/file-upload.html?v='+new Date().getTime(),
                link: function(scope, element, attrs, ngModel) {
                    if(attrs.ngMultiple=='one'){
                        scope.uploadMultiple= 'one';

                    }
                    var checkImage =false;
                    // get file current ng-modal
                    scope.$watch('assetEdit', function(newValue, oldValue) {
                         if(!angular.isUndefined(newValue)){
                            // if exist file name
                            if(!angular.isUndefined(newValue.filename)){
                                var fileEdit =[];
                                scope.listsFiles= [];
                                var fileCurrent=[];
                                fileEdit['uniId'] = getId();

                                fileEdit['proccess'] = 100;

                                fileEdit['error'] = 0;

                                scope.checkCurrent = false;

                                fileEdit['name'] = newValue.filename;

                                fileEdit['file_name'] =newValue.filename;

                                scope.fileUpload[fileEdit['uniId']]= fileEdit;

                                scope.fileUploadIds = fileEdit['uniId'];

                                fileCurrent['_id'] =newValue._id;

                                fileCurrent['name'] = newValue.filename;

                                scope.listsFiles[0]=fileCurrent;
                                // if type image
                                if(newValue.type === "image"){
                                    newValue.type = "images"
                                }
                                if(newValue.type === "images"){
                                    var checkImage =true;
                                    ngModel.$setViewValue({fileUploadIds:scope.fileUploadIds,listsFiles: scope.listsFiles,finished: scope.uploadFinish, checkImage : checkImage });
                                } else {
                                    ngModel.$setViewValue({fileUploadIds:scope.fileUploadIds,listsFiles: scope.listsFiles,finished: scope.uploadFinish}); 
                                }
                               

                            }
                         }
                    })
                    var countUpload = 0;
                    scope.baseUrl = baseUrl;
                    scope.fileUpload = {};
                    scope.fileUploaded = [];
                    scope.fileUploadIds = [];
                    scope.listsFiles = [];
                    scope.fileError = {};
                    scope.uploadFinish = true;
                    // set upload finish ==true
                    ngModel.$setViewValue({finished: scope.uploadFinish});
                    scope.numberFileUpload = [];
                    
                    scope.upload = function(files) {
                        if (files && files.length) {
                            countUpload++;
                            //notification when type is undefined
                            for (var i = 0; i < files.length; i++) {
                                (function(i){
                                    // file ext is upload
                                    var fileCheck = ['txt','htm','html', 'php','css','js','json','xml','swf','flv','png','jpe','jpeg','jpg','gif','bmp'
                                            ,'ico','tiff','tif','svg','svgz','zip','rar','exe','msi','cab','mp3','mp4','qt','mov','pdf','psd','ai','eps',
                                            'ps','doc','docx','rtf','xls','ppt','pptx','odt','ods'];
                                    // get file ext of file upload
                                    var file = files[i];
                                    var namefile=file.name.split(".");
                                    var ext=namefile.slice(-1).pop();
                                    // if ext file upload not exsit file check
                                    if(fileCheck.indexOf(ext.toLowerCase()) == -1 || ext.toLowerCase() == 'php'){

                                        alert('System don’t support this type file');
                                        return;
                                    }
                                    if(angular.isUndefined(scope.folder)){
                                        alert('chosse folder');
                                        return;
                                    }
                                    if(scope.folder != 'other'){
                                        if(scope.folder != checkFile(file.type)){
                                            alert('chosse file    ' + scope.folder);
                                            return;
                                        }
                                    }
                                    // set upload finish = flase
                                    scope.uploadFinished = false;
                                    ngModel.$setViewValue({finished: scope.uploadFinished,checkImage: false});
                                    // set list file upload =[]
                                    scope.listsFiles=[];
                                    if(file.size>0){
                                        scope.checkCurrent = true;
                                    }
                                    // if file size file upload >max file
                                    if(file['size'] > window.maxUpload['size']){
                                        scope.fileUpload ={};
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
                                    file['uniId'] = getId();
                                    file['proccess'] = 0;
                                    file['error'] = '';
                                    scope.fileUpload = {};
                                    scope.listsFiles.push(file);
                                    ngModel.$setViewValue({listsFiles: scope.listsFiles});
                                    scope.fileUpload[file['uniId']] = file;
                                    console.log(scope.listsFiles,'d');
                                    Upload.upload({
                                        method:'POST',
                                        url: baseUrl + '/upload-new-asset/file',
                                        file: file,
                                        data:scope.listsFiles
                                    }).progress(function(evt) {
                                        //run progressing file upload
                                        var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                                        scope.fileIsUploading = true;
                                        if(angular.isDefined(scope.fileUpload[file['uniId']])) {
                                            scope.fileUpload[file['uniId']]['proccess'] = progressPercentage;
                                            scope.uploadFinished = false;
                                            ngModel.$setViewValue({finished: scope.uploadFinished});

                                        }
                                    }).error(function(data, status, headers, config) {
                                        // console.log(data,'sdfdsfdsf');
                                        files.splice(1, i);
                                        for(var key in scope.listsFiles){
                                            if(file['uniId'] == scope.listsFiles[key]['uniId']){
                                                scope.listsFiles.splice(key, 1);
                                            }
                                        }
                                        if(angular.isDefined(scope.fileUpload[file['uniId']])) {
                                        if (angular.isDefined(data.message)) {
                                            scope.fileUpload[file['uniId']]['error'] = data.message;
                                        }
                                          scope.fileError[config.file['uniId']] =config.file;
                                          scope.fileError[config.file['uniId']]['status'] = data.status;
                                        }


                                    }).success(function(data, status, headers, config) {
                                        scope.uploadFinished = true;
                                        ngModel.$setViewValue({finished: scope.uploadFinished});
                                        scope.fileUploaded = config.file.uniId;
                                        scope.fileUploadIds = config.file;
                                    }).finally(function(){
                                        scope.uploadFinished = true;
                                        if(checkFile(scope.listsFiles[0].type)== 'images'){
                                            var checkImage =true;
                                        }
                                        ngModel.$setViewValue({fileUploadIds:scope.fileUploadIds,listsFiles: scope.listsFiles,finished: scope.uploadFinish, checkImage : checkImage });
                                    });


                                })(i);
                            }
                        }
                    }
                    ngModel.$render = function(){

                        // scope.$apply(function(){
                        scope.filesUpload = ngModel.$viewValue;
                        // })

                    }


                     /**
                      * [checkFile description]
                      * @param  {[type]} type [description]
                      * @return {[type]}      [description]
                      */
                    scope.checkFile = function(type){

                        return  checkFile (type);
                    }
                    function checkFile (type){
                        var images = ['png','gif','jpg', 'jpeg','jpe'];
                        var css = ['css'];
                        var video = ['video'];
                        var javascript = ['javascript'];
                          if(typeof type !== 'undefined'){
                            if(images.indexOf(type.split('/')[1]) != -1 ){
                                 return 'images';
                            } else if(css.indexOf(type.split('/')[1]) != -1 ){
                                return 'css';
                            }
                            else if(video.indexOf(type.split('/')[0]) != -1){
                                return 'video';

                            }
                            else if(javascript.indexOf(type.split('/')[1]) != -1){
                                return 'js';

                            }
                            else{

                            switch(type.split('/')[1]){
                                case 'zip':
                                    return 'zip';
                                    break;
                                case 'pdf':
                                    return 'pdf';
                                    break;
                                case 'msword':
                                    return 'msword';
                                    break;
                                default:
                                    return 'other';
                                    break;
                            }
                            }

                          }

                    }

                    function getId() {
                        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
                    }
/*
                    scope.deleteFile = function(uniId){
                        delete scope.fileUpload[uniId];
                        for(var key1 in scope.listsFiles){
                            if(uniId == scope.listsFiles[key1]['uniId']){
                                scope.listsFiles.splice(key1, 1);
                            }
                        }
                        for(var key in scope.fileUploaded){
                            if(uniId == scope.fileUploaded[key]['uniId']){
                               var index = scope.fileUploadIds.indexOf(scope.fileUploaded[key]['id']);
                                scope.fileUploadIds.splice(index, 1);
                            }
                        }
                        scope.uploadFinished = true;
                        ngModel.$setViewValue({ids: scope.fileUploadIds, files: scope.fileUploaded, finished: scope.uploadFinished,listsFiles: scope.listsFiles,checkImage: false});

                    }*/
                    scope.$on("emptyFiles", function (event, args) {
                        scope.fileUpload = {};
                        scope.listsFiles = [];
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
