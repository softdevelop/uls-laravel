<label class="label-form capitalize" ng-show="!field.multiple">
    <span>@{{field.name}}:<small class="text-require" ng-show="field.required != 'false' && field.required"> *</small></span>
</label>
<div id="field_@{{field._id.$id}}" ng-if="!field.multiple">
	<span ng-if="field.ra_check_title" ng-bind="field.ra_check_title"></span>
	<input ng-disabled ="isDisable" ng-class="{'no-drop':isDisable}" check-limit-and-change-date-time-directive type="@{{(field.type=='input' || field.type == 'label')?'text':field.type}}" id="@{{field.variable}}" class="form-control" name="_@{{currentTabId}}_@{{field.variable}}" ng-model="contentPage['_' + currentTabId]['data'].fields['_' + currentTabId + '_' + field.variable]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}"  ng-if="field.type != 'checkbox' && field.type != 'radio' && field.type != 'file'" ng-change="validateCurrentForm(formData.$invalid, type, field.variable, contentPage['_' + currentTabId]['data'].fields['_' + currentTabId + '_' + field.variable])" limit-to />

	<!--
		apply for input type checkbox
	-->
	<input ng-disabled ="isDisable" ng-class="{'no-drop':isDisable}" type="@{{(field.type=='input')?'text':field.type}}" id="@{{field.variable}}" class="form-control" name="_@{{currentTabId}}_@{{field.variable}}" ng-model="contentPage['_' + currentTabId]['data'].fields['_' + currentTabId + '_' + field.variable]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}"  ng-if="field.type == 'checkbox'" ng-true-value="'@{{field.ra_check_title}}'" ng-false-value="false" ng-change="validateCurrentForm(formData.$invalid, type, field.variable, contentPage['_' + currentTabId]['data'].fields['_' + currentTabId + '_' + field.variable])" limit-to />

	<!--
		apply for input type radio
	-->
	<input  ng-disabled ="isDisable"  ng-class="{'no-drop':isDisable}" type="@{{(field.type=='input')?'text':field.type}}" id="@{{field.variable}}" class="form-control" name="_@{{currentTabId}}_@{{field.variable}}" ng-model="contentPage['_' + currentTabId]['data'].fields['_' + currentTabId + '_' + field.variable]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}"  ng-if="field.type == 'radio'" ng-value="field.ra_check_title" ng-change="validateCurrentForm(formData.$invalid, type, field.variable, contentPage['_' + currentTabId]['data'].fields['_' + currentTabId + '_' + field.variable])" limit-to />
	
	<small class="help-inline" ng-show="submitted && formData['_'+currentTabId+'_'+field.variable].$error.required">
		<span class="capitalize">@{{field.name}}</span> {{trans('cms_page/page-validate.is_a_required_field')}}
	</small>
	<small class="help-inline" ng-show="submitted && !formData['_'+currentTabId+'_'+field.variable].$error.required && formData['_'+currentTabId+'_'+field.variable].$invalid">
		<span class="capitalize">@{{field.name}}</span> {{trans('cms_page/page-validate.is_invalid')}}
	</small>
</div>
