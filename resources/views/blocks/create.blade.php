<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">
        <span ng-if="!block._id">{{trans('cms_block/request-block.modal_header_request')}}</span>
        <span ng-if="block._id && block.modal == 'request_translation'">{{trans('cms_block/request-block.modal_header_translate')}}</span>
        <span ng-if="block._id && block.modal == 'request_region'">{{trans('cms_block/request-block.modal_header_region')}}</span>
    </h4>
</div>

<div class="modal-body" id="loaded">
    <div ng-if="error">@{{error}}</div>
    <form role="form" name="formData" ng-init="folders={{json_encode($folders)}};selectedItem={{json_encode($selectedItem)}};folderType={{json_encode($folderType)}}" novalidate>
        <!-- Input Name-->
        <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
            <label class="label-form" for="name">{{trans('cms_block/request-block.name_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <div ng-if="!block._id">
                    <input class="form-control name" placeholder="{{trans('cms_block/request-block.name_placeholder')}}" type="text" name="name" ng-model="block.name" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.name.$error.required">{{trans('cms_block/request-block.name_required')}}</small>
                    </div>
                </div>

                <div ng-if="block._id">
                    <span>@{{block.name}}</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Input folders-->
        <div class="form-group" ng-class="[submitted && formData.folder_id.$invalid]">
            <label class="label-form" for="name">{{trans('cms_block/request-block.folder_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                @if(!$block['_id'])
                <div >
                    <select-level items="folders" text="Select {{trans('cms_block/request-block.folder_placeholder')}}" show-icon="true" text-filter="Filter folder" ng-model="block.folder_id" selected-item="selectedItem"></select-level>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && !block.folder_id">{{trans('cms_block/request-block.folder_required')}}</small>
                    </div>
                </div>
                @else
                <div>
                    <span>@{{block.folderName}}</span>
                </div>
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- Input Type-->
        <div class="form-group" ng-class="[submitted && formData.folder_id.$invalid]" ng-show ="folderType[block.folder_id] != 'managed_block'">
            <label class="label-form" for="name">{{trans('cms_block/request-block.type_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <div ng-if="!block._id">
                    <select name="type" class="form-control" ng-options="key as value for (key,value) in {{json_encode($types)}}" ng-model="block.type" ng-required = "true">
                        <option value="" disabled>{{trans('cms_block/request-block.type_select')}}</option>
                    </select>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.type.$error.required">{{trans('cms_block/request-block.type_required')}}</small>
                    </div>
                </div>
                <div ng-if="block._id">
                    <span>@{{block.typeName}}</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Requested Date-->
        <div class="form-group" ng-class="[submitted && formData.due_date.$invalid]">
            <label class="label-form" for="name">{{trans('cms_block/request-block.requested_date_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input type="text" placeholder="{{trans('cms_block/request-block.requested_date_placeholder')}}" class="form-control" name="due_date"
                            datepicker-popup="@{{format}}"
                            ng-model="block.due_date"
                            is-open="opened['requestDate']"
                            ng-click="open($event,'requestDate')"
                            min-date = "minDate"
                            ng-required="true"/>
                <div class="pull-left">
                    <small class="help-inline" ng-show="submitted && formData.due_date.$error.required">{{trans('cms_block/request-block.requested_date_required')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Input Languages-->
        @if($block->_id && $block->modal == 'request_translation')
            <div class="form-group">
                <label class="label-form" for="requestDate">{{trans('cms_block/request-block.requested_language_label')}}:<span class="text-require"> *</span></label>
                <div class="clearfix"></div>
                <multi-select-block items = "{{json_encode($languagesUnselected)}}" required-item="requiredLanguage" items-assigned = "languages_selected"></multi-select-block>
                <div class="clearfix"></div>
                <small class="help-inline m-l-15 ng-invalid" ng-show="submitted && requiredLanguage">{{trans('cms_block/request-block.requested_language_required')}}</small>
            </div>
        @endif

        <!-- Input Regions-->
        @if($block->_id && $block->modal == 'request_region')
            <div class="form-group">
                <label class="label-form" for="requestDate">{{trans('cms_block/request-block.requested_region_label')}}:<span class="text-require"> *</span></label>
                <div class="clearfix"></div>
                <multi-select-block items = "{{json_encode($regionsUnselected)}}" required-item="requiredRegion" items-assigned = "regions_selected"></multi-select-block>
                <div class="clearfix"></div>
                <small class="help-inline m-l-15 ng-invalid" ng-show="submitted && requiredRegion">{{trans('cms_block/request-block.requested_region_required')}}</small>
            </div>
        @endif

        <!-- Input Description-->
        <div class="form-group" >
            <label class="label-form" for="">{{trans('cms_block/request-block.description_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <textarea id="description" name="description" class="form-control" ng-init="initRedactor()" placeholder="{{trans('cms_block/request-block.description_placeholder')}}"></textarea>
                <div class="pull-left">
                    <small class="help-inline ng-invalid" ng-show="submitted && requiredDescription">{{trans('cms_block/request-block.description_required')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Attach File -->
        <div class="form-group">
            <div class="form-group drop-file col-lg-12 padding-none">
                <div>
                    <file-upload ng-model="filesUpload" placeholder="{{trans('cms_block/request-block.placeholder_file_upload')}}"></file-upload>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Thumbnail -->
        <div class="form-group">
            <div class="form-group drop-file col-lg-12 padding-none">
                <button class="btn btn-primary pull-left" ng-model="block.thumbnail"
                        ngf-select
                        ngf-reset-model-on-click="false"
                        ngf-accept="'image/*'"
                        accept="image/*">
                    <i class="fa fa-image"></i> {{trans('cms_block/request-block.block_thumb_btn')}}
                </button>

                <div class="clearfix"></div>

                <div class="m-t-15">
                    <div class="" ng-repeat="image_add in block.thumbnail track by $index">
                        <img class="item-thum-up" ngf-src="image_add" ng-show="image_add.type.indexOf('image') > -1" ngf-accept="'image/*'">
                        <a class="action-thum-up" href="javascript:void(0);"><i ng-click="removeThumbnail($index)" class="fa fa-times"></i></a>
                    </div>
                </div>

            </div>
            <div class="clearfix"></div>
        </div>
    </form>

    <div class="" ng-show="errors">
        <div class="help-inline" ng-repeat="(key, value) in errors">@{{value}}</div>
        <div class="clearfix"></div>
    </div>

</div>

<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()" ><i class="fa fa-times"></i> {{trans('cms_block/request-block.cancel_btn')}}</button>

    <button class="btn btn-primary" id="btnSubmit" ng-click="submit(formData.$invalid)"><i class="fa fa-check"></i> {{trans('cms_block/request-block.submit_btn')}}</button>
</div>

<script>
    window.block = {!!json_encode($block)!!}
    window.folders = {!!json_encode($folders)!!}
</script>
