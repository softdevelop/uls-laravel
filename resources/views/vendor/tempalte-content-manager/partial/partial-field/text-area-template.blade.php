{{--
<div ng-repeat="(key, field_el) in multiFieldFollowVariable[field.variable]" ng-if="field.multiple  && field_el.id == field.variable+field_el.key_field">
	<label class="label-form">
	    @{{field.name}} &nbsp
	    <span ng-if="field.multiple && field.max_field > 1" class="pointer btn  btn-xs btn-upload" ng-click="addNewField(field)" ng-show="$first">
	        <i class="fa fa-plus-square"></i>
	        Add
	    </span>
	    <span ng-if="field.multiple" class="pointer" ng-click="removeCurrentField(field, field_el.key_field)" ng-show="!$first">
	        <i class="fa fa-times"></i>
	    </span>
	</label>
	<div class="col-lg-12">
		<textarea id="@{{field.name}}" class="form-control" name="@{{field.name}}_@{{key}}" ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable][field_el.key_field]" ng-required = "@{{field.required}}" cols="30" rows="3" ng-blur="validateCurrentForm(formData.$invalid, 'page', field.variable, page.fields['_' + currentChosseTemplate + '_' + field.variable])"></textarea>
		<small class="help-inline" ng-show="submitted && formData.@{{field.variable}}_@{{key}}.$error.required"><span>@{{field.name}}</span> is a required field.</small>
		<small class="help-inline" ng-show="submitted && !formData.@{{field.variable}}_@{{key}}.$error.required && formData.@{{field.variable}}_@{{key}}.$invalid"><span>@{{field.name}}</span> is a required field.</small>
	</div>
</div>
 --}}
<div ng-if="!field.multiple">
	<label class="label-form">
	    @{{field.name}}:<small class="text-require" ng-show="field.required != 'false' && field.required"> *</small>
	</label>
	<div class="wrap-form" >
	<textarea id="@{{field.name}}"  class="form-control" name="_@{{currentChosseTemplate}}_@{{field.variable}}" ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable]" ng-required = "@{{field.required}}" cols="30" rows="3" ng-blur="validateCurrentForm(formData.$invalid, 'page', field.variable, page.fields['_' + currentChosseTemplate + '_' + field.variable])"></textarea>
	<small class="help-inline" ng-show="submitted && formData._@{{currentChosseTemplate}}_@{{field.variable}}.$error.required"><span>@{{field.name}}</span> is a required field.</small>
	<small class="help-inline" ng-show="submitted && !formData._@{{currentChosseTemplate}}_@{{field.variable}}.$error.required && formData._@{{currentChosseTemplate}}_@{{field.variable}}.$invalid"><span>@{{field.name}}</span> is a required field.</small>
	</div>
</div>
