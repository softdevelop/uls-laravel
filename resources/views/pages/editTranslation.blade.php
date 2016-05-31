 
@extends('app')
@section('title')
    {{trans('cms_page/page-edit-translation.title')}}
@endsection
@section('content')

<div ng-controller="EditTranslationController" class="wrap-content-management p-20 hidden">

    <ul class="nav nav-tabs fix-normal top-tab" role="tablist">
        <li class="active">
            <a href="#Edit" ng-show ="isDisable"role="tab" data-toggle="tab">
                <i class="fa fa-list-alt"></i> {{trans('cms_page/page-edit-draft.page_build')}}
            </a>
             <a href="#Edit" ng-show ="!isDisable" role="tab" data-toggle="tab">
                <i class="fa fa-list-alt"></i> {{trans('cms_page/page-edit-draft.edit')}}
            </a>

        </li>
        <li>
            <a href="cms/pages/history/{{$content->_id}}">
                <i class="fa fa-file-code-o"></i> {{trans('cms_page/page-edit-draft.history')}}
            </a>
        </li>
        @if (\Auth::user()->can('manage_redirects'))
            <li>
                <a href="/cms/pages/redirect/{{$content->_id}}">
                    <i class="fa fa-file-code-o"></i> {{trans('cms_page/page-edit-draft.redirects')}}
                </a>
            </li>
        @endif
    </ul>
    <br>
    <div class="top-content">
        <label class="c-m">
            <a class="c-breadcrumb" href="@{{baseUrl}}/cms/pages">{{trans('cms_page/page-edit-translation.cms_page_manager')}}</a>
            @if(isset($breadcrumbData))
                @foreach($breadcrumbData as $key => $value)
                    <a class="c-breadcrumb" href="@{{baseUrl}}/cms/pages/set-page-selected/{{$value['_id']}}" target="_self" > / {{$value['name']}} </a>
                @endforeach
            @endif
            <span> / {{trans('cms_page/page-edit-translation.edit_translation')}} {{$page->name}}</span>
        </label>
    </div>
    <form role="form" name="formData" novalidate>
        <div ng-show="(pageOld.data.fields.length != 0 || pageOld.data.sections.length != 0 || pageOld.blockContent) && !isDisable" class="m-b-10">
            <a class="btn btn-primary" ng-click="export(pageOld)">
                <span class="fa fa-life-bouy"></span>
                {{trans('cms_page/page-edit-translation.export')}}
            </a>
            <a class="btn btn-primary" ng-model="fileImport" ngf-select ngf-accept="'.csv'" accept=".csv" ngf-reset-on-click="true" ngf-change="import(fileImport)">
                <span class="fa fa-plus"></span>
                {{trans('cms_page/page-edit-translation.import')}}
            </a>
        </div>
        <h2> @{{pageOld.languageName}} {{trans('cms_page/page-edit-translation.to')}}  @{{pageOld.translationTo}}</h2>  
        <ul id="mytab" class="nav nav-tabs" role="tablist">
            <li id="active-Page" class="active">
                <a href="#page" role="tab" data-toggle="tab" ng-click="showPage()">
                    <i class="fa fa-list-alt"></i> {{trans('cms_page/page-edit-translation.page')}}
                </a>
            </li>
            <li id="active-blocks" ng-if="!isDisable">
                <a href="#block" role="tab" data-toggle="tab" ng-click="showBlocks()">
                    <i class="fa fa-file-code-o"></i> {{trans('cms_page/page-edit-translation.blocks')}}
                </a>
            </li>

        </ul>
        <div class="tab-content fix-tab">
            <div ng-show="isShowPage">

                <div class="wrap-box-title" ng-repeat="field in listTemplate[currentChosseTemplate].fields" ng-init="key = currentChosseTemplate">
                    <label class="label-form">
                        <a data-toggle="collapse" id="action-@{{field.variable}}"  data-target="#template_@{{field.variable}}" class="capitalize accordion-toggle have-bg-grey">
                            <span class="f16">@{{field.name}} </span> <span ng-if="field.required && field.required !== 'false'" class="text-require"> *</span></span>&nbsp
                        </a>
                    </label>
                    <div id="template_@{{field.variable}}" class="collapse in">
                        <label ng-if ="!field.multiple">old :</label>
                        <label ng-if ="!field.multiple"> 
                            <!-- Handle map data option to get name of data option of field type is select -->
                            @include('pages.partial.fields.fieldSelect.select')
                            <!-- End Handle map data option to get name of data option of field type is select -->

                            <!-- Handle map data file to get file name of field type is file -->
                            @include('pages.partial.fields.fieldFile.file')
                            <!-- End Handle map data file to get file name of field type is file -->

                            <!-- Handle map asset file to get file name of field type is asset -->
                            @include('pages.partial.fields.fieldAsset.asset')
                            <!-- End Handle map asset file to get file name of field type is asset -->

                            <!-- Handle map link page to get name of field type is link -->
                            @include('pages.partial.fields.fieldLink.link')
                            <!-- End Handle map link page to get name of field type is link -->
                        </label>

                        <label ng-if ="!field.multiple && field.type!='select' && field.type!='file' && field.type!='asset' && field.type!='link' && field.type!='img_object'"> @{{pageOld.data.fields['_'+currentChosseTemplate+'_'+field.variable]}}</label>
                        
                        <div ng-if="field.form">
                            <div ng-if="!field.multiple && !isDisable">

                                <div class="wrap-form">
                                    <form-builder content="field.form"> </form-builder>
                                    <div class="m-t-30" >
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel panel-default have-border" ng-if="pageOld.data.fields['_'+currentChosseTemplate+'_'+field.variable]" ng-repeat="(key1, field_el) in multiFieldFollowVariable['_'+currentChosseTemplate+'_'+field.variable]">
                                <div class="panel-heading have-bg fix-height" role="tab">
                                    <h4 class="panel-title relative">
                                        <a data-toggle="collapse"  data-target=".blockid_@{{field.variable}}_@{{field_el.key_field}}" class="capitalize accordion-toggle">
                                            @{{field.name}} &nbsp
                                        </a>
                                    </h4>
                                </div>
                                <div id="blockid_@{{field.variable}}_@{{field_el.key_field}}"  class="p-20 collapse in bg-fff blockid_@{{field.variable}}_@{{field_el.key_field}}">

                                    @include('pages.partial.translation.old-field-multi')
                                    <div class="p-b-15" ng-if="!isDisable">
                                        <form-builder content="field.form"> </form-builder>
                                        <div class="m-t-30" >
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                    @include('pages.partial.translation.input-sub-content-block')

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div ng-if="!field.form && !isDisable" ng-init="currentTabId=currentChosseTemplate">
                            <div ng-if="listOutTypeMap[field.type] != 'select' && listOutTypeMap[field.type] != 'textarea'">
                                @include('pages.partial.fields.input-template')
                            </div>
                            <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[field.type] == 'select'">
                                @include('pages.partial.fields.select-template')
                            </div>
                            <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[field.type] == 'textarea'">
                                @include('pages.partial.fields.text-area-template')
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
                 <!-- show block fields -->
                <div class="form-group"  ng-repeat="(key, item) in listTemplate[currentChosseTemplate]['extends']">
                    <div class="wrap-box-title" ng-repeat="field in item.fields" >

                        <label class="label-form">
                            <a data-toggle="collapse"  data-target="#extends_@{{currentChosseTemplate}}_@{{key}}_@{{field.variable}}" class="capitalize accordion-toggle have-bg-grey">
                                <span class="f16">@{{field.name}} </span> <span ng-if="field.required && field.required !== 'false'" class="text-require"> *</span></span>&nbsp
                            </a>
                        </label>
                        <div id="extends_@{{currentChosseTemplate}}_@{{key}}_@{{field.variable}}" class="collapse in">
                            <label ng-if ="!field.multiple">old: </label>
                            <label ng-if ="!field.multiple"> @{{ pageOld.data.fields['_'+key+'_'+field.variable]}}</label>
                            <div ng-if="field.form ">
                                <div ng-if="!field.multiple && !isDisable">
                                    <label class="label-form" >
                                        <span>@{{field.name}} <span ng-if="field.required && field.required !== 'false'" class="text-require"> *</span></span>
                                    </label>
                                    <div class="wrap-form">
                                        <form-builder content="field.form"> </form-builder>
                                        <div class="m-t-30" ng-if="url[page.fields[field.variable]]">
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <div ng-if="pageOld.data.fields['_'+key+'_'+field.variable]">
                                    <div class="panel panel-default have-border" ng-repeat="(key1, field_el) in multiFieldFollowVariable['_'+key+'_'+field.variable]" ng-if="field.multiple && field_el.id == field.variable+field_el.key_field">
                                       <div class="panel-heading have-bg fix-height" role="tab">
                                            <h4 class="panel-title relative">
                                                <a data-toggle="collapse"  data-target=".extend_blockid_@{{field.variable}}_@{{field_el.key_field}}" class="capitalize accordion-toggle">
                                                    @{{field.name}}&nbsp
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="extend_blockid_@{{field.variable}}_@{{field_el.key_field}}"  class="p-20 collapse in bg-fff extend_blockid_@{{field.variable}}_@{{field_el.key_field}}">
                                            <div ng-if ="field.multiple">
                                                @include('pages.partial.translation.old-field-multi')
                                            </div>
                                            <div class="p-b-15" ng-if="!isDisable">
                                                <form-builder content="field.form"> </form-builder>
                                            </div>
                                            @include('pages.partial.translation.input-sub-content-block')
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div ng-if="!field.form && !isDisable" ng-init="currentTabId=key">
                                <div ng-if="listOutTypeMap[field.type] != 'select' && listOutTypeMap[field.type] != 'textarea'">
                                    @include('pages.partial.fields.input-template')
                                </div>
                                <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[field.type] == 'select'">
                                    @include('pages.partial.fields.select-template')
                                </div>
                                <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[field.type] == 'textarea'">
                                    @include('pages.partial.fields.text-area-template')
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group" ng-repeat="(key, item) in listTemplate[curIdTemplate].injects">
                    <div class="wrap-box-title" ng-repeat="field in item.fields" class="form-group">
                        <label class="label-form">
                            <a data-toggle="collapse" id="action-@{{key}}-@{{field.variable}}"  data-target="#block_inject_@{{curIdTemplate}}_@{{key}}_@{{field.variable}}" class="capitalize accordion-toggle have-bg-grey">
                                <span class="f16">@{{field.name}} </span> <span ng-if="field.required && field.required !== 'false'" class="text-require"> *</span></span>&nbsp
                            </a>
                        </label>
                        <div id="block_inject_@{{curIdTemplate}}_@{{key}}_@{{field.variable}}" class="collapse in">
                            <label ng-if="!field.multiple">@{{field.name}} {{trans('cms_page/page-edit-translation.old')}}: </label>
                            <!-- Handle map data option to get name of data option of field type is select -->
                            @include('pages.partial.fields.fieldSelect.select')
                            <!-- End Handle map data option to get name of data option of field type is select -->
                            <!-- Handle map data file to get file name of field type is file -->
                            @include('pages.partial.fields.fieldFile.file')
                            <!-- End Handle map data file to get file name of field type is file -->
                            <!-- Handle map asset file to get file name of field type is asset -->
                            @include('pages.partial.fields.fieldAsset.asset')
                            <!-- End Handle map asset file to get file name of field type is asset -->
                            <!-- Handle map link page to get name of field type is link -->
                            @include('pages.partial.fields.fieldLink.link')
                            <!-- End Handle map link page to get name of field type is link -->
                            <label ng-if ="!field.multiple && field.type!='select' && field.type!='file'"> @{{pageOld.data.fields['_'+key+'_'+field.variable]}}</label>
                            <div ng-if="field.form">
                                <div ng-if="!field.multiple && !isDisable">
                                    <label class="label-form" >
                                        <span>@{{field.name}} <span ng-if="field.required && field.required !== 'false'" class="text-require"> *</span></span>
                                    </label>
                                    <div class="wrap-form">
                                        <form-builder content="field.form"> </form-builder>
                                    </div>
                                </div>
                                <div ng-if="pageOld.data.fields['_'+key+'_'+field.variable]">
                                    <div class="panel panel-default have-border" ng-repeat="(key1, field_el) in multiFieldFollowVariable['_'+key+'_'+field.variable]" ng-if="field.multiple && field_el.id == field.variable+field_el.key_field">
                                        <div class="panel-heading have-bg fix-height" role="tab">
                                            <h4 class="panel-title relative">
                                                <a data-toggle="collapse"  data-target=".inject_blockid_@{{field.variable}}_@{{field_el.key_field}}" class="capitalize accordion-toggle">
                                                    @{{field.name}} &nbsp
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="p-20 collapse in bg-fff inject_blockid_@{{field.variable}}_@{{field_el.key_field}}">
                                            <div ng-if ="field.multiple">
                                                @include('pages.partial.translation.old-field-multi')
                                            </div>
                                            <div class="p-b-15" ng-if="!isDisable">
                                                <form-builder content="field.form"> </form-builder>
                                            </div>
                                            <div class="clearfix"></div>

                                            @include('pages.partial.translation.input-sub-content-block')

                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div ng-if="!field.form && !isDisable" ng-init="currentTabId = key">
                                <div ng-if="listOutTypeMap[field.type] != 'select' && listOutTypeMap[field.type] != 'textarea'">
                                    @include('pages.partial.fields.input-template')
                                </div>
                                <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[field.type] == 'select'">
                                    @include('pages.partial.fields.select-template')
                                </div>
                                <div id="field_@{{field._id.$id}}" ng-if="listOutTypeMap[field.type] == 'textarea'">
                                    @include('pages.partial.fields.text-area-template')
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Input Description-->
                <div class="wrap-box-title" ng-repeat="(key,value) in pageOld.data.sections" >
                    <label class="label-form">
                        <a data-toggle="collapse"  data-target="#section_@{{key}}" class="capitalize accordion-toggle have-bg-grey">
                            <span class="f16">@{{key}} </span>&nbsp
                        </a>
                    </label>
                    <div id="section_@{{key}}" class="collapse in">
                        <label class="label-form">@{{key}} {{trans('cms_page/page-edit-translation.old')}}:</label>
                        <label class="label-form" ng-bind-html="value" ></label>
                        <div class="clearfix"></div>
                        <div class="wrap-content-review-and-code" ng-show="!isDisable">
                            <div class="tab-content m-t--10">
                            
                                <div role="tabpanel" class="tab-pane in active padding-none">
                                    <label class="label-form">@{{key}}</label>
                                    <div class="wrap-form h300">
                                        <textarea class="form-control" rows="4" cols="50" name="editor" id="editor_@{{key}}"></textarea>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="wrap-link-input">
                                        <a class="link-insert-code" ng-click="callModalInsert(key,'insert-link', pageOld.language, pageOld.region,'page')">{{trans('cms_page/page-edit-translation.insert_link')}}</a> <span class="insert-object"> | </span>
                                        <a class="link-insert-code" ng-click="callModalInsert(key,'insert-block', pageOld.language == 'en'? null : pageOld.language, pageOld.region)">{{trans('cms_page/page-edit-translation.insert_block')}}</a> <span class="insert-object"> | </span>
                                        <a class="link-insert-code" ng-click="callModalInsert(key,'insert-asset', pageOld.language == 'en'? null : pageOld.language, pageOld.region)">{{trans('cms_page/page-edit-translation.insert_asset')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="space-error">
                                <small class="help-inline ng-invalid" ng-show="submitted && requiredEditorContent_@{{key}}">{{trans('cms_page/page-edit-translation.content')}} @{{key}} {{trans('cms_page/page-edit-translation.is_required_field')}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div ng-show="isShowBlocks">

                <div ng-repeat="(key, block) in blockTranslations">
                    <div class="wrap-content-review-and-code">
                        <div class="tab-content fix-tab m-t--10">
                            <div role="tabpanel" class="tab-pane in active">
                                <label class="label-form">@{{block.name}} <span class="text-require"> *</span></label>
                                <div class="wrap-form h300">
                                    <textarea class="form-control" rows="4" cols="50" name="editor" id="editor_@{{key}}"></textarea>
                                </div>
                                <div class="clearfix"></div>
                                <div class="wrap-link-input">
                                    <a class="link-insert-code" ng-click="callModalInsert(key,'insert-link', pageOld.language, pageOld.region,'page')">{{trans('cms_page/page-edit-translation.insert_link')}}</a> <span class="insert-object"> | </span>
                                    <a class="link-insert-code" ng-click="callModalInsert(key,'insert-block', pageOld.language == 'en'? null : pageOld.language, pageOld.region)">{{trans('cms_page/page-edit-translation.insert_block')}}</a> <span class="insert-object"> | </span>
                                    <a class="link-insert-code" ng-click="callModalInsert(key,'insert-asset', pageOld.language == 'en'? null : pageOld.language, pageOld.region)">{{trans('cms_page/page-edit-translation.insert_asset')}}</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="clearfix"></div>

                    <div class="space-error">
                        <small class="help-inline ng-invalid" ng-show="submitted && requiredEditorContent_@{{key}}">{{trans('cms_page/page-edit-translation.content')}} @{{block.name}} {{trans('cms_page/page-edit-translation.is_required_field')}}</small>
                    </div>
                </div>            
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="text-right" ng-if="!isDisable">
            <a  class="btn btn-default" href="@{{baseUrl}}/cms/pages/set-page-selected/@{{page.parent_id}}" target="_self">
                <i class="fa fa-times"></i> {{trans('cms_page/page-edit-translation.cancel')}}
            </a>
            <button class="btn btn-primary text-right" id="btnSubmit" ng-click="submit(formData.$invalid)"><i class="fa fa-check"></i> {{trans('cms_page/page-edit-translation.save')}}</button>
        </div>
    </form>
</div>
@stop

@section('script')
    <script type="text/javascript">
        window.baseUrl = '{{URL::to("")}}'
        window.content = {!!json_encode($content)!!}
        window.template = {!!json_encode($template)!!}
        window.listTemplate = {!!json_encode($listTemplate)!!}
        window.variableMapNameFieldsMulti = {!!json_encode($variableMapNameFieldsMulti)!!};
        window.page = {!!json_encode($page)!!}
        window.dataNestedOlds = {!! json_encode($dataNestedsOld) !!};
        window.dataNesteds = {!! json_encode($dataNesteds) !!};
        window.blockTranslations =  {!! json_encode($blockTranslations) !!};
        window.dataContentpage = {!! json_encode($dataContentpage) !!};
        window.contentPage = {!! json_encode($contentPage) !!};
        window.isDisable = {!! $isDisable !!};

        window.assets = {!!json_encode(getAssets())!!};
        window.listpages = {!!json_encode(listsPage($page->language, $page->region))!!};
        window.listsPageMap = {!!json_encode(listsPageMap())!!};
        window.listOutTypeMap = {!! json_encode(getListTypeMap()) !!}
        window.listCheckBoxMap = {!! json_encode(getListCheckBoxMap()) !!}
        window.listFileFollowId = {!! json_encode(listFileFollowId()) !!}
        window.listMapType = {!!json_encode(getMapTypeTCM())!!};
        window.listFileMapTranslate = {!!json_encode(getListFileMapTranslate())!!};
        window.listMapContentIdWithUrl = {!!json_encode(listMapContentIdWithUrl())!!};
        window.listsIdsMapPageAndContent = {!!json_encode(listIdsMapPageAndContent())!!};
        window.blockMapFileld = {!!json_encode(getListContentsBlock($page->language, $page->region))!!};
        window.blockCommentMap = {!! json_encode($blockCommentMap) !!};
        window.listAssetFolderContainFirstLevel = {!! json_encode($listAssetFolderContainFirstLevel) !!};
        window.listFilesFormBuilder = {!! json_encode(getFilesFormBuilder()) !!};
    </script>
    @if(!isProduction() && !isDev())
        {!! Html::script('/app/components/pages/EditTranslationController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/format-date/CheckLimitAndChangeDateTimeDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/partial/EditBlockController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/BlockManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages/EditDraftService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/shared/convent-text-to-lowercase/lowercase-character.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/partial/InsertBlockLinkAssetController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/cmsContentInsertService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/assetmanagers/AssetManagerService.js?v='.getVersionScript())!!}

        {!! Html::script('/app/components/pages/TranslationEditorService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/modal-select-level/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/modal-select-page/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/nested-block/BlockNestedService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/nested-block/BlockNestedController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level-asset/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/remove-cache-front-end/removeCacheService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/translation-editor.js') }}"></script>
    @endif

@stop
