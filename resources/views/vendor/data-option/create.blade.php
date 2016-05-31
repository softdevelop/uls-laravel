<div class="modal-header">
    <button ng-click="cancel()" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" ng-if="dataOption._id == null">{{ trans('configuration/data-option/data-option-create.create_dataOption') }}</h4>
    <h4 class="modal-title" ng-if="dataOption._id != null">{{ trans('configuration/data-option/data-option-create.edit_dataOption') }}</h4>
</div>
<div class="modal-body">
    <form name="formData">
        <div class="info-dropdown">
            <div class="form-group" ng-class="{'has-error':submitted && formData.label.$invalid}">
                <label>{{ trans('configuration/data-option/data-option-create.title_dropdown') }}:<span class="text-require"> *</span></label>
                <div>
                    <input class="form-control" type="text" ng-model="dataOption.label" name="label" type="text" ng-required ="true">
                    <label class="control-label" ng-show="submitted && formData.label.$error.required" >
                        {{ trans('configuration/data-option/data-option-create.title_dropdown_required') }}
                    </label>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                 <input id="filter-checkbox"  ng-true-value="true" ng-false-value="false" ng-model="dataOption.checkTable"  type="checkbox"  name="checkTable">
                <label >{{ trans('configuration/data-option/data-option-create.table_option') }}:<span class="text-require" ng-show="dataOption.checkTable"> *</span></label>

            </div>
            <div ng-show="dataOption.checkTable" class="form-group" ng-init="tableNames={{json_encode($tableNames)}}"  ng-class="{'has-error':submitted}" >
                <select class="form-control" name="dataOption.dataTable" ng-model="dataOption.dataTable">
                <option ng-repeat="tableName in tableNames" value="@{{tableName.name}}">@{{tableName.name}}</option>
                </select>
                <label class="control-label" ng-show="submitted &&!dataOption.dataTable " >
                        {{ trans('configuration/data-option/data-option-create.table_option_required') }}
                </label>
            </div>
            <div  ng-show="!dataOption.checkTable" class="form-group" ng-class="{'has-error':submitted && formData.number_option.$invalid}">
                <label >{{ trans('configuration/data-option/data-option-create.number_option') }}:<span class="text-require"> *</span></label>
                <div>
                    <input class="form-control" ng-change="createOption(formData.number_option.$invalid)" type="number" ng-required ="true" ng-model="dataOption.number_option" name="number_option"  min="1">
                    <label class="control-label" ng-show="submitted && formData.number_option.$error.required" >
                        {{ trans('configuration/data-option/data-option-create.number_option_required') }}.
                    </label>
                     <label class="control-label" ng-show="submitted && formData.number_option.$invalid && !formData.number_option.$error.required" >
                        {{ trans('configuration/data-option/data-option-create.number_option_is_number') }}.
                    </label>
                </div>
            </div>
        </div>
        <div ng-show="dataOption.number_option&&!dataOption.checkTable" class="set-option">
            <div class="form-group" ng-repeat="(key, value) in options" ng-class="{'has-error':submitted && formData['optionName@{{$index+1}}'].$invalid}">
                <label>{{ trans('configuration/data-option/data-option-create.option') }} @{{$index + 1}}</label>
                <input type="text" ng-model="dataOption.option[$index].name" class="form-control" ng-required ="true" name="optionName@{{$index+1}}">
                <label class="control-label" ng-show="submitted && formData['optionName@{{$index+1}}'].$error.required" >
                    {{ trans('configuration/data-option/data-option-create.option') }} @{{$index + 1}} {{ trans('configuration/data-option/data-option-create.is_a_required_field') }}.
                </label>
            </div>
        </div>
        <div class="alert alert-danger" ng-show="error">
            @{{error}}
        </div>
    </form>
    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <div class="center-block">
            <button ng-click="cancel()" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> {{ trans('configuration/data-option/data-option-create.cancel') }}</button>
            <button ng-if="!dataOption._id" type="submit" ng-click="create(formData.$invalid)" class="btn btn-primary btn-nxt"><i class="fa fa-plus"></i> {{ trans('configuration/data-option/data-option-create.add') }}</button>
            <button ng-if="dataOption._id" type="submit" ng-disabled="updating" ng-click="update(formData.$invalid)" class="btn btn-primary btn-nxt"><i class="fa fa-plus"></i> {{ trans('configuration/data-option/data-option-create.edit') }}</button>

        </div>
</div>
