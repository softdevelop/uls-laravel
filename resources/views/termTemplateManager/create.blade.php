@extends('app')
@section('title')
	Template Manager
@stop
@section('content')

<div class="top-content">
    <label class="c-m"> Add Template</label>
</div>
<div class="content" data-ng-controller="ModalTermTemplateCtrl">
	<div class="modal-body">
		<form name="formData" novalidate>
			{!! csrf_field() !!}
	        <div class="alert alert-danger" ng-show="errors">
				<span>@{{errors}}<br></span>
			</div>

			<div class="col-lg-12 padding-none">
				<div class="form-group">
					<label class="control-label"><strong>Template Name:<span class="text-require"> *</span></strong></label>
					<input type="text" class="form-control" name="name" id="" placeholder="Enter name"
							ng-model="template.name"
							ng-required="true"/>
					<small class="help-inline" ng-show="submitted && formData.name.$error.required">Name is a required field.</small>
					<div class="clearfix"></div>
				</div>

				<div class="form-group">
					<label class="control-label"><strong>Type:<span class="text-require"> *</span></strong></label>
					<select ng-required="true" class="form-control" ng-model="template.type" id="type" name="type">
	                        <option value="" disabled="disabled" selected="selected"> Select Type </option>
	                        <option value="detail">Detail</option>
	                        <option value="email">E-Mail</option>
	                </select>
					<small class="help-inline" ng-show="submitted && formData.type.$error.required">Type is a required field.</small>
					<div class="clearfix"></div>
				</div>

				<div class="form-group">
					<label class="control-label"><strong>Description:<span class="text-require"> *</span></strong></label>
					<textarea  class="form-control h-130" name="description" placeholder = "Enter description"
								ng-model="template.description"
								ng-required="true">
					</textarea>
					 <small class="help-inline" ng-show="submitted && formData.description.$error.required">Description is a required field.</small>
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="col-lg-12 padding-none border-box-ccc box-build-template">
				<div class="title-build">
					Build Template
				</div>
				<div class="col-lg-12 p-20">
					<div class="form-group col-lg-4">
						<label class="control-label m-b-20 c-primary"><strong>User</strong></label>
						<p class="text-add-element" ng-repeat="item in userFillable" >
							<label class="capitalize">@{{item['name']}}</label>
							<a class="add-element c-000" data-toggle="tooltip" data-placement="right" title="Add to html" ng-click="insertViewField(item['key'])"><i class="fa fa-plus"></i></a>
						</p>
						<div class="clearfix"></div>
					</div>
					<div class="form-group col-lg-4">
					<label class="control-label m-b-30 c-primary"><strong>Branch</strong></label>
						<div class="clearfix"></div>
					</div>
					<div class="form-group col-lg-4">
						<label class="control-label m-b-20 c-primary"><strong>@{{term['name']}}</strong></label>
						<p class="text-add-element" ng-repeat="item in term['fields']">
							<label class="capitalize">@{{item['name']}}</label>
							<a class="add-element c-000" data-toggle="tooltip" data-placement="right" title="Add to html" ng-click="insertViewField(item['alias'])"><i class="fa fa-plus"></i></a>
						</p>
						<div class="clearfix"></div>
					</div>
				</div>

				<div class="form-group col-lg-12">
					<label class="control-label"><strong>HTML:<span class="text-require"> *</span></strong></label>
					<textarea class="form-control h-130" name="html" id="html" placeholder = "Enter HTML"
								ng-model="template.html">
					</textarea>
					 <small class="help-inline" ng-show="submitted && formData.description.$error.required">HTML is a required field.</small>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>

				<div class="form-group">
					<div class="col-md-2" ng-if="template.thumbnail != '' && template.thumbnail != null">
						<p style=""><strong>Thumbnail:</strong></p>
						<img class="item-thum-up" ng-src="/uploads/term-templates/@{{template.thumbnail}}">
						<a class="action-thum-up" href="javascript:void(0);"><i ng-click="deleteThumbnail(template._id)" class="fa fa-times"></i></a>
						<div class="clearfix"></div>
		        	</div>
			    </div>

			    <div class="clearfix"></div>

				<div class="form-group col-lg-12">
					@if($template->_id)
						<button ng-if="template.thumbnail == ''" class="btn btn-primary pull-left" ng-model="template.images_add"
			                      ngf-select
			                      ngf-reset-model-on-click="false"
			                      ngf-accept="'image/*'"
			                      accept="image/*">
							Choose thumbnail
			        	</button>
			        @else
			        	<button class="btn btn-primary pull-left" ng-model="template.images_add"
			                      ngf-select
			                      ngf-reset-model-on-click="false"
			                      ngf-accept="'image/*'"
			                      accept="image/*">
							Choose thumbnail
			        	</button>
			        @endif
		        	<div class="clearfix"></div>
					<div class="m-t-15">
			        	<div class="" ng-repeat="image_add in template.images_add track by $index">
		                	<img class="item-thum-up" ngf-src="image_add" ng-show="image_add.type.indexOf('image') > -1" ngf-accept="'image/*'">
		                	<a class="action-thum-up" href="javascript:void(0);"><i ng-click="deleteImageAdd($index)" class="fa fa-times"></i></a>
		                </div>
					</div>
		            <div class="clearfix"></div>
				</div>

			</div>

			<div class="clearfix"></div>
	    </form>
	</div>
	<div class="footer-content">
		<button class="btn btn-primary" id="btnAdd" ng-click="submitTermTemplate(formData.$invalid)">

		<i class="fa fa-check"></i>	Submit
		</button>
		<a class="btn btn-warning" href="/admin/terms/{{$termId}}/template-manager/"><i class="fa fa-times"></i> Cancel</a>
	</div>
</div>
@stop

@section('script')
	<script>
		window.termId = {!!json_encode($termId)!!}
		window.template = {!!json_encode($template)!!}
		window.userFillable = {!!json_encode($userFillable)!!}
		window.term = {!!json_encode($term)!!}
	</script>
		{!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}
		{!! Html::script('bower_components/ng-file-upload/ng-file-upload.min.js')!!}
		{!! Html::script('js/edit_area/edit_area_full.js')!!}
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/TermTemplateManager/TermTemplateManagerService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/TermTemplateManager/TermTemplateManagerController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/termTemplate.js') }}"></script>
	@endif

@stop
