@extends('app')
@section('title')
	{{ trans('Role/role-permission-group.user_group_administration') }}
@stop
@section('content')


<div data-ng-controller="RoleGroupController">
    <div class="top-content">
	    <ul class="breadcrumb br-ticket1 top-content">
		    <li>
		        <a href="{{URL::to('admin/user/roles/user-group')}}">{{ trans('Role/role-permission-group.user_group_administration') }}</a>
		    </li>
		    <li class="active">
		        <a  href="javascript:void(0)">{{ trans('Role/role-permission-group.update_permission_for') }} <strong>{{$group->name}}</strong></a>
		    </li>
		</ul>
	</div>
	
	<div class="content wrap-permission-user">
		<h4>{{ trans('Role/role-permission-group.roles') }}</h4>
		<multi-select data-placeholder="Roles" error='error' message="message.role" data-items="listRoles" data-items-assigned="groupRoles" data-on-change="updateRole()"> </multi-select>
		<h4>{{ trans('Role/role-permission-group.permissions') }}</h4>		
		<multi-select data-items="listPermissions" error='error' message="message.per" data-items-assigned="groupPermissions" data-on-change="updatePermission()"> </multi-select>
	</div>
</div>

@stop
{{-- @section('scripts-modules') --}}
	<script>
	    modules = ['xeditable', 'multiSelect'];
	    window.dataController = {
	    	'id': {{$id}},
	    	'listPermissions' : {!!json_encode($listPermissions)!!},
	    	'groupPermissions' : {!!empty($groupPermissions)? '{}': json_encode($groupPermissions)!!},
	    	'listRoles'       : {!!json_encode($listRoles)!!},
	    	'groupRoles'       : {!!empty($groupRoles)? '{}': json_encode($groupRoles)!!}
	    };
	</script>
{{-- @stop --}}
@section('script')
	 @if(!isProduction() && !isDev())
		{!! Html::script('app/components/role/roleGroupPermissionController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/role/roleGroupService.js?v='.getVersionScript())!!}
		{!! Html::script('app/shared/multi-select/multiSelectDirective.js?v='.getVersionScript())!!}
	@else
	    <script src="{{ elixir('app/pages/group-permission.js') }}"></script>
	@endif
@stop