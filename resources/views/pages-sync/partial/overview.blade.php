<div role="tabpanel" class="col-lg-12 tab-pane overview-tab fix-tab-pane {{$state == 'overview' ? 'active': ''}}" id="actions">
    <p><span class="f700">{{trans('cms_page/page-sync/page-sync-overview.title')}}:</span> @{{pageOject.name}}</p>
    <p><span class="f700">{{trans('cms_page/page-sync/page-sync-overview.url')}}:</span> @{{pageOject.url.replace("http://www.ulsinc.com", "")}}</p>
    
    <p class="f700">{{trans('cms_page/page-sync/page-sync-overview.page_errors')}}</p>
    @if(empty($seoData['data']['output']))
        <p class="text-page-error">'{{trans('cms_page/page-sync/page-sync-overview.none')}}'</p>
    @else
    @if(count($seoData['data']['output']['diagnosticsInfo']['errorList']) > 1)
    <p class="text-page-error" ng-repeat="value in seo.data.output.diagnosticsInfo.errorList.entry">@{{value}}</p>
    @else
    <p class="text-page-error">@{{seo.data.output.diagnosticsInfo.errorList.entry ? seo.data.output.diagnosticsInfo.errorList.entry:'none' }}</p>
    @endif
    @endif
    <p class="f700">{{trans('cms_page/page-sync/page-sync-overview.page_warnings')}}</p>
    <div class="text-page-warning">
        @if(empty($seoData['data']['output']))
            <p>'{{trans('cms_page/page-sync/page-sync-overview.none')}}'</p>
        @else
        @if(count($seoData['data']['output']['diagnosticsInfo']['warningList']['entry']) > 1)
        <p ng-repeat="warning in seo.data.output.diagnosticsInfo.warningList.entry">@{{warning}}</p>
        @else
        <p>@{{seo.data.output.diagnosticsInfo.warningList.entry}}</p>
        @endif   
        @endif 
    </div>
    <p class="f700">{{trans('cms_page/page-sync/page-sync-overview.page_info')}}</p>
    <div class="text-page-info">
        <p ng-repeat="value in seo.data.output.diagnosticsInfo.infoList.entry ">@{{value}}</p>
    </div>
    <div class="col-lg-6 padding-left-none">
        <div class="border-box-ccc">
            <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-overview.search_factors')}}</p>
            <img class="google-tittle" src="/images/google.png" alt="Universal Laser Systems">
            <div>
                <div class="item-gg">
                    <a href=""><img src="/images/google PR.png" alt=""></a>
                    <span>{{trans('cms_page/page-sync/page-sync-overview.google_pr')}}</span>
                    @if(empty($seoData['data']['output']))
                        <span class="f700 pull-right">0</span>
                    @else
                        <span class="f700 pull-right">@{{seo.data.output.pageInfo.PageRank}}</span>
                    @endif 
                </div>
                <div class="item-gg">
                    <a href=""><img src="/images/google-plus.png" alt=""></a>
                    <span>{{trans('cms_page/page-sync/page-sync-overview.page_indexed_in_google')}}</span>
                    <span class="f700 pull-right"><span class="change-up">@{{seo.data.output.pageInfo.indexation.google?'Yes':'No'}}</span></span>
                </div>
                <div class="item-gg">
                    <a href=""><img src="/images/popularity.png" alt=""></a>
                    <span>{{trans('cms_page/page-sync/page-sync-overview.page_indexed_in_bing')}}</span>
                    <span class="f700 pull-right"><span class="change-down">@{{seo.data.output.pageInfo.indexation.bing?'Yes':'No'}}</span></span>
                </div>
                <div class="item-gg">
                    <a href=""><img src="/images/global-search-icon.jpg" alt=""></a>
                    <span>{{trans('cms_page/page-sync/page-sync-overview.links_on_page')}}</span>
                    @if(empty($seoData['data']['output']))
                        <span class="f700 pull-right"><span class="change-up">0</span> </span>
                    @else
                         <span class="f700 pull-right"><span class="change-up">@{{seo.data.output.pageInfo.totalLinks}}</span> </span>
                    @endif 
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 padding-right-none">
        <div class="wrap-social-activity">
            <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-overview.social_activity')}}</p>
            <div class="r-l-item">
                <div class="item-gg">
                    <a href=""><img src="/images/facebook.png" alt=""></a>
                    <span class="hide-fb">{{trans('cms_page/page-sync/page-sync-overview.facebook')}}</span>
                    @if(empty($seoData['data']['output']))
                        <span class="f700 pull-right">0</span>
                    @else
                         <span class="f700 pull-right">@{{seo.data.output.pageInfo.reputation.facebook }}</span>
                    @endif 
                    <span class="f700 pull-right">@{{seo.data.output.pageInfo.reputation.facebook }}</span>
                </div>
                <div class="item-gg">
                    <a href=""><img src="/images/twitter.png" alt=""></a>
                    <span class="hide-tt">{{trans('cms_page/page-sync/page-sync-overview.twitter')}}</span>
                    @if(empty($seoData['data']['output']))
                        <span class="f700 pull-right">0</span>
                    @else
                        <span class="f700 pull-right">@{{seo.data.output.pageInfo.reputation.twitter }}</span>
                    @endif 
                </div>
                <div class="item-gg">
                    <a href=""><img src="/images/google-plus.png" alt=""></a>
                    <span class="hide-gg">{{trans('cms_page/page-sync/page-sync-overview.google')}} +</span>
                    @if(empty($seoData['data']['output']))
                        <span class="f700 pull-right">0</span>
                    @else
                        <span class="f700 pull-right">@{{seo.data.output.pageInfo.reputation.googleblogsearch }} </span>
                    @endif 
                </div>
            </div>
            <div class="l-l-item">
                <div class="item-gg">
                    <a href=""><img src="/images/delicious.png" alt=""></a>
                    <span class="hide-dl">{{trans('cms_page/page-sync/page-sync-overview.delicious')}}</span>
                    @if(empty($seoData['data']['output']))
                        <span class="f700 pull-right">0</span>
                    @else
                        <span class="f700 pull-right">@{{seo.data.output.pageInfo.reputation.facebook }}</span>
                    @endif 
                </div>
                <div class="item-gg">
                    <a href=""><img src="/images/stumbleupon.png" alt=""></a>
                    <span class="hide-sl">{{trans('cms_page/page-sync/page-sync-overview.stumbleupon')}}</span>
                    @if(empty($seoData['data']['output']))
                        <span class="f700 pull-right">0</span>
                    @else
                        <span class="f700 pull-right">@{{seo.data.output.pageInfo.reputation.stumbleupon }}</span>
                    @endif 
                </div>
                <div class="item-gg">
                    <a href=""><img src="/images/diigo.png" alt=""></a>
                    <span class="hide-dig">{{trans('cms_page/page-sync/page-sync-overview.digg')}}</span>
                    @if(empty($seoData['data']['output']))
                        <span class="f700 pull-right">0</span>
                    @else
                        <span class="f700 pull-right">@{{seo.data.output.pageInfo.reputation.digg }}</span>
                    @endif 
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-lg-12 padding-none m-t-15">
        <div class="col-lg-4 padding-left-none3">
            <div id="container" class="container-chart"></div>
            <div class="col-lg-6 col-sm-6 m-t-15">
                <p class="text-center">{{trans('cms_page/page-sync/page-sync-overview.previous_month')}}</p>
                <p class="text-center infor-chart1">10%</p>
            </div>
            <div class="col-lg-6 col-sm-6 m-t-15">
                <p class="text-center">{{trans('cms_page/page-sync/page-sync-overview.previous_year')}}</p>
                <p class="text-center infor-chart1">10%</p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-lg-4 padding-none mb-m-t">
            <div id="container1" class="container-chart-over"></div>
            <div class="col-lg-6 col-sm-6 m-t-15">
                <p class="text-center">{{trans('cms_page/page-sync/page-sync-overview.previous_month')}}</p>
                <p class="text-center infor-chart1">10%</p>
            </div>
            <div class="col-lg-6 col-sm-6 m-t-15">
                <p class="text-center">{{trans('cms_page/page-sync/page-sync-overview.previous_year')}}</p>
                <p class="text-center infor-chart2">10%</p>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-lg-4 padding-right-none3">
            <div id="container2" class="container-chart"></div>
            <div class="col-lg-6 col-sm-6 m-t-15">
                <p class="text-center">{{trans('cms_page/page-sync/page-sync-overview.previous_month')}}</p>
                <p class="text-center infor-chart2">10%</p>
            </div>
            <div class="col-lg-6 col-sm-6 m-t-15">
                <p class="text-center">{{trans('cms_page/page-sync/page-sync-overview.previous_year')}}</p>
                <p class="text-center infor-chart2">10%</p>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>