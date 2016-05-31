
<div class="modal-header">
    <h4 class="modal-title">
        @if($language->id == '')
            {{ trans('configuration/language/language-create.create_language') }}
        @else
            {{ trans('configuration/language/language-create.edit_language') }}
        @endif
</div>
<div class="modal-body">
<div class="alert alert-danger" ng-show="errors">
    <span ng-repeat="error in errors">@{{error[0]}}<br></span>
</div>
<form role="form" name="createLanguage_form" ng-init="language={{$language}}" novalidate>

        <!-- Input Language-->
        <div class="form-group" ng-class="{true: 'has-error'}[submitted && (createLanguage_form.name.$invalid || nameExists)]">
            <label for="">{{ trans('configuration/language/language-create.language') }}<span class="text-require"> *</span></label>
            <input type="text" class="form-control" name="name" placeholder="Language"
                   ng-model="language.name"
                   ng-minlength=3
                   ng-maxlength=50
                   ng-required="true" />
            <div class="clearfix"></div>
            <div class="show-error pull-left">
                {{-- <small class="help-inline" ng-if="nameExists != ''">@{{nameExists}}</small> --}}
                <small class="help-inline" ng-show="submitted && createLanguage_form.name.$error.required">{{ trans('configuration/language/language-create.language_required') }}.</small>
                <small class="help-inline" ng-show="submitted && createLanguage_form.name.$error.minlength">{{ trans('configuration/language/language-create.language_minlength') }}</small>
                <small class="help-inline" ng-show="submitted && createLanguage_form.name.$error.maxlength">{{ trans('configuration/language/language-create.language_maxlength') }}</small>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Native Name-->
        <div class="form-group" ng-class="{true: 'has-error'}[submitted && createLanguage_form.native_name.$invalid]">
            <label for="">{{ trans('configuration/language/language-create.native_name') }}<span class="text-require"> *</span></label>
            <input type="text" class="form-control" name="native_name" placeholder="Native Name"
                   ng-model="language.native_name"
                   ng-minlength=3
                   ng-maxlength=30
                   ng-required="true" />
            <div class="show-error pull-left">
                <small class="help-inline" ng-show="submitted && createLanguage_form.native_name.$error.required">{{ trans('configuration/language/language-create.native_name_required') }}.</small>
                <small class="help-inline" ng-show="submitted && createLanguage_form.native_name.$error.minlength">{{ trans('configuration/language/language-create.native_name_minlength') }}</small>
                <small class="help-inline" ng-show="submitted && createLanguage_form.native_name.$error.maxlength">{{ trans('configuration/language/language-create.native_name_maxlength') }}</small>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Code-->
        <div class="form-group" ng-class="{true: 'has-error'}[submitted && createLanguage_form.code.$invalid]">
            <label for="">{{ trans('configuration/language/language-create.code') }}<span class="text-require"> *</span></label>
            <input type="text" class="form-control" name="code" placeholder="Language Code"
                   ng-model="language.code"
                   rowboat-length=2
                   ng-required="true" />
            <div class="show-error pull-left">
                {{-- <small class="help-inline" ng-if="codeExists != ''">@{{codeExists}}</small> --}}
                <small class="help-inline" ng-show="submitted && createLanguage_form.code.$error.required">{{ trans('configuration/language/language-create.code_required') }}.</small>
                <small class="help-inline" ng-show="submitted && createLanguage_form.code.$error.minlength">{{ trans('configuration/language/language-create.code_minlength') }}</small>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Direction-->
        <div class="form-group" ng-class="{true: 'has-error'}[submitted && createLanguage_form.direction.$invalid]">
            <label for="" >{{ trans('configuration/language/language-create.direction') }}<span class="text-require"> *</span></label>
            <select type="text" class="form-control" name="direction" placeholder="Direction"
                    ng-model="language.direction"
                    ng-required="true" >
                    <option value="">--- {{ trans('configuration/language/language-create.direction_option_default') }} ---</option>
                    <option value="Left to right">{{ trans('configuration/language/language-create.direction_option_first') }}</option>
                    <option value="Right to left">{{ trans('configuration/language/language-create.direction_option_second') }}</option>
            </select>
            <div class="pull-left">
                <small class="help-inline" ng-show="submitted && createLanguage_form.direction.$error.required">{{ trans('configuration/language/language-create.direction_required') }}.</small>
            </div>
        </div><br/ >
        <div class="clearfix"></div>

        <!-- Input Active-->
        <div class="form-group" ng-class="{true: 'has-error'}[submitted && createLanguage_form.active.$invalid]">
            <div class="radio radio-danger">
                <input type="radio" ng-model="language.active" value="1" name="active" ng-required="true" />
                <label for="radio3">{{ trans('configuration/language/language-create.active') }}</label>
            </div>
            <div class="radio radio-danger">
                <input type="radio" ng-model="language.active" value="0" name="active" ng-required="true" />
                <label for="radio3">{{ trans('configuration/language/language-create.inactive') }}</label>
            </div>
        </div>
        <div class="pull-left">
            <small class="help-inline" ng-show="submitted && createLanguage_form.active.$error.required">{{ trans('configuration/language/language-create.active_inactive_required') }}.</small>
        </div>
        <div class="clearfix"></div>

   </form>
</div>
<div class="modal-footer">
        <button class="btn btn-default" ng-click="cancel()"> <i class="fa fa-times"></i> {{ trans('configuration/language/language-create.cancel') }}</button>
        <button class="btn btn-primary" ng-click="submit(createLanguage_form.$invalid)">
        <i class="fa fa-plus"></i>
        <span>
            @if(!empty($language->id))
                {{ trans('configuration/language/language-create.edit') }}
            @else
                {{ trans('configuration/language/language-create.add') }}
            @endif
        </span>
    </button>

</div>
