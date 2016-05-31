
<label class="label-form" ng-show="!fieldNested.multiple">
    <span>@{{fieldNested.name}}:<small class="text-require" ng-show="fieldNested.required != 'false' && fieldNested.required"> *</small></span>
</label>
<div class="wrap-form" id="field_@{{fieldNested._id.$id}}" ng-if="!fieldNested.multiple">
	<span ng-if="fieldNested.ra_check_title" ng-bind="fieldNested.ra_check_title"></span>

	<input ng-disabled ="isDisable" ng-class="{'no-drop':isDisable}" check-limit-and-change-date-time-directive type="@{{(fieldNested.type=='input' || fieldNested.type == 'label')?'text':fieldNested.type}}"
		id="@{{fieldNested.variable}}" class="form-control" name="_@{{currentTabId}}_@{{fieldNested.variable}}_@{{field_el.key_field}}_@{{keyNested}}"
		ng-model="nested_block[currentTabId][field.variable][field_el.key_field][keyNested]['data'][fieldNested.variable]"
		ng-required = "@{{fieldNested.required}}"
		ng-style="{display:(fieldNested.ra_check_title)?'inline':''}"
		ng-if="fieldNested.type != 'checkbox' && fieldNested.type != 'radio' && fieldNested.type != 'file'"
		ng-change="validateCurrentForm(formData.$invalid, 'block')"
		limit-to
	/>
	<!--
		apply for input type checkbox
	-->
	<input ng-disabled ="isDisable" ng-class="{'no-drop':isDisable}" type="@{{(fieldNested.type=='input')?'text':fieldNested.type}}" id="@{{fieldNested.variable}}" class="form-control" name="_@{{currentTabId}}_@{{fieldNested.variable}}_@{{field_el.key_field}}_@{{keyNested}}" ng-model="nested_block[currentTabId][field.variable][field_el.key_field][keyNested]['data'][fieldNested.variable]" ng-required = "@{{fieldNested.required}}" ng-style="{display:(fieldNested.ra_check_title)?'inline':''}"  ng-if="fieldNested.type == 'checkbox'" ng-true-value="'@{{fieldNested.ra_check_title}}'" ng-false-value="false" ng-change="validateCurrentForm(formData.$invalid, 'block')" limit-to />
	<!--
		apply for input type radio
	-->
	<input ng-disabled ="isDisable" ng-class="{'no-drop':isDisable}" type="@{{(fieldNested.type=='input')?'text':fieldNested.type}}" id="@{{fieldNested.variable}}" class="form-control" name="_@{{currentTabId}}_@{{fieldNested.variable}}_@{{field_el.key_field}}_@{{keyNested}}" ng-model="nested_block[currentTabId][field.variable][field_el.key_field][keyNested]['data'][fieldNested.variable]" ng-required = "@{{fieldNested.required}}" ng-style="{display:(fieldNested.ra_check_title)?'inline':''}"  ng-if="fieldNested.type == 'radio'" ng-value="fieldNested.ra_check_title" ng-change="validateCurrentForm(formData.$invalid, 'block')" limit-to/>

	<small class="help-inline" ng-show="submitted && formData['_' + currentTabId + '_' + fieldNested.variable + '_' + field_el.key_field + '_' + keyNested].$error.required">
		<span class="capitalize">@{{fieldNested.name}}</span> {{trans('cms_page/page-nested.is_a_required_field')}}
	</small>
	<small class="help-inline" ng-show="submitted && !formData['_' + currentTabId + '_' + fieldNested.variable + '_' + field_el.key_field + '_' + keyNested].$error.required && formData['_' + currentTabId + '_' + fieldNested.variable + '_' + field_el.key_field + '_' + keyNested].$invalid">
		<span class="capitalize">@{{fieldNested.name}}</span> {{trans('cms_page/page-nested.is_invalid')}}
	</small>
</div>
