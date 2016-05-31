<!-- apply for block -->
@if(isset($currentVarialble))
	<!-- show select level for link -->
	<modal-select-page ng-required="{{$required}}" on-click="validateCurrentForm(formData.$invalid, '{{$textForm}}', {{$variable}}, {{$ngModel}})" ng-model="{{$ngModel}}" item-selected="{{$ngModel}}" name="_@{{idInjectOrTemplate}}_{{$currentVarialble}}_@{{field_el.key_field}}_@{{keyNested}}"></modal-select-page>

    @if($required)
        <!-- show validate form required -->
		<small class="help-inline" ng-show="submitted && formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested].$error.required">
			<span class="capitalize">{{$name}}</span> is a required field{{$type}}.
		</small>

        <!-- show validate form invalid and required is false -->
		<small class="help-inline" ng-show="submitted && !formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested].$error.required && formData['_' + idInjectOrTemplate + '_{{$currentVarialble}}_' + field_el.key_field + '_' + keyNested].$invalid">
			<span class="capitalize">{{$name}}</span> is invalid.
		</small>
	@endif

<!-- apply for template -->
@else
	<!-- show select level for link -->
	<modal-select-page ng-required="{{$required}}" on-click="validateCurrentForm(formData.$invalid, '{{$textForm}}', {{$variable}}, {{$ngModel}})" ng-model="{{$ngModel}}" item-selected="{{$ngModel}}" name="_@{{idInjectOrTemplate}}_@{{field.variable}}_@{{field_el.key_field}}_@{{keyNested}}"></modal-select-page>
    
    @if($required)
	    <!-- show validate form required -->
		<small class="help-inline" ng-show="submitted && formData['_' + idInjectOrTemplate + '_' + field.variable + '_' + field_el.key_field + '_' + keyNested].$error.required">
			<span class="capitalize">{{$name}}</span> is a required field{{$type}}.
		</small>
        
        <!-- show validate form invalid and required is false -->
		<small class="help-inline" ng-show="submitted && !formData['_' + idInjectOrTemplate + '_' + field.variable + '_' + field_el.key_field + '_' + keyNested].$error.required && formData['_' + idInjectOrTemplate + '_' + field.variable + '_' + field_el.key_field + '_' + keyNested].$invalid">
			<span class="capitalize">{{$name}}</span> is a required field.
		</small>
	@endif
@endif