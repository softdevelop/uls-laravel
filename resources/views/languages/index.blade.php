@extends('app')
@section('title')
	{{ trans('configuration/language/language-index.languages') }}
@stop
@section('content')
<div class="wrap-branch" data-ng-controller="LanguageControler">
	<div class="top-content">
	    <label class="c-m">{{ trans('configuration/language/language-index.breadcrum') }}
	    </label>
	    <a data-toggle="modal" href="javascript:void(0)" ng-click="getModalLanguage()" class="btn btn-primary pull-right fix-btn-top-content">
	        <i class="fa fa-plus"></i> {{ trans('configuration/language/language-index.add_language') }}
        </a>
	</div>
	<div class="content language-manager">
		<div class="title-table">
		     <div class="table-responsive">         
		        <table class="table fix-height-tb table-striped" ng-table="tableParams" show-filter="isSearch">
			        <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
		                <i class="fa fa-search"></i>
		            </a>
		            <tbody>
			            <tr  ng-repeat="language in $data">
			                <td data-title="'{{ trans('configuration/language/language-index.language') }}'" filter="{ 'name': 'text' }" sortable="'name'">
				                @{{language.name}}
				            </td>
				            <td data-title="'{{ trans('configuration/language/language-index.native_name') }}'" filter="{ 'native_name': 'text' }" sortable="'native_name'">
				                @{{language.native_name}}
				            </td>
				            <td data-title="'{{ trans('configuration/language/language-index.code') }}'" filter="{ 'code': 'text' }" sortable="'code'">
				                @{{language.code}}
				            </td>
				            <td data-title="'{{ trans('configuration/language/language-index.direction') }}'" filter="{ 'direction': 'text' }" sortable="'direction'">
				                @{{language.direction}}
				            </td>
				            <td data-title="'{{ trans('configuration/language/language-index.active') }}'" sortable="'active'">
				                <span ng-if="language.active == '1'" class="label label-success pointer">{{ trans('configuration/language/language-index.active') }}</span>
				                <span ng-if="language.active == '0'" class="label label-danger pointer" >{{ trans('configuration/language/language-index.inactive') }}</span>
				            </td>
				            <td data-title="'{{ trans('configuration/language/language-index.action') }}'">
				            	<a ng-click="getModalLanguage(language.id)" class="action-icon">
	                                <i class="ti-pencil"></i>
	                            </a>
	                            {{-- <a ng-click="removeLanguage(language.id)" class="action-icon">
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
		window.baseUrl   = '{{URL::to("")}}';
		window.languages = {!!json_encode($languages)!!};
	</script>
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/languages/LanguageService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/languages/LanguageController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/language.js') }}"></script>
	@endif

@stop