<style type="text/css">
	table.rb-table{
		border-collapse: collapse;
	}

	table.rb-table td{
	  padding:15px 30px;
	  border:1px solid #ccc;

	}
</style>
	{!!Html::style('bower_components/fontawesome/css/font-awesome.min.css?v='.getVersionCss())!!}
	{!! Html::style('css/demo-ulsinc.css?v='.getVersionCss())!!}
<div data-ng-app="uls"  data-ng-controller="ViewDraftController" class="label-demo">
	<div class="content-label-demo">
	
		<div id="wrap-box-toggle" class="wrap-working-draft space-20">
			
			<h2 class="">{{trans('cms_page/page-demo/page-demo-header-draft.working_draft')}}</h2>
			@if(!empty($contents->ticket))
				<div class="status">
					<span>{{trans('cms_page/page-demo/page-demo-header-draft.status')}}: {{ $states[$contents->ticket['status']] }}</span>
				</div>
			@endif

			<div class="list-btn">
				
			
				@if(!empty($contents->ticket))
					<div class="wrap-button">
						<a class="btn-top" href="{{urlViewTask()}}/support/show/{{$contents->ticket['id']}}">{{trans('cms_page/page-demo/page-demo-header-draft.view_task')}}</a>
					</div>
				@endif


				@if($contents->content_status == 'live')
				<div class="wrap-button">
					<a class="btn-top" href="{{\URL::to('/')}}/pages/request-revision/{{$contents->content_id}}">{{trans('cms_page/page-demo/page-demo-header-draft.request_revision')}}</a>
				</div>

				@endif
				 {{-- && \Auth::user()->can('create_new_page_ticket_admin') --}}
				@if(!empty($contents->ticket) && $contents->ticket['status'] == 'reviewed')

					<div class="wrap-button">
						<a class="btn-top pointer" ng-click="approve(contents.ticket.id)">{{trans('cms_page/page-demo/page-demo-header-draft.approve')}}</a>
					</div>

					<div class="wrap-button">
						<a class="btn-top pointer" ng-click="deny(contents.ticket.id)">{{trans('cms_page/page-demo/page-demo-header-draft.deny')}}</a>
					</div>
				@endif
				{{-- && \Auth::user()->can('create_new_page_ticket_assignee') --}}
				@if(!empty($contents->ticket) && $contents->ticket['status'] == 'assigned' )
					<div class="wrap-button">
						<a class="btn-top pointer" ng-click="requestReview (contents.ticket.id)">{{trans('cms_page/page-demo/page-demo-header-draft.request_review')}} </a>
					</div>

				@endif

			</div>

			<div class="navbar-toggle">
				<a href="javascript:void()">
					<span class="fa fa-align-right"></span>
				</a>
			</div>

		</div>

		<div class="wrap-toogle-button-action disappear">
			<div class="list-btn">
				
			
				@if(!empty($contents->ticket))
					<div class="wrap-button">
						<a class="btn-top" href="{{urlViewTask()}}/support/show/{{$contents->ticket['id']}}">View Task</a>
					</div>
				@endif

				@if($contents->content_status == 'live')
				<div class="wrap-button">
					<a class="btn-top" href="{{\URL::to('/')}}/pages/request-revision/{{$contents->content_id}}">Request Revision</a>
				</div>

				@endif
				{{-- && \Auth::user()->can('create_new_page_ticket_admin') --}}
				@if(!empty($contents->ticket) && $contents->ticket['status'] == 'reviewed')

					<div class="wrap-button">
						<a class="btn-top pointer" ng-click="approve(contents.ticket.id)">Approve</a>
					</div>

					<div class="wrap-button">
						<a class="btn-top pointer" ng-click="deny(contents.ticket.id)">Deny</a>
					</div>
				@endif
				 {{-- && \Auth::user()->can('create_new_page_ticket_assignee') --}}
				@if(!empty($contents->ticket) && $contents->ticket['status'] == 'assigned')
					<div class="wrap-button">
						<a class="btn-top pointer" ng-click="requestReview (contents.ticket.id)">Request Review </a>
					</div>

				@endif

			</div>
			<div class="clearfix"></div>
		</div>

	</div>
	<a class="btn-close toggle" id="check-close">
		<span class="icon-toogle"></span>
	</a>
	
</div>
	


@section('script')
	<script type="text/javascript">
		window.urlViewTask = {!!json_encode(urlViewTask())!!}
	</script>
	{!! Html::script('app/components/pages/ViewDraftService.js?v='.getVersionScript())!!}
	{!! Html::script('app/components/pages/ViewDraftController.js?v='.getVersionScript())!!}
@stop
@include('shared.script-tpl')
