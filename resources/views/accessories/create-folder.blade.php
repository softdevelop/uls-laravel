<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">{{trans('cms_asset/add-folder.modal_header')}}</h4>
</div>
<div>@{{error}}</div>

<div class="modal-body">
    <form role="form" name="createFolderForm" novalidate>

        <!-- Input Name-->
        <div class="form-group" ng-class="[submitted && (createFolderForm.name.$invalid || nameExists)]">
            <label class="label-form" for="name">{{trans('cms_asset/add-folder.folder_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input  ng-class="{true: 'error'}" type="text" class="form-control" ng-change="changeName()" name="name" placeholder="{{trans('cms_asset/add-folder.folder_placeholder')}}"
                   ng-model="accestories.name"
                   ng-minlength=1
                   ng-maxlength=50
                   ng-required="true" />
                <div>
                    <small class="error" ng-show="submitted && nameExists">{{trans('cms_asset/add-folder.folder_name_exists')}}</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.required">{{trans('cms_asset/add-folder.folder_name_required')}}</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.minlength">{{trans('cms_asset/add-folder.folder_name_min')}}</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.maxlength">{{trans('cms_asset/add-folder.folder_name_max')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </form>
    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> {{trans('cms_asset/add-folder.cancel_btn')}}</button>
    <button class="btn btn-primary" ng-click="submit(createFolderForm.$invalid)" ng-disabled="showLoad" ><i class="fa fa-plus"></i> {{trans('cms_asset/add-folder.submit_btn')}}</button>

</div>
