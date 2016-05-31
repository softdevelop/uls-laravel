
@extends('app')
@section('title')
    Edit Term
@stop
@section('content')
<div class="roles-wrap wrap-branch" ng-controller="TermController"> 
    <div class="tab-content wrap-generate">
        <div class="tab-menu-field wrap-term">
            <a class="active" href="{{URL::to('admin/terms')}}"><i class="fa fa-magic"></i> Terms</a>
            <a href="{{URL::to('admin/field')}}"><i class="fa icon-wrench-fill"></i> Fields</a>
            <a href="{{URL::to('admin/field-type')}}"><i class="fa fa-legal"></i> Field Types</a>
        </div>
        <div class="info-terms" ng-init="term={{json_encode($term)}}">
        
            <p class="first">
                <label>Term Name:</label>
                <span> 
                    <a href="#" editable-text="term.name"  e-name="term.name" ng-click="changeName()" onaftersave="updateTerm()">
                        @{{term.name || 'empty'}} 
                    </a>
                </span>
                <small class="help-inline">@{{nameExists}}</small>
            </p>        

            <p class="first">
                <label>Description:</label>
                <span> 
                    <a href="#" editable-text="term.description"  e-name="term.description"onaftersave="updateTerm()">@{{term.description || 'empty'}} </a>
                </span>
            </p>
            <p class="first">
                <label>Help:</label> 
                <span> 
                    <a href="#" editable-text="term.help" e-name="term.help" onaftersave="updateTerm()"> 
                         @{{term.help || 'empty'}}  
                    </a>
                </span> 
            </p>
            <p class="first">
                <div class="checkbox checkbox-success">
                    <input id="filter-checkbox"  ng-true-value="true" ng-false-value="false" ng-model="term.ticket" ng-change="updateTerm()" type="checkbox"  name="ticket" >
                    <label for="filter-checkbox">Type ticket</label>
                </div>
            </p>
            <div class="col-lg-6 padding-none">
                <p class="first">
                    <label>Add Field:</label>
                    <span>
                        <select class="pointer" select2 ng-options="key as value for (key, value) in field" ng-model="filed.field_id" name="field" ng-change="showHtmlField()">
                            <option ng-repeart="_field in field"></option>
                        </select>
                    </span>
                </p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="table-responsive table-terms wrap-box-content">
            <table class="table table-striped center-td" id="containerTable">
                <thead>
                    <tr>
                        <th>
                            Field
                        </th>
                        <th class="text-center w200">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody >
                    <tr>
                        <td class="droppedFieldsColumn">
                                
                                <div class="droppedFields">
                                    <div ng-repeat="filed in fileds" class="col-lg-@{{filed.value['col']}} @{{filed.value.alias}} fld">
                                        <form-builder content="filed.htmlField "> </form-builder>
                                        <div class="box-option">

                                            <a ng-if="!filed.value.postWrapperHtml" href="javascript:void(0)" ng-click="getModalAddWrapper(filed.value._id,$index,filed.value, $event)" class="pull-left btn btn-primary btn-xs btn-nxt edit-fiel"><i class="fa fa-paragraph"></i>@{{filed.value.endField ?'Edit Wrapper':'Add Wrapper'}} </a>
                                            
                                            <a href="javascript:void(0)" ng-click="getModalUpdateHtmlField(filed, $event)" class="pull-left btn btn-primary btn-xs btn-nxt edit-fiel"><i class="fa fa-edit"></i> Edit</a>

                                            <a href="javascript:void(0)" ng-click="deleteField(filed.value._id, $event)" class="pull-left btn btn-primary btn-xs btn-nxt edit-fiel"><i class="fa fa-times"></i> Delete</a>

                                            <a href="javascript:void(0)" ng-if="filed.value.endField"  ng-click="deleteGroupHtml(filed.value._id, $event)" class="pull-left btn btn-primary btn-xs btn-nxt edit-fiel"><i class="fa fa-times"></i>Delete Html</a>

                                            <a href="javascript:void(0)" ng-if="filed.value.isMulti" ng-click="addMore(filed.value.field_id, $event)" class="pull-left btn btn-primary btn-xs add-more m-5">
                                            <i class="fa fa-plus-square"></i> Add More</a>
                                            {{-- <div class="clearfix"></div> --}}
                                            <div class="checkbox checkbox-default checkbox-is-modal" ng-if="filed.value.term">
                                                <input type="checkbox" id="@{{filed.value._id}}" ng-false-value="0" ng-true-value="1" ng-Checked="filed.value.modal" ng-click="changeFieldOfTermIsModal(filed.value._id, term._id, $event)" name="is-multi">
                                                <label for="filter-checkbox">Is Modal</label>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div> 
                                    </div>
                                </div>
                            <div class="clearfix"></div>
                        </td>
                        <td class="text-center">
                            <a href="/admin/terms/show/@{{term._id}}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Test</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>
@stop
@section('script')
    <script>
        window.field = {!!json_encode($field)!!};
        window.htmlOrverideFiled = {!!json_encode($htmlOrverideFiled)!!}
        window.tagHtml = {!!json_encode($tagHtml)!!}
        window.baseUrl  = '{{URL::to("")}}';
    </script>

    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/terms/termDetailController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/terms/termService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/termDetail.js') }}"></script>
    @endif


    
@stop