<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" ng-show="!category.id">{{trans('cms_database/add-category.modal_header')}}</h4>
    <h4 class="modal-title" ng-show="category.id">{{trans('cms_database/add-category.modal_header_edit')}}</h4>
</div>
<div><small class="help-inline"> @{{error}}</small></div>
<div class="modal-body">
    <form role="form" name="createFolderForm" novalidate ng-init ="parentFolders = {{json_encode($result)}}; selectedItem = {{json_encode($selectedItem)}}; type = {{json_encode($type)}}; category = {{json_encode($categoriesData)}};">
        <!-- Input Name-->
        <div class="form-group full-width" ng-class="{true: 'error'}[submitted && (createFolderForm.name.$invalid || nameExists)]">
          <div class="form-group" ng-show='!exists'>
            <label class="label-form" for="name">{{trans('cms_database/add-category.name_label')}}:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input type="text" class="form-control" name="name" placeholder="{{trans('cms_database/add-category.name_placeholder')}}" 
                   ng-model="category.name" 
                   ng-minlength=1 
                   ng-maxlength=50 
                   ng-required="true" />
                <div>
                    <small class="error" ng-show="submitted && nameExists">{{trans('cms_database/add-category.name_exists')}}</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.required">{{trans('cms_database/add-category.name_required')}}</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.minlength">{{trans('cms_database/add-category.folder_name_min')}}</small>
                    <small class="error" ng-show="submitted && createFolderForm.name.$error.maxlength">{{trans('cms_database/add-category.folder_name_max')}}</small>
                </div>                
                
            </div>
          </div>
            <div class="clearfix"></div>
            @if($type == 'materials')
           <div class="form-group">
            <label class="label-form" for="name">
                {{trans('cms_database/add-category.folder_parent_label')}}:<span class="text-require"> *</span>
            </label>
            <div class="wrap-form" >
                 <select-level items="parentFolders" show-icon="true" text="Choose Parent" text-filter="Filter folder" ng-model="category.parent_id" selected-item="selectedItem" ></select-level>
                <div>
                    <small class="error" ng-show="submitted && category.parent_id==null">{{trans('cms_database/add-category.folder_parent_required')}}</small>
                </div>   
            </div>
            <div class="clearfix"></div>
        </div>
        @endif
            <div class="clearfix"></div>
        @if($type == 'accessories')
           <div class="form-group">
            <label class="label-form" for="name">
                Description:
            </label>
            <div class="wrap-form" >
                <textarea class="form-control" rows="3" name="description" ng-model="category.description"></textarea> 
            </div>
            <div class="clearfix"></div>
        </div>
        @endif
            <div class="clearfix"></div>
        </div>
        
    </form>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> {{trans('cms_database/add-category.cancel_btn')}}</button>
    <button class="btn btn-primary" ng-click="submit(createFolderForm.$invalid)" ng-show="!category.id"><i class="fa fa-plus"></i> {{trans('cms_database/add-category.submit_btn')}}</button>
    <button class="btn btn-primary" ng-click="submit(createFolderForm.$invalid)" ng-show="category.id"> {{trans('cms_database/add-category.submit_btn_edit')}}</button>
</div>