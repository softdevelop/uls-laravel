<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">{{trans('cms_page/page-move-page.move_page')}}</h4>
</div>
<div class="modal-body"  ng-init='parents = {{json_encode($parents)}}; selectedItem = {{json_encode($selectedItem)}}' >
    <form role="form" name="createFolderForm" novalidate>
        <div class="alert alert-danger" ng-show="error">
            @{{error}}
        </div>
        <div class="form-group">
            <div class="wrap-form">
                 <select-level items="parents" show-icon="true" text="choose Page Parent" text-filter="Filter folder" ng-model="parent._id" selected-item="selectedItem"></select-level>
            </div>
            <div class="clearfix"></div>
        </div>

    </form>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> {{trans('cms_page/page-move-page.cancel')}}</button>
    <button class="btn btn-primary" ng-click="submit(parent._id)"><i class="fa fa-plus"></i> {{trans('cms_page/page-move-page.add')}}</button>
</div>
