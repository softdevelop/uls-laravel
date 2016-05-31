@extends('app')
@section('title')
    @if($field->_id)
        Edit Field
    @else
        Add Field
    @endif
@stop
@section('content')
<div class="roles-wrap wrap-branch" ng-controller="createFiledController">
    <div class="tab-content">
        
        <div class="tab-menu-field wrap-term">
            <a href="{{URL::to('admin/terms')}}"><i class="fa fa-magic"></i> Terms</a>
            <a class="active" href="{{URL::to('admin/field')}}"><i class="fa icon-wrench-fill"></i> Fields</a>
            <a  href="{{URL::to('admin/field-type')}}"><i class="fa fa-legal"></i> Field Types</a>
        </div>
        <div class="alert alert-success" ng-if="errorMessage">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close" ng-click="closeNotification()">×</a>
            <strong>Success save field!</strong>
        </div>
        <form accept-charset="utf-8" name="formData" ng-init="listDataOption={{json_encode($listDataOption)}};" class="ng-pristine ng-valid" id="MyForm">
            <div class="alert alert-danger" ng-show="error">
                @{{error}}
            </div>
            <div class="form-group" ng-class="{'has-error':submitted && formData.name.$invalid}">
                <label class="f700 c-000 col-lg-12">Field Names:<span class="text-require"> *</span></label>
                <div class="col-lg-12 required">
                    <div class="">
                        <input required="true" placeholder ="Enter Field Name" ng-model="field.name" class="form-control" id="name" type="text" name="name" ng-pattern="/^[a-zA-Z ]*$/">
                    </div>
                    <small class="help-inline" ng-show="submitted && formData.name.$error.required">Field Name is a required field.</small>
                     <small class="help-inline" ng-show="submitted && formData.name.$error.pattern">Not special letter.</small>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-class="{'has-error':submitted && formData.label.$invalid}">
                <label class="f700 c-000 col-lg-12">Field Label: </label>
                <div class="col-lg-12 required">
                    <div class="">
                        <input placeholder ="Enter Field Name" ng-model="field.label" class="form-control" id="label" type="text" name="label" ng-pattern="/^[a-zA-Z ]*$/">
                    </div>
     {{--                <small class="help-inline" ng-show="submitted && formData.label.$error.required">Field Name is a required field.</small> --}}
                     <small class="help-inline" ng-show="submitted && formData.label.$error.pattern">Not special letter.</small>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <label class="f700 c-000 col-lg-12">Pre Add On:</label>
                <div class="col-lg-12">
                    <div class="">
                        <ui-iconpicker groups="font-awesome" value="@{{field.pre_addon.glyphicon}}" ng-model="field.pre_addon.glyphicon"></ui-iconpicker>

                        <a class="action-thum-up" href="javascript:void(0);"><i ng-click="field.pre_addon.glyphicon = ''" class="fa fa-times"></i></a>

                        <textarea class="form-control m-t-10" ng-model="field.pre_addon.html" placeholder="Enter Pre HTML Here" id="pre_addon_html" name="pre_addon_html"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="f700 c-000 col-lg-12">Post Add On:</label>
                <div class="col-lg-12">
                    <div class="">
                        <ui-iconpicker groups="font-awesome" value="@{{field.post_addon.glyphicon}}" ng-model="field.post_addon.glyphicon"></ui-iconpicker>
                        <a class="action-thum-up" href="javascript:void(0);"><i ng-click="field.post_addon.glyphicon = ''" class="fa fa-times"></i></a>
                        <textarea class="form-control m-t-10" ng-model="field.post_addon.html" placeholder="Enter Post Add On Here" id="post_addon_html" name="post_addon_html"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="f700 c-000 col-lg-12">Prepend HTML:</label>
                <div class="col-lg-12">
                    <div class="">
                        <textarea class="form-control" ng-model="field.pre_html" placeholder="Enter Pre HTML Here" id="pre_html" name="pre_html"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <label class="f700 c-000 col-lg-12">Post HTML:</label>
                <div class="col-lg-12">
                    <div class="">
                        <textarea class="form-control" ng-model="field.post_html" placeholder="Enter Append HTML Here" id="post_html" name="post_html"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-class="{'has-error':submitted && formData.name.$invalid}">
                <label class="f700 c-000 col-lg-12">Description:<span class="text-require"> *</span> </label>
                <div class="col-lg-12">
                    <div class="">
                        <textarea ng-required="true" class="form-control" placeholder="Enter Description Here" ng-model="field.description" id="description" name="description"></textarea>
                    </div>
                    <small class="help-inline" ng-show="submitted && formData.description.$error.required">Description is a required field.</small>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <label class="f700 c-000 col-lg-12">Help:<span class="text-require"> *</span> </label>
                <div class="col-lg-12">
                    <div class="">
                        <textarea class="form-control" ng-required="true" ng-model="field.help" placeholder="Enter Help Here" id="help" name="help"></textarea>
                    </div>
                    <small class="help-inline" ng-show="submitted && formData.help.$error.required">Help is a required field.</small>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="form-group ng-hide" ng-show="fieldType.help">
                <label class="f700 c-000 col-lg-12"></label> 
                <div class="widget col-lg-10" data2toggle="collapse-widget" data-collapse-closed="false">
                    <div class="widget-head">
                        <h4 class="heading ng-binding"> Help</h4>
                        <span class="collapse-toggle"></span>
                    </div>
                    <div class="widget-body collapse in ng-binding height-auto"></div>
                </div>
                <div class="clearfix"></div>
            </div>

            {{-- @if(empty($field->_id)) --}}
                <div class="form-group" ng-class="{'has-error':submitted && formData.name.$invalid}">
                    <label class="f700 c-000 col-lg-12">Field Type:<span class="text-require"> *</span> </label>
                    <div class="col-lg-12">
                        <div class="">

                            <select class="select-field-type" ng-model="field.field_type_id" name="field_type_id" ng-required ="true" ng-change="getFieldAttributes()" ng-options="type._id as type.name  group by type.output_type for type in listType">
                                <option value="">Select Field Type</option>
                            </select>
                        </div>
                        <small class="help-inline" ng-show="submitted && formData.field_type_id.$error.required">Field Type is a required field.</small>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div ng-repeat="attribute in field.html_attributes">
 
                    <div class="form-group" ng-class="{'has-error':submitted && formData.input_@{{$index}}.$invalid}">
                        {{-- attribute.attr = @{{attribute.attr}} --}} 
                        <label class="col-lg-2" >@{{attribute.key}}:<span ng-if="attribute.attr == '*' || attribute.data_option==true || attribute.orveride == '*'">(*)</span> </label>                        

                        <div class="col-lg-10 required">
                            <div class="" ng-if="(attribute.attr =='*' && attribute.key != 'option' && attribute.key != 'min-date' && attribute.key != 'max-date' && attribute.key != 'required'&&attribute.key != 'min'&&attribute.key != 'max')||attribute.orveride =='&'">
                                <input  class="form-control hidden" type="text" ng-init="field.html_attributes[$index].key = attribute.key" ng-model="field.html_attributes[$index].key">
                                <input ng-required="true" ng-if="attribute.key != 'minlength'&&attribute.key != 'maxlength'" ng-model="field.html_attributes[$index].value" class="form-control" type="text" name="input_@{{$index}}">

                                <input ng-required="true"   ng-if="attribute.key == 'minlength'||attribute.key == 'maxlength'" ng-model="field.html_attributes[$index].value" class="form-control" type="number" min="1" step="1" name="input_@{{$index}}" ng-change="lengthAttribute()">

                                <small class="help-inline" ng-show="submitted && validateLength&&attribute.key == 'minlength'">minlength is less than or as equal as maxlength.</small>
                            </div>


                            <div class="" ng-if="attribute.attr =='&' && attribute.key != 'option' && attribute.key != 'min-date' && attribute.key != 'max-date'  && attribute.key != 'required'&&attribute.key != 'min'&&attribute.key != 'max'">
                                <input  class="form-control hidden" type="text" ng-init="field.html_attributes[$index].key = attribute.key" ng-model="field.html_attributes[$index].key">

                                <input ng-if="attribute.key != 'minlength'&&attribute.key != 'maxlength'" ng-model="field.html_attributes[$index].value" class="form-control" type="text" name="input_@{{$index}}">

                                <input ng-if="attribute.key == 'minlength'||attribute.key == 'maxlength'" ng-model="field.html_attributes[$index].value" class="form-control" type="number" min="1" step="1" name="input_@{{$index}}" ng-change="lengthAttribute()">

                                <small class="help-inline" ng-show="submitted && validateLength&&attribute.key == 'minlength'">minlength is less than or as equal as maxlength.</small>
                            </div>
                            <div class="" ng-if="attribute.key == 'min-date' || attribute.key == 'max-date'||attribute.key == 'min'||attribute.key == 'max'">
                                <input  class="form-control hidden" type="text" ng-init="field.html_attributes[$index].key = attribute.key" ng-model="field.html_attributes[$index].key">
                                <input ng-if="attribute.attr == '*'" type="text" class="form-control" name="input_@{{$index}}" 
                                        datepicker-popup="@{{formatDate}}"
                                        ng-model="field.html_attributes[$index].value"
                                        is-open="openedLimitDate" 
                                        ng-click="openedLimitDate=!openedLimitDate"
                                        ng-change="changeDate()"
                                        ng-required = "true"/>

                                <input ng-if="attribute.attr != '*'" type="text" class="form-control" name="input_@{{$index}}" 
                                        datepicker-popup="@{{formatDate}}"
                                        ng-model="field.html_attributes[$index].value"
                                        is-open="openedLimitDate" 
                                        ng-click="openedLimitDate=!openedLimitDate"
                                        ng-change="changeDate()" />
                                <small class="help-inline" ng-show="submitted && checkDate&&attribute.key == 'min-date'">min-date is less than or as equal as max-date.</small>
                                <small class="help-inline" ng-show="submitted && checkDate&&attribute.key == 'min'">min is less than or as equal as max.</small>
                            </div>

                            <div class="" ng-if="attribute.key == 'option'">
                                <input  class="form-control hidden" type="text" ng-init="field.html_attributes[$index].key = attribute.key" ng-model="field.html_attributes[$index].key">
                                <select class="form-control"  name="input_@{{$index}}" ng-required="true"  ng-model="field.html_attributes[$index].value" ng-options="key as value for (key, value) in listDataOption">
                                    <option disabled="true" value="">Select option</option>
                                </select>
                            </div>

                            <div class="" ng-if="attribute.data_option==true">
                                <input  class="form-control hidden" type="text" ng-init="field.html_attributes[$index].key = attribute.key" ng-model="field.html_attributes[$index].key">
                                <input  class="form-control hidden" type="text" ng-init="field.html_attributes[$index].value = attribute.value" ng-model="field.html_attributes[$index].value">
                                
                                <select class="form-control" ng-model="field.html_attributes[$index].value">
                                    <option value="" disabled="true">Select option</option>
                                    <option value="@{{key}}" ng-repeat="(key, value) in listDataOption track by $index">@{{value}}</option>
                                </select>
                            </div>

                            <div class="" ng-if="attribute.key=='required'">
                                <div class="checkbox checkbox-success">
                                    <input id="filter-checkbox"  ng-true-value="true" ng-false-value="false" ng-model="field.html_attributes[$index].value"  type="checkbox"  name="is-required" >
                                    <label for="filter-checkbox"> Is Required</label>
                                </div>
                            </div>

                            <small class="help-inline" ng-show="submitted && formData.input_@{{$index}}.$error.required">@{{attribute.key}} is a required field.</small>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <div class="form-group col-lg-12 text-right">
                <button id ="bt-submit" class="btn btn-primary" ng-click="createField(formData.$invalid,0)" >
                <i class="fa fa-plus-square"></i> Save Close</button>
                <button id ="bt-submit-new" class="btn btn-primary" ng-click="createField(formData.$invalid,1)" >
                <i class="fa fa-plus-square"></i> Save New</button>
            </div>
            
            <div class="clearfix"></div>
        </form>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
@stop
@section('script')

    <script>
        window.field = {!!json_encode($field)!!}
        window.listType = {!! json_encode($listType)!!}
        window.formatDate = {!! json_encode($formatDate)!!}
    </script>
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/field/FieldController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/field/FieldService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/field-type/filedTypeService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/field.js') }}"></script>
    @endif

@stop