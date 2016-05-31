<div ng-if="!field.multiple">
	<label class="label-form">
	    @{{field.name}}<span class="text-require" ng-if="field.required !== 'false' && field.required"> *</span>
	</label>
	<div class="wrap-form" >
	<textarea id="@{{field.name}}" class="form-control" name="@{{field.name}}" ng-model="contentBlock['_' + currentBlockInject]['data']['fields']['_' + currentBlockInject + '_' + field.variable]" ng-required="@{{field.required}}" cols="30" rows="3" ng-change="validateCurrentForm(formData.$invalid)"></textarea>
	<small class="help-inline" ng-show="submitted && formData.@{{field.name}}.$invalid"><span>@{{field.name}}</span> is a required field.</small>
	</div>
</div>
