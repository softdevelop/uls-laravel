
<div ng-if="!fieldNested.multiple">
	<label class="label-form">
	    @{{fieldNested.name}}:
	    <small class="text-require" ng-show="fieldNested.required != 'false' && fieldNested.required"> *</small>
	</label>
	<div class="wrap-form" >
		<select ng-class="{'no-drop':isDisable}" ng-disabled ="isDisable" id="@{{fieldNested.variable}}" class="form-control"  name="_@{{currentTabId}}_@{{fieldNested.variable}}_@{{field_el.key_field}}_@{{keyNested}}"  ng-model="nested_block[currentTabId][field.variable][field_el.key_field][keyNested]['data'][fieldNested.variable]" ng-required = "@{{fieldNested.required}}" ng-options="key as value for (key, value) in fieldNested.options" ng-change="validateCurrentForm(formData.$invalid, 'block')">
			<option value="" ng-selected="true">{{trans('cms_page/page-nested.choose')}}...</option>
		</select>
		<small class="help-inline" ng-show="submitted && formData['_' + currentTabId + '_' + fieldNested.variable + '_' + field_el.key_field + '_' + keyNested].$error.required">
			<span class="capitalize">@{{fieldNested.name}}</span> {{trans('cms_page/page-nested.is_a_required_field')}}</small>
		<small class="help-inline" ng-show="submitted && !formData['_' + currentTabId + '_' + fieldNested.variable + '_' + field_el.key_field + '_' + keyNested].$error.required && formData['_' + currentTabId + '_' + fieldNested.variable + '_' + field_el.key_field + '_' + keyNested].$invalid">
			<span class="capitalize">@{{fieldNested.name}}</span> {{trans('cms_page/page-nested.is_invalid')}}
		</small>
	</div>
</div>
