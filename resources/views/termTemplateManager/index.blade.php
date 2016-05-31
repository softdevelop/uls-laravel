@extends('app')
@section('title')
	Template Manager
@stop
@section('content')
<div class="roles-wrap wrap-branch" data-ng-controller="TermTemplateManagerController">
	<div class="top-content">
	    <label class="c-m"> Template Term Manager</label>
	    <a data-toggle="modal" href="/admin/terms/@{{termId}}/template-manager/create" class="btn btn-primary fix-btn-top-content pull-right">
	        <i class="fa fa-plus"></i> Add Template
	    </a>
	</div>
	<div class="content">
		<div class="title-table">
		     <div class="table-responsive">
		        <table class="table table-hover fix-height-tb table-striped" ng-table="tableParams" show-filter="isSearch">
			        <a class="fixed-search" href="javascript:void(0)" ng-click="isSearch = !isSearch">
		                <i class="fa fa-search"></i>
		            </a>
		            <tbody>
			            <tr ng-repeat="template in $data">
							<td class="text-center cursor-initial" data-title="'Name'" sortable="'name'" filter="{ 'name': 'text' }">@{{template.name}}</td>
							
							<td class="text-center cursor-initial" data-title="'Type'">@{{templateType[template.type]}}</td>
							
							<td class="text-center cursor-initial" data-title="'Description'">@{{template.description}}</td>
							
							<td class="text-center cursor-initial" data-title="'Thumbnail'">
								<span ng-if="template.thumbnail != ''"><img style="height: 50px;width: 50px;" ng-src="\uploads\term-templates\@{{template.thumbnail}} " alt="" ng-click="viewImage(template.thumbnail)"> &nbsp;</span>
							</td>
							
							<td class="text-center cursor-initial" data-title="'Action'">
								<a ng-href="/admin/terms/@{{template.termId}}/template-manager/@{{template._id}}/edit" class="action-icon">
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
		window.templates = {!!json_encode($templates)!!}
		window.templateType = {!!json_encode($templateType)!!}
		window.termId = {!!json_encode($termId)!!}
	</script>
		{!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}
		{!! Html::script('bower_components/ng-file-upload/ng-file-upload.min.js')!!}
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/termTemplateManager/TermTemplateManagerService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/termTemplateManager/TermTemplateManagerController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/termTemplate.js') }}"></script>
	@endif
	
@stop

