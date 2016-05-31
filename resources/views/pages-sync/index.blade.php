@extends('app')
@section('title')
	{{trans('cms_page/page-sync/page-sync-index.pages')}}
@stop
@section('content')
<div ng-controller="PageSyncController" data-ng-init="pages={{json_encode($pagesTree)}};">
	<div class="top-content">
	    <label class="c-m">{{trans('cms_page/page-sync/page-sync-index.pages')}}</label>
	    <a data-toggle="modal" href="javascript:void(0)" ng-disabled="isLoading" ng-click="syncPage()" class="btn btn-primary pull-right fix-btn-top-content">
	        <i class="fa fa-plus"></i> {{trans('cms_page/page-sync/page-sync-index.sync')}}
	    </a>
	</div>
	<div class="content margin-top-0 pages">
		<div id="resize-left" class="page-sync">
			<div data-toggle="tree" id="tree"></div>
		</div>
		<div class="table-sync" id="resize-right">
			<div class="table-responsive wrap-box-content">
				<div ng-show="isLoading" class="col-md-12 text-center form-group opti-sync-1">
					<i class="fa fa-spinner fa-pulse"></i>
				</div>
			   <table ng-show="!isLoading" class="table fix-height-tb table-striped" ng-table="tableParams" show-filter="false">
				    <tr ng-repeat="page in $data">
					    <td class="text-center" data-title="'Title'" sortable="'title'"><a href="/seo/pages/seo-page-report/@{{page.key}}">@{{page.title}}</a></td>
					    <td class="text-center" data-title="'URL'" sortable="'data.url'">@{{ page.data.url.replace("http://www.ulsinc.com", "")}}</td>
					    <td class="text-center" data-title="'Error'" sortable="'data.error'">@{{page.data.error}}</td>
					    <td class="text-center" data-title="'Warning'" sortable="'data.warning'">@{{page.data.warning}}</td>
					    <td class="text-center" data-title="'PageRank'" sortable="'data.pageRank'">@{{page.data.pageRank}}</td>
		            </tr>
			  	</table>
			</div>
		</div>
		<div id="sidebar-resizer" resizer="vertical" resizer-width="0" resizer-left="#resize-left" resizer-right="#resize-right" resizer-max="500" resizer-position-left="300"></div>
	</div>
</div>
@stop

@section('script')

	<script type="text/javascript">
		window.pagesTree = {!!json_encode($pagesTree)!!};
	</script>
	
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/shared/resizer/resizer.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/pages-sync/PageSyncService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/pages-sync/PageSyncController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/page-sync.js') }}"></script>
	@endif
@stop