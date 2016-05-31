<!-- Ticket overview -->
<div class="box-item">
    <div class="title-table">
        <div class="wrap-task-dashboard">
            <ul class="nav nav-tabs" role="tablist">
                <li class="title-chart">
                    <span class="action">
                        <a class="collapsed" ng-if="!userDashboardView.height" ng-click="setCollapse(userDashboardView)" href="javascipt:void(0)">
                            <i  class="fa fa-chevron-right"></i>
                        </a>
                        <a ng-if="userDashboardView.height"  ng-click="setCollapse(userDashboardView)" href="javascipt:void(0)">
                            <i  class="fa fa-chevron-down"></i>
                        </a>
                        <a href="javascipt:void(0)" class="my-handle-field">
                            <i class="fa fa-arrows"></i>
                        </a>
                        <a ng-if="!$first" href="javascipt:void(0)">
                            <i  class="fa fa-arrow-up" ng-click="moveUp($event)"></i>
                        </a>
                        <a ng-if="!$last" href="javascipt:void(0)">
                            <i  class="fa fa-arrow-down" ng-click="moveDown($event)"></i>
                        </a>
                    </span>
                </li>
                <li role="presentation" class="active">
                    <a href="#actions" aria-controls="actions" role="tab" data-toggle="tab" ng-click="isTabTask=false">
                        {{trans('dashboard/dashboard.ticket.action_required_by_me')}}
                    </a>
                </li>
                <li role="presentation">
                    <a href="#task" aria-controls="task" role="tab" data-toggle="tab" ng-click="isTabTask=true">
                        {{trans('dashboard/dashboard.ticket.tasks_in_queue')}}
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="table-responsive m-b-20 block-ds" id="page_overview" ng-style="{height:userDashboardView.height}" id="list-link">
                <div role="tabpanel" class="tab-pane active" id="actions" ng-if="!isTabTask">
                    <div class="table-responsive">
                        <table class="table fix-height-tb min-width-1000" ng-table="tableParamsNewTicket" show-filter="isSearch">
                            <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
                            <i class="fa fa-search"></i>
                            </a>
                            <tbody>
                                <tr ng-repeat="ticket in $data">
                                    <td class="text-center" data-title="'{{trans('dashboard/dashboard.ticket.date_requested')}}'" sortable="'created_at'">@{{ticket.created_at | myDate}}</td>
                                    <td class="text-center" data-title="'{{trans('dashboard/dashboard.ticket.priority')}}'" sortable="'priority'" filter="{ 'priority': 'text' }">@{{ticket.priority}}</td>
                                    <td class="text-center" data-title="'{{trans('dashboard/dashboard.ticket.due_date')}}'" sortable="'due_date'">@{{ticket.due_date | myDate}}</td>
                                    <td class="text-center url-fix" data-title="'{{trans('dashboard/dashboard.ticket.url')}}'" sortable="'url'" filter="{ 'url': 'text' }">
                                        <a ng-if="ticket.type == 'page'" href="{{linkViewDraft()}}@{{ticket.url}}">@{{ticket.url}}</a>
                                        <a ng-if="ticket.type != 'page'" href="@{{ticket.url}}">@{{ticket.url}}</a>
                                    </td>
                                    <td class="text-center" data-title="'{{trans('dashboard/dashboard.ticket.status')}}'" sortable="'status'" filter="{ 'status': 'text' }">@{{states[ticket.status]}}</td>
                                    <td class="text-center" data-title="'{{trans('dashboard/dashboard.ticket.action')}}'">
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Update" href="@{{baseUrl}}/support/show/@{{ticket.id}}">
                                        {{trans('dashboard/dashboard.ticket.update')}}
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="task" ng-if="isTabTask">
                    <div class="table-responsive">
                        <table class="table fix-height-tb wrap-url" ng-table="tableParamsAllOpenTicket" show-filter="isSearch">
                            <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
                            <i class="fa fa-search"></i>
                            </a>
                            <tbody class="wrap-url">
                                <tr ng-repeat="ticket in $data" ng-class="{highlight:ticket.timeout}">
                                    <td class="text-center" data-title="'{{trans('dashboard/dashboard.ticket.date_requested')}}'" sortable="'created_at'">@{{ticket.created_at | myDate}}</td>
                                    <td class="text-center" data-title="'{{trans('dashboard/dashboard.ticket.priority')}}'" sortable="'priority'" filter="{ 'priority': 'text' }">@{{ticket.priority}}</td>
                                    <td class="text-center" data-title="'{{trans('dashboard/dashboard.ticket.due_date')}}'" sortable="'due_date'">@{{ticket.due_date | myDate}}</td>
                                    <td class="text-center" data-title="'{{trans('dashboard/dashboard.ticket.assignee')}}'" sortable="'assign_id'">
                                        <span ng-show="ticket.assign_id">@{{users_map[ticket.assign_id]['name']}} @{{users_map[ticket.assign_id]['deleted_at'] != null ? '(Deactivated)' : ''}}</span>
                                        <span ng-show="ticket.assign_id == null">Unassigned</span>
                                        {{-- @{{ticket.assign_id == null ? 'Unassigned' : users_map[ticket.assign_id].name}} --}}
                                    </td>
                                    <td class="text-center url-fix" data-title="'{{trans('dashboard/dashboard.ticket.url')}}'" sortable="'url'" filter="{ 'url': 'text' }">
                                        <a ng-if="ticket.type == 'page'" href="{{linkViewDraft()}}@{{ticket.url}}">@{{ticket.url}}</a>
                                        <a ng-if="ticket.type != 'page'" href="@{{ticket.url}}">@{{ticket.url}}</a>
                                    </td>
                                    <td class="text-center" data-title="'{{trans('dashboard/dashboard.ticket.action')}}'">
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Update" href="@{{baseUrl}}/support/show/@{{ticket.id}}">
                                        {{trans('dashboard/dashboard.ticket.update')}}
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
