@extends('app')
@section('title')
    {{trans('cms_page/page-sync/page-sync-page-traffic.page_traffic')}}
@stop
@section('content')
<div class="wrap-branch" ng-controller="PageController">
    <div class="top-content">
        <label class="c-m">{{trans('cms_page/page-sync/page-sync-page-traffic.dashboard')}}</label>
    </div>
    <div class="content">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <span class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    {{trans('cms_page/page-sync/page-sync-page-traffic.sessions')}}
                    <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">{{trans('cms_page/page-sync/page-sync-page-traffic.sessions')}}</a></li>
                    </ul>
                </span>
                <span>vs.</span>
                <span class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    {{trans('cms_page/page-sync/page-sync-page-traffic.bounce_rate')}}
                    <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <li><a href="#">{{trans('cms_page/page-sync/page-sync-page-traffic.bounce_rate')}}</a></li>
                    </ul>
                </span>
                <span class="fa  fa-close"></span>
            </div>
            <div class="col-lg-6">
                <div class="pull-right">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">{{trans('cms_page/page-sync/page-sync-page-traffic.hourly')}}</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{trans('cms_page/page-sync/page-sync-page-traffic.day')}}</a></li>
                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">{{trans('cms_page/page-sync/page-sync-page-traffic.week')}}</a></li>
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">{{trans('cms_page/page-sync/page-sync-page-traffic.month')}}</a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-lg-12 padding-none">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div style="border:1px solid #ccc" class="col-lg-12 text-center">
                            <span style="color:#d0d0d0;font-size:30px;" class="text-center">
                            	<div id="chart-1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            </span>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">...</div>
                    <div role="tabpanel" class="tab-pane" id="messages">...</div>
                    <div role="tabpanel" class="tab-pane" id="settings">...</div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-12 padding-none">
                <div class="col-lg-8 padding-none">

                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div style="border:1px solid #ccc;">
                            <div id="chart-session" style="height: 150px; margin: 0 auto"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div style="height:150px;border:1px solid #ccc;overflow:hidden">
                            <div id="chart-user" style="height: 150px; margin: 0 auto"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div style="height:150px;border:1px solid #ccc;overflow:hidden">
                            <div id="chart-pages-view" style="height: 150px; margin: 0 auto"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div style="height:150px;border:1px solid #ccc;overflow:hidden">
                            <div id="chart-pages-view-session" style="height: 150px; margin: 0 auto"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div style="height:150px;border:1px solid #ccc;overflow:hidden">
                            <div id="chart-pages-avg-session" style="height: 150px; margin: 0 auto"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div style="height:150px;border:1px solid #ccc;overflow:hidden">
                            <div id="chart-pages-bounce" style="height: 150px; margin: 0 auto"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 m-t-15 padding-left-n-ab">
                        <div style="height:150px;border:1px solid #ccc;overflow:hidden">
                            <div id="chart-pages-new-session" style="height: 150px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 m-t-15">
                    <div style="border:1px solid #ccc;">
                        <div id="chart-test" style="height: 150px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 padding-none">
                <div class="col-lg-4 m-t-20">
                    <div class="border-box-ccc1">
                        <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-page-traffic.demongraphics')}}</p>
                        <ul class="list-unstyled margin0">
                            {{-- <li class="item-gg-active"><a class="text-table-active " href="" ng-click="getData('Language')">Language</a></li> --}}
                            <li class="item-gg"><a href="" ng-click="getData('Language')">{{trans('cms_page/page-sync/page-sync-page-traffic.language')}}</a></li>
                            <li class="item-gg"><a href="" ng-click="getData('Country')">{{trans('cms_page/page-sync/page-sync-page-traffic.country')}}</a></li>
                            <li class="item-gg"><a href="" ng-click="getData('City')">{{trans('cms_page/page-sync/page-sync-page-traffic.city')}}</a></li>
                        </ul>
                    </div>
                    <div class="border-box-ccc1">
                        <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-page-traffic.system')}}</p>
                        <ul class="list-unstyled margin0">
                            <li class="item-gg"><a href="" ng-click="getData('Browser')">{{trans('cms_page/page-sync/page-sync-page-traffic.browser')}}</a></li>
                            <li class="item-gg"><a href="" ng-click="getData('Operation System')">{{trans('cms_page/page-sync/page-sync-page-traffic.operation_system')}}</a></li>
                            <li class="item-gg"><a href="" ng-click="getData('Service Provider')">{{trans('cms_page/page-sync/page-sync-page-traffic.service_provider')}}</a></li>
                        </ul>
                    </div>
                    <div class="border-box-ccc">
                        <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-page-traffic.mobile')}}</p>
                        <ul class="list-unstyled margin0">
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-page-traffic.operation_system')}}</a></li>
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-page-traffic.service_provider')}}</a></li>
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-page-traffic.screen_resolution')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 m-t-20">
                    <div class="table-responsive">
                        <table class="table table-striped fix-width-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:left!important">#</th>
                                    <th style="text-align:left!important">@{{firtNameColumb}}</th>
                                    <th style="text-align:left!important">{{trans('cms_page/page-sync/page-sync-page-traffic.sessions')}}</th>
                                    <th style="text-align:left!important">{{trans('cms_page/page-sync/page-sync-page-traffic.sessions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in showData">
                                    <td class="text-left">1</td>
                                    <td class="text-left"><a href="">@{{data}}</a></td>
                                    <td class="text-left"><a href="">34,843</a></td>
                                    <td class="text-left">
                                        <div class="progress progress-mini">
                                            <span class="progress-bar progress-bar-primary" style="width: 50%;"></span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12">
                        <a href="">{{trans('cms_page/page-sync/page-sync-page-traffic.view_full_report')}}</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script type="text/javascript">
        window.results   = {!!json_encode($results)!!};
    </script>

    @if(!isProduction() && !isDev())
        {!! Html::script('/app/components/pages-sync/pageTraficService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages-sync/pageTraficController.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/page-sync.js') }}"></script>
    @endif

@stop