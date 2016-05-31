<div class="modal-header">
    <button  ng-if="!showField" ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <button  ng-if="showField" ng-click="cancelFile()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">{{trans('cms_asset/upload-asset.modal_header_upload')}}</h4>
</div>

<div class="modal-body">
    <div ng-show="!showField" ng-init="assetEdit=({{json_encode($asset)}});folderType=({{json_encode($folderType)}});asset=({{json_encode($asset)}});folderAsset = {{json_encode($folderAsset)}}">
        <div ng-if="error">@{{error}}</div>
        <form role="form" name="formData"  class="upload-new-asset" novalidate>
            <!-- Input Name-->
            <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
                <label class="label-form" for="name">{{trans('cms_asset/upload-asset.name_label')}}:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control name" placeholder="{{trans('cms_asset/upload-asset.name_placeholder')}}" type="text" name="name" ng-model="asset.name" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.name.$error.required">{{trans('cms_asset/upload-asset.name_required')}}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-class="[submitted&& formData.folder.$invalid]">
                <label class="label-form" for="name">{{trans('cms_asset/upload-asset.folder_label')}}:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <select-level items="folderAsset" text="{{trans('cms_asset/upload-asset.folder_select')}}" item-choose="asset.folder" name="folder" text-filter="Filter folder" ng-model="asset.folder" show-icon="true" disable-click="'disabled'" ng-required = "true"></select-level>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.folder.$error.required">{{trans('cms_asset/upload-asset.folder_required')}}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- Attach File -->
            <div class="form-group" >
                <div class="form-group drop-file col-lg-12 padding-none">
                    <div>
                        <upload-file-asset ng-model="filesUpload"  folder ="folderType[asset.folder]" asset-edit="assetEdit" ng-multiple="one" placeholder="{{trans('cms_asset/upload-asset.placeholder_file_upload')}}"></upload-file-asset>
                    </div>
                    <div class="pull-left">
                        <small class="help-inline ng-invalid" ng-show="submitted && checkUpload && filesUpload.finished">{{trans('cms_asset/upload-asset.required_file_upload')}}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
             <div class="form-group" ng-show ="filesUpload.checkImage">
                <label class="label-form" for="name">{{trans('cms_asset/upload-asset.alt_label')}}</label>
                <div class="wrap-form">
                    <input class="form-control name" type="text" name="alt_tag" ng-model="asset.alt_tag"/>

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group" ng-show ="filesUpload.checkImage">
                <label class="label-form" for="name">{{trans('cms_asset/upload-asset.title_label')}}</label>
                <div class="wrap-form">
                    <input class="form-control name" type="text" name="title" ng-model="asset.title" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group" ng-show ="filesUpload.checkImage">
                <label class="label-form" for="name">{{trans('cms_asset/upload-asset.description_label')}}</label>
                <div class="wrap-form">
                    <textarea class="form-control name" type="text" name="description" ng-model="asset.description" ></textarea>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group" ng-show ="filesUpload.checkImage">
                <label class="label-form" for="name">{{trans('cms_asset/upload-asset.file_name')}}:<span class="text-require"> *</span></label>
                <div class="wrap-form">
                    <input class="form-control name" type="text" name="filename" ng-model="asset.filename"/>
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && !asset.filename && filesUpload.checkImage">{{trans('cms_asset/upload-asset.file_name_required')}}</small>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div ng-if="filesUpload.checkImage && folderType[asset.folder] =='images'" ng-include="teamplateThumb"></div>
        </form>
        <div class="clearfix"></div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default"  ng-click="cancel()"  data-dismiss="modal"><i class="fa fa-times"></i> {{trans('cms_asset/upload-asset.cancel_btn')}}</button>
    <button type="button" class="btn btn-primary" ng-disabled="!filesUpload.finished || showLoad" ng-click="submit(formData.$invalid)"><i class="fa fa-check"></i> {{trans('cms_asset/upload-asset.upload_new_version_btn')}}</button>
</div>

