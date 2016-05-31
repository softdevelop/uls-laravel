@extends('ticket::ticket.layout.ticket')
@section('title')
    Task Manager
@stop
@section('content')
    <!-- Right sibar -->
    @include('ticket::ticket.shared.yourticket')
    <!-- End Right sibar -->
    <a href="" id="sidebar-ticket" class="visible-xs"><i class="fa  fa-building-o"></i></a>
    <ul class="breadcrumb br-ticket">
        <li class="p-t-10">
            <a ng-href=""><h5>@{{groupName}} {{trans('tickets/index.table.tasks')}}</h5></a> / 
        </li>
    </ul>
    <div class="p-b-6">

        <a ng-if="showChild" ng-click="shouldShowChild()" class="btn btn-sm btn-default pull-right btn-mobile m-r-20"> 
            <i class="fa fa-eye"></i>
            {{trans('tickets/index.action.show_child_tickets')}}
        </a>

        <a ng-if="!showChild" ng-click="shouldShowChild()" class="btn btn-sm btn-default pull-right btn-mobile m-r-20">
            <i class="fa fa-tags"></i>
            {{trans('tickets/index.action.nest_child_tickets')}}
        </a>

        <a ng-click="updateDueDateListTicket(ticketSelected)" class="btn btn-sm btn-default pull-right btn-mobile m-r-10">
            <i class="fa fa-expand"></i>
            {{trans('tickets/index.action.update_due_date')}}           
        </a>
        
        @if (\Auth::user()->can('delete_task_manager_tickets'))
            <a ng-click="deleteListTickets(ticketSelected)" class="btn btn-sm btn-default pull-right btn-mobile m-r-10">
                <i class="fa fa-trash-o"></i>
                {{trans('tickets/index.action.delete')}}
            </a>
        @endif

        <a class="btn btn-sm btn-default pull-right assign btn-mobile m-r-10">
            <select-menu text="Re-assign" items="usersOfTicket" placeholder="Search User" title="Assign User Task Manager" icon="fa-gear"
                         ng-model="assignId" 
                         user-id="ticket.assign_id" 
                         list-ticket="listTicket"
                         on-click="assignPeopleList(assignId)" 
                         type="assign-list" >
            </select-menu>
        </a>
        <div class="clearfix"></div>
    </div>

    <div ng-if="errorDeleted">
        <div class="alert alert-danger">
            <strong>Can not delete ticket</strong>
        </div>
    </div>
    <div class="table-responsive list-ticket wrap-box-content set-height" ng-init="currentState='{{$state}}'; getTickets(); getTicketGroup()">
        <table class="table table-list table-list-ticket" ng-table="tableParams" show-filter="isSearch">
            <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
                <i class="fa fa-search"></i>
            </a> 
            <tbody id="responsive-table-body">
                <tr class="pointer" ng-repeat-start="item in $data">
                    <td colspan="13" class="padding-none">
                        <a class="a-wrap-table" href="{{URL::to('support/show')}}/@{{item.id}}">
                            <table class="full-width">
                                <tr>
                                    <td ng-click="$event.stopPropagation();" class="text-center">
                                        <a class="" href="javascript:void(0)" ng-if="item.openChild && showChild && item.children.length > 0" ng-click="item.openChild = false">
                                            <i class="fa fa-minus p-15-20"></i>
                                        </a>
                                        <a class="c-000" href="javascript:void(0)" ng-if="!item.openChild && showChild && item.children.length > 0" ng-click="item.openChild = true" >
                                            <i class="fa fa-plus p-15-20"></i>
                                        </a>
                                    </td>

                                    <!-- Choose ticket -->
                                    <td ng-click="$event.stopPropagation();">
                                        <div class="checkbox checkbox-success fix-label-checkbox">
                                            <input  type="checkbox" id="checkbox-@{{item.id}}" ng-click="selectTicket($event, item)"/>
                                            <label for="checkbox-@{{item.id}}">
                                            </label>
                                        </div>
                                    </td>
                                    

                                    <td sortable="'id'" filter="{ 'id': 'text' }" data-title="'{{trans('tickets/index.table.id')}}'">
                                        <div class="pre-line">@{{item.id}}</div>
                                    </td>

                                    <td class=" position-select" sortable="'type_id'" data-title="'{{trans('tickets/index.table.type')}}'" data-filter="{ 'type_id': 'filterType' }" data-filter-data="typeFilterSelect($column)">
                                        <div class="pre-line">@{{types[item.type_id]['name']}}</div>
                                    </td>
                                    
                                    <td class="" sortable="'title'" filter="{ 'title': 'text' }" data-title="'{{trans('tickets/index.table.subject')}}'">
                                        <div class="pre-line">@{{item.title}}</div>
                                    </td>

                                    <td  class="" data-title="'{{trans('tickets/index.table.status')}}'" sortable="'status'" data-filter="{ 'status': 'filterStatus' }" data-filter-data="statusFilterSelect($column)">
                                       <div class="pre-line"> @{{states[item.status]}}</div>
                                    </td>

                                    <td  class=" position-select"  sortable="'priority'" data-title="'{{trans('tickets/index.table.priority')}}'" data-filter="{ 'priority': 'filterPriority' }" data-filter-data="priorityFilterSelect($column)">
                                        <div class="pre-line">@{{prioritys[item.priority]}}</div>
                                    </td>

                                    <td  class="" data-title="'{{trans('tickets/index.table.assignee')}}'" sortable="'assign_id'" data-filter="{ 'assign_id': 'assign_id' }" data-filter-data="assignFilterData($column)">
                                        <span ng-show="item.assign_id">
                                            @{{users_map[item.assign_id]['name']}} @{{users_map[item.assign_id]['deleted_at'] != null ? '(Deactivated)' : ''}}
                                        </span>
                                        <span ng-show="item.assign_id == 'unassigned'">Unassigned</span>
                                    </td>
                                    <td  class=""  sortable="'create'" data-title="'{{trans('tickets/index.table.date_started')}}'" filter="{ 'create': 'text' }" >
                                        <span class="line-height-24">@{{item.create | myDateTime}}</span>
                                    </td>
                                    <td class=" w-110" data-title="'{{trans('tickets/index.table.due_date')}}'" sortable="'dueDate'" filter="{ 'dueDate': 'text' }" >
                                        <span class="line-height-24" ng-if="!item.hideDueDate">
                                            @{{item.dueDate | myDateTime}}                                            
                                        </span>
                                    </td>
                                    <td data-title="'{{trans('tickets/index.table.percent_complete')}}'" filter="{ 'percentSearch': 'filterPercent' }"sortable="'percent_complete'">
                                        <span class="fix-space-progress progress progress-normal full-left">
                                            <span class="progress-bar progress-bar-primary" ng-style="{'width':item.percent_complete + '%'}">@{{item.percent_complete}}%</span>    
                                        </span>
                                    </td>

                                    @if (\Auth::user()->can('delete_task_manager_tickets'))
                                        <td data-title="'{{trans('tickets/index.table.action')}}'">
                                            <a class="delete-16" ng-click="deleteTicket($event, item)" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash-o space-delete"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            </table>
                        </a>
                    </td>
                    
                </tr>
                <tr ng-show="item.openChild && showChild" class="child-active" ng-repeat-end="" ng-repeat="ticketChild in item.children" ng-click="clickable($envent, ticketChild.id)" >
                    <td colspan="12" class="padding-none">
                        <a class="a-wrap-table" href="{{URL::to('support/show')}}/@{{ticketChild.id}}">
                            <table class="full-width">
                                <tr>
                                    <td></td>

                                    <!-- Choose ticket -->
                                    <td ng-click="$event.stopPropagation();">
                                        <div class="checkbox checkbox-success fix-label-checkbox">
                                            <input id="checkbox-@{{ticketChild.id}}" type="checkbox" ng-click="selectTicket($event, ticketChild)"/>
                                            <label for="checkbox-@{{ticketChild.id}}">
                                            </label>
                                        </div>
                                    </td>
                                    
                                    <td sortable="'id'" filter="{ 'id': 'text' }" data-title="'{{trans('tickets/index.table.id')}}'">
                                        <div class="pre-line">@{{ticketChild.id}}</div>
                                    </td>

                                    <td class=" position-select" data-title="'{{trans('tickets/index.table.type')}}'"  data-filter="{ 'type_id': 'select' }" data-filter-data="typeFilterSelect($column)">
                                        <div class="pre-line">@{{types[ticketChild.type_id]['name']}}</div>
                                    </td>

                                    <td class="" sortable="'title'" filter="{ 'title': 'text' }" data-title="'{{trans('tickets/index.table.subject')}}'">
                                        <div class="pre-line">@{{ticketChild.title}}</div>
                                    </td>

                                    <td  class="" data-title="'{{trans('tickets/index.table.status')}}'">
                                        <div class="pre-line">@{{states[ticketChild.status]}}</div>
                                    </td>

                                    <td  class=" position-select" data-title="'{{trans('tickets/index.table.priority')}}'" data-filter="{ 'priority': 'select' }" data-filter-data="priorityFilterSelect($column)">
                                        <div class="pre-line">@{{prioritys[ticketChild.priority]}}</div>
                                    </td>
                                    
                                    <td  class="" data-title="'{{trans('tickets/index.table.assignee')}}'">
                                        <span ng-show="ticketChild.assign_id">@{{users_map[ticketChild.assign_id]['name']}} @{{users_map[ticketChild.assign_id]['deleted_at'] != null ? '(Deactivated)' : ''}}</span>
                                        <span ng-show="ticketChild.assign_id == 'unassigned'">Unassigned</span>
                                    </td>
                                    <td  class="" data-title="'{{trans('tickets/index.table.date_started')}}'">
                                        <span class="line-height-24">@{{ticketChild.created_at | myDateTime}}</span>
                                    </td>
                                    <td class=" w-110" data-title="'{{trans('tickets/index.table.due_date')}}'" sortable="'due_date'">
                                        <span class="line-height-24" ng-if="!ticketChild.hideDueDate">
                                            @{{ticketChild.due_date | myDateTime}}                                            
                                        </span>
                                    </td>
                                    <td data-title="'{{trans('tickets/index.table.percent_complete')}}'" sortable="'percent_complete'">
                                        <span class="progress progress-normal full-left">
                                            <span class="progress-bar progress-bar-primary" ng-style="{'width':ticketChild.percent_complete + '%'}">@{{ticketChild.percent_complete}}%</span>    
                                        </span>
                                    </td>
                                    @if (\Auth::user()->can('delete_task_manager_tickets'))
                                        <td data-title="'{{trans('tickets/index.table.action')}}'">
                                            <a class='delete-16' ng-click="deleteTicket($event, ticketChild)" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash-o space-delete"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            </table>
                        </a>
                    </td>
                    
                </tr>
            </tbody>
        </table>
    </div>
@stop
@section('script')
    <script>
        window.typeFilter = {!! json_encode($typeFilter) !!};
        window.shouldShowAllTicket = {!! json_encode($shouldShowAllTicket) !!};
        window.statusFilter = {!! json_encode($statusFilter) !!};
        window.filterIncludeClosed = {!! json_encode($filterIncludeClosed) !!};
        
        window.maxUpload   = {!!json_encode(uploadMaxFile())!!};
        window.types = {!!json_encode($listType)!!};
        window.prioritys = {!!json_encode($prioritys)!!}
        window.items = {!!json_encode($items)!!}
        window.states = {!!json_encode($states)!!}
        window.usersSelected = {!!json_encode($usersSelected)!!}
        
        window.returnSearchResultParam = {!!json_encode($returnSearchResultParam)!!}
    </script>
    <!-- Filter Assignee -->
    <script type="text/ng-template" id="ng-table/filters/assign_id.html">
        <select class="form-control pointer" ng-change="filtering()" ng-init="initSelect2('filter-assign_id')" class="select2" id="filter-assign_id"
                multiple ng-multiple="true"
                ng-options="data.id as data.title for data in $column.data"
                ng-model="params.filter()['assign_id']">

            <!-- <option value="all" ng-selected="selected">All</option>  
            <option value="unassigned">Unassigned</option>        
            <option ng-repeat="(key,value) in usersSelected" value="@{{value['id']}}" >@{{value['name']}}</option> -->

        </select>
    </script>

    <!-- Filter type -->
    <script type="text/ng-template" id="ng-table/filters/filterType.html">
        <select class="form-control pointer" ng-change="filtering()" ng-init="initSelect2('filter-type_id')" class="select2" id="filter-type_id"
                multiple ng-multiple="true"
                ng-options="data.id as data.title for data in $column.data"
                ng-model="params.filter()['type_id']">
                <!-- <option value="">All</option> -->
        </select>
    </script>

    <!-- Filter status -->
    <script type="text/ng-template" id="ng-table/filters/filterStatus.html">
        <select class="form-control pointer" ng-change="filtering()" ng-init="initSelect2('filter-status')" class="select2" id="filter-status"
                multiple ng-multiple="true"
                ng-options="data.id as data.title for data in $column.data"
                ng-model="params.filter()['status']">
                <!-- <option value="">All</option> -->
        </select>
    </script>

    <!-- Filter priority -->
    <script type="text/ng-template" id="ng-table/filters/filterPriority.html">
        <select class="form-control pointer" ng-change="filtering()" ng-init="initSelect2('filter-priority')" class="select2" id="filter-priority"
                multiple ng-multiple="true"
                ng-options="data.id as data.title for data in $column.data"
                ng-model="params.filter()['priority']">
                <!-- <option value="">All</option> -->
        </select>
    </script>

    <!-- Filter Percent -->
    <script type="text/ng-template" id="ng-table/filters/filterPercent.html">
        <input type="range" name="points" min="0" max="100" id='percent-search' ng-change="filtering()" ng-model="params.filter()['percentSearch']">
        <span>@{{params.filter()['percentSearch']}}%</span>
    </script>

    @if(!isProduction() && !isDev())
        {!! Html::script('app/components/ticket/ticketController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/ticket/ticketService.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/file/fileController.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/file/fileService.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/file/fileDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/components/user/userService.js?v='.getVersionScript())!!}   
        {!! Html::script('app/shared/status/statusDirective.js?v='.getVersionScript())!!}
        {!! Html::script('app/shared/select-menu/selectMenuDirective.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/ticket.js') }}"></script>
    @endif

@stop