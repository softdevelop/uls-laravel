<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">
        <span ng-if="!asset._id">{{trans('cms_asset/request-asset.modal_header_request')}}</span>
        <span ng-if="asset._id && asset.modal == 'request_translation'">{{trans('cms_asset/request-asset.modal_header_translate')}}</span>
        <span ng-if="asset._id && asset.modal == 'request_region'">{{trans('cms_asset/request-asset.modal_header_region')}}</span>
    </h4>
</div>

<div class="modal-body">
    <div ng-if="error">@{{error}}</div>
    <form role="form" name="formData" ng-init="asset={{json_encode($asset)}}; selectedItem={{json_encode($selectedItem)}}" novalidate>
        <!-- Input Name-->
        <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
            <label class="label-form" for="name">{{trans('cms_asset/request-asset.name_label')}}:<span class="text-require"> *</span></label>
            <div class="clearfix"></div>
            <div class="wrap-form">
                <div ng-if="!asset._id">
                    <input class="form-control name" placeholder="{{trans('cms_asset/request-asset.name_placeholder')}}" type="text" name="name" ng-model="asset.name" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.name.$error.required">{{trans('cms_asset/request-asset.name_required')}}</small>
                    </div>
                </div>

                <div ng-if="asset._id">
                    <span>@{{asset.name}}</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Input folders-->
        <div class="form-group" ng-class="[submitted && !asset.folder_id]">
            <label class="label-form" for="name">{{trans('cms_asset/request-asset.folder_label')}}:<span class="text-require"> *</span></label>
            <div class="clearfix"></div>
            <div class="wrap-form">

                <div ng-if="!asset._id">
                    <select-level items="{{json_encode($folders)}}" text="{{trans('cms_asset/request-asset.folder_select')}}" show-icon="true" text-filter="Filter folder" ng-model="asset.folder_id" selected-item="selectedItem" type-select="'Assets'" ng-required="true"></select-level>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && !asset.folder_id">{{trans('cms_asset/request-asset.folder_required')}}</small>
                    </div>
                </div>
                <div ng-if="asset._id">
                    <span>@{{asset.folderName}}</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- Requested Date-->
        <div class="form-group" ng-class="[submitted && formData.due_date.$invalid]">
            <label class="label-form" for="name">{{trans('cms_asset/request-asset.requested_date_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input type="text" placeholder="{{trans('cms_asset/request-asset.requested_date_placeholder')}}" class="form-control" name="due_date"
                            datepicker-popup="@{{format}}"
                            ng-model="asset.due_date"
                            is-open="opened['due_date']"
                            ng-click="open($event,'due_date')"
                            min-date = "minDate"
                            ng-required="true"/>

                <div class="pull-left">
                    <small class="help-inline" ng-show="submitted && formData.due_date.$error.required">{{trans('cms_asset/request-asset.requested_date_required')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Input Languages-->
        @if($asset->_id && $asset->modal == 'request_translation')
            <div class="form-group">
                <label class="label-form" for="due_date">{{trans('cms_asset/request-asset.requested_language_label')}}:<span class="text-require"> *</span></label>
                
                <div class="clearfix"></div>

                <multi-select-asset items = "{{json_encode($languagesUnselected)}}" required-item="requiredLanguage" items-assigned = "languages_selected"></multi-select-asset>
                <div class="clearfix"></div>

                <small class="help-inline ng-invalid m-l-15" ng-show="submitted && requiredLanguage">{{trans('cms_asset/request-asset.requested_language_required')}}</small>
            </div>
        @endif

        <!-- Input Regions-->
        @if($asset->_id && $asset->modal == 'request_region')
            <div class="form-group">
                <label class="label-form" for="due_date">{{trans('cms_asset/request-asset.requested_region_label')}}:<span class="text-require"> *</span></label>
                <div class="clearfix"></div>
                <multi-select-asset items = "{{json_encode($regionsUnselected)}}" required-item="requiredRegion" items-assigned = "regions_selected"></multi-select-asset>
                <div class="clearfix"></div>
                <small class="col-lg-12 help-inline  ng-invalid" ng-show="submitted && requiredRegion">{{trans('cms_asset/request-asset.requested_region_required')}}</small>
            </div>
        @endif

        <!-- Input Description-->
        <div class="form-group" >
            <label class="label-form" for="">{{trans('cms_asset/request-asset.description_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <textarea id="content" name="description" class="form-control" ng-init="initRedactor()" placeholder="{{trans('cms_asset/request-asset.description_placeholder')}}"></textarea>
                <div class="pull-left">
                    <small class="help-inline ng-invalid" ng-show="submitted && requiredDescription">{{trans('cms_asset/request-asset.description_required')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Attach File -->
        <div class="form-group">
            <div class="form-group drop-file col-lg-12 padding-none">
                <div>
                    <file-upload ng-model="filesUpload" placeholder="{{trans('cms_asset/request-asset.placeholder_file_upload')}}"></file-upload>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </form>

</div>

<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()" ><i class="fa fa-times"></i> {{trans('cms_asset/request-asset.cancel_btn')}}</button>

    <button class="btn btn-primary" id="btnSubmit" ng-disabled="!filesUpload.finished || showLoad" ng-click="submit(formData.$invalid)"><i class="fa fa-check"></i> {{trans('cms_asset/request-asset.submit_btn')}}</button>
</div>
