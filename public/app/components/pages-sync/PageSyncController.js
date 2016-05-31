pageApp.controller('PageSyncController', ['$scope', '$modal', '$filter', 'ngTableParams', 'PageSyncService', function($scope, $modal, $filter, ngTableParams, PageSyncService) {
    /* Default value for Loading page when click Sync */
    $scope.isLoading = false;
    /* Value pages to show tree folder */
    $scope.pages = window.pagesTree;
    $scope.currentPage = 0;
    /* Declare value to show page tree */
    $scope.pageTree = [];
    /* Function get all child page */
    $scope.getChildrenPages = function(nodes) {
        /* When user select multi pages, foreach pages and get child of page */
        for(var key in nodes) {
            /* Node have parrent_id = 0 then delete this node */
            if (nodes[key].data.parent_id == 0) {
                nodes.splice(key, 1);
            }
        }
        /* Show node resolve in table */
        $scope.pageTree = nodes;
        /* Reload table */
        $scope.tableParams.reload();  
    }
    /* Ng-table to paggination, sort and filter */
    $scope.tableParams = new ngTableParams({
        page: 1,
        count: 10,
        sorting: {
            title: 'asc'
        }

    }, {
        total: $scope.pageTree.length,
        getData: function ($defer, params) {
            /* Filter and sort data */
            var orderedData = params.filter() ? $filter('filter')($scope.pageTree, params.filter()) : $scope.pageTree;
            orderedData = params.sorting() ? $filter('orderBy')(orderedData, params.orderBy()) : orderedData;
            params.total($scope.pageTree.length);
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    })
    /* Show tree pages */
    $('#tree').fancytree({
        /* Show check box */
        checkbox: true,
        selectMode: 3,
        activate: function (event, data){
            var node = data.node;
            if(node.folder == true){
                if (!$scope.$$phase) {
                    node.setExpanded();
                    $scope.$apply(function(){
                        $scope.title = node.title;
                    })
                } else {
                    $scope.title = node.title;
                }
            }
        },
         select: function(event, data) {
        /* Get a list of all selected nodes, and convert to a key array */
        var selKeys = $.map(data.tree.getSelectedNodes(), function(node){
            return node;
        });
        /* Get children pages */
        $scope.getChildrenPages(selKeys);
        },
        source: $scope.pages,
        autoScroll: true,
    });

    /* Active first node in tree pages */
    var tree = $('#tree').fancytree('getTree');
    /* If getFirstChild isset then */
    if( angular.isDefined( tree.getFirstChild())) {
        /* Expanded first tree */
        tree.getFirstChild().setExpanded();
        /* Set active for first tree */
        tree.getFirstChild().setActive();
        /* Selected the first tree */
        tree.getFirstChild().setSelected();
    }
    /*  Call function to sync page to load pages */
    $scope.syncPage = function (){
        /* Show button loading waiting sync pages */
        $scope.isLoading = true;
        PageSyncService.syncPage().then(function (data){
            /* When data is resolved then show in tree pages */
            var tree = $('#tree').fancytree('getTree');
            /* Reload page tree */
            tree.reload(data.pages);
            /* Disable button Loading */
            $scope.isLoading = false;
        })
    }
}])