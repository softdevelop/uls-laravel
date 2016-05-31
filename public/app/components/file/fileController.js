var fileModule = angular.module('file');
fileModule.controller('FileController', ['$scope', 'FileService', 'shareDataFactory','$modal','$timeout','$filter',
    function($scope, FileService, shareDataFactory, $modal,$timeout,$filter) {
        $scope.currentFolderId = 0;
        $scope.file_data = {};
        $scope.breadcumb = 'Graphics';
        $scope.items = window.files;
        $scope.listNameUser = window.listNameUser;
        $scope.nameFolder = [];
        FileService.setFiles(angular.copy($scope.items));
        FileService.formatFilesWitFolderId();
        angular.element('.document-page').removeClass('hidden');
        $scope.$watch(function(){
          return window.files;
        },function(value){
          if(angular.isDefined(window.foldersParent)){
            for(var i = 0; i <  window.foldersParent.length; i++){
              $scope.nameFolder[window.foldersParent[i].id] = window.foldersParent[i];
              $scope.items.push(window.foldersParent[i]);
            }
          }

          // FileService.setFiles(angular.copy(value));
          // FileService.formatFilesWitFolderId();
        });
        $scope.reload = function(){
          location.reload();
        }
        $scope.viewModel = function(id){
            var modalInstance = $modal.open({
              templateUrl: baseUrl+'/app/shared/file-manager/views/viewPicture.html',
              controller: 'ModalViewPictureCtrl',
              size: undefined,
              windowClass: 'show-img',
              resolve: {
                fileId: function () {
                  return id;
                }
              }
            });
            modalInstance.result.then(function (selectedItem) {
            }, function () {
          });
        }
        $scope.reloadTree = function(callback){
          $scope.tree.reload($scope.folders).done(callback);
        }
        $scope.initTree = function(){
          //console.log('folder',$scope.folders);
          var $myTree = angular.element("#tree").fancytree({
            extensions: ["glyph"],
            glyph: {
              map: {
                expanderClosed: "glyphicon glyphicon-plus-sign",
                expanderLazy: "glyphicon glyphicon-plus-sign",
                // expanderLazy: "glyphicon glyphicon-expand",
                expanderOpen: "glyphicon glyphicon-minus-sign",
                // expanderOpen: "glyphicon glyphicon-collapse-down",
                folder: "glyphicon glyphicon-folder-close",
                folderOpen: "glyphicon glyphicon-folder-open",
                loading: "glyphicon glyphicon-refresh"
                // loading: "icon-spinner icon-spin"
              }
            },
            autoScroll: true,
            source: $scope.folders,
            activate: function(event, data){
              // A node was activated: display its title:
              var node = data.node;
              $scope.changeBreadcrumb(node);
              node.setExpanded(true);
              // console.log('current_node', node);
              if(!$scope.$$phase) {
                  $scope.$apply(function(){
                    $scope.currentFolderId = node.key;
                    $scope.getFilesByFolderId();
                  })
              }else{
                $scope.currentFolderId = node.key;
                $scope.getFilesByFolderId();
              }
              // angular.element("#echoActive").text(node.title);
            },
            create: function(){
              if(typeof callback != 'undefined'){
                callback();
              }

            }
          });
          $scope.tree = $myTree.fancytree("getTree");

          if(angular.isDefined(window.folderRootId)){
           var node = $scope.tree.getNodeByKey(window.folderRootId.toString());
            if(angular.isDefined(node)) {
              node.setActive(true);
            }
          }

        }
        $scope.addFolder = function(store){
          var modalInstance = $modal.open({
            templateUrl: baseUrl+'/app/components/file/views/modal/addFolder.html',
            controller: 'ModalAddFolder',
            size: undefined,
            resolve: {
              currentFolderId : function(){
                return $scope.currentFolderId;
              },
              store: function(){
                return store;
              }
            }
          });


          modalInstance.result.then(function(item) {
            if(item.newFolder.parent_id == 0){
              $scope.folders.push(item.newFolder);
              $scope.initTree();
              var node = $scope.tree.getNodeByKey(item.newFolder.key.toString());
              node.setActive(true);
            }else{
              $scope.tree.getActiveNode().addChildren(item.newFolder);
              var node = $scope.tree.getNodeByKey(item.newFolder.key.toString());
              node.setActive(true);
            }

          }, function () {

          });

        }
        $scope.deleteFolder = function(id, position){
          $scope.positionDeleteFolder = position;
          if(typeof id != 'undefined') $scope.currentFolderId = id;
            var modalInstance = $modal.open({
              templateUrl: baseUrl+'/app/components/file/views/modal/deleteFolder.html',
              controller: 'ModalDeleteFolder',
              size: undefined,
              resolve: {
                currentFolderId : function(){
                  return $scope.currentFolderId;
                },
                name: function(){
                        var node = $scope.tree.getNodeByKey($scope.currentFolderId.toString());
                        return node.title;
                  //       console.log(node, 'huy123');

                  // // if($scope.tree.getNodeByKey($scope.currentFolderId) == null){
                  // //   console.log($scope.currentFolderId, 'test1');
                  // //   console.log($scope.nameFolder[$scope.currentFolderId], 'test');
                  // //   // return $scope.nameFolder[$scope.currentFolderId].name;
                  // // }else{
                  // //   return $scope.tree.getNodeByKey($scope.currentFolderId).title;
                  // // }

                }
              }
            });
              modalInstance.result.then(function(data) {
                var idFolderDeleted = data.id;
                if($scope.positionDeleteFolder == 'main'){
                   if(!angular.isDefined(idFolderDeleted)){
                      idFolderDeleted =$scope.currentFolderId;
                   }
                  var node = $scope.tree.getNodeByKey(idFolderDeleted);
                  $scope.currentFolderId = node.data.parent_id;
                  if(node){
                    node.remove();
                  }
                  $scope.items = FileService.getFilesCurrentFolder();
                }else{
                  var currentActiveFolder = $scope.tree.getActiveNode();
                  var nodeParent = $scope.tree.getNodeByKey(currentActiveFolder.parent.key);
                  $scope.tree.getActiveNode().remove();
                  $scope.items = [];
                  nodeParent.setActive(true);
                }
                if(typeof data.files != 'undefined'){

                  for(var key in $scope.items){
                    for(var key1 in data.files){
                      if($scope.items[key].id == data.files[key1].id){
                        delete $scope.items[key];
                        break;
                        // $scope.items.splice(key);
                      }
                    }

                  }

                }
                if(angular.isDefined(data.folder)) {
                  if(data.folder.parent_id == 0)
                  {
                     $scope.currentFolderId = 0;
                     for(var key in $scope.folders)
                     {
                      if($scope.folders[key].key == data.folder.id)
                       {
                          $scope.folders.splice(key, 1);
                          break;
                       }
                     }
                  }
                }


            }, function () {

            });

          }

        $scope.getFilesByFolderId = function(){
          // console.log(nodeIndex, currentNodesChildren, 'huy123');
          var items = [];
          var folderShare = [];
          var currentNodesChildren = $scope.tree.getActiveNode().getChildren();
          items =  angular.copy(FileService.getFileFolderMap()[$scope.currentFolderId]);
          if(typeof items == 'undefined') items = [];
          // console.log('huy123', currentNodesChildren);
          // if(!angular.isUndefined(currentNodesChildren){
          //   folderShare = window.folderShareMap[currentNodesChildren[nodeIndex]['key']];
          // }
          for(var nodeIndex in currentNodesChildren){
            items.push(
                {id:currentNodesChildren[nodeIndex]['key'],
                file_name:currentNodesChildren[nodeIndex]['title'],
                created_at:currentNodesChildren[nodeIndex]['data']['created_at'],
                group:'folder',
                user_id:currentNodesChildren[nodeIndex]['data']['user_id'],
                parent_id:currentNodesChildren[nodeIndex]['data']['parent_id'],
                visible:currentNodesChildren[nodeIndex]['data']['visible'],
                // files_share:folderShare
            });
          }
          $scope.items = items;
        }

        $scope.$on('editFile', function() {

          if(shareDataFactory.data.group == 'folder'){
             var node = $scope.tree.getNodeByKey(shareDataFactory.data.id.toString());
             node.setTitle(shareDataFactory.data.name);
          }
          FileService.formatFilesWitFolderId();
           if(shareDataFactory.data['folder_id'] > 0 || shareDataFactory.data['parent_id'] > 0 ){
            $scope.items = $filter('orderBy')(FileService.getFilesCurrentFolder(), 'file_name');
            // console.log($scope.items);
          }else if(shareDataFactory.data['parent_id'] == 0){
            var items = [];
            for(var key in window.foldersParent){
                if(window.foldersParent[key].id == shareDataFactory.data.id){
                  window.foldersParent[key] = shareDataFactory.data;
                  break;
                }
            }
            $scope.items = $filter('orderBy')(FileService.getData(), 'file_name');
          }

        });

        $scope.deleteFile = function(id){
          angular.element('#page-loading').css('display', 'block');
           FileService.remove(id).then(function(data){
            if(!data.status){
               if(data.error){
                  alert(data.error + ' Refresh this page.');
                  window.location.href = window.baseUrl +'/document-manager' ;
                  return; 
                }
            }
            FileService.formatFilesWitFolderId();
            $scope.items = FileService.getFilesCurrentFolder();
            angular.element('#page-loading').css('display', 'none');
          });
        }
        $scope.visibleFolder = function(id){
        // console.log(id);
          $scope.idFolderVisible = id ;
          angular.element('#page-loading').css('display', 'block');
           FileService.visibleFolder(id).then(function(data){
            angular.element('#page-loading').css('display', 'none');
            if(data.status){
              FileService.formatFilesWitFolderId();
              $scope.items = FileService.getFilesCurrentFolder();
              if(angular.isDefined($scope.idFolderVisible)){
                var tree = $('#tree').fancytree('getTree');
                var node = tree.getNodeByKey($scope.idFolderVisible.toString());
                if(angular.isDefined(node)){
                    node.data.visible =  data.visible;
                }
              }
            } else {
              if(data.error){
                alert(data.error + ' Refresh this page.');
                window.location.href = window.baseUrl +'/document-manager' ; 
              }
            }
          });
        }

        $scope.activeFolder = function(folderId){
          var node = $scope.tree.getNodeByKey(folderId.toString());
          //console.log('current node', node);
          node.parent.setExpanded(true);
          $scope.changeBreadcrumb(node);
          angular.element(node.li).trigger('click');
        }

        $scope.changeBreadcrumb = function(node){
          var currentNode = Object.create(node);
          $scope.breadcumbItems = [];
          $scope.breadcumbItems.push(currentNode);
          while(node.parent && node.parent.title!='root'){
            $scope.breadcumbItems.push(node.parent);
            node = node.parent;
          }
          $scope.breadcumbItems = $scope.breadcumbItems.reverse();
        }
        $scope.addFile = function(file){
          var items = angular.copy($scope.items);
          items.push(file);
          $scope.items = items;

        }

    }])
  .controller('ModalAddFolder', ['$scope', '$timeout', '$modalInstance', 'FileService','currentFolderId','store',function($scope, $timeout, $modalInstance, FileService,currentFolderId, store) {
     $scope.folder = {};
     $scope.folder.parent_id = currentFolderId;
     if(typeof store != 'undefined'){
      $scope.folder.store = store;
     }
     $scope.addFolder = function ($invalid) {
      $scope.submitted = true;
      if($invalid) return;
      angular.element('#add-folder-graphic').attr("disabled", "true");
        FileService.addFolder($scope.folder).then(function(data){
          if(!data.status){
              if(data.error){
                alert(data.error + ' Refresh this page.');
                window.location.href = window.baseUrl +'/document-manager' ; 
              }
              return;
          } else{
           $modalInstance.close(data);
          }

        })

    };
    $scope.cancel = function () {
      $modalInstance.dismiss('cancel');
    };
}])
  .controller('ModalDeleteFolder', ['$scope', '$modalInstance', 'FileService','currentFolderId','name',function($scope, $modalInstance, FileService,currentFolderId,name) {
    $scope.currentFolderId = currentFolderId;
    $scope.name = name;
    $scope.deleteFolder = function () {

        FileService.deleteFolder($scope.currentFolderId).then(function(data){
          if(!data.status){
              if(data.error){
                alert(data.error + ' Refresh this page.');
                window.location.href = window.baseUrl +'/document-manager' ; 
              }
              return;
          } else{
           $modalInstance.close(data);
          }
        })

    };
    $scope.cancel = function () {
      $modalInstance.dismiss('cancel');
    };
}])
  .controller('ModalViewPictureCtrl', ['$scope', '$modalInstance','fileId', function ($scope, $modalInstance, fileId) {
    $scope.fileId = fileId;
    $scope.baseUrl = baseUrl;
    $scope.cancel = function(){
      $modalInstance.dismiss('cancel');
    }
}]);
