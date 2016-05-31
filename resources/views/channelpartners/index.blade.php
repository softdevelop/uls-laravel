@extends('app')

@section('title')
	{{ trans('configuration/channel-partners/index.channel_partner_manager') }}
@stop

@section('content')
<div class="wrap-branch" data-ng-controller="ChannelPartnersController">
	<div class="top-content">
	    <label class="c-m">{{ trans('configuration/channel-partners/index.channel_partner_manager') }}
	    </label>
	    <a data-toggle="modal" href="javascript:void(0)" ng-click="getModalChannelPartners()" class="btn btn-primary pull-right fix-btn-top-content">
		    <i class="fa fa-plus"></i> {{ trans('configuration/channel-partners/index.channel_partner') }}
		</a>
	</div>
	<div class="content channelpartners">
		<div class="title-table">
		     <div class="table-responsive">
		        <table class="table fix-height-tb table-striped center-td" ng-table="tableParams" show-filter="isSearch">
			        <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
		                <i class="fa fa-search"></i>
		            </a>
		            <tbody>
			            <tr ng-repeat="partner in $data">
								<td data-title="'Name'" sortable="'name'" filter="{ 'name': 'text' }">@{{partner.name}}</td>
								<td data-title="'Address'" sortable="'address'">
									<span>@{{partner.address}}</span>
									<span ng-if="partner.suite != 'null'">, @{{partner.suite}}</span> <br/>
									<span>&nbsp;@{{partner.city}}</span>
									<span>&nbsp;@{{partner.zipcode}}</span>

								</td>
								<td data-title="'Telephone Number'" sortable="'telephone'" >@{{partner.telephone}}</td>
								<td data-title="'Email Address'" sortable="'email'" >@{{partner.email}}</td>
								<td data-title="'Country'" sortable="'country'">@{{partner.region['name']}}</td>								
								<td data-title="'Action'">
									<a href="javascipt:void(0)" ng-click="getModalChannelPartners(partner.id)" class="action-icon">
		                                <i class="ti-pencil"></i>
		                            </a>
		                            <a href="javascipt:void(0)" ng-click="deletePartner(partner.id)" class="action-icon">
		                                <i class="fa fa-trash-o"></i>
		                            </a>
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
		window.baseUrl  = '{{URL::to("")}}';
		window.partners = {!!json_encode($partners)!!};
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/channelpartners/ChannelPartnersService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/channelpartners/ChannelPartnersController.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/channelpartners/ChannelPartnersDirective.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/partner.js') }}"></script>
	@endif
@stop