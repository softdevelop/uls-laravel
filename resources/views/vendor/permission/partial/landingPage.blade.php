<div ng-if="error && message!=''" class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    @{{message}}
</div>
<div class="border-box-ccc">
    <h5 class="margin-none title-box-r">{{ trans('Permission/permission-landing-page.permissions') }}</h5>
    <div id="box-Permission">
        <div class="w-item" ng-class="{'active':permissionId == value.id}" ng-repeat="(key, value) in items_s | orderBy:'name'">
            <span class="item pull-left">@{{value.name}}</span>
            <span class="action pull-right">
            <a class="" href="" data-toggle="tooltip" ng-click="selectFeature('user', value)" data-placement="left" title="{{ trans('Permission/permission-landing-page.add_user_or_group') }}">
                <i class="fa fa-users"></i>
            </a>
           
            <a class="" href=""data-toggle="tooltip" ng-click="selectFeature('edit', value)" data-placement="left" title="{{ trans('Permission/permission-landing-page.edit_this_permission') }}">
                <i class="ti-pencil"></i>
            </a>
             <a class="" href=""data-toggle="tooltip" data-placement="left" ng-click="delete(value.id)" title="{{ trans('Permission/permission-landing-page.delete') }}">
                <i class="fa fa-trash-o"></i>
            </a>
           
            </span>
            <div class="clearfix"></div>
        </div> 
    </div>
</div>