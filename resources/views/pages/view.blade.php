@extends('app')
@section('title')
    {{$pageData->name}}
@endsection
@section('content')
<div ng-controller="PageController" class="roles-wrap wrap-branch">
    <div class="top-content">
        <label class="c-m"><a href="{{ URL::to('cms/pages')}}">{{trans('cms_page/page-view.pages')}}</a> / {{$pageData->name}}</label>
    </div>
    <div class="content">
        <div class="title-table seo">
            <div class="col-lg-12 padding-none wrap-task-dashboard">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"class="active" >
                        <a href="javascript:void(0)" aria-controls="actions" role="tab" data-toggle="tab">{{trans('cms_page/page-view.overview')}}</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div  class="col-lg-12 tab-content">
                    @include('pages.partial.overview')
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
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
    <script>
        window.seo = {!! json_encode($pageData)!!}
    </script>

    @if(!isProduction() && !isDev())
        {!! Html::script('/app/components/pages/PageService.js?v='.getVersionScript())!!}
        {!! Html::script('/app/components/pages/PageControllerDetail.js?v='.getVersionScript())!!}
    @else
        <script src="{{ elixir('app/pages/page-detail.js') }}"></script>
    @endif

@endsection
