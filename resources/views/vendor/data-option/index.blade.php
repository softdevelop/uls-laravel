@extends('app')	
@section('title')
    {{ trans('configuration/data-option/data-option-index.data_option') }}
@endsection
@section('content')
<div class="wrap-branch st-container hidden" ng-controller="DataOptionController">

    <div class="top-content">
        <label class="c-m">{{ trans('configuration/data-option/data-option-index.breadcrum') }}
        </label>
        <a data-toggle="modal" href="javascript:void(0)" ng-click="getModalCreate()" class="btn btn-primary pull-right fix-btn-top-content">
            <i class="fa fa-plus"></i> {{ trans('configuration/data-option/data-option-index.data_option') }}
        </a>
    </div>

    <div class="content data-option">
        <div class="table-responsive set-dropdown">
            <table class="table table-striped" ng-table="tableParams">
                <tbody>
                    <tr ng-repeat="(key, group) in  $data track by $index">

                        <td data-title="'{{ trans('configuration/data-option/data-option-index.title_dropdown') }}'">
                            @{{group.label}}
                        </td>
                        <td data-title="'{{ trans('configuration/data-option/data-option-index.dropdown') }}'" class="fix-select" >
                           <select class="w230" name="" id="">
                              <option ng-repeat="(key, value) in group.option" value="@{{value._id['$id'] ? value._id['$id']: value._id}}">@{{value.name}}</option>
                           </select>
                        </td>
                        <td data-title="'{{ trans('configuration/data-option/data-option-index.action') }}'">
                            <a class="action-icon" ng-click="getModalCreate(group, $index)" data-toggle="modal"  title="" title="Edit">
                                <i class="ti-pencil"></i>
                            </a>
                            <a class="action-icon" ng-click="delete(group._id, $index)">
                            <i class="fa fa-trash-o"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    window.options = {!!json_encode($dataOption)!!};
</script>
@stop
@section('script')
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/data-option/dataOptionController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/data-option/dataOptionService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/dataoption.js') }}"></script>
    @endif
@stop

