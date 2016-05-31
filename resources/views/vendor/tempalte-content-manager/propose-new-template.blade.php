<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">
        <span>{{trans('cms_template/propose-template.modal_header')}}</span>
    </h4>
</div>

<div class="modal-body">
    <form role="form" name="formData" ng-init="selectedItem={{json_encode($selectedItem)}}">
        <!-- Input Name-->
        <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
            <label class="label-form" for="name">{{trans('cms_template/propose-template.name_label')}}:<span class="text-require"> *</span></label>
            <input class="form-control" placeholder="{{trans('cms_template/propose-template.name_placeholder')}}" type="text" name="name" ng-model="template.name" ng-required = "true" />
            <div class="">
                <small class="help-inline" ng-show="submitted && formData.name.$error.required">{{trans('cms_template/propose-template.name_required')}}</small>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input folders-->
        <div class="form-group" ng-class="[submitted && formData.folder_id.$invalid]">
            <label class="label-form" for="name">{{trans('cms_template/propose-template.name_placeholder')}}:<span class="text-require"> *</span></label>
            <select-level items="{{json_encode($folders)}}" text="Select Folder" show-icon="true" text-filter="Filter folder" ng-model="template.folder_id" selected-item="selectedItem"></select-level>
            <div>
                <small class="help-inline" ng-show="submitted && !template.folder_id ">{{trans('cms_template/propose-template.folder_required')}}</small>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- Requested Date-->
        <div class="form-group" ng-class="[submitted && formData.due_date.$invalid]">
            <label class="label-form" for="name">{{trans('cms_template/propose-template.requested_date_label')}}:<span class="text-require"> *</span></label>
            <input type="text" placeholder="{{trans('cms_template/propose-template.requested_date_placeholder')}}" class="form-control" name="due_date" datepicker-popup="@{{format}}" ng-model="template.due_date" is-open="opened['due_date']" ng-click="open($event,'due_date')" min-date = "minDate" ng-required="true"/>
            <div class="">
                <small class="help-inline" ng-show="submitted && formData.due_date.$error.required">{{trans('cms_template/propose-template.requested_date_required')}}</small>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- Input Description-->
        <div class="form-group">
            <label class="label-form" for="">{{trans('cms_template/propose-template.description_label')}}:<span class="text-require"> *</span></label>
            <textarea id="content" name="description" class="form-control" ng-init="initRedactor()" placeholder="{{trans('cms_template/propose-template.description_placeholder')}}"></textarea>
            <div class="">
                <small class="help-inline ng-invalid" ng-show="submitted && requiredDescription">{{trans('cms_template/propose-template.description_required')}}</small>
            </div>

        </div>
        <div class="clearfix"></div>

        <!-- Attach File -->
        <div class="form-group">
            <div class="form-group drop-file col-lg-12 padding-none">
                <div>
                    <file-upload ng-model="filesUpload" placeholder="{{trans('cms_template/propose-template.placeholder_file_upload')}}"></file-upload>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- Ticket child -->
        <div class="form-group space-box" ng-if="!template._id" ng-init="template.template_visual_design = true;template.template_html = true;template.template_build = true">
            <div><b>{{trans('cms_template/propose-template.create_child_task_label')}}:</b></div>
            <div class="col-lg-6 col-md-6 padding-none">
                <div class="checkbox checkbox-info">
                    <input type="checkbox" id="checkbox1" ng-model="template.template_visual_design" ng-checked="template.template_visual_design == true">
                    <label for="checkbox1">{{trans('cms_template/propose-template.template_visual_design')}}</label>
                </div>

                <div class="checkbox checkbox-info">
                    <input id="checkbox2" type="checkbox" ng-model="template.template_html" ng-checked="template.template_html == true">
                    <label for="checkbox2">{{trans('cms_template/propose-template.template_html')}}</label>
                </div>
            </div>

            <div class="col-lg-6 padding-none">
                <div class="checkbox checkbox-info">
                    <input id="checkbox3" type="checkbox" ng-model="template.template_build" ng-checked="template.template_build == true">
                    <label for="checkbox3">{{trans('cms_template/propose-template.template_build')}}</label>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
    </form>

</div>
<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()" ><i class="fa fa-times"></i> {{trans('cms_template/propose-template.cancel_btn')}}</button>

    <button class="btn btn-primary" id="btnSubmit"  ng-click="submitRequest(formData.$invalid)"><i class="fa fa-check"></i> {{trans('cms_template/propose-template.submit_btn')}}</button>
</div>
