@extends('app')
@section('title')
    {{ trans('tickets/type-index.type_administration') }}
@stop
@section('content')
    <div class="wrap-branch st-container" data-ng-controller="TypeController">
        <div class="top-content">
            <label class="c-m">{{ trans('tickets/type-index.type_administration') }}
            </label>
            <a data-toggle="modal" href="javascript:void(0)" ng-click="getModalCreate()" class="btn btn-primary pull-right fix-btn-top-content">
                <i class="fa fa-plus"></i> &nbsp {{ trans('tickets/type-index.support_type') }}
            </a>
        </div>
        <div class="content types">
            <div class="table-responsive " ng-init="getAllType()">    
                <table class="table v-middle table-striped" ng-table="tableParams">
                    <tbody id="responsive-table-body">
                        <tr  ng-repeat="item in $data">
                            <td class="text-center" data-title="'{{ trans('tickets/type-index.name') }}'" >@{{item.name}}</td>
                            <td class="text-center" data-title="'{{ trans('tickets/type-index.alias') }}'">@{{item.alias}}</td>
                            <td class="text-center" class="text-center" class="text-right" data-title="'{{ trans('tickets/type-index.action') }}'">
                                <a  ng-click="getModalCreate(item.id)" class="action-icon" data-toggle="tooltip" data-placement="top" title="{{ trans('tickets/type-index.edit') }}">
                                <i class="ti-pencil"></i></a>
                                <a  ng-click="delete(item.id)" class="action-icon" data-toggle="tooltip" data-placement="top" title="{{ trans('tickets/type-index.delete') }}">
                                <i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        window.ticketAssignee = {!! json_encode(listTicketPerWithType('ticket_assignee')) !!}
        window.ticketAdmin = {!! json_encode(listTicketPerWithType('ticket_admin')) !!}
    </script>
@stop

@section('script')
    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/type/typeController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/type/typeService.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/type.js') }}"></script>
    @endif
@stop