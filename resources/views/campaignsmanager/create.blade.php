<div class="modal-header">
    @if(!empty($campaign->id))
        <h3 class="modal-title">Edit @{{ type | capitalize}}</h3>
    @else
        <h3 class="modal-title">Add @{{type | capitalize}}</h3>
    @endif
</div>
<div class="modal-body">
<form role="form" name="createEditCampaignForm" ng-init="campaign={{$campaign}}" novalidate>

        <!-- Input Name-->
        <div class="full-width" ng-class="{true: 'error'}[submitted && (createEditCampaignForm.name.$invalid || nameExists)]">
            <label for="">Name<span class="text-require">(*)</span></label>
            <input type="text" class="form-control" name="name" placeholder="Name"
                   ng-model="campaign.name"
                   ng-minlength=3
                   ng-maxlength=50
                   ng-required="true" />
            <div class="pull-right">
                <small class="help-inline">@{{nameExists}}</small>
                <small class="help-inline" ng-show="submitted && createEditCampaignForm.name.$error.required">Name is required.</small>
                <small class="help-inline" ng-show="submitted && createEditCampaignForm.name.$error.minlength">Name is required to be at least 3 characters</small>
                <small class="help-inline" ng-show="submitted && createEditCampaignForm.name.$error.maxlength">Name cannot be longer than 50 characters</small>
            </div>
        </div>
        <div class="clearfix"></div>
   </form>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" ng-click="submit(createEditCampaignForm.$invalid)">Submit</button>
    <button class="btn btn-primary" ng-click="cancel()">Cancel</button>
</div>
