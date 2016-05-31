
<div class="modal-header">
<button ng-click="cancel()" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">

		@if(!empty($region->id))
			{{ trans('configuration/region/region-create.edit_region') }}
		@else
			{{ trans('configuration/region/region-create.create_region') }}
		@endif
	</h4>
</div>
<div class="modal-body">

	<form name="formData" ng-init="region={{$region}}; languages = {{$languages}}">
		{!! csrf_field() !!}
        <div class="alert alert-danger" ng-show="errors">
			<span ng-repeat="error in errors">@{{error[0]}}<br></span>
		</div>
		<div class="form-group" >
			<label class="hightlight-lb" for="">{{ trans('configuration/region/region-create.country_name') }}</label>
			<input type="text" class="form-control" name="name" id="" placeholder="{{ trans('configuration/region/region-create.country_name') }}"
					ng-model="region.name"
					rowboat-required/>
		</div>
		<div class="clearfix"></div>
		<div class="form-group">
			<label class="hightlight-lb" for="">{{ trans('configuration/region/region-create.code') }}</label>
			<input type="text" class="form-control" name="code" id="" placeholder="{{ trans('configuration/region/region-create.code') }}"
					ng-model="region.code"
                  	rowboat-required
                  	rowboat-length='2'/>
		</div>

		<div class="clearfix"></div>
		<div class="form-group">
			<label class="hightlight-lb" for="">{{ trans('configuration/region/region-create.languages') }}</label><br/>
		</div>
		<div ng-repeat="language in languages">
			<div class="checkbox checkbox-danger">
				<input type="checkbox"  id="@{{language.id}}" value="@{{language.id}}"
						ng-checked="region.languages.indexOf(language.id) > -1"
						ng-click="SelectLanguage(language.id)"/>
		        <label>@{{language.name}}</label>
		    </div>
	    </div>
		{{-- <small class="error" ng-show="submitted && selectionLangId.length == 0">It is required</small> <br/> --}}

		<div class="clearfix"></div>
		<div class="form-group">
			<label class="form-group">{{ trans('configuration/region/region-create.active') }}:<span class="text-require"> *</span></label>
            <div class="radio radio-danger">
                <input type="radio" ng-model="region.active" value="1" name="active" required>
            	<label >{{ trans('configuration/region/region-create.active') }} </label>
            </div>
            <div class="radio radio-danger">
                <input type="radio" ng-model="region.active" value="0" name="active" required>
            	<label > {{ trans('configuration/region/region-create.inactive') }}</label>
            </div>
        	<br/><small class="error" ng-show="formData.active.$error.rowboatRequired">{{ trans('configuration/region/region-create.active_inactive_required') }}.</small> <br/>
        </div>

    </form>
</div>
<div class="modal-footer">
		<button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> {{ trans('configuration/region/region-create.cancel') }}</button>
        <button class="btn btn-primary" ng-disabled="formData.$invalid || selectionLangId.length == 0" ng-click="createRegion(formData.$invalid)">
        <i class="fa fa-plus"></i>
        <span>
            @if(!empty($region->id))
                {{ trans('configuration/region/region-create.edit') }}
            @else
                {{ trans('configuration/region/region-create.add') }}
            @endif
        </span>
    </button>
</div>
