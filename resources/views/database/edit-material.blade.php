@extends('app')
@section('title')
    {{trans('cms_database/create-category.title')}}
@endsection
@section('content')
<div ng-controller="MaterialsController" class="wrap-content-management block-manager">
    <div class="top-content">
        <label class="c-m content-management">
            <span class="breadcrumb-level">
                <a class="c-breadcrumb" href="@{{baseUrl}}/cms/database-manager">{{trans('cms_database/create-category.breadcrumb_first')}} / </a>
                <a class="c-breadcrumb" href="@{{baseUrl}}/cms/database-manager/set-database-selected/{{ $_GET['type'] == 'accessories' ? 'root_accessories': 'root_material'}}" title=""> {{$_GET['type'] == 'accessories' ? 'Accessories': 'Material'}}</a> / {{trans('cms_database/create-category.breadcrumb_last_create')}}</a>
            </span>
            <span>{{$material['name']}} / {{trans('cms_database/create-category.breadcrumb_last_edit')}}</span>
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
                    <div class="wrap-form show-full-width-select" >
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


                <!-- Engrave mark -->
                <!-- <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.engmare_mark_label')}}:</label>
                    <div class="checkbox checkbox-success checkbox-inline">
                        <input  type="checkbox" id="checkbox-engrave" name="engrave_mark" ng-checked="material.engrave_mark == true" ng-model="material.engrave_mark"/>
                        <label for="checkbox-engrave">
                        </label>
                    </div>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.engrave_mark.$error.required">{{trans('cms_database/create-category.engmare_mark_required')}}</small>
                    </div>
                    <div class="clearfix"></div>
                </div> -->

                <!-- Cut-->
              <!--   <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.cut_label')}}:</label>
                    <div class="checkbox checkbox-success checkbox-inline">
                        <input  type="checkbox" id="checkbox-cut" name="cut" ng-checked="material.cut == true" ng-model="material.cut"/>
                        <label for="checkbox-cut">
                        </label>
                    </div>
                    <div class="clearfix"></div>
                </div>
 -->
                <!-- Engrave mark recommended power-->
               <!--  <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.engrave_mark_recommended_power_label')}}:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input type="number" class="form-control name" name="engrave_mark_recommended_power" ng-model="material.engrave_mark_recommended_power" ng-required = "true">
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.engrave_mark_recommended_power.$error.required">{{trans('cms_database/create-category.engrave_mark_recommended_power_required')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div> -->
                
                <!-- Min thickness-->
               <!--  <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.min_thickness_label')}}:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input type="number" step="0.001" class="form-control name" name="min_thickness" ng-model="material.min_thickness" ng-required = "true">
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.min_thickness.$error.required">{{trans('cms_database/create-category.min_thickness_required')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div> -->
                
                <!-- Power at min thickness-->
              <!--   <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.min_thickness_label')}}:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input type="number" class="form-control name" name="power_at_min_thickness" ng-model="material.power_at_min_thickness" ng-required = "true">
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.power_at_min_thickness.$error.required">{{trans('cms_database/create-category.min_thickness_required')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div> -->

                <!-- Max thickness-->
             <!--    <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.max_thickness_label')}}:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input type="number" step="0.001" class="form-control name" name="max_thickness" ng-model="material.max_thickness" ng-required = "true">
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.max_thickness.$error.required">{{trans('cms_database/create-category.max_thickness_required')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div> -->

                <!-- Power at max thickness-->
                <!-- <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.power_at_max_thickness_label')}}:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input type="number" class="form-control name" name="power_at_max_thickness" ng-model="material.power_at_max_thickness" ng-required = "true">
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.power_at_max_thickness.$error.required">{{trans('cms_database/create-category.power_at_max_thickness_required')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div> -->

                <!-- Wave length-->
               <!--  <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.wave_length_label')}}:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input type="number" step="0.01" class="form-control name" name="wave_length" ng-model="material.wave_length" ng-required = "true">
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.wave_length.$error.required">{{trans('cms_database/create-category.wave_length_required')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div> -->

                <!-- Width length-->
               <!--  <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.width_length_label')}}:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input type="number" step="0.01" class="form-control name" name="width" ng-model="material.width" ng-required = "true">
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.width.$error.required">{{trans('cms_database/create-category.width_length_required')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div> -->

                <!-- Height length-->
                <!-- <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.height_length_label')}}:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input type="number" step="0.01" name="height" ng-model="material.height" ng-required = "true">
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.height.$error.required">{{trans('cms_database/create-category.height_length_required')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div> -->

                <!-- Depth length-->
              <!--   <div class="form-group">
                    <label class="label-form" for="name">{{trans('cms_database/create-category.depth_length_label')}}:<span class="text-require"> *</span></label>
                    <div class="wrap-form">
                        <input type="number" step="0.01" class="form-control name" name="depth" ng-model="material.depth" ng-required = "true">
                        <div class="pull-left">
                            <small class="help-inline" ng-show="submitted && formData.depth.$error.required">{{trans('cms_database/create-category.depth_length_required')}}</small>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
 -->
            </form>
            <div class="clearfix"></div>

            <div class="text-right form-group action-bottom">
                <a type="button" class="btn btn-default"  ng-click="cancel()" href="@{{baseUrl}}/cms/database-manager/set-database-selected/root_material" target="_self" data-dismiss="modal">
                    <i class="fa fa-times"></i> {{trans('cms_database/create-category.cancel_btn')}}
                </a>
                <a type="button" class="btn btn-primary" ng-click="updateMaterial(formData.$invalid)" ng-disabled="saving"><i class="fa fa-check"></i> {{trans('cms_database/create-category.submit_btn')}}</a>
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
        {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file-upload-directive/fileUploadDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/database/selectLevelDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/edit-material.js') }}"></script>
    @endif
@stop
