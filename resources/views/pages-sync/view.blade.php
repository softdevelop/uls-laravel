@extends('app')
@section('title')
    {{trans('cms_page/page-sync/page-sync-view.seo')}}
@stop
@section('content')
<div class="roles-wrap" ng-controller="PageController">
    <div class="top-content">
        <label class="c-m">
        <a class="c-breadcrumb" href="{{ URL::to('seo/pages')}}">{{trans('cms_page/page-sync/page-sync-view.pages')}}</a> / {{$pageObject->name}}
        </label>
    </div>
    <div class="content">
        <div class="title-table seo">
            <div class="col-lg-12 padding-none wrap-task-dashboard">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" @if($state == 'overview') class="active" @endif>
                        <a href="javascript:void(0)" ng-click="setLink({{$pageId}}, 'overview')" aria-controls="actions" role="tab" data-toggle="tab">{{trans('cms_page/page-sync/page-sync-view.overview')}}</a>
                    </li>
                    <li role="presentation" @if($state == 'traffic') class="active" @endif>
                        <a href="javascript:void(0)" ng-click="setLink({{$pageId}}, 'traffic')" aria-controls="task" role="tab" data-toggle="tab">{{trans('cms_page/page-sync/page-sync-view.traffic')}}</a>
                    </li>
                    {{-- <li role="presentation">
                        <a href="#task" aria-controls="task" role="tab" data-toggle="tab">Keywords</a>
                    </li>
                    <li role="presentation">
                        <a href="#task" aria-controls="task" role="tab" data-toggle="tab">Ranking</a>
                    </li>
                    <li role="presentation">
                        <a href="#task" aria-controls="task" role="tab" data-toggle="tab">Links</a>
                    </li> --}}
                </ul>

                <!-- Tab panes -->
                <div  class="col-lg-12 tab-content"  ng-init="seo={{json_encode($seoData)}}; pageOject = {{json_encode($pageObject)}}">
                    @if($state == 'overview')
                    @include('pages-sync.partial.overview')
                    @elseif($state == 'traffic')
                    @include('pages-sync.partial.traffic')
                    @endif
                   
                    
                </div>
                <div class="clearfix"></div>
                <!--   <div role="tabpanel" class="tab-pane padding-none col-lg-12" id="task">
                    <div>
                    df
                    </div>
                    </div> -->
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@stop
@section('script')
<script type="text/javascript">
    window.results   = {!!json_encode($results)!!};
</script>
<script type="text/javascript">
    $(window).load(function(){
        $(".seo #highcharts-28 svg .highcharts-tooltip text").attr("y","10");
    });
</script>
@if(!isProduction() && !isDev())
{!! Html::script('/app/components/pages-sync/pageTraficService.js?v='.getVersionScript())!!}
{!! Html::script('/app/components/pages-sync/pageTraficController.js?v='.getVersionScript())!!}
@else
<script src="{{ elixir('app/pages/page-sync-view.js') }}"></script>
@endif
<script type="text/javascript">
    // fix width chart
    $(".highcharts-container").addClass("fix-width-chart");    
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
            $('#container2').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'AVERAGE VISIT TIME'
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
                series: [{
                    showInLegend: false, 
                    data: [5, 3, 4, 7, 2]
                }]
            });
        });
    })
    
    (jQuery)
</script>
@stop