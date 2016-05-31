<div class="modal-header">
<button aria-label="Close" data-dismiss="modal" class="close" type="button" ng-click="cancel()"><span aria-hidden="true">×</span></button>
	@if(!empty($item->id))
	<h4 class="modal-title text-center">{{ trans('Permission/permission-create.edit_permission') }} {{$item->display_name}}</h4>
	@else
	<h4 class="modal-title">{{ trans('Permission/permission-create.create_permission') }}</h4>
	@endif
</div>
<div class="modal-body">
	<form class="" method="POST" action="{{{ URL::to('roles') }}}" accept-charset="UTF-8" name="formAddPermission" ng-init="permission={{$infoPermission}}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		@if(!empty($item->id))
			<div class="form-group"  ng-class="{'has-error':formAddPermission.name.$touched && formAddPermission.name.$invalid}">
				<label for="name">{{ trans('Permission/permission-create.name') }}<span class="text-require"> *</span></label>
				<div class="">
					<input class="form-control" disabled="true" placeholder="Name" type="text" name="name" id="name"  ng-model="permission.name" ng-required="true">
					<label class="control-label" ng-show="formAddPermission.name.$touched && formAddPermission.name.$invalid" >
						{{ trans('Permission/permission-create.name_invalid') }}
					</label>
				</div>
			</div>
		@else
			<div class="form-group" ng-class="{'has-error':formAddPermission.name.$touched && formAddPermission.name.$invalid}">
				<label for="name">{{ trans('Permission/permission-create.name') }}<span class="text-require"> *</span></label>
				<div class="">
					<input class="form-control" placeholder="Name" type="text" name="name" id="name"  ng-model="permission.name" ng-required="true">
					<label class="control-label" ng-show="formAddPermission.name.$touched && formAddPermission.name.$invalid" >
						{{ trans('Permission/permission-create.name_invalid') }}
					</label>
				</div>
			</div>
		@endif
{{--
		<div class="form-group" ng-class="{'has-error':formAddPermission.display_name.$touched && formAddPermission.display_name.$invalid}">
			<label for="display_name">{{ trans('permission-create.display_name') }}<span class="text-require"> *</span></label>
			<div class="">
				<input class="form-control" placeholder="{{ trans('permission-create.display_name') }}" type="text" name="display_name" id="display_name"  ng-model="permission.display_name" ng-required="true">
				<label class="control-label" ng-show="formAddPermission.display_name.$touched && formAddPermission.display_name.$invalid" >
					Display Name invalid
				</label>
			</div>
		</div> --}}

		<div class="form-group" ng-class="{'has-error':formAddPermission.description.$touched && formAddPermission.description.$invalid}">
			<label for="description">{{ trans('Permission/permission-create.description') }}<span class="text-require"> *</span></label>
			<div class="">
				<textarea class="form-control" placeholder="{{ trans('Permission/permission-create.description') }}" type="text" name="description" id="description"  ng-model="permission.description" ng-required="true">
				</textarea>
				<label class="control-label" ng-show="formAddPermission.description.$touched && formAddPermission.description.$invalid" >
					{{ trans('Permission/permission-create.description_invalid') }}
				</label>
			</div>
		</div>


		<div class="alert alert-danger" ng-show="error">
			@{{error}}
		</div>
		<div class="alert"  ng-show="notice">@{{notice}}</div>
	</form>
</div>
<div class="modal-footer">
	<button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> {{ trans('Permission/permission-create.cancel') }}</button>

	<button class="btn btn-primary" ng-disabled="formAddPermission.$invalid" ng-click="createPermission()"><i class="fa fa-plus"></i> {{ trans('Permission/permission-create.add') }}</button>

</div>
