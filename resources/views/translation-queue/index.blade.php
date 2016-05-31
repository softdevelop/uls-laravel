@extends('app')
@section('title')
	{{ trans('configuration/translation-quece/index.translation_queue') }}
@endsection
@section('content')

<div class="wrap-branch" data-ng-controller="TranslateCtrl">
	<div class="top-content">
	    <label class="c-m">{{ trans('configuration/translation-quece/index.translation_queue_manager') }}
	    </label>
	</div>
	<div class="content">
		<div class="title-table">
		    <div class="table-responsive">
		        <table class="table table-hover fix-height-tb table-striped" ng-table="tableParams" show-filter="isSearch">
		            <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
		                <i class="fa fa-search"></i>
		            </a>
		            <tbody>
			            <tr ng-repeat="translation in $data">
			                <td class="text-center" data-title="'Page'" sortable="'parent_name'" filter="{ 'parent_name': 'text' }">
				                @{{translation.page.name}}
				            </td>
				            <td class="text-center" data-title="'Language'" sortable="'language'">
				                @{{translation.language.name}}
				            </td>
				            <td data-title="'Status'" sortable="'status'">
				                @{{translation.status}}
				            </td>
				            <td class="text-center" data-title="'Last Updated'" sortable="'last_updated'">
				                @{{translation.last_updated}} {{ trans('configuration/translation-quece/index.day_ago') }}
				            </td>
				            <td class="text-center" data-title="'Priority'" sortable="'priority'">
				                @{{translation.priority}}
				            </td>
				            <td class="text-center" data-title="'Action'">
				            	<a href="javascipt:void(0)" ng-click="editTranslation(translation.id, translation.page_id)" class="btn btn-primary btn-xs">
	                                <i class="fa fa-pencil"></i>
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
		window.translations = {!!json_encode($translations)!!};
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/translations/TranslationService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/translations/TranslationController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/translation.js') }}"></script>
	@endif
@stop

