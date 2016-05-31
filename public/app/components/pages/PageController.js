var pageApp = angular.module('pageApp');

pageApp.controller('PageController', ['$scope', '$modal', '$filter', 'ngTableParams', '$http', 'PageService', '$window', '$timeout', '$filter', '$cookieStore', 'CmsContentFolderService', '$templateCache', 'CmsService', function ($scope, $modal, $filter, ngTableParams, $http, PageService, $window, $timeout, $filter, $cookieStore, CmsContentFolderService, $templateCache, CmsService){

    $scope.size = function(){
        CmsService.setHeightTable();
    }
    // Show icon show nested content
    $scope.isShowNested = true;

    // Not show button delete folder
    $scope.isShowBtnDelete = false;

    // Not show btn edit name folder
    $scope.isShowBtnEditNameFolder = false;

    // Delete cache route provider
    $templateCache.remove('cms/pages/template');

    /* Set new value for CmsServiceContent*/
    CmsContentFolderService.setContents(angular.copy(window.pages),window.currentPage);

    /* Set value for item want active */
    $scope.pageSelected = angular.copy(window.idOfPageSelected);

    /* Text in button show or hide all nested content */
    $scope.contentHideOrShowAllNestedContent = 'Show All Nested Content';

    /* If undefined pages then set emtype array */
    if (angular.isUndefined($scope.pages)) {
        $scope.pages = [];
    }

    // Tags content tree
    $scope.tagsContent = angular.copy(window.tagsContent);

    // All tag content
    $scope.allTags = angular.copy(window.allTags);

	$scope.currentFolderId = 0;
	$scope.listFolderSelected = [];
	$scope.baseUrl = window.baseUrl;
    $scope.labels = window.labels;

	/* Hide show filter in table */
	$scope.isSearch = false;

	$scope.btnSearch = function () {
		$scope.isSearch = !$scope.isSearch;
	}

	/* Ng-table to paggination, sort and filter */


    if($scope.pageSelected != 0) {
        CmsContentFolderService.setActiveNode($scope.pageSelected);
    }
    /**
     * [getDataFromNode convert node to object javascript]
     * @author toan
     * @param  {[type]} node [description]
     * @return {[type]}      [description]
     */
    var getDataFromNode = function(node){
        // When use choose only one node
        if ($scope.toggleChild == true) {
            node.data.openChild = true;
        } else {
            node.data.openChild = false;
        }

        var data = node.data;
        data['title'] = node.title;
        data['parent_title'] = node.parent.title;
        return data;
    }

    $scope.historyPage = function($id){
        window.location.href = window.baseUrl + '/cms/pages/history/' + $id;
    }
    /* Function hide or show all nested content */
    $scope.hideOrShowAllNestedContent = function () {
        $scope.pages = [];
        CmsContentFolderService.changeStatusHideOrShowAllNestedContent().then(function (dataResult) {
          
            $scope.contentHideOrShowAllNestedContent = dataResult.textButton;

            /* When user click show all nested content then */
            if ($scope.contentHideOrShowAllNestedContent == 'Hide All Nested Content') {
                $scope.isShowNested = false;
                /* If node active not root node then push nodeActive for $scope.page */
                if ((dataResult.nodeActive.title != 'Pages')) {
                    $scope.pages.push(getDataFromNode(dataResult.nodeActive));
                }

                /* Set all child node of activated node for $scope.page and reload table */
                $scope.showAllChild(dataResult.nodeActive.children);
                $scope.tableParams.reload();

            /* When user click hide all nested content then */
            } else if ($scope.contentHideOrShowAllNestedContent == 'Show All Nested Content') {
                $scope.isShowNested = true;
                /* If node active not root node then push nodeActive for $scope.page */
                if (dataResult.nodeActive.title != 'Pages') {
                    $scope.pages.push(getDataFromNode(dataResult.nodeActive));
                }

                /* Set all level child node of node activated */
                for (var i in dataResult.nodeActive.children) {
                    $scope.pages.push(getDataFromNode(dataResult.nodeActive.children[i]));
                }
                $scope.tableParams.reload();
            }
        })
    }
    $scope.$watch('tableParams', function(newVal, oldVal){
            //init filter for stats
            if(angular.isDefined(window.status) && window.status != ''&&window.status != 'false') {
                var status = window.status;
                $scope.tableParams.filter()['status'] = angular.copy(window.status);
                window.status = '';
                $timeout(function(){
                   $scope.tableParams.reload();
                });
                $scope.isSearch = true;
            }
            if(angular.isDefined(window.clickUpdate) && window.clickUpdate !='false' && window.clickUpdate) {
                $scope.tableParams.sorting({updated_at: 'desc'});
                window.clickUpdate = false;
                $timeout(function(){
                   $scope.tableParams.reload();
                });
                $scope.isSearch = true;
            }

    });

    /* Call function in service to show tree folder of block */
    CmsContentFolderService.initTree(function(valueResult, nodeActive){
        $scope.pages = [];
        /* If node activated is root node then set title is root */
        if (nodeActive.data.parent_id == '0') {
            $scope.titleItemSelected = 'Pages';
        } else if (nodeActive.folder == true) { /* If node activated is not root node but is folder */
            $scope.titleItemSelected = nodeActive.title;
        } else { /* If node active is not folder then set parent name of active node for title */
            if (angular.isUndefined (nodeActive.parent.data.name)) {
                $scope.titleItemSelected = 'Pages';
            } else {
                $scope.titleItemSelected = nodeActive.parent.data.name;
            }
        }

        // If node is not root node then show btn delete folder
        if (nodeActive.data.parent_id != '0') {
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


         // if user choosed nested content we will need get nested content to show
        if(!$scope.isShowNested){
            var contents = CmsContentFolderService.getDataNestedFromActiveNode();
        }else{
            var contents = CmsContentFolderService.getDataFromActiveNode(true);
        }

        $scope.toggleChild = false;
        // When use choose only one node
        if (angular.isDefined(contents) && contents.length == 1) {
            $scope.toggleChild = true;
        }

        //put contents to $scope.pages
        for(var key in contents){
            $scope.pages.push(getDataFromNode(contents[key]));
        }
        // if ngtable not yet constructed we will contrust it
        if(angular.isUndefined($scope.tableParams)){
            $scope.tableParams = new ngTableParams({
                page: 1,
                count: 100,
                sorting: {
                    title: 'asc'
                },
                filter: {
                       title:''
                    }

            }, {
                total: $scope.pages.length,
                getData: function ($defer, params) {
                    /* Filter and sort data */
                    var filteredData = params.filter() ? $filter('filter')($scope.pages, params.filter()) : $scope.pages;
                    var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
                    params.total(filteredData.length);
                    $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                }
            })
        }else{
            // reload ngtable
            $scope.tableParams.reload();
        }
    });

    if ((!angular.isUndefined(window.status)&&window.status != 'false')||(!angular.isUndefined(window.clickUpdate)&&window.clickUpdate !='false' && window.clickUpdate)){
        $scope.contentHideOrShowAllNestedContent = 'Hide All Nested Content';
        $scope.hideOrShowAllNestedContent();
     }
    
    /* When user choose one node then set this node for parent node want to create */
    $scope.getParentFolder = function () {
        /* Declare tree and get active node */
        var tree = $('#tree').fancytree('getTree');
        var activeNode = tree.getActiveNode();
        if (activeNode) {
            $scope.selectedItemName = activeNode.title;
            $scope.selectedItemId = activeNode.key;
        }
    }

    /* Function to select all chill off active node */
    $scope.showAllChild = function (node) {
        for (var key in node) {
            if (node[key].children != null) {
                $scope.showAllChild(node[key].children);
            }
            $scope.pages.push(getDataFromNode(node[key]));
        }
    }

    /**
     * Delete folder page
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    $scope.deletePage = function () {
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
                PageService.deletePage(activeNode.data._id).then(function (data) {
                    var parent = activeNode.getParent();
                    // Remove active node
                    activeNode.remove();

                    if(parent.children == null) {
                        parent.folder = false;
                        parent.render();
                    }
                    
                    // Get root node of node activated and set active
                    rootNodeOfNodeActive = _.find(rootNode.children, function(obj) { return obj.title == 'Pages' });
                    rootNodeOfNodeActive.setActive();
                    rootNodeOfNodeActive.render();

                    // Enable btn delete
                    $scope.dsbBtnDelete = false;
                });
            }
        } else {
            // Enable btn delete
            $scope.dsbBtnDelete = false;
            return;
        }
    }

    /**
     * Delete content of page
     *
     * @author Thanh Tuan <tuan@httsolution.com
     *
     * @param  {String} contentId Id of content
     *
     * @param  {Object} page      Page
     *
     * @return {Void}
     */
    $scope.deleteContent = function (contentId, page) {
        // Call function to delete content
        PageService.deleteContentPage(contentId).then(function (data) {
            // If delete successfull
            if (data.status != 0) {
                if(!angular.isUndefined(data.result)){
                    page.region = data.result.countUniqueRegion;
                    page.language = data.result.countUniqueLanguage;
                }
                // Each page content
                angular.forEach(page.contents, function (value, key) {
                    // Delete cotent deleted in page content array
                    if (value._id == contentId) {
                        page.contents.splice(key, 1);
                        page = changeStatusTotalPage(page);
                        return;
                    }
                })

                $scope.tableParams.reload();
            }
        })
    };

    /**
     * change status of page total
     *
     * @author Quang<quang@httsolution.com>
     *
     * @param  object page page
     * @return object page
     */
    function changeStatusTotalPage(page) {
        $listStatus = [];

        //get list status page
        for(i in page.contents) {
            $listStatus.push(page.contents[i].status);
        }

        //check and set statys for page
        if ($listStatus.indexOf('Not Started') > -1) {

            page.status = 'Not Started';

        } else if ($listStatus.indexOf('In Process') > -1) {

            page.status = 'In Process';

        } else if ($listStatus.indexOf('Approved') > -1) {

            page.status = 'Approved';

        } else if ($listStatus.indexOf('Overdue') > -1) {

            page.status = 'Overdue';

        } else {

            page.status = 'live';
        }
        //return page
        return page;
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

        var teamplate = '/cms/pages/edit-name-folder/'+ activeNode.data._id + '?' + new Date().getTime();

        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + teamplate,
            controller: 'editNameFolderPageCtrl',
            size: null,
            resolve: {
            }

        });

        modalInstance.result.then(function (data) {
            // Set title for node edited
            activeNode.setTitle(data.folder.name);
            activeNode.setActive();
            activeNode.getParent().sortChildren(null, true);
            $scope.tableParams.reload();
            $scope.titleItemSelected = data['folder']['name'];
        }, function () {

           });
    }

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
        PageService.addTagsForPage(pageId, {tags:$scope.tagId}).then(function (data){
            for (var key in $scope.pages) {
                if ($scope.pages[key]._id == data.item._id) {
                    $scope.pages[key].tags = data.item.tags;
                    break;
                }
            }
            $('#page-loading').css('display', 'none');
            $scope.tableParams.reload();
        });
    };

    var opened = false;

    /* poup modal crete new page*/
    $scope.getModalCreatePage = function(){
        if (opened) return;
        $scope.getParentFolder();
        var teamplate = '/cms/pages/create' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + teamplate,
            controller: 'CreatePageController',
            size: undefined,
            resolve: {
                content_id : function (){
                    return null;
                }
            }
        });
        opened = true;
        modalInstance.result.then(function (data) {
            opened = false;
            /* When user create new page not exists in system */
            if (angular.isDefined(data)) {
                var tree = $('#tree').fancytree('getTree');
                if(data.parent_id =='0'){
                    var nodeparent = tree.getNodeByKey('root');
                } else{
                    var nodeparent = tree.getNodeByKey(data.parent_id);
                }
                var child= nodeparent.addChildren(data);
                child.setExpanded();

                if(data.parent_id !='0'){
                     nodeparent.folder=true;
                }
                nodeparent.setActive(false);
                nodeparent.setActive();
                nodeparent.sortChildren(null, true);
            }
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }
     /* poup modal Request Translation*/
    $scope.getModalRequestTranslation = function(id){
        if (opened) return;
        $scope.getParentFolder();
        var teamplate = '/cms/pages/request-translation/' + id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
              templateUrl: window.baseUrl + teamplate,
              controller: 'CreatePageController',
              size: undefined,
              resolve: {
                content_id : function (){
                    return id;
                }
              }
            });
        opened = true;
        modalInstance.result.then(function (data) {
            opened = false;
            var tree = $('#tree').fancytree('getTree');
            // Get node edit
            var nodeCurent = tree.getNodeByKey(data.key);
            if(!angular.isUndefined(nodeCurent)&& nodeCurent != null){
                 nodeCurent.remove(); // delete node != null
            }
             // Add node for tree and set active for this node
            node = $('#tree').fancytree('getTree').getNodeByKey(data.parent_id);
            nodeAdd = node.addChildren(data);
            nodeAdd.setActive();
            // Sort child of root node
            node.sortChildren(null, true);
            $scope.tableParams.reload();

        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }
    /* poup modal request region*/
    $scope.getModalRequestRegion = function(id){
        if (opened) return;
        $scope.getParentFolder();
        var teamplate = '/cms/pages/request-region/' + id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
              templateUrl: window.baseUrl + teamplate,
              controller: 'CreatePageController',
              size: undefined,
              resolve: {
                content_id : function (){
                    return id;
                }
              }
            });
        opened = true;
        modalInstance.result.then(function (data) {
            opened = false;
            var tree = $('#tree').fancytree('getTree');
            // Get node edit
            var nodeCurent = tree.getNodeByKey(data.key);
            if(!angular.isUndefined(nodeCurent)&& nodeCurent != null){
                 nodeCurent.remove(); // delete node != null
            }
             // Add node for tree and set active for this node
            node = $('#tree').fancytree('getTree').getNodeByKey(data.parent_id);
            nodeAdd = node.addChildren(data);
            nodeAdd.setActive();
            // Sort child of root node
            node.sortChildren(null, true);
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }
    /* poup modal request revision*/
    $scope.getModalRequestRevision = function(id){
        if (opened) return;
        $scope.getParentFolder();
        var teamplate = '/cms/pages/request-revision/' + id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+ new Date().getTime();
        var modalInstance = $modal.open({
              templateUrl: window.baseUrl + teamplate,
              controller: 'CreatePageController',
              size: undefined,
              resolve: {
                content_id : function (){
                    return id;
                }
              }
            });
        opened = true;
        modalInstance.result.then(function (data) {
            opened = false;
            var tree = $('#tree').fancytree('getTree');
            // Get node edit
            var nodeCurent = tree.getNodeByKey(data.key);
            if(!angular.isUndefined(nodeCurent)&& nodeCurent != null){
                 nodeCurent.remove(); // delete node != null
            }
             // Add node for tree and set active for this node
            node = $('#tree').fancytree('getTree').getNodeByKey(data.parent_id);
            nodeAdd = node.addChildren(data);
            nodeAdd.setActive();
            // Sort child of root node
            node.sortChildren(null, true);
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }
      /**
     * Move Page
     *
     * @author van linh <vanlinh@httsolution.com>
     *
     * @return Void
     */
    $scope.movePage = function (page) {
        var teamplate = '/cms/pages/move-page/'+ page._id + '?v=' + new Date().getTime();

        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + teamplate,
            controller: 'movePageCtrl',
            size: null,
            resolve: {
                page : function (){
                    return page;
                }
            }

        });

        modalInstance.result.then(function (data) {
            var tree = $('#tree').fancytree('getTree');
            // Get node edit
            var nodeCurent = tree.getNodeByKey(data.key);
            if(!angular.isUndefined(nodeCurent)&& nodeCurent != null){
                var nodeCurentParent = nodeCurent.getParent();
                nodeCurent.remove(); // delete node != null
                if(!nodeCurentParent.hasChildren()){
                    nodeCurentParent.folder = false;
                    nodeCurentParent.setActive();
                }
            }
             // Add node for tree and set active for this node
            node = $('#tree').fancytree('getTree').getNodeByKey(data.parent_id);
            node.folder = true;
            nodeAdd = node.addChildren(data);
            nodeAdd.setActive();
            // Sort child of root node
            node.sortChildren(null, true);
      
        },function () {

           });
    }

}])
.controller('ModalCreteFolderCtrl', ['$scope', '$modalInstance', 'PageService', function ($scope, $modalInstance, PageService) {

	$scope.submit = function (invalid) {
		$scope.submitted=true;
		if(invalid){
            $(".ng-invalid:eq(1)").focus();
		    return;
		}
		PageService.createFolder($scope.folder).then(function (data){
			if(data.status == 0) {
				$scope.error = "Folder exist";
			} else {
				$modalInstance.close(data);
			}
		})
	};
	$scope.cancel = function () {
	    $modalInstance.dismiss('cancel');
	};
}])
.filter('lowercase', function () {
	return function (input) {
		if (input) {
			return input.replace(/\s+/g,'').toLowerCase();
		}
	};
})
.controller('editNameFolderPageCtrl', ['$scope', '$modalInstance', 'PageService','$http','$q', function ($scope, $modalInstance, PageService,$http,$q) {

    $scope.checkEmtypeName = function (data) {
        $scope.checkName = false;
        //If folder name is null
        if (data == '') {
            return "The folder name is a required field";
        } else {
            $scope.folder.name = data;
            var d = $q.defer();
            $http.post('/api/pages/edit-name-folder', {data: $scope.folder}).success(function(res) {
                console.log(res,'res');
                res = res || {};
                if(res.status) { // {status: "ok"}
                    d.resolve();
                    $modalInstance.close(res);
                } else { // {status: "error", msg: "Username should be `awesome`!"}
                    d.resolve('Name has already been taken.');
                    // $scope.folder.name =
                }
            }).error(function(e){
                d.reject('Server error!');
            });
            return d.promise;

            // $scope.folder.name = data;
            // PageService.editNameFolder($scope.folder).then(function (data){
            //     if(data.status != 0) {
            //         $modalInstance.close(data);
            //     } else {
            //         $scope.checkName = true;
            //     }
            // })
        }
    }
}]).controller('movePageCtrl', ['$scope', '$modalInstance', 'PageService','$http','$q','page', function ($scope, $modalInstance, PageService,$http,$q,page) {
    $scope.$watch('parent._id', function(newVal, oldVal){
        $scope.error = false ;      
    });
    $scope.submit = function (parentID) {
        if(parentID ==page.parent_id){
            $modalInstance.dismiss('cancel');
        }
        var data =[];
        data.pageId = page._id;
        data.parentID = parentID;
        angular.element('#page-loading').css('display','block');
        PageService.movePage(data).then(function (data){
            angular.element('#page-loading').css('display','none');
            if(data.status == 0) {
                $scope.error = "Name Page has already been taken";
            } else {
                $modalInstance.close(data.page);
            }
        })
    };
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');
    };
}]);
