<style type="text/css">
    input.select2-search__field{
        height: inherit;
    }
    .bootstrap-switch-container {
        height: 34px!important;
    }
</style>
@extends('app')
@section('title')
    Create
@stop
@section('content')
<div class="roles-wrap wrap-branch" data-ng-controller="ModalManageTermCtrl"> 
    <div class="tab-content">
        <div class="tab-menu-field wrap-term">
            {{-- <a class="active" href="{{URL::to('admin/terms')}}"><i class="fa fa-magic"></i> Terms</a>
            <a href="{{URL::to('admin/field')}}"><i class="fa icon-wrench-fill"></i> Fields</a>
            <a href="{{URL::to('admin/field-type')}}"><i class="fa fa-legal"></i> Field Types</a> --}}
        </div>

        <form method="POST" class="css-form" accept-charset="UTF-8" name="formData" ng-init="term={{json_encode($term)}}; getData()">
            
                <div ng-repeat="filed in fileds" class="col-lg-@{{filed.value['col']}} @{{filed.value.alias}}"  ng-class="{'has-error': submitted && formData.@{{filed.attrName}}.$invalid}">    

                        <form-builder ng-if="!term.fields[$index].modal" content="filed.htmlField"></form-builder>
                        <span class="m-l-20" ng-show="submitted && formData.@{{filed.attrName}}.$error.required">@{{filed.name}} is a required field</span>
                        <span class="m-l-20" ng-show="submitted &&formData.@{{filed.attrName}}.$invalid && !formData.@{{filed.attrName}}.$error.required">@{{filed.name}} is a invalid</span>
 {{--                    <legend ng-if="term.fields[$index].modal">
                        <strong style="font-size:13px;">Add @{{filed.name}}</strong> 
                        <a href="javascript:void(0)" ng-click="showModal(filed, $index)" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></a>
                    </legend>
                    <div id="fix-w" class="table-responsive" ng-if="term.fields[$index].modal">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th ng-repeat="(key, value) in filed.fileds">@{{value.name}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in dataModal[$index]">
                                    <td ng-repeat="value in filed.fileds">
                                        <p ng-if="value.element != 'select' && value.element != 'date' && value.element != 'file' && value.element != 'number'">
                                            <span ng-show="item[value.alias]" ng-bind-html="item[value.alias] | htmlize"></span>
                                        </p>
                                        <p ng-if="value.element == 'select'">
                                            <span ng-show="item[value.alias]"> @{{dataOptionMap[item[value.alias]]['name']}} </span>
                                        </p>
                                        <p ng-if="value.element == 'date'">
                                            <span ng-show="item[value.alias]"> @{{item[value.alias] | myDate}} </span>
                                        </p>
                                        <p ng-if="value.element == 'number'">
                                            <span ng-show="item[value.alias]"> @{{item[value.alias] | currency}} </span>
                                        </p>                                        
                                        <p> 
                                            <a ng-if="value.element == 'file' && filesAll[item[value.alias]]['file_name'].length  < 13" ng-href="@{{baseUrl}}/admin/file/download/@{{item[value.alias]}}" class="icon-f" title="files">
                                                @{{filesAll[item[value.alias]]['file_name']}}
                                            </a> 

                                            <a ng-if="value.element == 'file' && filesAll[item[value.alias]]['file_name'].length  > 13" ng-href="@{{baseUrl}}/admin/file/download/@{{item[value.alias]}}" class="icon-f" title="files">
                                                @{{filesAll[item[value.alias]]['file_name'] | limitTo: 10}}
                                                @{{filesAll[item[value.alias]]['file_name'].length > 13 ? '...' : '.'}}
                                                @{{filesAll[item[value.alias]]['file_name'].split('.').pop()}}
                                            </a> 
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> --}}

                </div>
            
        </form>



        <button id="bt-submit" class="btn btn-primary" ng-click="submit(formData)"><i class="fa fa-check"></i> Save</button>
    </div>
</div>
@stop

@section('script')
    <script>
        window.field = {!!json_encode($field)!!};
        window.term = {!! json_encode($term) !!};
        window.item = {!! json_encode($item) !!};
        window.termId = {!! json_encode($termId) !!};
        window.termName = {!! json_encode($termName) !!};
        window.htmlOrverideFiled = {!!json_encode($htmlOrverideFiled)!!};
        window.tagHtml = {!!json_encode($tagHtml)!!};
    </script>

    @if(!isProduction() && !isDev())
        {!! Html::script('/app/components/manage-term/ManageTermService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/manage-term/ManageTermController.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}

    @else
        <script src="{{ elixir('app/pages/managerTerm.js') }}"></script>
    @endif
    
@stop
