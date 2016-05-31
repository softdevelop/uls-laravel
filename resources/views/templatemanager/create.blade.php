@extends('app')
@section('title')
	Template Manager
@stop
@section('content')

<div class="top-content">
    <label class="c-m"> {{!empty($template->id) ? 'Edit Template' : 'Add Template'}}</label>
</div>
<div class="content" data-ng-controller="ModalTemplateCtrl">
	<div class="modal-body">
		@if($template->id)
			<form name="formData" ng-init="getTemplate({{$template}})"  novalidate>
		@else
			<form name="formData" ng-init="getTemplate({{$template}}); addPositionTemplate();addFieldTemplate()"  novalidate>
		@endif
			{!! csrf_field() !!}
	        <div class="alert alert-danger" ng-show="errors">
				<span>@{{errors}}<br></span>
			</div>
			<div class="form-group">
				<strong>Name:<span class="text-require"> *</span></strong>
				<input type="text" class="form-control" name="name" id="" placeholder="Enter name"
						ng-model="template.name"
						ng-required="true"/>
				<small class="help-inline" ng-show="submitted && formData.name.$error.required">Name is a required field.</small>
				<div class="clearfix"></div>
			</div>

			<div class="form-group">
				<strong>Fields:<span class="text-require"> *</span>
					<a class="btn btn-action btn-xs btn-circle" href="" ng-click="addFieldTemplate()" >
						<i class="fa fa-plus"></i>
					</a>
				</strong>

				<div class="col-sm-12 col-lg-12 padding-none form-group" ng-repeat="option in fieldNumber">
	                <a ng-if="!$first" href="" class="btn btn-default btn-xs btn-remove-price btn-circle" ng-click="deleteFieldTemplate(option)">
	                    <i class="fa fa-times"></i>
	                </a>

	                <div class="col-xs-7 col-lg-8 padding-none">
	                   <input id="fieldName" type="text" placeholder="Field name" ng-required="true" class="form-control"
	                    ng-model="template.fields[$index].name" name="fieldName@{{option}}">
	                    <small class="help-inline" ng-show="submitted && formData.fieldName@{{option}}.$error.required">Field is a required field.</small>
	                </div>
	            </div>
	            <div class="clearfix"></div>
			</div>

			<div class="form-group">
				<strong>Sections:<span class="text-require"> *</span>
					<a class="btn btn-action btn-xs btn-circle" href="" ng-click="addPositionTemplate()" >
						<i class="fa fa-plus"></i>
					</a>
				</strong>

				<div class="col-sm-12 col-lg-12 padding-none form-group" ng-repeat="option in numberOptions">
	                <a ng-if="!$first" href="" class="btn btn-default btn-xs btn-remove-price btn-circle" ng-click="removePositionTemplate($index)">
	                    <i class="fa fa-times"></i>
	                </a>

	                <div class="col-xs-7 col-lg-8 padding-none">
	                   <input id="positionName" type="text" placeholder="Section name" ng-required="true" class="form-control"
	                    ng-model="template.sections[option].name" name="positionName@{{option}}">
	                    <small class="help-inline" ng-show="submitted && formData.positionName@{{option}}.$error.required">Section is a required field.</small>
	                </div>
	                <div  class="col-xs-3 col-lg-3 text-center" ng-if="template.sections[option].thumbnail">
			        	<div class="col-md-2">
		                	<img class="item-thum-up" ng-src="@{{baseUrl}}/files/positions/@{{template.sections[option].thumbnail}}">
		                	<a class="action-thum-up" href="javascript:void(0);"><i ng-click="deleteThumbPosition(option)" class="fa fa-times"></i></a>
		                </div>
	                </div>
	                <div class="col-xs-3 col-lg-3" ng-show="!template.sections[option].thumbnail">
	                	<a id="upload_file_result" type="submit" accept="image/*" ngf-select  ngf-change="upload($files, option)" name="tmp"><i class="fa fa-camera"></i></a>
						<!-- <button id="upload_file_result" class="btn btn-primary" accept="image/*" ngf-select  ngf-change="upload($files, option)" name="tmp">Select Image</button> -->
	                	<!-- <input  type="file" class="form-control" > -->

	                {{-- 	<input type="text" placeholder="click to browse file"
	                		   name="file_position" id="file" ngf-change="upload($files)" class="form-control" /> --}}
	                </div>
	                <div class="clearfix"></div>
	            </div>
	            <div class="clearfix"></div>
			</div>

			<div class="form-group">
				<strong>Description:<span class="text-require"> *</span></strong>
				<textarea  class="form-control h-130" name="description" placeholder = "Enter description"
							ng-model="template.description"
							ng-required="true">
				</textarea>
				 <small class="help-inline" ng-show="submitted && formData.description.$error.required">Description is a required field.</small>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<div class="form-group">
				<div class="col-md-2" ng-if="template.thumbnail != '' && template.thumbnail != null">
					<img class="item-thum-up" ng-src="@{{baseUrl}}/uploads/templates/@{{template.thumbnail}}">
					<a class="action-thum-up" href="javascript:void(0);"><i ng-click="deleteThumbnail(template._id)" class="fa fa-times"></i></a>
					<div class="clearfix"></div>
	        	</div>
		    </div>
		    <div class="clearfix"></div>

			<div class="form-group">
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
			<div class="clearfix"></div>
	    </form>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" ng-click="submitTemplate(formData.$invalid)">
			<i class="fa fa-check"></i> Submit
		</button>
		<a class="btn btn-warning" href="/template-manager"> <i class="fa fa-times"></i> Cancel</a>
	</div>
</div>
@stop

@section('script')
	<script>
		window.baseUrl  = '{{URL::to("")}}';
		window.template = {!!json_encode($template)!!};
	</script>

	  {!! Html::script('bower_components/ng-file-upload/ng-file-upload-shim.min.js')!!}
	  {!! Html::script('bower_components/ng-file-upload/ng-file-upload.min.js')!!}
	@if(!isProduction() && !isDev())
		{!! Html::script('/app/components/templatemanager/TemplateManagerService.js?v='.getVersionScript())!!}
		{!! Html::script('/app/components/templatemanager/TemplateManagerController.js?v='.getVersionScript())!!}
	@else
		<script src="{{ elixir('app/pages/template.js') }}"></script>
	@endif

@stop
