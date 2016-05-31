@extends('app')
@section('title')
	{{trans('cms_page/page-history.history')}}
@stop
@section('content')
<div class="wrap-branch wrap-content-management" data-ng-controller="HistoryController">
	<div class="top-content">
        <label class="c-m">

            <span class="wrap-breadcrumb">
                <span class="breadcrumb-level">
                    <a class="c-breadcrumb" title="@{{baseUrl}}/cms/pages" href="@{{baseUrl}}/cms/pages">{{trans('cms_page/page-history.cms_page_manager')}}&nbsp;</a>
                </span>

                @if(isset($breadcrumbData))
                    @foreach($breadcrumbData as $key => $value)
                        <a class="c-breadcrumb" href="@{{baseUrl}}/cms/pages/set-page-selected/{{$value['_id']}}" target="_self" >/&nbsp;{{$value['name']}}&nbsp;</a>
                    @endforeach
                @endif

                <span class="breadcrumb-level">
                    <span title="{{$page->name}}">/ {{$page->name}} / {{trans('cms_page/page-history.history')}}</span>
                </span>

            </span>
        </label>

    </div>
	<div class="content page-manager" ng-init="contentId={{json_encode($contentId)}}">
		 <!-- Nav tabs -->
        <ul ng-if="contentId!=''" class="nav nav-tabs fix-normal top-tab" role="tablist">
            <li>
            	@if($statusPage == 'live')
	                <a href="cms/pages/page-build/@{{contentId}}">
		                <i class="fa fa-list-alt"></i> {{trans('cms_page/page-edit-draft.page_build')}}
		            </a>
            	@else
	                <a href="cms/pages/edit-page/@{{contentId}}">
	                    <i class="fa fa-list-alt"></i> {{trans('cms_page/page-history.edit')}}
	                </a>
            	@endif
            </li>
            <li class="active">
                <a href="#History" role="tab" data-toggle="tab" ng-click="showValueContent()">
                    <i class="fa fa-file-code-o"></i> {{trans('cms_page/page-history.history')}}
                </a>
            </li>
            @if (\Auth::user()->can('manage_redirects'))
                <li>
                    <a href="/cms/pages/redirect/@{{contentId}}">
                        <i class="fa fa-file-code-o"></i> {{trans('cms_page/page-history.redirects')}}
                    </a>
                </li>
            @endif
        </ul>
        <div class="tab-content fix-tab">
            <div class="tab-pane fade" id="Edit">
			</div>
			<div class="tab-pane fade active in" id="History">
                <div class="title-table">
				     <div class="table-responsive">     
				        <table class="table fix-height-tb table-striped center-td" ng-table="tableParams" show-filter="isSearch">
					        <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
				                <i class="fa fa-search"></i>
				            </a>
				            <tbody>
					            <tr ng-repeat="item in $data">
						            <td class="text-center" data-title="'User'" filter="" sortable="'name'">
                                        <span ng-if="item.user_id == -1">
                                            {{trans('cms_page/page-history.system')}}
                                        </span>
                                        <span ng-if="item.user_id != -1">
    						                @{{users_map[item.user_id].first_name}} @{{users_map[item.user_id].last_name}}
                                        </span>
						            </td>
					                <td class="text-center"  data-title="'Action'" filter="{ 'action': 'text' }" sortable="'action'">
						                @{{item.action}}
						            </td>
						            <td class="text-center"  data-title="'Create at'" sortable="'created_at'">
						                @{{item.created_at | clientDate:'MM-dd-yyyy HH:mm:ss'}}
						            </td>
						            <td class="text-center"  data-title="'Update at'" sortable="'updated_at'">
						                @{{item.updated_at | clientDate:'MM-dd-yyyy HH:mm:ss'}}
						            </td>
						            <td class="show-action text-left" data-title="'Action'">
						                <div class="wrap-ac-group">
			                                <i class="fa fa-ellipsis-v"></i>
			                                <a href="javascript:void(0)" ng-click="showGroup($event)" class="ac-group btn"></a>
											<ul class="group-btn-ac">
												<a ng-if="item.action != 'Page deleted'" class="text-show-action" href="{{URL::to('cms/pages/history/view-draft/')}}/@{{item._id}}" target="_blank"> 
													<li> {{trans('cms_page/page-history.view_page_link')}}</li>
												</a>
												<a class="text-show-action" href="{{URL::to('support/show/')}}/@{{item.ticket_id}}" target="_blank"> 
													<li> {{trans('cms_page/page-history.view_ticket')}}</li>
												</a>
											</ul>
			                            </div>
						            </td>
					            </tr>
				            </tbody>
				        </table>
				      </div>
				</div>
            </div>
        </div>
	</div>
</div>

@stop
@section('script')
	<script>
		window.histories = {!!json_encode($histories)!!};
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/pages/HistoryService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/pages/HistoryController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/history.js') }}"></script>
	@endif

@stop