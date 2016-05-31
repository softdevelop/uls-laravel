assetmanagerApp.controller('AssetManagerController', ['$scope', '$modal', 'ngTableParams','$timeout','AssetManagerService', 'CmsContentFolderService', '$filter', '$templateCache', 'CmsService', function ($scope, $modal, ngTableParams, $timeout, AssetManagerService, CmsContentFolderService, $filter, $templateCache, CmsService){


    $scope.size = function(){
        CmsService.setHeightTable();
    }

    // Show icon show nested content
    $scope.isShowNested = true;

    // Not button delete folder
    $scope.isShowBtnDelete = false;

    // Not show btn edit name folder
    $scope.isShowBtnEditNameFolder = false;
    

    // Delete cache route provider
    $templateCache.remove('cms/asset-manager/template');

    /* Set new value for CmsServiceContent*/
    $scope.assetManagers = CmsContentFolderService.setContents(angular.copy(window.folders),window.currentPage);

    // All tag content
    $scope.allTags = angular.copy(window.allTags);

    /* Text in button show or hide all nested content */
    $scope.contentHideOrShowAllNestedContent = 'Show All Nested Content';

    /* If undefined assets then set emtype array */
    if (angular.isUndefined($scope.assets)) {
        $scope.assets = [];
    }

    if(window.idOfAssetSelected != 0) {
        CmsContentFolderService.setActiveNode(window.idOfAssetSelected);
    }

    // Tags content
    $scope.tagsContent = angular.copy(window.tagsContent);

    $scope.labels = window.labels;

    /* Declare to contain value of title folder or file selected */
    $scope.titleItemSelected = 'root';

    /* Hide show filter in table */
    $scope.isSearch = false;

    $scope.btnSearch = function () {
        $scope.isSearch = !$scope.isSearch;
    }
    /* Ng-table to paggination, sort and filter */
    $scope.tableParams = new ngTableParams({
        page: 1,
        count: 100,
        sorting: {
            title: 'asc'
        },
        filter: {
               // title:''
            }

    }, {
        total: $scope.assets.length,
        getData: function ($defer, params) {
            /* Filter and sort data */
            var filteredData = params.filter() ? $filter('filter')($scope.assets, params.filter()) : $scope.assets;
            var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
            params.total(filteredData.length);
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    })

    $scope.getChildrenPages = function(nodes) {
        var nodeDelete=[];
        for(var key in nodes) {
            if(angular.isUndefined(nodes[key].data)) return;
            /* Node have parrent_id = 0 then delete this node */
            if (nodes[key].key=='root') {
                nodeDelete.push(nodes[key]);
                delete nodes[key];
            } else{
                    if (!angular.isUndefined(nodes[key].folder)) {
                    nodeDelete.push(nodes[key]);
                    delete nodes[key];
                }
            }
        }
        /* Show node resolve in table */
        $scope.assetManagers = nodes;
        /*$scope.pages.push(nodeDelete);*/
        /* Reload table */
        $scope.tableParams.reload();
    }

    /* Call function in service to show tree folder of block */
    CmsContentFolderService.initTree(function(valueResult, nodeActive){
        $scope.assets = [];
        /* If node activated is root node then set title is root */
        if (nodeActive.key == 'Assets') {
            $scope.titleItemSelected = 'Assets';
        } else if (nodeActive.folder == true) { /* If node activated is not root node but is folder */
            $scope.titleItemSelected = nodeActive.title;
        } else { /* If node active is not folder then set parent name of active node for title */
            if (angular.isUndefined (nodeActive.parent.data.name)) {
                $scope.titleItemSelected = 'Assets';
            } else {
                $scope.titleItemSelected = nodeActive.parent.data.name;
            }
        }

        //When user click only one node
        if (angular.isDefined(valueResult) && valueResult.length == 1 && nodeActive.folder != true) {
            valueResult[0].expanded = true;
            $scope.assets = valueResult;
        } else {
            angular.forEach(valueResult, function(value, key) {
                value.expanded = false;
                $scope.assets.push(value);
            })
        }

        $scope.tableParams.reload();
        if (angular.isDefined($scope.tableParams.$params)) {
            $scope.tableParams.$params.page = 1;
        }

        // Declare tree and get active node
        var tree = $('#tree').fancytree('getTree');

        // Get rootNode
        var rootNode = _.find(tree.getRootNode().children, function(obj) { return obj.data.type == 'assets' })

        // If node is not root node then show btn delete folder
        if(nodeActive.data.parent_id != '0' && nodeActive.data.parent_id != rootNode.data._id) {
            $scope.isShowBtnDelete = true;
            if (nodeActive.folder == true) {
                $scope.isShowBtnEditNameFolder = true;
            } else{
                $scope.isShowBtnEditNameFolder = false;
            }
        } else {
            $scope.isShowBtnDelete = false;
            $scope.isShowBtnEditNameFolder = false;
        }

        if(nodeActive.folder == true){
            if( window.folderType[nodeActive.data._id] == 'css'|| window.folderType[nodeActive.data._id] == 'js'){
                $scope.isShowBtnCreateNewAsset = true;
            } else {
                $scope.isShowBtnCreateNewAsset = false;
            }
        } else {
            var nodeParent = nodeActive.getParent();
            if( window.folderType[nodeParent.data._id] == 'css'|| window.folderType[nodeParent.data._id] == 'js'){
                $scope.isShowBtnCreateNewAsset = true;
            } else {
                $scope.isShowBtnCreateNewAsset = false;
            }
        }
    });

    /* Function hide or show all nested content */
    $scope.hideOrShowAllNestedContent = function () {
        CmsContentFolderService.changeStatusHideOrShowAllNestedContent().then(function (dataResult) {
            $scope.contentHideOrShowAllNestedContent = dataResult.textButton;
            if ($scope.contentHideOrShowAllNestedContent == 'Show All Nested Content') {
                $scope.isShowNested = true; // Show icon eye
            }else {
                $scope.isShowNested = false; // Show icon flash eye
            }
            $scope.assets = dataResult.contents;
            $scope.tableParams.reload();
        })
    }

    /**
     * Delete folder asset
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    $scope.deleteFolderAndAsset = function () {

        // Disable btn delete
        $scope.dsbBtnDelete = true;

        // Declare tree and get active node
        var tree = $('#tree').fancytree('getTree');

        // Find node activated
        var activeNode = tree.getActiveNode();

        // Find root node
        var rootNode = tree.getRootNode();

        // if node is folder
        if (activeNode.folder == true) {
            var comfrm = confirm($filter('trans')('confirm-delete-folder', 'golbal'));
        } else {
            var comfrm = confirm($filter('trans')('confirm-delete-content', 'golbal'));
        }

        if (comfrm == true) {

            // If node isn't root then delete node and child node
            if (activeNode.data.parent_id != '0') {
                // Call function to delete selected node
                AssetManagerService.deleteFolderAndAsset(activeNode.data._id).then(function (data) {
                    // Remove active node
                    activeNode.remove();
                    // Get root node of node activated and set active
                    rootNodeOfNodeActive = _.find(rootNode.children, function(obj) { return obj.title == 'Assets' });
                    rootNodeOfNodeActive.setActive();

                    // Enable btn delete
                    $scope.dsbBtnDelete = false;
                })
            }
        } else {
            // Enable btn delete
            $scope.dsbBtnDelete = false;
            return;
        }
    }

    /**
     * Delete file of asset
     *
     * @author Thanh Tuan <tuan@httsolution.com
     *
     * @param  {String} fileId Id of file
     *
     * @param  {Object} asset      Asset
     *
     * @return {Void}
     */
    $scope.deleteFileAsset = function (fileId, asset) {
        // Call function to delete content
        AssetManagerService.deleteAssetFile(fileId).then(function (data) {
            // If delete successfull
            if (data.status != 0) {
                if(!angular.isUndefined(data.result)){
                    asset.region = data.result.countUniqueRegion;
                    asset.language = data.result.countUniqueLanguage;
                    asset.status = data.result.status;
                }
                // Each page content
                angular.forEach(asset.subFiles, function (value, key) {
                    // Delete cotent deleted in page content array
                    if (value._id == fileId) {
                        asset.subFiles.splice(key, 1);
                    }
                })
                $scope.tableParams.reload();
            }
        })
    };

    /**
     * Edit name of folder
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    $scope.editNameFolder = function () {
        // Declare tree and get active node
        var tree = $('#tree').fancytree('getTree');
        // Find node activated
        var activeNode = tree.getActiveNode();

        if (!activeNode) return;

        var teamplate = '/cms/asset-manager/edit-name-folder/'+ activeNode.data._id + '?' + new Date().getTime();

        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + teamplate,
            controller: 'editNameFolderAssetCtrl',
            size: null,
            resolve: {
            }

        });

        modalInstance.result.then(function (data) {
            // Set title for node edited
            activeNode.setTitle(data.folder.name);
            activeNode.setActive();
            // Get root node and sort all child of root node
            // var rootNode = $("#tree").fancytree("getRootNode");
            activeNode.getParent().sortChildren(null, true);
            $scope.tableParams.reload();
            $scope.titleItemSelected = data['folder']['name'];

        }, function () {

           });
    }
       /**
     * Edit name of folder
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    $scope.createNewAsset = function () {
        if (opened) return;
        $scope.getParentFolder();
        var teamplate = '/cms/asset-manager/create-new-asset/'+ '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();

        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + teamplate,
            controller: 'CreateNewAssetCtrl',
            size: null,
            resolve: {
            }

        });

        modalInstance.result.then(function (data) {
            opened = false;

            // Format data to show in tree
            data.title = data.name;
            data.key = data._id;

            // Get parent node of node added
            node = $('#tree').fancytree('getTree').getNodeByKey(data.folder_id);

            if (node != null) {

                // Add child for parent of node added
                node.addChildren(data);

                // Get node added and set active for node added
                nodeAdded = $('#tree').fancytree('getTree').getNodeByKey(data._id);
                nodeAdded.setActive();

                // Sort child of root node
                node.sortChildren(null, true);
            }

        }, function () {

           });
    }

    $scope.showGroup = function($event,subFile) {

        var hBox = $('.group-btn-ac').outerHeight();
        var w = $(window).outerWidth();
        var h = $(window).outerHeight();
        var point = $event.pageY;
        var check = h - point;

        if (check < 300) {
            $('.wrap-ac-group').each(function( index ) {
                $( this ).addClass('show-top');
            });
        };

         $('.wrap-ac-group').each(function( index ) {
            $( this ).removeClass('ac-up');
        });


        $($event.target).parent().toggleClass("ac-up");
        if($('.group-btn-ac').hasClass('fix-missing-li')){
            $('.group-btn-ac').css({
                top: $event.pageY - 65 + 'px',
                right: w - $event.pageX - 30 + 'px',
            });
        }
        else{
            $('.group-btn-ac').css({
                top: $event.pageY - 200 + 'px',
                right: w - $event.pageX - 30 + 'px',
            });
        }
        $(document).on('click', function closeMenu (e){
          $(e.target).closest('tr').siblings().find('.wrap-ac-group').removeClass('ac-up');
          if($('.wrap-ac-group').has(e.target).length === 0){

              $('.wrap-ac-group').removeClass('ac-up');
              $('.wrap-ac-group').removeClass('show-top');

          } else {
              $(document).one('click', closeMenu);
          }
        });

        if(typeof subFile != 'undefined') {
            var arrImage = ['png','jpg','jpeg','gif','tiff','bmp'];

            if(subFile.filename) {

                var splitFile = subFile.filename.split(".");
                var extension = splitFile[splitFile.length - 1];

                var element = $('#viewFile-' + subFile._id);
                if(arrImage.indexOf(extension.toLowerCase()) == -1) {
                    element.attr('href', baseUrl + '/cms/asset-manager/file/download/' + subFile._id);
                    element.attr('target','_self');
                } else  {
                    element.removeAttr('target');
                    element.attr('href', 'script:void(0)');
                }
            }
        }

        angular.element('.table-responsive').addClass('fix-height');
    }

    /* When user choose one node then set this node for parent node want to create */
    $scope.getParentFolder = function () {
        /* Declare tree and get active node */
        var tree = $('#tree').fancytree('getTree');
        var activeNode = tree.getActiveNode();
        if (activeNode) {
            if(activeNode.folder==false||angular.isUndefined(activeNode.folder)){
                $scope.selectedItemName = activeNode.getParent().title;
                $scope.selectedItemId = activeNode.getParent().key;
            } else{
                if (activeNode.data.parent_id == '0') {
                    $scope.selectedItemName = '';
                    $scope.selectedItemId = '';
                } else {
                    $scope.selectedItemName = activeNode.title;
                    $scope.selectedItemId = activeNode.key;
                }
            }
        }
    }

    /**
     * Add tag for the page
     * @author Thanh Tuan <tuan@httsolution.com>
     * @param {String} pageId Id of the page
     * @param {String} tagId  Id of the tag
     */
    $scope.addTagsForPage = function (pageId, tagId) {
        $('#page-loading').css('display', 'block');
        $scope.tagId = tagId;
        AssetManagerService.addTagsForPage(pageId, {tags:$scope.tagId}).then(function (data){
            for (var key in $scope.assets) {
                if ($scope.assets[key].data._id == data.item._id) {
                    $scope.assets[key].data.tags = data.item.tags;
                    break;
                }
            }
            $('#page-loading').css('display', 'none');
            $scope.tableParams.reload();
        });
    };

    var opened = false;
    /* poup modal crete new folder*/
    $scope.createFolderAsset = function(){
        if (opened) return;
        $scope.getParentFolder();
        var teamplate = '/cms/asset-manager/create-folder' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
              templateUrl: window.baseUrl + teamplate,
              controller: 'ModalCreateFolderAssetCtrl',
              size: undefined,
              resolve: {
              }
            });
        opened = true;
        modalInstance.result.then(function (data) {
            window.folderType = data.folderType; 
            var data = data.item;
            opened = false;
            // Format data
            console.log(data);
            // Get tree
            var tree = $('#tree').fancytree('getTree');
            // Get parent node of node added
            var nodeparent = tree.getNodeByKey(data.parent_id);

            // Add node created for parent node
            nodeparent.addChildren(data);
            // Get node added
            var nodeAdded = tree.getNodeByKey(data._id);
            // Set active for node Added
            nodeAdded.setActive();
            // Sort child of root node
            $timeout(function() {
                nodeparent.sortChildren(null, true);
            });
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }

    $scope.getModalEditFile = function(id){
        if (opened) return;
        $scope.getParentFolder();
        var teamplate = '/cms/asset-manager/edit-file/'+ id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
              templateUrl: window.baseUrl + teamplate,
              controller: 'ModalEditFileAssetCtrl',
              size: undefined,
              resolve: {
              }
            });
        opened = true;
        modalInstance.result.then(function (assetUpload) {
            opened = false;
            var data = assetUpload;
            var tree = $('#tree').fancytree('getTree');
            // Get node edit
            var nodeCurent = tree.getNodeByKey(data._id);
            if(!angular.isUndefined(nodeCurent)&& nodeCurent != null){
                 nodeCurent.remove(); // delete node != null
            }
             // Add node for tree and set active for this node
            data.title = data.name;
            data.key = data._id;
            node = $('#tree').fancytree('getTree').getNodeByKey(data.folder_id);
            nodeAdd = node.addChildren(data);
            nodeAdd.setActive();
            // Sort child of root node
            node.sortChildren(null, true);
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }

    $scope.uploadNewAssets = function() {
        if (opened) return;
        $scope.getParentFolder();
        var teamplate = '/cms/asset-manager/upload-new-asset' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
              templateUrl: window.baseUrl + teamplate,
              controller: 'ModalUploadNewAssetCtrl',
              size: undefined,
              resolve: {
                tagsContent: function () {
                    return $scope.tagsContent;
                },
                allTags: function () {
                    return $scope.allTags;
                }
              }
            });
        opened = true;
        modalInstance.result.then(function (assetUpload) {

            opened = false;

            // Format data to show in tree
            var data= assetUpload;
            data.title = data.name;
            data.key = data._id;

            // Get parent node of node added
            node = $('#tree').fancytree('getTree').getNodeByKey(data.folder_id);

            if (node != null) {

                // Add child for parent of node added
                node.addChildren(data);

                // Get node added and set active for node added
                nodeAdded = $('#tree').fancytree('getTree').getNodeByKey(data._id);
                nodeAdded.setActive();

                // Sort child of root node
                node.sortChildren(null, true);
            }
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }

    $scope.viewFile = function(asset) {
        var arrImage = ['png','jpg','jpeg','gif','tiff','bmp'];
        if(asset.filename) {
            var splitFile = asset.filename.split(".");
            var extension = splitFile[splitFile.length - 1];
            if(arrImage.indexOf(extension.toLowerCase()) > -1) {
                //Show modal
                var modalInstance = $modal.open({
                    templateUrl: baseUrl+'/app/shared/assetmanagers/views/viewPicture.html?v=' + new Date().getTime(),
                    controller: 'viewFileController',
                    size: undefined,
                    windowClass: 'show-img',
                    resolve: {
                        asset: function () {
                            return asset;
                        }
                    }
                });
            }
        }
    }

    /**
     * [checkFileType description]
     * check file type is js or css or html
     *
     * @author [bang@httsolution.com]
     *
     * @param  {[type]} subFile [current file]
     *
     * @return {[type]}  boolean       [description]
     */
    $scope.checkFileType = function(subFile) {
        // console.log(subFile.filename, 'subFile.filename');
        if(subFile.filename) {
            var splitStringFile = String(subFile.filename).split('.');
            if (angular.isArray(splitStringFile) && splitStringFile.length > 1) {
                if (splitStringFile[splitStringFile.length - 1] == 'js' || splitStringFile[splitStringFile.length - 1] == 'css' || splitStringFile[splitStringFile.length - 1] == 'html') {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * [getModalUploadNewVersion description]
     *
     * update contetn file
     *
     * @author [bang@httsolution.com]
     *
     * @param  {[type]} fileId [description]
     * @return {[type]}        [description]
     */
    $scope.getModalUploadNewVersion = function(fileId) {
        if (opened) return;

        $scope.getParentFolder();

        var teamplate = '/cms/asset-manager/get-content-file/'+ fileId + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName;
        window.location.href = window.baseUrl + teamplate;
        // var modalInstance = $modal.open({
        //       templateUrl: window.baseUrl + teamplate,
        //       controller: 'ModalUploadNewVersion',
        //       size: undefined,
        //       resolve: {
        //       }
        //     });
        // opened = true;
        // modalInstance.result.then(function (assetUpload) {
        //     opened = false;
        //     // var data = assetUpload;
        //     // var tree = $('#tree').fancytree('getTree');
        //     // // Get node edit
        //     // var nodeCurent = tree.getNodeByKey(data._id);
        //     // if(!angular.isUndefined(nodeCurent)&& nodeCurent != null){
        //     //      nodeCurent.remove(); // delete node != null
        //     // }
        //     //  // Add node for tree and set active for this node
        //     // data.title = data.name;
        //     // data.key = data._id;
        //     // node = $('#tree').fancytree('getTree').getNodeByKey(data.folder_id);
        //     // nodeAdd = node.addChildren(data);
        //     // nodeAdd.setActive();
        // },function () {
        //     // console.info('Modal dismissed at: ' + new Date());
        //     opened = false;
        // });
    }

}])
.controller('viewFileController', ['$scope', '$modalInstance','asset', function ($scope, $modalInstance, asset) {
    $scope.asset = asset;
    $scope.baseUrl = baseUrl;
    $scope.cancel = function(){
      $modalInstance.dismiss('cancel');
    };
    $scope.v = new Date().getTime();
}])
.controller('ModalCreateFolderAssetCtrl', ['$scope', '$modalInstance','AssetManagerService', function ($scope, $modalInstance,AssetManagerService) {
    $scope.showLoad  = false;
    $scope.changeName = function(){
        $scope.nameExists = false;
    }

    $scope.submit = function (validate) {
        $scope.submitted  = true;
        $scope.nameExists = false;
        if(validate){
            $(".ng-invalid:eq(1)").focus();
            return;
        }
        if(typeof $scope.assetManager.parent_id=='undefined'|| $scope.assetManager.parent_id==''){
            $(".ng-invalid:eq(1)").focus();
            return;
        }
        $scope.showLoad  = true;
        AssetManagerService.createFolderProvider($scope.assetManager).then(function (data){
            $scope.showLoad  = false;
            if(data.status == 0){
                $(".ng-invalid:eq(1)").focus();
                $scope.nameExists = true;
                return;
            }else{
                $scope.nameExists = false;
                $modalInstance.close(data);
            }
        });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');

    };
}])
.controller('ModalUploadNewAssetCtrl', ['$scope', '$modalInstance','$timeout','Upload','$filter','AssetManagerService', 'tagsContent', 'allTags', function ($scope, $modalInstance,$timeout,Upload,$filter,AssetManagerService, tagsContent, allTags) {
    // setup variable for date picker
    $scope.format = 'MM-dd-yyyy';
    $scope.minDate = new Date();
    $scope.submitted  = false;
    $scope.showField  = false;
    $scope.showLoad  = false;
    $scope.tagsContent = tagsContent;
    $scope.allTags = allTags;
    $scope.teamplateThumb = window.baseUrl + '/app/components/assetmanagers/views/thumbnails.html';
    $scope.tagsSelected = [];
    $scope.itemsSelected = [];

    /**
     * Select tag when upload new asset
     * @author Thanh Tuan <tuan@httsolution.com>
     * @param {String} pageId Id of the page
     * @param {String} tagId  Id of the tag
     */
    $scope.selectTags = function (pageId, tagId) {
        if ($scope.tagsSelected.indexOf(tagId) == -1) {
            $scope.tagsSelected.push(tagId);
        } else {
            angular.forEach($scope.tagsSelected, function(value, key) {
                if (value == tagId) {
                    $scope.tagsSelected.splice(key, 1);
                }
            })
        }
        $scope.itemsSelected = $scope.tagsSelected;        
    };

    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches
    /* Open calendar when create page*/
    $scope.open = function($event, type) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = {};
        $scope.opened[type] = true;
    };
    $modalInstance.result.then(function () {
    }, function (status) {
        $modalInstance.close($scope.assetUpload);
    });
    // Init redactor
    // check upload finish and file upload image
    $scope.$watch('filesUpload', function(newValue, oldValue) {
            // if click  upload file
            if(!angular.isUndefined($scope.filesUpload)){
                // if exist file upload
                if(!angular.isUndefined($scope.filesUpload.listsFiles)){
                    // if exist upload file not finish
                    if($scope.filesUpload.listsFiles.length==0){
                        $scope.checkUpload=true;
                    } else{
                        $scope.asset.altTag = null;
                        $scope.asset.description = null;
                        $scope.asset.nameNewFile = null;
                        $scope.asset.title = null;
                        // if file upload is image
                        if(!angular.isUndefined($scope.filesUpload.checkImage)){
                   /*         var fileName = $scope.filesUpload.listsFiles[0].name;
                            var index = fileName.search('.' + fileName.split('.').pop());*/
                            // set name file new   = name file up load
                            $scope.asset.nameNewFile =  $scope.filesUpload.listsFiles[0].name;
                            // set type  = image
                            $scope.asset.type = 'image';

                            $scope.checkWithHeightValidate($scope.filesUpload.listsFiles);

                        } else {
                            // set type = orther
                            $scope.asset.type = $scope.folderType[$scope.asset.folder];
                        }
                        $scope.checkUpload = false;
                    }
                }else{
                 $scope.checkUpload=true;
                }
            }else{
                 $scope.checkUpload=true;
            }
    });
    $scope.submit = function (validate) {

        $scope.submitted  = true;
        // if exist file finish
        if(!angular.isUndefined($scope.filesUpload)){
            // if validate and file upload
            if(validate||$scope.checkUpload) {
                $(".ng-invalid:eq(1)").focus();
                if( $scope.asset.thumbnailsCustom && ( typeof $scope.asset.thumbnailsWidth == "undefined" || $scope.asset.thumbnailsWidth == null || typeof $scope.asset.thumbnailsHeight == "undefined" || $scope.asset.thumbnailsHeight == null))
                {
                     alert('Min height is 1 pixels and min width is 1 pixels');
                }
                return;
            }
            // if not exist seclect folder
            if(typeof $scope.asset.folder=='undefined'){
                return;
            }
            // if file upload is image then validate  Atl, description,name file
            if(!angular.isUndefined($scope.filesUpload.checkImage) &&(typeof $scope.asset.nameNewFile=='undefined'||$scope.asset.nameNewFile== null||!$scope.asset.nameNewFile)){
                return;
            }
            if($scope.asset.type == 'image' && $scope.asset.withFile && $scope.asset.heightFile){
                if( $scope.asset.thumbnailsMedium && $scope.asset.withFile <100 && $scope.asset.heightFile <100)
                {
                    alert('Max height is ' + $scope.asset.heightFile + ' pixels and Max width is ' + $scope.asset.withFile + ' pixels');
                    return;
                }
                if( $scope.asset.thumbnailsProduct && $scope.asset.withFile <82 && $scope.asset.heightFile <82)
                {
                    alert('Max height is ' + $scope.asset.heightFile + ' pixels and Max width is ' + $scope.asset.withFile + ' pixels');
                    return;
                }
                 if( $scope.asset.thumbnailsMaterial && $scope.asset.withFile <75 && $scope.asset.heightFile <75)
                {
                    alert('Max height is ' + $scope.asset.heightFile + ' pixels and Max width is ' + $scope.asset.withFile + ' pixels');
                    return;
                }
                 if( $scope.asset.thumbnailsSmall && $scope.asset.withFile <64 && $scope.asset.heightFile < 64)
                {
                    alert('Max height is ' + $scope.asset.heightFile + ' pixels and Max width is ' + $scope.asset.withFile + ' pixels');
                    return;
                }
                if( $scope.asset.thumbnailsCustom && (!$scope.asset.thumbnailsHeight || !$scope.asset.thumbnailsWidth))
                {
                    alert('Height and width is a required field');
                    return;
                }
                 if( $scope.asset.thumbnailsCustom && ($scope.asset.withFile < $scope.asset.thumbnailsWidth || $scope.asset.heightFile < $scope.asset.thumbnailsHeight))
                {
                     alert('Max height is ' + $scope.asset.heightFile + ' pixels and Max width is ' + $scope.asset.withFile + ' pixels');
                    return;
                }
            }
            $scope.showLoad  = true;
            $scope.asset.tags = $scope.itemsSelected;
            $('#page-loading').css('display','block');
            //upload file sever
                Upload.upload({
                    method:'POST',
                    url: baseUrl + '/api/asset-manager/upload-new-asset',
                    file: $scope.filesUpload.listsFiles,
                    data:$scope.asset
                }).success(function(data, status, headers, config){
                    $('#page-loading').css('display','none');
                     $scope.showLoad  = false;
                    $modalInstance.close(data.item);

                });
        }else{
            $scope.checkUpload=true;
            return;
        }

    };
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');

    };
    $scope.checkWithHeightValidate = function (file) {

        var reader = new FileReader();
        reader.readAsDataURL(file[0]);
        reader.onload = function(e) {
            var image = new Image();
            image.src = e.target.result;

            image.onload = function() {console.log('width', this.width, this.height);
                $scope.asset.withFile = this.width;
                $scope.asset.heightFile = this.height;
            };



        };

    };
}])
.controller('ModalEditFileAssetCtrl', ['$scope', '$modalInstance','$timeout','Upload','$filter','AssetManagerService', function ($scope, $modalInstance,$timeout,Upload,$filter,AssetManagerService) {
    // setup variable for date picker
    $scope.format = 'MM-dd-yyyy';
    $scope.minDate = new Date();
    $scope.submitted  = false;
    $scope.showField  = false;
    $scope.showLoad  = false;
    $scope.teamplateThumb = window.baseUrl + '/app/components/assetmanagers/views/thumbnails.html';

    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches
    /* Open calendar when create page*/
    $scope.open = function($event, type) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = {};
        $scope.opened[type] = true;
    };
    $modalInstance.result.then(function () {
    }, function (status) {
        $modalInstance.close($scope.assetUpload);
    });
    // Init redactor
     // if click  upload file
    $scope.$watch('filesUpload', function(newValue, oldValue) {
        // if exist file upload
        if(!angular.isUndefined($scope.filesUpload)){
            // if exist list file upload
            if(!angular.isUndefined($scope.filesUpload.listsFiles)){
                // if lengt list file == 0
                if($scope.filesUpload.listsFiles.length==0){
                    $scope.checkUpload=true;
                } else{
                    // if file uploas is image
                    if(!angular.isUndefined($scope.filesUpload.checkImage)){
                        //set type == image and file name = file name of file
                        $scope.asset.type = 'image';
                        $scope.asset.filename =  $scope.filesUpload.listsFiles[0].name;

                        if($scope.asset.height && $scope.asset.width){
                            $scope.asset.withFile = angular.copy($scope.asset.width);
                            $scope.asset.heightFile = angular.copy($scope.asset.height);
                            $scope.asset.height=false;
                            $scope.asset.width=false;
                        } else {
                            $scope.checkWithHeightValidate($scope.filesUpload.listsFiles);
                        }
                    } else {
                        // set type = orther
                        $scope.asset.type = $scope.folderType[$scope.asset.folder];
                        $scope.asset.filename =  $scope.filesUpload.listsFiles[0].name;
                    }
                    $scope.checkUpload = false;
                }
            }else{
             $scope.checkUpload=true;
            }
        }else{
             $scope.checkUpload=true;
        }
    });
    $scope.submit = function (validate) {
        $scope.assetUpload = [];
        $scope.submitted  = true;
        //  if exist upload and list file upload
        if(!angular.isUndefined($scope.filesUpload)&&!angular.isUndefined($scope.filesUpload.listsFiles)){
            // if length  !=0
            if($scope.filesUpload.listsFiles.length!=0){
                // if check validate and is upload file finish
                if(validate ||$scope.checkUpload) {
                    $(".ng-invalid:eq(1)").focus();
                    if( $scope.asset.thumbnailsCustom && ( typeof $scope.asset.thumbnailsWidth == "undefined" || $scope.asset.thumbnailsWidth == null || typeof $scope.asset.thumbnailsHeight == "undefined" || $scope.asset.thumbnailsHeight == null))
                    {
                        alert('Min height is 1 pixels and min width is 1 pixels');
                    }
                    return;
                }
                // if file is image then check validate field ATL and description  and file name
                if(($scope.filesUpload.checkImage) && (typeof $scope.asset.filename=='undefined'||$scope.asset.filename== null||!$scope.asset.filename)){
                    return;
                }
                // if file uploas is not  image
                if(!$scope.filesUpload.checkImage){
                    //set type = orther and  ALT =nyll and description =null
                    $scope.asset.alt_tag = null;
                    $scope.asset.description = null;
                    $scope.asset.title = null;
                }
                if($scope.asset.type == 'image' && $scope.asset.withFile && $scope.asset.heightFile){
                    if( $scope.asset.thumbnailsMedium && $scope.asset.withFile <100 && $scope.asset.heightFile <100)
                    {
                        alert('Max height is ' + $scope.asset.heightFile + ' pixels and Max width is ' + $scope.asset.withFile + ' pixels');
                        return;
                    }
                    if( $scope.asset.thumbnailsProduct && $scope.asset.withFile <82 && $scope.asset.heightFile <82)
                    {
                        alert('Max height is ' + $scope.asset.heightFile + ' pixels and Max width is ' + $scope.asset.withFile + ' pixels');
                        return;
                    }
                     if( $scope.asset.thumbnailsMaterial && $scope.asset.withFile <75 && $scope.asset.heightFile <75)
                    {
                        alert('Max height is ' + $scope.asset.heightFile + ' pixels and Max width is ' + $scope.asset.withFile + ' pixels');
                        return;
                    }
                     if( $scope.asset.thumbnailsSmall && $scope.asset.withFile <64 && $scope.asset.heightFile < 64)
                    {
                        alert('Max height is ' + $scope.asset.heightFile + ' pixels and Max width is ' + $scope.asset.withFile + ' pixels');
                        return;
                    }
                    if( $scope.asset.thumbnailsCustom && (!$scope.asset.thumbnailsHeight || !$scope.asset.thumbnailsWidth))
                    {
                        alert('Height and width is a required field');
                        return;
                    }
                     if( $scope.asset.thumbnailsCustom && ($scope.asset.withFile < $scope.asset.thumbnailsWidth || $scope.asset.heightFile < $scope.asset.thumbnailsHeight))
                    {
                         alert('Max height is ' + $scope.asset.heightFile + ' pixels and Max width is ' + $scope.asset.withFile + ' pixels');
                        return;
                    }
                }
                 $scope.showLoad  = true;
                $('#page-loading').css('display','block');
                // upload file to sever
                Upload.upload({
                    method:'POST',
                    url: baseUrl + '/api/asset-manager/edit-file',
                    file: $scope.filesUpload.listsFiles,
                    data:$scope.asset
                }).success(function(data, status, headers, config){
                    $scope.showLoad  = false;
                    $('#page-loading').css('display','none');
                    $modalInstance.close(data.item);
                });
            }else{
               $scope.checkUpload=true;
               return ;
            }
        }else{
           $scope.checkUpload=true;
           return;
        }

    };
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');

    };
    $scope.checkWithHeightValidate = function (file) {

        var reader = new FileReader();
        reader.readAsDataURL(file[0]);
        reader.onload = function(e) {
            var image = new Image();
            image.src = e.target.result;

            image.onload = function() {console.log('width', this.width, this.height);
                $scope.asset.withFile = this.width;
                $scope.asset.heightFile = this.height;
            };



        };

    };
}])
.controller('ModalViewAssetManagerCtrl', ['$scope', '$modalInstance', function ($scope, $modalInstance) {
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');

    };
}])
.controller('CreateNewAssetCtrl', ['$scope', '$modalInstance','AssetManagerService', function ($scope, $modalInstance,AssetManagerService) {
        $scope.showLoad  = false;
       $scope.submit = function (validate) {

            $scope.submitted  = true;
            if(validate) {
                $(".ng-invalid:eq(1)").focus();
                return;
            }
            if(typeof $scope.asset.folder=='undefined'){
                    return;
            }
             $scope.showLoad  = true;
            $scope.asset.type =  $scope.folderType[$scope.asset.folder];
            AssetManagerService.createNewAsset($scope.asset).then(function(data) {
                $scope.showLoad  = false;
                $modalInstance.close(data);
            })
        }

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');

        };
}])
.controller('editNameFolderAssetCtrl', ['$scope', '$modalInstance', 'AssetManagerService','$http','$q', function ($scope, $modalInstance, AssetManagerService, $http, $q) {

    $scope.checkFirstName = function(data) {
        if (data == '') {
          return "The first name is a required field";
        } else {
            $scope.userProfile.first_name = data;
            $scope.updateUser();
        }
    };

    $scope.checkEmtypeName = function (data) {
        //If folder name is null
        if (data == '') {
            return "The folder name is a required field";
        } else {
            $scope.folder.name = data;
            var d = $q.defer();
            $http.post('/api/asset-manager/edit-name-folder', {data: $scope.folder}).success(function(res) {
                res = res || {};
                if(res.status) {
                    d.resolve();
                    $modalInstance.close(res);
                } else {
                    d.resolve('Name has already been taken.');
                }
            }).error(function(e){
                d.reject('Server error!');
            });
            return d.promise;

            // $scope.folder.name = data;
            // AssetManagerService.editNameFolder($scope.folder).then(function (data){
            //     if(data.status != 0) {
            //         $modalInstance.close(data);
            //     }
            // })
        }
    }
}]).controller('ModalUploadNewVersion', ['$scope', '$modalInstance', 'AssetManagerService', function ($scope, $modalInstance, AssetManagerService) {
    $scope.showLoad  = false;
    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
    }

    $scope.updateNewVerSionFile = function() {
         $scope.showLoad  = true;
        AssetManagerService.updateContentFile($scope.asset).then(function(data) {
            $scope.showLoad  = false;
            $modalInstance.close(data);
        })
    }

}]);

