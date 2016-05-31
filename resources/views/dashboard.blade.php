@extends('app')
@section('title')
{{trans('dashboard/dashboard.webTitle')}}
@stop
@section('content')

<div class="wrap-branch dashboard">
    <div class="top-content">
        <label class="c-m">{{trans('dashboard/dashboard.breadCrumb')}}</label>
    </div>
    <div class="content dashboard st-container" ng-controller="dashboardController">
        <div ui-sortable="sortableOptions" ng-model="userDashboardViews">
            <div class="panel-group" ng-repeat="userDashboardView in userDashboardViews">    
                <div ng-include="userDashboardView.file_name"></div>
            </div>
        </div>
    </div>

    

</div>

@endsection
@section('script')
{!! Html::script('app/lib/google-chart/google-chart.js')!!}
<script type="text/ng-template" id="page-overview">
    @include('dashboard.partials.page-overview')
</script>
<script type="text/ng-template" id="traffic-overview">
    @include('dashboard.partials.traffic-overview')
</script>
<script type="text/ng-template" id="ticket-overview">
    @include('dashboard.partials.ticket-overview')
</script>
<script type="text/ng-template" id="task-overview">
    @include('dashboard.partials.task-overview')
</script>
<script>
    window.pageOverview = {!! json_encode($pageOverview) !!};
    window.ticketTypes = {!! json_encode($ticketTypes) !!};
    
    window.tickets_new = {!!json_encode($tickets_new)!!};
    window.tickets_allopen = {!!json_encode($tickets_allopen)!!};
    window.states = {!!json_encode($states)!!};
    window.userDashboardViews = {!!json_encode($userDashboardViews)!!};
</script>
@if(!isProduction() && !isDev())
{!! Html::script('app/components/dashboard/google-chart.js?v='.getVersionScript())!!}
{!! Html::script('app/components/dashboard/dashboardController.js?v='.getVersionScript())!!}
{!! Html::script('app/components/dashboard/dashboardService.js?v='.getVersionScript())!!}
@else
<script src="{{ elixir('app/pages/dashboard.js') }}"></script>
@endif
@stop