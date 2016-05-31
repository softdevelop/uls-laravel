<div ng-controller="RoleUserController" ng-init="setDataUsersAndGroups({{json_encode($usersAndGroups)}}, {{$id}}, {{json_encode($groupAvailable)}}, {{json_encode($userIdsAssigned)}})">
<div class="col-lg-5 padding-none-1200">
    @include('users::role.partial.landingPage')
    <div class="box-w-n m-t-20">
            <div class="table-responsive table-action-user"> 
                <table class="table box-w-n-group">
                        <thead>
                            <tr class="title-box-r">
                                <th colspan="2" class="top-title-left">
                                    <span class="hidden-480">@{{roleData.name}} - {{ trans('Role/role-users-in-group.available_users_and_groups') }}</span>
                                    <span class="visible-480">
                                    <p>@{{roleData.name}} -</p>
                                    <p class="margin-none">{{ trans('Role/role-users-in-group.available_users_and_groups') }}</p>
                                    </span>
                                </th>
                                <th class="top-title-right action-add-u">
                                   <a ng-click="switchAssign()" href="javascript:void(0)" class="position-360"><i class="fa fa-plus"></i>&nbsp<i ng-class="{'ti-user':!isSelectGroup, 'fa fa-group':isSelectGroup}"></i></a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="search-u-g">
                            <tr>
                                <td colspan="3">
                                     <input ng-model="search.name" type="text" name="search-users" placeholder="@{{!isSelectGroup ? 'Select Group' :'Search Users'}}" value="">
                                </td>
                            </tr>
                            <tr ng-repeat="(key, value) in usersAndGroupsAvailable|filter:search | orderBy:'name'">
                                <td colspan="3" ng-if="value.email">
                                    <div class="role-user-img">
                                        <img ng-src="@{{users_map[value.id].avatar}}" ng-if="value.email" alt="" class="img-circle" width="30" height="30">
                                    </div>
                                    
                                    <div class="role-user-name">
                                        <a class="c-000">@{{value.name}}</a>    
                                    </div>
                                    
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{{ trans('Role/role-users-in-group.add_this_user_or_group_to_the_role') }}" ng-click="attachUserOrGroup(value.id, value.email)"><i class="fa  fa-plus-square pull-right"></i></a>
                                </td>
                                <td colspan="3" ng-if="!value.email">
                                    <i data-toggle="collapse" data-target="#collapseExampleGroup-@{{value.id}}" aria-expanded="false" aria-controls="collapseExampleGroup-@{{value.id}}" class="pointer fa fa-group"></i>
                                    <a data-toggle="collapse"  data-target="#collapseExampleGroup-@{{value.id}}" aria-expanded="false" aria-controls="collapseExampleGroup-@{{value.id}}" href="#" class="c0-b m-l-30"><i></i>@{{value.name}}</a>
                                    <a id="dt" data-toggle="tooltip" data-placement="top" title="{{ trans('Role/role-users-in-group.add_this_user_or_group_to_the_role') }}" ng-click="attachUserOrGroup(value.id, value.email)" href="javascript:void(0)"><i class="fa  fa-plus-square pull-right"></i></a>
                                       <div class="collapse m-t-15" id="collapseExampleGroup-@{{value.id}}">
                                          <div class="sub-td well" ng-repeat="(key, value) in value.users">
                                            <div>
                                                <div class  ="w-item">
                                                    <img ng-src="@{{value.avatar}}" alt="" class="img-circle" width="30" height="30">
                                                    <span>&nbsp</span> <span>@{{value.first_name}} @{{value.last_name}}</span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div>
    </div>
</div>
<div class="col-lg-7 padding-none-1200 fix-bt-remove">
    <div class="box-w-n">
            <div class="table-responsive table-action-user"> 
                <table class="table box-w-n-group">
                        <thead>
                            <tr class="title-box-r">
                                <th colspan="3" class="top-title-left">
                                    <span class="hidden-480">@{{roleData.name}} - {{ trans('Role/role-users-in-group.assigned_users_and_groups') }}</span>
                                    <span class="visible-480">
                                        <p>@{{roleData.name}} -</p>
                                        <p class="margin-none">{{ trans('Role/role-users-in-group.assigned_users_and_groups') }}</p>
                                    </span>
                                </th>
                            </tr>

                        </thead>
                        <tbody class="search-u-g">
                            <tr ng-repeat="(key, value) in usersAndGroups | orderBy:'name'">
                                <td  ng-if="value.email">
                                    <img ng-src="@{{users_map[value.id].avatar}}" ng-if="value.email" alt="" class="img-circle" width="30" height="30">
                                    <a class="c-000 m-l-30">@{{value.name}}</a>
                                </td>
                                <td  ng-if="!value.email">
                                    <i data-toggle="collapse" data-target="#collapseExampleGroup-@{{value.id}}" aria-expanded="false" aria-controls="collapseExampleGroup-@{{value.id}}" class="pointer fa fa-group"></i>
                                    <a data-toggle="collapse"  data-target="#collapseExampleGroup-@{{value.id}}" aria-expanded="false" aria-controls="collapseExampleGroup-@{{value.id}}" href="#" class="c0-b m-l-30"><i></i>@{{value.name}}</a>
                                       <div class="collapse m-t-15" id="collapseExampleGroup-@{{value.id}}">
                                          <div class="sub-td well" ng-repeat="(key, value) in value.users">
                                            <div>
                                                <div class  ="w-item">
                                                    <img ng-src="@{{value.avatar}}" alt="" class="img-circle" width="30" height="30">
                                                    <span>&nbsp</span> <span>@{{value.first_name}} @{{value.last_name}}</span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="{{ trans('Role/role-users-in-group.remove_this_user_or_group_from_the_role') }}" ng-click="detachAssignedUserAndGroup(value.id, value.email)"><i class="fa fa-minus-square pull-right"></i></a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
            </div>
    </div>
</div>
<div class="clearfix"></div>
</div>

