@extends('app')
@section('title') 
    {{trans('cms_asset/edit-asset.title')}}
@stop
@section('content')

<div ng-init="initTree();assetEdit=({{json_encode($asset)}});asset=({{json_encode($asset)}});folderAsset = {{json_encode($folderAsset)}}" class="wrap-content-management asset-management" ng-controller="EditAssetController">
    <div class="top-content">
        <label class="c-m  content-management">
            <a class="c-breadcrumb" href="/cms/asset-manager">{{trans('cms_asset/edit-asset.breadcrumb_first')}}</a>
            @if(isset($breadcrumbData))
                @foreach($breadcrumbData as $key => $value)
                    <a class="c-breadcrumb" href="@{{baseUrl}}/cms/asset-manager/set-asset-selected/{{$value['_id']}}" target="_self" >/&nbsp;{{$value['name']}}&nbsp;</a>
                @endforeach
            @endif
            <span>/ @{{asset.name}} / {{trans('cms_asset/edit-asset.breadcrumb_last')}} </span>
        </label>
    </div>
    <div class="assets p-20" ng-show="!showField">
        <div ng-if="error">@{{error}}</div>
        <form role="form" name="formData"  class="upload-new-asset" novalidate>
            <!-- Input Name-->
            <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
                <label class="label-form" for="name">{{trans('cms_asset/edit-asset.name_label')}}:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control name" placeholder="{{trans('cms_asset/edit-asset.name_placeholder')}}" type="text" name="name" ng-model="asset.name" ng-required = "true" ng-disabled="true"/>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.name.$error.required">{{trans('cms_asset/edit-asset.name_required')}}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-class="[submitted&& formData.folder.$invalid]">
                <label class="label-form" for="name">{{trans('cms_asset/edit-asset.folder_label')}}:</label>
                <div class="wrap-form">
                    @if(isset($folder_name))
                        <i class="fa fa-folder c-folder"></i>
                        {{$folder_name}}
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- Attach File -->
            <div class="form-group" ng-show="asset.description">
                <label class="label-form" for="name">{{trans('cms_asset/edit-asset.description_label')}}:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <textarea class="form-control name" type="text" name="description" ng-model="asset.description" ng-disabled="true"></textarea>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && !asset.description">{{trans('cms_asset/edit-asset.description_required')}}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <label class="label-form" for="name">{{trans('cms_asset/edit-asset.file_name_label')}}:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control name" type="text" name="filename" ng-model="asset.filename" ng-disabled="true"/>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && !asset.filename">{{trans('cms_asset/edit-asset.file_name_required')}}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <label class="label-form" for="name">{{trans('cms_asset/edit-asset.content_file_label')}}:<span class="text-require"> *</span></label>

                <div class="wrap-form set-height">
                    <textarea class="form-control name" type="text" name="content_file" ng-model="asset.content" id="editor" placeholder="{{trans('cms_asset/edit-asset.content_file_placeholder')}}"></textarea>
                </div>
                <div class="wrap-form">
                    <small class="help-inline" ng-show="submitted && requiredEditorContent">{{trans('cms_asset/edit-asset.content_file_required')}}</small>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="text-right">
                <a type="button" class="btn btn-default" href="@{{baseUrl}}/cms/asset-manager/set-asset-selected/@{{asset.folder_id}}" target="_self"  data-dismiss="modal"><i class="fa fa-times"></i> {{trans('cms_asset/edit-asset.cancel_btn')}}</a>
                <button type="button" class="btn btn-primary" ng-click="updateContentFile(asset._id, formData.$invalid)" ><i class="fa fa-check"></i> {{trans('cms_asset/edit-asset.submit_btn')}}</button>
                <div class="clearfix"></div>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
<div>
@stop
@section('script')
    <script type="text/javascript">
        'use strict';
        (function($) {
            // $('#page-loading').css('display','block');
            $('#resize-right .table-responsive').css('opacity','0');
            $('#resize-right .table-responsive').css('opacity','1');
        })(jQuery);
    </script>

    {!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-all.min.js')!!}
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}

    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/assetmanagers/AssetManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/assetmanagers/EditAssetController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}

        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/cmsContentFolderService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/edit-asset-file.js') }}"></script>

    @endif
@stop
