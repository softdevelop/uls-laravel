/**
 * Cms Content folder service
 *
 * @author Thanh Tuan <tuan@httsolution.com>
 *
 */
var cmsApp = angular.module('cmsContentFolderApp');
cmsApp.service('CmsContentFolderService', ['$q', function ($q) {
    var that = this;

    /* Declare new array to contain value */
    var contents = [];

    /* Declare new status show or hide all nested content */
    var statusHideOrShowAllNestedContent = false;

    /* Declare to contain text to show in button show or hide all nested content */
    var textInButtonShowOrHideAllNestedContent = '';

    /* Declare to cotain node is active */
    var nodeActive;

    /* Declare id of node activated */
    var idOfNodeActivated = '';

    // Confirm current page
    var currentPage = '';

    /* Function to change status to show or hide all nested content */
    this.changeStatusHideOrShowAllNestedContent = function () {
        /* Set array null for content */
        contents = [];

        statusHideOrShowAllNestedContent = !statusHideOrShowAllNestedContent; // change status to true or false

        if (statusHideOrShowAllNestedContent == false) { // When user click hide all nested contents
            if (!nodeActive.isFolder()) { // When user click node not folder
                contents.push(nodeActive);
            } else {
                this.showFirstLevelOfChildPages(nodeActive.children);
            }
            textInButtonShowOrHideAllNestedContent = 'Show All Nested Content';
        }else {// When user click show all nested content
            if (!nodeActive.isFolder()) { // When user click not not folder
                contents.push(nodeActive);
            } else {
                this.showAllLevelOfChildPages(nodeActive.children);
            }
            textInButtonShowOrHideAllNestedContent = 'Hide All Nested Content';
        }

        var dataResult = {
            'textButton' : textInButtonShowOrHideAllNestedContent,
            'contents' : contents,
            'nodeActive': nodeActive
        }

        /* Return value */
        var defer = $q.defer();
        defer.resolve(dataResult);
        return defer.promise;
    }
    /**
     * [getAllDataOfNestedContent get all data of nested content of current node]
     * @author toan
     * @return {[Node]} return list nodes from tree
     */
    this.getDataNestedFromActiveNode = function(){
        contents = [];
        if (!nodeActive.isFolder()) { // When user click not not folder
            nodeActive.openChild = true;
            contents.push(nodeActive);
        } else {
            this.showAllLevelOfChildPages(nodeActive.children);
        }
        return contents;
    }
    /**
     * [getDataFromActiveNode get data from active node]
     * @return {[Node]} return list nodes from tree
     */
    this.getDataFromActiveNode = function(needPushNodeActiveToTrue){
        var arrayType = ['blocks', 'assets', 'templates'];
        if (arrayType.indexOf(nodeActive.data.type) > -1) return;
        
        contents = [];
        if (!nodeActive.isFolder()) { // When user click not not folder
            nodeActive.openChild = true;
            contents.push(nodeActive);
        } else {
            // only push nodeactive that it is not the root
            if(needPushNodeActiveToTrue && nodeActive.data.parent_id != 0){
                contents.push(nodeActive);
            }
            for(var key in nodeActive.children){
                contents.push(nodeActive.children[key]);
            }
            
        }
        return contents;
    }

    /* Function to reload fancytree */
    this.reloadTree = function () {
        /* Declare tree */
        var tree = $('#tree').fancytree('getTree');
        tree.reload();
    }

	/* Show tree pages */
    this.initTree = function(callback){
        // When user click in other folder root diffirent current folder root then set status is false
        statusHideOrShowAllNestedContent = false;
        $('#tree').fancytree({
            extensions: ["glyph"],
            source: contents,
            autoScroll: true,
            activate: function (event, data){

                /* Declare tree */
                var tree = $('#tree').fancytree('getTree');
                var node = $("#tree").fancytree("getActiveNode");

                // Get root node and sort all child of root node
                node.sortChildren(null, true);

                /* Get Node with id */
                nodeActive = tree.getNodeByKey(String(idOfNodeActivated));
                if (nodeActive != null) { // If node active not null then set active for node
                    nodeActive.setActive();
                    idOfNodeActivated = '';
                } else { /* Get current node is activated */
                    nodeActive = node;
                }

                // Expand all child node of node active
                that.expandAllChildNodes(nodeActive);

                /* Get child nodes of active node */
                var childNodesOfActiveNode = nodeActive.getChildren();

                contents = []; // Set emtype array for contain data to show in table

                /* When user click not not folder */
                if (!nodeActive.isFolder() || angular.isUndefined(nodeActive.folder)) {
                    contents.push(nodeActive);
                }

                /* If user hide all nested content page */
                if (statusHideOrShowAllNestedContent == false) {
                    that.showFirstLevelOfChildPages(childNodesOfActiveNode);
                } else {
                    that.showAllLevelOfChildPages(childNodesOfActiveNode);
                }

                /* return value */
                var valueResult = callback.call(valueResult, contents, nodeActive);
            },

            click: function (event, data){
                var node = data.node;
                if (!node.isExpanded()) {
                     if(angular.isDefined(node.data.type)){

                        switch(node.data.type) {
                            case 'assets':
                                if(node.data.type != currentPage) {
                                    $('#page-loading').css('display', 'block');
                                }
                                $( "#click-asset").click();
                            break;

                            case 'templates':
                                if(node.data.type != currentPage) {
                                    $('#page-loading').css('display', 'block');
                                }
                                $( "#click-template").click();
                            break;

                            case 'pages':
                                if(node.data.type != currentPage) {
                                    $('#page-loading').css('display', 'block');
                                }
                                $( "#click-page").click();
                            break;

                            case 'blocks':
                                if(node.data.type != currentPage) {
                                    $('#page-loading').css('display', 'block');
                                }
                                $( "#click-block").click();
                            break;

                            case 'database':
                                if(node.data.type != currentPage) {
                                    $('#page-loading').css('display', 'block');
                                }
                                $( "#click-database" ).click();
                            break;
                            case 'accessories':
                                if(node.isActive()!=true){
                                    $('#page-loading').css('display', 'block');
                                }
                            break;
                            case 'lasers':
                                if(node.isActive()!=true){
                                    $('#page-loading').css('display', 'block');
                                }
                            break;
                            case 'material':
                                if(node.isActive()!=true){
                                    $('#page-loading').css('display', 'block');
                                }
                            break;
                            case 'platform':
                                if(node.isActive()!=true){
                                   $('#page-loading').css('display', 'block');
                                }
                            break;
                            case 'product':
                                if(node.isActive()!=true){
                                   $('#page-loading').css('display', 'block');
                                }
                            break;
                        }


                    }
                }
            }
        });

        /* Call function to expanded root node when root node has child */
        that.expandedRootNode();
    }

    /* Function expand all child nodes of node selected */
    this.expandAllChildNodes = function (nodeActivated) {
        if (nodeActivated.data.parent_id != '0') { // If node Active is not root node
            nodeActivated.setExpanded(true);
            nodeActivated.visit(function(node){
                node.setExpanded(true);
            });
        }
    }

    /* Function cosllapse all child of node not active don't root node */
    this.cosllapseAllNodeNotActive = function () {

    }

    /* Function to show hide child page all nested content */
    this.showFirstLevelOfChildPages = function (childNodesOfActiveNode) {
        if (childNodesOfActiveNode == null || childNodesOfActiveNode[0].title == 'Loading...') {
            childNodesOfActiveNode = [];
        } else {
            angular.forEach(childNodesOfActiveNode, function(value, key) {
                if (!value.isFolder()) {
                    contents.push(value);
                }
            });
        }
    }

    /* Function to show hide child page all nested content */
    this.showAllLevelOfChildPages = function (childNodesOfActiveNode) {
        if (childNodesOfActiveNode == null || childNodesOfActiveNode[0].title == 'Loading...') {
            childNodesOfActiveNode = []; // Set new array for contain child nodes of node active
        } else {
            angular.forEach(childNodesOfActiveNode, function (value, key) {
                if (value.hasChildren()) {
                    that.showAllLevelOfChildPages(value.children);
                } else if (!value.isFolder()) {
                    contents.push(value);
                }
            })
        }
    }

    /* Function set expanded root node */
    this.expandedRootNode = function () {

        /* Declare fancytree */
        var tree = $('#tree').fancytree('getTree');

        var temp = tree.getRootNode().children;

        for (var i in temp) {
            if(temp[i].data.type == currentPage){
                var rootFirst = i;
            }
        };

        /* Get root node and set active root node */
        var rootNode = tree.getRootNode().children[rootFirst];

        /* If early root node then set active for root node */
        if (angular.isDefined(rootNode)) {
            rootNode.setActive();
        }

        /* If root node have children then set expaned */
        if (rootNode.hasChildren()) {
            rootNode.setExpanded();
        }
    }

    /* Set value for idOfNodeActivated */
    this.setActiveNode = function (nodeId) {
        idOfNodeActivated = nodeId;
    }

    /* Set content */
    this.setContents = function(data, curPage) {
        currentPage = curPage;
        contents = data;
        return contents;
    }

    /* Get content */
    this.getContents = function() {
        return contents;
    }

}]);
