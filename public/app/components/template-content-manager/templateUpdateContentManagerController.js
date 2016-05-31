var TemplateContentManagerModule = angular.module('TemplateContentManager');

TemplateContentManagerModule.controller('TemplateUpdateContentManagerCtr', ['$scope', '$modal', '$filter', '$controller', 'ngTableParams', '$timeout', 'Upload', 'TemplateContentManagerService', 'BlockManagerService', 'CmsService',
function($scope, $modal, $filter, $controller, ngTableParams, $timeout, Upload, TemplateContentManagerService, BlockManagerService, CmsService) {
    // use controller config
    $controller('ConfigController', {
        $scope: $scope
    });

    angular.element('.wrap-content-management').removeClass('hidden');

    $scope.templateContent = angular.copy(window.templateContent);

    var oldNameTemplate = $scope.templateContent.name;

    $scope.usages = window.usages;
    console.log('usages', $scope.usages);
    CmsService.setFieldsContent(window.templateContent['fields']); // set fields content template

    CmsService.setSectionsContent(window.templateContent['sections']); // set sections content template
    /**
     * [loadDataUsage description]
     * @return {[type]} [description]
     */
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
            onChange: function(){
            }
        });
        // check undefined content template
        if(typeof $scope.templateContent.content == 'undefined'){
            // set value code mirror
            $scope.editableCodeMirror.setValue('');

        }else{
            // set value content template to code mirror
            $scope.editableCodeMirror.setValue($scope.templateContent.content);
            // If template has content then set active for tab content
            $('#mytab a[href="#content"]').tab('show'); // Select content tab
            $scope.showValueContent();
        }


        $scope.editableCodeMirror.on("change", function() {

            hideValidateContent();

            var curContent = $scope.editableCodeMirror.getValue();
        });

    }, 100);

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

    $scope.clickable = function($event, contentId, type) {

        switch(type) {
            case 'template':
                window.open(baseUrl + "/cms/template-content-manager/update-template/" + contentId,'_blank');
                //window.location = baseUrl + "/cms/template-content-manager/update-template/" + contentId;
                break;
            case 'page':
                window.open(baseUrl + "/cms/pages/edit-page/" + contentId,'_blank');
                //window.location = baseUrl + "/cms/pages/edit-page/" + contentId;
                break;
            default:
        }
    }
    $scope.setDIVHeight = function() {
        var theDiv =  $('.assets .fix-tab #code');
        var Divtop = $('.assets .fix-tab').offset();

        var divTop = Divtop.top;
        console.log(divTop);

        // var winHeight = $(window).height();
        var winHeight = screen.height;

        var divHeight = winHeight - divTop - 273;

        theDiv.attr('style', 'height: ' + divHeight + 'px!important;overflow:auto'  );
    }
    /**
     * Show value detail in template
     *
     * @author minh than <than@httsolution.com>
     *
     * @return Void [description]
     */
    $scope.showDetail = function () {
        $scope.isShowUsage = false;
    }
    /**
     * Show value content in description
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void [description]
     */
    $scope.showValueContent = function () {
        $scope.isShowUsage = false;
        $timeout(function(){
            $scope.editableCodeMirror.refresh();
            // $scope.editableCodeMirror.setSize(1048, 800);
        }, 200);
    }
    /**
     * Show value usage in template
     *
     * @author minh than <than@httsolution.com>
     *
     * @return Void [description]
     */
    $scope.showUsage = function () {
        $scope.isShowUsage = true;
    }
    var hideValidateContent = function() {

        $scope.errorContentTemplate = '';
    }
    
    $scope.extError = false;

    /**
     * function upload file template
     *
     * @author  minh than
     * @param  {[file]} files [file upload]
     * @return {[type]}       [description]
     */
    $scope.uploadFileTemplate = function(files) {
        $scope.extError = false;
        $scope.errorContentTemplate = '';
        // if exits file upload
        if (files && files.length) {
            var nameSplit = files[0]['name'].split(".");
            var extend = nameSplit.pop();
            var extArrayUpload = ['txt','php','html'];
            var checkExtUpload = extArrayUpload.indexOf(extend);

            if(checkExtUpload == -1) {
                $scope.extError = true;
                return;
            }

            // check max file size serve
            if (files[0]['size'] > maxUpload['size']) {

                $scope.errorUploadFile = 'Max file size is ' + maxUpload['name']; // notification error upload file

                return;
            }

            $scope.wating = 'uploading file';
            // upload file to server
            Upload.upload({
                url: baseUrl + '/cms/template-content-manager/parsing-file',
                file: files,
            }).progress(function(evt) {

                $scope.isErrorUploadFile = true;

            }).success(function(data, status, headers, config) { // upload file success

                $scope.wating = files[0].name;

                $scope.isErrorUploadFile = false;

                $scope.errorUploadFile = '';

                $scope.result = data; // set result

                $scope.editableCodeMirror.setValue(data.content); //set contnet CodeMirror when upload file

            }).error(function(data) { // upload file faild

                $scope.errorUploadFile = data.message;

                $scope.wating = 'upload file error';

                $scope.isErrorUploadFile = true;

            });
        }

    }
    /**
     * parse content template
     *
     * @author minh than <than@httsolution.com>
     *
     * @param  {[type]} validate [validate form]
     * @return {[type]}          [description]
     */
    $scope.parseTemplateContent = function(validate) {
        // validate form
        if(validate) {
            //if form error then return
            $(".ng-invalid:eq(1)").focus();
            $('#mytab a[href="#detail"]').tab('show');
            return;
        }
        if (oldNameTemplate != $scope.templateContent.name) {
            var alert = confirm('Do you want to change template name?');
            if (!alert) {
                return;
            }
        }

        CmsService.setFieldsOld(); // set default field old

        CmsService.setSectionsOld(); // set default sctions old

        $scope.errorContentTemplate = ''; // set default error content template
        $scope.requiredEditorContent = ''; // set default error content template

        $scope.submitted = true; // user submit button
        // get content template
        $scope.templateContent.content = $scope.editableCodeMirror.getValue();

        if(!$scope.templateContent.content){
        console.log($scope.templateContent.content);

            $scope.errorContentTemplate = 'content is required field'; // notification error content template empty
            $scope.requiredEditorContent = 'content is required field'; // notification error content template empty
        }

        if(!$scope.templateContent.content) {
            //if form error then return
               $('#mytab a[href="#content"]').tab('show');
            return;
        }
        angular.element('#page-loading').css('display','block');
        // call function parse content config template
        TemplateContentManagerService.parseContentConfigTemplate({content: $scope.templateContent.content, type:'template'}).then(function(data){
            angular.element('#page-loading').css('display','none');
            if(data['status']){

                $scope.templateContent.blocks = data['blocks'];
                // $scope.templateContent.databases = data['database'];

                $scope.templateContent.extends = data['extends'];
                $scope.templateContent.links = data['links'];
                $scope.templateContent.assets = data['assets'];
                // get field new template
                var fieldsNew = CmsService.getFieldsNew(data['fields']);

                if(typeof $scope.templateContent.fields == 'undefined' && fieldsNew.length == 0) {
                    updateTemplateContent();
                }else{
                    // get sections new template
                    var sectionsNew = CmsService.getSectionsNew(data['sections']);
                    // check exits sectionsnew
                    if(sectionsNew.length > 0){

                        $scope.configSection(function(valueResultSections){
                            // if fields new has exits when config step fields new
                            if(fieldsNew.length > 0){
                                // if user config over section
                                if(typeof valueResultSections != 'undefined'){
                                    // call function config fields
                                    $scope.configFields(function(valueResultFields) {

                                        if (angular.isDefined(valueResultFields)) {

                                            dataFields = CmsService.mapDataFields(valueResultFields);
                                            // call function edit field config
                                            $scope.templateContent.sections = CmsService.mapDataSections(valueResultSections);
                                            // get modal show list field to config and edit
                                            $scope.getModalShowListConfigFields(function(valueResultConfigFields) {
                                                // check user is update field
                                                if(typeof valueResultConfigFields != 'undefined'){
                                                    // get field template when update field
                                                    $scope.templateContent.fields = valueResultConfigFields;
                                                    // call function update template
                                                    updateTemplateContent();
                                                }


                                            }, dataFields);
                                        }

                                    }, fieldsNew);
                                }

                            }else{
                                // if user config over section
                                if(typeof valueResultSections != 'undefined'){
                                    // call function get data old and field new
                                    dataFields = CmsService.mapDataFields([]);
                                    // call function edit field config
                                    $scope.templateContent.sections = CmsService.mapDataSections(valueResultSections);
                                    
                                    if (data.fields && !data.fields.length) {
                                        $scope.templateContent.fields = {};
                                        updateTemplateContent();
                                    } else {
                                        // $scope.getModalConfigTemplate(dataFields, dataSections);
                                        $scope.getModalShowListConfigFields(function(valueResultConfigFields) {
                                            // check user is update field
                                            if(typeof valueResultConfigFields != 'undefined'){
                                                // get field template when update field
                                                $scope.templateContent.fields = valueResultConfigFields;

                                                updateTemplateContent();   // call function update template
                                            }

                                        }, dataFields);
                                    }
                                }
                            }

                        }, sectionsNew)

                    }
                    else if(fieldsNew.length > 0){ // if user add field new
                        // if fields new has exits when config step fields new
                        // call function config fields
                        $scope.configFields(function(valueResultFields) {
                            // check user is update field
                            if(typeof valueResultFields != 'undefined'){
                                // call function get data old and field new
                                dataFields = CmsService.mapDataFields(valueResultFields);

                                $scope.templateContent.sections = CmsService.mapDataSections([]);
                                // call function edit field config
                                $scope.getModalShowListConfigFields(function(valueResultConfigFields) {

                                    if(typeof valueResultConfigFields != 'undefined'){
                                        // get field template when update
                                        $scope.templateContent.fields = valueResultConfigFields;
                                        // calll function update template content
                                        updateTemplateContent(); //  update template
                                    }

                                }, dataFields);
                            }


                        }, fieldsNew);
                    }else{ // if user not add field and section new
                        // get field template
                        dataFields = CmsService.mapDataFields([]);
                        // get section template
                        $scope.templateContent.sections = CmsService.mapDataSections([]);
                        if (data.fields && !data.fields.length) {
                            $scope.templateContent.fields = {};
                            updateTemplateContent();
                        } else {
                            // call modal show list field to update
                            $scope.getModalShowListConfigFields(function(valueResultConfigFields) {

                                if(typeof valueResultConfigFields != 'undefined'){
                                    // get field template when update
                                    $scope.templateContent.fields = valueResultConfigFields;

                                    updateTemplateContent(); // update template
                                }

                            }, dataFields);
                        }
                    }

                }


            }else{ // template content error

                $scope.errorContentTemplate = data['message']; // show error content template
            }

        });

    }
    /* When user click insert link */
    $scope.callModalInsert = function (typeInsert, language, region) {
        /* Call Modal Popup To Insert With Input Type */
        var teamplate = '/cms/block-manager/insert' + '?language=' + language + '&&region=' + region + '&&type=' + typeInsert + '&&template=true' + '&&id=';
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
    $scope.reViewTemplate = function()
    {

        angular.element('#page-loading').css('display','block');

        data = {'content': JSON.stringify($scope.editableCodeMirror.getValue()), 'type' : 'blade', 'language' : $scope.templateContent.language, region : $scope.templateContent.region};

        BlockManagerService.reviewContentBlock(data).then(function(data){

            if(data.status){
                $scope.refreshIframe();
            }
        });

    }

    $scope.iframeLoaded = function () {
        $scope.isShowCode = false;
        $scope.isShowReView = true;
    }

    $scope.refreshIframe = function () {

        BlockManagerService.getContentForIframe().then(function(data){
            $scope.iframeLoaded();
            $('#frameBlock').contents().find('body').html(data.content);
            angular.element('#page-loading').css('display','none');
        });

        // window.frames[0].location = baseUrl + "/cms/block-manager/review-content-block";

    }
    /**
     * update template
     *
     * @author minhthan [<than@httsolution.com>]
     * @return {[type]} [description]
     */
    var updateTemplateContent = function() {
        // call function update template
        angular.element('#page-loading').css('display','block');
        TemplateContentManagerService.update($scope.templateContent).then(function(data){
            if(data['status']){
                // redirec page index template
                window.location = baseUrl + "/cms/template-content-manager/set-template-selected/" + $scope.templateContent.folder_id;
            }
            angular.element('#page-loading').css('display','none');
        })
    }

    /* When user click delete thumbnail */
    $scope.removeThumbnail = function(index) {

        if (!confirm('Do you want delete this image?')) return;

        $scope.thumbnail.splice(index, 1);

        $scope.templateContent.thumbnail = null;
    }
    /**
     * upload file thumbnail
     * @param  {[type]} files [description]
     * @return {[type]}       [description]
     */
    $scope.uploadThumbnail = function(files) {
        // check exits file
        if (files && files.length) {
            // max file size serve
            if (files[0]['size'] > maxUpload['size']) {

                $scope.errorThumbnail = 'Max file size is ' + maxUpload['name']; // notification upload file error

                return;
            }
            $scope.reciept_file_name = 'uploading file';
            // upload file to serve
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

                $scope.templateContent.thumbnail = data.item.id; // assignment id file to thumbnail template content

                $scope.reciept_file_name = files[0]['name']; // get file name

                $scope.errorThumbnail = '';

            }).error(function(data) {

                $scope.errorThumbnail = data.message;

                $scope.isErrorUploadFile = true;

            });
        }

    }
}])
