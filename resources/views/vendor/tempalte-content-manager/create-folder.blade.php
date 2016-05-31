<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">{{trans('cms_template/add-folder.modal_header')}}</h4>
</div>
<div>@{{error}}</div>
<div class="modal-body">
    <form role="form" name="createFolderForm" novalidate>

        <!-- Input Name-->
        <div class="form-group full-width" ng-init="parentFolders = {{json_encode($result)}}; selectedItem = {{json_encode($selectedItem)}}" ng-class="[submitted && (createFolderForm.name.$invalid || nameExists)]">
            <label class="label-form" for="name">{{trans('cms_template/add-folder.folder_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input  ng-class="{true: 'error'}" type="text" class="form-control" name="name" placeholder="{{trans('cms_template/add-folder.folder_placeholder')}}"
                   ng-change="changeName()"
                   ng-model="folder.name"
                   ng-minlength=1
                   ng-maxlength=50
                   ng-required="true" />
                <div class="pull-right">
                    <small class="error" ng-show="submitted && nameExists">{{trans('cms_template/add-folder.folder_name_exists')}}</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.required">{{trans('cms_template/add-folder.folder_name_required')}}</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.minlength">{{trans('cms_template/add-folder.folder_name_min')}}</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.maxlength">{{trans('cms_template/add-folder.folder_name_max')}}</small>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <label class="label-form" for="name">
                {{trans('cms_template/add-folder.folder_parent_label')}}
            </label>

            <div class="wrap-form">

                <select-level items="parentFolders" text="root" text-filter="Filter folder" show-icon="true" ng-model="folder.parent_id" selected-item="selectedItem"></select-level>
            </div>
            <div class="clearfix"></div>
        </div>

    </form>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> {{trans('cms_template/add-folder.cancel_btn')}}</button>
    <button class="btn btn-primary" ng-click="submit(createFolderForm.$invalid)"><i class="fa fa-plus"></i> {{trans('cms_template/add-folder.submit_btn')}}</button>

</div>
