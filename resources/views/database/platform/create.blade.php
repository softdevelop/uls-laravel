@extends('app')
@section('title')
    Platforms
@endsection
@section('content')
<div ng-controller="PlatformsController" class="wrap-content-management block-manager">
    <div class="top-content">
        <label class="c-m content-management">
            <span class="breadcrumb-level">
                <a class="c-breadcrumb" href="@{{baseUrl}}/cms/database-manager/set-database-selected/root_platform">Platforms</a> / @{{platform.id ? platform.name + ' / Edit' : 'Create' }}
            </span>
        </label>

    </div>
    <div class="content margin-top-0">
        <div class="alert alert-danger" ng-show="errors">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <span ng-repeat="error in errors">@{{error[0]}}<br></span>
        </div>

        <form role="form" name="formData" novalidate>
            <!-- Name -->
            <div class="form-group">
                <label class="label-form" for="name">Name:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control name" placeholder="Name" type="text" name="name" ng-model="platform.name" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.name.$error.required">Name is a required field.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Fiber -->
            <div class="form-group">
                <label class="label-form" for="name">Fiber:</label>
                <input type="checkbox" name="fiber" ng-checked="platform.fiber == 1 || platform.fiber == true" ng-model="platform.fiber"/>
                <div class="clearfix"></div>
            </div>
            
            <!-- Width Exceptions -->
            <div class="form-group">
                <label class="label-form" for="name">Width Exceptions:</label>
                <input type="checkbox" name="width_exceptions" ng-checked="platform.width_exceptions == 1 || platform.width_exceptions == true" ng-model="platform.width_exceptions"/>
                <div class="clearfix"></div>
            </div>

            <!-- Productivity -->
            <div class="form-group">
                <label class="label-form" for="name">Productivity:</label>
                <input type="checkbox" name="productivity" ng-checked="platform.productivity == 1 || platform.productivity == true" ng-model="platform.productivity"/>
                <div class="clearfix"></div>
            </div>

            <!-- Dual Laser -->
            <div class="form-group">
                <label class="label-form" for="name">Dual Laser:</label>
                <input type="checkbox" name="dual_laser" ng-checked="platform.dual_laser == 1 || platform.dual_laser == true" ng-model="platform.dual_laser"/>
                <div class="clearfix"></div>
            </div>

            <!-- Multiple Laser -->
            <div class="form-group">
                <label class="label-form" for="name">Multiple Laser:</label>
                <input type="checkbox" name="multiple_laser" ng-checked="platform.multiple_laser == 1 || platform.multiple_laser == true" ng-model="platform.multiple_laser"/>
                <div class="clearfix"></div>
            </div>

            <!-- Width -->
            <div class="form-group">
                <label class="label-form" for="name">Width (Inches):<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control" placeholder="Width" type="number" name="width" ng-model="platform.width" min="0" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.width.$error.required">Width is a required field.</small>
                        <small class="help-inline" ng-show="submitted && formData.width.$error.min">Width minumum is 0.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Height -->
            <div class="form-group">
                <label class="label-form" for="name">Height (Inches):<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control" placeholder="Height" type="number" name="height" ng-model="platform.height" min="0" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.height.$error.required">Height is a required field.</small>
                        <small class="help-inline" ng-show="submitted && formData.height.$error.min">Height minimum is 0.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Depth -->
            <div class="form-group">
                <label class="label-form" for="name">Depth (Inches):<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control" placeholder="Depth" type="number" name="depth" ng-model="platform.depth" min="0" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.depth.$error.required">Depth is a required field.</small>
                        <small class="help-inline" ng-show="submitted && formData.depth.$error.min">Depth minimum is 0.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Max CO2 Laser Power -->
            <div class="form-group">
                <label class="label-form" for="name">Max CO2 Laser Power:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control" placeholder="Max CO2 Laser Power" type="number" min="0" name="max_co2_lsrpwr"
                            integer-input
                            ng-model="platform.max_co2_lsrpwr" 
                            ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.max_co2_lsrpwr.$error.required">Max CO2 Laser Power is a required field.</small>
                        <small class="help-inline" ng-show="submitted && formData.max_co2_lsrpwr.$error.min">Max CO2 Laser Power minimum is 0.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="label-form" for="name">Description:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <textarea class="form-control" id="description" name="description" ng-init="initCodeMirror()"></textarea>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && desRequired">Description is a required field.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Meta Description -->
            <div class="form-group">
                <label class="label-form" for="name">Meta Description:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <textarea class="form-control" id="meta-description" name="description" ng-init="initCodeMirrorMetaDes()"></textarea>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && metaDesRequired">Meta Description is a required field.</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label class="label-form" for="name">Image:</label>
                <file-upload-directive file-type="'image/*'" files="platform.image" is-multi=false ng-model="filesUpload"></file-upload-directive>
                <div class="clearfix"></div>
            </div>
        </form>
        <div class="clearfix"></div>
        <div class="text-right form-group action-bottom">
            <a type="button" class="btn btn-default" ng-disabled="saving" ng-click="cancel()" href="@{{baseUrl}}/cms/database-manager/set-database-selected/root_platform" target="_self">
                <i class="fa fa-times"></i> Cancel
            </a>
            <a type="button" class="btn btn-primary" ng-click="createPlatform(formData.$invalid)" ng-disabled="saving || !filesUpload.finished">
                <i class="fa fa-check"></i> Create
            </a>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="clearfix"></div>

</div>
@stop
@section('script')
    <script type="text/javascript">
        window.platform = {!! json_encode($platform) !!}
    </script>
    @if(!isProduction() && !isDev())
        {!! Html::script('app/shared/cms-content/CmsService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/platforms/PlatformsService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/platforms/PlatformsController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file-upload-directive/fileUploadDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/create-platforms.js') }}"></script>
    @endif
@stop
