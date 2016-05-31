@extends('app')
@section('title')
    @if($fieldType->id)
      Edit Field Type
    @else
      Add Field Type
    @endif
@stop
@section('content')

<div class="roles-wrap wrap-branch"  ng-controller="createFiledTypeController">
    <div class="tab-content">
        
        <div class="tab-menu-field wrap-term">
            <a href="{{URL::to('admin/terms')}}"><i class="fa fa-magic"></i>  Terms</a>
            <a href="{{URL::to('admin/field')}}"><i class="fa icon-wrench-fill"></i> Fields</a>
            <a class="active" href="{{URL::to('admin/field-type')}}"><i class="fa fa-legal"></i> Field Types</a>
        </div>
        <div class="alert alert-success" ng-if="errorMessage">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close" ng-click="closeNotification()">×</a>
            <strong>Success save field type!</strong>
        </div>
        <form class="field-type" name="formData" ng-init="fieldType={{$fieldType}}" novalidate >
            <div class="form-group" ng-class="{'has-error':submitted && formData.name.$invalid}">
                <label for="" class="col-lg-12 f700">Field Name: <span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <input class="form-control"  placeholder="Field Name" type="text" name="name" id="name" value=""  ng-pattern="/^[a-zA-Z ]*$/" ng-model="fieldType.name" ng-required="true" ng-change="changName()">
                    <small class="help-inline">@{{nameExists}}</small>
                    <span class="help-inline" ng-show="submitted &&formData.name.$error.required">Field name is a required field</span>
                    <span class="help-inline" ng-show="submitted &&formData.name.$error.pattern">Not special letter</span>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-class="{'has-error':submitted && formData.output_type.$invalid}">
                <label for="" class="col-lg-12 f700">Category: <span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <select required="true" class="select-category" ng-change="changeCategory(fieldType.category)" ng-model="fieldType.category" id="category" name="category">
                        <option value="" disabled="disabled" selected="selected"> ---Select Category--- </option>
                        <option value="form_element">Form element</option>
                        <option value="term">Term</option> 
                    </select>
                    <span class="help-inline" ng-show="submitted &&formData.category.$error.required">Category is a required field</span>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group" ng-class="{'has-error':submitted && formData.output_type.$invalid}">
                <label for="" class="col-lg-12 f700">Output Type: <span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <select ng-options="key as value for (key,value) in types" ng-model="fieldType.output_type" name="output_type" class="form-control select-output-type" ng-required ="true" ng-change="changeOutputType(fieldType.output_type)">
                        <option value="" disabled="disabled" selected="selected"> ---Select Output Type--- </option>
                    </select>
                     <span class="help-inline" ng-show="submitted &&formData.output_type.$error.required">Output type is a required field</span>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-class="{'has-error':submitted && formData.term.$invalid}" ng-if="fieldType.output_type == 'term'">
                <label for="" class="col-lg-12 f700">Term: <span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <select name="term" class="form-control select-term"
                            ng-options="item._id as item.name for item in {{json_encode($term)}}"
                            ng-required ="true"
                            ng-model="fieldType.termId">
                        <option value="" disabled="disabled" selected="selected"> ---Select Term--- </option>
                    </select>
                    <span class="help-inline" ng-show="submitted &&formData.term.$error.required">Term is a required field</span>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-class="{'has-error':submitted && formData.output_type.$invalid}" ng-if="fieldType.output_type == 'term'">
                <label for="" class="col-lg-12 f700"></label>
                <div class="col-lg-12" >
                   <div class="checkbox checkbox-success">
                        <input id="filter-checkbox"  ng-true-value="true" ng-false-value="false" ng-model="fieldType.isMulti"  type="checkbox"  name="is-multi">
                        <label for="filter-checkbox"> Is Multiple</label>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-show="fieldType.output_type != 'term'">
                <label class="col-lg-12 f700 m-b--5">Pre Add On:</label>
                <div class="col-lg-12">
                    <div class="controls">
                        <textarea class="form-control m-t-10" ng-model="fieldType.pre_addon" placeholder="Enter Pre Add On Here" id="pre_addon_html" name="pre_addon_html"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>


            <div class="form-group" ng-if="fieldType.output_type == 'html'" ng-class="{'has-error':submitted && formData.output_type.$invalid}">
                <label for="" class="col-lg-12 f700">Content Output:</label>
                <div class="col-lg-12">
                    <div class="controls">
                        <textarea ng-required="true" class="form-control m-t-10" ng-model="fieldType.output_content" placeholder="Enter HTML Here" id="output_content" name="output_content"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-show="fieldType.output_type != 'term'">
                <label class="col-lg-12 f700 m-b--5">Post Add On:</label>
                <div class="col-lg-12">
                    <div class="controls">
                        <textarea class="form-control m-t-10" ng-model="fieldType.post_addon" placeholder="Enter Post Add On Here" id="post_addon_html" name="post_addon_html"></textarea>
                    </div>
                  
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-class="{'has-error':submitted && formData.description.$invalid}">
                <label for="" class="col-lg-12 f700">Description: <span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <textarea class="form-control" id="description" placeholder="Enter Description Here" name="description" rows="3" ng-model="fieldType.description" ng-required="true">
                    </textarea>
                    <span class="help-inline" ng-show="submitted &&formData.description.$error.required">Description is a required field</span>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-class="{'has-error':submitted && formData.help.$invalid}">
                <label for="" class="col-lg-12 f700">Help: <span class="text-require"> *</span></label>
                <div class="col-lg-12">
                <textarea class="form-control" id="help" placeholder="Enter Help Here" name="help" rows="3" ng-model="fieldType.help" ng-required="true">
                </textarea>
                <span class="help-inline" ng-show="submitted &&formData.help.$error.required">Help is a required field</span>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="form-group" ng-show="fieldType.output_type != 'term'">
                <label for="" class="col-lg-12 f700">Legend:</label>
                <div class="col-lg-12">
                    <p>*: Required</p>
                    <p>&: Default Value</p>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group attributes-area" ng-if="fieldType.output_type != 'term'">
                <div class="form-group">
                    <label for="" class="col-lg-6">Attributes:</label>
                    <div class="col-lg-6">
                        <a href="" ng-click="addAttribute()" class="pull-right btn btn-primary btn-xs"><i class="fa fa-plus-square"></i> Add Attribute</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <div class="col-lg-12">
                    <div class="col-lg-12">
                        @if(empty($fieldType->_id))
                        <div ng-repeat="(key, value) in fieldType.attribute">
                            <div class="col-lg-4">
                                <label for="" class="col-lg-3 space-vertical">Key</label>
                                <div class="col-lg-9">
                                    <input  ng-model="fieldType.attribute[$index].key" type="text" placeholder="Enter Key Here" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-lg-4" ng-if="!dataOption[$index]">
                                <label for="" class="col-lg-3 space-vertical">Value</label>
                                <div class="col-lg-9">
                                    <input  type="text" ng-model="fieldType.attribute[$index].value" placeholder="Enter Value Here" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-4" ng-if="dataOption[$index]">
                                <label for="" class="col-lg-3 space-vertical">Value</label>
                                <div class="col-lg-9">
                                    <select class="form-control" ng-change="dataOption(0)" ng-options="key as value for (key, value) in attributeDataOptions" ng-model="fieldType.attribute[$index].value">
                                    </select>
                                </div>
                            </div>
                           
                            <div class="col-lg-4">
                                <div class="checkbox checkbox-success">
                                    <input id="filter-checkbox"  ng-true-value="true" ng-false-value="false" ng-model="dataOption[$index]"  type="checkbox"  name="filter-status">
                                    <label for="filter-checkbox"> is data option</label>
                                </div>
                            </div>
                            <div class="close-attr">
                                <a class="close-details-attr" href="" ng-click="removeAttribute($index)">
                                    <i class="fa fa-times-circle"></i>
                                </a>
                            </div>

                            <div class="clearfix"></div>
                            <div id="add_attribute"> </div>
                        </div>
                        @else
                        <div ng-repeat="item in fieldType.attribute">
                            <div id="element-apepend@{{$index}}">
                                <div class="col-lg-4">
                                    <label for="" class="col-lg-3 space-vertical">Key</label>
                                    <div class="col-lg-9">
                                        <input  ng-model="fieldType.attribute[$index].key" type="text" placeholder="Enter Key Here" class="form-control">
                                        
                                    </div>
                                </div>
                                <div class="col-lg-4" ng-if="!dataOption[$index]">

                                    <label for="" class="col-lg-3 space-vertical">Value</label>
                                    <div class="col-lg-9">
                                        <input ng-value="fieldType.attribute[$index].value"  type="text" ng-model="fieldType.attribute[$index].value" placeholder="Enter Value Here" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-lg-4" ng-if="dataOption[$index]">
                                    <label for="" class="col-lg-3 space-vertical">Value</label>
                                    <div class="col-lg-9">

                                        <select class="form-control" ng-change="dataOption($index)" ng-options="key as value for (key, value) in attributeDataOptions" ng-model="fieldType.attribute[$index].value">
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="checkbox checkbox-success">
                                        <input id="filter-checkbox@{{$index}}" ng-true-value="true" ng-false-value="false" ng-model="dataOption[$index]"  type="checkbox">
                                        <label for="filter-checkbox@{{$index}}"> is data option</label>
                                    </div>
                                </div>
                                <div class="close-attr">
                                    <a class="close-details-attr" href="" ng-click="removeAttribute($index)">
                                        <i class="fa fa-times-circle"></i>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> 
                        <div id="add_attribute"> </div>                        
                        @endif
                        
                    </div>

                    <div class="clearfix"></div>   
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="col-lg-12 form-group text-right">
                <button id="bt-submit" ng-click="createFieldType(formData.$invalid,0)" class="btn btn-primary">
                    <i  class="fa fa-check"></i> Save Close 
                </button>
                <button id="bt-submit-new" ng-click="createFieldType(formData.$invalid,1)" class="btn btn-primary">
                    <i class="fa fa-plus-square"></i> Save New 
                </button>
            </div>

            <div class="clearfix"></div>
        </form>

    </div>
</div>
<script>
    window.attribute = {!! json_encode($fieldType->attribute) !!};
    window.attributeDataOptions = {!! json_encode($listDataOption) !!}
    window.types = {!! json_encode($types) !!};
</script>

@stop
@section('script')
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/field-type/filedTypeController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/field-type/filedTypeService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/field-type.js') }}"></script>
    @endif
@stop
