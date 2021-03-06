<div ng-if="!field.multiple">
	<label class="label-form">
	    @{{field.name}}:
	    <small class="text-require" ng-show="field.required != 'false' && field.required"> *</small>
	</label>
	<div class="wrap-form" >
	<textarea ng-disabled ="isDisable" ng-class="{'no-drop':isDisable}" id="@{{field.name}}"  class="form-control" name="_@{{currentTabId}}_@{{field.variable}}" ng-model="contentPage['_' + currentTabId]['data'].fields['_'+ currentTabId + '_' + field.variable]" ng-required = "@{{field.required}}" cols="30" rows="3" ng-change="validateCurrentForm(formData.$invalid, type, field.variable, contentPage['_' + currentTabId]['data'].fields['_' + currentTabId + '_' + field.variable])"></textarea>

	<small class="help-inline" ng-show="submitted && formData['_'+currentTabId+'_'+field.variable].$error.required">
		<span class="capitalize">@{{field.name}}</span> {{trans('cms_page/page-validate.is_a_required_field')}}
	</small>
	<small class="help-inline" ng-show="submitted && !formData['_'+currentTabId+'_'+field.variable].$error.required && formData['_'+currentTabId+'_'+field.variable].$invalid">
		<span class="capitalize">@{{field.name}}</span> {{trans('cms_page/page-validate.is_invalid')}}
	</small>
	</div>
</div>
