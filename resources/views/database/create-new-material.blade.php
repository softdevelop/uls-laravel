@extends('app')
@section('title')
    {{trans('cms_database/create-category.title')}}
@endsection
@section('content')
<div ng-controller="MaterialsController" class="wrap-content-management block-manager">
    <div class="top-content">
        <label class="c-m content-management">
            <span class="breadcrumb-level">
                <a class="c-breadcrumb" href="@{{baseUrl}}/cms/database-manager">{{trans('cms_database/create-category.breadcrumb_first')}} /&nbsp;
                <a class="c-breadcrumb" href="@{{baseUrl}}/cms/database-manager/set-database-selected/{{ $_GET['type'] == 'accessories' ? 'root_accessories': 'root_material'}}" title=""> {{$_GET['type'] == 'accessories' ? 'Accessories': 'Material'}}</a> / {{trans('cms_database/create-category.breadcrumb_last_create')}}</a>
            </span>
        </label>

    </div>
    <div class="content margin-top-0">
        <div>
            <form role="form" name="formData" novalidate>
       
                <input type="hidden" ng-model="material.type" ng-init="material.type='{{$_GET['type']}}'" value="{{$_GET['type']}}">

                <div class="form-group">
                    <label class="label-form" for="name">
                        {{trans('cms_database/create-category.category_label')}}:<span class="text-require"> *</span>
                    </label>
                    <div class="wrap-form show-full-width-select">
                        <select-level items="{{json_encode($categories)}}" show-icon="true" text="{{trans('cms_database/create-category.category_placeholder')}}" text-filter="Filter folder" ng-model="material.category_id" selected-item="{{json_encode($selectedItem)}}" ></select-level>
                        <div>
                            <small class="error" ng-show="submitted && material.category_id==null">{{trans('cms_database/create-category.category_required')}}</small>
                        </div>   
                    </div>
                    <div class="clearfix"></div>
                </div>

                <!-- Name -->
                <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.name_label')}}:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input class="form-control name" placeholder="{{trans('cms_database/create-category.name_placeholder')}}" type="text" name="name" ng-model="material.name" ng-required = "true" />
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.name.$error.required">{{trans('cms_database/create-category.name_required')}}</small>
                            <small class="help-inline" ng-show="submitted && nameError && !formData.name.$error.required">{{trans('cms_database/create-category.name_exists')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @if($type == 'materials')
              @include('database.partial.create_material')
            @elseif($type == 'accessories')
                @include('database.partial.create_accessories')
            @endif

            </form>
            <div class="clearfix"></div>

            <div class="text-right form-group action-bottom">
                <a type="button" class="btn btn-default"  ng-click="cancel()" href="@{{baseUrl}}/cms/database-manager/set-database-selected/root_material" target="_self" data-dismiss="modal">
                    <i class="fa fa-times"></i> {{trans('cms_database/create-category.cancel_btn')}}
                </a>
                <a type="button" class="btn btn-primary" ng-click="createMaterial(formData.$invalid)" ng-disabled="saving"><i class="fa fa-check"></i> {{trans('cms_database/create-category.submit_btn')}}</a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

</div>
@stop
@section('script')
    <script type="text/javascript">
       window.material = {!! json_encode($material)!!}

    </script>
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/materials/MaterialsService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/materials/MaterialsController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/database/selectLevelDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file-upload-directive/fileUploadDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/create-new-material.js') }}"></script>
    @endif
@stop
