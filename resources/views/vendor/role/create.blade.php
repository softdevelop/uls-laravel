<div class="modal-header">
<button aria-label="Close" data-dismiss="modal" class="close" type="button" ng-click="cancel()"><span aria-hidden="true">×</span></button>
	@if(!empty($item->id))
	<h4 class="modal-title">{{ trans('Role/role-create.edit_role') }} {{$item->display_name}}</h4>
	@else
	<h4 class="modal-title">{{ trans('Role/role-create.create_role') }}</h4>
	@endif

</div>
<div class="modal-body">

	<form class="form-horizontal" method="POST" action="{{{ URL::to('roles') }}}" accept-charset="UTF-8" name="formAddRole" ng-init="role={{$item}}">
		<input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
		<div class="col-lg-12">
			<div class="form-group" ng-class="{'has-error':formAddRole.name.$touched && formAddRole.name.$invalid}">
				<label for="name">{{ trans('Role/role-create.name') }}<span class="text-require"> *</span></label>
				<div>
					<input ng-if="!role.id" class="form-control" placeholder="Name" type="text" name="name" id="name"  ng-model="role.name" ng-required="true">
					<label ng-if="role.id" class="m-t-5"><h4>@{{role.name}}</h4></label>
					<label class="control-label" ng-show="formAddRole.name.$touched && formAddRole.name.$invalid" >
						{{ trans('Role/role-create.name_invalid') }}
					</label>
				</div>
			</div>

{{-- 			<div class="form-group" ng-class="{'has-error':formAddRole.display_name.$touched && formAddRole.display_name.$invalid}">
				<label for="display_name">Display Name<span class="text-require"> *</span></label>
				<div>
					<input class="form-control" placeholder="Display Name" type="text" name="display_name" id="display_name"  ng-model="role.display_name" ng-required="true">
					<label class="control-label" ng-show="formAddRole.display_name.$touched && formAddRole.display_name.$invalid" >
						Display Name invalid
					</label>
				</div>
			</div> --}}

			<div class="form-group" ng-class="{'has-error':formAddRole.description.$touched && formAddRole.description.$invalid}">
				<label for="description">{{ trans('Role/role-create.description') }}<span class="text-require"> *</span></label>
				<div>
					<textarea class="form-control" rows="5" placeholder="Description" type="text" name="description" id="description"  ng-model="role.description" ng-required="true">
					</textarea>
					<label class="control-label" ng-show="formAddRole.description.$touched && formAddRole.description.$invalid" >
						{{ trans('Role/role-create.description_invalid') }}
					</label>
				</div>
			</div>

			<div class="alert alert-danger" ng-show="error">
				@{{error}}
			</div>
		</div>
		<div class="clearfix"></div>
	</form>
</div>
<div class="modal-footer center-block">
	<button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i>{{ trans('Role/role-create.cancel') }}</button>
	<button id="bt-submit" class="btn btn-primary" ng-disabled="formAddRole.$invalid" ng-click="createRole()"><i class="fa fa-check"></i>{{ trans('Role/role-create.save') }}</button>
</div>
