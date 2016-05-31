var TemplateContentManagerModule = angular.module('TemplateContentManager', ['toggle-switch']);

TemplateContentManagerModule.controller('TemplateContentManagerCtr', ['$scope', '$modal', '$filter', '$timeout', 'ngTableParams', 'TemplateContentManagerService', 'CmsContentFolderService', '$templateCache', 'CmsService', function ($scope, $modal, $filter, $timeout, ngTableParams, TemplateContentManagerService, CmsContentFolderService, $templateCache, CmsService) {
    
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
    $templateCache.remove('cms/template-content-manager/template');

    $scope.baseUrl = window.baseUrl;

    /* Set value for item want active */
    $scope.pageSelected = window.idOfTemplateSelected;

    // Tags content tree
    $scope.tagsContent = angular.copy(window.tagsContent);

    // All tag content
    $scope.allTags = angular.copy(window.allTags);

    /* Set new value for CmsServiceContent*/
    $scope.templates = CmsContentFolderService.setContents(angular.copy(window.folders),window.currentPage);

    /* Text in button show or hide all nested content */
    $scope.contentHideOrShowAllNestedContent = 'Show All Nested Content';

    /* If undefined templates then set emtype array */
    if (angular.isUndefined($scope.templates)) {
        $scope.templates = [];
    }

    $scope.tableParams = new ngTableParams({
        page: 1, // show first page
        count: 100, // count per page
        sorting: {
            'id': 'desc' // initial sorting
        },
        filter: {
            // title:''
        }
    }, {
        total: $scope.templates.length, // length of data
        getData: function($defer, params) {
            var orderedData = params.sorting() ? $filter('orderBy')($scope.templates, params.orderBy()) : $scope.templates;
            orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
            params.total(orderedData.length);
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });

    if($scope.pageSelected != 0) {
        CmsContentFolderService.setActiveNode($scope.pageSelected);
    }

    /* Call function in service to show tree folder of block */
    CmsContentFolderService.initTree(function(valueResult, nodeActive) {
        $scope.templates = [];
        /* If node activated is root node then set title is root */
        if (nodeActive.key == 'Templates') {
            $scope.titleItemSelected = 'Templates';
        } else if (nodeActive.folder == true) { /* If node activated is not root node but is folder */
            $scope.titleItemSelected = nodeActive.title;
        } else { /* If node active is not folder then set parent name of active node for title */
            if (angular.isUndefined (nodeActive.parent.data.name)) {
                $scope.titleItemSelected = 'Templates';
            } else {
                $scope.titleItemSelected = nodeActive.parent.data.name;
            }
        }
        
        //When user click only one node
        if (angular.isDefined(valueResult) && valueResult.length == 1 && nodeActive.folder != true) {
            valueResult[0].expanded = true;
            $scope.templates = valueResult;
        } else {
            angular.forEach(valueResult, function(value, key) {
                value.expanded = false;
                $scope.templates.push(value);
            })
        }

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
    // open search
    $scope.btnSearch = function () {
        $scope.isSearch = !$scope.isSearch;
    }
    /* Function hide or show all nested content */
    $scope.hideOrShowAllNestedContent = function() {
        CmsContentFolderService.changeStatusHideOrShowAllNestedContent().then(function(dataResult) {
            $scope.contentHideOrShowAllNestedContent = dataResult.textButton;
            if ($scope.contentHideOrShowAllNestedContent == 'Show All Nested Content') {
                $scope.isShowNested = true; // Show icon eye
            }else {
                $scope.isShowNested = false; // Show icon flash eye
            }
            $scope.templates = dataResult.contents;
            $scope.tableParams.reload();
        })
    }

    /**
     * Delete folder template
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    $scope.deleteFolderAndTemplate = function () {
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
                TemplateContentManagerService.deleteFolderAndTemplate(activeNode.data._id).then(function (data) {
                    // Remove active node
                    activeNode.remove();
                    // Get root node of node activated and set active
                    rootNodeOfNodeActive = _.find(rootNode.children, function(obj) { return obj.title == 'Templates' });
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
     * Delete file of template
     *
     * @author Thanh Tuan <tuan@httsolution.com
     *
     * @param  {String} fileId Id of file
     *
     * @param  {Object} template      Page
     *
     * @return {Void}
     */
    $scope.deleteFileTemplate = function (fileId, template) {
        // Call function to delete file
        TemplateContentManagerService.deleteTemplateFile(fileId).then(function (data) {
            // If delete successfull
            if (data.status != 0) {
                if(!angular.isUndefined(data.result)){
                    template.region = data.result.countUniqueRegion;
                    template.language = data.result.countUniqueLanguage;
                    template.status = data.result.status;
                }
                // Each template file
                angular.forEach(template.subFiles, function (value, key) {
                    // Delete cotent deleted in template file array
                    if (value._id == fileId) {
                        template.subFiles.splice(key, 1);
                        //template = changeStatusTotalTemplate(template);
                    }
                })

                $scope.tableParams.reload();
            }
        })
    };

    /**
     * change status of template total 
     *
     * @author Quang<quang@httsolution.com>
     * 
     * @param  object template template
     * @return object template
     */
    function changeStatusTotalTemplate(template) {
        $listStatus = [];

        //get list status template
        for(i in template.contents) {
            $listStatus.push(template.contents[i].status);
        }

        //check and set statys for template
        if ($listStatus.indexOf('waiting-approve') > -1) {

            template.status = 'waiting-approve';

        } else {

            template.status = 'uptodate';
        }
        //return template
        return template;
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

        var teamplate = '/cms/template-content-manager/edit-name-folder/'+ activeNode.data._id + '?v=' + new Date().getTime();

        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + teamplate,
            controller: 'editNameFolderTemplateCtrl',
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

    $scope.showGroup = function($event, subFile) {

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

        $('.wrap-ac-group').each(function(index) {
            $(this).removeClass('ac-up');
        });


        $($event.target).parent().toggleClass("ac-up");
        if ($('.group-btn-ac').hasClass('fix-missing-li')) {
            $('.group-btn-ac').css({
                top: $event.pageY - 65 + 'px',
                right: w - $event.pageX - 30 + 'px',
            });
        }        
        else {
            $('.group-btn-ac').css({
                top: $event.pageY - 200 + 'px',
                right: w - $event.pageX - 30 + 'px',
            });
        }
        $(document).on('click', function closeMenu(e) {
            $(e.target).closest('tr').siblings().find('.wrap-ac-group').removeClass('ac-up');
            if ($('.wrap-ac-group').has(e.target).length === 0) {

                $('.wrap-ac-group').removeClass('ac-up');
                $('.wrap-ac-group').removeClass('show-top');

            } else {
                $(document).one('click', closeMenu);
            }
        });

        angular.element('.table-responsive').addClass('fix-height');
    }

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
    }

    var opened = false;
    $scope.getModalCreateTemplateContentManager = function(id) {
        if (opened) return;
        $scope.getParentFolder();

        var templateUrl = '/cms/template-content-manager/new' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();

        if (typeof id != 'undefined') {

            var templateUrl = '/cms/template-content-manager/update-template/' + id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();

        }

        var modalInstance = $modal.open({
            templateUrl: templateUrl,
            controller: 'ModalCreateUseCreateTemplateContentManager',
            size: undefined,
            resolve: {
                listCheckBox: function() {
                    return $scope.listCheckBox;
                },

                maxUpload: function() {
                    return window.maxUpload;
                },

                listIdCheck: function() {
                    return $scope.listIdCheck;
                }
            }
        });
        opened = true;
        modalInstance.result.then(function(data) {
            opened = false;
            data.title = data.name;
            data.key = data._id;
            node = $('#tree').fancytree('getTree').getNodeByKey(String(data.folder_id));
            if (node != null) {
                node.addChildren(data);
                node.setActive(false);
                node.setActive();
                // Sort all child of root node
                node.sortChildren(null, true);
            }

        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });

    }

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
        TemplateContentManagerService.addTagsForPage(pageId, {tags:$scope.tagId}).then(function (data){
            for (var key in $scope.templates) {
                if ($scope.templates[key].data._id == data.item._id) {
                    $scope.templates[key].data.tags = data.item.tags;
                    break;
                }
            }
            $('#page-loading').css('display', 'none');
            $scope.tableParams.reload();
        });
    };

    $scope.getModalRequestProposeNewTemplate = function() {
        if (opened) return;

        $scope.getParentFolder();

        var template = '/cms/template-content-manager/request-propose-new-template' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();

        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + template,
            controller: 'ModalRequestProposeNewTemplate',
            size: undefined,
            resolve: {

            }
        });
        opened = true;
        modalInstance.result.then(function(data) {
            opened = false;

            data.title = data.name;
            data.key = data._id;
            node = $('#tree').fancytree('getTree').getNodeByKey(data.folder_id);
            if (node != null) {
                node.addChildren(data);
                node.setActive(false);
                node.setActive();
                // Sort all child of root node
                node.sortChildren(null, true);
            }

        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });

    }
    $scope.createFolderTemplate = function() {
        if (opened) return;
        $scope.getParentFolder();
        var teamplate = '/cms/template-content-manager/create-folder' + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + teamplate,
            controller: 'ModalCreateFolderTemplateCtrl',
            size: undefined,
            resolve: {}
        });
        opened = true;
        modalInstance.result.then(function(data) {
            opened = false;
            var tree = $('#tree').fancytree('getTree');
            if (data.parent_id == '0') {
                var nodeparent = tree.getNodeByKey('0');
            } else {
                var nodeparent = tree.getNodeByKey(data.parent_id);
            }
            var child = nodeparent.addChildren(data);
            child.setExpanded();
            // Sort all child of root node
            nodeparent.sortChildren(null, true);
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }
    $scope.viewThumbnail = function(imgPath) {
        var teamplate = window.baseUrl + '/app/components/template-content-manager/modal/viewImage.html' + '?v='+new Date().getTime();
        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: teamplate,
            controller: 'viewThumbnail',
            size: null,
            resolve: {
                path: function() {
                    return window.baseUrl + '/admin/file/' + imgPath;
                },
            }

        });

    }
    $scope.getModalRequestTranslationTemplate = function(id, subFiles) {
        var subFile= [];
        if (opened) return;
        $scope.getParentFolder();
        angular.forEach(subFiles, function(value, key) {
            if(value.language =='en'&& value.region == null){
                subFile = value;
            }

        })
        var template = '/cms/template-content-manager/request-translation/' + id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + template,
            controller: 'ModalRequesTemplatetController',
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
        opened = true;
        modalInstance.result.then(function(data) {
            opened = false;
            for (i in data.templates) {

                node = $('#tree').fancytree('getTree').getNodeByKey(data.templates[i].base_id);

                node.data.subFiles.push(data.templates[i]);

                if (node.data.language == 'n/a') {
                    node.data.language = 1;
                } else {
                    node.data.language = parseInt(node.data.language) + 1;
                }

                if (node.data.due_date == 'n/a' || typeof(node.data.due_date) == 'undefined') {

                    node.data.due_date = data.templates[i].due_date;

                } else if (node.data.due_date > data.templates[i].due_date) {

                    node.data.due_date = data.templates[i].due_date;
                }

                node.data.status = 'waiting-approve';

                $scope.tableParams.reload();
            }
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }

    /* poup modal Request Translation*/
    $scope.getModalRequestRegionTemplate = function(id, subFile) {
        if (opened) return;
        $scope.getParentFolder();
        var template = '/cms/template-content-manager/request-region/' + id + '?selectedItemId=' + $scope.selectedItemId + '&&selectedItemName=' + $scope.selectedItemName + '&&v='+new Date().getTime();
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + template,
            controller: 'ModalRequesTemplatetController',
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
        opened = true;
        modalInstance.result.then(function(data) {
            opened = false;
            for (i in data.templates) {
                node = $('#tree').fancytree('getTree').getNodeByKey(data.templates[i].base_id);
                node.data.region = data.countUniqueRegion;

                node.data.subFiles.push(data.templates[i]);

                if (node.data.due_date == 'n/a' || typeof(node.data.due_date) == 'undefined') {

                    node.data.due_date = data.templates[i].due_date;

                } else if (node.data.due_date > data.templates[i].due_date) {

                    node.data.due_date = data.templates[i].due_date;
                }

                node.data.status = 'waiting-approve';

                $scope.tableParams.reload();
            }
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }
}])
.controller('ModalCreateFolderTemplateCtrl', ['$scope', '$modalInstance', 'TemplateContentManagerService', function($scope, $modalInstance, TemplateContentManagerService) {
    $scope.changeName = function() {
        $scope.nameExists = false;
    }
    $scope.submit = function(validate) {
        $scope.submitted = true;
        $scope.nameExists = false;
        if (validate) {
            return;
        }
        angular.element('#page-loading').css('display','block');
        TemplateContentManagerService.createFolderProvider($scope.folder).then(function(data) {
            angular.element('#page-loading').css('display','none');
            if (data.status == 0) {
                $scope.nameExists = true;
                return;
            } else {
                $scope.nameExists = false;
                $modalInstance.close(data.item);
            }
        });
    };

    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');

    };
}])
.controller('ModalRequesTemplatetController', ['$scope', '$modal', '$filter', '$modalInstance', 'folder_id', 'TemplateContentManagerService', 'subFile','$timeout', function($scope, $modal, $filter, $modalInstance, folder_id, TemplateContentManagerService, subFile,$timeout) {
    $scope.languages_selected = {};
    $scope.requiredLanguage = true;
    $scope.requiredRegion = true;
    $scope.regions_selected = {};
    
    $timeout(function(){
        $scope.template = window.template;
        $scope.folders = window.folders;

    },500);
    // if (typeof $scope.template == 'undefined') {
    //     $scope.template = {};
    //     $scope.template.folder_id = folder_id == 'root' ? '' : folder_id;
    // }

    // setup variable for date picker
    $scope.format = 'MM-dd-yyyy';
    $scope.minDate = new Date();
    /* Open calendar when create page*/
    $scope.open = function($event, type) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened = {};
        $scope.opened[type] = true;
    };

    // Init redactor
    $scope.initRedactor = function() {
        $('#content').redactor({
            plugins: ['table', window.isAdvancedEditingFeatures == true ? 'source' : ''],
            imageUpload: '/content/upload',
            // buttonsHide: ['link','insertpage'],
            callbacks: {
                modalOpened: function(name, modal) {
                    if (name == 'link' && !this.observe.isCurrent('a')) {
                        $('#redactor-link-blank').attr("checked", "true");
                        $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                    } else if (name == 'link') {
                        var rel = this.link.$node.attr('rel');
                        if (typeof rel == 'undefined') {
                            $('<label><input type="checkbox" id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                        } else {
                            $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                        }
                    }
                },
                insertedLink: function(element) {
                    var href = $(element).attr('href');
                    if (href.substring(0, 4) != 'http' && href.substring(0, 5) != 'https' && href.substring(0, 3) != 'ftp') {
                        $(element).attr('href', 'http://' + href);
                    }
                    if ($('#redactor-link-no-follow').prop('checked')) {
                        element.attr('rel', 'nofollow');
                    } else {
                        element.removeAttr('rel');
                    }
                },
                linkify: function(elements) {
                    elements.attr("target", "_blank");
                },
                change: function() {
                    /* Get content in redactor when change event */
                    $content = $('#content').redactor('code.get');
                    $scope.$apply(function() {
                        /* If content is not null then not show error required content */
                        // $checkEmpty = $('#content').redactor('utils.isEmpty',$('#content').redactor('core.editor')[0].innerHTML);
                        if ($content == '<div></div>' || $content == '' || $content == '<br>' || $content == '<div><strong></strong></div>' || $content == '<div><em></em><strong></strong></div>' || $content == '<div><em><del></del></em></div>') {
                            $scope.requiredDescription = true;
                        } else { /* Show error required content */
                            $scope.requiredDescription = false;
                        }
                    });
                }
            },
            linkSize: 1000,
            minHeight: 200 // pixels
        });
    }

    //Click button submit
    $scope.submit = function(validate) {
        $scope.requiredDescription = false;
        $scope.submitted = true;
        $content = $('#content').redactor('code.get');

        if ($content == '<div></div>' || $content == '' || $content == '<br>' || $content == '<div><strong></strong></div>' || $content == '<div><em></em><strong></strong></div>' || $content == '<div><em><del></del></em></div>') {
            $scope.requiredDescription = true;
        }

        if (validate || $scope.requiredDescription) {
            $(".ng-invalid:eq(1)").focus();
            return;
        }

        if ($scope.template.modal == 'request_translation' && $scope.requiredLanguage) {
            $(".ng-invalid:eq(1)").focus();
            return;
        }
        if ($scope.template.modal == 'request_region' && $scope.requiredRegion) {
            $(".ng-invalid:eq(1)").focus();
            return;
        }
        if ($scope.template.parent_id) {
            $(".ng-intemplatevalid:eq(0)").focus();
            return;
        }


        files_id = [];

        if (typeof $scope.filesUpload !== 'undefined') {
            files_id = $scope.filesUpload['ids'];
        }
        $scope.template.files_id = files_id;

        $('#btnSubmit').attr('disabled', 'true');
        $scope.template.description = $content;
        $scope.template.meta = $content;

        if ($scope.template._id && $scope.template.modal == 'request_translation') {
            $scope.template.languages = $scope.languages_selected;
        }

        if ($scope.template._id && $scope.template.modal == 'request_region') {
            $scope.template.regions = $scope.regions_selected;
        }
        $scope.template.status = 'waiting-approve';
        $scope.template.copyTemplate = subFile._id;
        angular.element('#page-loading').css('display','block');
        TemplateContentManagerService.requestTemplate($scope.template).then(function(data) {
            angular.element('#page-loading').css('display','none');
            if (data.status == 0) {
                $('#btnSubmit').removeAttr('disabled');
                $scope.checkName = true;
                $(".name").focus();
            } else {
                $modalInstance.close(data);
            }
        });

    }

    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
    }

}])
.controller('ModalCreateUseCreateTemplateContentManager', ['$scope', '$modalInstance', '$controller', 'Upload', 'TemplateContentManagerService', 'listCheckBox', 'maxUpload', 'listIdCheck',
    function($scope, $modalInstance, $controller, Upload, TemplateContentManagerService, listCheckBox, maxUpload, listIdCheck) {

        $scope.template = {};

        $scope.listCheckBox = listCheckBox;

        $scope.listIdCheck = listIdCheck;

        $scope.stepFirst = true;

        $scope.sectionLengh = 0;

        $scope.stepSection = 0;

        $scope.template.sections = [];

        $scope.submittedSection = [];

        $scope.listMapType = window.listMapType;

        $scope.extError = false;
        $scope.uploadFileTemplate = function(files) {
            $scope.extError = false;
            if (files && files.length) {
                console.log(files,'s');
                var nameSplit = files[0]['name'].split(".");
                var extend = nameSplit.pop();
                var extArrayUpload = ['txt','php','html'];
                var checkExtUpload = extArrayUpload.indexOf(extend);

                if(checkExtUpload == -1) {
                    $scope.extError = true;
                    return;
                }

                if (files[0]['size'] > maxUpload['size']) {

                    $scope.error = 'Max file size is ' + maxUpload['name'];

                    return;
                }

                $scope.wating = 'uploading file';

                Upload.upload({
                    url: baseUrl + '/cms/template-content-manager/parsing-file',
                    file: files,
                }).progress(function(evt) {

                    $scope.isErrorUploadFile = true;

                }).success(function(data, status, headers, config) {

                    $scope.wating = files[0].name;

                    $scope.isErrorUploadFile = false;

                    $scope.error = '';

                    $scope.result = data;

                    console.log($scope.result);

                }).error(function(data) {

                    $scope.template.reciept_file_name = '';

                    $scope.error = data.message;

                    $scope.isErrorUploadFile = true;

                });
            }

        }

        $scope.uploadThumbnail = function(files) {
            if (files && files.length) {

                if (files[0]['size'] > maxUpload['size']) {

                    $scope.errorThumbnail = 'Max file size is ' + maxUpload['name'];

                    return;
                }
                $scope.reciept_file_name = 'uploading file';

                Upload.upload({
                    url: baseUrl + '/admin/file',
                    method: 'POST',
                    file: files,
                    fields: {
                        'store': 'template-content-manager'
                    }
                }).progress(function(evt) {

                    $scope.isErrorUploadFile = true;

                }).success(function(data, status, headers, config) {

                    $scope.isErrorUploadFile = false;

                    $scope.template.thumbnail = data.item.id;

                    $scope.reciept_file_name = files[0]['name'];

                    $scope.errorThumbnail = '';

                }).error(function(data) {

                    $scope.template.reciept_file_name = '';

                    $scope.errorThumbnail = data.message;

                    $scope.isErrorUploadFile = true;

                });
            }

        }

        $scope.loadingFile = [];

        $scope.errorThumbnailSection = [];
        // function upload thumbnail step section
        $scope.uploadThumbnailSection = function(files, step) {

            if (files && files.length) {

                if (files[0]['size'] > maxUpload['size']) {

                    $scope.errorThumbnailSection[step] = 'Max file size is ' + maxUpload['name'];

                    return;
                }
                $scope.loadingFile[step] = 'uploading file';

                Upload.upload({
                    url: baseUrl + '/admin/file',
                    method: 'POST',
                    file: files,
                    fields: {
                        'store': 'template-content-manager'
                    }
                }).progress(function(evt) {

                    $scope.isErrorUploadFile = true;

                }).success(function(data, status, headers, config) {

                    $scope.isErrorUploadFile = false;

                    $scope.template.sections[step].thumbnail = data.item.id;

                    $scope.loadingFile[step] = files[0]['name'];

                    $scope.errorThumbnailSection[step] = '';

                }).error(function(data) {

                    $scope.loadingFile[step] = '';

                    $scope.errorThumbnailSection[step] = data.message;

                });
            }
        }

        $scope.eventNextStepSecond = function(validate) {

            $scope.submitStepSecond = true;

            if (validate || !$scope.result || $scope.result['status'] == 0 || ($scope.result.fields.length == 0 && $scope.result.sections.length == 0) || !$scope.template.folder_id)

                return;

            if ($scope.result.sections.length == 0) {

                $scope.stepFirst = false;

                $scope.eventNextStepThird();

            } else {

                $scope.stepFirst = false;

                $scope.stepSecond = true;

                $scope.sectionLenght = $scope.result.sections.length;
            }
        }
        /* next step section*/
        $scope.eventNextStepSection = function(validate) {

            $scope.submittedSection[$scope.stepSection] = true;
            // check validate and section exits thumbnail
            if (validate || !$scope.template.sections[$scope.stepSection].thumbnail)

                return;
            // check section is location last sections
            if ($scope.stepSection < ($scope.sectionLenght - 1)) {

                $scope.stepSection++;

            } else {

                $scope.eventNextStepThird();
            }

        }
        /* prev step section*/
        $scope.prevStepSection = function() {
            if ($scope.stepSection > 0) {

                $scope.stepSection--; // prev section befor

            } else {

                $scope.prevStepFirst(); // prev step upload file template
            }
        }

        /*
         * load step update field infomation
         * start config fields
         */

        $scope.eventNextStepThird = function() {

            angular.element('#model-template-content').hide();

            $scope.configFields(function(valueResult) {
                if (angular.isUndefined(valueResult)) {
                    $modalInstance.dismiss('cancel');
                } else {
                    $scope.template.fields = valueResult;
                    $scope.createTemplateContentManager(2);
                }
            }, $scope.result.fields);

        }

        /*hide error check max field, min field*/
        $scope.hiddenE = function() {
            $scope.errorMax = '';
        }

        /*prev step*/
        $scope.prevStepFileld = function(curStep) {
            $scope.curStepField = curStep - 1;
        }

        /*move to form update section infomation*/
        $scope.eventPrevStepSecond = function() {

            if ($scope.result.sections.length == 0) {

                $scope.stepFirst = true;

                $scope.stepThird = false;

            } else {

                $scope.stepSecond = true;

                $scope.stepThird = false;

            }
        }


        $scope.prevStepFirst = function() {
            $scope.stepFirst = true;

            $scope.stepSecond = false;
        }

        /*
         * create template
         */
        $scope.createTemplateContentManager = function(isField, validate) {

            $scope.submitStepSecond = false;

            // if(isField == 1){
            //     $scope.submitStepSecond = true;
            // }else{
            //     $scope.submitted = true;
            // }

            if (validate || !$scope.template.folder_id) {
                $scope.submitStepSecond = true;
                return;
            }

            // $scope.template['content'] = $scope.result['content'];


            // $scope.template['extends'] = $scope.result['extends'];

            // $scope.template['blocks'] = $scope.result['blocks'];
            angular.element('#page-loading').css('display','block');
            TemplateContentManagerService.create($scope.template).then(function(data) {
                angular.element('#page-loading').css('display','none');
                if (data['status']) {

                    $modalInstance.close(data.template);

                }
            })
        }

        $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
        };

        /*
         * remove max field and min field value, when iterable value is false
         */
        $scope.checkIterable = function(isChange, curStep) {
            if (!isChange) {
                delete $scope.template.fields[curStep].min_field;
                delete $scope.template.fields[curStep].max_field;
            }
        }

    }
])
.controller('ModalRequestProposeNewTemplate', ['$scope', '$modalInstance', '$timeout', 'Upload', '$filter', 'TemplateContentManagerService',
    function($scope, $modalInstance, $timeout, Upload, $filter, TemplateContentManagerService) {
        $scope.template = {};
        // setup variable for date picker
        $scope.format = 'MM-dd-yyyy';
        $scope.minDate = new Date();
        /* Open calendar when create page*/
        $scope.open = function($event, type) {
            $event.preventDefault();
            $event.stopPropagation();
            $scope.opened = {};
            $scope.opened[type] = true;
        };
        // Init redactor
        $scope.initRedactor = function() {
            // alert('ss');
            $('#content').redactor({
                plugins: ['table', window.isAdvancedEditingFeatures == true ? 'source' : ''],
                imageUpload: '/content/upload',
                // buttonsHide: ['link','insertpage'],
                callbacks: {
                    modalOpened: function(name, modal) {
                        if (name == 'link' && !this.observe.isCurrent('a')) {
                            $('#redactor-link-blank').attr("checked", "true");
                            $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                        } else if (name == 'link') {
                            var rel = this.link.$node.attr('rel');
                            if (typeof rel == 'undefined') {
                                $('<label><input type="checkbox" id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                            } else {
                                $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                            }
                        }
                    },
                    insertedLink: function(element) {
                        var href = $(element).attr('href');
                        if (href.substring(0, 4) != 'http' && href.substring(0, 5) != 'https' && href.substring(0, 3) != 'ftp') {
                            $(element).attr('href', 'http://' + href);
                        }
                        if ($('#redactor-link-no-follow').prop('checked')) {
                            element.attr('rel', 'nofollow');
                        } else {
                            element.removeAttr('rel');
                        }
                    },
                    linkify: function(elements) {
                        elements.attr("target", "_blank");
                    },
                    change: function() {
                        /* Get content in redactor when change event */
                        $content = $('#content').redactor('code.get');
                        $scope.$apply(function() {
                            /* If content is not null then not show error required content */
                            // $checkEmpty = $('#content').redactor('utils.isEmpty',$('#content').redactor('core.editor')[0].innerHTML);
                            if ($content == '<div></div>' || $content == '' || $content == '<br>' || $content == '<div><strong></strong></div>' || $content == '<div><em></em><strong></strong></div>' || $content == '<div><em><del></del></em></div>') {
                                $scope.requiredDescription = true;
                            } else { /* Show error required content */
                                $scope.requiredDescription = false;
                            }
                        });
                    }
                },
                linkSize: 1000,
                minHeight: 200 // pixels
            });

        }

        //Click button submit
        $scope.submitRequest = function(validate) {
            $scope.requiredDescription = false;

            $scope.submitted = true;

            $content = $('#content').redactor('code.get');

            if ($content == '<div></div>' || $content == '' || $content == '<br>' || $content == '<div><strong></strong></div>' || $content == '<div><em></em><strong></strong></div>' || $content == '<div><em><del></del></em></div>') {
                $scope.requiredDescription = true;
            }
            if (validate || $scope.requiredDescription) {

                $(".ng-invalid:eq(1)").focus();
                return;
            }
            if (typeof $scope.template.folder_id=='undefined'){
                return;
            }

            files_id = [];

            if (typeof $scope.filesUpload !== 'undefined') {

                files_id = $scope.filesUpload['ids'];
            }
            $scope.template.files_id = files_id;

            $('#btnSubmit').attr('disabled', 'true');
            $scope.template.description = $content;

            $scope.template.status = 'waiting-approve';
            angular.element('#page-loading').css('display','block');
            TemplateContentManagerService.requestProposeNewTemplate($scope.template).then(function(data) {
                angular.element('#page-loading').css('display','none');
                if (data.status == 0) {

                    $('#btnSubmit').removeAttr('disabled');

                    $scope.checkName = true;

                    $(".name").focus();

                } else {
                    $modalInstance.close(data.template);
                }
            });

        }

        $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
        };

    }
])
.controller('viewThumbnail', ['$scope', '$modalInstance', 'path', function($scope, $modalInstance, path) {

    $scope.path = path;

    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
    };

}])
.controller('editNameFolderTemplateCtrl', ['$scope', '$modalInstance', 'TemplateContentManagerService','$http','$q', function ($scope, $modalInstance, TemplateContentManagerService, $http, $q) {

    $scope.checkFirstName = function(data) {
        if (data == '') {
          return "The first name is a required field";
        }
    };

    $scope.checkEmtypeName = function (data) {
        //If folder name is null
        if (data == '') {
            return "The folder name is a required field";
        } else {
            $scope.folder.name = data;
            var d = $q.defer();
            $http.post('/api/template-content-manager/edit-name-folder', {data: $scope.folder}).success(function(res) {
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
            // TemplateContentManagerService.editNameFolder($scope.folder).then(function (data){
            //     if(data.status != 0) {
            //         $modalInstance.close(data);
            //     }
            // })
        }
    }
}]);
