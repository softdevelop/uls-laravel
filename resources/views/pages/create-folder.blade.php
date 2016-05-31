
<div class="modal-header">
    <h4 class="modal-title">{{trans('cms_page/page-create-folder.header_title')}}</h4>
</div>
<div class="modal-body">
<form role="form" name="createFolder_form" novalidate>
        <div class="alert alert-danger" ng-show="error">
            @{{error}}
        </div>

        <!-- Input Native Name-->
        <div class="form-group" ng-class="{true: 'has-error'}[submitted && createFolder_form.name.$invalid||nameExists]">
            <label for="">{{trans('cms_page/page-create-folder.folder_name')}}<span class="text-require"> *</span></label>
            <input type="text" class="form-control" name="name" placeholder="{{trans('cms_page/page-create-folder.folder_name')}}"
                   ng-model="folder.name"
                   ng-required="true" />
            <div class="show-error pull-left">
                <small class="help-inline" ng-show="submitted && createFolder_form.name.$error.required">{{trans('cms_page/page-create-folder.folder_name_required')}}</small>
            </div>
        </div>
        <div class="clearfix"></div>
</form>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" ng-click="submit(createFolder_form.$invalid)"><i class="fa fa-check"></i> Save</button>
    <button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> Cancel</button>
</div>
