<div class="col-lg-5 m-b-20 padding-none-1200">
@include('users::permission.partial.landingPage')
</div>
<div class="col-lg-7 padding-none-1200" ng-controller="PermissionEditorController"  ng-init="perm={{json_encode($permission)}}">
    <div class="box-w-n">
        <div class="border-box-ccc box-w-n-edit">
            <h5 class="margin-none title-box-r">@{{permission.name}} - {{ trans('Permission/permission-editor.user_details') }}</h5>
            <div class="space-role-detail">
                <div class="form-group">
                    <label class="col-lg-12 label-title-edit f700">{{ trans('Permission/permission-editor.permission_name') }}:</label>
                    <div class="col-lg-12">
                        <div class="fix-input-pl">
                            <a href="#" onbeforesave="checkNamePerm($data,perm.id)" editable-text="perm.name">@{{ perm.name || 'empty' }}</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12 label-title-edit f700">{{ trans('Permission/permission-editor.permission_slug') }}:</label>
                    <div class="col-lg-12">
                        <span>@{{perm.slug}}</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12 form-group f700">{{ trans('Permission/permission-editor.permission_description') }}: </label>

                    <div class="col-lg-12 fix-btn-pl">
                        <a href="#" onbeforesave="checkDescription($data)" editable-textarea="perm.description" e-class="form-control" e-rows="5" e-cols="197">
                            <pre>@{{ perm.description || 'no description' }}</pre>
                        </a>
                        <div class="editable-error help-block ng-binding c-primary" ng-show="errorPer">The Permission do not exist!</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>  
    </div>
</div>
    
    