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

<div data-ng-app="uls" data-ng-controller="ViewDraftController" class="label-demo">
	@if(!empty($contents->version))

	<div class="content-label-demo">
		<div id="wrap-box-toggle" class="wrap-working-draft space-20">
			<h2>{{trans('cms_page/page-demo/page-demo-header-revision.archived_page')}}</h2>
			<div class="status revision">
				<span class="c-insipid">{{trans('cms_page/page-demo/page-demo-header-revision.status')}}:</span>  <span>{{trans('cms_page/page-demo/page-demo-header-revision.replaced')}}</span>
				<p >
				<span class="c-insipid">{{trans('cms_page/page-demo/page-demo-header-revision.page_active')}}:</span>

				<span>{{$contents->startDate}} {{trans('cms_page/page-demo/page-demo-header-revision.to')}} {{$contents->dueDate}}</span>
				</p>
			</div>

			<ul class="list-btn">

				@if(!empty($contents->version))
					@if(!empty($contents->revisions[$contents->version-1]))
					<li class="ds-inline">
						<a ng-click="preRevisions()" class="size-26 sub-display" href="javascript:void(0)" >
							<i class="fa fa-arrow-circle-o-left"></i>
						</a>
					</li>
					@endif

					<li class="ds-inline">{{trans('cms_page/page-demo/page-demo-header-revision.revision')}} {{$contents->version}}</li>

					@if(!empty($contents->revisions[$contents->version+1]))

					<li class="ds-inline">
						<a ng-click="nextRevisions()" class="size-26 sub-display" href="javascript:void(0)">
							<i class="fa fa-arrow-circle-o-right "></i>
						</a>
					</li>
					@endif
				@else
				<li class="ds-inline">
					<a class="btn-top" href="{{\URL::to('/')}}/pages/request-revision/{{$contents->content_id}}">{{trans('cms_page/page-demo/page-demo-header-revision.request_revision')}}</a>
				</li>
				@endif
				<div class="clearfix"></div>
			</ul>

			<div class="navbar-toggle">
				<a href="">
					<span class="fa fa-align-right"></span>
				</a>
			</div>
		</div>

		<div class="wrap-toogle-button-action disappear">
			<ul class="list-btn">

				@if(!empty($contents->version))
					@if(!empty($contents->revisions[$contents->version-1]))
					<li class="ds-inline">
						<a ng-click="preRevisions()" class="size-26 sub-display" href="javascript:void(0)" >
							<i class="fa fa-arrow-circle-o-left"></i>
						</a>
					</li>

					@endif
					<li class="ds-inline">{{trans('cms_page/page-demo/page-demo-header-revision.revision')}} {{$contents->version}}</li>

					@if(!empty($contents->revisions[$contents->version+1]))

					<li class="ds-inline">
						<a ng-click="nextRevisions()" class="size-26 sub-display" href="javascript:void(0)">
							<i class="fa fa-arrow-circle-o-right "></i>
						</a>
					</li>
					@endif
				@else
				<li class="ds-inline">
					<a class="btn-top" href="{{\URL::to('/')}}/pages/request-revision/{{$contents->content_id}}">{{trans('cms_page/page-demo/page-demo-header-revision.request_revision')}}</a>
				</li>
				@endif
				<div class="clearfix"></div>
			</ul>
			<div class="clearfix"></div>
		</div>
	</div>

	<a class="btn-close toggle" id="check-close">
		<span class="icon-toogle"></span>
	</a>
	@endif
</div>
@include('shared.script-tpl')
@section('script')

	{!! Html::script('app/components/pages/ViewDraftService.js?v='.getVersionScript())!!}
	{!! Html::script('app/components/pages/ViewDraftController.js?v='.getVersionScript())!!}

@stop
