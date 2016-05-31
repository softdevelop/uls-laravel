<div class="modal-header" ng-init="folderAsset = {{json_encode($folderAsset)}};folderType = {{json_encode($folderType)}};selectedItem={{json_encode($selectedItem)}}">
    <button  ng-if="!showField" ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <button  ng-if="showField" ng-click="cancelFile()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">{{trans('cms_asset/upload-asset.modal_header_upload')}}</h4>
</div>
<div class="modal-body assets" ng-show="!showField">
    <div ng-if="error">@{{error}}</div>
    <form role="form" name="formData"  class="upload-new-asset" novalidate>
        <!-- Input Name-->
        <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
            <label class="label-form" for="name">{{trans('cms_asset/upload-asset.name_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input class="form-control" placeholder="{{trans('cms_asset/upload-asset.name_placeholder')}}" type="text" name="name" ng-model="asset.name" ng-required = "true" />
                <div class="pull-left">
                    <small class="help-inline" ng-show="submitted && formData.name.$error.required">{{trans('cms_asset/upload-asset.name_required')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group" ng-class="[submitted && !asset.folder]">
            <label class="label-form" for="name">{{trans('cms_asset/upload-asset.folder_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <select-level items="folderAsset" selected-item="selectedItem" show-icon="true" text="{{trans('cms_asset/upload-asset.folder_select')}}" text-filter="Filter folder" ng-model="asset.folder" type-select="'Assets'"></select-level>
                <div class="pull-left">
                    <small class="help-inline" ng-show="submitted && !asset.folder">{{trans('cms_asset/upload-asset.folder_required')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- Attach File -->
        <div class="form-group" >
            <div class="form-group drop-file col-lg-12 padding-none">
                <div ng-click="changeImg()">
                    <upload-file-asset ng-model="filesUpload" folder ="folderType[asset.folder]" placeholder="{{trans('cms_asset/upload-asset.placeholder_file_upload')}}"></upload-file-asset>
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
                <input class="form-control" type="text" name="altTag" ng-model="asset.altTag"/>
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
                <textarea class="form-control" type="text" name="description" ng-model="asset.description" ></textarea>

            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group" ng-show ="filesUpload.checkImage">
            <label class="label-form" for="name">{{trans('cms_asset/upload-asset.file_name')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input class="form-control" type="text" name="nameNewFile" ng-model="asset.nameNewFile"/>
                <div>
                    <small class="help-inline" ng-show="submitted && !asset.nameNewFile && filesUpload.checkImage">{{trans('cms_asset/upload-asset.file_name_required')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div ng-if="filesUpload.checkImage && folderType[asset.folder] =='images'" ng-include="teamplateThumb"></div>
        <div class="form-group" >
            <div class="wrap-form">
                <div class="tag-modal fix-space-checkbox">
                    <tag-content-directive items="tagsContent" class="wrap-tag-content" text="Tag Content Type"
                        title="Apply labels to this page" placeholder="Filter labels"
                        ng-model="idTagContent" current-page="asset" all-tags="allTags"
                        index="$index+900" on-click="selectTags(asset.data._id, tagId)"
                        selected-items="itemsSelected">
                    </tag-content-directive>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </form>
    <div class="clearfix"></div>
</div>


<div class="modal-footer">
    <button type="button" class="btn btn-default"  ng-click="cancel()"  data-dismiss="modal"><i class="fa fa-times"></i> {{trans('cms_asset/upload-asset.cancel_btn')}}</button>
    <button type="button" class="btn btn-primary" ng-disabled="!filesUpload.finished || showLoad" ng-click="submit(formData.$invalid)"><i class="fa fa-check"></i> {{trans('cms_asset/upload-asset.submit_btn')}}</button>
</div>

{!! Html::script('app/shared/tag-content-directive/tagContentDirective.js?v='.getVersionScript())!!}
