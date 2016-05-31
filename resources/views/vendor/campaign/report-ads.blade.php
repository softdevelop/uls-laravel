@extends('app')
@section('title')
	Campaign
@stop
@section('content')

<div class="roles-wrap wrap-branch" data-ng-controller="campaignDetailCtrl" >
	<div class="top-content">
	    <label class="c-m">
		    <a class="c-fff" href="{{ URL::to('campaign')}}">Campaigns</a> >
		    <a class="c-fff" href="{{ URL::to('campaign/report-group')}}/{{$campaignId}}">{{$campaignName}}</a>
		    > {{$groupName}}
	    </label>
	</div>
	<div class="content content-fix">

		<select class="col-lg-5 col-md-5" name="typeFilterFirst" ng-model="firstSelect.typeFilterFirst" ng-change="filterFirstSelect(firstSelect.typeFilterFirst)" ng-init="firstSelect.typeFilterFirst = 0; filterFirstSelect(0)">
            <option value="0">Clicks</option>
            <option value="1">Impressions</option>
            <option value="2">Conversions</option>
            <option value="3">CTR</option>
            <option value="4">Conv. Rate</option>
            <option value="5">CPA</option>
            <option value="6">Avg. Position</option>
        </select>
        <span class="col-lg-2 col-md-2 space-vertical text-center">vs.</span>
        <select class="col-lg-5 col-md-5" name="typeFilterSecond" ng-model="secondSelect.typeFilterSecond" ng-change="filterSecondSelect(secondSelect.typeFilterSecond)" ng-init="secondSelect.typeFilterSecond = 1; filterSecondSelect(1)">
            <option value="0">Clicks</option>
            <option value="1">Impressions</option>
            <option value="2">Conversions</option>
            <option value="3">CTR</option>
            <option value="4">Conv. Rate</option>
            <option value="5">CPA</option>
            <option value="6">Avg. Position</option>
        </select>
        <div class="clearfix"></div>

        <div ng-show="isLoading || isLoadingChart" id="page-loading" class="overlay-loading">
		  <div class="spin-box"></div>
		</div>
		
		<div class="form-group" ng-show="!isLoading" id="container"></div>
		
		<div class="clearfix"></div>

		<form name="formSearchByDate" novalidate>
			<div class="tile-title">
				<!-- Input Date Available -->
				<div class="col-sm-12 col-md-5 col-lg-4 form-group">
		            <label class="control-label col-sm-3 col-md-5 col-lg-4 text-right padding-none f700" for="startDate">Start Date</label>
		            <div class="control col-sm-9 col-md-7 col-lg-8 padding-none" ng-class="{true: 'error'}[submitted && formSearchByDate.startDate.$invalid]">
		                <input  type="text" class="form-control" name="startDate"
		                        datepicker-popup="@{{format}}" 
		                        ng-model="campaign.startDate" 
		                        is-open="opened['startDate']" 
		                        date-disabled="disabled(date, mode)" 
		                        ng-click="open($event, 'startDate')" 
		                        ng-required="true" 
		                        close-text="close" />   
		                <div class="pull-right">
		                    <small class="help-inline" ng-show="submitted && formSearchByDate.startDate.$error.required">Start date is required.</small>
		                </div>   
		            </div>
		        </div>

	            <!-- Input Date to-->
	            <div class="col-sm-12 col-md-5 col-lg-4 form-group">
		            <label class="control-label col-sm-3 col-md-5 col-lg-4 text-right padding-none f700" for="endDate">End Date</label>
		            <div class="control col-sm-9 col-md-7 col-lg-8 padding-none" ng-class="{true: 'error'}[submitted && formSearchByDate.endDate.$invalid]">
		                <input  type="text" class="form-control" name="endDate"
		                        datepicker-popup="@{{format}}" 
		                        ng-model="campaign.endDate" 
		                        is-open="opened['endDate']" 
		                        date-disabled="disabled(date, mode)" 
		                        ng-click="open($event, 'endDate')"
		                        ng-required="true" 
		                        close-text="close" />
		                <div class="pull-right">
		                    <small class="help-inline" ng-show="submitted && formSearchByDate.endDate.$error.required">End date is required.</small>
		                    <small class="help-inline" ng-show="submitted && formSearchByDate.endDate.$error.bigger">End date is bigger Start date.</small>
		                </div>  
		            </div>
	            </div>
	            <div class="search-day col-sm-12 col-md-2 col-lg-4 form-group">
	            	<button ng-disable="isLoading" class="btn btn-primary" ng-click="getSearchModalAds('search-report-ads', formSearchByDate.$invalid)">Search</button>
	            </div>
			</div>
		</form>

		<div class="clearfix"></div>

		<div class="title-table table-responsive">
            <table ng-show="!isLoading" class="table table-bordered report-campaign center-td" ng-table="tableParams">
			    <tbody>
				    <tr ng-repeat="campaign in $data">
					    <td class="text-center icon"><i class="fa fa-circle"></i></td>
					    <td sortable="'name'" data-title="'Name'" class="text-center name">@{{campaign['name']}}</td>
		                <td sortable="'Clicks'" data-title="'Clicks'" class="text-center">@{{campaign['Clicks']}}</td>
		                <td sortable="'Impressions'" data-title="'Impressions'" class="text-center">@{{campaign['Impressions']}}</td>
		                <td sortable="'CTR'" data-title="'CTR'" class="text-center">@{{campaign['CTR']}}%</td>
		                <td sortable="'AvgCPC'" data-title="'Conv.Rate'" class="text-center">@{{campaign['AvgCPC']}}%</td>
		                <td sortable="'CPA'" data-title="'CPA'" class="text-center">@{{campaign['CPA']}}</td>
		                <td sortable="'Conversions'" data-title="'Conversions'" class="text-center">@{{campaign['Conversions']}}</td>
		                <td sortable="'Avgposition'" data-title="'Avg. Position'" class="text-center">@{{campaign['Avgposition']}}</td>
		            </tr>
		
					<tr class="total">
						<td colspan="2">Total - Search</td>
					 	<td class="text-center">@{{total['Clicks']}}</td>
		                <td class="text-center">@{{total['Impressions']}}</td>
		                <td class="text-center">@{{total['CTR']}}%</td>
		                <td class="text-center">@{{total['AvgCPC']}}%</td>
		                <td class="text-center">@{{total['CPA']}}</td>
		                <td class="text-center">@{{total['Conversions']}}</td>
		                <td class="text-center">@{{total['Avgposition']}}</td>
					</tr>
			    </tbody>

		  	</table>
		  	<div class="clearfix"></div>
		</div>
	</div>
</div>
@stop
@section('script')
	<script type="text/javascript">
		window.endDate 	  = {!!json_encode($endDate)!!};
		window.startDate  = {!!json_encode($startDate)!!};
		window.campaigns  = {!!json_encode($campaigns)!!};
		window.labels 	  = {!!json_encode($labels)!!};
		window.total 	  = {!!json_encode($total)!!};
		window.groupId 	  = {!!json_encode($groupId)!!};
		window.dateRange  = {!!json_encode($dateRange)!!};
		window.dataReportChart = {!!json_encode($dataReportChart)!!};
	</script>
	

	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/campaign/CampaignDetailService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/campaign/CampaignDetailController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/campaign-manager-detail.js') }}"></script>
	@endif
@stop
