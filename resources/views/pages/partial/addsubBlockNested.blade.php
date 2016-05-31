
<div class="modal-header" ng-init="blocks={{json_encode($blocks)}}" >
    <h4 class="modal-title">{{trans('cms_page/page-nested-create.choose_sub_block')}}</h4>
</div>
<div class="modal-body">
<form role="form" name="sub_block_form" novalidate>
        <!-- Input Native Name-->
        <div class="form-group">
            <select-level items="blocks" text="Select Sub Block" text-filter="Filter page" ng-model="block._id" selected-item="selectedItem"></select-level>
            <small class="help-inline" ng-show="submitted && !block._id">{{trans('cms_page/page-nested-create.sub_block_required')}}.</small>  
        </div>
        <div class="clearfix"></div>
</form>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" ng-click="submit(block._id)"><i class="fa fa-check"></i> {{trans('cms_page/page-nested-create.save')}}</button>
    <button class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> {{trans('cms_page/page-nested-create.cancel')}}</button>
</div>