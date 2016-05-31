@extends('app')
@section('title')
    Terms
@stop
@section('content')
<div class="roles-wrap term" data-ng-controller="TermController">
    <div class="tab-content">
        <div class="tab-menu-field wrap-term">
            <a class="active" href="{{URL::to('admin/terms')}}"><i class="fa fa-magic"></i> Terms</a>
            <a href="{{URL::to('admin/field')}}"><i class="fa icon-wrench-fill"></i> Fields</a>
            <a href="{{URL::to('admin/field-type')}}"><i class="fa fa-legal"></i> Field Types</a>
        </div>
        <div class="text-right">
            <a href="javascript:void(0)" ng-click="getModalCreateNewTerm()" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Term
            </a>
        </div>
        <div class="table-responsive wrap-box-content table-terms">
            <table class="table center-td">
                <thead>
                    <tr>
                        <th class='w200'>
                            Field
                        </th>
                        <th>
                            Description
                        </th>
                        <th class="w120 text-center">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in terms | orderBy:'-created_at'">
                        <td>
                            @{{item.name}}
                        </td>
                        <td>
                            @{{item.description}}
                        </td>
                        <td class="text-center">

                            <a href="/admin/terms/@{{item._id}}/template-manager" title="Template manager" class="btn btn-primary btn-xs"><i class="fa fa-gg"></i></a>

                            <a href="/admin/terms/edit/@{{item._id}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>

                            <a class="btn btn-primary btn-xs" ng-click="deleteTerm(item._id)" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>


@stop
@section('script')
    <script>
        window.terms = {!!json_encode($terms)!!};
    </script>
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/terms/termController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/terms/termService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/terms.js') }}"></script>
    @endif
@stop
