blockApp.controller('BlockManagerController', ['$scope', '$modal', 'ngTableParams','$timeout','BlockManagerService', 'CmsContentFolderService', '$filter', '$templateCache', 'CmsService', function ($scope, $modal, ngTableParams, $timeout, BlockManagerService, CmsContentFolderService, $filter, $templateCache, CmsService){

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
    $templateCache.remove('cms/block-manager/template');
    $templateCache.remove('cms/block-manager/template-manage-block');

    /* Set new value for CmsServiceContent*/
    $scope.blockManagers = CmsContentFolderService.setContents(window.folders, window.currentPage);

    // All tag content
    $scope.allTags = angular.copy(window.allTags);

    // Tags content tree
    $scope.tagsContent = angular.copy(window.tagsContent);

    /* Set value for item want active */
    $scope.pageSelected = window.idOfBlockSelected;

    /* Text in button show or hide all nested content */
    $scope.contentHideOrShowAllNestedContent = 'Show All Nested Content';

    /* If undefined blocks then set emtype array */
    if (angular.isUndefined($scope.blocks)) {
        $scope.blocks = [];
    }

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
        total: $scope.blocks.length,
        getData: function ($defer, params) {
            /* Filter and sort data */
            var filteredData = params.filter() ? $filter('filter')($scope.blocks, params.filter()) : $scope.blocks;
            var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
            params.total(filteredData.length);
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    })

    if($scope.pageSelected != 0) {
        CmsContentFolderService.setActiveNode($scope.pageSelected);
    }

    /* Call function in service to show tree folder of block */
    CmsContentFolderService.initTree(function(valueResult, nodeActive){
        $scope.blocks = [];
        /* If node activated is root node then set title is root */
        if (nodeActive.key == 'Blocks') {
            $scope.titleItemSelected = 'Blocks';
        } else if (nodeActive.folder == true) { /* If node activated is not root node but is folder */
            $scope.titleItemSelected = nodeActive.title;
        } else { /* If node active is not folder then set parent name of active node for title */
            if (angular.isUndefined (nodeActive.parent.data.name)) {
                $scope.titleItemSelected = 'Blocks';
            } else {
                $scope.titleItemSelected = nodeActive.parent.data.name;
            }
        }

        //When user click only one node
        if (angular.isDefined(valueResult) && valueResult.length == 1 && nodeActive.folder != true) {
            valueResult[0].expanded = true;
            $scope.blocks = valueResult;
        } else {
            angular.forEach(valueResult, function(value, key) {
                value.expanded = false;
                $scope.blocks.push(value);
            })
        }

        $scope.blocks = valueResult;

        $scope.tableParams.reload();
        if (angular.isDefined($scope.tableParams.$params)) {
            $scope.tableParams.$params.page = 1;
        }

        // If node is not root node then show btn delete folder
        if(nodeActive.data.parent_id != '0') {
            $scope.isShowBtnDelete = true;
        } else {
            $scope.isShowBtnDelete = false;
        }

        // If node actvated is not root node and node is folder then show btn edit name folder
        if (nodeActive.folder == true && nodeActive.data.parent_id != '0') {
            $scope.isShowBtnEditNameFolder = true;
        } else {
            $scope.isShowBtnEditNameFolder = false;
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
            $scope.blocks = dataResult.contents;
            $scope.tableParams.reload();
        })
    };

    $scope.checkPermission = function (asset) {
        var typeName = $scope.types_map[asset.asset_id];
        var check = window.editAssetPermission && ((window.jsPermission && typeName == 'javascript') || (window.cssPermission && typeName == 'css') || (window.imagePermission && typeName == 'image') || (window.videoPermission && typeName == 'video'));
        return check;
    };

    $scope.getChildrenPages = function(nodes) {
        var nodeDelete=[];
        for(var key in nodes) {
            if(angular.isUndefined(nodes[key].data)) return;
            /* Node have parrent_id = 0 then delete this node */
            if (nodes[key].key=='0') {
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
        $scope.blockManagers = nodes;
        $scope.tableParams.reload();
    };

    /**
     * Delete folder block
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    $scope.deleteFolderAndBlock = function () {
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
                BlockManagerService.deleteFolderAndBlock(activeNode.data._id).then(function (data) {
                    if (data['status']) {
                        // Remove active node
                        activeNode.remove();
                        // Get root node of node activated and set active
                        rootNodeOfNodeActive = _.find(rootNode.children, function(obj) { return obj.title == 'Blocks' });
                        rootNodeOfNodeActive.setActive();
                    }

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
     * Delete file of block
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {String} fileId Id of file
     *
     * @param  {Object} block      Block
     *
     * @return {Void}
     */
    $scope.deleteFileBlock = function (fileId, block) {
        // Call function to delete content
        BlockManagerService.deleteBlockFile(fileId).then(function (data) {
            // If delete successfull
            if (data.status != 0) {
                if(!angular.isUndefined(data.result)){
                    block.region = data.result.countUniqueRegion;
                    block.language = data.result.countUniqueLanguage;
                    block.status = data.result.status;
                }
                // Each block file
                angular.forEach(block.subBlocks, function (value, key) {
                    // Delete file deleted in block file array
                    if (value._id == fileId) {
                        block.subBlocks.splice(key, 1);
                        /*block = changeStatusTotalBlock(block);*/
                    }
                })

                $scope.tableParams.reload();
            }
        })
    };

    /**
     * change status of block total 
     *
     * @author Quang<quang@httsolution.com>
     * 
     * @param  object block block
     * @return object block
     */
    function changeStatusTotalBlock(block) {
        $listStatus = [];

        //get list status block
        for(i in block.contents) {
            $listStatus.push(block.contents[i].status);
        }

        //check and set statys for block
        if ($listStatus.indexOf('draft') > -1) {

            block.status = 'draft';

        } else {

            block.status = 'live';
        }
        //return block
        return block;
    }

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

        var teamplate = '/cms/block-manager/edit-name-folder/'+ activeNode.data._id + '?' + new Date().getTime();

        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + teamplate,
            controller: 'editNameFolderBlockCtrl',
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

        angular.element('.table-responsive').addClass('fix-height');
    };

    /**
     * Add tag for the page
     * @author Thanh Tuan <tuan@httsolution.com>
     * @param {String} pageId Id of the page
     * @param {String} tagId  Id of the tag
     */
    $scope.addTagsForPage = function (pageId, tagId) {
        $('#page-loading').css('display', 'block');
        console.log(pageId, tagId);
        $scope.tagId = tagId;
        BlockManagerService.addTagsForPage(pageId, {tags:$scope.tagId}).then(function (data){
            for (var key in $scope.blocks) {
                if ($scope.blocks[key].data._id == data.item._id) {
                    $scope.blocks[key].data.tags = data.item.tags;
                    break;
                }
            }
            $('#page-loading').css('display', 'none');
            $scope.tableParams.reload();
        });
    };

    /* When user choose one node then set this node for parent node want to create */
    $scope.getParentFolder = function () {
        /* Declare tree and get active node */
        var tree = $('#tree').fancytree('getTree');
        var activeNode = tree.getActiveNode();
        if (activeNode) {
            if(activeNode.folder==false ||angular.isUndefined(activeNode.folder)){
                $scope.selectedItemName = activeNode.getParent().title;
                $scope.selectedItemId = activeNode.getParent().key;
            } else{
                $scope.selectedItemName = activeNode.title;
                $scope.selectedItemId = activeNode.key;
            }
        }
    };

    var opened = false;
    /* poup modal crete new folder*/
    $scope.createFolderBlock = function(){
        if (opened) return;

        $scope.getParentFolder();
        var teamplate = '/cms/block-manager/create-folder' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
              templateUrl: window.baseUrl + teamplate,
              controller: 'ModalCreateFolderBlockCtrl',
              size: undefined,
              resolve: {
              }
        });
        opened = true
        modalInstance.result.then(function (data) {
            opened = false;
            var tree = $('#tree').fancytree('getTree');
            if(data.parent_id =='0'){
                var nodeparent = tree.getNodeByKey('0');
            } else{
                var nodeparent = tree.getNodeByKey(data.parent_id);
            }
            window.folderType[data.key] =  window.folderType[nodeparent.key];
            var child = nodeparent.addChildren(data);
            child.setExpanded();
            // Sort all child of root node
            nodeparent.sortChildren(null, true);
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    };

      /* poup modal crete new folder*/
    $scope.getModalEditBlock = function(id){
        // var teamplate = window.baseUrl + '/cms/block-manager/edit-block/'+id;
        // console.log(teamplate);
        $scope.getParentFolder();
        window.location.href = window.baseUrl + '/cms/block-manager/edit-block/' + id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
    };
    $scope.uploadNewBlock = function(){
        $scope.getParentFolder();
        if(angular.isUndefined(window.folderType[$scope.selectedItemId])){
            window.location.href = window.baseUrl + '/cms/block-manager/create-new-block' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
            return;
        }
        if(window.folderType[$scope.selectedItemId].indexOf("managed_block") != -1){
            window.location.href = window.baseUrl + '/cms/block-manager/create-new-block-manage' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        } else {
            window.location.href = window.baseUrl + '/cms/block-manager/create-new-block' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        }
    };
    $scope.getEditBlock = function(id){
        $scope.getParentFolder();
        if(angular.isUndefined(window.folderType[$scope.selectedItemId])){
            window.location = window.baseUrl + '/cms/block-manager/edit-block/' + id +  '?v='+new Date().getTime();
            return;
        }
        if(window.folderType[$scope.selectedItemId].indexOf("managed_block") != -1){
            window.location = window.baseUrl + '/cms/block-manager/edit-block-manage/' + id +  '?v='+new Date().getTime();
        } else {
          window.location = window.baseUrl + '/cms/block-manager/edit-block/' + id +  '?v='+new Date().getTime();
        }
    }

}])

.controller('ModalCreateFolderBlockCtrl', ['$scope', '$modalInstance','BlockManagerService', function ($scope, $modalInstance,BlockManagerService) {
    $scope.blockFolder = {};

    $scope.submit = function (validate) {
        $scope.submitted  = true;
        $scope.nameExists = false;
        if(validate){
            return true;
        }

        if (angular.isUndefined($scope.blockFolder.parent_id)) {
            return true;
        }

        BlockManagerService.createFolderProvider($scope.blockFolder).then(function (data){
            if(data.status == 0){
                $scope.nameExists = true;
                return true;
            }else{
                $scope.nameExists = false;
                $modalInstance.close(data.item);
            }
        });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');

    };
}])
.controller('editNameFolderBlockCtrl', ['$scope', '$modalInstance', 'BlockManagerService','$http','$q', function ($scope, $modalInstance, BlockManagerService, $http,$q) {

    $scope.checkEmtypeName = function (data) {
        //If folder name is null
        if (data == '') {
            return "The folder name is a required field";
        } else {
            $scope.folder.name = data;
            var d = $q.defer();
            $http.post('/api/block-manager/edit-name-folder/'+$scope.folder._id, $scope.folder).success(function(res) {
                res = res || {};
                if(res.status) {
                    d.resolve();
                    $modalInstance.close(res);
                } else {
                    d.resolve('Name has already been taken.');
                }
            }).error(function(result){
                    if (result['errors']) {
                        d.resolve(result['errors'][0])
                    } else {
                        d.reject('Server error!');
                    }
                
            });
            return d.promise;

            // $scope.folder.name = data;
            // BlockManagerService.editNameFolder($scope.folder).then(function (data){
            //     if(data.status != 0) {
            //         $modalInstance.close(data);
            //     }
            // })
        }
    }
}]);

