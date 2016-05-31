@extends('app')
@section('title')
    Block Manager
@endsection
@section('content')
<div ng-controller="ModalUploadNewBlockCtrl" class="wrap-content-management page-management">
    <div class="top-content">
        <label class="c-m content-management">
            <a href="/cms/block-manager">CMS Block Manager</a> / Create New Block
        </label>

    </div>

    <div class="content margin-top-0">

    <div class="assets" ng-show="!showField" ng-init="types = {{json_encode($types)}};folders = {{json_encode($folders)}}">
        <div ng-if="error">@{{error}}</div>
        <form role="form" name="formData"  class="upload-new-asset" novalidate>
            <!-- Input Name-->
            <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
                <label class="label-form" for="name">Name:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control name" placeholder="Name" type="text" name="name" ng-model="block.name" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.name.$error.required">Name is required field.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-class="[submitted && formData.folder.$invalid]">
                <label class="label-form" for="name">Folder:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <select-level items="folders" text="Select Folder" text-filter="Filter folder" ng-model="block.folder"></select-level>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && !block.folder">Folder is required field.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- Input Name-->
            <div class="form-group" ng-class="[submitted && formData.type.$invalid]">
                <label id= "type-folder" class="label-form" for="name">Type:<span class="text-require"> *</span></label>
                <div class="col-lg-12" >
                    <select name="type" class="form-control" ng-model="block.type"  ng-options="key as value for (key , value) in types" ng-required = "true" ng-change="changeType()">
                        <option value="" disabled>Select Type</option>
                    </select>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.type.$error.required">Type is required field.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

                    <!-- Input Content-->
            <div class="form-group" >
                <label class="label-form" for="">Content:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <textarea rows="4" cols="143" name="description" id="description" ng-init="initRedactor('description')"></textarea>
                    <div class="pull-left">
                        <small class="help-inline ng-invalid" ng-show="submitted && requiredDescription">Description is required field.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Input Description-->
            <div class="form-group" >
                <div class="wrap-form">
                    <textarea rows="4" cols="50" name="editor" id="editor"></textarea>
                    <div class="pull-left">
                        <small class="help-inline ng-invalid" ng-show="submitted && requiredEditorContent">Content is required field.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="pull-right">
                    <a ng-click="callModalInsert('insert-link', 'null', 'null')">Insert Link</a> |
                    <a ng-click="callModalInsert('insert-block', 'null', 'null')">Insert Block</a> |
                    <a ng-click="callModalInsert('insert-asset', 'null', 'null')">Insert Asset</a>
                </div>
            </div>


            <!-- Thumbnail -->
            <div class="form-group">
                <div class="drop-file col-lg-12 padding-none">
                    <button class="btn btn-primary pull-left" ng-model="block.thumbnail"
                            ngf-select
                            ngf-reset-model-on-click="false"
                            ngf-accept="'image/*'"
                            accept="image/*">
                        Choose Thumbnail
                    </button>

                    <div class="clearfix"></div>

                    <div class="m-t-15">
                        <div class="" ng-repeat="image_add in block.thumbnail track by $index">
                            <img class="item-thum-up" ngf-src="image_add" ng-show="image_add.type.indexOf('image') > -1" ngf-accept="'image/*'">
                            <a ng-click="removeThumbnail()" class="action-thum-up" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                        </div>
                    </div>

                </div>
                <div class="clearfix"></div>
            </div>

            <div class="text-right">
                <button type="button" class="btn btn-default"  ng-click="cancel()"  data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="button" class="btn btn-primary" ng-click="submit(formData.$invalid)" ng-disabled="saving"><i class="fa fa-check"></i> Upload New Block</button>
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
        window.listMapType = {!!json_encode(getMapTypeTCM())!!};
        window.listFieldType = {!!json_encode($listFieldType)!!};
        window.listIdCheck = {!!json_encode(getTypeFollowIdTCM())!!};
        window.listAttributeDataOption = {!!json_encode(getAttributeDataOption())!!};
    </script>
    {!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}

    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-all.min.js')!!}
    {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}


    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/blocks/BlockManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/BlockManagerController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/RequestBlockController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/RequestBlockService.js?v='.getVersionScript())!!}

        {!! Html::script('app/components/blocks/partial/UploadNewBlockController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/partial/InsertBlockLinkAssetController.js?v='.getVersionScript())!!}

        {!! Html::script('app/shared/cms-content/cmsContentFolderService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/cms-content/cmsContentInsertService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file-upload/fileTicketUploadDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/RequestNewBlockDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/blocks/BlockDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}

        {!! Html::script('app/shared/cms-config-field/ConfigFieldController.js?v='.getVersionScript())!!}
        {!! Html::script('/app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/block.js') }}"></script>
     @endif
@stop
