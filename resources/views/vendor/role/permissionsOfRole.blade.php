<div class="col-lg-5 padding-none-1200" ng-init="setData({{json_encode($permissionsAvailbale)}}, {{json_encode($permissionsAssigned)}})">
    @include('users::role.partial.landingPage')
    <div class="box-w-n m-t-20 ">
            <div class="table-responsive table-action-user"> 
                <table class="table box-w-n-group">
                    <thead>
                        <tr class="title-box-r">
                            <th colspan="2" class="top-title-left">
                                <span class="hidden-480">@{{roleData.name}} {{ trans('Role/role-permissions-of-role.available_permissions') }}</span>
                                <span class="visible-480">
                                <p>@{{roleData.name}}</p>
                                <p class="margin-none">{{ trans('Role/role-permissions-of-role.available_permissions') }}</p>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="search-u-g">
                        <tr ng-repeat="(key, value) in permissionsAvailbale | orderBy:'name'">
                            <td>
                               @{{value.name}}
                            </td>
                            <td class="pull-right">
                               <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{{ trans('Role/role-permissions-of-role.add_this_permission_to_the_role') }}" ng-click="attachPermission(value.id)"><i class="fa fa-plus-square"></i></a> 
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
</div>
<div class="col-lg-7 padding-none-1200">
    <div class="box-w-n">
            <div class="table-responsive table-action-user"> 
                <table class="table box-w-n-group">
                        <thead>
                            <tr class="title-box-r">
                                <th colspan="2" class="top-title-left">
                                    <span class="hidden-480">@{{roleData.name}} {{ trans('Role/role-permissions-of-role.assigned_permissions') }}</span>
                                    <span class="visible-480">
                                        <p>@{{roleData.name}}</p>
                                        <p class="margin-none">{{ trans('Role/role-permissions-of-role.assigned_permissions') }}</p>
                                    </span>
                                </th>
                            </tr>

                        </thead>
                        <tbody class="search-u-g">
                             <tr ng-repeat="(key, value) in permissionsAssigned | orderBy:'name'">
                                <td>
                                     @{{value.name}}
                                </td>
                                <td>
                                     <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{{ trans('Role/role-permissions-of-role.remove_this_permission_from_the_role') }}" ng-click="detachPermission(value.id)"><i class="fa fa-minus-square pull-right"></i></a>
                                </td>
                              
                            </tr>
                        </tbody>
                    </table>
            </div>
    </div>
</div>
<div class="clearfix"></div>
