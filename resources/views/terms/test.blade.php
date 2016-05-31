@extends('app')
@section('title')
    Test Term
@stop
@section('content')
<div class="roles-wrap wrap-branch" data-ng-controller="testTermController"> 
    <div class="tab-content">
        <div class="tab-menu-field wrap-term">
            <a class="active" href="{{URL::to('admin/terms')}}"><i class="fa fa-magic"></i> Terms</a>
            <a href="{{URL::to('admin/field')}}"><i class="fa icon-wrench-fill"></i> Fields</a>
            <a href="{{URL::to('admin/field-type')}}"><i class="fa fa-legal"></i> Field Types</a>
        </div>
        <form method="POST" class="css-form padding-none" accept-charset="UTF-8" name="formData" ng-init="term={{json_encode($term)}}">
            <div ng-repeat="filed in fileds" class="m-b-20 col-lg-@{{filed.value['col']}} @{{filed.value.alias}} padding-none" ng-class="{'has-error': submitted && formData.@{{filed.attrName}}.$invalid}">    

                <form-builder ng-if="!term.fields[$index].modal" content="filed.htmlField"></form-builder>

                <span class="m-l-20 has-error" ng-show="submitted && formData.@{{filed.attrName}}.$error.required">@{{filed.name}} is a required field</span>

                <span class="m-l-20 has-error" ng-show="submitted &&formData.@{{filed.attrName}}.$invalid && !formData.@{{filed.attrName}}.$error.required">@{{filed.name}} is a invalid</span>
                <legend ng-if="term.fields[$index].modal">
                    <strong class="f-13">Add @{{filed.name}}</strong> 
                    <a href="javascript:void(0)" ng-click="showModal(filed, $index)" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></a>
                </legend>
                <div id="fix-w" ng-form="formExpense" method="POST" class="table-responsive" ng-if="term.fields[$index].modal">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th ng-repeat="(key, value) in filed.fileds">@{{value.name}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in dataModal[$index]">
                                <td ng-repeat="value in filed.fileds">

                                    <p ng-if="value.element != 'select' && value.element != 'date' && value.element != 'file'">
                                        <span ng-show="item[value.alias]" ng-bind-html="item[value.alias] | htmlize"></span>
                                    </p>
                                    <p ng-if="value.element == 'select'">
                                        <span ng-show="item[value.alias]"> @{{dataOptionMap[item[value.alias]]['name']}} </span>
                                    </p>
                                    <p ng-if="value.element == 'date'">
                                        <span ng-show="item[value.alias]"> @{{item[value.alias] | myDate}} </span>
                                    </p>
                                    <p> <a ng-if="value.element == 'file'" ng-href="javascript:void()" class="icon-f" title="files"><i class="fa fa-file-o"></i></a> </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="form-group col-lg-12 text-right">
                <button id="bt-submit" class="btn btn-primary" ng-click="submit(formData)"><i class="fa fa-check"></i> Save</button>    
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
@stop

@section('script')
    <script>
        window.field = {!!json_encode($field)!!};
        window.htmlOrverideFiled = {!!json_encode($htmlOrverideFiled)!!}
        window.term = {!! json_encode($term) !!}
        window.tagHtml = {!! json_encode($tagHtml) !!}
        window.baseUrl  = '{{URL::to("")}}';
    </script>
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/terms/termDetailController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/terms/termService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-level/selectLevelDirective.js?v='.getVersionScript())!!}       
    @else
        <script src="{{ elixir('app/pages/testTerm.js') }}"></script>
    @endif
    
@stop
