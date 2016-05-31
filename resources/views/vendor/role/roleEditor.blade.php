<div class="col-lg-5 m-b-20 padding-none-1200">
    @include('users::role.partial.landingPage')
</div>
<div ng-controller="RoleEditorController" class="col-lg-7 padding-none-1200 edit-role" ng-init="role={{json_encode($role)}}">
    <div class="box-w-n">
        <div class="border-box-ccc box-w-n-edit">
            <h5 class="margin-none title-box-r">@{{roleData.name}} -{{ trans('Role/role-editor.user_details') }}</h5>
            <div class="space-role-detail">
                <div class="form-group">
                    <label class="col-lg-12 label-title-edit f700">{{ trans('Role/role-editor.role_name') }}:</label>
                    <div class="col-lg-12">
                        <div class="fix-input-pl">
                            <a href="#" onbeforesave="checkNameRole($data,role.id)" editable-text="role.name">@{{ role.name || 'empty' }}</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12 label-title-edit f700">{{ trans('Role/role-editor.role_slug') }}:</label>
                    <div class="col-lg-12">
                        <span>@{{role.slug}}</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="col-lg-12 form-group f700">{{ trans('Role/role-editor.role_description') }} : </label>

                    <div class="col-lg-12 fix-btn-pl">
                        <a href="#" onbeforesave="checkDescriptionRole($data,role)" editable-textarea="role.description" e-class="form-control" e-rows="5" e-cols="197">
                            <pre>@{{ role.description || 'no description' }}</pre>
                        </a>
                        <div class="editable-error help-block ng-binding c-primary" ng-show="errorRole">The Role do not exist!</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>  
    </div>
</div>
