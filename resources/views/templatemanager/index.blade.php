@extends('app')
@section('title')
	Content Management
@stop
@section('content')
<div class="roles-wrap wrap-branch" data-ng-controller="TemplateManagerController">
	<div class="top-content">
	    <label class="c-m">CMS Template Manager
		      <!-- <a data-toggle="modal" href="/template-manager/create" class="btn btn-primary fixed-add pull-right">
		        <i class="fa fa-plus"></i> Add Template
		      </a> -->
	    </label>
	    <a data-toggle="modal" href="/template-manager/create" class="btn btn-primary fix-btn-top-content pull-right">
	        <i class="fa fa-plus"></i> Add Template
	     </a>
	</div>
	<div class="content">
		<div class="title-table">
		     <div class="table-responsive">
		        <table class="table fix-height-tb table-striped" ng-table="tableParams" show-filter="isSearch">
			        <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
		                <i class="fa fa-search"></i>
		            </a>
		            <tbody>
			            <tr ng-repeat="template in $data">
							<td class="text-center cursor-initial" data-title="'Name'" sortable="'name'" filter="{ 'name': 'text' }">@{{template.name}}</td>
							<td class="text-center cursor-initial" ng-bind-html="template.description | htmlize" data-title="'Description'"></td>
							<td class="text-center cursor-initial" data-title="'Sections'">
								<span ng-repeat="section in template.sections track by $index">
									@{{section.name}}
									<span ng-if="$index < template.sections.length-1">,</span>
								</span>
							</td>
							<td class="text-center cursor-initial" data-title="'Thumbnail'">
								<span ng-if="template.thumbnail != ''"><img style="height: 50px;width: 50px;" ng-src="uploads\templates\@{{template.thumbnail}} " alt="" ng-click="viewImage(template.thumbnail)"> &nbsp;</span>
							</td>

							<td class="text-center cursor-initial" data-title="'Action'">
								<a ng-href="/template-manager/@{{template._id}}/edit" class="action-icon">
	                                <i class="ti-pencil"></i>
	                            </a>
	                            <a ng-click="deleteTemplate(template._id)" class="action-icon">
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
		window.templates = {!!json_encode($templates)!!};
		window.baseUrl  = '{{URL::to("")}}';
	</script>

	  {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}
	  {!! Html::script('bower_components/ng-file-upload/ng-file-upload.min.js')!!}
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/templatemanager/TemplateManagerService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/templatemanager/TemplateManagerController.js?v='.getVersionScript())!!}
		{!! Html::script('app/shared/tag-content-directive/tagContentDirective.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/template.js') }}"></script>
	@endif

@stop

