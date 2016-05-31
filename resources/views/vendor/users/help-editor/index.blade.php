@extends('app')
@section('title')
	Help Editor
@stop
@section('content')
<div ng-controller="HelpEditorController" ng-init="initTree();" class="wrap-content-management">
	<div class="top-content">
	    <label class="c-m">Help Editor</label>

		<a class="btn btn-primary hidden-xs pull-right fix-btn-top-content" ng-click="showModelCreateTopic()">
   			<i class="fa fa-plus"></i> Add Topic
  		</a>
		<a href="#" class="btn btn-primary hidden-xs pull-right fix-btn-top-content" ng-click="addPage()">
	   		<i class="fa fa-plus"></i> Add Page
	  	</a>
	</div>
	
		<div class="visible-xs group-action-mobile">
		<div class="btn-show-group" data-toggle="collapse" data-target="#group-btn" aria-expanded="false">
			<i class="fa fa-plus"></i>
		</div>

		<div class="wrap-btn-create-circle collapse" id="group-btn">
			<div class="btn-create-circle" title="Add Topic">
				<a  ng-click="showModelCreateTopic()" href="javascript:void(0)" href=""><i class="fa fa-plus"></i></a>
			</div>

			<div class="btn-create-circle" title="Add Page">
				<a  ng-click="addPage()" href="javascript:void(0)" href=""><i class="fa fa-file-text-o"></i></a>
			</div>

			<!-- <div class="btn-create-circle" title="Delete">
				<a  ng-click="deleteHelpEditor()" href="javascript:void(0)" href=""><i class="fa fa-trash-o"></i></a>
			</div>
			<div class="btn-create-circle" title="Edit Details">
				<a data-toggle="modal" href="javascript:void(0)" ng-model="files" ng-click="editDetail()" href=""><i class="fa fa-pencil"></i></a>
			</div>
			<div class="btn-create-circle" title="Save">
				<a data-toggle="modal" href="javascript:void(0)" ng-click="updateHelp()" href=""><i class="fa fa-floppy-o"></i></a>
			</div> -->
		</div>
	</div>


	<div class="content margin-top-0">
		<div id="resize-left" >
			<div data-toggle="tree" id="tree"></div>
		</div>
		
		<div id="resize-right" class="fix-td-tb" >
			<div ng-if="error" class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				Can not delete this help.
			</div>
			<div ng-if="success" class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				You are saved success.
			</div>
			<div ng-if="errorMessage" class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				@{{errorMessage}}
			</div>
			<div ng-if="showEditor">
				<div class="p-b-6">

					<a href="#" class="btn btn-sm btn-default pull-right btn-mobile" ng-click="deleteHelpEditor()">
						<i class="fa fa-times" ></i> Delete
					</a>

					<a href="#" class="btn btn-sm btn-default pull-right btn-mobile m-r-10" ng-click="editDetail()">
						<i class="fa fa-pencil" ></i> Edit Details
					</a>

					<a href="#" class="btn btn-sm btn-default pull-right btn-mobile m-r-10" ng-click="updateHelp()">
						<i class="fa fa-check" ></i> Save
					</a>
					<div class="clearfix"></div>
				</div>
				
			</div>
			
			<div class="table-responsive table-animate" ng-if="showEditor">
				<div class="p-20">
					<div class="form-group" ng-if="isShowPage || isShowTopic">
			            <label ng-if="isShowPage"><strong>Page name<span class="text-require"> *</span></strong></label>
			            <label ng-if="isShowTopic"><strong>Topic name<span class="text-require"> *</span></strong></label>
			            <div ng-class="{'has-error': submitted && formData.name.$invalid }">
			                <input type="text" ng-change="setIsNotSaved()" id="page-name" name="name" ng-model="helpEditor.name"></input>
			            </div>
			            <span class="control-label span-error ng-hide" ng-show="submitted && !isRequiredRedactor">Name is a required field</span>
			        </div>
			        <div class="form-group" ng-show="isShowTopic">
			            <label><strong>Page type<span class="text-require"> *</span></strong></label>
			            <div ng-class="{'has-error': submitted && formData.notes.$invalid }">
			                <select class="form-control" 
			                		ng-options="item._id as item.title for item in rootHelps | orderBy:'title'" 
			                		ng-model="helpEditor.parent_id" 
			                		ng-change="changePageType()">
			                		<option value="">Choose page type</option>
	                		</select>
			            </div>
			            <span class="control-label span-error ng-hide" ng-show="submitted && !isRequiredRedactor">Description is a required field</span>
			        </div>
					<div class="form-group" ng-init="initRedactor('description')">
			            <label>
				            <strong>
					            Description
					            {{--<span class="text-require"> *</span>--}}
				            </strong>
			            </label>
			            <div ng-class="{'has-error': submitted && formData.notes.$invalid }">
			                <textarea id="description"></textarea>
			            </div>
			            <span class="control-label span-error ng-hide" ng-show="submitted && !isRequiredRedactor">Description is a required field</span>
			        </div>	
				</div>
				
			</div>
		</div>

		<div id="sidebar-resizer" resizer="vertical" resizer-width="0" resizer-left="#resize-left" resizer-right="#resize-right" resizer-max="500" resizer-position-left="300">
  		</div>

  		<div class="clearfix"></div>

	</div>

</div>
@stop
@section('script')
    <script>
		window.folders = {!! json_encode($folders) !!};
	</script>
	{!! Html::script('app/shared/resizer/resizer.js?v='.getVersionScript())!!}
	{!! Html::script('app/lib/redactor1023/redactor/link-page-topic-help.js?v='.getVersionScript())!!}
	@if(!isProduction() && !isDev())
	    {!! Html::script('app/components/user/help-editor/HelpEditorController.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/user/help-editor/HelpEditorService.js?v='.getVersionScript())!!}
		{!! Html::script('app/components/user/help-editor/partial/HelpEditorCreateTopic.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/help-editor.js') }}"></script>

	@endif
@stop
