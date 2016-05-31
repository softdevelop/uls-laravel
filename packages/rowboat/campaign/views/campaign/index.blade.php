<style type="text/css">
	.content-fix1{
	margin-top: 131px!important;
}
</style>
@extends('app')
@section('title')
	Campaign
@stop
@section('content')

<div class="roles-wrap wrap-branch" data-ng-controller="campaignCtrl">
	<div class="top-content">
	    <h3 class="c-m">Campaigns</h3>
	</div>
	<div class="content content-fix content-fix1">

		<div ng-show="isLoading || isLoadingChart" style="padding: 40px 0;" class="col-md-12 text-center form-group">
			<i style="position:absolute; top:155px; left:45%px; font-size:90px;z-index:999"  class="fa fa-refresh fa-spin"></i>
		</div>
		
		<div ng-show="!isLoading" id="container"></div>

		<div class="clearfix"></div>

		<form name="formSearchByDate" novalidate>
			<div class="tile-title">
				<!-- Input Date Available -->

				<div class="col-sm-12 col-md-5 col-lg-4 form-group">
				    <label class="control-label col-sm-3 col-md-5 col-lg-4 text-right padding-none" for="startDate">Start Date</label>
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
		            <div class="clearfix"></div>
				</div>
	            <!-- Input Date to-->

	            <div class="col-sm-12 col-md-5 col-lg-4 form-group">
	            	<label class="control-label col-sm-3 col-md-5 col-lg-4 text-right padding-none" for="endDate">End Date</label>
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
		                    <small class="help-inline" ng-show="submitted && formSearchByDate.endDate.$error.bigger" style="color:red">End date is bigger Start date.</small>
		                </div>  
		            </div>
		            <div class="clearfix"></div>
		        </div>
	            
	            <div class="search-day col-sm-12 col-md-2 col-lg-4 form-group">
	            	{{-- <button class="btn btn-default" ng-click="getChartModalCampaign(formSearchByDate.$invalid)"><i class="fa fa-spinner">Chart</i></button> --}}
	            	
	            	<button ng-disable="isLoading" class="btn btn-default" ng-click="getSearchModalCampaign(formSearchByDate.$invalid)">Search</button>	
	            </div>
			</div>
		</form>

		<div class="clearfix"></div>

		<div class="title-table table-responsive">
            <table ng-show="!isLoading" class="table table-bordered" ng-table="tableParams">
			 {{--    <thead style="background:#fafafa!important">
		      		<tr style="background: #F5F5F5; font-size:15px;">
				      	<th><i style="font-size:9px; color: #A5A5A5" class="fa fa-circle"></i></th>
				        <th style="text-align:left!important">Campaign</th>
		        		<th>Clicks</th>
		        		<th>Impressions</th>
		        		<th>CTR</th>
		        		<th>Conversions</th>
		        		<th>Conv.Rate</th>
		        		<th>CPA</th>
		        		<th>Avg. position</th>
			      	</tr>
			    </thead> --}}
			    <tbody> 
				    <tr ng-repeat="campaign in $data" >
				    	<td class="text-center"><i style="font-size:9px; color: #43B94C" class="fa fa-circle"></i></td>
		                <td sortable="'name'" data-title="'Name'" class="text-left"><a style="color:#004FFF" href="/campaign/report-group/@{{campaign['campaignId']}}" >@{{campaign['name']}}</a></td>
		                <td sortable="'Clicks'" data-title="'Clicks'" class="text-center">@{{campaign['Clicks']}}</td>
		                <td sortable="'Impressions'" data-title="'Impressions'" class="text-center">@{{campaign['Impressions']}}</td>
		                <td sortable="'CTR'" data-title="'CTR'" class="text-center">@{{campaign['CTR']}}%</td>
		                <td sortable="'Conversion'" data-title="'Conversions'" class="text-center">@{{campaign['Conversion']}}</td>
		                <td sortable="'AvgCPC'" data-title="'Conv.Rate'" class="text-center">@{{campaign['AvgCPC']}}%</td>
		                <td sortable="'CPA'" data-title="'CPA'" class="text-center">@{{campaign['CPA']}}</td>
		               
		                <td data-title="'Avgposition'" class="text-center">@{{campaign['Avgposition']}}</td>
					</tr>
		            <tr style="background: #E6E6E6;color:#000;font-weight:600">
		            	<td></td>
		                <td class="text-left">Total - Search</td>
		                <td class="text-center">@{{total['Clicks']}}</td>
		                <td class="text-center">@{{total['Impressions']}}</td>
		                <td class="text-center">@{{total['CTR']}}%</td>
		                <td class="text-center">@{{total['Conversion']}}</td>
		                <td class="text-center">@{{total['AvgCPC']}}%</td>
		                <td class="text-center">@{{total['CPA']}}</td>
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
		window.endDate 	 = {!!json_encode($endDate)!!};
		window.startDate = {!!json_encode($startDate)!!};
		window.campaigns = {!!json_encode($campaigns)!!};
		window.labels 	 = {!!json_encode($labels)!!};
		window.total 	 = {!!json_encode($total)!!};
		window.dateRange = {!!json_encode($dateRange)!!};
		window.dataReportChart = {!!json_encode($dataReportChart)!!};
	</script>
	
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/campaign/CampaignService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/campaign/CampaignController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/campaign-manager.js') }}"></script>
	@endif
@stop


