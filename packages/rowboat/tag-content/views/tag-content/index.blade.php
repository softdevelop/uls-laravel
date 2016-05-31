@extends('app')
@section('title')
	Tag Content Management
@endsection
@section('content')
	<div class="wrap-branch" data-ng-controller="TagContentController as tagcontent">
		<div class="top-content">
		    <h3 class="c-m">Tag Content Management
			      <a data-toggle="modal" href="javascript:void(0)" ng-click="getModalTagContent()" class="btn btn-primary fixed-add pull-right">
			        <i class="fa fa-plus"></i> Tag Content
			      </a>
		    </h3>
		</div>
		<div class="content language-manager">
			<div class="title-table">
			     <div class="table-responsive">
			        <table class="table fix-height-tb table-striped" ng-table="tableParams" show-filter="isSearch">
				        <a class="fixed-search" href="javascript:void(0)" ng-click="tagcontent.isSearch = !tagcontent.isSearch">
			                <i class="fa fa-search"></i>
			            </a>
			            <tbody>
				            <tr  ng-repeat="tagContent in $data">
				                <td data-title="Name" filter="{ 'name': 'text' }" sortable="'name'">
					                @{{tagContent.name}}
					            </td>
					            <td data-title="color" filter="{ 'color': 'text' }" sortable="'color'">
					                @{{tagContent.color}}
					            </td>
					            <td data-title="Action">
					            	<a ng-click="getModalTagContent(tagContent._id)" class="action-icon">
		                                <i class="ti-pencil"></i>
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
		window.tagsContent = {!! json_encode($tagsContent) !!};
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('app/components/tag-content/TagContentService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/tag-content/TagContentController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/tag-content/TagContent.js') }}"></script>
	@endif

@stop

