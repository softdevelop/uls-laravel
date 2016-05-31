
<label class="label-form" ng-show="!field.multiple">
    <span>@{{field.name}}<span class="text-require" ng-if="field.required !== 'false' && field.required"> *</span></span>
</label>
<div class="wrap-form" id="field_@{{field._id.$id}}" ng-if="!field.multiple">
	<span ng-if="field.ra_check_title" ng-bind="field.ra_check_title"></span>
	<input type="@{{(field.type=='input' || field.type == 'label')?'text':field.type}}" id="@{{field.variable}}" class="form-control" name="@{{field.variable}}" ng-model="contentBlock['_' + currentBlockInject]['data']['fields']['_' + currentBlockInject + '_' + field.variable]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}"  ng-if="field.type != 'checkbox' && field.type != 'radio' && field.type != 'file'" ng-change="validateCurrentForm(formData.$invalid)" limit-to>
	<!--
		apply for input type checkbox
	-->
	<input type="@{{(field.type=='input')?'text':field.type}}" id="@{{field.variable}}" class="form-control" name="@{{field.variable}}" ng-model="contentBlock['_' + currentBlockInject]['data']['fields']['_' + currentBlockInject + '_' + field.variable]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}"  ng-if="field.type == 'checkbox'" ng-true-value="'@{{field.ra_check_title}}'" ng-false-value="false" ng-change="validateCurrentForm(formData.$invalid)" limit-to />

	<!--
		apply for input type radio
	-->
	<input type="@{{(field.type=='input')?'text':field.type}}" id="@{{field.variable}}" class="form-control" name="@{{field.variable}}" ng-model="contentBlock['_' + currentBlockInject]['data']['fields']['_' + currentBlockInject + '_' + field.variable]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}"  ng-if="field.type == 'radio'" ng-value="field.ra_check_title" ng-change="validateCurrentForm(formData.$invalid)" limit-to />

	<small class="help-inline" ng-show="submitted && formData.@{{field.variable}}.$invalid"><span>@{{field.name}}</span> is a required field.</small>
</div>
