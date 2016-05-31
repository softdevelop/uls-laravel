@extends('app')
@section('title')
    Help Editor
@endsection
@section('content')
<div ng-controller="HelpEditorController" class="wrap-content-management block-manager">
    <div class="top-content">
        <label class="c-m content-management">
            <span class="breadcrumb-level">
                <a class="c-breadcrumb" href="@{{baseUrl}}/admin/help-editor">Help Editor /</a>
                @if(empty($help->_id))
                    <span> Create</span>
                @else
                    <span>{{$help->title}} / Edit</span>
                @endif
            </span>
        </label>

    </div>
    <div class="content margin-top-0">
        <div>
            <form role="form" name="formData" novalidate>
                <div ng-if="error && errors.help != '' && errors.title == ''" class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    Can not update this help.
                </div>
                <!-- choose parent -->
                <div class="form-group">
                    <label class="label-form" for="name">
                        Parent
                    </label>
                    <div class="wrap-form show-full-width-select">
                        <select-level-help items="{{json_encode($folders)}}" show-icon="true" text="Select Parent" text-filter="Filter folder" ng-model="helpEditor.parent_id" selected-item="{{json_encode($selectedItem)}}" ></select-level-help>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <!-- title -->
                <div class="form-group">
                    <label class="label-form" for="name">Title:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input class="form-control name" placeholder="Title" type="text" name="title" ng-model="helpEditor.title" ng-required = "true" />
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.title.$error.required">Title is required field.</small>
                            <small class="help-inline" ng-show="submitted && !formData.title.$error.required && errors.title != '' ">@{{errors.title[0]}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <!-- description -->
                <div class="form-group">
                    <label class="label-form" for="name">Description:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <textarea id="description" class="form-control" ng-init="initRedactor('description')" ng-model="helpEditor.description"></textarea>
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && isRequiredRedactor">Description is required field.</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="clearfix"></div>

            <div class="text-right form-group action-bottom">
                <a type="button" class="btn btn-default" ng-disabled="saving"  ng-click="cancel()" href="@{{baseUrl}}/admin/help-editor" target="_self" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </a>
                <a type="button" class="btn btn-primary" ng-click="createHelpEditor(formData.$invalid)" ng-disabled="saving"><i class="fa fa-check"></i> Save</a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

</div>
@stop
@section('script')
    <script type="text/javascript">
        window.helpEditor = {!! json_encode($help)!!}
    </script>
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/user/help-editor/HelpEditorService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/user/help-editor/HelpEditorController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/user/help-editor/SelectLevelHelp.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/help-editor.js') }}"></script>
    @endif
@stop
