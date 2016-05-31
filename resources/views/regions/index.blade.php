@extends('app')
@section('title')
	{{ trans('configuration/region/region-index.breadcrum') }}
@stop
@section('content')

<div class="wrap-branch" data-ng-controller="RegionController">
	<div class="top-content">
	    <label class="c-m">{{ trans('configuration/region/region-index.breadcrum') }}
	    </label>
	    <a data-toggle="modal" href="javascript:void(0)" ng-click="getModalCreateRegion()" class="btn btn-primary pull-right fix-btn-top-content">
	        <i class="fa fa-plus"></i> {{ trans('configuration/region/region-index.add_region') }}
	    </a>
	</div>
	<div class="content regions" ng-init="languages_map = {{json_encode($languages_list)}}">
		<div class="title-table">
		     <div class="table-responsive">
		        <table class="table fix-height-tb table-striped" ng-table="tableParams" show-filter="isSearch">
			        <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
		                <i class="fa fa-search"></i>
		            </a>
		            <tbody>
			            <tr ng-repeat="region in $data">
							<td data-title="'{{ trans('configuration/region/region-index.country_name') }}'" sortable="'name'" filter="{ 'name': 'text' }">@{{region.name}}</td>
							<td data-title="'{{ trans('configuration/region/region-index.code') }}'">@{{region.code}}</td>
							<td data-title="'{{ trans('configuration/region/region-index.languages') }}'">
								<span ng-repeat="language in region.languages track by $index">
									@{{language.code}}
									<span ng-show="$index+1 != region.languages.length">,</span>
								</span>

							</td>
							{{-- <td data-title="'Active'">@{{region.active}}</td> --}}
							<td data-title="'{{ trans('configuration/region/region-index.active') }}'" sortable="'active'">
				                <span ng-if="region.active == '1'" class="label label-success pointer">{{ trans('configuration/region/region-index.active') }}</span>
				                <span ng-if="region.active == '0'" class="label label-danger pointer" >{{ trans('configuration/region/region-index.inactive') }}</span>
				            </td>

							<td data-title="'Action'">
								<a ng-click="getModalCreateRegion(region.id)" class="action-icon">
	                                <i class="ti-pencil"></i>
	                            </a>
								{{-- <button type="button" class="btn btn-success" ng-click="historyRegion(region._id)">History</button> --}}
								{{-- <a ng-click="deleteRegion(region.id)" class="">
	                                <i class="fa fa-trash-o"></i>
	                            </a> --}}
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
		window.regions = {!!json_encode($regions)!!};
		window.baseUrl  = '{{URL::to("")}}';
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('app/components/regions/RegionService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/regions/RegionController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/languages/LanguageService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/languages/LanguageController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/region.js') }}"></script>
	@endif
@stop
