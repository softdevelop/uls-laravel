var helpEditorApp = angular.module('HelpEditorApp');

helpEditorApp.controller('HelpEditorController', ['$scope', '$modal', 'ngTableParams','$timeout','HelpEditorService', '$filter', function ($scope, $modal, ngTableParams, $timeout, HelpEditorService,$filter){
    $scope.helpEditors = angular.copy(window.folders);
    $scope.rootHelps = angular.copy($scope.helpEditors);

    angular.forEach($scope.helpEditors, function(value, key) {
        value.children.sort(function(a, b) {
            return (a.sort_number - b.sort_number);
        }); 
    });

    $scope.currentIdNodeAcive = 0;

    /**
     * Init tree folder
     * @author Thanh Tuan <tuan@httsolution.com>
     * @return {Void} 
     */
    $scope.initTree = function(){
        // When user click in other folder root diffirent current folder root then set status is false
        $('#tree').fancytree({
            extensions: ["glyph", "dnd"],
            source: $scope.helpEditors,
            autoScroll: true,
            dnd: {
                autoExpandMS: 400,
                focusOnClick: true,
                preventVoidMoves: true,      // Prevent dropping nodes 'before self', etc.
                preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
                /**
                 * This function MUST be defined to enable dragging for the tree.
                 * Return false to cancel dragging of node.
                 */
                dragStart: function(node, data) {
                    // Prevent dropping parent nodes
                    if (node.isFolder() || node.data.parent_id == '0') return false;
                    return true;
                },
                dragEnter: function(node, data) {
                    // Prevent dropping node to other parent node
                    if(node.parent !== data.otherNode.parent){
                        return false;
                    }
                    return true;
                },
                /**
                 * This function MUST be defined to enable dropping of items on the tree.
                 */
                dragDrop: function(node, data) {

                    if (data.hitMode == 'over') return;

                    $('#page-loading').css('display','block');
                    
                    data.otherNode.moveTo(node, data.hitMode);

                    var parentNode = $scope.tree.getNodeByKey(data.node.data.parent_id);

                    $scope.data = [];
                    angular.forEach(parentNode.children, function(value, key) {
                        $scope.data.push(value.data);
                    })

                    // Call function update help
                    HelpEditorService.updateSortNumber($scope.data).then(function(result){
                        if(result.status) {
                            $('#page-loading').css('display','none');
                        } 
                    });
                }
            },
            beforeActivate: function(event,data) {
                if($scope.saved == false) {
                    if($scope.activeNode.data.parent_id == '0') {
                        var message = 'You have not saved the changes to the current page';
                    } else {
                        var message = 'You have not saved the changes to the current topic';                        
                    }
                    alert(message);
                    return false;
                }                
            },
            activate: function (event, data){

                $scope.success = false;                 // Hide note
                $scope.saved = true;                    // Status indicates that user has saved
                data.node.setExpanded(true);            // Set expanded for node activated

                // Get current key of node active
                if (typeof data != 'undefined' && typeof data.node != 'undefined' && typeof data.node.key != 'undefined'
                    && typeof data.node.data != 'undefined' &&  data.node.data['parent_id'] == '0') {
                    $scope.currentIdNodeAcive = data.node.key;
                }

                $scope.isShowPage = false;              // Status indicates should show name page to edit
                $scope.isShowTopic = false;             // Status indicates should show name topic and page type to edit
                $scope.isChangeParent = false;          // Status indicates the page type is changed

                $scope.helpEditor = data.node.data;     // Set data of current node activated for $scope.helpEditor
                $scope.activeNode = data.node;          // Set scope activeNode

                // If node has node then not show editor
                if (angular.isDefined($scope.activeNode)) {
                    $scope.showEditor = true;
                }

                // Set data of node activated for editor
                $timeout(function(){
                    $('#description').redactor('code.set', data.node.data.description);
                    $('#description').val(data.node.data.description);
                });
            },
            click: function (event, data){
                if(!data.node.folder){ 
                    data.node.toggleExpanded();
                }
            }
        });
        
        $scope.tree = $("#tree").fancytree("getTree"); // Init $scope tree

        // Active first node of tree
        nodeFirst = $scope.tree.getFirstChild();
        if (angular.isDefined(nodeFirst)) {
            nodeFirst.setActive();
        }
    }

    /**
     * When user change page type
     * @return {Void}
     */
    $scope.changePageType = function () {
        $scope.isChangeParent = true;
        $scope.setIsNotSaved();
    }

    /**
     * When user click button edit help
     * @author Thanh Tuan <tuan@httsolution.com>
     * @return {Void} 
     */
    $scope.updateHelp = function () {
        $('#page-loading').css('display', 'block');
        // Set data to update
        $scope.helpEditor.description = $('#description').redactor('code.get');
        $scope.helpEditor.title = $scope.helpEditor.name;

        // Old parent node of node activated
        $scope.oldParentNode = $scope.activeNode.getParent();

        // Call function update help
        HelpEditorService.updateHelpEditor($scope.helpEditor).then(function(data){
            if(data.status) {
                $scope.rootHelps = data.rootHelps;                      // Set new page type for select
                $scope.saved = true;                                    // Status indicates has saved data
                $scope.activeNode.setTitle($scope.helpEditor.title);    // Set new title for node edited

                if ($scope.isChangeParent) {
                    var newParent = $scope.tree.getNodeByKey(String($scope.helpEditor.parent_id));
                    $scope.activeNode.moveTo(newParent);
                    newParent.setActive();
                    newParent.folder = true;
                    newParent.render();
                    $scope.setOldParentIsFolder();
                }

                // Message says for user data is saved success
                $scope.success = true;
                $timeout(function(){
                    $scope.success = false;
                }, 3000);
                window.folders = data.folders;
            } else {

                // Message says for user data is saved error
                $scope.errorMessage = data.errors.title[0];
                $timeout(function(){
                    $scope.errorMessage = false;
                }, 3000);
            }

            $('#page-loading').css('display', 'none');

        }).then(function() {
            $('#page-loading').css('display', 'none');
        });
    }

    $scope.setOldParentIsFolder = function() {
        if($scope.oldParentNode.children == null) {
            $scope.oldParentNode.folder = false;
            $scope.oldParentNode.render();
        }
    }

    /**
     * When user click button edit details
     * @author Thanh Tuan <tuan@httsolution.com>
     * @return {Void} 
     */
    $scope.editDetail = function() {
        // If node is root node
        if ($scope.activeNode.data.parent_id == "0") {
            $scope.isShowPage = true;
        } else { // If node is not root node
            $scope.isShowTopic = true;
        }
    }

    $scope.createHelpEditor = function(validate) {

        $scope.submitted = true;
        $scope.saving = true;
        $scope.error = false;
        $scope.errors = [];

        $content = $('#description').redactor('code.get');

        $scope.isRequiredRedactor = false;

        if($content == '' || $content == '<div></div>' || $content == '<br>') {
            $scope.isRequiredRedactor = true;
        }

        if(validate || $scope.isRequiredRedactor) {
            $scope.saving = false;
            return;
        }

        $scope.helpEditor.description = $content;

        if(angular.isUndefined($scope.helpEditor.parent_id)) {
            $scope.helpEditor.parent_id = '0';
        }

        HelpEditorService.createHelpEditor($scope.helpEditor).then(function(data){
            if(data.status) {
                window.location = window.baseUrl + '/admin/help-editor';
            } else {
                $scope.error = true;
                $scope.saving = false;
                $scope.errors = data.errors;
            }
        });
    }
    
    $scope.initRedactor = function(element){
        $('#description').redactor({
            imageUpload: window.baseUrl+'/file-redactor/upload-file-redactor',
            plugins: ['table', window.isAdvancedEditingFeatures == true ? 'source' : '', 'linkPageTopic'],
            callbacks: {
                modalOpened: function(name, modal) {
                    if(name == 'link' && !this.observe.isCurrent('a')) {
                        $('#redactor-link-blank').attr("checked","true");
                        $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                    } else if(name == 'link') {
                        var rel = this.link.$node.attr('rel');
                        if(typeof rel == 'undefined') {
                            $('<label><input type="checkbox" id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                        } else {
                            $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());                   
                        }
                    }
                },
                insertedLink: function(element) {
                    var href = $(element).attr('href');
                    if($('#redactor-link-no-follow').prop('checked')) {
                        element.attr('rel', 'nofollow');
                    } else {
                        element.removeAttr('rel');
                    }
                },
                linkify: function(elements) {
                    elements.attr("target","_blank");
                },
                change: function() {
                    $scope.setIsNotSaved();
                    $content = $('#' + element).redactor('code.get');
                    $scope.$apply(function(){
                        if($content == '<div></div>' || $content == ''|| $content == '<br>') {
                            $scope.saved = true;
                            $scope.isRequiredRedactor = false;
                        } else {
                            $scope.isRequiredRedactor = true;
                        }
                    });
                }
            },
            linkSize: 1000,
            minHeight: 300
        });
        
        $timeout(function(){
            if(typeof $scope.helpEditor != 'undefined' && angular.isDefined($scope.helpEditor._id)) {
                $('#description').redactor('code.set',$scope.helpEditor.description);
            }            
        });
    }

    $scope.createNewHelp = function() {
        var tree = $('#tree').fancytree('getTree');
        var nodeActivated = tree.getActiveNode();
        var idOfNodeActivated = '0';
        if (nodeActivated != null) {
            idOfNodeActivated = nodeActivated.data._id;
            window.location.href = window.baseUrl + '/admin/help-editor/create' + '?selectedItemId=' + idOfNodeActivated + '&&v=' + new Date().getTime();
        } else {
            window.location.href = window.baseUrl + '/admin/help-editor/create';
        }
    }
    
    /**
     * [deleteHelpEditor description]
     * delete a page or topic
     *
     * @author [someone, Kim Bang] [someone@httsolution.com, bang@httsolution.com]
     * @return {[type]} [description]
     */
    $scope.deleteHelpEditor = function() {

        //show note when delete page or topic
        if (typeof $scope.activeNode != 'undefined' && typeof $scope.activeNode.data != 'undefined'
            && typeof $scope.activeNode.data.parent_id != 'undefined' && $scope.activeNode.data.parent_id != '0') {

            var conf = confirm("The topic will be deleted, and we will lose all data in the topic.");
        } else {
            var conf = confirm("The page will be deleted, and they will lose all data in the page.");            
        }


        if(!conf) {
            return;
        }

        $('#page-loading').css('display','block');

        HelpEditorService.deleteHelpEditor($scope.activeNode.data._id).then(function(data){
            $scope.error = false;
            if(data.status) {
                $scope.saved = true;
                var tree = $('#tree').fancytree('getTree');
                var node = tree.getNodeByKey(String($scope.activeNode.data._id));

                //active parent of node delete
                var parentNode = node.getParent();

                //node delete
                node.remove();

                if ($scope.activeNode.data.parent_id == '0') {
                    var rootNode = tree.getRootNode();
                    parentNode = rootNode.getFirstChild();
                }
                

                // If parentNode not has children
                if(!parentNode.hasChildren()) {
                    parentNode.folder = false;
                }

                parentNode.setActive(event, parentNode);
                parentNode.render();

            } else {
                $scope.error = true;
            }
            $('#page-loading').css('display','none');
        }).then(function() {
            $('#page-loading').css('display','none');
        });
    }

    /**
     * [showModelHelpEditor description]
     * show model create new help editor topic
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @return {[type]} [description]
     */
    $scope.showModelCreateTopic = function() {

        if($scope.saved == false) {
            if($scope.activeNode.data.parent_id == '0') {
                var message = 'You have not saved the changes to the current page';
            } else {
                var message = 'You have not saved the changes to the current topic';                        
            }
            alert(message);
            return false;
        }

        $scope.saved = true;


        getListHelpEditorWithParentIdZero(function(result) {
            if (result.length || Object.keys(result).length) {
                var teamplate = '/admin/help-editor/get-model-create-topic?v=' + new Date().getTime();
                var modalInstance = $modal.open({
                        templateUrl: window.baseUrl + teamplate,
                        controller: 'ModelCreateTopic',
                        size: undefined,
                        resolve: {
                            listItemHelpEditor: function() {
                                return result;
                            },
                            parentId: function() {
                                return $scope.currentIdNodeAcive;
                            }
                        }
                    });
                modalInstance.result.then(function (data) {
                    window.folders = data.folders;
                    var result = data.result;
                    result['key'] = result._id;
                    result['name'] = result.title;
                    var tree = $('#tree').fancytree('getTree');
                    var currentNode = tree.getNodeByKey(result.parent_id);
                    currentNode.folder = true;
                    var nodeActive = currentNode.addNode(result);
                    currentNode.render();
                    nodeActive.setActive();

                });                
            }
        })
    }

    /**
     * [getListHelpEditorWithParentIdZero description]
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @return {[type]} [description]
     */
    function getListHelpEditorWithParentIdZero(callback) {
        HelpEditorService.getListHelpEditorWithParentIdZero().then(function(result) {
            callback.call(true, result['data']);
        })
    }

    /**
     * add page modal
     *
     * @author Quang <quang@httsolution.com>
     * 
     */
    $scope.addPage = function() {

        if($scope.saved == false) {
            if($scope.activeNode.data.parent_id == '0') {
                var message = 'You have not saved the changes to the current page';
            } else {
                var message = 'You have not saved the changes to the current topic';                        
            }
            alert(message);
            return false;
        }

        $scope.saved = true;

        var teamplate = '/admin/help-editor/add-page';
        var modalInstance = $modal.open({
            animation: true,
            templateUrl: window.baseUrl + teamplate,
            controller: 'AddPageController',
            size: null,
            resolve: {
            }
            
        });
        modalInstance.result.then(function (data) {
            data.children = [];
            window.folders.push(data);
            data.name = data.title;
            data.key = data._id;
            var tree = $('#tree').fancytree('getTree');
            var rootNode = tree.getRootNode();
            nodeAdd = rootNode.addChildren(data);
            nodeAdd.setActive();

            $scope.rootHelps.push(data);
        }, function () {
        });
    }

    $scope.setIsNotSaved = function () {
        $scope.saved = false;
    }
}]);
helpEditorApp.controller('AddPageController', ['$scope','$modalInstance','HelpEditorService', function ($scope,$modalInstance,HelpEditorService) {
    
    /**
     * add page
     *
     * @author Quang <quang@httsolution.com>
     * 
     * @param validate
     */
    $scope.addPage = function(validate) {
        $scope.submitted = true;

        if(validate) {
            return;
        }

        $scope.saving = true;

        HelpEditorService.addPage($scope.help).then(function(data){
            if(data.status == -1) {
                $scope.error = true;
                $scope.saving = false;
                $scope.errors = data.errors;
            } else if(data.status) {
                $modalInstance.close(data.help);
            } else {
                $scope.error = true;
                $scope.saving = false;
                $scope.errors = data.errors;
            }
        });
    }

    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    }
}]);
