<div class="modal-header">
	<button aria-label="Close" data-dismiss="modal" class="close" type="button" ng-click="cancel()"><span aria-hidden="true">×</span></button>
	@if(!empty($item->id))
	<h4 class="modal-title">{{ trans('User/user-create.edit_user') }} {{$item->first_name}} {{$item->last_name}}</h4>
	@else
	<h4 class="modal-title">{{ trans('User/user-create.create_user') }}</h4>
	@endif

</div>

<div class="clearfix"></div>

<div class="modal-body">
	<div class="innerAll">
		<div class="innerLR">
			<form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8" name="formAddUser"  ng-init='userItem={{$item}}'>
				<div class="form-group">
					<label for="first_name">{{ trans('User/user-create.first_name') }}:<span class="text-require"> *</span></label>
					<input class="form-control" placeholder="{{trans('User/user-create.first_name') }}" type="text" name="first_name" id="first_name" value="" ng-model="userItem.first_name"
							 ng-maxlength=50
							 ng-required="true">
					<label class="control-label has-error" ng-show="formAddUser.first_name.$touched && formAddUser.first_name.$error.required">
						{{ trans('User/user-create.required_first_name') }}.
					</label>
            		<label class="control-label has-error" ng-show="formAddUser.first_name.$touched && formAddUser.first_name.$error.maxlength">{{ trans('User/user-create.valitdate_characters_first_name') }}</label>
				</div>

				<div class="form-group" >
					<label for="last_name"> {{ trans('User/user-create.last_name') }}:<span class="text-require"> *</span></label>
					<input class="form-control"  placeholder="{{ trans('User/user-create.last_name') }}" type="text" name="last_name" id="last_name" value="" 		 ng-model="userItem.last_name"
						   ng-maxlength=50
						   ng-required="true">
					<label class="control-label has-error" ng-show="formAddUser.last_name.$touched && formAddUser.last_name.$error.required">
						{{ trans('User/user-create.required_last_name') }}
					</label>
            		<label class="control-label has-error" ng-show="formAddUser.last_name.$touched && formAddUser.last_name.$error.maxlength">{{ trans('User/user-create.valitdate_characters_last_name') }}</label>
				</div>

				<div class="form-group">
					<label for="inputEmail3">{{ trans('User/user-create.email') }}:<span class="text-require"> *</span></label>
					<input ng-pattern="/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/" class="form-control" placeholder="Email" type="text" name="email" id="email" ng-model="userItem.email" ng-required="true">
					<label class="control-label has-error" ng-show="formAddUser.email.$touched && formAddUser.email.$invalid" >
						{{ trans('User/user-create.validate_email') }}
					</label>
				</div>

				<div class="form-group">
					<label for="phone_number">{{ trans('User/user-create.phone') }}:</label>
					<input class="form-control" type="text" name="phone_number" id="phone_number"
							ng-model="userItem.personal_information.phone_number"
							data-ng-init='formatPhoneNumber()' ng-blur="validatePhone(userItem.personal_information.phone_number)">
					<label class="control-label has-error" ng-show="formAddUser.phone_number.$touched && formAddUser.phone_number.$invalid">
						{{ trans('User/user-create.validate_phone') }}
					</label>
				</div>
				<div class="alert alert-error alert-danger" ng-show="error">
					@{{error}}
				</div>

			</form>
		</div>
	</div>
</div>

<div class="clearfix"></div>

<div class="modal-footer">
	<div class="form-group center-block">
		<button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i>{{ trans('User/user-create.cancel') }}</button>
		<button ng-disabled="formAddUser.$invalid || patternPhone" class="btn btn-primary" id="btnAddUser" ng-click="createUser()">
		<i class="fa fa-plus"></i>
		<span>
			@if(!empty($item->id))
				{{ trans('User/user-create.edit') }}
			@else
				{{ trans('User/user-create.add') }}
			@endif
		</span>
		</button>

	</div>
</div>
