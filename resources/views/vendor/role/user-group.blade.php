@extends('app')
@section('title')
	{{ trans('Role/role-user-group.user_group_administration') }}
@stop
@section('content')
<div ng-controller="RoleGroupController">
	<div class="top-content">
	    <label class="c-m">{{ trans('Role/role-user-group.user_group_administration') }}</label>
	    <a href="javascript:void(0)" ng-click="addGroup()" class="btn btn-primary pull-right fix-btn-top-content">
	    	<i class="fa fa-plus"></i> {{ trans('Role/role-user-group.add_group') }}
	    </a>
	</div>
	<div class="content user-group">
		<div class="title-table">
			<div class="table-responsive hidden" id="tb-group-user"> 
				<table class="table">
					<thead>
						<th class="w50"></th>
						<th>
							{{ trans('Role/role-user-group.name') }}
						</th>
						<th>
							{{ trans('Role/role-user-group.action') }}
						</th>
					</thead>
					<tbody class="icon-in-table">
						<tr ng-repeat="userGroup in lists_group_user | orderBy:'name'">
							<td class="text-center">
								<a class='user-gr-icon'><i class="fa fa-group"></i></a>
							</td>
							<td class="text-left">
								<span>@{{userGroup.name}}</span>
							</td>

							<td class="show-action action text-center" data-title="{{ trans('Role/role-user-group.action') }}">
			                    <div class="wrap-ac-group">
			                        <i ng-disabled="item.deleted_at != null" ng-click="showGroup($event)" class="fa fa-ellipsis-v pointer"></i>
			                        <ul class="group-btn-ac affix">
			                            <li>
			                                <a class="text-show-action" ng-href="@{{baseUrl}}/admin/user/roles/user-group/@{{userGroup.id}}" href="javascript:void(0)"  name="click"><i class="fa fa-key"></i> {{ trans('Role/role-user-group.update_permissions') }}</a>
			                            </li>
			                            <li>
			                                <a class="text-show-action" ng-click="addGroup(userGroup.id, userGroup)" href="javascript:void(0)" name="click"><i class="fa fa-pencil"></i>{{ trans('Role/role-user-group.edit') }}</a>
			                            </li>
			                            <li>
			                                <a class="text-show-action" ng-click="removeUserGroup(userGroup.id)" href="javascript:void(0)"><i class="fa fa-times"></i>{{ trans('Role/role-user-group.delete') }}</a>
			                            </li>
			                        </ul>
			                    </div>
			                </td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop
{{-- @section('scripts-modules') --}}
	<script>
	    modules = ['xeditable','ngTable'];
	    window.userGroupInfor = {!! json_encode($userGroupInfor) !!};
	</script>
{{-- @stop --}}
@section('script')
	 @if(!isProduction() && !isDev())
		{!! Html::script('app/components/role/roleGroupController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/role/roleGroupService.js?v='.getVersionScript())!!}
		{!! Html::script('app/shared/search/searchDirective.js?v='.getVersionScript())!!}
		{{-- {!! Html::script('app/components/role/roleGroupDirective.js?v=getVersionScript()')!!} --}}
	@else
	    <script src="{{ elixir('app/pages/roleGroup.js') }}"></script>
	@endif
@stop