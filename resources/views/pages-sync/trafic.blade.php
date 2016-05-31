@extends('app')
@section('content')
<div class="wrap-branch">
    <div class="top-content">
        <label class="c-m">{{trans('cms_page/page-sync/page-sync-traffic.dashboard')}}</label>
    </div>
    <div class="content">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <span class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    {{trans('cms_page/page-sync/page-sync-traffic.sessions')}}
                    <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">{{trans('cms_page/page-sync/page-sync-traffic.sessions')}}</a></li>
                    </ul>
                </span>
                <span>vs.</span>
                <span class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    {{trans('cms_page/page-sync/page-sync-traffic.bounce_rate')}}
                    <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <li><a href="#">{{trans('cms_page/page-sync/page-sync-traffic.bounce_rate')}}</a></li>
                    </ul>
                </span>
                <span class="fa  fa-close"></span>
            </div>
            <div class="col-lg-6">
                <div class="pull-right">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">{{trans('cms_page/page-sync/page-sync-traffic.hourly')}}</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{trans('cms_page/page-sync/page-sync-traffic.day')}}</a></li>
                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">{{trans('cms_page/page-sync/page-sync-traffic.week')}}</a></li>
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">{{trans('cms_page/page-sync/page-sync-traffic.month')}}</a></li>
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
                    <div class="col-lg-3 m-t-30">
                        <div style="height:150px;border:1px solid #ccc;background:#efefef">{{trans('cms_page/page-sync/page-sync-traffic.s')}}1</div>
                    </div>
                    <div class="col-lg-3 m-t-30">
                        <div style="height:150px;border:1px solid #ccc;background:#efefef">{{trans('cms_page/page-sync/page-sync-traffic.s')}}2</div>
                    </div>
                    <div class="col-lg-3 m-t-30">
                        <div style="height:150px;border:1px solid #ccc;background:#efefef">{{trans('cms_page/page-sync/page-sync-traffic.s')}}3</div>
                    </div>
                    <div class="col-lg-3 m-t-30">
                        <div style="height:150px;border:1px solid #ccc;background:#efefef">{{trans('cms_page/page-sync/page-sync-traffic.s')}}4</div>
                    </div>
                    <div class="col-lg-3 m-t-30">
                        <div style="height:150px;border:1px solid #ccc;background:#efefef">{{trans('cms_page/page-sync/page-sync-traffic.s')}}2</div>
                    </div>
                    <div class="col-lg-3 m-t-30">
                        <div style="height:150px;border:1px solid #ccc;background:#efefef">{{trans('cms_page/page-sync/page-sync-traffic.s')}}3</div>
                    </div>
                    <div class="col-lg-3 m-t-30">
                        <div style="height:150px;border:1px solid #ccc;background:#efefef">{{trans('cms_page/page-sync/page-sync-traffic.s')}}4</div>
                    </div>
                </div>
                <div class="col-lg-4 m-t-30">
                    <div style="height:300px;border:1px solid #ccc;background:#efefef">{{trans('cms_page/page-sync/page-sync-traffic.s')}}5</div>
                </div>
            </div>
            <div class="col-lg-12 padding-none">
                <div class="col-lg-4 m-t-20">
                    <div class="border-box-ccc1">
                        <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-traffic.demongraphics')}}</p>
                        <ul class="list-unstyled margin0">
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.language')}}</a></li>
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.country')}}</a></li>
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.city')}}</a></li>
                        </ul>
                    </div>
                    <div class="border-box-ccc1">
                        <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-traffic.demongraphics')}}</p>
                        <ul class="list-unstyled margin0">
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.language')}}</a></li>
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.country')}}</a></li>
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.city')}}</a></li>
                        </ul>
                    </div>
                    <div class="border-box-ccc">
                        <p class="tittle-box f700">{{trans('cms_page/page-sync/page-sync-traffic.demongraphics')}}</p>
                        <ul class="list-unstyled margin0">
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.language')}}</a></li>
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.country')}}</a></li>
                            <li class="item-gg"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.city')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 m-t-20">
                    <div class="table-responsive">
                        <table class="table table-striped fix-width-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:left!important">#</th>
                                    <th style="text-align:left!important">{{trans('cms_page/page-sync/page-sync-traffic.language')}}</th>
                                    <th style="text-align:left!important">{{trans('cms_page/page-sync/page-sync-traffic.sessions')}}</th>
                                    <th style="text-align:left!important">{{trans('cms_page/page-sync/page-sync-traffic.sessions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left">1</td>
                                    <td class="text-left"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.en_us')}}</a></td>
                                    <td class="text-left"><a href="">34,843</a></td>
                                    <td class="text-left">
                                        <div class="progress progress-mini">
                                            <span class="progress-bar progress-bar-primary" style="width: 50%;"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">1</td>
                                    <td class="text-left"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.en_us')}}</a></td>
                                    <td class="text-left"><a href="">34,843</a></td>
                                    <td class="text-left">
                                        <div class="progress progress-mini">
                                            <span class="progress-bar progress-bar-primary" style="width: 50%;"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">1</td>
                                    <td class="text-left"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.en_us')}}</a></td>
                                    <td class="text-left"><a href="">34,843</a></td>
                                    <td class="text-left">
                                        <div class="progress progress-mini">
                                            <span class="progress-bar progress-bar-primary" style="width: 50%;"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">1</td>
                                    <td class="text-left"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.en_us')}}</a></td>
                                    <td class="text-left"><a href="">34,843</a></td>
                                    <td class="text-left">
                                        <div class="progress progress-mini">
                                            <span class="progress-bar progress-bar-primary" style="width: 50%;"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">1</td>
                                    <td class="text-left"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.en_us')}}</a></td>
                                    <td class="text-left"><a href="">34,843</a></td>
                                    <td class="text-left">
                                        <div class="progress progress-mini">
                                            <span class="progress-bar progress-bar-primary" style="width: 50%;"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">1</td>
                                    <td class="text-left"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.en_us')}}</a></td>
                                    <td class="text-left"><a href="">34,843</a></td>
                                    <td class="text-left">
                                        <div class="progress progress-mini">
                                            <span class="progress-bar progress-bar-primary" style="width: 50%;"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">1</td>
                                    <td class="text-left"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.en_us')}}</a></td>
                                    <td class="text-left"><a href="">34,843</a></td>
                                    <td class="text-left">
                                        <div class="progress progress-mini">
                                            <span class="progress-bar progress-bar-primary" style="width: 50%;"></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left">1</td>
                                    <td class="text-left"><a href="">{{trans('cms_page/page-sync/page-sync-traffic.en_us')}}</a></td>
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
                        <a href="">{{trans('cms_page/page-sync/page-sync-traffic.view_full_report')}}</a>
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
		(function($){
		    $('#container').highcharts({
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'CONVERSION RATE'
		        },
		        subtitle: {
		            text: '9.1%'
		        },
		        yAxis: {
		            title: {
		                enabled: false
		            }
		        },
		        exporting: { 
		        	enabled: false 
		        },
		        credits: {
				    enabled: false
				},
		        tooltip: {
		            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
		                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
		            footerFormat: '</table>',
		            shared: true,
		            useHTML: true
		        },
		        plotOptions: {
		            column: {
		                pointPadding: 0.2,
		                borderWidth: 0
		            }
		        },
		        series: [{
		            showInLegend: false, 
		            data: [49.9, 176.0, 135.6, 95.6, 54.4]

		        }]
		    });
			$(function () {
			    $('#container1').highcharts({

			        title: {
			            text: 'ORGANIC - BRANDED'
			        },

			        credits: {
					      enabled: false
					},
					yAxis: {
			            title: {
			                enabled: false
			            }
			        },
			        exporting: { 
			        	enabled: false 
			        },
			        tooltip: {
			            headerFormat: '<b>{series.name}</b><br />',
			            pointFormat: 'x = {point.x}, y = {point.y}'
			        },

			        series: [{
			        	showInLegend: false, 
			            data: [210, 190, 140, 128, 150, 70, 75, 69, 70],
			            pointStart: 1
			        }]
			    });
			});
			$(function () {
			    $('#chart-1').highcharts({
			        title: {
			            text: 'AVERAGE VISIT TIME'
			        },
			        yAxis: {
			            title: {
			                enabled: false
			            },
			            enabled: false
			        },
			        exporting: { 
			        	enabled: false 
			        },
			        credits: {
					    enabled: false
					},
			        series: [
			        	{
			        		type: '',
				        	showInLegend: false, 
				            data: [5, 3, 4, 7, 2]
			        	},
			        	{
			        		type: 'area',
			        		showInLegend: false, 
				            data: [210, 190, 140, 128, 150, 70, 75, 69, 70],
				            pointStart: 1
			        	}
			        ]
			    });
			});
		})(jQuery)
	</script>
@stop