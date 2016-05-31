<div class="modal-header">
	<h4 class="modal-title">{{!empty($partner->id) ? 'Edit Partner': 'Add Partner'}}</h3>
</div>
<div class="modal-body">

	<form name="formData" ng-init="partner = {{$partner}}; countries = {{$countries}}">
		{!! csrf_field() !!}
        <div class="alert alert-danger" ng-show="errors">
			<span ng-repeat="error in errors">@{{error[0]}}<br></span>
		</div>
		<div class="form-group">
			<label class="label-form" for="">{{ trans('configuration/channel-partners/create.name') }}</label>
			<input type="text" class="form-control" name="name" id="" placeholder="Name" 
					ng-model="partner.name"
					rowboat-required/>
		</div>

		<div class="form-group">
			<label class="label-form" for="">{{ trans('configuration/channel-partners/create.address') }}</label>
			<input type="text" class="form-control" name="address" id="" placeholder="Enter mailing or street address"
					ng-model="partner.address"
					rowboat-required/>
		</div>

		<div class="form-group">
			<label class="label-form" for="">{{ trans('configuration/channel-partners/create.suite_number') }}</label>
			<input type="text" class="form-control" name="suite" id="" placeholder="Enter suite number, if applicable"
					ng-model="partner.suite"/>
		</div>

		<div class="form-group">
			<label class="label-form" for="">{{ trans('configuration/channel-partners/create.city') }}</label>
			<input type="text" class="form-control" name="city" id="" placeholder="Enter City"
					ng-model="partner.city"
					rowboat-required/>
		</div>

		{{-- <div class="form-group" ng-class="{true: 'error'}[submitted && formData.state.$invalid]">
			<label for="">State</label><br/>
			<select class="form-control" ng-model='partner.state' name="state" 
				ng-options="state.abbr as state.name for state in states"
				ng-required = 'true'>
				<option disabled selected value="">Select State</option>
			</select>
			<div class="pull-right">
	            <small class="error" ng-show="submitted && formData.state.$error.required">It is required</small>
	        </div>
		</div> --}}
		
		<div class="form-group">
			<label class="label-form" for="">{{ trans('configuration/channel-partners/create.zip_code') }}</label>
			<input type="text" class="form-control" name="zipcode" id="" placeholder="Enter Zip Code"
					ng-model="partner.zipcode"
					ng-pattern="/^[0-9]{5}$/"/>
			<div class="">
	            {{-- <small class="error" ng-show="submitted && formData.zipcode.$error.required">It is required</small> --}}
	            <small class="error" ng-show="formData.zipcode.$error.pattern">{{ trans('configuration/channel-partners/create.zip_code_required') }}</small>
	        </div>
		</div>
		<div class="clearfix"></div>
		<div class="form-group">
			<label class="label-form" for="">{{ trans('configuration/channel-partners/create.telephone_number') }}</label><br/>
			<input type="text" class="form-control" name="telephone"  id="telephone" placeholder="Telephone Number"
					ng-model="partner.telephone"
					ng-init="formatPhoneNumber()"
					ng-blur="validatePhone(partner.telephone)"
					rowboat-required/>
			<small  class="error" ng-show="formData.telephone.$touched && formData.telephone.$invalid">
				{{ trans('configuration/channel-partners/create.telephone_number_invalid') }}!
			</small>
		</div>

		<div class="form-group">
			<label class="label-form" for="">{{ trans('configuration/channel-partners/create.email') }}</label><br/>
			<input type="text" class="form-control" name="email" id="" placeholder="Email" ng-model="partner.email" rowboat-email-pattern/>
		</div>

		<div class="form-group">
			<label class="label-form" for="">{{ trans('configuration/channel-partners/create.country') }}</label><br/>
			<select class="form-control" placeholder="Chosse your Country" name="country" 
				ng-model='partner.region_id'
				ng-options="country.id as country.name for country in countries"
				rowboat-required>
				<option disabled selected value="">{{ trans('configuration/channel-partners/create.select_country_option') }}</option>
			</select>
		</div>
    </form> 
</div>
<div class="modal-footer">
	<button class="btn btn-primary" ng-disabled="formData.$invalid" ng-click="createPartner(formData.$invalid)"> <i class="fa fa-check"></i> {{ trans('configuration/channel-partners/create.submit') }}</button>
	<button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> {{ trans('configuration/channel-partners/create.cancel') }}</button>
</div>