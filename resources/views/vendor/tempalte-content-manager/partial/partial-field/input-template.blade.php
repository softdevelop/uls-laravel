{{-- <div ng-repeat="(key, field_el) in multiFieldFollowVariable[field.variable]" ng-if="field.multiple && field_el.id == field.variable+field_el.key_field">
	<label class="label-form">
	    <span  ng-show="field.type != 'checkbox' && field.type != 'radio'">@{{field.name}}</span>
	    <span  ng-show="(field.type == 'checkbox' || field.type == 'radio') && field_el.key_field == 0">@{{field.name}}</span>
	    <span  ng-if="field.multiple && field.max_field > 1" class="pointer btn btn-xs btn-upload" ng-click="addNewField(field)" ng-show="field_el.key_field == 0" >
	         <i class="fa fa-plus-square"></i>
	        Add
	    </span>
	    <span ng-if="field.multiple" class="pointer" ng-click="removeCurrentField(field, field_el.key_field)" ng-show="field_el.key_field != 0 && field.type != 'checkbox' && field.type != 'radio'">
	        <i class="fa fa-times"></i>
	    </span>
	</label>
	<div class="col-lg-12" id="field_@{{field._id.$id}}">

		<span ng-if="field.ra_check_title" ng-bind="field.ra_check_title" ng-show="field.type == 'checkbox' || field.type == 'radio'"></span>

		<input check-limit-and-change-date-time-directive type="@{{(field.type=='input' || field.type == 'label')?'text':field.type}}" id="@{{field.variable}}_@{{field_el.key_field}}" class="form-control" name="@{{field.variable}}_@{{field_el.key_field}}" ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable][field_el.key_field]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}" ng-if="field.type != 'checkbox' && field.type != 'radio' && field.type != 'file'" ng-blur="validateCurrentForm(formData.$invalid, 'page', field.variable, page.fields['_' + currentChosseTemplate + '_' + field.variable])" />

		<!--
			apply for input type date
		-->
		<!-- end input type date-->

		<!--

			apply for input type checkbox

		-->

		<input type="@{{(field.type=='input')?'text':field.type}}" id="@{{field.variable}}_@{{field_el.key_field}}" class="form-control"
		name="@{{field.variable}}_@{{field_el.key_field}}" ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable][field_el.key_field]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}" ng-if="field.type == 'checkbox'" ng-true-value="'@{{field.ra_check_title}}'"  ng-false-value="false" ng-blur="validateCurrentForm(formData.$invalid, 'page', field.variable, page.fields['_' + currentChosseTemplate + '_' + field.variable])" />

		<!-- end input type checkbox-->

		<!--

			apply for input type radio

		-->
		<input type="@{{(field.type=='input')?'text':field.type}}" id="@{{field.variable}}_@{{field_el.key_field}}" class="form-control" name="@{{field.variable}}_@{{field_el.key_field}}" ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable][field_el.key_field]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}" ng-if="field.type == 'radio'" ng-value="field.ra_check_title" ng-blur="validateCurrentForm(formData.$invalid, 'page', field.variable, page.fields['_' + currentChosseTemplate + '_' + field.variable])" />

		<!-- end input type checkbox-->

		<!--

			apply for input type file

		-->
		<div ng-if="field.type == 'file'" class="input-group">
			<input name="@{{field.variable}}_@{{field_el.key_field}}" type="text" class="form-control" ng-model="file_fields[field.variable][field_el.key_field]"
			ng-required="@{{field.required}}"  ng-init="file_fields[field.variable][field_el.key_field] = listFileFollowId[page.fields['_' + currentChosseTemplate + '_' + field.variable][field_el.key_field]]" ng-disabled="true"/>
			<span class="input-group-btn">
				<button class="btn btn-default" type="button" ngf-select ngf-drop ngf-change="uploadFileCurTemp($files, field.variable, field_el.key_field)">Select File</button>
			</span>
	    </div>

	    <!-- end input type file-->

		<span ng-if="field.multiple" class="btn-primary pointer" ng-click="removeCurrentField(field, field_el.key_field)" ng-show="field_el.key_field != 0 && (field.type == 'checkbox' || field.type == 'radio')">
	        <i class="fa fa-times"></i>
	    </span>

		<small class="help-inline" ng-show="submitted && formData.@{{field.variable}}_@{{field_el.key_field}}.$error.required"><span>@{{field.name}}</span> is a required field.</small>
		<small class="help-inline" ng-show="submitted && !formData.@{{field.variable}}_@{{field_el.key_field}}.$error.required && formData.@{{field.variable}}_@{{field_el.key_field}}.$invalid"><span>@{{field.name}}</span> is invalid.</small>
	</div>
</div>
 --}}
<label class="label-form" ng-show="!field.multiple">
    <span>@{{field.name}}:<small class="text-require" ng-show="field.required != 'false' && field.required"> *</small></span>
</label>
<div class="wrap-form" id="field_@{{field._id.$id}}" ng-if="!field.multiple">
	<span ng-if="field.ra_check_title" ng-bind="field.ra_check_title"></span>
	<input check-limit-and-change-date-time-directive type="@{{(field.type=='input' || field.type == 'label')?'text':field.type}}" id="@{{field.variable}}" class="form-control" name="_@{{currentChosseTemplate}}_@{{field.variable}}" ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}"  ng-if="field.type != 'checkbox' && field.type != 'radio' && field.type != 'file'" ng-blur="validateCurrentForm(formData.$invalid, 'page', field.variable, page.fields['_' + currentChosseTemplate + '_' + field.variable])" />

	<!--

		apply for input type checkbox

	-->
	<input type="@{{(field.type=='input')?'text':field.type}}" id="@{{field.variable}}" class="form-control" name="_@{{currentChosseTemplate}}_@{{field.variable}}" ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}"  ng-if="field.type == 'checkbox'" ng-true-value="'@{{field.ra_check_title}}'" ng-false-value="false" ng-blur="validateCurrentForm(formData.$invalid, 'page', field.variable, page.fields['_' + currentChosseTemplate + '_' + field.variable])" />

	<!--

		apply for input type date

	-->
	{{-- <input class="form-control ng-valid ng-scope ng-isolate-scope ng-valid-date ng-touched ng-dirty ng-valid-parse" datepicker-popup="" is-open="opened" datepicker-rowboat="" ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable]" id="-5" type="text" ng-if="field.type == 'date'" --}}
	{{-- name="@{{field.variable}}" id="@{{field.variable}}" ng-required = "@{{field.required}}"> --}}

	<!--

		apply for input type radio

	-->
	<input type="@{{(field.type=='input')?'text':field.type}}" id="@{{field.variable}}" class="form-control" name="_@{{currentChosseTemplate}}_@{{field.variable}}" ng-model="page.fields['_' + currentChosseTemplate + '_' + field.variable]" ng-required = "@{{field.required}}" ng-style="{display:(field.ra_check_title)?'inline':''}"  ng-if="field.type == 'radio'" ng-value="field.ra_check_title" ng-blur="validateCurrentForm(formData.$invalid, 'page', field.variable, page.fields['_' + currentChosseTemplate + '_' + field.variable])" />

	<!--

		apply for input type file

	-->
	<div ng-if="field.type == 'file'" class="input-group">
      <input name="@{{field.variable}}" type="text" class="form-control" ng-model="file_fields[field.variable]" ng-required="@{{field.required}}" ng-init="file_fields[field.variable] = listFileFollowId[page.fields['_' + currentChosseTemplate + '_' + field.variable]]" ng-disabled="true"/>
      <span class="input-group-btn">
        <button class="btn btn-default" type="button" ngf-select ngf-drop ngf-change="uploadFileCurTemp($files, field.variable)">Select File</button>
      </span>

    </div>
	<small class="help-inline" ng-show="submitted && formData._@{{currentChosseTemplate}}_@{{field.variable}}.$error.required"><span>@{{field.name}}</span> is a required field.</small>
	<small class="help-inline" ng-show="submitted && !formData._@{{currentChosseTemplate}}_@{{field.variable}}.$error.required && formData._@{{currentChosseTemplate}}_@{{field.variable}}.$invalid"><span>@{{field.name}}</span> is invalid.</small>
</div>
