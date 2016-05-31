<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" ng-if="template._id && template.modal == 'request_translation'">{{trans('cms_template/request-template.modal_header_translate')}}</h4>
    <h4 class="modal-title" ng-if="template._id && template.modal == 'request_region'">{{trans('cms_template/request-template.modal_header_region')}} | @{{template.modal}}</h4>
</div>

<div class="modal-body" ng-init="selectedItem={{json_encode($selectedItem)}}">
    <div ng-if="error">@{{error}}</div>
    <form role="form" name="formData" novalidate>
        <!-- Input Name-->
        <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
            <label class="label-form" for="name">{{trans('cms_template/request-template.name_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <div ng-if="!template._id">
                    <input class="form-control name" placeholder="{{trans('cms_template/request-template.name_placeholder')}}" type="text" name="name" ng-model="template.name" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.name.$error.required">{{trans('cms_template/request-template.name_required')}}</small>
                    </div>
                </div>

                <div ng-if="template._id">
                    <span>@{{template.name}}</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Input folders-->
        <div class="form-group" ng-class="[submitted && formData.folder_id.$invalid]">
            <label class="label-form" for="name">{{trans('cms_template/request-template.folder_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <div ng-if="!template._id"  >
                    <select-level items="folders" text="Select Folder" text-filter="Filter folder" ng-model="template.folder_id" selected-item="selectedItem"></select-level>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.folder_id.$error.required">{{trans('cms_template/request-template.folder_required')}}</small>
                    </div>
                </div>
                <div ng-if="template._id">
                    <span>@{{template.folderName}}</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- Requested Date-->
        <div class="form-group" ng-class="[submitted && formData.due_date.$invalid]">
            <label class="label-form" for="name">{{trans('cms_template/request-template.requested_date_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input type="text" placeholder="{{trans('cms_template/request-template.requested_date_placeholder')}}" class="form-control" name="due_date"
                            datepicker-popup="@{{format}}"
                            ng-model="template.due_date"
                            is-open="opened['due_date']"
                            ng-click="open($event,'due_date')"
                            min-date = "minDate"
                            ng-required="true"/>

                <div class="pull-left">
                    <small class="help-inline" ng-show="submitted && formData.due_date.$error.required">{{trans('cms_template/request-template.requested_date_required')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Input Languages-->
        @if($template->_id && $template->modal == 'request_translation')
            <div class="form-group">
                <label class="label-form" for="due_date">{{trans('cms_template/request-template.requested_language_label')}}:<span class="text-require"> *</span></label>
                <div class="clearfix"></div>
                <multi-select-template items = "{{json_encode($languagesUnselected)}}" required-item="requiredLanguage" items-assigned = "languages_selected"></multi-select-template>
                <div class="clearfix"></div>
                <small class="help-inline m-l-15 ng-invalid" ng-show="submitted && requiredLanguage">{{trans('cms_template/request-template.requested_language_required')}}</small>
            </div>
        @endif

        <!-- Input Regions-->
        @if($template->_id && $template->modal == 'request_region')
            <div class="form-group">
                <label class="label-form" for="due_date">{{trans('cms_template/request-template.requested_region_label')}}:<span class="text-require"> *</span></label>
                <div class="clearfix"></div>
                <multi-select-template items = "{{json_encode($regionsUnselected)}}" required-item="requiredRegion" items-assigned = "regions_selected"></multi-select-template>
                <div class="clearfix"></div>
                <small class="help-inline  ng-invalid" ng-show="submitted && requiredRegion">{{trans('cms_template/request-template.requested_region_required')}}</small>
            </div>
        @endif

        <!-- Input Description-->
        <div class="form-group" >
            <label class="label-form" for="">{{trans('cms_template/request-template.description_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <textarea id="content" name="description" class="form-control" ng-init="initRedactor()" placeholder="{{trans('cms_template/request-template.description_placeholder')}}"></textarea>
                <div class="pull-left">
                    <small class="help-inline ng-invalid" ng-show="submitted && requiredDescription">{{trans('cms_template/request-template.description_required')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Attach File -->
        <div class="form-group">
            <div class="form-group drop-file wrap-form">
                <div>
                    <file-upload ng-model="filesUpload" placeholder="{{trans('cms_template/request-template.placeholder_file_upload')}}"></file-upload>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </form>

</div>
<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()" ><i class="fa fa-times"></i> {{trans('cms_template/request-template.cancel_btn')}}</button>

    <button class="btn btn-primary" id="btnSubmit" ng-disabled="!filesUpload.finished" ng-click="submit(formData.$invalid)"><i class="fa fa-check"></i> {{trans('cms_template/request-template.submit_btn')}}</button>
</div>
<script>
    window.template={!!json_encode($template)!!}
    window.folders = {!!json_encode($folders)!!}
</script>
