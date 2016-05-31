@extends('app')
@section('title')
    {{trans('cms_block/edit-block.title')}}
@endsection
@section('content')
<div ng-controller="ManageBlockCreateController" class="wrap-content-management block-manager">
    <div class="top-content">
        <label class="c-m content-management">
            <a ng-click="breadCrumbNewBlock()" class="c-breadcrumb" href="/cms/block-manager">{{trans('cms_block/edit-block.breadcrumb_first')}}</a>
            @if(isset($breadcrumbData))
                @foreach($breadcrumbData as $key => $value)
                    <a class="c-breadcrumb" href="@{{baseUrl}}/cms/block-manager/set-block-selected/{{$value['_id']}}" target="_self" > / {{$value['name']}} </a>
                @endforeach
            @endif
             / {{trans('cms_block/edit-block.breadcrumb_last')}} {{$block->name}}
        </label>
    </div>
    <div class="content margin-top-0">
        <div class="assets" ng-show="!showField">
            <form role="form" name="formData"  class="upload-new-asset" novalidate>

                <ul id="mytab" class="nav nav-tabs" role="tablist">
                    <li ng-click="isShowAction = true" ng-show="isShowManageBlock">
                        <a id="event-manage" role="tab" href="#manage" data-toggle="tab" class="hide">
                        </a>
                        <a ng-click="activeManageBlock(formData.$invalid)">
                            <i class="fa fa-list-alt"></i> {{trans('cms_block/edit-block.manage_tab')}}
                        </a>

                    </li>
                    <li ng-click="isShowAction = true" class="active">
                        <a href="#detail" role="tab" data-toggle="tab" ng-click="showDetail(formData.$invalid)">
                            <i class="fa fa-list-alt"></i> {{trans('cms_block/edit-block.detail_tab')}}
                        </a>
                    </li>
                    <li ng-click="isShowAction = false" >
                        <a href="#content" role="tab" data-toggle="tab" ng-click="showValueContent(formData.$invalid)">
                            <i class="fa fa-file-code-o"></i> {{trans('cms_block/edit-block.content_tab')}}
                        </a>
                    </li>
                     <li>
                    <a href="#usage" role="tab" data-toggle="tab" ng-click="showUsage()">
                        <i class="fa fa-file-code-o"></i> {{trans('cms_block/edit-block.usage_tab')}}
                    </a>
                </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content fix-tab">

                    <div class="tab-pane fade" id="manage" ng-show="isManage && isShowManageBlock">
                        @include('blocks.manage-blocks.manage-input-fields')
                    </div>
                    <div class="tab-pane active in" id="detail" ng-show="isDetail">
                        <!-- Input Name-->
                        <div class="form-group">

                            <label class="label-form" for="name">{{trans('cms_block/edit-block.name_label')}}:<span class="text-require"> *</span></label>
                            <div class="wrap-form">
                                <input class="form-control name" placeholder="{{trans('cms_block/edit-block.name_placeholder')}}" type="text" name="name_block" ng-model="block.name" ng-required="true" />
                                <div class="pull-left">
                                    <small class="help-inline ng-invalid" ng-show="submitted && formData.name_block.$error.required">{{trans('cms_block/edit-block.name_required')}}</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- Select folder -->
                        <div class="form-group" >
                            <label class="label-form" for="name">{{trans('cms_block/edit-block.folder_label')}}: </label>
                            <div class="wrap-form">
                                    {{$block->folderName}}
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
                                    <i class="fa fa-image"></i> {{trans('cms_block/edit-block.block_thumb_btn')}}
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
                            <label class="label-form" for="">{{trans('cms_block/edit-block.description_label')}}:<span class="text-require"> *</span></label>
                            <div class="wrap-form">
                                <textarea class="form-control" rows="4" cols="143" name="description" id="description" ng-model="block.description" ng-required="true" placeholder="{{trans('cms_block/edit-block.description_placeholder')}}"></textarea>
                                <div class="pull-left">
                                    <small class="help-inline ng-invalid" ng-show="submitted && formData.description.$error.required">{{trans('cms_block/edit-block.description_required')}}</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="content">
                        <!-- Input Content -->
                        <div>
                            <label class="label-form" for="">{{trans('cms_block/edit-block.content_label')}}:
                                <span class='text-require'> *</span>
                            </label>
                            <div class="clearfix"></div>
                            <div class="wrap-content-review-and-code">
                                <ul class="nav nav-tabs" role="tablist">
                                </ul>
                            <div class="tab-content fix-tab">
                                <div role="tabpanel" class="tab-pane in active padding-none" id="code" ng-show="isShowCode">

                                    <div class="col-lg-12 padding-none" id="code" >
                                        <textarea class="form-control" rows="4" cols="50" name="editor" id="editor"></textarea>

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="wrap-link-input">
                                        <a class="link-insert-code" ng-click="callModalInsert('insert-link', 'null', 'null')">{{trans('cms_block/edit-block.insert_link')}}</a> <span class="insert-object"> | </span>
                                        <a class="link-insert-code" ng-click="callModalInsert('insert-block', 'null', 'null', 'true',block.base_id)">{{trans('cms_block/edit-block.insert_block')}}</a> <span class="insert-object"> | </span>
                                        <a class="link-insert-code" ng-click="callModalInsert('insert-asset', 'null', 'null')">{{trans('cms_block/edit-block.insert_asset')}}</a>
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
                    <div class="tab-pane fade" id="usage">
                    <!-- Input Description-->
                        <div class="table-responsive wrap-box-content " ng-show="usages.length > 0">
                            <table class="table" ng-table="tableParams" show-filter="isSearch">
                                <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
                                    <i class="fa fa-search"></i>
                                </a>
                                <tbody id="responsive-table-body">
                                    <tr class="pointer" ng-click="clickable($envent,item.content_id, item.type, item.block_type)" ng-repeat="item in $data">
                                        <td class=" w-104" sortable="'name'" filter="{ 'name': 'text' }" data-title="'{{trans('cms_block/edit-block.name_usage')}}'">@{{item.name}}</td>
                                        <td class=" w-104" sortable="'type'" filter="{ 'type': 'text' }" data-title="'{{trans('cms_block/edit-block.type_usage')}}'">@{{item.type}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div ng-show="usages.length == 0">
                            <span> {{trans('cms_block/edit-block.no_usage')}}</span>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger none" id="show-warning">
                    <!-- <button class="close" ng-click="closeAlert()" aria-label="close">&times;</button> -->
                    <span>{{trans('cms_block/edit-block.note_data_wrong')}}</span>
                </div>

                <!--show error minimum field-->
                <div class="form-group control-label col-lg-12 text-require" ng-repeat="(key, value) in listErrorListFile">@{{value}}</div>
                
                <!-- End Tab  -->
                <div class="text-right form-group action-bottom">
                    <a type="button" class="btn btn-default" href="@{{baseUrl}}/cms/block-manager/set-block-selected/@{{block.folder_id}}" target="_self" data-dismiss="modal"><i class="fa fa-times"></i> {{trans('cms_block/edit-block.cancel_btn')}}</a>
                    <button type="button" class="btn btn-primary" ng-click="submit(formData.$invalid)" ng-disabled="saving || uploading"><i class="fa fa-check"></i> {{trans('cms_block/edit-block.submit_btn')}}</button>
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
        window.block = {!! json_encode($block) !!}
        window.maxUpload = {!!json_encode($maxUpload)!!};
        window.listFieldType = {!!json_encode($listFieldType)!!};
        window.blockCommentMap = {!! json_encode($blockCommentMap)!!};
        window.listMapType = {!!json_encode(getMapTypeTCM())!!};
        window.listIdCheck = {!!json_encode(getTypeFollowIdTCM())!!};
        window.listAttributeDataOption = {!!json_encode(getAttributeDataOption())!!};
        window.listFieldNameMap = {!!json_encode(getListFieldNameFollowIdTCM())!!};
        window.listMapTypeTextSpecial = {!! json_encode(getmapTypeTextSpecial())!!};
        window.listBlocks = {!! json_encode(getListBlocksCms(null,null,$block->_id))!!};
        window.assets = {!!json_encode(getAssets())!!}
        window.listpages = {!!json_encode(listsPage())!!};
        window.listsPageMap = {!!json_encode(listsPageMap())!!};
        window.listOutTypeMap = {!! json_encode(getListTypeMap()) !!}
        window.listCheckBoxMap = {!! json_encode(getListCheckBoxMap()) !!}
        window.listsIdsMapPageAndContent = {!!json_encode(listIdsMapPageAndContent())!!};
        window.usages = {!! json_encode($usages) !!};
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
        {!! Html::script('app/shared/select-level-asset/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/confirm/confirmDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/block-manage.js') }}"></script>
     @endif
@stop
