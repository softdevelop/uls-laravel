
<div ng-if="!fieldNested.multiple">
	<label class="label-form">
	    @{{fieldNested.name}}:
	    <small class="text-require" ng-show="fieldNested.required != 'false' && fieldNested.required"> *</small>
	</label>
	<div class="wrap-form" >
		<textarea  ng-disabled ="isDisable" ng-class="{'no-drop':isDisable}" id="@{{fieldNested.name}}"  class="form-control" name="_@{{currentTabId}}_@{{fieldNested.variable}}_@{{field_el.key_field}}_@{{keyNested}}" ng-model="nested_block[currentTabId][field.variable][field_el.key_field][keyNested]['data'][fieldNested.variable]" ng-required = "@{{fieldNested.required}}" cols="30" rows="3" ng-change="validateCurrentForm(formData.$invalid, 'block')"></textarea>

		<small class="help-inline" ng-show="submitted && formData['_' + currentTabId + '_' + fieldNested.variable + '_' + field_el.key_field + '_' + keyNested].$error.required">
			<span class="capitalize">@{{fieldNested.name}}</span> {{trans('cms_page/page-nested.is_a_required_field')}}
		</small>
		<small class="help-inline" ng-show="submitted && !formData['_' + currentTabId + '_' + fieldNested.variable + '_' + field_el.key_field + '_' + keyNested].$error.required && formData['_' + currentTabId + '_' + fieldNested.variable + '_' + field_el.key_field + '_' + keyNested].$invalid">
			<span class="capitalize">@{{fieldNested.name}}</span> {{trans('cms_page/page-nested.is_invalid')}}
		</small>
	</div>
</div>
