@extends('app')
@section('title')
@if(empty($checkPage))
    {{trans('cms_page/page-edit-draft.title_draft')}}
@else
    {{trans('cms_page/page-edit-draft.title_page')}}
@endif
@endsection
@section('content')
<div ng-controller="EditDraftController" class="wrap-content-management  wrap-edit-pages hidden">
    <div class="top-content">
        <label class="c-m">

            <a ng-if="!checkPage" class="c-breadcrumb" href="@{{baseUrl}}/support/show/@{{page['ticket_id']}}" target="_self" >{{trans('cms_page/page-edit-draft.task')}}</a>

            <!-- / Edit Draft -->

            <span class="wrap-breadcrumb" ng-if="checkPage">
                <span class="breadcrumb-level">
                    <a class="c-breadcrumb" title="@{{baseUrl}}/cms/pages" href="@{{baseUrl}}/cms/pages">{{trans('cms_page/page-edit-draft.cms_page_manager')}}&nbsp;</a>
                </span>

                @if(isset($breadcrumbData))
                    @foreach($breadcrumbData as $key => $value)
                        <a class="c-breadcrumb" href="@{{baseUrl}}/cms/pages/set-page-selected/{{$value['_id']}}" target="_self" >/&nbsp;{{$value['name']}}&nbsp;</a>
                    @endforeach
                @endif

                <span class="breadcrumb-level">
                    <span ng-show ="!isDisable" title="{{$page->name}}"> / {{$page->name}} / {{trans('cms_page/page-edit-draft.edit')}}</span>
                    <span ng-show ="isDisable" title="{{$page->name}}"> / {{$page->name}} / {{trans('cms_page/page-edit-draft.page_build')}}</span>
                </span>

            </span>
        </label>

    </div>
    <div class="content st-container page-manager">
        <!-- Nav tabs -->
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
                <a href="cms/pages/history/@{{page.content_id}}">
                    <i class="fa fa-file-code-o"></i> {{trans('cms_page/page-edit-draft.history')}}
                </a>
            </li>
            @if (\Auth::user()->can('manage_redirects'))
                <li>
                    <a href="/cms/pages/redirect/@{{page.content_id}}">
                        <i class="fa fa-file-code-o"></i> {{trans('cms_page/page-edit-draft.redirects')}}
                    </a>
                </li>
            @endif
        </ul>

        <div class="tab-content fix-tab edit-page">
            <div class="tab-pane fade active in" id="Edit">
                <form role="form" name="formData" novalidate id="tesst">
                    <!-- Info, Template Extend -->
                    <tabset class="first">
                        <tab class="large-tab" ng-click="chooseDetails(formData.$invalid)" active="activeTemplate[1]">
                            <tab-heading class="thumbnail-page">
                                <figure>
                                    <span class="fa fa-info-circle f-80"></span>
                                </figure>

                                <span class="name">{{trans('cms_page/page-edit-draft.details')}}
                                  <i class="status ti-alert" ng-show="!successForm[1]"></i>
                                  <i class="fa fa-check-circle" ng-show="successForm[1]"></i>
                                </span>
                            </tab-heading>

                        </tab>

                        <tab ng-repeat="(key,value) in listTemPlate" ng-click="chooseCurrentTemplate(formData.$invalid, key, indexCurrentTemplate, value.stepTemplate)" active="activeTemplate[value.stepTemplate]" id="populate_@{{key}}" ng-if="value.fields.length || value.sections.length || existInjecIntTemplate[key]" class="large-tab">
                            <tab-heading class="thumbnail-page">
                                <figure>
                                    <img width="100%" ng-if="templates[key]['thumbnail'] != null" ng-src="/admin/file/@{{templates[key]['thumbnail']}}" alt="">
                                    <img width="100%" ng-if="templates[key]['thumbnail'] == null" ng-src="/thumbnail_default.jpg" alt="">
                                </figure>
                                <span class="name">@{{templates[key]['name']}}
                                  <i class="status ti-alert" ng-if="!successForm[key]"></i>
                                  <i class="fa fa-check-circle" ng-if="successForm[key]"></i>
                                </span>
                            </tab-heading>
                        </tab>

                    </tabset>

                    <tabset ng-show="!isDetails" class="child-tab">
                        <tab ng-click="chooseFields(formData.$invalid, indexCurrentTemplate)" ng-if="templates[currentChosseTemplate]['fields'].length > 0"  active="activeFields[indexCurrentTemplate]">
                            <tab-heading class="thumbnail-page box" ng-click="setDIVHeight()">
                                <span class="name">
                                  <i class="status ti-alert" ng-show="!successField[currentChosseTemplate]"></i>
                                  <i class="ti-check" ng-show="successField[currentChosseTemplate]"></i>
                                  {{trans('cms_page/page-edit-draft.fields')}}
                                </span>
                            </tab-heading>

                        </tab>
                        <tab ng-repeat="(keyInject, inject) in templates[currentChosseTemplate]['injects']" ng-click="chooseInject(formData.$invalid, keyInject, indexCurrentTemplate)" ng-if="templates[currentChosseTemplate]['injects'] && exitsFieldBlock[keyInject]" id="injects_@{{keyInject}}" active="activeBlocks[keyInject+indexCurrentTemplate]" >
                            <tab-heading class="thumbnail-page box" ng-click="setDIVHeight()">
                                <span class="name">
                                  <i class="status ti-alert" ng-show="!successInject[currentChosseTemplate][keyInject]"></i>
                                  <i class="ti-check" ng-show="successInject[currentChosseTemplate][keyInject]"></i>
                                  @{{inject.name}}
                                </span>
                            </tab-heading>
                        </tab>

                        <tab ng-repeat="section in templates[currentChosseTemplate]['sections']" ng-click="chooseSection(formData.$invalid, section.variable, section._id, indexCurrentTemplate)" ng-if="templates[currentChosseTemplate]['sections'].length > 0">
                          <tab-heading class="thumbnail-page box" ng-click="setDIVHeight()">
                                <span class="name">
                                  <!-- <i class="status ti-alert" ng-show="!successSection[indexCurrentTemplate][section._id]"></i>
                                  <i class="ti-check" ng-show="successSection[indexCurrentTemplate][section._id]"></i> -->
                                  @{{section.name}}
                                </span>
                          </tab-heading>
                        </tab>
                    </tabset>
                    <!-- show page detail -->
                    @include('pages.partial.pages-detail')
                    <!-- end show page detail -->

                    <!-- show extend template fields -->
                    <div ng-if="isShowField"  ng-repeat="field in templates[currentChosseTemplate].fields">
                        <input type="hidden" class="hidden" name="" ng-model="contentPage['_' + currentChosseTemplate]['data']['type']" ng-init="contentPage['_' + currentChosseTemplate]['data']['type'] = listTypeWithId[currentChosseTemplate]||null">
                        <input type="hidden" class="hidden" name="" ng-model="contentPage['_' + currentChosseTemplate]['data']['content_id']" ng-init="contentPage['_' + currentChosseTemplate]['data']['content_id'] = page.content_id||0">
                        @include('pages.partial.show-fields-template-extends')
                    </div>
                    <!-- end show extend template fields -->
                    <!-- show block fields -->
                    <div ng-if="isShowInjects[curSecIndex+indexCurrentTemplate]"  ng-repeat="field in templates[currentChosseTemplate].injects[curSecIndex].fields">
                        <!-- <div ng-repeat="field in injectData.fields" ng-show="childInject[keyInjectChild]"> -->
                            <input type="hidden" class="hidden" name="" ng-model="contentPage['_' + curSecIndex]['data']['type']" ng-init="contentPage['_' + curSecIndex]['data']['type'] = listTypeWithId[curSecIndex]||null">
                            <input type="hidden" class="hidden" name="" ng-model="contentPage['_' + curSecIndex]['data']['content_id']" ng-init="contentPage['_' + curSecIndex]['data']['content_id'] = page.content_id||0">
                            @include('pages.partial.show-fields-template-inject-block')

                        <!-- </div> -->
                    </div>

                    <!-- <div class="set-height"> -->

                    <div ng-show="isShowContentSection">
                        @include('pages.partial.show-sections-template')
                    </div>

                    <div class="alert alert-danger" ng-show="warningError">
                        <button class="close" ng-click="closeAlert()" aria-label="close">&times;</button>
                        <span>{{trans('cms_page/page-edit-draft.note_data_wrong')}}</span>
                    </div>

                    <!--show error minimum field-->
                    <div class="form-group control-label col-lg-12 text-require" ng-repeat="(key, value) in listErrorListFile">@{{value}}</div>
                    
                    <div class="clearfix"></div>

                    

                    <a href="@{{urlPre}}" target="_blank" id="preview-draft"></a>

                </form>
                <div class="text-right space-action-bottom" ng-show ="!isDisable">

                    <a   ng-if="!checkPage" class="btn btn-default" href="@{{baseUrl}}/support/show/@{{page['ticket_id']}}"><i class="fa fa-times"></i> {{trans('cms_page/page-edit-draft.cancel')}}</a>
                    <a  ng-disabled ="isDisable" ng-if="checkPage" class="btn btn-default" href="@{{baseUrl}}/cms/pages/set-page-selected/@{{page.parent_id}}" target="_self">
                        <i class="fa fa-times"></i> {{trans('cms_page/page-edit-draft.cancel')}}
                    </a>

                    <button ng-show="page.template" class="btn btn-primary" id="btnSubmit" ng-click="prevStepPage(indexCurrentTemplate)" ng-if="indexCurrentTemplate > 1">
                        <i class="fa fa-arrow-left"></i> {{trans('cms_page/page-edit-draft.prev')}}
                    </button>

                    <button class="btn btn-primary" id="btnSubmit" ng-click="nextStepPage(formData.$invalid, indexCurrentTemplate)" ng-if="indexCurrentTemplate < lastTemplate">
                    <!-- <button class="btn btn-primary" id="btnSubmit" ng-click="nextStepPage(formData.$invalid, indexCurrentTemplate)"> -->
                        <i class="fa fa-arrow-right"></i> {{trans('cms_page/page-edit-draft.next')}}
                    </button>
                    <button   class="btn btn-primary" id="btnSubmitButton" ng-click="submit(formData.$invalid)">
                        <i class="fa fa-check"></i> {{trans('cms_page/page-edit-draft.save')}}
                    </button>

                    <!-- <button ng-show="!page.template" class="btn btn-primary" id="btnSubmit" ng-click="saveDetailPage()"> -->
                        <!-- <i class="fa fa-check"></i> Save -->
                    <!-- </button> -->

                    <button  class="btn btn-upload" id="btnSubmit" ng-click="previewDraff(formData.$invalid)" ng-if="indexCurrentTemplate==lastTemplate">
                        <i class="fa fa-eye"></i> {{trans('cms_page/page-edit-draft.preview')}}
                    </button>
                </div>
            </div>
        </div>
        

    </div>
</div>
@stop

@section('script')
    <script type="text/javascript">
        window.baseUrl = '{{URL::to("")}}'
        window.parents = {!!json_encode($parents)!!};
        window.templates = {!!json_encode($templates)!!};
        window.contents = {!!json_encode($contents)!!};
        window.checkPage = {!!json_encode($checkPage)!!};
        window.listOutTypeMap = {!! json_encode(getListTypeMap()) !!};
        window.maxUpload = {!! json_encode($maxUpload) !!};
        window.listMapType = {!!json_encode(getMapTypeTCM())!!};
        window.listFieldTemplateRequired = {!!json_encode($listFieldTemplateRequired)!!};
        window.page = {!! json_encode($page) !!};
        window.folderPages = {!! json_encode($folderPages) !!};
        window.blockCommentMap = {!! json_encode($blockCommentMap) !!};
        window.assets = {!!json_encode(getAssets())!!};
        window.listpages = {!!json_encode(listsPage($page->language, $page->region))!!};
        window.listsPageMap = {!!json_encode(listsPageMap())!!};
        window.listsIdsMapPageAndContent = {!!json_encode(listIdsMapPageAndContent())!!};
        window.blockMapFileld = {!!json_encode(getListContentsBlock($page->language, $page->region))!!};
        window.listAssetFolderContainFirstLevel = {!! json_encode($listAssetFolderContainFirstLevel) !!};
        window.listFilesFormBuilder = {!! json_encode(getFilesFormBuilder()) !!};
        window.versions = {!! json_encode($versions) !!};
        window.isDisable = {!! $isDisable !!};
    </script>

    @if(!isProduction() && !isDev())
        {!! Html::script('app/shared/format-date/CheckLimitAndChangeDateTimeDirective.js?v='.getVersionScript())!!}

        {!! Html::script('app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/pages/EditDraftService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/pages/EditDraftController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/convent-text-to-lowercase/lowercase-character.js?v='.getVersionScript())!!}

        {!! Html::script('app/components/blocks/partial/InsertBlockLinkAssetController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/cmsContentInsertService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/assetmanagers/AssetManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/modal-select-level/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/modal-select-page/selectLevelDirective.js?v='.getVersionScript())!!}

        {!! Html::script('app/components/blocks/nested-block/BlockNestedService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/nested-block/BlockNestedController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level-asset/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/remove-cache-front-end/removeCacheService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/edit-draft.js') }}"></script>
    @endif
@stop
