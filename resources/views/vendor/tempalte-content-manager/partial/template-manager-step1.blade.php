    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancel()"><span aria-hidden="true">&times;</span></button>
        @if(empty($templateContent->_id))
        	<h4 class="modal-title" id="myModalLabel">{{trans('cms_template/add-template.modal_header_create')}}</h4>
        @else
        	<h4 class="modal-title" id="myModalLabel">{{trans('cms_template/add-template.modal_header_update')}}</h4>
        @endif
    </div>

    <div class="modal-body template-manager">

    	<form class="form-horizontal" method="POST" action="" accept-charset="UTF-8" name="formTemplate">
	        <div class="form-group" ng-class="{'has-error':submitStepSecond && formTemplate.name.$invalid}">
	        	<label for="" class="col-lg-12"><strong>{{trans('cms_template/add-template.name_label')}}:<span class="text-require"> *</span></strong></label>
	        	@if(empty($templateContent->_id))
		        	<div class="col-lg-12">
		        		<input type="text" name="name" class="form-control" ng-model="template.name" ng-required="true" />
		        		<small class="help-inline" ng-show="submitStepSecond && formTemplate.name.$error.required">{{trans('cms_template/add-template.name_label_required')}}</small>
		        	</div>
	        	@else
                    <div class="col-lg-12">
                        <span>{{$templateContent->name}}</span>
                        <input type="hidden" ng-model="template._id" ng-init="template._id={{json_encode($templateContent->_id)}}" />
                    </div>
                @endif
	        	<div class="clearfix"></div>
	        </div>
	        <div class="form-group" ng-class="{'has-error':submitStepSecond && !template.folder_id}">
	        	<label for="" class="col-lg-12"><strong>{{trans('cms_template/add-template.folder_label')}}:<span class="text-require"> *</span></strong></label>
	        	@if(empty($templateContent->_id))
		        	<div class="col-lg-12">
	                    <select-level items="{{json_encode($folders)}}" text="Select Folder" show-icon="true" text-filter="Filter folder" ng-model="template.folder_id" selected-item="selectedItem"></select-level>
		        		<small class="help-inline" ng-show="submitStepSecond && !template.folder_id">{{trans('cms_template/add-template.folder_label_required')}}</small>
		        	</div>
				@else
                    <div class="col-lg-12">
                        <span>{{$templateContent->folderName}}</span>
                        <input type="hidden" ng-model="template.folder_id" ng-init="template.folder_id={{json_encode($templateContent->folder_id)}}">
                    </div>
                @endif
	        	<div class="clearfix"></div>
	        </div>

{{-- 			<div class="form-group" ng-class="{'has-error':submitStepSecond && (!result || result.status == 0)}">
				<label class="col-lg-12" for=""><strong>Template File:</strong></label>
				<div class="col-lg-12">
				    <div class="input-group">
				      <input name="file" type="text" class="form-control" ng-value="wating" ng-required="true" ng-disabled="true" />
				      <span class="input-group-btn">
				        <button class="btn btn-default" type="button" accept=".txt,.blade.php,.php,.html" ngf-select ngf-drop ngf-change="uploadFileTemplate($files)">Select File</button>
				      </span>

				    </div>
				    <small class="help-inline" ng-show="submitStepSecond && (!result || result.status == 0) && !error">Template File is a required field.</small>
                    <small class="help-inline" ng-show="error && !extError">@{{error}}</small>
				    <small class="help-inline" ng-show="extError">File's type does not support</small>

				</div>

				<div class="clearfix"></div>
			</div> --}}

			<div class="form-group">
				<label class="col-lg-12" for=""><strong>{{trans('cms_template/add-template.thumbnail_image_label')}}:</strong></label>
				<div class="col-lg-12">
				    <div class="input-group">
				      <input type="text" name="thumbnail" class="form-control" ng-value="reciept_file_name" ng-required="true" ng-disabled="true"/>
				      <span class="input-group-btn">
				        <button class="btn btn-default" type="button" ngf-accept="'image/*'" accept="image/*" ngf-select ngf-drop ngf-change="uploadThumbnail($files)"><i class="fa fa-image"></i></button>
				      </span>
				    </div>
				    <small class="help-inline" ng-show="errorThumbnail">@{{errorThumbnail}}</small>
				</div>
				<div class="clearfix"></div>
			</div>
		</form>
    </div>

    <div class="modal-footer">
    	<button type="button" class="btn btn-default" ng-click="cancel()" data-dismiss="modal"> <i class="fa fa-times"></i> {{trans('cms_template/add-template.cancel_btn')}}</button>
{{--         <button type="button" ng-if="result.fields.length > 0 || result.sections.length > 0" class="btn btn-primary" data-dismiss="modal" ng-click="eventNextStepSecond(formTemplate.$invalid)">
        	<i class="fa fa-arrow-right"></i> Next
        </button> --}}
{{--         <button type="button" ng-if="(!result.fields && !result.sections) || (result.fields.length == 0 && result.sections.length == 0)" class="btn btn-primary" data-dismiss="modal" ng-click="createTemplateContentManager(1, formTemplate.$invalid)">
        	<i class="fa fa-check"></i> Save
        </button> --}}
        <button type="button" class="btn btn-primary" data-dismiss="modal" ng-click="createTemplateContentManager(1, formTemplate.$invalid)">
        	<i class="fa fa-check"></i> {{trans('cms_template/add-template.submit_btn')}}
        </button>
    </div>
