
@extends('app')
@section('title')
    {{trans('cms_template/edit-template.title')}}
@endsection
@section('content')
<div ng-controller="TemplateUpdateContentManagerCtr" class="wrap-content-management edit-template hidden">

    <div class="top-content">
        <label class="c-m content-management">
            <a class="c-breadcrumb" href="/cms/template-content-manager">{{trans('cms_template/edit-template.breadcrumb_first')}}</a>
            @if(isset($breadcrumbData))
                @foreach($breadcrumbData as $key => $value)
                    <a class="c-breadcrumb" href="@{{baseUrl}}/cms/template-content-manager/set-template-selected/{{$value['_id']}}" target="_self" > / {{$value['name']}} </a>
                @endforeach
            @endif
            <span>/ {{$template->name}} / {{trans('cms_template/edit-template.breadcrumb_last')}}</span>
        </label>

    </div>

    <div class="content margin-top-0">

    <div class="assets" ng-init="">
        <div ng-if="error">@{{error}}</div>
        <form role="form" name="formData"  class="upload-new-asset" novalidate>

            <!-- Tab  -->
            
            <!-- Nav tabs -->
            <ul id="mytab" class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#detail" role="tab" data-toggle="tab" ng-click="showDetail()">
                        <i class="fa fa-list-alt"></i> {{trans('cms_template/edit-template.detail_tab')}}
                    </a>
                </li>
                <li>
                    <a href="#content" role="tab" data-toggle="tab" ng-click="showValueContent()">
                        <i class="fa fa-file-code-o"></i> {{trans('cms_template/edit-template.content_tab')}}
                    </a>
                </li>
                <li>
                    <a href="#usage" role="tab" data-toggle="tab" ng-click="showUsage()">
                        <i class="fa fa-file-code-o"></i> {{trans('cms_template/edit-template.usage_tab')}}
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content fix-tab">
                <div class="tab-pane fade active in" id="detail">
                    <!-- Input Name-->
                    <div class="form-group" ng-class="{'has-error':submitted && formData.name.$invalid}">
                        <label class="label-form" for="name">{{trans('cms_template/edit-template.name_label')}}:<small class="text-require"> *</small></label>
                        <div class="wrap-form">
                            <input type="text" name="name" class="form-control" placeholder="{{trans('cms_template/edit-template.name_placeholder')}}" ng-model="templateContent.name" ng-required="true" />
                            <small class="help-inline" ng-show="submitStepSecond && formData.name.$error.required">{{trans('cms_template/edit-template.name_required')}}</small>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group" ng-class="{'has-error':submitted && formData.folder.$invalid}">
                        <label class="label-form" for="name">{{trans('cms_template/edit-template.folder_label')}}: </label>
                        <div class="wrap-form">
                            <p>@{{templateContent.folderName}}</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group" >
                        <label class="label-form" for="">{{trans('cms_template/edit-template.template_file_label')}}: </label>

                        <div class="wrap-form">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" accept=".txt,.blade.php,.php,.html" ngf-select ngf-drop ngf-change="uploadFileTemplate($files)">{{trans('cms_template/edit-template.template_file_btn')}}</button>
                                </span>
                                <div class="">
                                    <small class="help-inline ng-invalid" ng-show="errorUploadFile && !extError">@{{errorUploadFile}}</small>
                                    <small class="help-inline ng-invalid" ng-show="extError">{{trans('cms_template/edit-template.template_file_err')}}</small>
                                </div>

                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- Thumbnail -->
                    <div class="form-group">
                        <div class="drop-file col-lg-12 padding-none">
                            <button class="btn btn-upload pull-left" ng-model="thumbnail"
                            accept="image/*" ngf-select ngf-drop ngf-change="uploadThumbnail($files)">
                                <i class="fa fa-image"></i> {{trans('cms_template/edit-template.template_thumb_btn')}}
                            </button>

                            <div class="clearfix"></div>

                            <div class="m-t-15">
                                <div class="" ng-repeat="image_add in thumbnail track by $index">
                                    <img class="item-thum-up" ngf-src="image_add" ng-show="image_add.type.indexOf('image') > -1" ngf-accept="'image/*'">
                                    <a class="action-thum-up" href="javascript:void(0);"><i ng-click="removeThumbnail($index)" class="fa fa-times"></i></a>
                                </div>
                            </div>

                        </div>
                        <div class="clearfix"></div>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="content">
                    <!-- Input Description-->
                    <div>
                        <label class="label-form" for="">{{trans('cms_template/edit-template.content_label')}}: <span class="text-require"> *</span></label>
                        <div class="clearfix"></div>
                        <div class="p-b-10">
                            <small class="help-inline ng-invalid" ng-show="submitted && requiredEditorContent">{{trans('cms_template/edit-template.content_required')}}</small>
                        </div>
                        <div class="wrap-content-review-and-code">

                            <div class="tab-content fix-tab m-t--10">
                                <div role="tabpanel" class="tab-pane in active padding-none" id="code">
                                    <div class="col-lg-12 padding-none padding-none" id="code" >
                                        <textarea class="form-control" rows="4" cols="50" name="editor" id="editor"></textarea>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="wrap-link-input">
                                        <a class="link-insert-code" ng-click="callModalInsert('insert-link', templateContent.language, templateContent.region)">{{trans('cms_template/edit-template.insert_link')}}</a> <span class="insert-object"> | </span>
                                        <a class="link-insert-code" ng-click="callModalInsert('insert-block', templateContent.language, templateContent.region)">{{trans('cms_template/edit-template.insert_block')}}</a> <span class="insert-object"> | </span>
                                        <a class="link-insert-code" ng-click="callModalInsert('insert-asset', templateContent.language, templateContent.region)">{{trans('cms_template/edit-template.insert_asset')}}</a>
                                        <span class="insert-object">
                                        <!--  | </span> -->
                                       <!--  <a class="link-insert-code" ng-click="callModalInsert('insert-database', templateContent.language, templateContent.region)">Insert Database</a> -->
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane padding-none min-h-400" id="review" ng-show="isShowReView">
                                </div>

                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="usage" >
                    <!-- Input Description-->
                    <div class="table-responsive wrap-box-content" ng-show="usages.length > 0">
                        <table class="table" ng-table="tableParams" show-filter="isSearch">
                            <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
                                <i class="fa fa-search"></i>
                            </a>     
                            <tbody id="responsive-table-body">
                                <tr class="pointer" ng-click="clickable($envent,item.content_id, item.type)" ng-repeat="item in $data">
                                    <td class=" w-104" sortable="'name'" filter="{ 'name': 'text' }" data-title="'{{trans('cms_template/edit-template.name_usage')}}'">@{{item.name}}</td>
                                    <td class=" w-104" sortable="'type'" filter="{ 'type': 'text' }" data-title="'{{trans('cms_template/edit-template.type_usage')}}'">@{{item.type}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div ng-show="usages.length == 0">
                        <span> {{trans('cms_template/edit-template.no_usage')}}</span>
                    </div>
                </div>
            </div>

            <!-- End Tab  -->


            <div class="text-right action-bottom" ng-if="!isShowUsage">
                <a type="button" class="btn btn-default" href="@{{baseUrl}}/cms/template-content-manager/set-template-selected/@{{templateContent.folder_id}}" target="_self" data-dismiss="modal"><i class="fa fa-times"></i> {{trans('cms_template/edit-template.cancel_btn')}}</a>
                <button type="button" class="btn btn-primary" ng-click="parseTemplateContent(formData.$invalid)" ng-disabled="saving"><i class="fa fa-check"></i> {{trans('cms_template/edit-template.submit_btn')}}</button>
                <div class="clearfix"></div>
            </div>

        </form>
        <div class="clearfix"></div>
    </div>

    </div>

    <div class="clearfix"></div>


</div>
@stop
@section('script')
    <script>
        window.templateContent = {!! json_encode($templateContent)!!};
        window.listFieldType = {!! json_encode($listFieldType)!!};
        window.listMapType = {!!json_encode(getMapTypeTCM())!!};
        window.maxUpload = {!!json_encode($maxUpload)!!};
        window.listAttributeDataOption = {!!json_encode(getAttributeDataOption())!!};
        window.listIdCheck = {!!json_encode(getTypeFollowIdTCM())!!};
        window.listFieldNameMap = {!!json_encode(getListFieldNameFollowIdTCM())!!};
        window.listMapTypeTextSpecial = {!! json_encode(getmapTypeTextSpecial())!!};
        window.listBlocks = {!! json_encode(getListBlocksCms($templateContent->language, $templateContent->region))!!};
        window.blockCommentMap = {!! json_encode($blockCommentMap) !!};
        window.usages = {!! json_encode($usages) !!};
        window.assets = {!! json_encode($assets) !!};
        window.listAssetFolderContainFirstLevel = {!! json_encode($listAssetFolderContainFirstLevel) !!};
    </script>

    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/blocks/BlockManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/cmsContentFolderService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/cmsContentInsertService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/partial/InsertBlockLinkAssetController.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/template-content-manager/templateContentManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/template-content-manager/templateUpdateContentManagerController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/confirm/confirmDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/CmsService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms/cms-config/CmsConfigController.js?v='.getVersionScript())!!}
        {!! Html::script('/app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/assetmanagers/AssetManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages/EditDraftService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level-database/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level-asset/selectLevelDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/templateEdit.js') }}"></script>
     @endif
@stop
