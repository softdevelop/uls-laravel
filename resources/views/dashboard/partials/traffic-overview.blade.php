<!-- Traffic overview -->
<div class="box-item">
    <div class="">
        <h5 class="title-chart">
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
            <span>
            {{trans('dashboard/dashboard.trafficOverview.title')}}
            </span>
        </h5>
    </div>
    <div class="table-responsive m-b-20 block-ds" id="page_overview" ng-style="{height:userDashboardView.height}" id="traffic_overview">
        <table class="table center-td table-wrap-chart">
            <tr>
                <td>
                    <div id="PageVisitorsChart"></div>
                </td>
                <td>
                    <div id="CollumnVisitorsandLeads"></div>
                </td>
            </tr>
        </table>
    </div>
</div>
