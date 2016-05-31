@extends('app')
@section('title')
	Domain Statistics
@stop
@section('content')

	{{-- <table class="table" ng-controller="domainCtr">

        <thead>
        	<th>Domain Google PageRank</th>
        	<th>Alexa Rank</th>
        	<th>Complete Rank in Complete.Com</th>
        	<th>Traffic accourding to Complete.Com</th>
        	<th>DMOZ Listing</th>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center">@{{domainAnalysis.output.domainInfo.totalInGoogle}}</td>
                <td style="text-align: center">@{{domainAnalysis.output.trafficInfo.AlexaRank}}</td>
                <td style="text-align: center">@{{domainAnalysis.output.trafficInfo.CompeteRank}}</td>
                <td style="text-align: center">@{{domainAnalysis.output.trafficInfo}}</td>
                <td style="text-align: center">@{{domainAnalysis.output.domainInfo.DMOZcategories}}</td>
            </tr>
            <tr>
            	<td colspan="5">The domain @{{domainAnalysis.output.domainInfo.domain}} and has IP address @{{domainAnalysis.output.domainInfo.serverIP}} and is located in @{{domainAnalysis.output.domainInfo.countryServer}}.</td>
            </tr>
        </tbody>
    </table> --}}
    <div class="wrap-branch">
    <div class="top-content">
        <label class="c-m">SEO</label>
    </div>
    <div class="content st-container seo" ng-controller="domainCtr">
        <div class="row">
            <div class="col-lg-12 form-group box-domain">
                <h5 class="title-box">Domain Statistics</h5>
                <div class="content-box">
                    <p>The domain @{{domainAnalysis.output.domainInfo.domain}} has IP address <strong>@{{domainAnalysis.output.domainInfo.serverIP}}</strong> and is localted in <strong>@{{domainAnalysis.output.domainInfo.countryServer}}</strong>. The domain is age <strong>16 year(s)</strong></p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td class="text-left title-domain">
                                        <img src="images/seo/google-pr.png" alt="img">
                                        <strong>Domain Google PageGrank</strong>
                                    </td>
                                    <td class="text-right value-domain">
                                        <strong>@{{domainAnalysis.output.domainInfo.totalInGoogle}}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left title-domain">
                                        <img src="images/seo/alexa.jpg" alt="img">
                                        <strong for="">Alexa Rank</strong>
                                    </td>
                                    <td class="text-right value-domain">
                                        <strong for="">@{{domainAnalysis.output.trafficInfo.AlexaRank}}</strong>
                                    </td>
                                    <td class="text-left sub-value-domain up">
                                        <i class="fa fa-arrow-up"></i>
                                        <span class="up">80%</span>
                                    </td>
                                    <td class="text-left prosess-domain">
                                        <div class="progress progress-mini  hidden-xs">
                                            <div class="progress-bar progress-bar-success w-80-per"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left title-domain">
                                        <img src="images/seo/compolete.png" alt="img">
                                        <strong for="">Complete Rank in Complete.Com</strong>
                                    </td>
                                    <td class="text-right value-domain">
                                        <strong for="">@{{domainAnalysis.output.trafficInfo.CompeteRank}}</strong>
                                    </td>
                                    <td class="text-left sub-value-domain">
                                        <i class="fa fa-minus"></i>
                                        <span class="up">0%</span>
                                    </td>
                                    <td class="text-left prosess-domain">
                                        <div class="progress progress-mini hidden-xs">
                                            <div class="progress-bar progress-bar-success w-0-per"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left title-domain">
                                        <img src="images/seo/compolete.png" alt="img">
                                        <strong for="">Traffic accourding to Complete.Com</strong>
                                    </td>
                                    <td class="text-right value-domain">
                                        <strong for=""></strong>
                                    </td>
                                    <td class="text-left sub-value-domain">
                                        <i class="fa fa-minus"></i>
                                        <span class="up">0%</span>
                                    </td>
                                    <td class="text-left prosess-domain">
                                        <div class="progress progress-mini hidden-xs">
                                            <div class="progress-bar progress-bar-success w-0-per"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left title-domain">
                                        <img src="images/seo/dmoz.png" alt="img">
                                        <strong for="">DMOZ Listing</strong>
                                    </td>
                                    <td class="text-right value-domain">
                                        <strong for="">@{{domainAnalysis.output.domainInfo.dmoz == 0 ? 'No' : 'Yes'}}</strong>
                                        {{-- <strong ng-if="domainAnalysis.output.domainInfo.dmoz == 0" for="">No</strong> --}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- crawl --}}
            <div class="col-lg-12 form-group box-crawl">
                <h5 class="title-box">Crawl Statistics</h5>
                <div class="content-box">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td class="text-left title-domain">
                                        <img src="images/seo/m.png" alt="img">
                                        <strong for="">Proprietary Research</strong>
                                        <label>showed</label>
                                    </td>
                                    <td class="text-right value-domain">
                                        <strong for="">1234.9879</strong>
                                        <label>pages</label>
                                    </td>
                                    <td class="text-left prosess-domain">
                                        <span class="visible-xs">50%</span>
                                        <div class="progress progress-mini hidden-xs">
                                            <span class="progress-bar progress-bar-primary w-50-per"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left title-domain">
                                        <img src="images/seo/google_search.png" alt="img">
                                        <strong for="">Google</strong>
                                        <label>showed</label>
                                    </td>
                                    <td class="text-right value-domain">
                                        <strong for="">1234.9879</strong>
                                        <label>pages</label>
                                    </td>
                                    <td class="text-left prosess-domain">
                                        <span class="visible-xs">50%</span>
                                        <div class="progress progress-mini hidden-xs">
                                            <div class="progress-bar progress-bar-primary w-80-per"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left title-domain">
                                        <img src="images/seo/yahoo.png" alt="img">
                                        <strong for="">Yahoo</strong>
                                        <label>showed</label>
                                    </td>
                                    <td class="text-right value-domain">
                                        <strong for="">1234.9879</strong>
                                        <label>pages</label>
                                    </td>
                                    <td class="text-left prosess-domain">
                                        <span class="visible-xs">50%</span>
                                        <div class="progress progress-mini hidden-xs">
                                            <span class="progress-bar progress-bar-primary w-50-per"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left title-domain">
                                        <img src="images/seo/ping.png" alt="img">
                                        <strong for="">Ping</strong>
                                        <label>showed</label>
                                    </td>
                                    <td class="text-right value-domain">
                                        <strong for="">1234.9879</strong>
                                        <label>pages</label>
                                    </td>
                                    <td class="text-left prosess-domain">
                                        <span class="visible-xs">50%</span>
                                        <div class="progress progress-mini hidden-xs">
                                            <div class="progress-bar progress-bar-primary w-80-per"></div>
                                        </div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- crawl availability --}}
            <div class="col-lg-12 form-group box-crawl-avai">
                <h5 class="title-box">Crawl Availabilityh</h5>
                <div class="content-box">
                    <div id="chart-1"></div>
                </div>
            </div>

            {{-- content-structure --}}
            <div class="col-lg-12 form-group box-structure">
                <h5 class="title-box">Content and Struchture Crawl Stats</h5>
                <div class="content-box">
                    <div class="col-lg-6 item-structure">
                        <i class="fa fa-check-circle"></i>
                        <a href="">90</a>
                        <strong for="">Pages have missing or empty title tag</strong>
                    </div>
                    <div class="col-lg-6 item-structure">
                        <i class="fa  fa-times-circle"></i>
                        <a href="">90</a>
                        <strong for="">Pages have missing or empty title tag</strong>
                    </div>
                    <div class="col-lg-6 item-structure">
                        <i class="fa  fa-times-circle"></i>
                        <a href="">90</a>
                        <strong for="">Pages have missing or empty title tag</strong>
                    </div>
                    <div class="col-lg-6 item-structure">
                        <i class="fa  fa-times-circle"></i>
                        <a href="">90</a>
                        <strong for="">Pages have missing or empty title tag</strong>
                    </div>
                    <div class="col-lg-6 item-structure">
                        <i class="fa fa-check-circle"></i>
                        <a href="">90</a>
                        <strong for="">Pages have missing or empty title tag</strong>
                    </div>
                    <div class="col-lg-6 item-structure">
                        <i class="fa  fa-times-circle"></i>
                        <a href="">90</a>
                        <strong for="">Pages have missing or empty title tag</strong>
                    </div>
                    <div class="col-lg-6 item-structure">
                        <i class="fa  fa-times-circle"></i>
                        <a href="">90</a>
                        <strong for="">Pages have missing or empty title tag</strong>
                    </div>
                    <div class="col-lg-6 item-structure">
                        <i class="fa  fa-warning"></i>
                        <a href="">90</a>
                        <strong for="">Pages have missing or empty title tag</strong>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            {{-- html validation --}}
            <div class="col-lg-6 box-html">
                <h5 class="title-box">HTML Validation</h5>
                <div class="content-box">
                    <div id="chart-2"></div>
                </div>
            </div>

            {{-- css validation --}}
            <div class="col-lg-6 box-css">
                <h5 class="title-box">CSS Validation</h5>
                <div class="content-box">
                    <div id="chart-3"></div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
	<script type="text/javascript">
		window.domainAnalysis = {!!json_encode($domainAnalysis)!!};
	</script>
	
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/seo/DomainStatisticsService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/seo/DomainStatisticsController.js?v='.getVersionScript())!!}	
	@else
		<script src="{{ elixir('app/pages/domain-statistics.js') }}"></script>
	@endif
@stop
