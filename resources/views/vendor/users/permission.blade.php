@extends('app')
@section('title')
	{{ trans('User/user-index.breadcrum') }}
@stop
@section('content')

	<div data-ng-controller="UserController">
		<div class="top-content">
	        <ul class="breadcrumb br-ticket1 top-content">
	            <li>
	                <a href="{{URL::to('admin/user')}}">{{ trans('User/user-index.breadcrum') }}</a>
	            </li>
	            <li class="active">
	                <a  href="javascript:void(0)">{{ trans('User/user-update-permissions.text_breadcrum') }} <strong>{{$user->first_name}} {{$user->last_name}}</strong></a>
	            </li>
        	</ul>
	    </div>

		<div class="content wrap-permission-user">
			<h4 class="title-multiselect">{{ trans('User/user-update-permissions.roles') }}</h4>
			<multi-select error='error' message='message.role' placeholder="{{ trans('User/user-update-permissions.roles') }}" items="listRoles" items-assigned="userRoles" on-change="updateRole()"> </multi-select>
			
			<h4 class="title-multiselect">{{ trans('User/user-update-permissions.permissions') }}</h4>
			<multi-select error='error' message='message.per' items="listPermissions" items-assigned="userPermissions" on-change="updatePermission()"> </multi-select>
			
			<h4>{{ trans('User/user-update-permissions.groups') }}</h4>
			<multi-select error='error' message='message.group' placeholder="{{ trans('User/user-update-permissions.groups') }}" data-items="listGroups" data-items-assigned="userGroups" data-on-change="updateGroup()"> </multi-select>
		</div>
	</div>
	
@stop
@section('script')
	<script  type="text/javascript">
	     window.dataController = {
	    	'id': {{$id}},
	    	'listPermissions' : {!!json_encode($listPermissions)!!},
	    	'userPermissions' : {!!empty($userPermissions)? '{}': json_encode($userPermissions)!!},
	    	'listRoles'       : {!!json_encode($listRoles)!!},
	    	'userRoles'       : {!!empty($userRoles)? '{}': json_encode($userRoles)!!},
	    	'listGroups'      : {!!json_encode($listGroups)!!},
	    	'userGroups'      : {!!empty($userGroups) ? '{}': json_encode($userGroups)!!}
 	    };
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('app/components/user/userController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/user/userService.js?v='.getVersionScript())!!}
		{!! Html::script('app/shared/multi-select/multiSelectDirective.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/permissionforuser.js') }}"></script>
	@endif
@stop

	