{{-- <div ng-repeat="(indexSelect, field_el) in multiFieldFollowVariable[field.variable]" ng-if="field.multiple  && field_el.id == field.variable+field_el.key_field">
	<label class="label-form">
	    @{{field.name}}
	    <span ng-if="field.multiple && field.max_field > 1" class="pointer btn  btn-xs btn-upload" ng-click="addNewField(field)"  ng-show="field_el.key_field == 0">
	        <i class="fa fa-plus-square"></i>
	        Add
	    </span>

	    <span ng-if="field.multiple" class="pointer" ng-click="removeCurrentField(field, field_el.key_field)"  ng-show="field_el.key_field!=0">
	        <i class="fa fa-times"></i>
	    </span>
	</label>
	<div class="wrap-form">
		<select name="@{{field.variable}}_@{{field_el.key_field}}" id="@{{field.variable}}" class="form-control"  name="@{{field.variable}}_@{{field_el.key_field}}"  ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable][field_el.key_field]" ng-required = "@{{field.required}}" ng-options="key as value for (key, value) in field.options" ng-change="validateCurrentForm(formData.$invalid, 'page', field.variable, page.fields['_' + currentChosseTemplate + '_' + field.variable])">
			<option value="" ng-selected="true">Choose...</option>
		</select>
		<small class="help-inline" ng-show="submitted && formData.@{{field.variable}}_@{{field_el.key_field}}.$error.required"><span>@{{field.name}}</span> is a required field.</small>
		<small class="help-inline" ng-show="submitted && !formData.@{{field.variable}}_@{{field_el.key_field}}.$error.required && formData.@{{field.variable}}_@{{field_el.key_field}}.$invalid"><span>@{{field.name}}</span> is invalid.</small>
	</div>
</div> --}}

<div ng-if="!field.multiple">
	<label class="label-form">
	    @{{field.name}}:<small class="text-require" ng-show="field.required != 'false' && field.required"> *</small>
	</label>
	<div class="wrap-form">
		<select name="@{{field.variable}}" id="@{{field.variable}}" class="form-control"  name="_@{{currentChosseTemplate}}_@{{field.variable}}"  ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable]" ng-required = "@{{field.required}}" ng-options="key as value for (key, value) in field.options" ng-change="validateCurrentForm(formData.$invalid, 'page', field.variable, page.fields['_' + currentChosseTemplate + '_' + field.variable])">
			<option value="" ng-selected="true">Choose...</option>
		</select>
		<small class="help-inline" ng-show="submitted && formData._@{{currentChosseTemplate}}_@{{field.variable}}.$error.required"><span>@{{field.name}}</span> is a required field.</small>
		<small class="help-inline" ng-show="submitted && !formData._@{{currentChosseTemplate}}_@{{field.variable}}.$error.required && formData._@{{currentChosseTemplate}}_@{{field.variable}}.$invalid"><span>@{{field.name}}</span> is invalid.</small>
	</div>
</div>
