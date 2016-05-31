@extends('app')
@section('title')
    Field Types
@stop
@section('content')
<div class="roles-wrap wrap-branch term" data-ng-controller="filedTypeController">
    <div class="tab-content">
        <div class="tab-menu-field wrap-term">
            <a  href="{{URL::to('admin/terms')}}"><i class="fa fa-magic"></i> Terms</a>
            <a href="{{URL::to('admin/field')}}"><i class="fa icon-wrench-fill"></i> Fields</a>
            <a class="active" href="{{URL::to('admin/field-type')}}"><i class="fa fa-legal"></i> Field Types</a>
        </div>
        <div class="text-right">
            <a href="{{URL::to('admin/field-type/create')}}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Field Type
              </a>
        </div>
        <div class="table-responsive table-terms wrap-box-content" ng-init="getAllFieldType()">
                <table class="table v-middle center-td" ng-table="tableParams">
                    <tbody id="responsive-table-body">
                        <tr  ng-repeat="item in $data | orderBy:'-created_at'">

                            <td  class="w200" data-title="'Name'" >@{{item.name}}</td>
                            <td  data-title="'Description'">@{{item.description}}</td>
                            <td  class="w100" data-title="'Action'">
                                <a  href="/admin/field-type/edit/@{{item._id}}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa fa-pencil"></i></a>
                                <a href="/admin/field-type/show/@{{item._id}}"  class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Test"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-primary btn-xs" ng-click="deleteFieldType(item._id)" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</div>
@stop
@section('script')
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/field-type/filedTypeController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/field-type/filedTypeService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/field-type.js') }}"></script>
    @endif
@stop
