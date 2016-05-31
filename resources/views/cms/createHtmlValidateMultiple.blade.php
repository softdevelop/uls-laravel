@if(isset($hasForeachField) && $hasForeachField)
	<small class="help-inline" ng-show="submitted && formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested + '_' + field.variable].$error.required">
		<span class="capitalize">{{$name}} is a required fieldr.</span>
	</small>

	<small class="help-inline" ng-show="submitted && !formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested + '_' + field.variable].$error.required && formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested + '_' + field.variable].$invalid">
		<span class="capitalize">{{$name}} is invalid.</span>
	</small>
@else
	<small class="help-inline" ng-show="submitted && formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested].$error.required">
		<span class="capitalize">{{$name}} is a required fieldr.</span>
	</small>

	<small class="help-inline" ng-show="submitted && !formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested].$error.required && formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested].$invalid">
		<span class="capitalize">{{$name}} is a required field.</span>
	</small>
@endif