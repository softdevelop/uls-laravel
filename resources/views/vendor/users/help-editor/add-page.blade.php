<div class="modal-header">
    <button type="button" class="close" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
        Add Page
    </h4>
</div>
<div class="modal-body" ng-init="help = {{json_encode($help)}}">
    <form role="form" name="formData" novalidate>
        <!-- Input Language-->
        <div class="form-group">
            <input type="text" class="form-control name" placeholder="Title" name="title" ng-model="help.title" ng-required = "true" />
            <div class="pull-left">
                <small class="help-inline" ng-show="submitted && formData.title.$error.required">Title is required field.</small>
                <small class="help-inline" ng-show="submitted && !formData.title.$error.required && errors.title != '' ">@{{errors.title[0]}}</small>
            </div>
        </div>
        <div class="clearfix"></div>
    </form>
</div>
<div class="modal-footer">
    <button class="btn btn-default" ng-disabled="saving" ng-click="cancel()"> <i class="fa fa-times"></i> Cancel</button>
    <button class="btn btn-primary" ng-disabled="saving" ng-click="addPage(formData.$invalid)">
        <i class="fa fa-plus"></i> Add
    </button>
</div>
