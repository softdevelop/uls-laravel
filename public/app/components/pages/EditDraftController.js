
var editDraftApp = angular.module('EditDraftApp');

editDraftApp.controller('EditDraftController', ['$scope', '$modal', '$filter', 'ngTableParams', '$http', '$window', '$timeout','BlockNestedService','EditDraftService', 'AssetManagerService', '$compile', 'Upload',  'CmsContentInsertService', 'BlockNestedService', '$controller','RemoveCacheService',
    function ($scope, $modal, $filter, ngTableParams, $http, $window, $timeout, BlockNestedService, EditDraftService, AssetManagerService, $compile, Upload, CmsContentInsertService, BlockNestedService, $controller, RemoveCacheService) {
    $controller('BaseController', { $scope: $scope });
    
    $scope.isSearch= false;
    
    angular.element('.wrap-content-management').removeClass('hidden');

     /**
     * set height Editor full screen
     *
     * @author Cong Hoan <hoan@httsolution.com>
     *
     * @return Void
    */
    
    $timeout(function() {
        $(document).ready(function () {
            $scope.setDIVHeight();
        });

        $(window).resize(function () {
            $scope.setDIVHeight();
        });
    })

    $scope.setDIVHeight = function() {
        var theDiv =  $('.set-height');
        var Divtop = $('.top-tab').offset();

        var divTop = Divtop.top;
        
        // var winHeight = $(window).height();
        var winHeight = screen.height;

        var divHeight = winHeight - divTop - 490;

        theDiv.attr('style', 'height: ' + divHeight +  'px!important;min-height:300px;overflow:auto');

    }
    // $scope.redirect = {};
    // $scope.redirect.header = "301";
    $scope.callbackLoadUserFinish = function() {

    };

    $scope.changePageType = function(pageId) {
        data = {'pageId': pageId,'language' : $scope.page.language, 'region' : $scope.page.region}
        EditDraftService.getParentUrl(data).then(function (data) {
            $scope.page.parentUrl = data['url_build'];
        });
    }

    //containt id template or block and they's type with format [id => type]
    //$scope.listTypeWithId = {};

    $scope.listBlockMapData = angular.copy(window.blockMapFileld);

    $scope.listFieldTemplateRequired = angular.copy(window.listFieldTemplateRequired['fieldRequiredIsValid']);

    $scope.listTemPlate = {};

    // $scope.ngModalFile = {};
    $scope.multiFieldFollowVariable = [];

    $scope.exitsFieldBlock = {};  
    //$scope.keyInjects = [];

    $scope.isDetails = true;//view template detail
    // $scope.isShowSelectBox =  false;
    // $scope.successDatabase = false;
    $scope.codeMirrorInited = false;

    // $scope.countUpdate = 0;
    $scope.currentChosseTemplate = 0;//set default current template id

    $scope.page = angular.copy(window.page);
    $scope.versions = angular.copy(window.versions);

    $scope.curLanguage = angular.copy(window.page.language);
    $scope.region = angular.copy(window.page.region);

    // Folder pages show in type
    $scope.folderPages = window.folderPages;
    $scope.isChangeTemplate = false;
    /**
     * set default afew value to validate
     */
    setDefaultValueObjets();

    $scope.baseUrl = window.baseUrl;
    $scope.parents = window.parents;
    $scope.templates = angular.copy(window.templates);

    $scope.checkPage = window.checkPage;

    $scope.listOutTypeMap = angular.copy(window.listOutTypeMap);
    $scope.maxUpload = window.maxUpload;

    // $scope.redirects = EditDraftService.setDataRedirects(window.redirects);

    $scope.nested_block = {};

    $scope.curFields = {};

    $scope.activeFields = {};
    $scope.isShowInjects = {};
    $scope.isDisable = window.isDisable;

    /**
     * cache data nested content block
     */
    $scope.cacheNestedContend = {};

    function setDefaultValueObjets() {
        /**
         * show hide icon danger or success with tab: template, field, block and section,...
         */
        $scope.successForm = {};

        if (angular.isDefined($scope.page.url) && $scope.page.url && angular.isDefined($scope.page.name) && $scope.page.name) {
            $scope.successForm[1] = true;
        }

        $scope.successField = {};

        //apply for inject belong to template
        $scope.successInject = {};
        $scope.existInjecIntTemplate = {};

        $scope.contentPage = {};
        $scope.cacheContentPage = {};

        /*count field added of multiple fields*/
        $scope.countFieldsOfMultiField = {};
        $scope.multiFieldFollowVariable = {};

        //apply for tempate
        $scope.extendsTemplate = {};
        $scope.activeTemplate = {};

        $scope.indexCurrentTemplate = 1;
        $scope.lastTemplate = 0;

        //show warning note if data of page not complete
        $scope.warningError = false;
    }

    /**
     * [synchFields description]
     * get list fields is multitple and count field to show in view agian
     * and check fields of current template is required?
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * 
     * @param  {[type]} oldFields [field's value of template(s) in page]
     * @param  {[type]} id        [description]
     * @param  {[type]} listField  [list field]
     * @param  {[type]} _listFieldRequired  [contain field is requred]
     * @return {[type]}           [description]
     */
    function synchFields(oldFields, id, listField, _listFieldRequired) {

        for (var i in listField) {
            var _variable = '_' + id + '_' + listField[i].variable;
            var oldValueField = oldFields[_variable]; //get value of current field

                //check current field is multiple?
            if (angular.isDefined(oldValueField) && (angular.isArray(oldValueField)
                || angular.isObject(oldValueField)) && listField[i].multiple) {

                for (var f in oldValueField) {

                    if (angular.isUndefined($scope.multiFieldFollowVariable[_variable])) {
                        $scope.multiFieldFollowVariable[_variable] = [{'id':listField[i].variable+'___'+f, 'key_field':f}];
                        updateFieldsOfMuitiField('add',_variable);

                    } else {
                        $scope.multiFieldFollowVariable[_variable].push({'id':listField[i].variable+'___'+f, 'key_field':f});
                        updateFieldsOfMuitiField('add',_variable);
                    }

                    if (listField[i]['type'] == 'asset') { // map url asset
                        $scope.getUrlImageAsset(oldValueField[f]);// get url asset item field
                    }
                }
            }

            if (angular.isDefined(oldValueField) && !listField[i].multiple && listField[i]['type'] == 'html') {
                // get url file asset
                $scope.getUrlImageAsset(oldValueField);
            }
        }
        return _listFieldRequired;
    }
    
    /**
     * show fields of current template
     * and page's data when edit
     *
     * @author [Kim Bang] <bang@httsolution.com>
     *
     * @param  {[type]} _id        [id template]
     * @param  {[type]} oldFields        [fields value of content page]
     *
     */
    var loadCurrentData = function(_id) {

        setDefaultValueObjets();

        $scope.activeTemplate[$scope.indexCurrentTemplate] = true;

        var count = 1;
        $scope.successForm[1] = true;

        //get list tempate of page
        getListTemPlateOfPage(_id);

        for (var _key in $scope.listTemPlate) {

            var currentTemplate = angular.copy($scope.listTemPlate[_key]);

            if (currentTemplate['fields'].length || currentTemplate['sections'].length || checkValidFieldOfInject(currentTemplate['injects'])) {

                if (angular.isUndefined($scope.successInject[_id])) {
                    $scope.successInject[_key] = {};
                }

                count++;

                $scope.extendsTemplate[count] = _key;

                //use to get location of template in page
                $scope.listTemPlate[_key]['stepTemplate'] = count;

                //get block which insert to template and fields is not emplty
                getInjectsHasField(currentTemplate, 'edit', _key, count);

            }
        }

        getTemplateInvalid($scope.listTemPlate, false);
        $scope.lastTemplate = count;

    }

    /**
     * [getInjectsHasField description]
     * get injects has field (field is not empty)
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _template [current template]
     * @param  {[type]} _type     [create or edit]
     * @param  {[type]} _id       [template id]
     * @param  {[type]} _index       [location template in page]
     * @return {[type]}           [description]
     */
    function getInjectsHasField(_template, _type, _id, _index) {
        if (angular.isDefined(_template['injects'])) { //check exist inject in template

            for (var key in _template['injects']) {

                $scope.successInject[_id][key] = true;

                var oldFieldInjects = _template['injects'][key]['fields'];//fields of current inject

                if (angular.isDefined(oldFieldInjects) && oldFieldInjects.length) {//check fields of current inject is valid?

                    $scope.existInjecIntTemplate[_id] = true;

                    $scope.exitsFieldBlock[key] = true;
                }
            }

        }
    }

    /**
     * [getListTemPlateOfPage description]
     * get templates(current tempate and tempate extends of current template) of page
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _idTemplate       [template id]
     * @return {[type]} [description]
     */
    function getListTemPlateOfPage(_idTemplate) {
        //check exist template extends in current template
        if (angular.isDefined($scope.templates[_idTemplate]['extends'])) {

            var listTemplateExtend = angular.copy($scope.templates[_idTemplate]['extends']);

            for (var key in listTemplateExtend) {
                $scope.listTemPlate[key] = $scope.templates[key];
            }
        }

        $scope.listTemPlate[_idTemplate] = $scope.templates[_idTemplate];
    }


    //check exist a template blong to page?
    if (angular.isDefined($scope.page.template)) {
        //check template of page is exist in list template?
        if (angular.isDefined($scope.templates[$scope.page.template])) {

            loadCurrentData($scope.page.template);
        } else {
            $scope.page.template = null;
        }

        $scope.currentChosseTemplate = $scope.page.template;
    }

    // when load page create block then show default code
    $scope.isShowCode = true;

    /**
     * Event when change template for page
     *
     *@author Quang [quang@httsolution.com, than@httsolution.com, bang@httsolution.com]
     *
     */
    $scope.changeTemplate = function (_templateId) {

        if (angular.isDefined($scope.currentChosseTemplate) && $scope.currentChosseTemplate && $scope.currentChosseTemplate != _templateId) {

            var status = confirm($filter('trans')('confirm-change-template', 'page'));
            if (!status) {
                if (angular.isDefined($scope.page.template)) {
                    $scope.page.template = $scope.currentChosseTemplate;
                }
                return;
            }
        }

        //format value for a few object to default value;
        setDefaultValueObjets();

        $scope.listFieldTemplateRequired = angular.copy(window.listFieldTemplateRequired['fieldRequiredIsInvalid']);

        $scope.nested_block = {};

        $scope.listTemPlate = {};

        $scope.isChangeTemplate = true;

        //get list template(current tempalte and template extend of current template)
        getListTemPlateOfPage(_templateId);

        $scope.currentChosseTemplate = _templateId;

        $scope.template = $scope.templates[_templateId];

        $scope.activeTemplate[$scope.indexCurrentTemplate] = true;

        var count = 1;

        $scope.isShowContentSection = false;

        //set content empty
        $scope.content = {};

        contructDefaultVal($scope.listTemPlate, count);

        $scope.extend = _templateId;

        //update icon success for tabs
        getTemplateInvalid($scope.listTemPlate);
    }

    /**
     * [checkValidFieldOfInject description]
     * check exist inject's field belong to current template?
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _listinject [description]
     * @return {[type]}             [description]
     */
    function checkValidFieldOfInject(_listinject) {
        //check exist inject?
        if (angular.isDefined(_listinject)) {
            for (var i in _listinject) {
                //passing each inject and check exist field of current injectSSSS
                if (Object.keys(_listinject[i].fields).length) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * close alert warning
     *
     * @author Quang <quang@httsolution.com>
     *
     */
    $scope.closeAlert = function () {
        $scope.warningError = false;
    }

    /**
     * check validate when save or preview  pages
     *
     * @author Quang <quang@httsolution.com>
     *
     */
    $scope.checkWhenSavePreview = function () {
        //find still field warning element
        var checkExtendTemplate = $('#extend-template').find('.ti-alert');
        //check warning
        if (checkExtendTemplate.length == 0) {
            $scope.warningError = false;
            return false;
        } else {
            $scope.warningError = true;
            return true;
        }
    }

    /**
     * next step template in page
     * @param  {[type]} validate [description]
     * @param  {[type]} index    [description]
     * @return {[type]}          [description]
     */
    $scope.nextStepPage = function(validate, index) {

        $scope.showNotificationNoFields = false;

        $scope.warningError = false;
        $scope.submitted = false;

        if (index > $scope.lastTemplate) return;


        //check current form is valid?
        if (validate) {
            $scope.submitted = true;
            //focus to first element error.
            $('form[name="formData"]').find('.ng-invalid:eq(0)').focus();
            return;
        }

        $scope.indexCurrentTemplate++;

        //get current id template
        $scope.currentChosseTemplate = $scope.extendsTemplate[$scope.indexCurrentTemplate];


        //get data content page with id template
        getDataPage($scope.currentChosseTemplate, 'template', function(data) {
            //check current template exist field?
            if ($scope.listTemPlate[$scope.currentChosseTemplate].fields.length == 0) {//check field of current template is empty?

                //active tab block, if exist an inject belong to current template and that inject contant field
                setDefaultActiveTabBlock($scope.currentChosseTemplate);
            } else {
                //show hide tab content
                showHideHtml(isDetails = false, isShowField = true, isShowInject = false, isShowContentSection = false, isShowDatabase = false);
            }

            //use to active current tab template
            $scope.activeTemplate[index] = false;
            $scope.activeTemplate[$scope.indexCurrentTemplate] = true;

            //change icon success of tabs
            getTemplateInvalid($scope.listTemPlate, false);
        });

        //get data nested of current template
        getDataNestedBlock($scope.currentChosseTemplate);
    }

    /**
     * [setDefaultActiveTabBlock description]
     * set active first tab block when field of current template is empty
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * 
     * @param {[type]} _templateId [id of current template]
     */
    function setDefaultActiveTabBlock(_templateId) {
        var _listInject = $scope.listTemPlate[_templateId]['injects'];
        //active tab section, if not exist inject belong to current template or field's inject is empty
        if (angular.isUndefined(_listInject) || angular.isDefined(_listInject) && Object.keys(angular.extend({}, _listInject)).length < 1) {
            setDefaultActiveSection(_templateId); 
        } else {
            for (var key in _listInject) {
                
                var dataInject = _listInject[key]['fields'];

                if (angular.isDefined(dataInject) && Object.keys(dataInject).length) {//check and get first inject, if exist field
                    $scope.curSecIndex = key;

                    getDataNestedBlock(key);

                    //get content current block belong to current template
                    getDataPage(key, 'block', function(data) {

                        $scope.isShowInjects = {};
                        $scope.isShowInjects[$scope.curSecIndex + $scope.indexCurrentTemplate] = true;

                        //check and active tab block
                        if (angular.isUndefined($scope.activeBlocks[$scope.curSecIndex + $scope.indexCurrentTemplate])) {
                            $scope.activeBlocks = {};
                            $scope.activeBlocks[$scope.curSecIndex + $scope.indexCurrentTemplate] = true;
                        }

                        showHideHtml(isDetails = false, isShowField = true, isShowInject = true, isShowContentSection = false, isShowDatabase = false);
                    });


                    //$scope.listTypeWithId[key] = 'block';

                    break;                    
                } else if (Object.keys(_listInject)[Object.keys(_listInject).length - 1] == key) {
                    setDefaultActiveSection(_templateId);                
                }
            }
        }

    }

    /**
     * [prevStepPage description]
     * @param  {[type]} index [description]
     * @return {[type]}       [description]
     */
    $scope.prevStepPage = function(index) {

        $scope.showNotificationNoFields = false; // hide notification no fields tempalte

        if (index < 2) return;

        if (index < 3) {
            $scope.isShowField = false;
            $scope.isDetails = true;
        }

        $scope.activeTemplate[index] = false;
        $scope.indexCurrentTemplate--;

        //check exist current template
        if (angular.isDefined($scope.extendsTemplate[$scope.indexCurrentTemplate])) {
            $scope.currentChosseTemplate = $scope.extendsTemplate[$scope.indexCurrentTemplate];
        }

        //check and active tab block, if template not exist field
        if ($scope.listTemPlate[$scope.currentChosseTemplate].fields.length == 0) {//check field of current template is empty?
            setDefaultActiveTabBlock($scope.currentChosseTemplate);
        }

        //format data field of content nested block
        if (angular.isDefined($scope.nested_block) && Object.keys($scope.nested_block).length) {
            formatDateValueNestedContent($scope.nested_block);
        }

        $scope.activeTemplate[$scope.indexCurrentTemplate] = true;
    }

    /**
     * [formatDataFileDate description]
     * convent field data is date to format yyyy-mm-dd
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * 
     * @param  {[type]} fields [field data of page]
     * @return {[type]}        [description]
     */
    function formatDataFileDate(fields) {
        
        (function(fields) {
            for (var i in fields) {
                if ((angular.isArray(fields[i]) && fields[i].length || angular.isObject(fields[i]) && Object.keys(fields[i]).length)) {
                    formatDataFileDate(fields[i]);
                } else if (angular.isDate(fields[i])) {
                    fields[i] = $filter('date')(fields[i], 'yyyy-MM-dd');
                }
            }
        })(fields)

    }

    $scope.indexCurrentTemplate = 1;

    /**
     * when choose details
     *
     * @author Quang <quang@httsolution.com>
     *
     * @param  bool validate validate form
     *
     */
    $scope.chooseDetails = function (validate) {
        $scope.submitted = false;

        $scope.activeTemplate = {};
        $scope.activeBlocks = {};
        $scope.activeFields = {};

        delete $scope.currentTabActive;

        $scope.showNotificationNoFields = false;

        $scope.listErrorListFile = [];

        $scope.indexCurrentTemplate = 1;

        $scope.activeTemplate[$scope.indexCurrentTemplate] = true;

        showHideHtml(isDetails = true, isShowField = false, isShowInject = false, isShowContentSection = false, isShowDatabase = false);
    }

    /**
     * [showHideHtml description]
     * show hide tan contant data content page
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {Boolean} isDetails            [description]
     * @param  {Boolean} isShowField          [description]
     * @param  {Boolean} isShowInject         [description]
     * @param  {Boolean} isShowContentSection [description]
     * @param  {Boolean} isShowDatabase       [description]
     * @return {[type]}                       [description]
     */
    function showHideHtml(isDetails, isShowField, isShowInject, isShowContentSection, isShowDatabase) {
        $scope.isDetails = isDetails;

        $scope.isShowField = isShowField;  //show or hide template's field

        if (!isShowInject) {
            $scope.isShowInjects = {};
        }

        $scope.isShowInject = isShowInject; //show or hide block's field

        $scope.isShowContentSection = isShowContentSection; //show or hide codeMirror

        if (angular.isDefined($scope.nested_block) && Object.keys($scope.nested_block).length) {
            formatDateValueNestedContent($scope.nested_block);
        }
    }

    /**
     * [formatDateValueNestedContent description]
     * format date for field is object date in content nested block
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} nestedData [description]
     * @return {[type]}            [description]
     */
    function formatDateValueNestedContent(nestedData) {
        (function formatData(data) {
            for (var _key in data) {
                if (angular.isDefined(data[_key]) && angular.isUndefined(data[_key]['data'])) {
                    formatData(data[_key]);
                } else {
                    formatDataFileDate(data[_key]['data']);
                }
            }
        })(nestedData)
    }

    /**
     * [getDataPage description]
     * get data of page with id template or block from server
     * 
     * @author [someone@httsolution.com, bang@httsolution.com]
     * @param  {[type]} baseId [description]
     * @param  {[type]} type   [description]
     * @return {[type]}        [description]
     */
    var getDataPage = function(baseId, type, callback) {

        //check exist content page in cache?
        if (angular.isDefined($scope.cacheContentPage['_' + baseId])) {
            $scope.contentPage['_' + baseId] = $scope.cacheContentPage['_' + baseId];

            //call back
            if (angular.isDefined(callback)) {
                var callbackData = callback.call(callbackData, true);
            }
        } else {
            var data = {
                'base_id': baseId, 'content_id' : $scope.page.content_id, 'type' : type, 
                'template_id' : $scope.currentChosseTemplate, 'blocks_injects' : $scope.blocksInjects, 'is_change_template' : $scope.isChangeTemplate
            };
            angular.element('#page-loading').css('display', 'block');

            EditDraftService.getDataPage(data).then(function(result) {

                //convent array to object
                if (angular.isDefined(result.data['_' + baseId]['data'])) {
                    result.data['_' + baseId]['data'] = angular.extend({}, result.data['_' + baseId]['data']);

                    if (angular.isDefined(result.data['_' + baseId]['data']['fields'])) {
                        result.data['_' + baseId]['data']['fields'] = angular.extend({}, result.data['_' + baseId]['data']['fields']);
                    }
                }

                $scope.contentPage['_' + baseId] = result.data['_' + baseId];
                $scope.cacheContentPage['_' + baseId] = $scope.contentPage['_' + baseId];

                //check current data is template or block
                //and show content for page
                if (type == 'block') {
                    synchFieldInject($scope.currentChosseTemplate, baseId, $scope.contentPage['_' + baseId]['data']['fields']);
                } else if (type = 'template') {
                    synchFieldTemplate(baseId, $scope.contentPage['_' + baseId]['data']['fields']);
                }

                angular.element('#page-loading').css('display', 'none');

                if (angular.isDefined(callback)) {
                    var callbackData = callback.call(callbackData, true);
                }
            });
        }
    }

    /**
     * [synchFieldInject description]
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _templateId          [description]
     * @param  {[type]} _blockId             [description]
     * @param  {[type]} _oldFieldValueOfPage [description]
     * @return {[type]}                      [description]
     */
    function synchFieldInject(_templateId, _blockId, _oldFieldValueOfPage) {
        var injectsBelongToTemplate = $scope.listTemPlate[_templateId]['injects'];

        //check current exist inject belong to current template with block id
        //and check exist fields in that inject
        if (angular.isDefined(injectsBelongToTemplate) && angular.isDefined(injectsBelongToTemplate[_blockId])
                && angular.isDefined(injectsBelongToTemplate[_blockId]['fields'])) {
            var currentFieldInject = injectsBelongToTemplate[_blockId]['fields'];
        }

        //check field is empty?
        if (angular.isDefined(currentFieldInject) && currentFieldInject.length > 0) {

            //check exist current block in list field template required?
            if (angular.isDefined($scope.listFieldTemplateRequired[_templateId]) && angular.isDefined($scope.listFieldTemplateRequired[_templateId]['block'])) {

                synchFields(_oldFieldValueOfPage, _blockId, currentFieldInject, $scope.listFieldTemplateRequired[_templateId]['block'][_blockId]);
            } else {

                synchFields(_oldFieldValueOfPage, _blockId, currentFieldInject);
            }
            var _currentFieldBlock = $scope.listFieldTemplateRequired[_templateId][_blockId];
            updateStatusFieldRequired(_blockId, _currentFieldBlock, $scope.contentPage['_' + _blockId]['data']['fields']);

        }
        angular.element('#page-loading').css('display', 'none');
    }

    /**
     * [synchFieldTemplate description]
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _templateId          [description]
     * @param  {[type]} _oldFieldValueOfPage [description]
     * @return {[type]}                      [description]
     */
    function synchFieldTemplate(_templateId, _oldFieldValueOfPage) {
        var currentFieldTemplate = $scope.listTemPlate[_templateId].fields;

        if (angular.isDefined(currentFieldTemplate) && currentFieldTemplate.length) {

            synchFields(_oldFieldValueOfPage, _templateId, currentFieldTemplate, $scope.listFieldTemplateRequired[_templateId]);

            var _currentFieldTemplate = $scope.listFieldTemplateRequired[_templateId];
            updateStatusFieldRequired(_templateId, _currentFieldTemplate, $scope.contentPage['_' + _templateId]['data']['fields']);
        }

        angular.element('#page-loading').css('display', 'none');
    }

    /**
     * [chooseCurrentTemplate description]
     *
     * @author [quang@httsolution.com, bang@httsolution.com]
     * @param  {[type]} validate             [description]
     * @param  {[type]} _templateId          [id of current template belong to page]
     * @param  {[type]} indexCurrentTemplate [old location of template belong to page]
     * @param  {[type]} index                [new location of template belong to page]
     * @return {[type]}                      [description]
     */
    $scope.chooseCurrentTemplate = function (validate, _templateId, indexCurrentTemplate, index) {

        $scope.submitted = false;

        //check current form is valide?
        if (checkFormInvalid(validate)) {
            return;
        }

        $scope.currentTabActive = _templateId;

        $scope.showNotificationNoFields = false;

        $scope.blocksInjects = [];

        //get id inject belong to current template
        for(var key in $scope.templates[_templateId].injects) {
            $scope.blocksInjects.push(key);
        }
        
        $scope.indexCurrentTemplate = index;
        $scope.currentChosseTemplate = _templateId;
        $scope.activeTemplate = {};
        $scope.activeTemplate[index] = true;

        //redirect to block tab is invalid
        //apply when click edit or preview button
        if (!validate && angular.isDefined($scope.hasInjectFocus)
            && angular.isDefined(angular.element('#injects_' + $scope.hasInjectFocus))) {

            $timeout(function() {
                $('#injects_' + $scope.hasInjectFocus).trigger('click');
                delete $scope.hasInjectFocus;
            })
            return;
        } else if (angular.isDefined($scope.hasInjectFocus)) {
            delete $scope.hasInjectFocus;
        }

        //get data content with id template
        getDataPage(_templateId, 'template', function(data) {

            $scope.activeFields = {};

            if ($scope.listTemPlate[_templateId].fields.length == 0) {//check field of current template is empty?

                setDefaultActiveTabBlock(_templateId);//function
            } else {
                showHideHtml(isDetails = false, isShowField = true, isShowInject = false, isShowContentSection = false, isShowDatabase = false);
                
                if (angular.isUndefined($scope.activeFields[$scope.indexCurrentTemplate])) {
                    $scope.activeFields = {};
                    $scope.activeBlocks = {};
                    $scope.activeFields[$scope.indexCurrentTemplate] = true;
                }
            }

            checkInvalidAndAcTiveTemplateError($scope.currentChosseTemplate, false);//chang status for icons in tabs

            $scope.isDetails = false;

            $timeout(function() {
                expandBlockElementError();
            })
        });

        getDataNestedBlock(_templateId);

        //$scope.listTypeWithId[_templateId] = 'template';
    }

    /**
     * [setDefaultActiveSection description]
     * active tab section if exist section in current template
     * and field of current template is empty and field of inject belong to current template is empty
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param {[type]} _templateId [description]
     */
    function setDefaultActiveSection(_templateId) {
        var listSection =  $scope.listTemPlate[_templateId].sections;
        //active first section
        for (var key in listSection) {
            $scope.chooseSection(false, listSection[key]['variable'], listSection[key]['_id'], $scope.indexCurrentTemplate);
            break;
        }
    }

    /**
     * [chooseFields description]
     *
     * @author [quang@httsolution.com, bang@httsolution.com]
     * @param  {[type]} validate [description]
     * @param  {[type]} index    [description]
     * @return {[type]}          [description]
     */
    $scope.chooseFields = function (validate, index) {

        $scope.submitted = false;

        //check current form is valid?
        if (checkFormInvalid(validate)) {
            return;
        }

        $scope.currentTabActive = $scope.currentChosseTemplate;

        //get data content of current tab
        getDataPage($scope.currentChosseTemplate, 'template', function(data) {

            showHideHtml(isDetails = false, isShowField = true, isShowInject = false, isShowContentSection = false, isShowDatabase = false);
            
            $scope.activeFields = {};
            $scope.activeFields[$scope.indexCurrentTemplate] = true;

            $timeout(function() {
                expandBlockElementError();
            })
        });

        getDataNestedBlock($scope.currentChosseTemplate);


        //$scope.listTypeWithId[$scope.currentChosseTemplate] = 'template';

    }

    /**
     * [chooseSection description]
     *
     * @author [quang@httsoluttion.com, bang@httsolution.com]
     * @param  {[type]} validate    [description]
     * @param  {[type]} secVariable [variable of current section]
     * @param  {[type]} sectionId   [description]
     * @param  {[type]} index       [location template that current section belong to]
     * @return {[type]}             [description]
     */
    $scope.chooseSection = function(validate, secVariable, sectionId, index) {
        $scope.submitted = false;

        if (checkFormInvalid(validate, $scope.curSecIndex)) {
            return;
        }
        delete $scope.currentTabActive;

        //check codeMirror has been inited? if not yet then init
        if (!$scope.codeMirrorInited) {
            $scope.initCodeMirror();
        }
        //set value for code mirror
        $timeout(function() {
            var _templateId = (angular.isDefined($scope.currentChosseTemplate)) ? $scope.currentChosseTemplate : $scope.page.template;

            if (angular.isUndefined($scope.content[_templateId])) {
                $scope.content[_templateId] = {};
            }

            //check exist content section belong to template
            if (angular.isDefined($scope.content[_templateId][secVariable]) && $scope.content[_templateId][secVariable]) {
                $scope.editableCodeMirror.setValue($scope.content[_templateId][secVariable]);

                //check exist content section belong to template in content page
            }else {
                var _dataContentPage = $scope.contentPage['_' + _templateId];
                if (angular.isDefined(_dataContentPage) && angular.isDefined(_dataContentPage['data']) && angular.isDefined(_dataContentPage['data']['sections'])
                     && angular.isDefined(_dataContentPage['data']['sections'][secVariable])) {

                    $scope.editableCodeMirror.setValue(_dataContentPage['data']['sections'][secVariable]);
                    $scope.content[_templateId][secVariable] = _dataContentPage['data']['sections'][secVariable];
                } else {
                    $scope.editableCodeMirror.setValue('');
                }
            }
        });

        //true when choose section
        $scope.curSection = true;

        $scope.curSecIndex = sectionId;//set current section

        showHideHtml(isDetails = false, isShowField = false, isShowInject = false, isShowContentSection = true, isShowDatabase = false);

        //set new section variable
        $scope.secVariable = secVariable;
    }

    $scope.activeBlocks = [];

    /**
     * [chooseInject description]
     *
     * @author [Quang, Kim Bang] [quang@httsolution.com, bang@httsolution.com]
     * @param  {[type]} validate [description]
     * @param  {[type]} blockId  [description]
     * @param  {[type]} index    [description]
     * @return {[type]}          [description]
     */
    $scope.chooseInject = function (validate, blockId, index) {

        $scope.submitted = false;

        if (checkFormInvalid(validate, blockId)) {
            //check current form is valid?
            return;
        }

        $scope.currentTabActive = blockId;

        $scope.childInject = {};

        $scope.childInject[blockId] = true;

        $scope.curSecIndex = blockId;

        //is not select section
        $scope.curSection = false;
        
        //get data content current block tab
        getDataPage(blockId, 'block', function(data) {
            //show hide content of tabs
            showHideHtml(isDetails = false, isShowField = false, isShowInject = true, isShowContentSection = false, isShowDatabase = false);

            $scope.isShowInjects = {};
            $scope.isShowInjects[blockId+index] = true;

            $scope.activeBlocks[blockId+index] = true;

            $timeout(function() {
                expandBlockElementError();
            })
        });

        getDataNestedBlock(blockId);
        //$scope.listTypeWithId[blockId] = 'block';

    }

    /**
     * [getDataNestedBlock description]
     * call sever get data of subblock with block id
     *
     * @author [someone, Kim Bang] [someone@httsolution.com, bang@httoslution.com]
     * @param  {[type]} blockId [description]
     * @return {[type]}         [description]
     */
    var getDataNestedBlock = function(blockId) {
        //if content nested block exist, get from to cache.
        if (angular.isDefined($scope.cacheNestedContend[blockId])) {
            $scope.nested_block = $scope.cacheNestedContend[blockId];
            return;
        }
        //call server to get data nested content block with content_id (content page id) and blockId
        var data = {'contentId': $scope.page.content_id,'blockId' : blockId}
        BlockNestedService.getDataNestedBlock(data).then(function(data) {
            //check current data is empty?
            if (data.results && Object.keys(data.results).length) {

                //set data content current block with blockId
                $scope.nested_block[blockId] = data.results;
                // for(var key in $scope.nested_block[blockId]) {
                //     console.log('$scope.nested_block[blockId]', $scope.nested_block[blockId][key]);
                // }

            } else {
                $scope.nested_block[blockId] = {};
            }
            $scope.cacheNestedContend[blockId] = $scope.nested_block;

        })        

    }
    // sort table options fields multi
    $scope.sortableOptionsFields = {
        axis: "y",
        handle: "span.my-handle-field",
        start: function(e, ui) {
            // creates a temporary attribute on the element with the old index
            $(this).attr('data-previndex', ui.item.index());
        },
        update: function(event, ui) { // callback 
        },
        stop: function(event, ui) { // callback stop event
            var oldIndex = $(this).attr('data-previndex');
            var newIndex = ui.item.index();
            if(oldIndex != newIndex) {
                
                $(this).removeAttr('data-previndex');
                var tab = ui.item.sortable.droptarget.attr('tab-field').split("-")[1]; // get id tab
                var variable = ui.item.sortable.droptarget.attr('variable-field').split("-")[1]; // get variable
                $scope.sortFields(tab, variable, oldIndex,  newIndex);
            }

        }
    };

    /**
     * change position sort fields
     *
     * @author Minh than than@httsolution.com
     * 
     * @param  {[string]} tab      [current tab]
     * @param  {[string]} variable [current variable]
     * @param {int} oldIndex [old index draft]
     * @param {int} newIndex [new index draft]
     * @return {[type]}          [description]
    */
    $scope.sortFields = function(tab, variable, oldIndex, newIndex) {
        _tab = '_' + tab;
        _variable = _tab + '_' + variable;
        var tmpNFields = [];
        for (var i = 0; i <= $scope.multiFieldFollowVariable[_variable].length - 1; i++) {

            var stringId = $scope.multiFieldFollowVariable[_variable][i]['id'].split('___')[0];// get string id
            $scope.multiFieldFollowVariable[_variable][i]['id'] = stringId + '___' + i; // set id
            $scope.multiFieldFollowVariable[_variable][i]['key_field'] = ''+ i; // set id
            // check exits content page in multi field key
            if(angular.isDefined($scope.contentPage[_tab]) && angular.isDefined($scope.contentPage[_tab]['data']['fields'][_variable]) && 
                angular.isDefined($scope.contentPage[_tab]['data']['fields'][_variable][i])) {
                tmpNFields[i] = $scope.contentPage[_tab]['data']['fields'][_variable][i];
            } else {
                tmpNFields[i] = null; // set default
            }
        }


        EditDraftService.sortArray(oldIndex, newIndex, tmpNFields).then(function(data) {
            
            if(data) {

                $scope.contentPage[_tab]['data']['fields'][_variable] = data; // sort array
            }
            updateIndexNestedWhenSortField(tab, variable, oldIndex, newIndex); // sort nesteds
            updateArrayRequiredField(tab, variable, oldIndex, newIndex);

        })

    }

    /**
     * [updateArrayRequiredField description]
     * update index of listFieldValidate when move a field to new location
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} tab      [id of current tab]
     * @param  {[type]} variable [variable of field]
     * @param  {[type]} oldIndex [description]
     * @param  {[type]} newIndex [description]
     * @return {[type]}          [description]
     */
    function updateArrayRequiredField(tab, variable, oldIndex, newIndex) {
        if (angular.isDefined($scope.listFieldTemplateRequired[tab], $scope.listFieldTemplateRequired[$scope.currentChosseTemplate][tab])) {
            var curVariable = '_' + tab + '_' + variable;
            var listFieldRequired = (angular.isDefined($scope.listFieldTemplateRequired[tab]))?$scope.listFieldTemplateRequired[tab]:$scope.listFieldTemplateRequired[$scope.currentChosseTemplate][tab];
            if (angular.isDefined(listFieldRequired) && angular.isDefined(listFieldRequired[curVariable])
                && angular.isDefined(listFieldRequired[curVariable][newIndex]) && angular.isDefined(listFieldRequired[curVariable][oldIndex])) {

                var _tmp = angular.copy(listFieldRequired[curVariable][oldIndex]);

                listFieldRequired[curVariable][oldIndex] = angular.copy(listFieldRequired[curVariable][newIndex]);
                listFieldRequired[curVariable][newIndex] = angular.copy(_tmp);
            }
        }
    }

    $scope.parseInt = function (string) {
        return parseInt(string);
    }
    /**
     * [moveUp description]
     * @param  {[type]} $event [description]
     * @return {[type]}        [description]
     */
    $scope.moveUp = function($event) {
        // item contain a box that user want move up
        var item = $($event.currentTarget).closest('.panel-group');
        // itemSortable is a container of list box
        var itemSortable = $(item).closest('.ui-sortable');
        // items contain list boxes
        var items = itemSortable.children('.panel-group');
        // crntPos contain a  position of the current box
        var crntPos = items.index(item);
        // topMoveUp is value of the previous position 
        var topMoveUp =  - (items.eq(crntPos-1).height() + 20);
        // topMoveDown is value of the current position 
        var topMoveDown =  item.height() + 20;

        items.eq(crntPos-1).css({position: 'relative'}).animate({top:  topMoveDown}, 500, function(){
            
            items.eq(crntPos-1).css({position: 'static', 'top' : 'auto'});
        });

        item.css({position: 'relative'}).animate({top:  topMoveUp}, 500, function(){
            item.css({position: 'static', 'top' : 'auto'});

            if (crntPos > 0) {
              var keyField = itemSortable.attr('data-tab-key');
              var oldValue = $scope.multiFieldFollowVariable[keyField].splice(crntPos, 1);
              $scope.multiFieldFollowVariable[keyField].splice(crntPos - 1, 0, oldValue[0]);
            }

            var oldIndex = crntPos;
            var newIndex = crntPos - 1;
                
            var tab = itemSortable.attr('tab-field').split("-")[1]; // get id tab
            var variable = itemSortable.attr('variable-field').split("-")[1]; // get variable
            $scope.sortFields(tab, variable, oldIndex,  newIndex);

        });
    };
    
    /**
     * [moveDown description]
     * @param  {[type]} $event [description]
     * @return {[type]}        [description]
     */
    $scope.moveDown = function($event) {
        // item contain a box that user want move down
        var item = $($event.currentTarget).closest('.panel-group');
        // itemSortable is a container of list box
        var itemSortable = $(item).closest('.ui-sortable');
        // items contain list boxes
        var items = itemSortable.children('.panel-group');
        // crntPos contain a  position of the current box
        var crntPos = items.index(item);
        // swap current data to new position
       if (crntPos >= items.length) {
            return;
       }
        // topMoveUp is value of the current position 
        var topMoveUp =  - (item.height() + 20);
        // topMoveDown is value of the previous position 
        var topMoveDown =  items.eq(crntPos-1).height() + 20;


        item.css({position: 'relative'}).animate({top:  topMoveDown}, 500, function(){
            item.css({position: 'static', 'top' : 'auto'});
        });
        items.eq(crntPos+1).css({position: 'relative'}).animate({top:  topMoveUp}, 500, function(){
            items.eq(crntPos+1).css({position: 'static', 'top' : 'auto'});

            var keyField = itemSortable.attr('data-tab-key');
            var oldValue = $scope.multiFieldFollowVariable[keyField].splice(crntPos, 1);
            

            var oldIndex = crntPos;
            var newIndex = crntPos + 1;
                
            var tab = itemSortable.attr('tab-field').split("-")[1]; // get id tab
            var variable = itemSortable.attr('variable-field').split("-")[1]; // get variable

            $scope.multiFieldFollowVariable[keyField].splice(crntPos + 1, 0, oldValue[0]);
            $scope.sortFields(tab, variable, oldIndex,  newIndex);
            

        });

        
    };

    /**
     * [moveDown description]
     * @param  {[type]} $event [description]
     * @return {[type]}        [description]
     */
    $scope.moveDownNestedBlock = function($event) {
        $event.pageX--;
        // item contain a box that user want move down
        var item = $($event.currentTarget).closest('.panel-group');
        // itemSortable is a container of list box
        var itemSortable = $(item).closest('.ui-sortable');
        // items contain list boxes
        var items = itemSortable.children('.panel-group');
        // crntPos contain a  position of the current box
        var crntPos = items.index(item);
        // topMoveUp is value of the current position 
        var topMoveUp =  - (item.height() + 20);
        // topMoveDown is value of the previous position 
        var topMoveDown = + (items.eq(crntPos+1).height() + 20);

        item.css({position: 'relative'}).animate({top:  topMoveDown}, 500, function(){
            item.css({position: 'static', 'top' : 'auto'});
        });

        items.eq(crntPos+1).css({position: 'relative'}).animate({top:  topMoveUp}, 500, function(){
            

            if (crntPos < items.length) {
                var tabId = $($event.currentTarget).attr('data-tab-id');
                var variable = $($event.currentTarget).attr('data-variable');
                var indexParent = $($event.currentTarget).attr('data-index-parent');
                var nestedId = $($event.currentTarget).attr('data-nested-id');   

                var nestedContentsTemp = $scope.nested_block[tabId][variable][indexParent];

                ++nestedContentsTemp[crntPos].sort_number;
                --nestedContentsTemp[crntPos+1].sort_number;

                var oldValue = nestedContentsTemp.splice(crntPos, 1);
                nestedContentsTemp.splice(crntPos + 1, 0, oldValue[0]);
                $scope.$apply();
            }

            items.eq(crntPos+1).css({position: 'static', 'top' : 'auto'});

               
        });

        if (angular.isDefined($scope.nested_block) && Object.keys($scope.nested_block).length) {
            formatDateValueNestedContent($scope.nested_block);
        }
    };

    /**
     * [moveDown description]
     * @param  {[type]} $event [description]
     * @return {[type]}        [description]
     */
    $scope.moveUpNestedBlock = function($event) {
        // item contain a box that user want move down
        var item = $($event.currentTarget).closest('.panel-group');
        // itemSortable is a container of list box
        var itemSortable = $(item).closest('.ui-sortable');
        // items contain list boxes
        var items = itemSortable.children('.panel-group');
        // crntPos contain a  position of the current box
        var crntPos = items.index(item);
        // topMoveUp is value of the current position 
        var topMoveUp =  - (items.eq(crntPos-1).height() + 20);
        // topMoveDown is value of the previous position 
        var topMoveDown = + (item.height() + 20);

        item.css({position: 'relative'}).animate({top:  topMoveUp}, 500, function(){
            item.css({position: 'static', 'top' : 'auto'});
        });

        items.eq(crntPos-1).css({position: 'relative'}).animate({top:  topMoveDown}, 500, function(){
            items.eq(crntPos-1).css({position: 'static', 'top' : 'auto'});

            if (crntPos > 0) {
                var tabId = $($event.currentTarget).attr('data-tab-id');
                var variable = $($event.currentTarget).attr('data-variable');
                var indexParent = $($event.currentTarget).attr('data-index-parent');
                var nestedId = $($event.currentTarget).attr('data-nested-id');
            }

            var nestedContentsTemp = $scope.nested_block[tabId][variable][indexParent];
            --nestedContentsTemp[crntPos].sort_number;
            ++nestedContentsTemp[crntPos-1].sort_number;

            var oldValue = nestedContentsTemp.splice(crntPos, 1);
            nestedContentsTemp.splice(crntPos - 1, 0, oldValue[0]);
            $scope.$apply();
        });

        if (angular.isDefined($scope.nested_block) && Object.keys($scope.nested_block).length) {
            formatDateValueNestedContent($scope.nested_block);
        }
    };

    /**
     * [updateIndexNestedWhenSortField description]
     *
     * @author Minh than than@httsolution.com
     * @return {[type]} [description]
     */
    var updateIndexNestedWhenSortField = function (tab, variable, oldIndex, newIndex) {

        var tmpNesteds = [];
        for (var i = 0; i <= $scope.multiFieldFollowVariable[_variable].length - 1; i++) {

            if(angular.isDefined($scope.nested_block[tab]) && angular.isDefined($scope.nested_block[tab][variable]) 
                && angular.isDefined($scope.nested_block[tab][variable][i])) {
                tmpNesteds[i] = $scope.nested_block[tab][variable][i];
            } else {
                tmpNesteds[i] = null;
            }
        }

        EditDraftService.sortArray(oldIndex, newIndex, tmpNesteds).then(function(data) {

            $scope.nested_block[tab][variable] = data; // sort array
            // BlockNestedService.updateIndexNestedWhenSortField($scope.nested_block[tab][variable]).then(function(data) {

            // });
        });
    }

    // sort table options nesteds
    $scope.sortableOptionsNesteds = {
        connectWith: ".connected-drop-target-sortable",
        axis: "y",
        handle: "span.my-handle",
        update: function(event, ui) {
        },
        stop: function(event, ui) { // callback stop event
            
            var tab = ui.item.sortable.droptarget.attr('tab-nested').split("-")[1]; // get id tab
            var variable = ui.item.sortable.droptarget.attr('variable').split("-")[1]; // get variable
            var index = ui.item.sortable.droptarget.attr('id').split("-")[1]; // get index
            $scope.sortCurrentNesteds(tab, variable, index); // change sort number
        }
    };

    /**
     * change sort number nested
     * @param  {[type]} tab      [description]
     * @param  {[type]} variable [description]
     * @param  {[type]} index    [description]
     * @return {[type]}          [description]
     */
    $scope.sortCurrentNesteds = function(tab, variable, index) {
        var sort = 0;
        for(var key in $scope.nested_block[tab][variable][index]) {

            $scope.nested_block[tab][variable][index][key]['sort_number'] = sort;
            sort++;
        }
    }

    var reSortNumber = function(tab, variable, index, deleteIndex) {

        var tmpCurrentNesteds = []; // set temp current nested
        // sort nested block
        for(var key in $scope.nested_block[tab][variable][index]) {
            // if current delete index sort < sort nested index
            if(deleteIndex < $scope.nested_block[tab][variable][index][key]['sort_number']) {
                sort = $scope.nested_block[tab][variable][index][key]['sort_number'] - 1; // sort number -1
                $scope.nested_block[tab][variable][index][key]['sort_number'] = sort;
            }
            $scope.nested_block[tab][variable][index][key]['data'] = angular.extend({}, $scope.nested_block[tab][variable][index][key]['data']);
            tmpCurrentNesteds.push($scope.nested_block[tab][variable][index][key]); // push tmp current nested
        }        
        $scope.nested_block[tab][variable][index] = tmpCurrentNesteds; // reset nested

    }
    /**
     * [checkFormInvalid description]
     * check current template or current inject of form is valid?
     * and active current template or inject belong to current template
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} validate [description]
     * @param  {[type]} blockId  [description]
     * @return {[type]}          [description]
     */
    function checkFormInvalid(validate, blockId) {
        //check current form is success?
        if (validate) {

            $scope.activeTemplate = {};
            $scope.activeTemplate[$scope.indexCurrentTemplate] = true;

            //check and active tab field, if data of it invalid
            if ($scope.currentTabActive == $scope.currentChosseTemplate && angular.isDefined($scope.currentTabActive)) {

                var tmpActiveField = {};
                    tmpActiveField[$scope.indexCurrentTemplate] = true;
                
                $scope.activeFields = tmpActiveField;//show class active, if exist field is invalid.
            } else if ($scope.curSecIndex == $scope.currentTabActive && angular.isDefined($scope.currentTabActive)) {//active tab block

                var tmpActiveField = {};
                    tmpActiveField[$scope.curSecIndex + $scope.indexCurrentTemplate] = true;
                    
                $scope.activeBlocks = tmpActiveField;
            }

            $scope.submitted = true;

            //function
            expandBlockElementError();
            $scope.warningError = true;

            return true;
        }

        $scope.submitted = false;

        return false;
    }

    /**
     * [getElementAndActiveTogle description]
     * get parent element contant element error and expand that emlement
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} currentEl [parent element contant element error]
     * @return {[type]}           [description]
     */
    function getElementAndActiveTogle(currentEl) {

        var _parentEl = currentEl.parent().find('[data-toggle="collapse"]');

        //passing each element contant attribute [data-toggle="collapse"]
        //get value of attribute "data-target";
        _parentEl.each(function() {
            var _attrValue = $(this).attr('data-target');

            //declare regex
            var re = new RegExp('(\.|#)');

            //replace character "." or "#" to empty
            _attrValue = _attrValue.replace(re, '');

            //check currentEl exist class or id that same value of attribute "data-target" of current element?
            if (currentEl.hasClass(_attrValue) || currentEl.attr('id') == _attrValue) {
                //click current element
                $(this).trigger('click');
                return true;
            }
        });

        return false;
    }

    /**
     * [expandBlockElementEror description]
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} currentElement [description]
     * @return {[type]}                [description]
     */
    function expandBlockElementError() {

        var _currentElement = $('form[name="formData"]').find('.ng-invalid:eq(0)');

        if (_currentElement.length) {
            //recursive function
            (function callBack(currentElement){
                //check parent of current element is form?
                if (!currentElement.parent().is('form')) {

                    currentElement = currentElement.parents('.collapse:not(.in)');

                    //check exist block element contant class .collpse and not exist class .in?
                    if (currentElement.length){
                        //call function getElementAndActiveTogle to expand current element
                        if (getElementAndActiveTogle(currentElement)) {                        
                            return;
                        } else {
                            //call recursive function again
                            callBack(currentElement);
                        }
                    }
                }
            })(_currentElement)

            focusFieldError();
        }

        return;
    }

    /**
     * [focusFieldError description]
     * focus to element error
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _elementError [description]
     * @return {[type]}               [description]
     */
    function focusFieldError() {

        var _elementError = $('form[name="formData"]').find(".ng-invalid:eq(0)");

        //scroll to emlemt is div, span,... that's value is invalid
        if (_elementError.is('div')) {

            $offsetTopOfCurrentDiv = _elementError.offset().top; // get location of current element to top
            $('body').scrollTop($offsetTopOfCurrentDiv - 150); // scroll to element error (150 is height of navibar)
        } else if (_elementError.is('textarea')) {//scroll to element texarea use plugin redactor is invalid.

            var parentDiv = _elementError.parent();//get parent element contain current textarea
            var isRedactor = parentDiv.find('div.redactor-editor').length; //check exist div that be created by redactor plugin?

            if (isRedactor) {
                $offsetTopOfCurrentDiv = parentDiv.offset().top;
                $('body').scrollTop($offsetTopOfCurrentDiv - 150);
            }
        } else if (_elementError) {
            $offsetTopOfCurrentDiv = _elementError.offset().top; // get location of current element to top
            $('body').scrollTop($offsetTopOfCurrentDiv - 150); // scroll to element error (150 is height of navibar)
        }

        _elementError.focus(); //focus to first element is invalid
    }

    /**
     * [validateCurrentForm description]
     * change status fields is required
     * and update status icon success
     *
     * @author [someone, Kim Bang] [someone@httsolution.com, bang@httsolution.com]
     * @param  {[type]}  validate   [description]
     * @param  {Boolean} isNameStep [alias name of current tab (aliasname maybe page or block)]
     * @param  {[type]}  _variable  [description]
     * @param  {[type]}  _curValue  [description]
     * @return {[type]}             [description]
     */
    $scope.validateCurrentForm = function(validate, isNameStep, _variable, _curValue) {

        //check form detail is valid
        if (validate && $scope.indexCurrentTemplate == 1) {
            $scope.successForm[1] = false;
            return;
        }

        var _idTemplate = $scope.currentChosseTemplate;
        var _currentFieldTemplate = $scope.listFieldTemplateRequired[_idTemplate];

        
        switch(isNameStep) {
            case 'page':
                var _dataContentPage = $scope.contentPage['_' + _idTemplate];
                //check data content page with templateId
                if (angular.isDefined(_dataContentPage) && angular.isDefined(_dataContentPage['data']) && angular.isDefined(_dataContentPage['data']['fields'])) {

                    updateStatusFieldRequired(_idTemplate, _currentFieldTemplate, _dataContentPage['data']['fields']);
                }

                $scope.successField[_idTemplate] = true;

                checkFieldRequired(_currentFieldTemplate, _idTemplate, false, _idTemplate, 'template');

                break;
            case 'block':
                var _blockId = $scope.curSecIndex;

                var _currentFieldBlock = $scope.listFieldTemplateRequired[_idTemplate][_blockId];

                var _dataContentPage = $scope.contentPage['_' + _blockId];

                //check data content page with blockId
                if (angular.isDefined(_dataContentPage) && angular.isDefined(_dataContentPage['data']) && angular.isDefined(_dataContentPage['data']['fields'])) {

                    updateStatusFieldRequired(_blockId, _currentFieldBlock, $scope.contentPage['_' + _blockId]['data']['fields']);
                }

                $scope.successInject[_idTemplate][_blockId] = true;

                checkFieldRequired(_currentFieldBlock, _blockId, false, _idTemplate, 'block');

                break;
        }

        checkInvalidCurrentTemplate($scope.currentChosseTemplate);
    }

    /**
     * [checkInvalidCurrentTemplate description]
     * change icon success for tabs
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _templateId [description]
     * @return {[type]}             [description]
     */
    function checkInvalidCurrentTemplate(_templateId) {
        if (!$scope.successField[_templateId]) {
            $scope.successForm[_templateId] = false;
            return true;
        }

        //check current template is success?
        if (angular.isDefined($scope.listTemPlate[_templateId]['injects'])
            && Object.keys(angular.extend({}, $scope.listTemPlate[_templateId]['injects'])).length) {

            var listInjects = $scope.listTemPlate[_templateId]['injects'];

            for (var key in listInjects) {
                if (angular.isDefined($scope.successInject[_templateId]) && angular.isDefined($scope.successInject[_templateId][key])
                    && !$scope.successInject[_templateId][key]) {
                    
                    $scope.successForm[_templateId] = false;
                    return true;
                }
            }
        }

        $scope.successForm[_templateId] = true;
        $scope.warningError = false;
    }

    /**
     * [updateStatusFieldRequired description]
     * update status for fields is required when change data of field
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _id                         [description]
     * @param  {[type]} _listFieldRequired          [description]
     * @param  {[type]} _listFieldDataOfContentPage [description]
     * @return {[type]}                             [description]
     */
    function updateStatusFieldRequired(_id, _listFieldRequired, _listFieldDataOfContentPage) {

        if (angular.isDefined(_listFieldDataOfContentPage) && _listFieldDataOfContentPage) {

            for (var key in _listFieldRequired) {
                //check current value is array?
                if (Object.keys(angular.extend({}, _listFieldRequired[key])).length && key.indexOf('_' + _id) != -1
                    && angular.isDefined(_listFieldDataOfContentPage[key])) {
                    for (var keyField in _listFieldRequired[key]) {//passing each item in array and call back updateStatusFieldRequired function
                        updateStatusFieldRequired(_id, _listFieldRequired[key][keyField], _listFieldDataOfContentPage[key][keyField]);
                    }
                } else {
                    
                    //format date
                    if (angular.isDate(_listFieldDataOfContentPage[key])) {
                        _listFieldDataOfContentPage[key]= $filter('date')(_listFieldDataOfContentPage[key], 'yyyy-MM-dd');
                    }
                    if ((typeof  _listFieldRequired[key] != 'object' && typeof _listFieldRequired[key] != 'array') || angular.isDate(_listFieldRequired[key])) {
                        // console.log('_listFieldDataOfContentPage', _listFieldDataOfContentPage);
                        //check exit data current fild in content page
                        if (angular.isDefined(_listFieldDataOfContentPage[key]) && (_listFieldDataOfContentPage[key] || _listFieldDataOfContentPage[key] == 0)) {
                            _listFieldRequired[key] = false;
                        } else {
                            var _idTemplate = $scope.currentChosseTemplate;
                            var _currentTermTemlate = $scope.listTemPlate[_idTemplate]['term'];
                            //check field valide of template or block belong to current template
                            //if current field data not in content page, check current field is required?
                            if (angular.isDefined(_currentTermTemlate)) {
                                if (angular.isDefined(_currentTermTemlate[_idTemplate]) && angular.isDefined(_currentTermTemlate[_idTemplate][key])
                                    && _currentTermTemlate[_idTemplate][key]) {

                                    _listFieldRequired[key] = true;
                                } else if (angular.isDefined(_currentTermTemlate[_id]) && angular.isDefined(_currentTermTemlate[_id][key])
                                    && _currentTermTemlate[_id][key]) {

                                    _listFieldRequired[key] = true;
                                }
                            }
                        }
                    }
                }
            }
        }
        return _listFieldRequired;
    }

    /**
     * [checkMinimunCurFields description]
     * check minimum field of current template
     * apply for templates contant field foreach
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _listFields [description]
     * @param  {[type]} _id         [description]
     * @param  {[type]} _status     [description]
     * @param  {[type]} _idTemplate [description]
     * @return {[type]}             [description]
     */
    function checkMinimunCurFields(_listFields, _id, _status, _idTemplate) {
        if (typeof _listFields != 'undefined' && _listFields.length > 0) {

            var _tmpId = $scope.currentChosseTemplate;//id template or block belong to template

            if (typeof _id != 'undefined') {
                _tmpId = _id;
            }

            $scope.listErrorListFile = [];

            if (angular.isDefined(_listFields)) {
                for (var key in _listFields) {
                    var _variable = '_' + _tmpId + '_' + _listFields[key].variable;

                    //check current field is muulple?
                    if (_listFields[key].multiple) {

                        //check current field of template is multiple
                        if ((angular.isUndefined($scope.countFieldsOfMultiField[_variable]) || $scope.countFieldsOfMultiField[_variable] < _listFields[key].min_field)
                           && _listFields[key].min_field > 0) {

                            if (angular.isUndefined($scope.countFieldsOfMultiField[_variable])) {
                                var fieldMultiple = (angular.isDefined(_idTemplate))?$scope.listFieldTemplateRequired[_idTemplate][_tmpId][_variable]:$scope.listFieldTemplateRequired[_tmpId][_variable];
                                if (Object.keys(angular.extend({}, fieldMultiple)).length
                                    && Object.keys(angular.extend({}, fieldMultiple)).length >= _listFields[key].min_field) {

                                    return false;
                                }
                            }

                            $scope.listErrorListFile.push('Please, add minimum '+ _listFields[key].min_field + ' field '+ _listFields[key].name);

                            $timeout(function() {
                                if (_tmpId != $scope.currentChosseTemplate && angular.isDefined(_tmpId)) {
                                    $scope.isDetails = false;
                                    $scope.hasInjectFocus = _tmpId;
                                }

                                //forcus to tab error
                                if (angular.isDefined(_idTemplate)) {
                                    angular.element('#populate_' + _idTemplate).trigger('click');
                                } else {
                                    angular.element('#populate_' + _tmpId).trigger('click');
                                }
                                
                                $('body').scrollTop($('#btnSubmitButton').offset().top);
                            })

                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * [checkMinimumFieldOfTemplate description]
     * passing each all template of page and check minimum field of template contant field multiple
     *
     * @author [Kim bang] [bang@httsolution.com]
     * @param  {[type]} _status [description]
     * @return {[type]}         [description]
     */
    function checkMinimumFieldOfTemplate(_status) {
        var status = false;
        for (var key in $scope.listTemPlate) {
            status = checkMinimunCurFields($scope.listTemPlate[key].fields, key, _status);
            if (!status && typeof $scope.listTemPlate[key].injects != 'undefined') {
                for (var keyInject in $scope.listTemPlate[key].injects) {
                   status = checkMinimunCurFields($scope.listTemPlate[key].injects[keyInject].fields, keyInject, _status, key);

                   if (status) {
                        return status;
                   }
                }
            } else if(status) {
                return status;
            }
        }
        return status;
    }

    //init codemirror
    $scope.initCodeMirror = function () {
        $scope.codeMirrorInited = true;
        $timeout(function () {
            $scope.editableCodeMirror = CodeMirror.fromTextArea(document.getElementById('editor'), {
                mode:  "htmlmixed",
                theme: "night",
                styleActiveLine: true,
                lineNumbers: true,
                readOnly: $scope.isDisable
            });

            $scope.editableCodeMirror.on("change", function() {
                $timeout(function() {
                    $scope.$apply(function() {
                        var _templateId = (angular.isDefined($scope.currentChosseTemplate)) ? $scope.currentChosseTemplate : $scope.page.template;

                        //check exist content section of current template
                        if (angular.isUndefined($scope.content[_templateId])) {
                            $scope.content[_templateId] = {};
                        }

                        //check current variable of section is empty?
                        if (angular.isDefined($scope.secVariable)) {
                            $scope.content[_templateId][$scope.secVariable] = $scope.editableCodeMirror.getValue();
                        }
                    });
                });
            });
        });
    }

    var opened = false;
    /* When user click insert link */
    $scope.callModalInsert = function (typeInsert, language, region, page) {
        /* Call Modal Popup To Insert With Input Type */
        if (opened) return;
        var teamplate = '/cms/block-manager/insert' + '?language=' + language + '&&region=' + region + '&&type=' + typeInsert + '&&site=' + page + '&&id=';
        var modalInstance = $modal.open({
                templateUrl: window.baseUrl + teamplate,
                controller: 'ModalInsertCms',
                size: undefined,
                resolve: {
                    language: function() {
                        return null;
                    },
                    region: function() {
                        return null;
                    },
                }
            });
        opened = true;
        modalInstance.result.then(function (data) {
            opened = false;
            $timeout(function() {
                //insert content to codemirror
                $scope.editableCodeMirror.replaceSelection(data);

            });
        },function () {
            console.info('Modal dismissed at: ' + new Date());
            opened = false;
        });
    }

    $scope.content = angular.copy(window.contents);

    var contructDefaultVal = function(templates, count) {
        if (angular.isUndefined($scope.page)) {
            $scope.page = {};
        }

        for (var _key in templates) {
            //check current template is exist fields, injects, sections?
            if (templates[_key].fields && templates[_key].fields.length || templates[_key].sections.length 
                || checkValidFieldOfInject(templates[_key].injects)) {
                //check and contruct onject successInject
                if (angular.isUndefined($scope.successInject[_key])) {
                    $scope.successInject[_key] = {};
                }

                count ++;

                getInjectsHasField(templates[_key], 'create', _key, 0);

                $scope.extendsTemplate[count] = _key;

                $scope.listTemPlate[_key]['stepTemplate'] = count;
            }
        }
        $scope.lastTemplate = count;
    }

    /**
     * save page's content
     *
     * @auther linh@httsolution.com, bang@httsolution.com
     *
     * @author edit: Quang <quang@httsolution.com>
     *
     * @param  {validate} validate form validate
     *
     */    
    $scope.submit = function (validate)
    {
        $scope.warningError = false;
        $scope.pageNameUnique = false;
        $scope.pageUrlUnique = false;
        $scope.errorTypeUrl = false;

        $scope.submitted  = true;

        if (typeof $scope.page.template != 'undefined') {

            /* if the user has not entered enough information then return */
            if (validate || $scope.checkWhenSavePreview() || $('.exits-required').length > 0) {
                if (validate) {
                    //function
                    expandBlockElementError();
                } else {
                    //function
                    focusFieldError();
                }
                
                $scope.warningError = true;
                return;
            }

            //check field of template in page is valid?
            if (getTemplateInvalid($scope.listTemPlate, true)) {
                $scope.warningError = true;
                return;
            }
        } else {
            if ($scope.formData.name.$error.required || $scope.formData.url.$error.required) {
                $(".ng-invalid:eq(5)").focus();
                $scope.warningError = true;
                return;
            }
        }

        $scope.page.url = $scope.page.url.trim();

        //validate url
        var checkUrl = validateUrl($scope.page.url);

        if (checkUrl) {
            $scope.errorTypeUrl = true;
            $('form[name="formData"]').find('.ng-invalid:eq(0)').focus();
            $scope.warningError = true;
            return;
        }



        if (typeof $scope.page.parent_id =="undefined") {
             $('form[name="formData"]').find('.ng-invalid:eq(0)').focus();
            $scope.page.parent_id='0';
        }

        if (checkMinimumFieldOfTemplate()) {
            $scope.warningError = false;
            return;
        }

        $('#btnSubmitButton').attr('disabled', 'true');
        //set section for page
        // $scope.page.sections = (angular.isArray($scope.content[$scope.page.template]))?angular.extend({},$scope.content[$scope.page.template]):$scope.content[$scope.page.template];
        getSectionFollowIdTemplate();
        
        var data = angular.copy($scope.page);

        var dataNestedBlock = angular.copy($scope.nested_block);
        
        data['nestedContent'] = (function formatData(dataNestedBlock) {//convent array data to object
            for (var i in dataNestedBlock) {
                if (angular.isDate(dataNestedBlock[i])) {
                    dataNestedBlock[i] = $filter('date')(dataNestedBlock[i], 'yyyy-MM-dd');
                } else {
                    if (typeof dataNestedBlock[i] == 'object' || typeof dataNestedBlock[i] == 'array') {
                        dataNestedBlock[i] = angular.extend({}, dataNestedBlock[i]);
                        formatData(dataNestedBlock[i]);
                    }
                }
            }

            return dataNestedBlock;
        })(dataNestedBlock);

        data['contentPage'] = $scope.contentPage;

        //Save page's content
        EditDraftService.editDraft(data).then(function (data) {

            if (!data['status']) {

                $('#btnSubmitButton').removeAttr('disabled');
                if (data['name']) {
                    $scope.pageNameUnique = true;
                }
                if (data['url']) {
                    $scope.pageUrlUnique = true;
                }

            } else {

                if ($scope.checkPage) {
                    $window.location = $scope.baseUrl + '/cms/pages/set-page-selected/' + $scope.page.parent_id;
                } else {
                    $window.location = $scope.baseUrl + '/support/show/' + $scope.page['ticket_id'];
                }        
                // RemoveCacheService.removeCache($scope.page.content_id).then(function(){
                // });
            }
        });
    };

    //set sections to templates follow template id
    function getSectionFollowIdTemplate() {
        for (var key in $scope.content) {
            if (angular.isDefined($scope.contentPage['_' + key]) && angular.isDefined($scope.contentPage['_' + key]['data'])) {
                if (angular.isUndefined($scope.contentPage['_' + key]['data']['sections'])) {
                    $scope.contentPage['_' + key]['data']['sections'] = {};
                }

                $scope.contentPage['_' + key]['data']['sections'] = angular.extend({}, $scope.content[key]);
            }
        }
    }

    function validateUrl (url) { 
        //check special character
        var pattSpecial = /[^a-zA-Z0-9\/\-]/g;
        var check = pattSpecial.test(url);
        if (!check) {
            //check bouble / or double -
            var pattDouble = /\/{2,}|\-{2,}/g;
            check = pattDouble.test(url);
        }        

        return check;
    }

    /*
     * check minimum field of field multiple
     *
     * @author [Kim Bang] <bang@httsolution.com>
     *
     */
    function checkMinimumField(fields, _id) {
        var id = $scope.currentChosseTemplate;
        if (typeof _id != 'undefined') {
            id = _id;
        }

        $scope.listErrorListFile = [];

        /*get lists field of current template*/
        var curTemp = fields;

        if (angular.isDefined(curTemp)) {
            for (var i in curTemp) {
                var _variable = '_' + id + '_' + curTemp[i].variable;

                //check current field is muulple?
                if (curTemp[i].multiple) {

                    if ((angular.isUndefined($scope.countFieldsOfMultiField[_variable]) || $scope.countFieldsOfMultiField[_variable] < curTemp[i].min_field)
                       && curTemp[i].min_field > 0) {

                        $scope.listErrorListFile.push('Please, add minimum '+ curTemp[i].min_field + ' field '+ curTemp[i].name);

                        $timeout(function() {
                            if (id != $scope.currentChosseTemplate && angular.isDefined(id)) {
                                $scope.isDetails = false;
                                $scope.hasInjectFocus = id;
                            }

                            angular.element('#populate_' + $scope.currentChosseTemplate).trigger('click');
                            // $('body').scrollTop($('#btnSubmitButton').offset().top);
                        })

                        return true;
                    }
                }
            }
        }

        return false;
    }

    $scope.cancel = function ()
    {
        $window.location = '/cms/pages';
    }

    $scope.url = [];
    /**
     * GET URL SHOW IMAGE
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    $scope.getUrlImageAsset = function(id) {

        AssetManagerService.getUrlImageAsset(id).then(function (data) {

            if (typeof $scope.url[id] == 'undefined') {
                $scope.url[id] = data['url']; // return url image not multi
            }
        })

    }
    /**
     * remove current thumb nail assert
     * @param  {[type]} id       [description]
     * @param  {[type]} variable [description]
     * @param  {[type]} index    [description]
     * @return {[type]}          [description]
     */
    $scope.removeThumbnailAssert = function(id, variable, index) {

        $scope.url[id] = '';

        if (typeof index != 'undefined') {

            // $scope.page.fields[variable][index] = null; // remove thumbnail multi

        }else{

            // $scope.page.fields[variable] = null;// remove thumbnail not multi
        }

    }
    /*
     * add new field, apply for fields are multiple
     *
     * @author [Kim Bang] <bang@httsolution.com>
     *
     */
    $scope.addNewField = function(curField, blockId) {

        $('#page-loading').css('display', 'block');

        var id = $scope.currentChosseTemplate;
        if (typeof blockId != 'undefined') {
            id = blockId;
        }

        $scope.listErrorListFile = [];

        var maxIndex = 0;
        var checkMaxField = 0;

        var _variable = '_' + id + '_' + curField.variable;

        /**/
        if (angular.isDefined($scope.multiFieldFollowVariable[_variable]) && $scope.multiFieldFollowVariable[_variable].length) {

            for (var i in $scope.multiFieldFollowVariable[_variable]) {

                if ($scope.multiFieldFollowVariable[_variable][i].id == curField.variable + '___' + $scope.multiFieldFollowVariable[_variable][i].key_field) {

                   checkMaxField +=1;

                   if ($scope.multiFieldFollowVariable[_variable][i].key_field > maxIndex) {

                        maxIndex =  $scope.multiFieldFollowVariable[_variable][i].key_field;
                   }
                }
            }
        }
        
        /*check maximum fields number, apply for fields multiple*/
        if (checkMaxField >= curField.max_field && curField.max_field) {
            alert('Maximum '+curField.name+' field is '+curField.max_field);
            $('#page-loading').css('display', 'none');
            return
        }

        maxIndex = (checkMaxField > 0)?parseInt(maxIndex) + 1:0;

        //function
        updateListMultipleFieldWithId(curField, id, _variable, maxIndex, blockId);

        getTemplateInvalid($scope.listTemPlate, false);

        if(!angular.element('#parentBlock_' + curField.variable).hasClass('in')) {
            angular.element('#action-' + curField.variable).trigger('click');
        }

        $('#page-loading').css('display', 'none');
    }

    /**
     * [updateListMultipleFieldWithId description]
     * update list content for field foreach
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} curField  [description]
     * @param  {[type]} id        [description]
     * @param  {[type]} _variable [description]
     * @param  {[type]} maxIndex  [description]
     * @param  {[type]} blockId   [description]
     * @return {[type]}           [description]
     */
    function updateListMultipleFieldWithId(curField, id, _variable, maxIndex, blockId) {
        if (angular.isUndefined($scope.multiFieldFollowVariable[_variable])) {
            $scope.multiFieldFollowVariable[_variable] = [{'id':curField.variable + '___' + maxIndex, 'key_field':maxIndex}];

            if ($scope.currentChosseTemplate == id) {
                $scope.listFieldTemplateRequired[$scope.currentChosseTemplate][_variable][maxIndex] = getListFieldRequired(curField['option_id']);
            } else {
                $scope.listFieldTemplateRequired[$scope.currentChosseTemplate][blockId][_variable][maxIndex] = getListFieldRequired(curField['option_id'], blockId);
            }

            updateFieldsOfMuitiField('add', _variable);
        } else {

            $scope.multiFieldFollowVariable[_variable].push({'id':curField.variable + '___' + maxIndex, 'key_field':maxIndex});

            if ($scope.currentChosseTemplate == id) {
                $scope.listFieldTemplateRequired[$scope.currentChosseTemplate][_variable][maxIndex] = getListFieldRequired(curField['option_id']);
            } else {                
                $scope.listFieldTemplateRequired[$scope.currentChosseTemplate][blockId][_variable][maxIndex] = getListFieldRequired(curField['option_id'], blockId);
            }

            updateFieldsOfMuitiField('add', _variable);
        }
    }

    /**
     * [getListFieldRequired description]
     * get list field and required value field of block belong to current field with option_id
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _optionId [description]
     * @return {[type]}           [description]
     */
    function getListFieldRequired(_optionId, _blockId) {
        if (typeof _blockId == 'undefined') {
            var _term = $scope.listTemPlate[$scope.currentChosseTemplate].term[$scope.currentChosseTemplate];
        } else {            
            var _term = $scope.listTemPlate[$scope.currentChosseTemplate].term[_blockId];
        }

        var arrayField = [];

        for (var key in _term) {
            //check and get fields of block belong to current field with option id
            if (key.indexOf(_optionId) != -1) {
                arrayField[key] = _term[key];
            }
        }

        return angular.extend({},arrayField);//convent to object
    }

    /**
     * [removeCurrentField description]
     *
     * apply for fields are multiple
     *
     * @author [Kim Bang] <bang@httsolution.com>
     *
     * @param  {[type]} curField [current field]
     * @param  {[type]} index    [location of field]
     *
     * @return {[type]} void         [description]
     */
    $scope.removeCurrentField = function(curField, index, blockId) {

        // var status = confirm('All Nesteds will be lost if the page delete is changed. Do you want to proceed?');

        var id = $scope.currentChosseTemplate;
        
        if (typeof blockId != 'undefined') {
            id = blockId;
        }
        $scope.listErrorListFile = [];

        var _variable = '_' + id + '_' + curField.variable;

        var curVal = angular.copy($scope.multiFieldFollowVariable[_variable]);

        //check exist item in array value of current field content foreach
        if (angular.isDefined(curVal) && curVal.length) {

            for (var i in curVal) {

                //check exist current field?
                if (curVal[i].key_field == index && curVal[i].id == curField.variable + '___' + curVal[i].key_field) {

                    //function
                    removeDataContentPageWithIndex(id, curVal[i].key_field, _variable, function() {
                        updateFieldsOfMuitiField('remove', _variable);

                        $scope.multiFieldFollowVariable[_variable].splice(curVal[i].key_field, 1);

                        for (var curKey in $scope.multiFieldFollowVariable[_variable]) {
                            //update index current array value
                            if ($scope.multiFieldFollowVariable[_variable][curKey]['key_field'] > curVal[i].key_field) {
                                $scope.multiFieldFollowVariable[_variable][curKey] = {'id':curField.variable + '___' + curKey, 'key_field':curKey};
                            }
                        }

                        //function
                        removeNestedBlockWithIndex(id, curField.variable, curVal[i].key_field);
                        // reIndex(index, blockId, curField.variable, curField.option_id);

                        removeItemInListFieldRequiredWithIdex(id, curVal[i].key_field, _variable, blockId);// function
                    });

                    break;
                }
            }
        }

    }

    /**
     * [removeDataContentPageWithIndex description]
     * remove current data content page with index (current localtion of field when delete)
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]}   _currentId [description]
     * @param  {[type]}   _index     [description]
     * @param  {Function} callback   [description]
     * @return {[type]}              [description]
     */
    function removeDataContentPageWithIndex(_currentId, _index, _variable, callback) {
        //check exist item and remove item of current field and update list field multiple
        if (angular.isDefined($scope.contentPage['_' + _currentId]) && angular.isDefined($scope.contentPage['_' + _currentId]['data'])
            && angular.isDefined($scope.contentPage['_' + _currentId]['data']['fields'])
            && angular.isDefined($scope.contentPage['_' + _currentId]['data']['fields'][_variable])) {

            var listValueField = angular.copy($scope.contentPage['_' + _currentId]['data']['fields'][_variable]);

            listValueField = angular.extend({}, listValueField);
            
            var listKeyObject = Object.keys(listValueField);
            
            if (listKeyObject.length == 1 || listKeyObject[listKeyObject.length - 1] == _index) {
                delete listValueField[_index];
            } else {
                for (var keyItem in listValueField) {
                    if (parseInt(keyItem) > parseInt(_index) && angular.isDefined(listValueField[keyItem])) {
                        listValueField[keyItem - 1] = angular.copy(listValueField[keyItem]);
                        delete listValueField[keyItem];
                    }
                }
            }

            $scope.contentPage['_' + _currentId]['data']['fields'][_variable] = listValueField;
        }

        callback.call();
    }

    /**
     * [removeNestedBlockWithIndex description]
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _currentId [description]
     * @param  {[type]} _variable  [variable of foreach field]
     * @param  {[type]} _index     [description]
     * @return {[type]}            [description]
     */
    function removeNestedBlockWithIndex(_currentId, _variable, _index) {
        var _currentDataNested = $scope.nested_block[_currentId];
        if (typeof _currentDataNested != 'undefined' && typeof _currentDataNested[_variable] != 'undefined') {

            var _dataNestedWithIndex = angular.copy(_currentDataNested[_variable]);

            if (typeof _dataNestedWithIndex.length == 'undefined') {
                for (var key in _dataNestedWithIndex) {
                    if (parseInt(key) > parseInt(_index) && typeof _dataNestedWithIndex[key] != 'undefined') {
                        _dataNestedWithIndex[key - 1] = angular.copy(_dataNestedWithIndex[key]);
                        delete _dataNestedWithIndex[key];
                    } else if (parseInt(key) == parseInt(_index) && typeof _dataNestedWithIndex[_index] != 'undefined') {
                        delete _dataNestedWithIndex[_index];
                    }
                }
            } else {
                _dataNestedWithIndex.splice(_index, 1);
            }

            $scope.nested_block[_currentId][_variable] = _dataNestedWithIndex;
        }
    }

    /**
     * [removeItemInListFieldRequiredWithIdex description]
     * remove list array value of current field required of template with index (current localtion of field when delete)
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _currentId [description]
     * @param  {[type]} _index     [description]
     * @param  {[type]} _variable  [description]
     * @param  {[type]} _blockId   [description]
     * @return {[type]}            [description]
     */
    function removeItemInListFieldRequiredWithIdex(_currentId, _index, _variable, _blockId) {

        //contant list array value field of current tempalte
        var _currentItem = $scope.listFieldTemplateRequired[$scope.currentChosseTemplate];

        //check and remove a child array belong to current field
        if (angular.isDefined(_currentItem)
            && (angular.isDefined(_currentItem[_variable]) 
            || angular.isDefined(_currentItem[_blockId][_variable]))) {

            if ($scope.currentChosseTemplate == _currentId) {
                //convent array to object
                var chilArrayValueFieldRequired = angular.extend({}, _currentItem[_variable]);
            } else {
                var chilArrayValueFieldRequired = angular.extend({}, _currentItem[_blockId][_variable]);
            }


            var listKeyObject = Object.keys(chilArrayValueFieldRequired);

            if (listKeyObject.length == 1 || listKeyObject[listKeyObject.length - 1] == _index) {
                delete chilArrayValueFieldRequired[_index];
            } else {
                for (var _key in chilArrayValueFieldRequired) {
                    if (parseInt(_key) > parseInt(_index) && angular.isDefined(chilArrayValueFieldRequired[_key])) {
                        chilArrayValueFieldRequired[_key - 1] = angular.copy(chilArrayValueFieldRequired[_key]);
                        delete chilArrayValueFieldRequired[_key];
                    }
                }
            }

            //check current item was deleted belong to template or block?
            if ($scope.currentChosseTemplate == _currentId) {
                _currentItem[_variable] = chilArrayValueFieldRequired;
            } else {
                _currentItem[_blockId][_variable] = chilArrayValueFieldRequired;
            }

            getTemplateInvalid($scope.listTemPlate, false);
        }
    }

    /**
     * reIndex block nested
     * @param  {[type]} index       [description]
     * @param  {[type]} blockId     [description]
     * @param  {[type]} variable    [description]
     * @param  {[type]} optionBlock [description]
     * @return {[type]}             [description]
     */
    // var reIndex = function(index, blockId, variable, optionBlock) {

    //     var data = {'contentId': $scope.page.content_id,'index': index, 'blockId' : blockId, 'option_block' : optionBlock};
    //     // copy block in variable
    //     var listValueFieldN = angular.extend({}, $scope.nested_block[blockId][variable]);
    //     // call serve reIndex 
    //     // BlockNestedService.reIndex(data).then(function(data) {

    //         for(var key in listValueFieldN) {

    //             if(listValueFieldN[key]['index'] > index) {
    //                 listValueFieldN[key]['index'] = listValueFieldN[key]['index'] - 1;
    //             }
    //             if(key == index) {
                    
    //                 delete listValueFieldN[index];
    //             }
    //         }

    //         $scope.nested_block[blockId][variable] = angular.copy(listValueFieldN);
    //     // })        

    // }

    $scope.removeNestedContent = function(id, _tabId, _indexParent, _variable, _indexNested)
    {
        var status = confirm('Would you like to delete the  nested block?');
        showLoadingPage();
        if (status) {

            BlockNestedService.deleteContentNestedBlock(id).then(function (data){
                //check exist data of current nested block?
                if (data.status && angular.isDefined($scope.nested_block[_tabId]) && angular.isDefined($scope.nested_block[_tabId][_variable])
                    && angular.isDefined($scope.nested_block[_tabId][_variable][_indexParent])
                    && angular.isDefined($scope.nested_block[_tabId][_variable][_indexParent][_indexNested])) {

                    var listValueFieldN = angular.extend({}, $scope.nested_block[_tabId][_variable][_indexParent]);
                    delete listValueFieldN[_indexNested];

                    $scope.nested_block[_tabId][_variable][_indexParent] = angular.copy(listValueFieldN);
                    reSortNumber(_tabId, _variable, _indexParent, _indexNested);

                    //format field is object date
                    if (angular.isDefined($scope.nested_block) && Object.keys($scope.nested_block).length) {
                        formatDateValueNestedContent($scope.nested_block);
                    }

                    hideLoadingPage();
                }
            });
        }
    }

    /*
     * update (add or remove) field number for multiple fields
     *
     * @author [Kim Bang] <bang@httsolution.com>
     *
     * @action add or remove
     * @variable variable of fields
     */
    function updateFieldsOfMuitiField(action, variable) {
        if (angular.isDefined($scope.countFieldsOfMultiField[variable])) {
            switch(action) {
                case 'add':
                    $scope.countFieldsOfMultiField[variable] += 1;
                    break;
                case 'remove':
                    if (angular.isDefined($scope.countFieldsOfMultiField[variable]) && $scope.countFieldsOfMultiField[variable] > 0) {
                        $scope.countFieldsOfMultiField[variable] -= 1;
                        break;
                    }
            }
        } else {
            $scope.countFieldsOfMultiField[variable] = 1;
        }
    }

    /*
    * preview draff
    *
    * @author [Kim Bang] <bang@httsolution.com>
    *
    */
    $scope.previewDraff = function (validate) {

        $scope.warningError = false;
        // return;
        $scope.submitted  = false;

        if (getTemplateInvalid($scope.listTemPlate, true)) {
            $scope.warningError = true;
            return;
        }

        if (validate || $scope.checkWhenSavePreview()) {

            if (validate) {
                //function
                expandBlockElementError();
            } else {
                //function
                focusFieldError();
            }

            $scope.warningError = true;
            $scope.submitted  = true;

            return;
        }

        if (checkMinimumFieldOfTemplate()) {
            $scope.warningError = false;
            return;
        }

        //set section for page
        getSectionFollowIdTemplate();

        if (typeof $scope.page.parent_id =="undefined") {
            $scope.page.parent_id='0';
        }

        var data = angular.copy($scope.page);

        // data.fields = customFieldData(data.fields);

        if (angular.isDefined($scope.nested_block) && Object.keys($scope.nested_block).length) {
            formatDateValueNestedContent($scope.nested_block);
        }

        var dataNestedBlock = angular.copy($scope.nested_block);
        
        data['nestedContent'] = (function formatData(dataNestedBlock) {//convent array data to object
            for (var i in dataNestedBlock) {
                if (angular.isDate(dataNestedBlock[i])) {
                    dataNestedBlock[i] = $filter('date')(dataNestedBlock[i], 'yyyy-MM-dd');
                } else {
                    if (typeof dataNestedBlock[i] == 'object' || typeof dataNestedBlock[i] == 'array') {
                        dataNestedBlock[i] = angular.extend({}, dataNestedBlock[i]);
                        formatData(dataNestedBlock[i]);
                    }
                }
            }

            return dataNestedBlock;
        })(dataNestedBlock);

        data['contentPage'] = $scope.contentPage;

        EditDraftService.createDraftContentPreview(data,$scope.parents[$scope.page.parent_id]).then(function (data) {
            var url = $scope.baseUrl + '/cms/pages/preview-draft/' + $scope.page.content_id + '?v='+new Date().getTime();
            window.open(url);
        });

    }

        /**
     * [checkFieldRequired description]
     * check field of template of block belong to tempalte is valid?
     * and update status for tabs belong to template and current template
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _currentListField [lilst field of current template or block belong to template]
     * @param  {[type]} _key             [id of template or block]
     * @param  {[type]} _status          [use check and focus to tab error, if form invalid]
     * @param  {[type]} _idCurTemplate   [current id template]
     * @param  {[type]} _type            [type is template or block]
     * @return {[type]}                  [description]
     */
    function checkFieldRequired(_currentListField, _key, _status, _idCurTemplate, _type) {
        var hasFieldInvalid = false;
        (function callBack(_currentListField) {
            for (var _keyField in _currentListField) {

                //check current field is array?
                //and exist current field of template or block in _currentListField
                if (Object.keys(angular.extend({}, _currentListField[_keyField])).length && _keyField.indexOf(_key) != -1) {
                    // console.log(_keyField, '_keyFieldf');
                    for (var key in _currentListField[_keyField]) {
                        // console.log(key, 'key');
                        callBack(_currentListField[_keyField][key]);
                    }
                } else {
                    //check current field data in content page is valid and update status form and tab?
                    if (_currentListField[_keyField] == true) {

                        $scope.successForm[_idCurTemplate] = false;

                        //update status for tabs (of template or block belong to template)
                        if (_type != "block") {
                            $scope.successField[_idCurTemplate] = false;
                        } else {
                            $scope.successInject[_idCurTemplate][_key] = false; 
                        }

                        if (_status) {//if click button submit or preview, focus to field invalid (field of template)
                            $timeout(function() {
                                if (_type == 'block') {
                                    $scope.isDetails = false;
                                    $scope.hasInjectFocus = _key;
                                }

                                $('#populate_'+_idCurTemplate).trigger('click');
                            })
                            hasFieldInvalid = true;
                            return true;
                        }
                    }
                }
            }
        })(_currentListField)

        return hasFieldInvalid;
    }

    /**
     * [getTemplateInvalid description]
     * get template invalid (exist a field not valid)
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * 
     * @return {[type]} [description]
     */
    function getTemplateInvalid(_listTemplateOfPage, status) {
        for (var _key in _listTemplateOfPage) {//passing each template
            //check current template is valid?
            if (checkInvalidAndAcTiveTemplateError(_key, status)) {
                return true;
            }
        }

        if (Object.keys(angular.extend({}, _listTemplateOfPage)).length === 0) {
            $scope.successForm[$scope.currentChosseTemplate] = true;
        }

        return false;
    }

    /**
     * [checkInvalidAndAcTiveTemplateError description]
     * get template contant field is invalid and active tab error of current template
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * @param  {[type]} _templateId [description]
     * @return {[type]}             [description]
     */
    function checkInvalidAndAcTiveTemplateError(_templateId, status) {
        $scope.successField[_templateId] = true;
        var _currentTemplate = $scope.listTemPlate[_templateId];
        var _listFieldRequiredOfTemplate = $scope.listFieldTemplateRequired[_templateId];
            
        //check exist current template in list field required blong to tempaltes
        if (angular.isDefined(_listFieldRequiredOfTemplate)) {

            //check exist field invalid in current template?
            if (checkFieldRequired(_listFieldRequiredOfTemplate, _templateId, status, _templateId, 'template')) {
                checkInvalidCurrentTemplate(_templateId);
                return true;
            } else {

                var _listInject = _currentTemplate['injects'];

                //check current template exist inject?
                if (angular.isDefined(_listInject) && Object.keys(angular.extend({}, _listInject)).length) {
                    for (var _keyinject in _listInject) {

                        var _listFieldRequiredOfBlock = _listFieldRequiredOfTemplate[_keyinject];                        
                        $scope.successInject[_templateId][_keyinject] = true;
                        //check current block belong to template is valid?
                        if (angular.isDefined(_listFieldRequiredOfBlock)
                            && checkFieldRequired(_listFieldRequiredOfBlock, _keyinject, status, _templateId, 'block')) {
                            checkInvalidCurrentTemplate(_templateId);
                            return true;
                        }
                    }
                }
            }
        }

        checkInvalidCurrentTemplate(_templateId);
    }

    /**
     * [updateStatusFieldsRequired description]
     * update status for fields required
     *
     * @author [Kim Bang] [bang@httsolution.com]
     * 
     * @param  {[type]} _field             [current field of template]
     * @param  {[type]} _oldValueField     [value of field in content page]
     * @param  {[type]} _listFieldRequired [containt fields required and status]
     * @return {[type]} array              [description]
     */
    function updateStatusFieldsRequired(_field, _oldValueField, _listFieldRequired) {
        if (angular.isDefined(_listFieldRequired) && _listFieldRequired) {
            _listFieldRequired[_field.variable] = 0;

            //check current field data is valid?
            if (_field.required != 'false' && _field.required && (angular.isUndefined(_oldValueField)
                || !_oldValueField) && !_field.multiple) {

                _listFieldRequired[_field.variable] = 1;

            } else if(_field.required != 'false' && _field.required && _field.multiple && !_oldValueField.length) {

                _listFieldRequired[_field.variable] = 1;

            }
        }
        return _listFieldRequired;
    }

    /**
     * [addSubContentBlock description]
     * @param {[type]} _blockId [parent_id]
     * @param {[type]} _pageId  [contetn id of page]
     * @param {[type]} _tabId [current inject id]
     * @param {[type]} _language [description]
     * @param {[type]} _region   [description]
     * @param {[type]} _index   [description]
     */
    $scope.addSubContentBlock = function(_blockId, _tabId, _pageId, _language, _region, _index, _variable) {

        var teamplate = '/cms/block-manager/add-subblock-nested/'+ '?blockId= '+ _blockId +  '&&language=' + _language + '&&region=' + _region + '&v=' + new Date().getTime();
        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + teamplate,
            controller: 'addSubBlockNestedCtrl',
            size: null,
            resolve: {
                parent_id : function (){
                    return _blockId;
                },
                content_id : function (){
                    return _pageId;
                },
                variable : function (){
                    return _variable;
                },
                index : function (){
                    return _index;
                },
                tab_id : function (){
                    return _tabId;
                }
            }
        });

        modalInstance.result.then(function (data) {
            var countNested = 0;
            if(angular.isDefined($scope.nested_block[_tabId]) && angular.isDefined($scope.nested_block[_tabId][_variable])
             && angular.isDefined($scope.nested_block[_tabId][_variable][_index])) {

                countNested = $scope.nested_block[_tabId][_variable][_index].length;
            }
            data['template_id'] = $scope.page.template;
            data['count_nested'] = countNested;
            showLoadingPage();
            BlockNestedService.saveNestedBlock(data).then(function(data) {

                //check exist objects and declare
                if (angular.isUndefined($scope.nested_block[_tabId])) {

                    $scope.nested_block[_tabId] = [];
                }

                if (angular.isUndefined($scope.nested_block[_tabId][_variable])) {
    
                    $scope.nested_block[_tabId][_variable] = [];
                }

                if (angular.isUndefined($scope.nested_block[_tabId][_variable][_index]) || !$scope.nested_block[_tabId][_variable][_index]) {

                    $scope.nested_block[_tabId][_variable][_index] = [];
                }

                for (var i in data.block[_variable][_index]) {

                    data.block[_variable][_index][i]['data'] = angular.extend({}, data.block[_variable][_index][i]['data']);
                    $scope.nested_block[_tabId][_variable][_index][i] = data.block[_variable][_index][i];
                }
                $scope.cacheNestedContend[_tabId] = $scope.nested_block;

                hideLoadingPage();
            })
        })

    }

    var showLoadingPage = function() {
        angular.element('#page-loading').css('display', 'block');
    }

    var hideLoadingPage = function() {
        angular.element('#page-loading').css('display', 'none');
    }

}]).filter('formatName', function() {
    return function(text) {
        return String(text).replace(/\s+/g, "-");
    };
}).filter('formatText', function() {
    return function(input) {
        var text = input.replace(/_/gi, " ");
        return text[0].toUpperCase() + text.slice(1);
    }
}).controller('addSubBlockNestedCtrl', ['$scope', '$modalInstance', 'parent_id', 'content_id', 'tab_id', 'index', 'variable', 'EditDraftService','$http','$q', 
function ($scope, $modalInstance, parent_id, content_id, tab_id, index, variable, EditDraftService,$http,$q) {

    $scope.submit= function (block_id) {
        $scope.submitted = true ;
        if(!block_id){
            return;
        }
        var data = [];
        data.sub_block_id = block_id;
        data.parent_id = parent_id;
        data.content_id = content_id;
        data.tab_id = tab_id;
        data.index = index;
        data.variable = variable;
        $modalInstance.close(data);

    }

    $scope.cancel = function() {
        $modalInstance.dismiss('cancel');
    }
}]);