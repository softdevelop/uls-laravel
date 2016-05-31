@extends('app')
@section('title')
    Template Manager
@endsection
@section('content')
<div ng-controller="" class="wrap-content-management block-manager">
    <div class="top-content">
        <label class="c-m content-management">
            <a class="c-breadcrumb" href="/cms/template-content-manager">CMS Template Manager</a> / Update Template
        </label>

    </div>

    <div class="content margin-top-0">

        <div class="assets" ng-init="">
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
                    <label class="label-form" for="name">Type:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
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
                    <label class="label-form" for="">Description:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <textarea class="form-control" rows="4" cols="143" name="description" id="description" ng-model="block.description" ng-required="true" placeholder="Description"></textarea>
                        <div class="pull-left">
                            <small class="help-inline ng-invalid" ng-show="submitted && formData.description.$error.required">Description is required field.</small>
                            {{-- <small class="help-inline ng-invalid" ng-show="submitted && requiredDescription">Description is required field.</small> --}}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <!-- Input Description-->
                <div class="form-group" >
                    <label class="label-form" for="">Content:<span class="text-require"> *</span></label>
                    <div class="clearfix"></div>
                    <div class="wrap-content-review-and-code">

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                {{-- <a href="javascript:void(0)" ng-click="showCodeBlock()" aria-controls="code" role="tab" data-toggle="tab">Code</a> --}}
                                <button class="btn btn-code btn-lg" href="#code" ng-click="showCodeBlock()" aria-controls="code" role="tab" data-toggle="tab">Code</button>
                                {{-- <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a> --}}
                            </li>

                            <li role="presentation">
                                {{-- <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a> --}}
                                {{-- <a href="javascript:void(0)" ng-click="reViewBlock()" aria-controls="review" role="tab" data-toggle="tab">Review</a> --}}
                                <button class='btn btn-review btn-lg' href="#review" ng-click="reViewBlock()" aria-controls="review" role="tab" data-toggle="tab">Review</button>
                            </li>

                        </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane in active padding-none" id="code" ng-show="isShowCode">

                            <div class="col-lg-12 padding-none" id="code" >
                                <textarea class="form-control" rows="4" cols="50" name="editor" id="editor"></textarea>

                            </div>
                            <div class="clearfix"></div>
                            <div class="wrap-link-input">
                                <a class="link-insert-code" ng-click="callModalInsert('insert-link', 'null', 'null')">Insert Link</a> <span class="insert-object"> | </span>
                                <a class="link-insert-code" ng-click="callModalInsert('insert-block', 'null', 'null')">Insert Block</a> <span class="insert-object"> | </span>
                                <a class="link-insert-code" ng-click="callModalInsert('insert-asset', 'null', 'null')">Insert Asset</a>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane padding-none" id="review" ng-show="isShowReView">
                            <div class="full-height" id="re_view">
                                <iframe name="myframeBlock" id="frameBlock" class="full-height review-iframe" src="/cms/block-manager/review-content-block"></iframe>
                            </div>

                        </div>
                        <div class="pull-left">
                            <small class="help-inline ng-invalid" ng-show="submitted && requiredEditorContent">Content is required field.</small>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    </div>


                </div>


                <!-- Thumbnail -->
                <div class="form-group">
                    <div class="drop-file col-lg-12 padding-none">
                        <button class="btn btn-upload pull-left" ng-model="block.thumbnail"
                                ngf-select
                                ngf-reset-model-on-click="false"
                                ngf-accept="'image/*'"
                                accept="image/*">
                            <i class="fa fa-image"></i> Choose Thumbnail
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

                <div class="text-right">
                    <button type="button" class="btn btn-default"  ng-click="cancel()"  data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="button" class="btn btn-primary" ng-click="submit(formData.$invalid)" ng-disabled="saving"><i class="fa fa-check"></i> Save</button>
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
        window.baseUrl  = '{{URL::to("")}}';
    </script>

      {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}
      {!! Html::script('bower_components/ng-file-upload/ng-file-upload.min.js')!!}
    @if(!isProduction() && !isDev())
        {!! Html::script('/app/components/templatemanager/TemplateManagerService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/templatemanager/TemplateManagerController.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/template.js') }}"></script>
     @endif
@stop
