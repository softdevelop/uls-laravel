@extends('app')
@section('title')
    {{trans('cms_block/add-block.title')}}
@endsection
@section('content')
<div ng-controller="ManageBlockCreateController" class="wrap-content-management block-manager">
    <div class="top-content">
        <label class="c-m content-management">
            <a ng-click="breadCrumbNewBlock()" class="c-breadcrumb" href="/cms/block-manager">{{trans('cms_block/add-block.breadcrumb_first')}}</a>
            @if(isset($breadcrumbData))
                @foreach($breadcrumbData as $key => $value)
                    <a class="c-breadcrumb" href="@{{baseUrl}}/cms/block-manager/set-block-selected/{{$value['_id']}}" target="_self" > / {{$value['name']}} </a>
                @endforeach
            @endif
             / {{trans('cms_block/add-block.breadcrumb_last')}}
        </label>
    </div>
    <div class="content margin-top-0">
        <div class="assets" ng-show="!showField" ng-init="folders = {{json_encode($folders)}}">
            <form role="form" name="formData"  class="upload-new-asset" novalidate>

                <ul id="mytab" class="nav nav-tabs" role="tablist">
                    <li ng-click="isShowAction = true" ng-show="isShowManageBlock">
                        <a id="event-manage" role="tab" href="#manage" data-toggle="tab" class="hide">
                        </a>
                        <a ng-click="activeManageBlock(formData.$invalid)">
                            <i class="fa fa-list-alt"></i> {{trans('cms_block/add-block.manage')}}
                        </a>

                    </li>
                    <li ng-click="isShowAction = true" class="active">
                        <a href="#detail" role="tab" data-toggle="tab" ng-click="showDetail(formData.$invalid)">
                            <i class="fa fa-list-alt"></i> {{trans('cms_block/add-block.detail_tab')}}
                        </a>
                    </li>
                    <li ng-click="isShowAction = false">
                        <a href="#content" role="tab" data-toggle="tab" ng-click="showValueContent(formData.$invalid)">
                            <i class="fa fa-file-code-o"></i> {{trans('cms_block/add-block.content_tab')}}
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content fix-tab">
                    <div class="tab-pane fade" id="manage">
                        @include('blocks.manage-blocks.manage-input-fields')
                    </div>
                    <div class="tab-pane active in" id="detail">
                        <!-- Input Name-->
                        <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
                            <label class="label-form" for="name">{{trans('cms_block/add-block.name_label')}}:<span class="text-require"> *</span></label>
                            <div class="wrap-form">
                                <input class="form-control name" placeholder="{{trans('cms_block/add-block.name_placeholder')}}" type="text" name="name" ng-model="block.name" ng-required = "true" />
                                <div class="pull-left">
                                    <small class="help-inline" ng-show="submitted && formData.name.$error.required">{{trans('cms_block/add-block.name_required')}}</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- Select folder -->
                        <div class="form-group" ng-class="[submitted && formData.folder.$invalid]">
                            <label class="label-form" for="name">{{trans('cms_block/add-block.folder_label')}}:<span class="text-require"> *</span></label>
                            <div class="wrap-form show-full-width-select">
                                <select-level items="folders" text="{{trans('cms_block/add-block.folder_placeholder')}}" text-filter="Filter folder" ng-model="block.folder" selected-item="{{json_encode($selectedItem)}}" ></select-level>
                                <div class="pull-left">
                                    <small class="help-inline" ng-show="submitted && !block.folder">{{trans('cms_block/add-block.folder_required')}}</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- Thumbnail -->
                        <div class="form-group">
                            <div class="drop-file col-lg-12 padding-none">
                                <button class="btn btn-upload pull-left" ng-model="block.thumbnail"
                                        ngf-select
                                        ngf-reset-model-on-click="false"
                                        ngf-accept="'image/*'"
                                        accept="image/*">
                                    <i class="fa fa-image"></i> {{trans('cms_block/add-block.block_thumb_btn')}}
                                </button>
                                <div class="clearfix"></div>

                                <div class="m-t-15">
                                    <div class="" ng-repeat="image_add in block.thumbnail track by $index">
                                        <img class="item-thum-up" ngf-src="image_add" ng-show="image_add.type.indexOf('image') > -1" ngf-accept="'image/*'">
                                        <a class="action-thum-up" href="javascript:void(0);"><i ng-click="removeThumbnail($index)" class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                         <!-- Input Description -->
                        <div class="form-group" >
                            <label class="label-form" for="">{{trans('cms_block/add-block.description_label')}}:<span class="text-require"> *</span></label>
                            <div class="wrap-form">
                                <textarea class="form-control" rows="4" cols="143" name="description" id="description" ng-model="block.description" ng-required="true" placeholder="{{trans('cms_block/add-block.description_placeholder')}}"></textarea>
                                <div class="pull-left">
                                    <small class="help-inline ng-invalid" ng-show="submitted && formData.description.$error.required">{{trans('cms_block/add-block.description_required')}}</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="content">
                        <!-- Input Content -->
                        <div>
                            <label class="label-form" for="">{{trans('cms_block/add-block.content_label')}}:<span class="text-require"> *</span></label>
                            <div class="m-b-10">
                                <small class="help-inline ng-invalid" ng-show="submitted && requiredEditorContent">{{trans('cms_block/add-block.content_required')}}</small>
                            </div>
                            <div class="clearfix"></div>
                            <div class="wrap-content-review-and-code">
                                <ul class="nav nav-tabs" role="tablist">
                                </ul>
                            <div class="tab-content fix-tab">
                                <div role="tabpanel" class="tab-pane in active padding-none" id="code" ng-show="isShowCode">
                                    <div class="pull-left">
                                    </div>
                                    <div class="col-lg-12 padding-none" id="code" >
                                        <textarea class="form-control" rows="4" cols="50" name="editor" id="editor"></textarea>

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="wrap-link-input">
                                        <a class="link-insert-code" ng-click="callModalInsert('insert-link', 'null', 'null')">{{trans('cms_block/add-block.insert_link')}}</a> <span class="insert-object"> | </span>
                                        <a class="link-insert-code" ng-click="callModalInsert('insert-block', 'null', 'null', 'true')">{{trans('cms_block/add-block.insert_block')}}</a> <span class="insert-object"> | </span>
                                        <a class="link-insert-code" ng-click="callModalInsert('insert-asset', 'null', 'null')">{{trans('cms_block/add-block.insert_asset')}}</a>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane padding-none" id="review" ng-show="isShowReView">
                                    <div class="full-height p-10" id="re_view">
                                        <iframe name="myframeBlock" id="frameBlock" class="full-height review-iframe"></iframe>
                                    </div>

                                </div>

                            </div>

                            <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger none" id="show-warning">
                    <!-- <button class="close" ng-click="closeAlert()" aria-label="close">&times;</button> -->
                    <span>{{trans('cms_block/add-block.note_data_wrong')}}</span>
                </div>

                <!--show error minimum field-->
                <div class="form-group control-label col-lg-12 text-require" ng-repeat="(key, value) in listErrorListFile">@{{value}}</div>
                
                <!-- End Tab  -->
                <div class="text-right form-group action-bottom">
                    <a type="button" class="btn btn-default" ng-href="@{{baseUrl}}/cms/block-manager/set-block-selected/{{$selectedItemId}}" target="_self" ng-click="cancel()"  data-dismiss="modal"><i class="fa fa-times"></i> {{trans('cms_block/add-block.cancel_btn')}}</a>
                    <button type="button" class="btn btn-primary" ng-click="submit(formData.$invalid)" ng-disabled="saving"><i class="fa fa-check"></i> {{trans('cms_block/add-block.submit_btn')}}</button>
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
    <script type="text/javascript">
        window.folders = {!! json_encode($folders) !!}
        window.maxUpload = {!!json_encode($maxUpload)!!};
        window.listFieldType = {!!json_encode($listFieldType)!!};
        window.blockCommentMap = {!! json_encode($blockCommentMap)!!};
        window.listMapType = {!!json_encode(getMapTypeTCM())!!};
        window.listIdCheck = {!!json_encode(getTypeFollowIdTCM())!!};
        window.listAttributeDataOption = {!!json_encode(getAttributeDataOption())!!};
        window.listFieldNameMap = {!!json_encode(getListFieldNameFollowIdTCM())!!};
        window.listMapTypeTextSpecial = {!! json_encode(getmapTypeTextSpecial())!!};
        window.listBlocks = {!! json_encode(getListBlocksCms())!!};
        window.assets = {!!json_encode(getAssets())!!}
        window.listpages = {!!json_encode(listsPage())!!};
        window.listsPageMap = {!!json_encode(listsPageMap())!!};
        window.listOutTypeMap = {!! json_encode(getListTypeMap()) !!}
        window.listCheckBoxMap = {!! json_encode(getListCheckBoxMap()) !!}
        window.listsIdsMapPageAndContent = {!!json_encode(listIdsMapPageAndContent())!!};
        window.selectedItemId = {!!json_encode($selectedItemId)!!};
        window.assets = {!! json_encode($data) !!};
        window.listAssetFolderContainFirstLevel = {!! json_encode($listAssetFolderContainFirstLevel) !!};
        window.listFilesFormBuilder = {!! json_encode(getFilesFormBuilder()) !!};

    </script>
    {!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/blocks/BlockManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/BlockManagerController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/RequestBlockController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/RequestBlockService.js?v='.getVersionScript())!!}

        {!! Html::script('app/components/blocks/partial/InsertBlockLinkAssetController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/manage-block/ManagerBlockValidate.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/manage-block/ManageBlockCreate.js?v='.getVersionScript())!!}

        {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/RequestNewBlockDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/BlockDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/assetmanagers/AssetManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages/EditDraftService.js?v='.getVersionScript())!!}

        {!! Html::script('app/shared/cms-content/cmsContentFolderService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/cmsContentInsertService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file-upload/fileTicketUploadDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms/cms-config/CmsConfigController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/CmsContentInsertService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/modal-select-level/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/modal-select-page/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms/cmsController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level-asset/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/confirm/confirmDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/block-manage.js') }}"></script>
     @endif
@stop
