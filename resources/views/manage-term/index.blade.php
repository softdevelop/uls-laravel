@extends('app')
@section('title')
	{{$termName}}
@stop
@section('content')
<style type="text/css">
  	#search {
  		width: 200px;	
  	}
</style>

<div class="wrap-branch" data-ng-controller="ManageTermController">
	<div class="top-content">
	    <!-- <label class="c-m">
	    </label>
	    <a href="" ng-click="getModalCreate(termId, item._id)" class="btn btn-primary fixed-add pull-right">
	    	<i class="fa fa-plus"></i> Create {{$termName}}
	    </a> -->
	    <label class="c-m"> Translation
	    </label>
	    <a href="" ng-click="getModalCreate(termId, item._id)" class="btn btn-primary fix-btn-top-content pull-right">
	    	<i class="fa fa-plus"></i> Create {{$termName}}
	    </a>
	</div>
	<div class="content content-type">
		<div class="title-table">
		    <div class="table-responsive">     
		     	<table class="table table-striped ">
	            	<thead>
						<tr>
							<th ng-repeat="title in fieldsName">@{{title.title}}</th>
							<th class="w200">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="item in data">
							<td ng-repeat="value in fieldsName" class="text-center">
			                	<span ng-if="value.element == 'select'&&value.isArray" ng-repeat="value1 in item[value.name] track by $index " >@{{dataOptionMap[value1]['name']}} @{{ $last ?'':',' }}</span>
			                	<span ng-if="value.element == 'select'&&!value.isArray">@{{dataOptionMap[item[value.name]]['name']}}</span>
			                	<span ng-if="value.element == 'date'">@{{item[value.name] | myDate}} </span>
				                <span ng-if="value.element != 'select' && value.element != 'date' && value.element != 'file'" ng-bind-html="item[value.name] | htmlize"></span>
								<a ng-if="value.element == 'file'" ng-href="javascript:void()" class="icon-f" title="files"><i class="fa fa-file-o"></i></a>
				            </td>

				            <td>
				            	<a class="btn btn-primary btn-xs" title="view detail" ng-href="/manage-term/@{{termId}}/content-type/@{{item._id}}/show-detail" ng-click="viewDetail(item,termId)"><i class="fa fa-eye"></i></a>
				            	<a class="btn btn-primary btn-xs" ng-click="getModalCreate(termId, item._id)"><i class="fa fa-pencil"></i></a>
				            	<a class="btn btn-primary btn-xs" ng-click="deleteItem(termId, item._id)"><i class="fa fa-times"></i></a>
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
		window.items = {!!json_encode($items)!!};
		window.termId = {!!json_encode($termId)!!};
		window.fieldsName = {!!json_encode($fieldsName)!!};
		// window.dataOptionMap = {!!json_encode(getDataOptionsMap())!!};
	</script>

	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/manage-term/ManageTermService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/manage-term/ManageTermController.js?v='.getVersionScript())!!}
		{!! Html::script('app/shared/form-builder-directive/formBuilderDirective.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/managerTerm.js') }}"></script>
		
	@endif

@stop