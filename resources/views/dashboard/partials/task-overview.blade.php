<!-- Task manager overview -->
<div class="box-item">
    <div class="wrap-title-header-b-t-20">
        <h5 class="title-chart">
            <span class="action">
                <a class="collapsed" ng-if="!userDashboardView.height" ng-click="setCollapse(userDashboardView)" href="javascipt:void(0)">
                    <i  class="fa fa-chevron-right"></i>
                </a>
                <a ng-if="userDashboardView.height"  ng-click="setCollapse(userDashboardView)" href="javascipt:void(0)">
                    <i  class="fa fa-chevron-down"></i>
                </a>
                <a href="javascript:void(0)" class="my-handle-field">
                    <i class="fa fa-arrows"></i>
                </a>
                <a ng-if="!$first" href="javascript:void(0)">
                    <i  class="fa fa-arrow-up" ng-click="moveUp($event)"></i>
                </a>
                <a ng-if="!$last" href="javascript:void(0)">
                    <i  class="fa fa-arrow-down" ng-click="moveDown($event)"></i>
                </a>
            </span>
            <span>{{trans('dashboard/dashboard.taskOverview.title')}}</span>
        </h5>
    </div>
    <div class="table-responsive m-b-20 block-ds" id="page_overview" ng-style="{height:userDashboardView.height}" id="task_manager_overview">
        <div class="wrap-explain-chart ">
            <div class="total-infor">
                <span class="item-infor"><i class="fa fa-circle new"></i></span>
                <span >
                {{trans('dashboard/dashboard.taskOverview.new')}}
                </span>
                <span class="item-infor"><i class="fa fa-circle open"></i></span>
                <span>
                {{trans('dashboard/dashboard.taskOverview.open')}}
                </span>
                <span class="item-infor"><i class="fa fa-circle ready-for-review"></i></span>
                <spa>
                {{trans('dashboard/dashboard.taskOverview.ready_for_review')}}
                </span>
                <span class="item-infor"><i class="fa fa-circle approved"></i></span>
                <span>
                {{trans('dashboard/dashboard.taskOverview.approved')}}
                </span>
                <span ng-if="isShowTicketClosed">
                <span class="item-infor"><i class="fa fa-circle close-ticket"></i></span>
                <span>
                {{trans('dashboard/dashboard.taskOverview.closed')}}
                </span>                
                </span>
            </div>
        </div>
        <div>
            <a class="btn btn-sm btn-default pull-left btn-mobile m-r-10" ng-click="selectTypeToShowDashBoard()">
            <i class="fa fa-eye"></i> {{trans('dashboard/dashboard.taskOverview.button.add')}}
            </a>
            <a class="btn btn-sm btn-default pull-left btn-mobile m-r-10" ng-click="removeTypeOnDashBoard()">
            <i class="fa fa-eye-slash"></i> {{trans('dashboard/dashboard.taskOverview.button.delete')}}
            </a>          
            <a class="btn btn-sm btn-default pull-left btn-mobile m-r-10" ng-click="showTicketClosed()">
            <span ng-if="!isShowTicketClosed"><i class="fa fa-eye"></i> {{trans('dashboard/dashboard.taskOverview.button.show_closed_tickets')}}</span>
            <span ng-if="isShowTicketClosed"><i class="fa fa-eye-slash"></i> {{trans('dashboard/dashboard.taskOverview.button.hide_closed_tickets')}}</span>
            </a>
            <div class="clearfix"></div>
        </div>
        </br>
        <div class="table-responsive wrap-box-content m-b-20">
            <div class="table-responsive">
                <table class="table fix-height-tb center-td table-percentage table-triped table-list-ticket" ng-table="tableParamsTicketTypes" show-filter="isSearch">
                    <tbody>
                        <tr ng-repeat-start="type in $data">
                            <td class="text-center">
                                <span ng-if="type['childs'].length">
                                <a class="c-000" href="javascript:void(0)" ng-if="type.openChild" ng-click="type.openChild = false"><i class="fa fa-minus"></i></a>
                                <a class="c-000" href="javascript:void(0)" ng-if="!type.openChild" ng-click="type.openChild = true"><i class="fa fa-plus"></i></a>
                                </span>
                            </td>
                            <td>
                                <div class="checkbox checkbox-success fix-label-checkbox">
                                    <input type="checkbox" id="checkbox-@{{type.id}}" ng-click="selectType($event, type)">
                                    <label for="checkbox-@{{type.id}}">
                                    </label>
                                </div>
                            </td>
                            <td class="text-center" data-title="'{{trans('dashboard/dashboard.taskOverview.table.task_type')}}'" sortable="'name'">
                                <a class="c-333" ng-click="goToTaskManager(type,null,isShowTicketClosed)" >@{{type.name}}</a>
                            </td>
                            <td class="" data-title="'{{trans('dashboard/dashboard.taskOverview.table.percentage_complete')}}'" sortable="'percent'">
                                <span ng-if="type.percent != null" class="fix-space-progress progress progress-normal middle full-left pointer" ng-click="goToTaskManager(type,null,isShowTicketClosed)">
                                <span class="progress-bar progress-bar-primary" ng-style="{'width':type.percent + '%'}">
                                @{{type.percent}}%
                                </span>
                                </span>
                                <span ng-if="type.percent == null" class="middle full-left">
                                There are no @{{type.name}} tickets
                                </span>
                            </td>
                            <td class="text-center" data-title="'{{trans('dashboard/dashboard.taskOverview.table.task_count')}}'">
                                <div ng-if="type.percent != null" class="fix-space-progress progress progress-normal middle full-left pointer overflow-visible">
                                    <div class="h18">
                                        <span tooltip="{{trans('dashboard/dashboard.taskOverview.new')}} @{{type.new || ''}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top" class="progress-bar bg-new-status-ticket pull-left" href="#" ng-click="goToTaskManager(type,'new',null)" ng-style="{'width':type.percentNew + '%'}" >@{{type.new || ''}}</span>

                                        <span tooltip="{{trans('dashboard/dashboard.taskOverview.open')}} @{{type.open || ''}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top" class="progress-bar bg-open-status-ticket pull-left" href="#" ng-click="goToTaskManager(type,'assigned',null)" ng-style="{'width':type.percentOpen + '%'}">@{{type.open || ''}}</span>

                                        <span tooltip="{{trans('dashboard/dashboard.taskOverview.ready_for_review')}} @{{type.reviewed || ''}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top" class="progress-bar bg-ready-for-review-status-ticket pull-left" ng-click="goToTaskManager(type,'reviewed',null)" href="#" ng-style="{'width':type.percentReviewed + '%'}">@{{type.reviewed || ''}}</span>

                                        <span tooltip="{{trans('dashboard/dashboard.taskOverview.approved')}} @{{type.approved || '' }}" tooltip-trigger tooltip-animation="true" tooltip-placement="top" class="progress-bar bg-approved-status-ticket pull-left" href="#" ng-click="goToTaskManager(type,'approved',null)" ng-style="{'width':type.percentApproved + '%'}">@{{type.approved || '' }}</span>

                                        <span tooltip="{{trans('dashboard/dashboard.taskOverview.closed')}} @{{type.closed || ''}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top" class="progress-bar bg-close-status-ticket pull-left" href="#"
                                            ng-if="isShowTicketClosed"
                                            ng-click="goToTaskManager(type,'closed',null)" 
                                            ng-style="{'width':type.percentClosed + '%'}">
                                        @{{type.closed || ''}}
                                        </span>
                                        
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <!-- </div> -->
                            </td>
                        </tr>
                        <tr class="child-active" ng-show="type.openChild" ng-repeat-end ng-repeat="children in type['childs']">
                            <td class="text-center">
                            </td>
                            <td>
                                <div class="checkbox checkbox-success fix-label-checkbox">
                                    <input type="checkbox" id="checkbox-@{{children.id}}" ng-click="selectType($event, children)">
                                    <label for="checkbox-@{{children.id}}">
                                    </label>
                                </div>
                            </td>
                            <td  data-title="'{{trans('dashboard/dashboard.taskOverview.table.task_type')}}'">
                                <a class="c-333" href="#" ng-click="goToTaskManager(children,null,isShowTicketClosed)">@{{children.name}}</a>
                            </td>
                            <td class="" data-title="'{{trans('dashboard/dashboard.taskOverview.table.percentage_complete')}}'" sortable="'percent'">
                                <span ng-if="children.percent != null" class="fix-space-progress progress progress-normal middle full-left pointer" ng-click="goToTaskManager(children,null,isShowTicketClosed)">
                                <span class="progress-bar progress-bar-primary" ng-style="{'width':children.percent + '%'}">
                                @{{children.percent}}%
                                </span>
                                </span>
                                <span ng-if="children.percent == null" class="middle full-left">
                                There are no @{{children.name}} tickets
                                </span>
                            </td>
                            <td class="text-center" data-title="'{{trans('dashboard/dashboard.taskOverview.table.task_count')}}'">
                                <div class="wrap-position-explain">
                                    <div ng-if="children.percent != null" class="progress progress-normal middle full-left pointer overflow-visible">
                                        <div class="">
                                            <span tooltip="{{trans('dashboard/dashboard.taskOverview.new')}} @{{children.new || ''}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top" class="progress-bar bg-new-status-ticket pull-left" href="#" ng-click="goToTaskManager(children,'new',null)" ng-style="{'width':children.percentNew + '%'}">@{{children.new || ''}}</span>
                                            <span tooltip="{{trans('dashboard/dashboard.taskOverview.open')}} @{{children.open || ''}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top" class="progress-bar bg-open-status-ticket pull-left" href="#" ng-click="goToTaskManager(children,'assigned',null)" ng-style="{'width':children.percentOpen + '%'}">@{{children.open || ''}}</span>
                                            <span tooltip="{{trans('dashboard/dashboard.taskOverview.ready_for_review')}} @{{children.reviewed || ''}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top" class="progress-bar bg-ready-for-review-status-ticket pull-left" ng-click="goToTaskManager(children,'reviewed',null)" href="#" ng-style="{'width':children.percentReviewed + '%'}">@{{children.reviewed || ''}}</span>
                                            <span tooltip="{{trans('dashboard/dashboard.taskOverview.approved')}} @{{children.approved || ''}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top" class="progress-bar bg-approved-status-ticket pull-left" href="#" ng-click="goToTaskManager(children,'approved',null)" ng-style="{'width':children.percentApproved + '%'}">@{{children.approved || ''}}</span>
                                            <span tooltip="{{trans('dashboard/dashboard.taskOverview.closed')}} @{{children.closed || ''}}" tooltip-trigger tooltip-animation="true" tooltip-placement="top" class="progress-bar bg-close-status-ticket pull-left" href="#"
                                                ng-if="isShowTicketClosed"
                                                ng-click="goToTaskManager(children,'closed',null)" 
                                                ng-style="{'width':children.percentClosed + '%'}">
                                            @{{children.closed || ''}}
                                            </span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
