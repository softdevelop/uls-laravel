@extends('app')
@section('title')
    {{trans('cms_block/edit-block.title')}}
@endsection
@section('content')
<div ng-controller="EditBlockCtrl" class="wrap-content-management edit-block">
    <div class="top-content">
        <label class="c-m content-management"><a class="c-breadcrumb" href="/cms/block-manager">{{trans('cms_block/edit-block.breadcrumb_first')}}</a>
            @if(isset($breadcrumbData))
                @foreach($breadcrumbData as $key => $value)
                    <a class="c-breadcrumb" href="@{{baseUrl}}/cms/block-manager/set-block-selected/{{$value['_id']}}" target="_self" >/&nbsp;{{$value['name']}}&nbsp;</a>
                @endforeach
            @endif
            <span>/ {{$block->name}} / {{trans('cms_block/edit-block.breadcrumb_last')}}</span>
        </label>

    </div>

    <div class="content margin-top-0">

    <div class="assets" ng-show="!showField" ng-init="types = {{json_encode($types)}}">
        <div ng-if="error">@{{error}}</div>
        <form role="form" name="formData"  class="upload-new-asset" novalidate>

            <!-- Tab  -->

            <!-- Nav tabs -->
            <ul id="mytab" class="nav nav-tabs" role="tablist">
                <li class="active">
                    <a href="#detail" role="tab" data-toggle="tab">
                        <i class="fa fa-list-alt"></i> {{trans('cms_block/edit-block.detail_tab')}}
                    </a>
                </li>
                <li>
                    <a href="#content1" role="tab" data-toggle="tab" ng-click="showValueContent()">
                        <i class="fa fa-file-code-o"></i> {{trans('cms_block/edit-block.content_tab')}}
                    </a>
                </li>
                <li>
                    <a href="#usage" role="tab" data-toggle="tab" ng-click="showUsage()">
                        <i class="fa fa-file-code-o"></i> {{trans('cms_block/edit-block.usage_tab')}}
                    </a>
                </li>
            </ul>

            <div class="tab-content fix-tab">
                <div class="tab-pane fade active in" id="detail">
                    <!-- Input Name -->
                    <div class="form-group" ng-class="[submitted && formData.blockName.$invalid]">
                        <label class="label-form" for="name">{{trans('cms_block/edit-block.name_label')}}:<span class="text-require"> *</span></label>
                        <div class="wrap-form">
                            <input class="form-control name" placeholder="{{trans('cms_block/edit-block.name_placeholder')}}" type="text" name="blockName" ng-model="blockContent.name" ng-required = "true" />
                            <div class="pull-left">
                                <small class="help-inline" ng-show="submitted && formData.blockName.$error.required">{{trans('cms_block/edit-block.name_required')}}</small>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <!-- Input Folder -->
                    <div class="form-group" ng-class="[submitted && formData.folder.$invalid]">
                        <label class="label-form" for="name">{{trans('cms_block/edit-block.folder_label')}}: </label>
                        <div class="wrap-form">
                            <input class="form-control name" placeholder="Folder" type="text" name="folder" ng-model="blockContent.folderName" ng-required = "true" disabled="disabled" />
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <!-- Input Type -->
                    <div class="form-group" ng-class="[submitted && formData.type.$invalid]">
                        <label class="label-form" for="name">{{trans('cms_block/edit-block.type_label')}}:<span class="text-require"> *</span></label>
                        <div class="wrap-form">
                            <select name="type" class="form-control" ng-model="blockContent.type"  ng-options="key as value for (key , value) in types" ng-required = "true" ng-change="changeType()" disabled="disabled">
                                <option value="" disabled>{{trans('cms_block/edit-block.type_select')}}</option>
                            </select>
                            <div class="pull-left">
                                <small class="help-inline" ng-show="submitted && formData.type.$error.required">{{trans('cms_block/edit-block.type_required')}}</small>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <!-- Thumbnail -->
                    <div class="form-group">
                        <div class="drop-file col-lg-12 padding-none">
                            <button class="btn btn-upload pull-left" ng-model="blockContent.addThumbnail" ng-show="blockContent.thumbnail == null"
                                    ngf-select
                                    ngf-reset-model-on-click="false"
                                    ngf-accept="'image/*'"
                                    accept="image/*">
                                <i class="fa fa-image"></i> {{trans('cms_block/edit-block.block_thumb_btn')}}
                            </button>

                            <div class="clearfix"></div>

                            <div class="m-t-15">
                                @if($blockContent['thumbnail'] != null)
                                    <div class="" ng-if="blockContent.thumbnail != null">
                                        <img class="item-thum-up" ng-if="blockContent.thumbnail != null" ng-src="/uploads/blocks/@{{blockContent.thumbnail}}" alt="">
                                        <a ng-click="removeThumbnail()" class="action-thum-up" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                    </div>
                                @endif
                                <div class="" ng-repeat="image_add in blockContent.addThumbnail track by $index">
                                    <img class="item-thum-up" ngf-src="image_add" ng-show="image_add.type.indexOf('image') > -1" ngf-accept="'image/*'">
                                    <a ng-click="removeAddThumbnail()" class="action-thum-up" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                </div>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <!-- Input Description -->
                    <div class="form-group" >
                        <label class="label-form" for="">{{trans('cms_block/edit-block.description_label')}}:<span class="text-require"> *</span></label>
                        <div class="wrap-form">
                            <!-- <textarea id="content" name="description" class="form-control" ng-init="initRedactor()" placeholder="Description"></textarea> -->
                            <textarea class="form-control" rows="4" cols="143" name="description" id="description" ng-model="blockContent.description" ng-required="true" placeholder="{{trans('cms_block/edit-block.description_placeholder')}}"></textarea>
                            <div class="pull-left">
                                <small class="help-inline ng-invalid" ng-show="submitted && formData.description.$error.required">{{trans('cms_block/edit-block.description_required')}}</small>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="content1">
                    <!-- Input Content -->
                    <div>
                        <label class="label-form" for="">{{trans('cms_block/edit-block.content_label')}}:<span class="text-require"> *</span></label>
                        <div class="clearfix"></div>
                        <div class="m-b-10">
                                <small class="help-inline ng-invalid" ng-show="submitted && requiredEditorContent">{{trans('cms_block/edit-block.content_required')}}</small>
                            </div>
                        <div class="wrap-content-review-and-code">

                        <div class="tab-content fix-tab">
                            <div role="tabpanel" class="tab-pane in active padding-none" id="code">

                                <div class="col-lg-12 padding-none" id="code" >
                                    <textarea class="form-control" rows="4" cols="50" name="editor" id="editor"></textarea>
                                </div>
                                
                                <div class="clearfix"></div>
                                <div class="wrap-link-input">
                                    <a class="link-insert-code" ng-click="callModalInsert('insert-link', blockContent.language, blockContent.region)">{{trans('cms_block/edit-block.insert_link')}}</a> <span class="insert-object"> | </span>
                                    <a class="link-insert-code" ng-click="callModalInsert('insert-block', blockContent.language, blockContent.region, 'true',blockContent.base_id)">{{trans('cms_block/edit-block.insert_block')}}</a> <span class="insert-object"> | </span>
                                    <a class="link-insert-code" ng-click="callModalInsert('insert-asset', blockContent.language, blockContent.region)">{{trans('cms_block/edit-block.insert_asset')}}</a>
                                    <span class="insert-object">
                                  <!--    | </span>
                                    <a class="link-insert-code" ng-click="callModalInsert('insert-database', templateContent.language, templateContent.region)">Insert Database</a> -->
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane padding-none min-h-400" id="review" ng-show="isShowReView">
                                <div class="p-10" id="re_view">
                                    <iframe name="myframeBlock" id="frameBlock" class="review-iframe"></iframe>
                                </div>

                            </div>

                        </div>

                        <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="usage">
                    <!-- Input Description-->
                    <div class="table-responsive wrap-box-content " ng-show="usages.length > 0" >
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

            <div class="form-group action-bottom" ng-if="errors">
                <div ng-repeat="(key, value) in errors">@{{value}}</div>
            </div>

            <div class="text-right form-group action-bottom">
                <a type="button" class="btn btn-default"  ng-click="cancel()" href="@{{baseUrl}}/cms/block-manager/set-block-selected/@{{blockContent.folder_id}}" target="_self" data-dismiss="modal">
                    <i class="fa fa-times"></i> {{trans('cms_block/edit-block.cancel_btn')}}
                </a>
                <button type="button" class="btn btn-primary" ng-click="parseBlockontent(formData.$invalid)" ng-disabled="saving"><i class="fa fa-check"></i> {{trans('cms_block/edit-block.submit_btn')}}</button>
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
        window.blockContent = {!! json_encode($blockContent) !!}
        window.listMapType = {!!json_encode(getMapTypeTCM())!!};
        window.listFieldType = {!!json_encode($listFieldType)!!};
        window.listIdCheck = {!!json_encode(getTypeFollowIdTCM())!!};
        window.listAttributeDataOption = {!!json_encode(getAttributeDataOption())!!};
        window.listFieldNameMap = {!!json_encode(getListFieldNameFollowIdTCM())!!};
        window.maxUpload = {!!json_encode($maxUpload)!!};
        window.listMapTypeTextSpecial = {!! json_encode(getmapTypeTextSpecial())!!};
        window.listBlocks = {!! json_encode(getListBlocksCms($blockContent->language, $blockContent->region,$blockContent->_id))!!};
        window.blockCommentMap = {!! json_encode($blockCommentMap)!!};
        window.usages = {!! json_encode($usages) !!};
        window.assets = {!! json_encode($data) !!};
        window.listAssetFolderContainFirstLevel = {!! json_encode($listAssetFolderContainFirstLevel) !!};
    </script>
    {!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}

    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-all.min.js')!!}
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}


    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/blocks/BlockManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/BlockManagerController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/RequestBlockController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/RequestBlockService.js?v='.getVersionScript())!!}

        {!! Html::script('app/components/blocks/partial/InsertBlockLinkAssetController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/partial/EditBlockController.js?v='.getVersionScript())!!}

        {!! Html::script('app/shared/cms-content/cmsContentFolderService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/cmsContentInsertService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file-upload/fileTicketUploadDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/RequestNewBlockDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/BlockDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}

        {!! Html::script('app/shared/confirm/confirmDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/CmsService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms/cms-config/CmsConfigController.js?v='.getVersionScript())!!}
        {!! Html::script('/app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/assetmanagers/AssetManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages/EditDraftService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level-database/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level-asset/selectLevelDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/editBlock.js') }}"></script>
     @endif
@stop
