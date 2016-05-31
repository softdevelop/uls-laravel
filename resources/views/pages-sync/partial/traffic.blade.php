<div ng-controller="PageControllerTraffic" role="tabpanel" class="col-lg-12 tab-pane tab-traffic fix-tab-pane {{$state == 'traffic' ? 'active': ''}}"  id="traffic">
    <div class="col-lg-12 padding-none">
        <div class="col-lg-12">
            <div class="col-lg-6 col-md-6 col-xs-12 dr-l">
                <select class="col-lg-5 col-md-5" name="typeFilterFirst" ng-model="firstSelect.typeFilterFirst" ng-change="filterFirstSelect(firstSelect.typeFilterFirst)" ng-init="firstSelect.typeFilterFirst = 'Sessions'">
                    <option value="Sessions">{{trans('cms_page/page-sync/page-sync-partial-traffic.sessions')}}</option>
                    <option value="Users">{{trans('cms_page/page-sync/page-sync-partial-traffic.users')}}</option>
                    <option value="Page Views">{{trans('cms_page/page-sync/page-sync-partial-traffic.page_views')}}</option>
                    <option value="Pages/Sessions">{{trans('cms_page/page-sync/page-sync-partial-traffic.pages')}}/{{trans('cms_page/page-sync/page-sync-partial-traffic.sessions')}}</option>
                    <option value="Avg.Sessions">{{trans('cms_page/page-sync/page-sync-partial-traffic.avg')}}.{{trans('cms_page/page-sync/page-sync-partial-traffic.sessions')}}</option>
                    <option value="Bounce">{{trans('cms_page/page-sync/page-sync-partial-traffic.bounce')}}</option>
                    <option value="New Sessions">{{trans('cms_page/page-sync/page-sync-partial-traffic.new_sessions')}}</option>
                </select>
                <span class="col-lg-1 col-md-1 space-vertical">{{trans('cms_page/page-sync/page-sync-partial-traffic.vs')}}.</span>
                <select class="col-lg-5 col-md-5" name="typeFilterSecond" ng-model="secondSelect.typeFilterSecond" ng-change="filterSecondSelect(secondSelect.typeFilterSecond)" ng-init="secondSelect.typeFilterSecond = 'Page Views'">
                    <option value="Page Views">{{trans('cms_page/page-sync/page-sync-partial-traffic.page_views')}}</option>
                    <option value="Users">{{trans('cms_page/page-sync/page-sync-partial-traffic.users')}}</option>
                    <option value="Bounce">{{trans('cms_page/page-sync/page-sync-partial-traffic.bounce')}}</option>
                    <option value="Pages/Sessions">{{trans('cms_page/page-sync/page-sync-partial-traffic.pages')}}/{{trans('cms_page/page-sync/page-sync-partial-traffic.sessions')}}</option>
                    <option value="Avg.Sessions">{{trans('cms_page/page-sync/page-sync-partial-traffic.avg')}}.{{trans('cms_page/page-sync/page-sync-partial-traffic.sessions')}}</option>
                    <option value="Sessions">{{trans('cms_page/page-sync/page-sync-partial-traffic.sessions')}}</option>
                    <option value="New Sessions"{{trans('cms_page/page-sync/page-sync-partial-traffic.new_sessions')}}</option>
                </select>
                <a class="text-table col-lg-1 col-md-1" href=""><span class="fa fa-close space-vertical"></span></a>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12 dr-r">
                <div class="pull-right">
                    <!-- Nav tabs -->
                    <div class="btn-group" role="group" aria-label="...">
                     {{--  <button type="button" class="btn btn-default">Hourly</button>
                      <button type="button" class="btn btn-default">Day</button>
                      <button type="button" class="btn btn-default">Week</button>
                      <button type="button" class="btn btn-default">Month</button> --}}
                    </div>
                    <!-- <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Hourly</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Day</a></li>
                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Week</a></li>
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Month</a></li>
                    </ul> -->
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="col-lg-12 padding-none">
            <!-- Tab panes -->
            <div class="col-lg-12 m-t-20 padding-none-mb">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="col-lg-12 wrap-main-chart">
                            <div id="chart-1"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- <div role="tabpanel" class="tab-pane" id="profile">...</div>
                    <div role="tabpanel" class="tab-pane" id="messages">...</div>
                    <div role="tabpanel" class="tab-pane" id="settings">...</div> -->
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-12 padding-none">
                <div class="col-lg-8 padding-none">
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div class="wrap-chart-item">
                            <div id="chart-session" class="size-chart-item"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div class="wrap-chart-item">
                            <div id="chart-user" class="size-chart-item"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div class="wrap-chart-item">
                            <div id="chart-pages-view" class="size-chart-item"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div class="wrap-chart-item">
                            <div id="chart-pages-view-session" class="size-chart-item"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div class="wrap-chart-item">
                            <div id="chart-pages-avg-session" class="size-chart-item"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div class="wrap-chart-item">
                            <div id="chart-pages-bounce" class="size-chart-item"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div class="wrap-chart-item">
                            <div id="chart-pages-new-session" class="size-chart-item"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 m-t-15 padding-none-mb">
                    <div class="wrap-chart-item">
                        <div id="chart-test" class="size-chart-item"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-12 padding-none">
                <div class="col-lg-4 m-t-20 padding-none-mb">
                    <div class="border-box-ccc1">
                        <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-partial-traffic.demongraphics')}}</p>
                        <ul class="list-unstyled margin0">
                            <a class="text-table" href="" ng-click="getDataLanguage('Language')"><li class="item-gg active">{{trans('cms_page/page-sync/page-sync-partial-traffic.language')}}</li></a>
                            <a class="text-table" href="" ng-click="getDataCountry('Country')"><li class="item-gg">{{trans('cms_page/page-sync/page-sync-partial-traffic.country')}}</li></a>
                            <a class="text-table" href="" ng-click="getDataCity('City')"><li class="item-gg">{{trans('cms_page/page-sync/page-sync-partial-traffic.city')}}</li></a>
                        </ul>
                    </div>
                    <div class="border-box-ccc1">
                        <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-partial-traffic.system')}}</p>
                        <ul class="list-unstyled margin0">
                            <a class="text-table" href="" ng-click="getDataBrowser('Browser')"><li class="item-gg">{{trans('cms_page/page-sync/page-sync-partial-traffic.browser')}}</li></a>
                            <a class="text-table" href="" ng-click="getDataOperatingSystem('Operating System')"><li class="item-gg">{{trans('cms_page/page-sync/page-sync-partial-traffic.operating_system')}}</li></a>
                            <a class="text-table" href="" ng-click="getDataProviderSystem('Service Provider')"><li class="item-gg">{{trans('cms_page/page-sync/page-sync-partial-traffic.service_provider')}}</li></a>
                        </ul>
                    </div>
                    <div class="border-box-ccc">
                        <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-partial-traffic.mobile')}}</p>
                        <ul class="list-unstyled margin0">
                            <a ng-click="getDataOperatingSystemMobile('Operating System Mobile')" class="text-table" href=""><li class="item-gg">{{trans('cms_page/page-sync/page-sync-partial-traffic.operating_system')}}</li></a>
                            <a ng-click="getDataProviderSystemMobile('Service Provider Mobile')" class="text-table" href=""><li class="item-gg">{{trans('cms_page/page-sync/page-sync-partial-traffic.service_provider')}}</li></a>
                            <a ng-click="getDataScreenResolutionMobile('Screen Resolution Mobile')" class="text-table" href=""><li class="item-gg">{{trans('cms_page/page-sync/page-sync-partial-traffic.screen_resolution')}}</li></a>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 m-t-20 padding-none-mb">
                    <div class="table-responsive">
                        <table class="table table-striped fix-width-striped">
                            <thead>
                                <tr>
                                    <th class="text-left">#</th>
                                    <th class="text-left">@{{firtNameColumb}}</th>
                                    <th class="text-left">{{trans('cms_page/page-sync/page-sync-partial-traffic.sessions')}}</th>
                                    <th class="text-left">{{trans('cms_page/page-sync/page-sync-partial-traffic.sessions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(key, session) in showData track by $index">
                                    <td class="text-left">@{{$index + 1}}</td>
                                    <td class="text-left"><a class="text-table" href="">@{{key}}</a></td>
                                    <td class="text-left"><a class="text-table" href="">@{{session}}</a></td>
                                    <td class="text-left">
                                        <div class="progress progress-mini middle">
                                            <span class="progress-bar progress-bar-primary" style="width: @{{session / totalSession * 100}}%;"></span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12 m-t-20">
                        {{-- <a class="btn btn-primary" href="">View Full Report</a> --}}
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>