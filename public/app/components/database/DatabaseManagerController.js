databasemanagerApp.controller('DatabaseManagerController', ['$scope', '$modal', 'ngTableParams', '$timeout', 'DatabaseManagerService', 'CmsContentFolderService', '$filter', '$templateCache', 'CmsService', function ($scope, $modal, ngTableParams, $timeout, DatabaseManagerService, CmsContentFolderService, $filter, $templateCache, CmsService){

    $scope.currentNode = '';
    $scope.size = function(){
        CmsService.setHeightTable();
    }

    // Show icon show nested content
    $scope.isShowNested = true;

    // Not button delete folder
    $scope.isShowBtnDelete = false;

    // Not show btn edit name folder
    $scope.isShowBtnEditNameFolder = false;

    $scope.isShowCreateFolder = true;

    // Delete cache route provider
    $templateCache.remove('cms/database/template');

    /* Set new value for CmsServiceContent*/
    CmsContentFolderService.setContents(angular.copy(window.folders),window.currentPage);

    /* Set value for item want active */
    $scope.pageSelected = window.idOfDatabaseSelected;

    // All tag content
    $scope.allTags = angular.copy(window.allTags);

    // Node active
    var nodeActive;

    /* Text in button show or hide all nested content */
    $scope.contentHideOrShowAllNestedContent = 'Show All Nested Content';

    /* If undefined assets then set emtype array */
    if (angular.isUndefined($scope.database)) {
        $scope.database = [];
    }
    // Tags content
    $scope.tagsContent = angular.copy(window.tagsContent);

    /* Declare to contain value of title folder or file selected */
    $scope.titleItemSelected = 'Database';

    /* Hide show filter in table */
    $scope.isSearch = false;

    $scope.btnSearch = function () {
        $scope.isSearch = !$scope.isSearch;
    }
    
    if($scope.pageSelected != 0) {
        CmsContentFolderService.setActiveNode($scope.pageSelected);
    }

    /* Call function in service to show tree folder of block */
    CmsContentFolderService.initTree(function(valueResult, nodeActived){
        angular.element('#page-loading').css('display','block');
        $scope.database = [];
        nodeActive = nodeActived;
        $scope.isShowBtnCreateMaterial = false;
        $scope.isShowBtnCreateCategory = false;
        $scope.isShowBtnPlatform = false;
        $scope.isShowBtnCreateLaser = false;
        $scope.isDatabase = false;
        $scope.currentNode = nodeActive.key;
        // Material
        if (nodeActive.key == 'root_material') {
            $scope.currentNode = 'materials';
            $scope.isShowBtnCreateCategory = true;
            $scope.isShowBtnCreateMaterial = true;
            $scope.templateTable = window.baseUrl + '/app/components/database/partials/table-materials.html?v=' + new Date().getTime();
            $scope.database = nodeActive.data.materials;
        }

        if (nodeActive.key == 'root_platform') {
            $scope.database = nodeActive.data.content;
            $scope.isShowBtnPlatform = true;
            $scope.templateTable = window.baseUrl + '/app/components/database/partials/table-platforms.html?v=' + new Date().getTime();
        }

        if (nodeActive.key == 'root_accessories') {
            $scope.currentNode = 'accessories';
            $scope.isShowBtnCreateCategory = true;
            $scope.isShowBtnCreateMaterial = true;
            $scope.database = nodeActive.data.content;
            $scope.templateTable = window.baseUrl + '/app/components/database/partials/table-accessories.html?v=' + new Date().getTime();
        }

        if (nodeActive.key == 'root_lasers') {
            $scope.isShowBtnCreateLaser = true;
            $scope.database = nodeActive.data.content;
            $scope.templateTable = window.baseUrl + '/app/components/database/partials/table-lasers.html?v=' + new Date().getTime();
        }

        if (nodeActive.key == 'root_products') {
            $scope.database = nodeActive.data.content;
            $scope.templateTable = window.baseUrl + '/app/components/database/partials/table-products.html?v=' + new Date().getTime();
        }
        if (nodeActive.key == 'root_database') {
             $scope.isDatabase =true;
        }
        /* Ng-table to paggination, sort and filter */
        if($scope.database.length != 0) {
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
                total: $scope.database.length,
                getData: function ($defer, params) {
                    /* Filter and sort data */
                    var filteredData = params.filter() ? $filter('filter')($scope.database, params.filter()) : $scope.database;
                    var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
                    params.total(filteredData.length);
                    $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                }
            });
        }

        if (angular.isDefined($scope.tableParams)) {
            $scope.tableParams.reload();
            $scope.titleItemSelected = nodeActive.title;
        }
        angular.element('#page-loading').css('display','none');
        
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
            $scope.database = dataResult.contents;
            $scope.tableParams.reload();
        })
    }

    /**
     * Show group button in row
     * @author Thanh Tuan <tuan@httsolution.com>
     * @param  {Event} $event  Event
     * @return {Void}         
     */
    $scope.showGroup = function($event) {

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
                top: $event.pageY - 45 + 'px',
                right: w - $event.pageX - 30 + 'px',
            });
        }
        else{
            $('.group-btn-ac').css({
                top: $event.pageY - 140 + 'px',
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
    }

    /**
     * Create new material
     * @author Thanh Tuan <luc@httsolution.com>
     * @return {Void} 
     */
    $scope.createNewMaterial = function() {
        window.location.href = window.baseUrl + '/cms/database-manager/create-new-material?type='+$scope.currentNode;
    }

    /**
     * Create new laser
     * @author Tan Luc <tuan@httsolution.com>
     * @return {Void} 
     */
    $scope.createLaser = function() {
        window.location.href = window.baseUrl + '/cms/database-manager/create-laser';
    }

    /**
     * Edit name Category
     * @author Thanh Tuan <tuan@httsolution.com>
     * @return {Void} 
     */
    $scope.editNameCategory = function () {
        if (!nodeActive) return;

        var teamplate = '/cms/database-manager/edit-name-category/'+ nodeActive.data.id + '?v=' + new Date().getTime();

        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + teamplate,
            controller: 'editNameCategoryCtr',
            size: null,
            resolve: {
            }

        });

        modalInstance.result.then(function (data) {
            // Set title for node edited
            nodeActive.setTitle(data.category.name);
            if (angular.isDefined($scope.tableParams)) {
                $scope.tableParams.reload();
            }
            $scope.titleItemSelected = data.category.name;
        }, function () {

           });
    }

    /**
     * Create category 
     * @author Thanh Tuan <tuan@httsolution.com>
     * @return {Void} 
     */
    $scope.createCategory = function(idCategory) {
        var selectedItem = 0;
        if (angular.isDefined(nodeActive.data.id)) {
            var selectedItem = nodeActive.data.id;
        }
        if (typeof idCategory == 'undefined') {
            var template = '/cms/database-manager/create-category' + '?selectedItemId=' + selectedItem + '&&v=' + new Date().getTime()+'&&type='+$scope.currentNode;
        } else {
            var template = '/cms/database-manager/edit-category' + '?selectedItemId=' + selectedItem + '&&v=' + new Date().getTime()+'&&type='+$scope.currentNode + '&&id=' + idCategory;
        }
        var modalInstance = $modal.open({
              templateUrl: window.baseUrl + template,
              controller: 'ModalCreateCategoryDatabaseCtrl',
              size: undefined,
              resolve: {

              }
        });
        modalInstance.result.then(function (data) {
            if (typeof idCategory != 'undefined') {
                for (var key in $scope.database) {
                    if (parseInt($scope.database[key]['id']) == parseInt(data.id)) {
                        $scope.database[key] = data;
                        break;
                    }
                }

                $scope.tableParams.reload();
            }
            //nodeActive.addChildren(data);
        });
    };


    /**
     * Delete category and material 
     * @author Thanh Tuan <tuan@httsolution.com> update vanlinh@httsolution.com
     * @return Void
     */
    $scope.deleteCategoryAndMaterial = function (id) {
        // Disable btn delete
        //$scope.dsbBtnDelete = true;

        // Declare tree and get active node
        //var tree = $('#tree').fancytree('getTree');
        // Find root node
        //var rootNode = tree.getRootNode();
        // if node is folder
        //if (nodeActive.folder == true) {
        //    var comfrm = confirm("Are you sure you want to delete this folder? This will remove all contents under this folder, and may impact live web pages");
        //    nodeActive.data.type = 'category';
        //} else {
        //    var comfrm = confirm("Are you sure you want to delete this content?");
        //    nodeActive.data.type = 'material';
        //}
        
        var comfrm = confirm("Are you sure you want to delete this material?");
        var type = 'material';

        if ($scope.currentNode == 'accessories') {
            type = 'accessories';
        } else if($scope.currentNode == 'root_lasers'){
            type = 'laser';
        }
        // if user delete
        if (comfrm == true) {
            DatabaseManagerService.deleteMaterial(id, type).then(function (data) {
                // if delete success
                if (data.status) {
                    // delete item is delete
                   angular.forEach($scope.database, function(value, key) {
                        if(value.id == id){
                            $scope.database.splice(key, 1);
                        }
                    });
                   $scope.tableParams.reload();
                }
            })
            // If node isn't root then delete node and child node
            /*if (nodeActive.data.id) {
                // Call function to delete selected node
                DatabaseManagerService.deleteCategoryAndMaterial(nodeActive.data).then(function (data) {
                    if (data.status) {
                        // Remove active node
                        nodeActive.remove();
                        // Get root node of node activated and set active
                        rootNodeOfNodeActive = _.find(rootNode.children, function(obj) { return obj.title == 'Database' });
                        rootNodeOfNodeActive.setActive();

                        // Enable btn delete
                        $scope.dsbBtnDelete = false;
                    }
                })
            } */
          /*  else {
                // Enable btn delete
                $scope.dsbBtnDelete = false;
                return;
            }*/
        }
    }
    $scope.getModalRequestTranslationTemplate = function(id, subFiles) {
        var subFile= [];
        angular.forEach(subFiles, function(value, key) {
            if(value.language =='en'&& (value.region == null||!value.region)){
                subFile = value;
            }

        })
        var template = '/cms/database-manager/request-translation-material/' + id + '?v='+new Date().getTime();
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + template,
            controller: 'ModalRequesDatabasetController',
            size: undefined,
            resolve: {
                folder_id: function() {
                    return null;
                },
                subFile: function() {
                    return subFile;
                }
            }
        });
        modalInstance.result.then(function(data) {
           var tree = $('#tree').fancytree('getTree');
            // Get node edit
            var nodeCurent = tree.getNodeByKey(data.key);
            if(!angular.isUndefined(nodeCurent)&& nodeCurent != null){
                 nodeCurent.remove(); // delete node != null
            }
             // Add node for tree and set active for this node
            node = $('#tree').fancytree('getTree').getNodeByKey('category_' + data.category_id);

            nodeAdd = node.addChildren(data);
            nodeAdd.setActive();
            // Sort child of root node
            node.sortChildren(null, true);
            $scope.tableParams.reload();
        },function () {
            console.info('Modal dismissed at: ' + new Date());
        });
    }

    /* poup modal Request Translation*/
    $scope.getModalRequestRegionTemplate = function(id, subFile) {
        var template = '/cms/database-manager/request-region-material/' + id + '?v='+new Date().getTime();
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + template,
            controller: 'ModalRequesDatabasetController',
            size: undefined,
            resolve: {
                folder_id: function() {
                    return null;
                },
                subFile: function() {
                    return subFile;
                }
            }
        });
        modalInstance.result.then(function(data) {
            var tree = $('#tree').fancytree('getTree');
            // Get node edit
            var nodeCurent = tree.getNodeByKey(data.key);
            if(!angular.isUndefined(nodeCurent)&& nodeCurent != null){
                 nodeCurent.remove(); // delete node != null
            }
             // Add node for tree and set active for this node
            node = $('#tree').fancytree('getTree').getNodeByKey('category_' + data.category_id);
            
            nodeAdd = node.addChildren(data);
            nodeAdd.setActive();
            // Sort child of root node
            node.sortChildren(null, true);
            $scope.tableParams.reload();
        },function () {
            console.info('Modal dismissed at: ' + new Date());
        });
    }

    /* poup modal crete new folder*/
    $scope.createGroupAccesstories = function(){
 
        var modalInstance = $modal.open({
              templateUrl: window.baseUrl + '/cms/accessories/create-folder',
              controller: 'ModalCreateGroupAccesstoriesCtrl',
              size: undefined,
              resolve: {
              }
            });
        modalInstance.result.then(function (data) {
            // window.folderType = data.folderType; 
            var data = data.item;
            // opened = false;
            // Format data
            console.log(data);
            // Get tree
            var tree = $('#tree').fancytree('getTree');
            // Get parent node of node added
            var nodeparent = tree.getNodeByKey('root_accessories');

            // Add node created for parent node
            nodeparent.addChildren(data);
            // Get node added
            var nodeAdded = tree.getNodeByKey(data.key);
            // Set active for node Added
            nodeAdded.setActive();
            // Sort child of root node
            $timeout(function() {
                nodeparent.sortChildren(null, true);
            });
        },function () {
        });
    }



}]).controller('ModalCreateGroupAccesstoriesCtrl', ['$scope', '$modalInstance','DatabaseManagerService','AccessoriesService', function ($scope, $modalInstance,DatabaseManagerService, AccessoriesService) {
    // $scope.showLoad  = false;
    // $scope.changeName = function(){
    //     $scope.nameExists = false;
    // }

    $scope.submit = function (validate) {
        // $scope.submitted  = true;
        // $scope.nameExists = false;
        // if(validate){
        //     $(".ng-invalid:eq(1)").focus();
        //     return;
        // }
        // if(typeof $scope.assetManager.parent_id=='undefined'|| $scope.assetManager.parent_id==''){
        //     $(".ng-invalid:eq(1)").focus();
        //     return;
        // }
        // $scope.showLoad  = true;
        AccessoriesService.createFolderProvider($scope.accestories).then(function (data){
            // $scope.showLoad  = false;
            // if(data.status == 0){
            //     // $(".ng-invalid:eq(1)").focus();
            //     // $scope.nameExists = true;
            //     // return;
            // }else{
            //     // $scope.nameExists = false;
                $modalInstance.close(data);
            // }
        });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');

    };
}]).controller('ModalCreateCategoryDatabaseCtrl', ['$scope', '$modalInstance','DatabaseManagerService', function ($scope, $modalInstance,DatabaseManagerService) {
    $scope.exists = false;
    $scope.submit = function (validate) {
        $scope.submitted  = true;
        $scope.nameExists = false;
        if(validate|| (angular.isUndefined($scope.category.parent_id) && $scope.type === 'material')){
            return;
        }

        if ($scope.type == 'accessories') {
            $scope.category.parent_id = 0;
            $scope.category.type = 'accessories';
        }

        DatabaseManagerService.createCategory($scope.category).then(function (data){
            if(data.status == 0){
                if (data.errors) {
                    $scope.error = data.errors;
                    return true;
                }
                if(data.item.checkName){
                    alert('Not exist table name is ' + data.item.name + ' in category!');
                } else {
                    $scope.nameExists = true;
                }
                return;
            }else {
                $scope.nameExists = false;
                $modalInstance.close(data.item);
            }
        });
    };

    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');

    };
}]).controller('editNameCategoryCtr', ['$scope', '$modalInstance', 'DatabaseManagerService', function ($scope, $modalInstance, DatabaseManagerService) {
    $scope.checkEmtypeName = function (data) {
        //If category name is null
        if (data == '') {
            return "The category name is a required field";
        } else {
            $scope.category.name = data;
            DatabaseManagerService.editNameCategory($scope.category).then(function (data){
                if(data.status != 0) {
                    $modalInstance.close(data);
                }else {
                    $scope.nameExists = true;
                }
            })
        }
    }
}]).controller('ModalRequesDatabasetController', ['$scope', '$modal', '$filter', '$modalInstance', 'folder_id', 'DatabaseManagerService', 'subFile','$timeout', function($scope, $modal, $filter, $modalInstance, folder_id, DatabaseManagerService, subFile,$timeout) {
    $scope.languages_selected = {};
    $scope.requiredLanguage = true;
    $scope.requiredRegion = true;
    $scope.regions_selected = {};
    // if (typeof $scope.template == 'undefined') {
    //     $scope.template = {};
    //     $scope.template.folder_id = folder_id == 'root' ? '' : folder_id;
    // }

    //Click button submit
    $scope.submit = function(validate) {
        $scope.submitted = true;
        
        if (validate) {
            $(".ng-invalid:eq(1)").focus();
            return;
        }

        if ($scope.material.modal == 'request_translation' && $scope.requiredLanguage) {
            $(".ng-invalid:eq(1)").focus();
            return;
        }
        if ($scope.material.modal == 'request_region' && $scope.requiredRegion) {
            $(".ng-invalid:eq(1)").focus();
            return;
        }
   
        $('#btnSubmit').attr('disabled', 'true');
        $scope.material.copyContent = subFile.id;
        if ($scope.material.id && $scope.material.modal == 'request_translation') {
            $scope.material.languages = $scope.languages_selected;
            DatabaseManagerService.requestTranslation($scope.material).then(function(data) {
                $modalInstance.close(data.item);
            });
        }

        if ($scope.material.id && $scope.material.modal == 'request_region') {
            $scope.material.regions = $scope.regions_selected;
            DatabaseManagerService.requestRegion($scope.material).then(function(data) {
                $modalInstance.close(data.item);
            });
        }

    }

    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
    }

}]);



