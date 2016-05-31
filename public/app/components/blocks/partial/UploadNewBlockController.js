var blockApp =  angular.module('BlockApp');

blockApp.controller('ModalUploadNewBlockCtrl', ['$window','$scope', '$modal', '$timeout', 'Upload', '$filter', '$sce', '$cookieStore', 'BlockManagerService', '$controller',
    function ($window,$scope, $modal, $timeout, Upload, $filter, $sce, $cookieStore, BlockManagerService, $controller) {
    /* Code Mirror editor */
    $scope.block = {};
    $timeout(function () {

        $scope.mixedMode = {
            name: "htmlmixed",
            scriptTypes: [
                {
                    matches: /\/x-handlebars-template|\/x-mustache/i,
                    mode: null
                },
                {
                    matches: /(text|application)\/(x-)?vb(a|script)/i,
                    mode: "vbscript"
                }
            ]
        };
        $scope.breadCrumbNewBlock =function() {
             window.location.href = window.baseUrl + '/cms/block-manager';
        }
        $scope.editableCodeMirror = CodeMirror.fromTextArea(document.getElementById('editor'), {
            lineNumbers: true,
            mode: "application/x-httpd-php",
            keyMap: "sublime",
            autoCloseBrackets: true,
            matchBrackets: true,
            showCursorWhenSelecting: true,
            lineWrapping:true,
            theme: "monokai",
            tabSize: 2,
            indentUnit: 4,
            indentWithTabs: true,
            onChange: function() {
            }
        });
        $scope.editableCodeMirror.setValue("");

        $scope.editableCodeMirror.on("change", function() {

            var curContent = $scope.editableCodeMirror.getValue();

            if (curContent == '<div></div>' || curContent == '' || curContent == '<br>' || curContent == '<div><strong></strong></div>'|| curContent == '<div><em></em><strong></strong></div>'|| curContent == '<div><em><del></del></em></div>') {
                $scope.$apply(function() {
                    $scope.requiredEditorContent = true;
                });
            } else {
                $scope.$apply(function() {
                    $scope.requiredEditorContent = false;
                });
            }

        });

    }, 700);


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

    $scope.setDIVHeight = function() {
        var theDivCode =  $('.assets .fix-tab #code');
        var theDivReview =  $('.assets .fix-tab #review');

        var Divtop = $('.assets .fix-tab').offset();

        var divTop = Divtop.top;

        // var winHeight = $(window).height();

        var winHeight = screen.height;

        var divHeight = winHeight - divTop - 315;

        theDivCode.attr('style', 'height: ' + divHeight + 'px!important;overflow:auto'  );
        theDivReview.attr('style', 'height: ' + divHeight + 'px!important;overflow:auto'  );
    }

    $controller('ConfigController', {
        $scope: $scope
    });

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
        }, 700);
    }

    /**/
    $controller('ConfigController', {
        $scope: $scope
    });

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

    /**
     * callModalInsert      [function]
     * show model           [description]
     *
     * @auth   tuan@httsolution.com, bang@httsolution.com
     * @param  [typeInsert]    [type: block, asset, link,..]
     * @param  [language]
     * @param  [region]
     *
     * add data to content of block when insert completed
     */
    $scope.callModalInsert = function (typeInsert, language, region, notShowFieldBlock) {
        /* Call Modal Popup To Insert With Input Type */
        var teamplate = '/cms/block-manager/insert' + '?language=' + language + '&&region=' + region + '&&type=' + typeInsert + '&&notShowFieldBlock=' + notShowFieldBlock + '&&id=';
        var modalInstance = $modal.open({
                templateUrl: window.baseUrl + teamplate,
                controller: 'ModalInsertCms',
                size: undefined,
                resolve: {
                    blockId: function() {
                    },
                    language: function() {
                        return null;
                    },
                    region: function() {
                        return null;
                    },
                    listField: function() {
                    }
                }
            });
        modalInstance.result.then(function (data) {

            $timeout(function() {

                $scope.editableCodeMirror.replaceSelection(data);

            });
        });
    }

    CodeMirror.markClean = function() {
        alert("Content Changed");
    };


    /* When user click delete thumbnail */
    $scope.removeThumbnail = function() {

        if (!confirm('Do you want delete this image?')) return;

        delete $scope.block.thumbnail;
    }

    /**
     *  @auth  quang@httsolution.com, bang@httsolution.com
     *
     *  save content block            [description]
     *  submit                        [function]
     *
     * check validate form, return when form is invalid
     * check contetn block, return when content is null
     *
     * parse content of block,if block's content fill format type blade
     * if contest of block fill field(fields), show modal config field
     *
     * save content block after config fields and redirect to home page
     */
    $scope.submit = function (validate) {

        $scope.submitted  = true;

        if(validate){
            $('#mytab a[href="#detail"]').tab('show');
            $(".ng-invalid:eq(1)").focus();
            return true;
        }
        if (typeof $scope.block.folder=='undefined') {
            $('#mytab a[href="#detail"]').tab('show');
            $(".ng-invalid:eq(1)").focus();
            $scope.saving = false;
            return true;
        }
        if ($scope.requiredContent || $scope.checkUpload || $scope.requiredEditorContent) {
            $('#mytab a[href="#content"]').tab('show');
            $scope.requiredEditorContent = true;
            $scope.saving = false;
            return true;
        }

        var curContent = $scope.editableCodeMirror.getValue();

        if (curContent == '') {
            $scope.requiredEditorContent = true;
            // Show tab textarea content
            $('#mytab a[href="#content"]').tab('show');
            // Refresh tab code mirror
            $timeout(function(){
                $scope.editableCodeMirror.refresh();
            }, 200);
            $scope.saving = false;
            return true;
        }

        $scope.showLoad  = true;

        $scope.block.content = curContent;

        if ($scope.block.type == 'blade') {

            BlockManagerService.parseContentBlock({content: curContent, type:'block'}).then(function(result) {

                $scope.block.injects = result['blocks'];
                $scope.block.links = result['links'];
                $scope.block.assets = result['assets'];

                if (result.status && angular.isDefined(result.fields) && result.fields.length > 0) {
                    /*config field*/
                    $scope.configFields(function(valueResult) {

                        if (angular.isDefined(valueResult)) {
                            $scope.block.fields = valueResult;
                            addNewBlock($scope.block);
                        }

                        $scope.saving = false;

                    }, result.fields);

                } else {
                    addNewBlock($scope.block);
                }
            })
        } else {
            addNewBlock($scope.block);
        }

    };

    //save data
    function addNewBlock(data) {
        angular.element('#page-loading').css('display','block');
        delete $scope.errors;
        BlockManagerService.addNew(data).then(function(data) {
            if (data.status == 0) {
                $scope.saving = false;
                $('#btnSubmit').removeAttr('disabled');

                if (data['errors']) {
                    $scope.errors = data['errors'];
                }

                $scope.checkName=true;
                $(".name").focus();
                angular.element('#page-loading').css('display','none');
            } else {
                if (angular.isDefined($scope.block.thumbnail)) {
                    var modal = 'propose_new';
                    for (var i = 0; i < $scope.block.thumbnail.length; i++) {
                        var file = $scope.block.thumbnail[i];
                        Upload.upload({
                            url: window.baseUrl + '/api/block-manager/change-thumbnail',
                            fields: {
                                modal: modal,
                                data : data
                            },
                            file: file
                        }).progress(function (evt) {

                        }).success(function (data, status, headers, config) {
                            if (!data['status']) {
                                return;
                            } else {
                                //redirect to home page
                                window.location.href = window.baseUrl + '/cms/block-manager/set-block-selected/' + window.selectedItemId;
                            }
                        });
                    }
                } else {
                    //redirect to home page
                    window.location.href = window.baseUrl + '/cms/block-manager/set-block-selected/' + window.selectedItemId;
                }
            }

        });
    }

    $scope.cancel = function () {

        window.location.href = window.baseUrl + '/cms/block-manager';

    };
}])
