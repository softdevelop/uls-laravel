<div id="myModal" class="modal-help" role="dialog">    
    <div class="modal-header">
       <button type="button" class="close" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <h4 class="modal-title">Create New Topic</h4>
    </div>

    <form role="form" name="formDataModel" novalidate ng-init="loadData()">
        <div class="modal-body">            
            <div class="form-group">
                <label class="label-form" for="name">
                    Page Type <span class="text-require"> *</span>
                </label>

                <div class="wrap-form">
                    <select ng-model="topic.parent_id" id="page-type-topic" ng-required='true' name="pageType">
                        <!-- <option value=""></option> -->
                        <option ng-repeat="(key, value) in listItemHelpEditor|orderBy:'title'" value="@{{value._id}}">@{{value.title}}</option>
                    </select>
                </div>
                <small class="help-inline" ng-show="submitted && formDataModel.pageType.$error.required">Page Type is a required field</small>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <label class="label-form" for="name">
                    Topic Name <span class="text-require"> *</span>
                </label>

                <div class="wrap-form">
                    <input type="text" ng-model="topic.title" name="title" id="title-topic" ng-required='true'>
                </div>
                <small class="help-inline" ng-show="submitted && formDataModel.title.$error.required">Topic Name is a required field</small>
                <div class="clearfix"></div>
            </div>

            <div class="form-group" ng-if="errors">
                <div class="wrap-form help-inline" ng-repeat="(key, value) in errors">
                    @{{value}}
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" ng-click="cancel()"><i class="fa fa-times"></i> Cancel</button>
            <button type="button" class="btn btn-primary" ng-click="addNewTopic(formDataModel.$invalid)"><i class="fa fa-check"></i> Save</button>
        </div>
    </form>
</div>