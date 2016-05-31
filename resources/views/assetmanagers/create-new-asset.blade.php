<div class="modal-header" ng-init="folderAsset = {{json_encode($folderAsset)}};folderType={{json_encode($folderType)}};selectedItem={{json_encode($selectedItem)}}">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">
        <span>{{trans('cms_asset/create-asset.modal_header')}}</span>
    </h4>
</div>

<div class="modal-body">
    <div ng-if="error">@{{error}}</div>
    <form role="form" name="formData">
        <!-- Input Name-->
        <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
            <label class="label-form" for="name">{{trans('cms_asset/create-asset.name_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <div ng-if="!asset._id">
                    <input class="form-control name" placeholder="{{trans('cms_asset/create-asset.name_placeholder')}}" type="text" name="name" ng-model="asset.name" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.name.$error.required">{{trans('cms_asset/create-asset.name_required')}}</small>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="form-group" ng-class="[submitted && !asset.folder]">
            <label class="label-form" for="name">{{trans('cms_asset/create-asset.folder_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <select-level items="folderAsset" selected-item="selectedItem" show-icon="true" text="{{trans('cms_asset/create-asset.folder_select')}}" text-filter="Filter folder" ng-model="asset.folder" type-select="'Assets'"></select-level>
                <div class="pull-left">
                    <small class="help-inline" ng-show="submitted && !asset.folder">{{trans('cms_asset/create-asset.folder_required')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="form-group" ng-class="[submitted && formData.name.$invalid]">
            <label class="label-form" for="name">{{trans('cms_asset/create-asset.file_name_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <div ng-if="!asset._id">
                    <input class="form-control name" placeholder="{{trans('cms_asset/create-asset.file_name_placeholder')}}" type="text" name="nameFile" ng-model="asset.fileName" ng-required = "true" />
                    <div class="pull-left">
                        <small class="help-inline" ng-show="submitted && formData.nameFile.$error.required">{{trans('cms_asset/create-asset.file_name_required')}}</small>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- Input folders-->

    </form>

</div>

<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()" ><i class="fa fa-times"></i> {{trans('cms_asset/create-asset.cancel_btn')}}</button>

    <button class="btn btn-primary" id="btnSubmit" ng-disabled="showLoad" ng-click="submit(formData.$invalid)"><i class="fa fa-check"></i> {{trans('cms_asset/create-asset.submit_btn')}}</button>
</div>
