
{!!Former::$outputType()->setAttributes($attributes)!!}

@if(isset($currentVarialble) && $required)
	<small class="help-inline" ng-show="submitted && formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested].$error.required">
		<span class="capitalize">{{$name}} is a required field._@{{idInjectOrTemplate}}_@{{field.variable}}_@{{keyNested}}</span>
	</small>

	<small class="help-inline" ng-show="submitted && !formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested].$error.required && formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested].$invalid">
		<span class="capitalize">{{$name}} is invalid.</span>
	</small>
@elseif($required)
	<small class="help-inline" ng-show="submitted && formData['_' + idInjectOrTemplate + '_' + field.variable + '_' + field_el.key_field + '_' + keyNested].$error.required">
		<span class="capitalize">{{$name}} is a required field _@{{idInjectOrTemplate}}_@{{field.variable}}_@{{keyNested}}.</span>
	</small>

	<small class="help-inline" ng-show="submitted && !formData['_' + idInjectOrTemplate + '_' + field.variable + '_' + field_el.key_field + '_' + keyNested].$error.required && formData['_' + idInjectOrTemplate + '_' + field.variable + '_' + field_el.key_field + '_' + keyNested].$invalid">
		<span class="capitalize">{{$name}} is invalid.</span>
	</small>
@endif