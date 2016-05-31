<style>
    .btn-info {
        display: none!important;
    }

    .btn-info.active {
        display: block!important;
    }

    .redactor-toolbar.toolbar-fixed-box {
        visibility: visible !important;
    }
</style>
<div class="form-group" ng-repeat="field in listField">

    <div ng-if="field.form" class="fix-editor">
        <div ng-if="!field.multiple">
            <label class="label-form">
                <span>@{{field.name}}:<span class="text-require"> *</span></span>
            </label>
            <div class="wrap-form">
                <form-builder content="field.form" ng-if="!url[curFields[field.variable]]"> </form-builder>

                <div class="m-t-15" ng-if="url[curFields[field.variable]]">
                    <div class="" style="padding: 10px;width: 150px;height: 70px;border: 1px solid #e3e3e3;">
                        <img style="position:absolute;top:0px;left:0px;bottom:0px;right:0px;min-width: auto;min-height: auto; width: auto; height: auto; max-width: 100%; max-height: 100%; margin: auto;" ng-src="@{{url[curFields[field.variable]]}}">
                        <a style="left: 125px!important;top: 0px!important"class="action-thum-up" href="javascript:void(0);"><i ng-click="removeThumbnailAssert(curFields[field.variable], field.variable)" class="fa fa-times"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <small class="help-inline" ng-show="submitted && formDataModal.@{{field.variable}}.$error.required">
                    <span class="capitalize">@{{field.name}}</span> is a required field
                </small>

                <small class="help-inline" ng-show="submitted && !formDataModal.@{{field.variable}}.$error.required && formDataModal.@{{field.variable}}.$invalid">
                    <span class="capitalize">@{{field.name}}</span> is invalid
                </small>

            </div>
        </div>

        <div class="wrap-box-title" ng-if="field.multiple" ng-repeat="(key, field_el) in multiFieldFollowVariable[field.variable]" ng-if="field.multiple && field_el.id == field.variable+field_el.key_field">
            <label class="label-form" ng-show="field.multiple">
                @{{field.name}}:<span class="text-require"> *</span> &nbsp
                <a id="addFieldType_@{{$index}}" class="pointer btn btn-xs btn-upload" ng-click="addNewField(field)"  ng-if="field.multiple && (field.max_field > 1 || !field.max_field) && field_el.key_field == 0">
                    <i class="fa fa-plus-square"></i>  Add</a>
                <span ng-if="field.multiple" class="pointer" ng-click="removeCurrentField(field, field_el.key_field)" ng-show="field_el.key_field != 0">
                    <i class="fa fa-times"></i>
                </span>
            </label>
            <div class="wrap-form form-group">
                <form-builder content="field.form" ng-if="!url[curFields[field.variable][field_el.key_field]]"> </form-builder>

                <div class="m-t-30" ng-if="url[curFields[field.variable][field_el.key_field]]">
                    <div class="" style="padding: 10px;width: 150px;height: 70px;border: 1px solid #e3e3e3;">
                        <img style="position:absolute;top:0px;left:0px;bottom:0px;right:0px;min-width: auto;min-height: auto; width: auto; height: auto; max-width: 100%; max-height: 100%; margin: auto;" ng-src="@{{url[curFields[field.variable][field_el.key_field]]}}">
                        <a style="left: 125px!important;top: 0px!important"class="action-thum-up" href="javascript:void(0);"><i ng-click="removeThumbnailAssert(curFields[field.variable], field.variable, field_el.key_field)" class="fa fa-times"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <small class="help-inline" ng-show="submitted && formDataModal.@{{field.variable}}_@{{field_el.key_field}}.$error.required">
                    <span class="capitalize">@{{field.name}}</span> is a required field
                </small>
                <small class="help-inline" ng-show="submitted && !formDataModal.@{{field.variable}}_@{{field_el.key_field}}.$error.required && formDataModal.@{{field.variable}}_@{{field_el.key_field}}.$invalid"><span class="capitalize">@{{field.name}}</span> is invalid</small>

            </div>
            <div class="clearfix"></div>
            <div id="addFormModel@{{$index}}" class="col-lg-12">

            </div>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
    </div>
    
    <div ng-if="!field.form">
        <div ng-if="field.type != 'select' && field.type != 'textarea'">
            @include('cms-content.partial.input-template')
        </div>
        <div id="field_@{{field._id.$id}}" ng-if="field.type == 'select'">
            @include('cms-content.partial.select-template')
        </div>
        <div id="field_@{{field._id.$id}}" ng-if="field.type == 'textarea'">
            @include('cms-content.partial.text-area-template')
        </div>
        <div class="clearfix"></div>
    </div>
</div>
