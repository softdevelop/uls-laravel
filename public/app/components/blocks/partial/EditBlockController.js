var blockApp =  angular.module('BlockApp');

blockApp.controller('EditBlockCtrl', ['$scope', '$modal', '$timeout', 'Upload', '$filter', 'ngTableParams', 'BlockManagerService', 'CmsService', '$controller',
    function ($scope, $modal, $timeout, Upload, $filter, ngTableParams, BlockManagerService, CmsService, $controller) {

    /* Code Mirror editor */
    $scope.blockContent = angular.copy(window.blockContent);
    $scope.baseUrl = window.baseUrl;
    $scope.usages = window.usages;
    // If block has content then set active for tab content
    if ($scope.blockContent.content != null) {
        $('#mytab a[href="#content1"]').tab('show'); // Select content tab
    }
    
    /**
     * set height Editor full screen
     *
     * @author Cong Hoan <hoan@httsolution.com>
     *
     * @return Void
    */
    
    $timeout(function(){
        $(document).ready(function (){
            $scope.setDIVHeight();
        });

        $(window).resize(function (){
            $scope.setDIVHeight();
        });

    })
    $scope.loadDataUsage = function() {
        $scope.tableParams = new ngTableParams({
            page: 1,
            count: 50,
            sorting: {
                'name': 'desc'
            },
        }, {
            total: $scope.usages.length,
            getData: function($defer, params) {
                var orderedData = params.sorting() ? $filter('orderBy')($scope.usages, params.orderBy()) : $scope.usages;
                orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
                params.total(orderedData.length);
                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            }
        });
    }

    $scope.loadDataUsage();
    $scope.clickable = function($event, contentId, type, block_type) {

        switch(type) {
            case 'template':
                window.open(baseUrl + "/cms/template-content-manager/update-template/" + contentId,'_blank');
                //window.location = baseUrl + "/cms/template-content-manager/update-template/" + contentId;
                break;
            case 'page':
                window.open(baseUrl + "/cms/pages/edit-page/" + contentId,'_blank');
                //window.location = baseUrl + "/cms/pages/edit-page/" + contentId;
                break;
            case 'block':
                // if(block_type)
                window.open(baseUrl + "/cms/block-manager/edit-block/" + contentId,'_blank');
                //window.location = baseUrl + "/cms/block-manager/edit-block/" + contentId;
            default:
        }
    }
    $scope.setDIVHeight = function() {
        var theDivCode =  $('.assets .fix-tab #code');
        var theDivReview =  $('.assets .fix-tab #review');
        
        var Divtop = $('.assets .fix-tab').offset();

        var divTop = Divtop.top;
        console.log(divTop);

        // var winHeight = $(window).height();
        var winHeight = screen.height;

        var divHeight = winHeight - divTop - 315;

        theDivCode.attr('style', 'height: ' + divHeight + 'px!important;overflow:auto'  );
        theDivReview.attr('style', 'height: ' + divHeight + 'px!important;overflow:auto'  );
    }

    $controller('ConfigController', {
        $scope: $scope
    });

    CmsService.setFieldsContent(window.blockContent['fields']);
    /* Code Mirror editor */
    $timeout(function () {
        $scope.editableCodeMirror = CodeMirror.fromTextArea(document.getElementById('editor'), {
            mode:  "htmlmixed",
            theme: "night",
            styleActiveLine: true,
            lineNumbers: true,
            onChange: function(){
            },
        });
        if($scope.blockContent.content == null){

            $scope.blockContent.content = '';
        }
        $scope.editableCodeMirror.setValue($scope.blockContent.content);

        $scope.editableCodeMirror.on("change", function() {

            var curContent = $scope.editableCodeMirror.getValue();

            if(curContent == '<div></div>' || curContent == '' || curContent == '<br>' || curContent == '<div><strong></strong></div>'|| curContent == '<div><em></em><strong></strong></div>'|| curContent == '<div><em><del></del></em></div>'){
                $scope.$apply(function(){
                    $scope.requiredEditorContent = true;
                });
            } else {
                $scope.$apply(function(){
                    $scope.requiredEditorContent = false;
                });
            }

        });

    }, 700);

    /**
     * Show value content in description
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void [description]
     */
    $scope.showValueContent = function () {
        $timeout(function(){
            $scope.editableCodeMirror.refresh();
            // $scope.editableCodeMirror.setSize(1048, 800);
        }, 200);
    }

    // $scope.initRedactor = function() {
    //     $('#content').redactor({
    //         plugins: ['table',window.isAdvancedEditingFeatures == true ? 'source' : ''],
    //         imageUpload: '/content/upload',
    //         // buttonsHide: ['link','insertpage'],
    //         callbacks: {
    //             modalOpened: function(name, modal) {
    //                 if(name == 'link' && !this.observe.isCurrent('a')) {
    //                     $('#redactor-link-blank').attr("checked","true");
    //                     $('<label><input type="chddfeckbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
    //                 } else if(name == 'link') {
    //                     var rel = this.link.$node.attr('rel');
    //                     if(typeof rel == 'undefined') {
    //                       $('<label><input type="checkbox" id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
    //                     } else {
    //                       $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
    //                     }
    //                 }
    //             },
    //             insertedLink: function(element) {
    //                 var href = $(element).attr('href');
    //                 if(href.substring(0, 4) != 'http' && href.substring(0,5) != 'https' && href.substring(0,3) != 'ftp') {
    //                   $(element).attr('href','http://' + href);
    //                 }
    //                 if($('#redactor-link-no-follow').prop('checked')) {
    //                   element.attr('rel', 'nofollow');
    //                 } else {
    //                   element.removeAttr('rel');
    //                 }
    //             },
    //             linkify: function(elements) {
    //               elements.attr("target","_blank");
    //             },
    //             change: function() {
    //                 /* Get content in redactor when change event */
    //                 $content = $('#content').redactor('code.get');
    //                 $scope.$apply(function(){
    //                     /* If content is not null then not show error required content */
    //                     // $checkEmpty = $('#content').redactor('utils.isEmpty',$('#content').redactor('core.editor')[0].innerHTML);
    //                     if($content == '<div></div>' || $content == ''|| $content == '<br>' || $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>') {
    //                         $scope.requiredDescription = true;
    //                     } else {/* Show error required content */
    //                         $scope.requiredDescription = false;
    //                     }
    //                 });
    //             }
    //         },
    //         linkSize: 1000,
    //         minHeight: 200 // pixels
    //     });
    //     $('#content').val($scope.blockContent.description);
    //     $('#content').redactor('code.set',$scope.blockContent.description);
    // }
    // setup variable for date picker
    $scope.format = 'MM-dd-yyyy';
    $scope.minDate = new Date();
    $scope.submitted  = false;
    $scope.showField  = false;
    $scope.showLoad  = false;
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
    /* When user click insert link */
    $scope.callModalInsert = function (typeInsert, language, region, notShowFieldBlock,id) {
              console.log(id);
        /* Call Modal Popup To Insert With Input Type */
        var teamplate = '/cms/block-manager/insert' + '?language=' + language + '&&region=' + region + '&&type=' + typeInsert + '&&notShowFieldBlock=' + notShowFieldBlock + '&&id=' +id;
        var modalInstance = $modal.open({
                templateUrl: window.baseUrl + teamplate,
                controller: 'ModalInsertCms',
                size: undefined,
                resolve: {
                    blockId: function() {
                    },
                    language: function() {
                        return language;
                    },
                    region: function() {
                        return region;
                    },
                    listField: function() {
                    }
                }
            });
        modalInstance.result.then(function (data) {
            $timeout(function(){
                $scope.editableCodeMirror.replaceSelection(data);

            });
        });
    }

    CodeMirror.markClean = function(){
        alert("Content Changed");
    };

    // when load page create block then show default code
    $scope.isShowCode = true;
    /**
     * show code in content
     * @return {[type]} [description]
     */
    $scope.showCodeBlock = function()
    {
        $scope.isShowCode = true;

        $scope.isShowReView = false;
    }
    /**
     * review block
     * @return {[type]} [description]
     */
    $scope.reViewBlock = function()
    {

        angular.element('#page-loading').css('display','block');

        var type;

        if(typeof $scope.blockContent.type == 'undefined')
        {
            type = 'html';

        }else{

            type = $scope.blockContent.type;
        }

        data = {'content': JSON.stringify($scope.editableCodeMirror.getValue()), 'type' : type, 'language' : $scope.blockContent.language, region : $scope.blockContent.region};

        BlockManagerService.reviewContentBlock(data).then(function(data){

            if(data.status){
                $scope.refreshIframe();

                // $timeout(function(){

                //     $scope.isShowCode = false;

                //     $scope.isShowReView = true;

                //     // $scope.refreshIframe();

                //     angular.element('#page-loading').css('display','none');
                // }, 500);
            }
        });

    }

    $scope.iframeLoaded = function () {
        $scope.isShowCode = false;
        $scope.isShowReView = true;
        // angular.element('#page-loading').css('display','none');
    }

    $scope.refreshIframe = function () {

        BlockManagerService.getContentForIframe().then(function(data){
            $scope.iframeLoaded();
            $('#frameBlock').contents().find('body').html(data.content);
            angular.element('#page-loading').css('display','none');
        });

        // window.frames[0].location = baseUrl + "/cms/block-manager/review-content-block";

    }
    /* When user click delete thumbnail */
    $scope.removeThumbnail = function(index) {

        if (!confirm('Do you want delete this image?')) return;

        $scope.blockContent.thumbnail = null;
    }

    $scope.removeAddThumbnail = function(index) {

        if (!confirm('Do you want delete this image?')) return;

        delete $scope.blockContent.addThumbnail;
    }

    $scope.parseBlockontent = function(validate) {

        CmsService.setFieldsOld(); // set default field old

        $scope.errorContentTemplate = ''; // set default error content template

        $scope.blockContent.content = $scope.editableCodeMirror.getValue();

        // $scope.requiredDescription = false;

        $scope.requiredEditorContent = false;

        $scope.submitted  = true;

        var curContent = $scope.editableCodeMirror.getValue();

        var curContent = $scope.editableCodeMirror.getValue();
         if(validate) {
            $(".ng-invalid:eq(1)").focus();
            $('#mytab a[href="#detail"]').tab('show');
            return;
        }
        if(curContent == '<div></div>' || curContent == '' || curContent == '<br>' || curContent == '<div><strong></strong></div>'|| curContent == '<div><em></em><strong></strong></div>'|| curContent == '<div><em><del></del></em></div>'){

            $scope.requiredEditorContent = true;

            // Show tab textarea content
            $('#mytab a[href="#content1"]').tab('show');
            // Refresh tab code mirror
            $timeout(function(){
                $scope.editableCodeMirror.refresh();
            }, 200);
            $scope.saving = false;
            return;
        }

        // $content = $('#content').redactor('code.get');

        // if($content == '<div></div>' || $content == '' || $content == '<br>' || $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>'){
        //     $scope.requiredDescription = true;
        // }

        if($scope.requiredEditorContent){
            $('#mytab a[href="#content1"]').tab('show');
            return;
        }
        // $scope.blockContent.description = $content;
        // call function parse content config template
        BlockManagerService.parseContentConfigBlock({content: $scope.blockContent.content, type:'block'}).then(function(data){
            $scope.blockContent.injects = data['blocks'];
            $scope.blockContent.links = data['links'];
            $scope.blockContent.assets = data['assets'];
            // $scope.blockContent.database = data['database'];
            if(data['status']){
                // get field new template
                var fieldsNew = CmsService.getFieldsNew(data['fields']);
                // check exits sectionsnew
                if(fieldsNew.length > 0){
                    // if fields new has exits when config step fields new
                    // call function config fields
                    $scope.configFields(function(valueResultFields) {
                        // check value result field not is undefined
                        if(typeof valueResultFields != 'undefined'){
                            // map data field
                            dataFields = CmsService.mapDataFields(valueResultFields);
                            // call function edit field config
                            $scope.getModalShowListConfigFields(function(valueResultDataFields) {
                                //
                                if(typeof valueResultDataFields != 'undefined'){

                                    $scope.blockContent.fields = dataFields;

                                    updateBlockContent($scope.blockContent);
                                }

                            }, dataFields);
                        }


                    }, fieldsNew);

                }else{

                    dataFields = CmsService.mapDataFields([]);

                    if(dataFields.length > 0){

                        $scope.getModalShowListConfigFields(function(valueResultDataFields) {

                            if(typeof valueResultDataFields != 'undefined'){

                                $scope.blockContent.fields = dataFields;

                                updateBlockContent($scope.blockContent);
                            }

                        }, dataFields);

                    }else{
                        $scope.blockContent.fields = dataFields;
                        updateBlockContent($scope.blockContent);

                    }
                }

            }else{

                $scope.errorContentTemplate = data['message'];
            }

        });

    }

    var updateBlockContent = function() {
        angular.element('#page-loading').css('display','block');
        $scope.saving = true;
        delete $scope.errors;
        BlockManagerService.editBlock($scope.blockContent).then(function(data){
            if(data['status']){
                if(angular.isDefined($scope.blockContent.addThumbnail)) {
                    var modal = 'propose_new';
                    for (var i = 0; i < $scope.blockContent.addThumbnail.length; i++) {
                        var file = $scope.blockContent.addThumbnail[i];
                        Upload.upload({
                            url: window.baseUrl + '/api/block-manager/update-thumbnail',
                            fields: {
                                modal: modal,
                                data : data
                            },
                            file: file
                        }).progress(function (evt) {

                        }).success(function (data, status, headers, config) {
                            if(!data['status']) {
                                $scope.saving = false;
                                return;
                            } else {
                                window.location = window.baseUrl + '/cms/block-manager/set-block-selected/' + $scope.blockContent.folder_id;
                            }
                        });
                    }
                } else {
                    window.location = window.baseUrl + '/cms/block-manager/set-block-selected/' + $scope.blockContent.folder_id;
                }
            } else {
                $scope.saving = false;

                if (data['errors']) {
                    $scope.errors = data['errors'];
                }
                angular.element('#page-loading').css('display','none');
            }
        })
    }

    $scope.cancel = function () {

        window.location.href = window.baseUrl + '/cms/block-manager';

    };


}])
