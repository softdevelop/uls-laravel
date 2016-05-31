
    <div class="div modal-header">
        <button aria-label="Close" ng-click="cancel()"  class="close" type="button"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Add</h4>
    </div>
    <div class="modal-body" >
        <form method="post" name="formData">
            <div class="form-group" ng-visible="true">
                <label class="col-lg-12">End Field: <span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <select class="form-control" ng-disabled="isDisibled" name="endfield" ng-required="true" ng-init="getListEndField()" ng-model="wrapper.endField" ng-options="key as value for (key,value) in listEndField">
                        <option disabled="true" value="">Select option</option>
                    </select>
                </div>
                <small class="help-inline" ng-show="submitted && formData.endfield.$error.required">End field is a required field.</small>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <label class="col-lg-12">Pre HTML:<span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <textarea ng-required="true" ng-model="wrapper.preWrapperHtml" name="preHtml" class="form-control" placeholder="Enter pre html"></textarea>
                </div>
                <small class="help-inline" ng-show="submitted && formData.preHtml.$error.required">Pre HTML is a required field.</small>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <label class="col-lg-12">Post HTML:<span class="text-require"> *</span></label>
                <div class="col-lg-12">
                    <textarea ng-required="true" ng-model="wrapper.postWrapperHtml" name="postHtml" class="form-control" placeholder="Enter post html"></textarea>
                </div>
                <small class="help-inline" ng-show="submitted && formData.postHtml.$error.required">Post HTML is a required field.</small>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn-primary btn" ng-click="addWrapper(formData.$invalid)" ><i class="fa fa-plus-square"></i> Add</button>
        <button class="btn-default btn" ng-click="cancel()" ><i class="fa fa-times"></i> Close</button>
    </div>
