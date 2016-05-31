var fileModule = angular.module('file');
fileModule.factory('FileResource', ['$resource',function($resource){
    return $resource('/admin/document-manager/:method/:id', {}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'}
    })
}])
.factory('shareDataFactory', ['$rootScope', function($rootScope){
    var sharedService = {};
    sharedService.data = '';
    sharedService.prepForBroadcase = function(data,broadcastName){
        this.data = data;
        this.broadcastItem(broadcastName);
    }
    sharedService.broadcastItem = function(broadcastName){
        $rootScope.$broadcast(broadcastName);
    }
    return sharedService;
}])
.service('FileService', ['$q', '$filter', 'FileResource', function($q, $filter, FileResource){
    var files = [];
    var filesFolder = [];
    var fileEdited = [];
    var filesUser = [];
    var filesUpload = [];
    var filesMapFolder = [];
    var filesCurrentFolder = [];
    this.create = function(data) {
        var defer = $q.defer(); 
        var temp = new FileResource(data);
        temp.$save({},
            function success(data) {
                if(data['status']){
                    defer.resolve(data);
                }else{
                    defer.resolve(null);
                }
                
            },
            function error(data) {
               defer.resolve(null);
            });

        return defer.promise;
    };

    this.fileShare = function(data) {
        var defer = $q.defer(); 
        var temp = new FileResource(data);
        temp.$save({id:data.fileId, method:'file-share'},
            function success(data) {
                defer.resolve(data);
                
            },
            function error(data) {
               defer.resolve(null);
            });

        return defer.promise;
    };
    this.deleteFileUserShare = function(data) {
        var id = data['folder_id'];
        if(typeof data['file_id'] != 'undefined'){
            id =  data['file_id'];
        }
        var defer = $q.defer();
        FileResource.delete({ id: id, method:'delete-file-user-share', userShareId: data['user_id'], group: data['group']}, function(data) {
            defer.resolve(data);
        });

        return defer.promise;
    };

    this.getChildFolders = function(id){
        var defer = $q.defer();
        FileResource.query({id:id,method:'get-child-folders'}, function(data){
            defer.resolve(data);
        });
        return defer.promise;
    }

    this.getFilesFolder = function(){
        return filesFolder;
    }
    this.getFiles = function(){
        return files;
    }
    this.update = function(data) {
        var defer = $q.defer(); 
        var temp = new FileResource(data);
        temp.$save({id:data['_id']},
            function success(data) {
                if(data['status']){
                    defer.resolve(data);
                }else{
                    defer.resolve(null);
                }
                
            },
            function error(data) {
               defer.resolve(null);
            });

        return defer.promise;
    };


     this.get = function(id, prefix) {
        var defer = $q.defer();

        FileResource.get({id:id, prefix:prefix}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };
    this.getAllOfUser = function(data) {
        var defer = $q.defer();
        FileResource.query({created_at:data, method:'file-all'}, function(data) {
            for(var key in data){
                filesUser[data[key].id] = data[key];
            }
            defer.resolve(data);
        });
        return defer.promise;
    };
    this.pushFilesOfUser = function(filesComment){
        filesFormat = [];
       for(var key in filesComment){
            filesUser.push(filesComment[key]);
       } 
       return filesUser;
    }
    this.getFilesOfUser = function(){
        return filesUser;
    }
    this.query = function() {
        var defer = $q.defer();

        if(files && files.length) {
            defer.resolve(files);
        } else {
            FileResource.query().$promise
                .then(function(data) {
                    files = data;
                    defer.resolve(files);
                }
            );
        }

        return defer.promise;
    };

    this.remove = function(id) {
        var defer = $q.defer();
        var temp = new FileResource(id);
        FileResource.delete({ id: id}, function(data) {
            if(data.status){
                for(var key in filesCurrentFolder){
                    if(filesCurrentFolder[key]['id'] == id){
                         filesCurrentFolder.splice(key, 1);
                         break;
                    }
                   
                }
                for(var key in files){
                    if(files[key]['id'] == id){
                         files.splice(key, 1);
                         break;
                    }
                }
            }
            defer.resolve(data);
        });

        return defer.promise;
    };
    this.visibleFolder = function(id) {
        var defer = $q.defer();
        var temp = new FileResource(id);
        temp.$save({ id: id ,method:'visible-folder'}, function(data) {
            if(data.status){
                for(var key in filesCurrentFolder){
                    if(filesCurrentFolder[key]['id'] == id){
                        filesCurrentFolder[key]['visible'] =data['visible'];
                         break;
                    }
                   
                }
                for(var key in files){
                    if(files[key]['id'] == id){
                         files.splice(key, 1);
                         break;
                    }
                }
            }
            defer.resolve(data);
        });

        return defer.promise;
    };
    this.deleteFolder = function(id) {
        var defer = $q.defer();
        FileResource.delete({ id: id, method:'delete-folder'}, function(data) {
            if(data){
                for(var key in filesCurrentFolder){
                    if(filesCurrentFolder[key]['id'] == id){
                         filesCurrentFolder.splice(key, 1);
                         break;
                    }
                   
                }
            }
            defer.resolve(data);
        });

        return defer.promise;
    };

    this.setFiles = function(data){
        files = data;

    }
    this.pushFiles = function(data){
        files.push(data);
    }
    this.setFilesCurrentFolder = function(data){
        filesCurrentFolder = data;
    }
    this.getFilesCurrentFolder = function(data){
        return filesCurrentFolder;
    }
    this.pushFile = function(data){
        filesUpload = [];
        filesUpload.push(data);
        files.push(data);
    }
    this.pushFileFoler = function(data){
            filesFolder = [];
            filesUpload = [];
            for(var key in files){
                filesFolder[key] = files[key];
            }
            filesFolder.push(data);
            filesUpload.push(data);
            files = filesFolder;
    }
    this.getFileUpload = function(){
        return filesUpload;
    }
    this.editFile = function(data){
        fileEdited = data;
    }
    this.getDataFileEdit = function(){
        return fileEdited;
    }

    this.getData = function(){
        return files;
    }
    this.addFolder = function(data){
        var defer = $q.defer(); 
        var temp = new FileResource(data);
        temp.$save({method:'add-folder'},
            function success(data) {
                defer.resolve(data);  
            },
            function error(data) {
               defer.resolve(null);
            });

        return defer.promise;
    }

    /**
      *isImage: check file is Image
      * @param  {[type]}  type [description]
      * @return {Boolean}      [description]
      */
      this.checkFile = function(type){
        var images = ['png','gif','jpg', 'jpeg'];
      if(typeof type !== 'undefined'){
        if(images.indexOf(type.split('/')[1]) != -1 ){
             return 'image';
        }else{
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
    this.formatFilesWitFolderId = function(){
        var _files = [];
        for(var key in files){
            if(!angular.isArray(_files[files[key]['folder_id']])){
                _files[files[key]['folder_id']] = [];
            }
            _files[files[key]['folder_id']].push(files[key]);
        }
        filesMapFolder = _files;
    }

    this.getFileFolderMap = function(){
        return filesMapFolder;
    }
    this.filesMap = function(data){
        var _files = [];
        for(var key in data){
            _files[data[key]['id']] = data[key];
        }
        return _files;
    }
    this.download=function(id_img){
        // alert(111);
        var defer = $q.defer(); 
        var temp = new FileResource();
        temp.$get({id:id_img,method:'download'},
            function success(data) {
                // if(data['status']){
                    defer.resolve(data);
                // }else{
                    // defer.resolve(null);
                // }
                
            },
            function error(data) {
               defer.resolve(null);
            });

        return defer.promise;
    }

    this.editFileName = function(data) {
        var defer = $q.defer(); 
        var temp = new FileResource(data);
        temp.$update({id:data['id'], method: 'edit-file-name'},
            function success(data) {

                for(var key in files){
                    if(files[key]['id'] == data['id'] && files[key]['group'] == data['group']){
                         files[key] = data;
                         break;
                    }
                }
                if(data['folder_id'] > 0 || data['parent_id'] > 0){
                    for(var key in filesCurrentFolder){
                     if(filesCurrentFolder[key]['id'] == data['id']){
                         filesCurrentFolder[key] = data;
                         break;
                        }
                    }
                }
                
               defer.resolve(data);
            },
            function error(data) {
               defer.resolve(null);
            });

        return defer.promise;
    };
}])
