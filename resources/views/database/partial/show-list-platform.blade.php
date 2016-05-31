<!-- <form name='formData'> -->
    <div class="modal-header">
        <h4>Platform</h4>
        <button ng-click="cancel()" type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <form name="formPlatform" ng-init="loadData()" novalidate>
        <div class="modal-body">
            <span class="">Platform<span class="text-require"> *</span>:</span>
            <div>
                <select name="platform" id="platfom" ng-model="guideConfig.platform" ng-required="true">
                    <option value="">Choose... </option>
                    <option value="@{{value.id}}" ng-repeat="(key, value) in listPlatForm">@{{value.name}}</option>
                </select>
                <small class="help-inline" ng-show="submitted && formPlatform.platform.$error.required">Platform is a required field.</small>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-default" ng-click="cancel()"> <i class="fa fa-times"></i> CANCEL</button>
            <button class="btn btn-default" ng-click="choosePlatform(formPlatform.$invalid, guideConfig.platform)"> <i class="fa fa-times"></i> DONE</button>
        </div>
    </form>
<!-- </form> -->