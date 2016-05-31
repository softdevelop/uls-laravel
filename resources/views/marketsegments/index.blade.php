@extends('app')
@section('title')
	{{ trans('configuration/market-segments/index.market_segments') }}
@stop
@section('content')
<div class="wrap-branch" data-ng-controller="MarketSegmentController">
	<div class="top-content">
	    <label class="c-m">{{ trans('configuration/market-segments/index.breadcrum') }}
	    </label>
	    <a data-toggle="modal" href="javascript:void(0)" ng-click="createMarketSegment()" class="btn btn-primary fix-btn-top-content pull-right hidden-xs">
	        <i class="fa fa-plus"></i> {{ trans('configuration/market-segments/index.add_marketsegment') }}
	    </a>
	    <a data-toggle="modal" href="javascript:void(0)" ng-click="createMarketSegment()" class="btn btn-primary fix-btn-top-content pull-right visible-xs">
	        <i class="fa fa-plus"></i> {{ trans('configuration/market-segments/index.add') }}
	    </a>
	</div>
	<div class="content marketsements-manager">
		<div class="title-table">
		     <div class="table-responsive">         
		        <table class="table table-striped center-td" ng-table="tableParams" show-filter="isSearch">
			        <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
		                <i class="fa fa-search"></i>
		            </a>
		            <tbody>
			            <tr ng-repeat="marketSegment in $data">
				            <td class="text-center" data-title="'{{ trans('configuration/market-segments/index.name') }}'" filter="{ 'name': 'text' }" sortable="'name'">
				                @{{marketSegment.name}}
				            </td>
				            <td class="text-center" data-title="'{{ trans('configuration/market-segments/index.active') }}'" sortable="'active'">
				                <span ng-if="marketSegment.active == '1'" class="label label-success pointer">{{ trans('configuration/market-segments/index.active') }}</span>
				                <span ng-if="marketSegment.active == '0'" class="label label-danger pointer" >{{ trans('configuration/market-segments/index.inactive') }}</span>
				            </td>
				            <td class="text-center" data-title="'Action'">
				            	<a ng-click="createMarketSegment(marketSegment.id)" class="action-icon">
	                                <i class="ti-pencil"></i>
	                            </a>
								{{-- <button type="button" class="btn btn-warning glyphicon glyphicon-time" ng-click="MarketSegment()"></button> --}}
							</td>
				        </tr>
		            </tbody>
		        </table>
		      </div>
		</div>
	</div>
</div>

@stop
@section('script')

	<script>
		window.marketSegments = {!!json_encode($marketSegments)!!};
		window.baseUrl  = '{{URL::to("")}}';
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('app/components/marketsegments/MarketSegmentService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/marketsegments/MarketSegmentController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/marketsegment.js') }}"></script>
	@endif
@stop