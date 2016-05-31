
<div class="modal-header">
    <button  ng-click="cancel()" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title">Add Term</h4>
</div>

<div class="modal-body">
    <form class="form-horizontal" method="POST" accept-charset="UTF-8" name="formNewTerm" novalidate>

        <div class="m-b-15" ng-class="{'has-error':submitted && formData.name.$invalid}">
            <label class="label-form">Name:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input type="text" placeholder="Name" ng-required="true" name="name" data-ng-model="term.name" class="form-control" ng-change="changeName()">
                <small class="help-inline">@{{nameExists}}</small>
                <span class="help-inline" ng-show="submitted &&formNewTerm.name.$error.required">Term name is a required field</span>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="m-b-15" ng-class="{'has-error':submitted && formData.description.$invalid}">
            <label class="label-form">Description:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <textarea class="form-control" rows="5" placeholder="Description" type="text" name="description" id="description"  data-ng-model="term.description" ng-required="true">
                </textarea>
                <span class="help-inline" ng-show="submitted &&formNewTerm.description.$error.required">Description is a required field</span>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="m-b-15" ng-class="{'has-error':submitted && formData.help.$invalid}">
            <label class="label-form">Help:<span class="text-require"> *</span></label>
            <div class="wrap-form">
                <input type="text" placeholder="Help" ng-required="true" name="help" data-ng-model="term.help" class="form-control">
                <span class="help-inline" ng-show="submitted &&formNewTerm.help.$error.required">Help is a required field</span>
            </div>

            <div class="clearfix"></div>
        </div>

    </form>
</div>

<div class="modal-footer">
    <button id="bt-submit" class="btn btn-primary" ng-click="createNewTerm(formNewTerm.$invalid)"><i class="fa fa-check"></i> Add</button>
    <button ng-click="cancel()" class="btn-default btn"><i class="fa fa-times"></i> Close</button>
</div>
